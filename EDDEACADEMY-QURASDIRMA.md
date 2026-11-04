# eddeacademy.az — WordPress-ə qoşulma təlimatı

Tema (`Edde Child`) artıq iki rejimdə işləyir. Rejim sorğunun domenindən avtomatik seçilir:

| Domen | Rejim | Nə göstərilir |
|---|---|---|
| `eddeglobal.az` | global | Əvvəlki kimi — heç nə dəyişməyib |
| `eddeacademy.az` | academy | Academy ana səhifəsi (`edde-academy-home.php`), Academy menyusu və altlığı, 11 kurs səhifəsi + Üstünlüklər, Niyə biz, FAQ, Əlaqə, Məxfilik |

`eddeacademy.az`-da Academy-yə aid olmayan ünvanlar (məs. `/xaricde-tehsil/`, `/meqaleler/`) avtomatik
`https://eddeglobal.az/<eyni-ünvan>/` ünvanına 301 ilə yönləndirilir.

## 1. Domeni hostinqə və WordPress-ə qoşmaq (siz edirsiniz)

1. **DNS:** domen qeydiyyatçısında `eddeacademy.az` üçün A qeydini (və `www` üçün CNAME/A) hostinqin IP-sinə yönəldin.
   `.az` domenlərində DNS dəyişikliyi bir neçə saat çəkə bilər.
2. **Hostinqdə domeni əlavə edin** (cPanel: *Domains → Addon/Alias Domain*). İki variant var:
   - **Eyni WordPress qurğusu (ən asan):** `eddeacademy.az`-ı **alias / parked domain** kimi eddeglobal.az-ın qovluğuna (məs. `public_html`) yönəldin.
     Tema host-a baxıb özü Academy rejiminə keçir və linkləri `eddeacademy.az` domeninə uyğunlaşdırır — başqa heç nə lazım deyil.
   - **Ayrıca WordPress:** domen üçün ayrı qovluq açıb təzə WordPress qurun, sonra bu temanı (və `edde` ana temasını) ora yükləyin və aktivləşdirin.
3. **SSL:** hostinqdə `eddeacademy.az` və `www.eddeacademy.az` üçün (Let's Encrypt/AutoSSL) sertifikat aktivləşdirin.
4. **`www` → `www`-suz** (və ya əksinə) yönləndirməni hostinqdə tək variantda saxlayın.

## 2. Temanı yeniləmək

Bu branch-dəki faylları (`claude/keen-babbage-bk8lac`) `wp-content/themes/edde-child/` qovluğuna yükləyin
(və ya GitHub-dan merge edib yerləşdirin). Yeni/dəyişən fayllar:

- `inc/edde-site.php` — rejim seçimi, Academy kurs siyahısı, brend məlumatları
- `edde-academy-home.php` — Academy ana səhifəsi
- `inc/edde-nav.php`, `parts/edde-header.php`, `parts/edde-footer.php`, `edde-page.php`, `functions.php` — Academy rejiminə uyğunlaşdırılıb

Yükləndikdən sonra **Parametrlər → Daimi keçidlər → Saxla** düyməsinə basın.

## 3. Yoxlama (DNS hələ hazır deyilsə)

`wp-config.php`-də müvəqqəti olaraq `define('EDDE_SITE_MODE', 'academy');` yazsanız bütün sayt Academy rejimində açılır.
Domen qoşulduqdan sonra bu sətri **silin** (yoxsa eddeglobal.az da Academy kimi görünər).

## 4. Məzmunu dəyişmək

| Nə | Harada |
|---|---|
| Kurs siyahısı, ikonlar, qısa təsvirlər (ana səhifə + menyu + altlıq) | `inc/edde-site.php` → `edde_academy_courses()` |
| Ana səhifə mətnləri (hero, üstünlüklər, rəqəmlər) | `edde-academy-home.php` |
| Hər kursun tam mətni | `inc/data/pages.php` (açar = ünvan, məs. `'ielts'`) |
| FAQ | `inc/data/faq.php` |
| Menyu | `inc/edde-nav.php` → `edde_academy_nav_items()` |
| Academy e-poçtu | `inc/edde-site.php` → `edde_brand()` (hazırda `info@eddeglobal.az`) |

## 5. Açıq qalan məsələlər

- **Academy üçün ayrıca e-poçt / sosial şəbəkə hesabları / telefon** varsa deyin — hazırda Global-ın məlumatları istifadə olunur.
- **Təkrar məzmun (SEO):** kurs səhifələri həm `eddeglobal.az`-da, həm `eddeacademy.az`-da var. Academy tərəfində `rel=canonical` qoyulub;
  Global tərəfdəki kurs ünvanlarını (`/ielts/` və s.) `eddeacademy.az`-a 301 ilə yönləndirmək tövsiyə olunur — razılıq versəniz əlavə edərəm.
- **Analitika:** Global-ın GTM/GA kodları (`footer.php`) yeni şablonlarda yoxdur; Academy üçün ayrıca GA/GTM ID verin, əlavə edim.
- **Loqo:** `assets/logo-footer.png` repoda yoxdur (Global altlığında da eyni istinad var). Yoxdursa, altlıqda loqo qırıq görünəcək — ağ versiyanı yükləyin.
- **Google Search Console:** `eddeacademy.az`-ı ayrıca əlavə edib sitemap göndərin.
