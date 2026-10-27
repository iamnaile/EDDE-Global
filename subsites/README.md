# dp / test / konsultasiya — eddeglobal.az dizaynına uyğunlaşdırma

Üç alt-sayt statik HTML-dir (WordPress deyil), ona görə dəyişiklik **bir ortaq CSS qatı** ilə edilib:

- `edde-brand.css` — əsas saytın token-ləri (`#7817B6` bənövşəyi, `#F7F0FC` fon, Manrope + Inter, pill düymələr, açıq header/footer). Məzmuna, JS-ə, forma/SRI/honeypot/Clarity-yə toxunmur.
- `edde-footer.css` + `edde_footer.py` + `edde-logo.png` — eddeglobal.az-ın altlığı (`parts/edde-footer.php`) birebir: 4 sütun, `--bg-alt` fon, sosial linklər, ICEF nişanı, məxfilik, üzən WhatsApp düyməsi. Linklər `https://eddeglobal.az/...`-a mütləq ünvanla gedir. AZ/EN/RU variantı səhifənin `<html lang>`-inə görə seçilir.
- `apply_brand.py` — CSS-i yeridir, şrift link-ini Manrope+Inter ilə əvəz edir, köhnə `<footer class="site-foot">`-u əsas sayt altlığı ilə əvəz edir. Təkrar işlədəndə köhnə versiyanı əvəz edir (idempotent).
  `python3 apply_brand.py <giriş_qovluğu> <çıxış_qovluğu>`
- `dist/` — hazır nəticə (yoxlama üçün): `dp/` (AZ, `en/`, `ru/`), `test/` (index, en, ru), `konsultasiya/` (AZ, `en/`, `tesdiq/`).

## Öz pipeline-ınıza (edde-ops) tətbiq
Ən təmiz yol: `edde-brand.css` məzmununu şablonun `<head>`-ində, mövcud `<style>` bloklarından **sonra** yerləşdirin və IBM Plex link-ini
`https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap` ilə əvəz edin.

## Qeydlər
- Altlıq mənbəyi `parts/edde-footer.php`-dir (vahid altlıq). `edde-home.php`-dəki köhnə altlıqda həll olunmamış git merge konflikti var (`<<<<<<< HEAD` sətirləri ana səhifədə görünə bilər) və ünvan/telefon fərqlidir — ana səhifəni də bu altlıqla vahidləşdirin.
- Ünvan: vahid altlıqda "Əliyar Əliyev 159", dp-nin köhnə altlığında "61" idi. Doğrusunu yoxlayın (`edde_footer.py` → `address`).
- dp altlığındakı "Bu sayt EDDE Global-ın müstəqil alətidir / dp.edu.az" qeydi altlıqdan çıxdı; eyni məzmun dp hero blokundakı `.disc` qeydində qalır.
- ICEF nişanı üçüncü tərəf skriptdir (`www-cdn.icef.com`), əsas saytda olduğu kimi əlavə edilib.
- Mənbə fayllarında qırıq sonluqlar var (`test/index.html`-də `head>`, bir neçə faylda `</script>/body>`, `body>`, `dy>`, `test/index.html`-də `</body></html>` yoxdur). Skript bunları düzəldir; mənbəni də düzəldin.
- PDF/çap rejimi öz rəngləri ilə qalıb (dəyişdirilməyib).
- Kosmos/uşaq ornamentləri (ulduz, planet, raket) gizlədilib; geri qaytarmaq üçün CSS-dəki 2-ci bölmədəki `display:none` sətrini silin.
