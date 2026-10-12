<?php
/**
 * Saytın vahid naviqasiyası. Bütün şablonlar (ana səhifə, Xidmətlər, IELTS və yeni məzmun səhifələri)
 * menyunu buradan oxuyur — yeni səhifə əlavə etmək üçün yalnız bu siyahını dəyişmək kifayətdir.
 *
 * '#...', 'tel:', 'mailto:', 'https://' ilə başlayan ünvanlar olduğu kimi qalır,
 * '/...' ilə başlayan ünvan isə sayt səhifəsinə aparır.
 */

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
            ['EDDE Global Missiyası',    '/missiya/'],
            ['EDDE Global Vizyonu',      '/edde-global-vizyonu/'],
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
        'url'   => '/xaricde-tehsil/',
        'mega'  => [
          'heading' => 'Xaricdə Təhsil',
          'text'    => 'Foundation-dan doktoranturaya qədər — hər mərhələ üçün uyğun proqram və tam dəstək.',
          'cta'     => 'Bütün proqramlara baxın',
          'visual'  => ['🌍', '18+', 'Tərəfdaş ölkə'],
          'links'   => [
            ['Foundation Təhsili',          '/foundation/'],
            ['Bakalavr',                    '/bakalavr/'],
            ['Magistratura Təhsili',        '/magistratura/'],
            ['Doktorantura Təhsili',        '/doktorantura/'],
            ['Türkiyədə təhsil',            '/turkiyede-tehsil/'],
            ['Transfer Proqramları',        '/transfer/'],
            ['Təqaüd Proqramları',          '/teqaud/'],
            ['Yay Məktəbləri',              '/yay-mektebleri/'],
            ['Beynəlxalq Məktəblər',        '/beynelxalq-mektebler/'],
            ['Xaricdə Yataqxana',           '/yataqxana/'],
            ['İxtisas Seçimi Dəstəyi',      '/ixtisas-secimi/'],
            ['İxtisas seçimi testi',        '/ixtisas-secimi-testi/'],
            ['Ölkələr və universitetlər',   '/olkeler/'],
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
          'visual'  => ['📖', '13', 'Kurs və imtahan hazırlığı'],
          'links'   => [
            ['SAT',                            '/sat/'],
            ['General ENGLISH Kursları',       '/general-english/'],
            ['IELTS',                          '/ielts/'],
            ['TOEFL',                          '/toefl/'],
            ['Duolingo English Test',          '/duolingo/'],
            ['KIDS ENGLISH',                   '/kids-english/'],
            ['Alman Dili Kursları',            '/alman-dili-kurslari/'],
            ['PTE ACADEMIC',                   '/pte-academic/'],
            ['ELLT Hazırlıq Kursları',         '/ellt-kursu/'],
            ['LanguageCert Hazırlıq Kursları', '/languagecert-kursu/'],
            ['Türk Dili Kursları',             '/turk-dili-kurslari/'],
            ['Xüsusi Üstünlüklər',             '/ustunlukler/'],
            ['Niyə biz?',                      '/niye-biz/'],
          ],
        ],
      ],
      ['title' => 'EDDE Corporate', 'url' => '/korporativ/'],
      ['title' => 'EDDE Event',     'url' => '/tedbirler/'],
      [
        'title' => 'Yazılar',
        'url'   => '/meqaleler/',
        'mega'  => [
          'heading' => 'Yazılar',
          'text'    => 'Xaricdə təhsil, viza və təqaüd mövzularında məqalələr və mediada çıxışlarımız.',
          'cta'     => 'Məqalələrə baxın',
          'visual'  => ['📰', '14', 'Məqalə və xəbər'],
          'links'   => [
            ['Məqalələr',   '/meqaleler/'],
            ['Mediada biz', '/mediada-biz/'],
          ],
        ],
      ],
      ['title' => 'FAQ', 'url' => '/faq/'],
      [
        'title' => 'Əlaqə',
        'url'   => '/elaqe/',
        'mega'  => [
          'heading' => 'Bizimlə əlaqə',
          'text'    => 'Suallarınız var? Məsləhətçilərimiz sizinlə əlaqə saxlamağa hazırdır.',
          'cta'     => 'WhatsApp-da yazın',
          'cta_url' => 'https://wa.me/994702141033',
          'label'   => 'Əlaqə məlumatları',
          'visual'  => ['📍', 'Bakı', 'Baş ofis'],
          'links'   => [
            ['070 214 10 33',                        'tel:+994702141033'],
            ['012 409 67 89',                        'tel:+994124096789'],
            ['info@eddeglobal.az',                   'mailto:info@eddeglobal.az'],
            ['Əliyar Əliyev 159, N.Nərimanov, Bakı', '/elaqe/'],
          ],
        ],
      ],
    ];
  }
}
