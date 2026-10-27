#!/usr/bin/env python3
"""edde-brand.css-i alt-saytların HTML fayllarına yeridir (təkrar işlədəndə köhnə versiyanı əvəz edir).

İstifadə:  python3 apply_brand.py <giriş_qovluğu> <çıxış_qovluğu>
Qovluqdakı bütün *.html faylları (alt qovluqlar daxil) işlənir, struktur saxlanılır.
Nə edir:
  1) IBM Plex Sans Google Fonts link-ini Manrope + Inter link-i ilə əvəz edir;
  0) mənbədə qırıq </head> varsa ("</script>head>") düzəldir;
  1b) köhnə <footer class="site-foot"> blokunu eddeglobal.az altlığı ilə (az/en/ru) əvəz edir (edde_footer.py);
  1c) faylın sonundakı qırıq "</script>/body>" / "body>" / "dy>" / çatışmayan "</body></html>" düzəldir;
  1d) <body>-nin əvvəlinə bulanıq fon (.page-bg + overlay) qoyur; fon şəklini <çıxış>/edde-assets/bg-home.jpg kimi kopyalayır;
  1e) dp: bölmələri sol sidebar əvəzinə sağdakı yan panelə (.epage-aside) köçürür, mobil çip menyusunu (.mnav) çıxarır;
  2) </head>-dən əvvəl  <style id="edde-brand">…edde-brand.css…</style>  əlavə edir.
Başqa heç nəyə (JS, SRI, forma, honeypot, Clarity) toxunmur.
"""
import re, sys, shutil, pathlib
from edde_footer import footer_html

FONTS = ('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
         'family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap">')
PLEX = re.compile(r'<link rel="stylesheet" href="https://fonts\.googleapis\.com/css2\?family=IBM\+Plex\+Sans[^"]*">')
FOOT = re.compile(r'<footer class="site-(?:foot|footer)".*?</footer>\s*(?:<a [^>]*class="floating-btn[^>]*>.*?</a>\s*)?', re.S)
BG = re.compile(r'<div class="page-bg"></div>\s*<div class="page-bg-overlay"></div>\s*')
BODY = re.compile(r'<body[^>]*>')
OLD = re.compile(r'<style id="edde-brand">.*?</style>\n?', re.S)

# test/konsultasiya mənbələrində faylın sonu qırıqdır: "</script>/body>", "</script>body>", "</script>dy>" və ya heç nə
BROKEN_TAIL = re.compile(r'(</script>)\s*(?:<?/?(?:bo)?dy>|<?/?body>)?\s*(?:</html>)?\s*$')
BROKEN_HEAD = re.compile(r'(</script>)head>(\s*<body)')

ASIDE_T = {
    'az': ('Məsləhətçilərimiz sizə uyğun ölkə, universitet və proqramı seçməkdə kömək edəcək.', 'Müraciət et'),
    'en': ('Our advisors will help you choose the right country, university and program.', 'Apply now'),
    'ru': ('Наши консультанты помогут вам выбрать подходящую страну, университет и программу.', 'Подать заявку'),
}
PHONE = ('+994 77 255 56 58', 'tel:+994772555658')

def cut(html, start_marker, end_marker):
    """start_marker-dən end_marker-ə (daxil) qədər hissəni kəsir; (qalan, kəsilən) qaytarır."""
    i = html.find(start_marker)
    if i < 0:
        return html, ''
    j = html.find(end_marker, i) + len(end_marker)
    return html[:i] + html[j:], html[i:j]

def sections_to_aside(html, lang):
    """dp: sol sidebar (<nav class="snav">) və mobil çip menyusu (.mnav) əvəzinə, əsas saytdakı məzmun səhifələri kimi,
    sağda yan panel (.epage-layout > main + aside.epage-aside) qurur: Bölmələr / Faydalı linklər / Pulsuz konsultasiya kartı.
    Linklərin data-sec və data-l atributları saxlanılır — dp-nin app.js-i (scroll-spy, dilə görə ünvan) dəyişməyib."""
    if '<nav class="snav"' not in html or '<main class="wrap"' not in html:
        return html
    html, _ = cut(html, '<nav class="mnav"', '</nav>')
    html, block = cut(html, '<nav class="snav"', '</nav>')
    h6 = re.findall(r'<h6>(.*?)</h6>', block)
    secs = re.findall(r'<a href="(#[^"]*)" data-sec="([^"]+)">(?:<i>.*?</i>)?<span>(.*?)</span></a>', block, re.S)
    lk = re.search(r'<div class="lk">(.*?)</div>', block, re.S)
    cta = re.search(r'<a class="cta"([^>]*)>(.*?)</a>', block, re.S)
    text, btn = ASIDE_T.get(lang, ASIDE_T['az'])
    nav1 = ''.join(f'<a href="{h}" data-sec="{d}">{t}</a>' for h, d, t in secs)
    aside = (f'<aside class="epage-aside snav" aria-label="{h6[0] if h6 else ""}">'
             f'<div class="epage-aside__card"><h4>{h6[0] if h6 else ""}</h4><nav>{nav1}</nav></div>'
             f'<div class="epage-aside__card"><h4>{h6[1] if len(h6) > 1 else ""}</h4><nav>{lk.group(1).strip() if lk else ""}</nav></div>'
             f'<div class="epage-aside__card epage-aside__card--cta"><h4>{cta.group(2) if cta else ""}</h4><p>{text}</p>'
             f'<a class="btn btn--light btn--block"{cta.group(1) if cta else ""}>{btn}</a>'
             f'<a class="epage-aside__phone" href="{PHONE[1]}">{PHONE[0]}</a></div></aside>')
    i = html.find('<main class="wrap"')
    j = html.find('</main>', i) + len('</main>')
    return html[:i] + '<div class="epage-layout">' + html[i:j] + aside + '</div>' + html[j:]

def patch(html, css):
    lang = (re.search(r'<html[^>]*\blang="(\w+)"', html) or [0, 'az'])[1]
    html = OLD.sub('', html)
    html = html[:-300] + BROKEN_TAIL.sub(r'\1</body>\n</html>\n', html[-300:])
    if '</head>' not in html:  # test.eddeglobal.az/index.html-də "</head>" yerinə "head>" yazılıb
        html = BROKEN_HEAD.sub(r'\1</head>\2', html)
    if 'family=Manrope' not in html:
        html, n = PLEX.subn(FONTS, html, count=1)
        if n == 0:
            html = html.replace('</head>', FONTS + '\n</head>', 1)
    html = BG.sub('', html)
    html = BODY.sub(lambda m: m.group(0) + '\n<div class="page-bg"></div>\n<div class="page-bg-overlay"></div>', html, count=1)
    html = sections_to_aside(html, lang)
    html = FOOT.sub(lambda m: footer_html(lang), html, count=1)
    return html.replace('</head>', '<style id="edde-brand">\n' + css + '</style>\n</head>', 1)

def main(src, dst):
    here = pathlib.Path(__file__).parent
    css = ''.join((here / n).read_text(encoding='utf8') for n in ('edde-brand.css', 'edde-footer.css'))
    src, dst = pathlib.Path(src), pathlib.Path(dst)
    shutil.copytree(here / 'edde-assets', dst / 'edde-assets', dirs_exist_ok=True)  # fon şəkli: <sayt-kökü>/edde-assets/bg-home.jpg
    for f in sorted(src.rglob('*.html')):
        out = dst / f.relative_to(src)
        out.parent.mkdir(parents=True, exist_ok=True)
        out.write_text(patch(f.read_text(encoding='utf8'), css), encoding='utf8')
        print('OK', out)

if __name__ == '__main__':
    if len(sys.argv) != 3:
        sys.exit(__doc__)
    main(sys.argv[1], sys.argv[2])
