<?php
/**
 * Sayt formalarından gələn müraciətlər.
 *
 * Bütün formalar (Zəng istə, hero modalları, məzmun səhifələrindəki forma, IELTS forması) assets/edde-script.js-dəki
 * eddeSendLead() ilə admin-ajax.php?action=edde_lead ünvanına göndərilir. Müraciət:
 *   1) WordPress admin-də "Müraciətlər" bölməsində saxlanılır (e-poçt işləməsə də itmir);
 *   2) info@eddeglobal.az ünvanına e-poçtla göndərilir (wp_mail — WP Mail SMTP ilə işləyir).
 */

add_action('init', function () {
    register_post_type('edde_lead', [
        'labels' => [
            'name'          => 'Müraciətlər',
            'singular_name' => 'Müraciət',
            'menu_name'     => 'Müraciətlər',
            'all_items'     => 'Bütün müraciətlər',
            'edit_item'     => 'Müraciətə bax',
            'search_items'  => 'Müraciət axtar',
            'not_found'     => 'Müraciət yoxdur',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-email-alt',
        'menu_position' => 26,
        'supports'     => ['title', 'editor'],
        'capability_type' => 'post',
        'capabilities' => ['create_posts' => 'do_not_allow'],
        'map_meta_cap' => true,
    ]);
});

if (!function_exists('edde_handle_lead')) {
    function edde_handle_lead() {
        $get = function ($k, $max = 300) {
            $v = isset($_POST[$k]) ? sanitize_textarea_field(wp_unslash($_POST[$k])) : '';
            return mb_substr($v, 0, $max);
        };

        // Bot tələsi: gizli "website" sahəsi doldurulubsa, sakitcə "uğurlu" cavab ver
        if ($get('website') !== '') {
            wp_send_json_success(['saved' => true]);
        }

        $name    = $get('name', 120);
        $phone   = $get('phone', 40);
        $email   = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        $details = $get('details', 1500);
        $message = $get('message', 2000);
        $course  = $get('course', 160);
        $source  = $get('source', 200);

        if ($name === '' || ($phone === '' && $email === '')) {
            wp_send_json_error(['message' => 'Ad və telefon (və ya e-poçt) mütləqdir.'], 400);
        }

        // Eyni IP-dən sürətli təkrar göndərmənin qarşısı (10 dəqiqədə 6 müraciət)
        $ip  = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $key = 'edde_lead_' . md5($ip);
        $n   = (int) get_transient($key);
        if ($n >= 6) {
            wp_send_json_error(['message' => 'Çox sayda müraciət göndərilib, bir az sonra yenidən cəhd edin.'], 429);
        }
        set_transient($key, $n + 1, 10 * MINUTE_IN_SECONDS);

        $label = $course !== '' ? $course : ($source !== '' ? $source : 'Sayt müraciəti');
        $lines = [
            'Ad: ' . $name,
            'Telefon: ' . $phone,
            'E-poçt: ' . $email,
            'Mövzu / proqram: ' . $label,
        ];
        if ($details !== '') { $lines[] = $details; }
        if ($message !== '') { $lines[] = 'Mesaj: ' . $message; }
        if ($source !== '')  { $lines[] = 'Mənbə: ' . $source; }
        $body = implode("\n", $lines);

        $id = wp_insert_post([
            'post_type'    => 'edde_lead',
            'post_status'  => 'private',
            'post_title'   => $name . ' — ' . $label,
            'post_content' => $body,
        ]);

        $c       = edde_contact();
        $to      = apply_filters('edde_lead_recipient', $c['email']);
        $headers = ['Content-Type: text/plain; charset=UTF-8'];
        if ($email !== '') { $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>'; }
        $mailed = wp_mail($to, 'EDDE sayt müraciəti: ' . $label, $body, $headers);

        if (!$id && !$mailed) {
            wp_send_json_error(['message' => 'Müraciət göndərilmədi.'], 500);
        }
        wp_send_json_success(['saved' => (bool) $id, 'mailed' => (bool) $mailed]);
    }
}
add_action('wp_ajax_edde_lead', 'edde_handle_lead');
add_action('wp_ajax_nopriv_edde_lead', 'edde_handle_lead');
