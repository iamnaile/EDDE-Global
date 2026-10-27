# dp / test / konsultasiya — eddeglobal.az dizaynına uyğunlaşdırma

Üç alt-sayt statik HTML-dir (WordPress deyil), ona görə dəyişiklik **bir ortaq CSS qatı** ilə edilib:

- `edde-brand.css` — əsas saytın token-ləri (`#7817B6` bənövşəyi, `#F7F0FC` fon, Manrope + Inter, pill düymələr, açıq header/footer). Məzmuna, JS-ə, forma/SRI/honeypot/Clarity-yə toxunmur.
- `apply_brand.py` — CSS-i HTML-lərə yeridir və IBM Plex şrift link-ini Manrope+Inter ilə əvəz edir. Təkrar işlədəndə köhnə versiyanı əvəz edir.
  `python3 apply_brand.py <giriş_qovluğu> <çıxış_qovluğu>`
- `dist/` — hazır nəticə (yoxlama üçün): `dp/` (AZ, `en/`, `ru/`), `test/` (index, en, ru), `konsultasiya/` (AZ, `en/`, `tesdiq/`).

## Öz pipeline-ınıza (edde-ops) tətbiq
Ən təmiz yol: `edde-brand.css` məzmununu şablonun `<head>`-ində, mövcud `<style>` bloklarından **sonra** yerləşdirin və IBM Plex link-ini
`https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap` ilə əvəz edin.

## Qeydlər
- `test/index.html` mənbəsində `</head>` yerinə `head>` yazılıb (səhifənin yuxarısında "head>" mətni görünür). Skript bunu düzəldir; mənbəni də düzəldin.
- PDF/çap rejimi öz rəngləri ilə qalıb (dəyişdirilməyib).
- Kosmos/uşaq ornamentləri (ulduz, planet, raket) gizlədilib; geri qaytarmaq üçün CSS-dəki 2-ci bölmədəki `display:none` sətrini silin.
