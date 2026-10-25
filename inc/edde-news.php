<?php
/**
 * Yazılar (xəbər/məqalə) bölməsi üçün WordPress hissəsi:
 *  - "Məqalələr (EDDE)" bölməsi (admin menyusu) — yazıları əl ilə əlavə/redaktə etmək üçün;
 *  - Alətlər → "Word-dən məqalə import" — çoxlu .docx faylını bir dəfəyə yükləmək üçün.
 * Saytda göstərilmə: inc/edde-content.php-dəki edde_news_all() və parts/edde-news-*.php.
 */

require_once __DIR__ . '/edde-docx.php';

add_action('init', function () {
    register_post_type('edde_news', [
        'labels' => [
            'name' => 'Məqalələr (EDDE)', 'singular_name' => 'Məqalə', 'menu_name' => 'Məqalələr (EDDE)',
            'add_new' => 'Yeni məqalə', 'add_new_item' => 'Yeni məqalə əlavə et', 'edit_item' => 'Məqaləni redaktə et',
            'all_items' => 'Bütün məqalələr', 'search_items' => 'Məqalə axtar', 'not_found' => 'Məqalə yoxdur',
        ],
        'public' => false, 'show_ui' => true, 'show_in_menu' => true, 'menu_icon' => 'dashicons-media-document', 'menu_position' => 27,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'], 'show_in_rest' => false,
    ]);
});

/* Tip (Məqalə / Mediada biz) və mənbə keçidi */
add_action('add_meta_boxes', function () {
    add_meta_box('edde_news_meta', 'Yazının tipi', function ($post) {
        $type = get_post_meta($post->ID, '_edde_type', true) === 'media' ? 'media' : 'meqale';
        $src  = get_post_meta($post->ID, '_edde_source', true);
        wp_nonce_field('edde_news_meta', 'edde_news_nonce');
        echo '<p><label><strong>Bölmə</strong><br><select name="edde_type"><option value="meqale"' . selected($type, 'meqale', false) . '>Məqalə</option><option value="media"' . selected($type, 'media', false) . '>Mediada biz</option></select></label></p>';
        $lang = get_post_meta($post->ID, '_edde_lang', true) === 'en' ? 'en' : 'az';
        echo '<p><label><strong>Yazının dili</strong><br><select name="edde_lang"><option value="az"' . selected($lang, 'az', false) . '>Azərbaycan</option><option value="en"' . selected($lang, 'en', false) . '>İngilis (yalnız /en/ saytında görünür)</option></select></label></p>';
        echo '<p><label><strong>Mənbə keçidi</strong> (yalnız "Mediada biz" üçün)<br><input type="url" name="edde_source" value="' . esc_attr($src) . '" style="width:100%" placeholder="https://..."></label></p>';
    }, 'edde_news', 'side');
});
add_action('save_post_edde_news', function ($id) {
    if (!isset($_POST['edde_news_nonce']) || !wp_verify_nonce($_POST['edde_news_nonce'], 'edde_news_meta') || !current_user_can('edit_post', $id)) { return; }
    update_post_meta($id, '_edde_type', (isset($_POST['edde_type']) && $_POST['edde_type'] === 'media') ? 'media' : 'meqale');
    update_post_meta($id, '_edde_lang', (isset($_POST['edde_lang']) && $_POST['edde_lang'] === 'en') ? 'en' : 'az');
    update_post_meta($id, '_edde_source', isset($_POST['edde_source']) ? esc_url_raw(wp_unslash($_POST['edde_source'])) : '');
});

/* İngilis versiyası: Azərbaycanca məqaləyə bağlanan tərcümə (başlıq, xülasə, mətn) */
add_action('add_meta_boxes', function () {
    add_meta_box('edde_news_en', 'İngilis versiyası (EN saytı üçün)', function ($post) {
        $t = get_post_meta($post->ID, '_edde_en_title', true);
        $x = get_post_meta($post->ID, '_edde_en_excerpt', true);
        $c = get_post_meta($post->ID, '_edde_en_content', true);
        wp_nonce_field('edde_news_en', 'edde_news_en_nonce');
        echo '<p class="description">Burada məqalənin ingilis tərcüməsini yazın. Doldurulubsa, məqalə saytın ingilis versiyasında (EN) bu mətnlə görünür; boşdursa, EN saytda göstərilmir. Şəkil Azərbaycan versiyası ilə eynidir.</p>';
        echo '<p><label><strong>English title</strong><br><input type="text" name="edde_en_title" value="' . esc_attr($t) . '" style="width:100%"></label></p>';
        echo '<p><label><strong>English excerpt</strong><br><textarea name="edde_en_excerpt" rows="3" style="width:100%">' . esc_textarea($x) . '</textarea></label></p>';
        echo '<p><strong>English content</strong></p>';
        wp_editor($c, 'edde_en_content', ['textarea_name' => 'edde_en_content', 'textarea_rows' => 14, 'media_buttons' => false]);
    }, 'edde_news', 'normal', 'default');
});
add_action('save_post_edde_news', function ($id) {
    if (!isset($_POST['edde_news_en_nonce']) || !wp_verify_nonce($_POST['edde_news_en_nonce'], 'edde_news_en') || !current_user_can('edit_post', $id)) { return; }
    update_post_meta($id, '_edde_en_title', isset($_POST['edde_en_title']) ? sanitize_text_field(wp_unslash($_POST['edde_en_title'])) : '');
    update_post_meta($id, '_edde_en_excerpt', isset($_POST['edde_en_excerpt']) ? sanitize_textarea_field(wp_unslash($_POST['edde_en_excerpt'])) : '');
    update_post_meta($id, '_edde_en_content', isset($_POST['edde_en_content']) ? wp_kses_post(wp_unslash($_POST['edde_en_content'])) : '');
});

/* ------------------------------ Word import ------------------------------ */
add_action('admin_menu', function () {
    add_management_page('Word-dən məqalə import', 'Word-dən məqalə import', 'manage_options', 'edde-import', 'edde_import_page');
});

function edde_import_page() {
    $nonce = wp_create_nonce('edde_import');
    $list  = admin_url('edit.php?post_type=edde_news');
    ?>
    <div class="wrap">
      <h1>Word-dən məqalə import</h1>
      <p>Bir neçə <strong>.docx</strong> faylı seçin (Ctrl+A ilə qovluqdakı hamısını seçə bilərsiniz). Hər fayl ayrıca məqalə olur: <em>başlıq</em> sənədin ilk sətri, qalan mətn, başlıqlar, siyahılar, cədvəllər və şəkillər qorunur. Sənədin ilk şəkli məqalənin üz qabığı olur.</p>
      <table class="form-table" role="presentation">
        <tr><th>Nə yükləyirsiniz?</th><td><select id="edMode">
            <option value="new">Yeni məqalələr</option>
            <option value="en">Mövcud məqalələrin İNGİLİS tərcümələri</option></select>
          <p class="description" id="edModeHelp" style="display:none">Hər ingilis faylın adı Azərbaycanca faylın adı ilə eyni olmalıdır, sonuna istəyə görə <strong>EN</strong> əlavə edilə bilər. Məsələn: <code>Viza məsləhətləri.docx</code> ↔ <code>Viza məsləhətləri EN.docx</code> (və ya <code>-en</code>, <code>_en</code>, <code>(English)</code>). Tərcümə həmin məqaləyə bağlanır və EN saytda görünür. Cütü tapılmayan fayl ayrıca İngilis məqalə kimi əlavə olunur.</p></td></tr>
        <tr class="ed-new"><th>Bölmə</th><td><select id="edType"><option value="meqale">Məqalələr</option><option value="media">Mediada biz</option></select></td></tr>
        <tr class="ed-new"><th>Fayllar hansı dildədir?</th><td><select id="edLang"><option value="auto">Avtomatik təyin et (hər fayl üçün ayrıca)</option><option value="az">Hamısı Azərbaycanca</option><option value="en">Hamısı İngiliscə</option></select>
          <p class="description">İngilis dilindəki məqalələr yalnız saytın ingilis versiyasında (EN), Azərbaycanca olanlar isə yalnız AZ versiyasında göstərilir.</p></td></tr>
        <tr><th>Seçimlər</th><td>
          <label><input type="checkbox" id="edDraft"> Dərhal dərc etmə, <strong>qaralama</strong> kimi saxla (əvvəlcə yoxlamaq üçün)</label><br>
          <label><input type="checkbox" id="edToday"> Sənədin tarixini yox, <strong>bugünkü tarixi</strong> yaz</label>
        </td></tr>
        <tr><th>Fayllar</th><td><input type="file" id="edFiles" accept=".docx" multiple></td></tr>
      </table>
      <p><button class="button button-primary button-large" id="edGo">İmport et</button> <span id="edCount"></span></p>
      <ol id="edLog" style="max-width:900px"></ol>
      <p id="edDone" style="display:none"><a class="button" href="<?php echo esc_url($list); ?>">Məqalələrin siyahısına bax</a></p>
    </div>
    <script>
    (function () {
      var go = document.getElementById('edGo'), files = document.getElementById('edFiles'), log = document.getElementById('edLog'), cnt = document.getElementById('edCount');
      var modeSel = document.getElementById('edMode');
      modeSel.addEventListener('change', function () {
        var en = modeSel.value === 'en';
        document.getElementById('edModeHelp').style.display = en ? 'block' : 'none';
        document.querySelectorAll('.ed-new').forEach(function (r) { r.style.display = en ? 'none' : ''; });
      });
      go.addEventListener('click', async function () {
        if (!files.files.length) { alert('Əvvəlcə .docx faylları seçin.'); return; }
        go.disabled = true; log.innerHTML = '';
        var ok = 0, skip = 0, fail = 0, total = files.files.length;
        for (var i = 0; i < total; i++) {
          var f = files.files[i], li = document.createElement('li');
          li.textContent = f.name + ' — göndərilir…'; log.appendChild(li); cnt.textContent = (i + 1) + ' / ' + total;
          var fd = new FormData();
          fd.append('action', 'edde_import_docx'); fd.append('nonce', '<?php echo esc_js($nonce); ?>');
          fd.append('type', document.getElementById('edType').value);
          fd.append('lang', document.getElementById('edLang').value);
          fd.append('mode', document.getElementById('edMode').value);
          if (document.getElementById('edDraft').checked) fd.append('draft', '1');
          if (document.getElementById('edToday').checked) fd.append('today', '1');
          fd.append('file', f);
          try {
            var r = await fetch(ajaxurl, { method: 'POST', body: fd, credentials: 'same-origin' });
            var j = await r.json();
            if (j.success && j.data.status === 'paired') { ok++; li.innerHTML = '🔗 <strong>' + j.data.title + '</strong> → ingilis versiya bağlandı: <em>' + j.data.en_title + '</em>'; }
            else if (j.success && j.data.status === 'created') { ok++; li.innerHTML = '✅ <strong>' + j.data.title + '</strong>' + (j.data.images ? ' (' + j.data.images + ' şəkil)' : ''); }
            else if (j.success) { skip++; li.innerHTML = '⏭️ ' + f.name + ' — artıq var, keçildi: <em>' + j.data.title + '</em>'; }
            else { fail++; li.innerHTML = '❌ ' + f.name + ' — ' + (j.data && j.data.message ? j.data.message : 'xəta'); }
          } catch (e) { fail++; li.innerHTML = '❌ ' + f.name + ' — şəbəkə/server xətası'; }
        }
        cnt.textContent = 'Hazırdır: ' + ok + ' əlavə olundu, ' + skip + ' keçildi, ' + fail + ' xəta.';
        document.getElementById('edDone').style.display = 'block'; go.disabled = false;
      });
    })();
    </script>
    <?php
}

add_action('wp_ajax_edde_import_docx', function () {
    check_ajax_referer('edde_import', 'nonce');
    if (!current_user_can('manage_options')) { wp_send_json_error(['message' => 'İcazə yoxdur.'], 403); }
    if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error(['message' => 'Fayl yüklənmədi (ölçü limiti ola bilər).']);
    }
    $rawName = (string) $_FILES['file']['name']; // cütləşdirmə açarı üçün orijinal ad (Azərbaycan hərfləri ilə)
    $name = sanitize_file_name($rawName);
    if (strtolower(pathinfo($name, PATHINFO_EXTENSION)) !== 'docx') { wp_send_json_error(['message' => 'Yalnız .docx qəbul olunur.']); }
    $tmp = $_FILES['file']['tmp_name'];
    @set_time_limit(120);

    try {
        // 0) İngilis tərcümə rejimi: mövcud Azərbaycan məqaləsinə bağla
        if (isset($_POST['mode']) && $_POST['mode'] === 'en') {
            $en  = edde_docx_parse($tmp, null);
            $key = edde_docx_key($rawName, true);
            $hit = get_posts(['post_type' => 'edde_news', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids',
                              'meta_query' => [['key' => '_edde_file', 'value' => $key]]]);
            if ($hit) {
                $pid = (int) $hit[0];
                $enTitle = $en['title'] !== '' ? $en['title'] : trim(preg_replace('~[\s_\-]+~u', ' ', pathinfo($name, PATHINFO_FILENAME)));
                update_post_meta($pid, '_edde_en_title', $enTitle);
                update_post_meta($pid, '_edde_en_excerpt', $en['excerpt']);
                update_post_meta($pid, '_edde_en_content', wp_kses_post($en['html']));
                wp_send_json_success(['status' => 'paired', 'title' => get_the_title($pid), 'en_title' => $enTitle]);
            }
            // cüt tapılmadı: ayrıca İngilis məqalə kimi əlavə olunacaq
            $_POST['lang'] = 'en';
        }

        // 1) şəkilsiz ilkin oxuma: başlıq və təkrar yoxlaması
        $probe = edde_docx_parse($tmp, null);
        $title = $probe['title'] !== '' ? $probe['title'] : trim(preg_replace('~[\s_\-]+~u', ' ', pathinfo($name, PATHINFO_FILENAME)));
        $dup = get_posts(['post_type' => 'edde_news', 'post_status' => 'any', 'title' => $title, 'numberposts' => 1, 'fields' => 'ids']);
        if ($dup) { wp_send_json_success(['status' => 'skipped', 'title' => $title]); }

        // 2) şəkillərlə tam oxuma
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attach = [];
        $save = function ($fname, $bytes) use (&$attach) {
            $up = wp_upload_bits('edde-' . wp_generate_password(6, false) . '-' . sanitize_file_name($fname), null, $bytes);
            if (!empty($up['error'])) { return false; }
            $ft = wp_check_filetype($up['file']);
            if (empty($ft['type']) || strpos($ft['type'], 'image/') !== 0) { @unlink($up['file']); return false; }
            $aid = wp_insert_attachment(['post_mime_type' => $ft['type'], 'post_title' => preg_replace('~\.[^.]+$~', '', basename($up['file'])), 'post_status' => 'inherit', 'guid' => $up['url']], $up['file']);
            if (is_wp_error($aid) || !$aid) { return false; }
            wp_update_attachment_metadata($aid, wp_generate_attachment_metadata($aid, $up['file']));
            $attach[] = $aid;
            return $up['url'];
        };
        $doc = edde_docx_parse($tmp, $save);
        // ilk şəkil üz qabığı (featured image) olur — məzmunun əvvəlində təkrar göstərilməsin
        if (!empty($doc['images'])) {
            $doc['html'] = preg_replace('~^\s*<figure><img src="' . preg_quote(htmlspecialchars($doc['images'][0], ENT_QUOTES, 'UTF-8'), '~') . '" alt=""></figure>\s*~', '', $doc['html'], 1);
        }

        $today = !empty($_POST['today']);
        $date  = (!$today && $doc['date'] !== '') ? get_date_from_gmt($doc['date']) : current_time('mysql');
        $slug  = sanitize_title(mb_substr(edde_docx_translit(mb_strtolower($title, 'UTF-8')), 0, 90));
        $id = wp_insert_post([
            'post_type' => 'edde_news', 'post_status' => !empty($_POST['draft']) ? 'draft' : 'publish',
            'post_title' => $title, 'post_name' => $slug, 'post_content' => $doc['html'], 'post_excerpt' => $doc['excerpt'],
            'post_date' => $date, 'post_date_gmt' => get_gmt_from_date($date),
        ], true);
        if (is_wp_error($id)) { wp_send_json_error(['message' => $id->get_error_message()]); }
        $want = isset($_POST['lang']) ? $_POST['lang'] : 'auto';
        $lang = in_array($want, ['az', 'en'], true) ? $want : edde_docx_detect_lang($title . ' ' . $doc['html']);
        update_post_meta($id, '_edde_lang', $lang);
        update_post_meta($id, '_edde_file', edde_docx_key($rawName, false));
        update_post_meta($id, '_edde_type', (isset($_POST['type']) && $_POST['type'] === 'media') ? 'media' : 'meqale');
        foreach ($attach as $i => $aid) {
            wp_update_post(['ID' => $aid, 'post_parent' => $id]);
            if ($i === 0) { set_post_thumbnail($id, $aid); }
        }
        wp_send_json_success(['status' => 'created', 'title' => $title, 'id' => $id, 'images' => count($attach), 'lang' => $lang]);
    } catch (Throwable $e) {
        wp_send_json_error(['message' => $e->getMessage()]);
    }
});
