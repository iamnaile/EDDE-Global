<?php
/**
 * Saytın vahid naviqasiyası. Bütün şablonlar (ana səhifə, Xidmətlər, IELTS və yeni məzmun səhifələri)
 * menyunu buradan oxuyur — yeni səhifə əlavə etmək üçün yalnız bu siyahını dəyişmək kifayətdir.
 *
 * '#...', 'tel:', 'mailto:', 'https://' ilə başlayan ünvanlar olduğu kimi qalır,
 * '/...' ilə başlayan ünvan isə sayt səhifəsinə aparır.
 */

require_once __DIR__ . '/edde-contact.php';

if (!function_exists('edde_href')) {
  function edde_href($u) {
    return preg_match('~^(#|tel:|mailto:|https?://)~', $u) ? esc_url($u) : esc_url(home_url($u));
  }
}

if (!function_exists('edde_nav_items')) {
  function edde_nav_items() {
    return [
      [
        'title' => 'Haqqımızda',
        'url'   => '/shirket-haqqinda/',
        'mega'  => [
          'heading' => 'Haqqımızda',
          'text'    => 'EDDE Global — 2018-ci ildən xaricdə təhsil və dil təhsili sahəsində etibarlı tərəfdaşınız.',
          'cta'     => 'Şirkət haqqında',
          'visual'  => ['🏛️', '2018', 'Fəaliyyətə başladıq'],
          'links'   => [
            ['Şirkət haqqında',          '/shirket-haqqinda/'],
            ['Tərəfdaşlarımız',          '/terefdaslarimiz/'],
            ['Xidmətlər paketi',         '/xidmetler-paketi/'],
            ['Akkreditasiyalarımız',     '/akkreditasiya/'],
            ['Hüquqi Məsuliyyətlər',     '/qanunvericilik/'],
            ['Beynəlxalq Əməkdaşlıqlar', '/uzvlukler/'],
            ['Karyera',                  '/karyera/'],
          ],
        ],
      ],
      [
        'title' => 'Xaricdə təhsil',
        'url'   => '/#programs',
        'mega'  => [
          'heading' => 'Xaricdə Təhsil',
          'text'    => 'Foundation-dan doktoranturaya qədər — hər mərhələ üçün uyğun proqram və tam dəstək.',
          'cta'     => 'Bütün proqramlara baxın',
          'visual'  => ['🌍', '20+', 'Təhsil ölkəsi'],
          'links'   => [
            ['Foundation Təhsili',          '/foundation/'],
            ['Bakalavr',                    '/bakalavr/'],
            ['Magistratura Təhsili',        '/magistratura/'],
            ['Doktorantura Təhsili',        '/doktorantura/'],
            ['Transfer Proqramları',        '/transfer/'],
            ['Təqaüd Proqramları',          '/teqaud/'],
            ['Ölkələr və universitetlər',   '/olkeler/'],
            ['Yay Məktəbləri',              '/yay-mektebleri/'],
            ['Beynəlxalq Məktəblər',        '/beynelxalq-mektebler/'],
            ['Xaricdə Yataqxana',           '/yataqxana/'],
            ['İxtisas Seçimi Dəstəyi',      '/ixtisas-secimi/'],
          ],
        ],
      ],
      [
        'title' => 'EDDE Academy',
        'url'   => '/edde-xidmetler/',
        'mega'  => [
          'heading' => 'EDDE Academy',
          'text'    => 'Beynəlxalq imtahanlara hazırlıq və dil kursları ilə hədəflərinizə çatın.',
          'cta'     => 'Bütün proqramlara baxın',
          'visual'  => ['📖', '11', 'Kurs və imtahan hazırlığı'],
          'links'   => [
            ['Dil Kursları',               '/dil-kurslari/'],
            ['İmtahana Hazırlıq kursları', '/imtahana-hazirlik-kurslari/'],
            ['KIDS ENGLISH',               '/kids-english/'],
            ['Xüsusi Üstünlüklər',         '/ustunlukler/'],
            ['Niyə biz?',                  '/niye-biz/'],
          ],
        ],
      ],
      ['title' => 'EDDE Corporate', 'url' => '/korporativ/'],
      ['title' => 'İxtisas seçimi testi', 'url' => edde_contact()['test_url']],
      [
        'title' => 'Yazılar',
        'url'   => '/meqaleler/',
        'mega'  => [
          'heading' => 'Yazılar',
          'text'    => 'Xaricdə təhsil, viza və təqaüd mövzularında məqalələr və mediada çıxışlarımız.',
          'cta'     => 'Məqalələrə baxın',
          'visual'  => ['📰', 'Yeni', 'Məqalələr və xəbərlər'],
          'links'   => [
            ['Məqalələr',   '/meqaleler/'],
            ['Mediada biz', '/mediada-biz/'],
          ],
        ],
      ],
      ['title' => 'FAQ', 'url' => '/faq/'],
      [
        'title' => 'Əlaqə',
        'url'   => '/#contact',
        'mega'  => edde_nav_contact(),
      ],
    ];
  }
}

if (!function_exists('edde_nav_contact')) {
  function edde_nav_contact() {
    $c = edde_contact();
    $links = [];
    foreach ($c['phones'] as $p) { $links[] = [$p[0], 'tel:' . $p[1]]; }
    $links[] = [$c['email'], 'mailto:' . $c['email']];
    $links[] = [$c['address'], '#map'];
    return [
      'heading' => 'Bizimlə əlaqə',
      'text'    => 'Suallarınız var? Məsləhətçilərimiz sizinlə əlaqə saxlamağa hazırdır.',
      'cta'     => 'WhatsApp-da yazın',
      'cta_url' => edde_wa_url(),
      'label'   => 'Əlaqə məlumatları',
      'visual'  => ['📍', 'Bakı', 'Baş ofis'],
      'map'     => true, // "Bakı / Baş ofis" qutusuna basanda xəritə açılır
      'links'   => $links,
    ];
  }
}
