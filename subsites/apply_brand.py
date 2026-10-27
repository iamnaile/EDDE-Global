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
  1e) dp: bölmələri (sol sidebar) header-də sağa köçürür, hamburger + mobil menyu əlavə edir; hamısında header-ə rəngli logo qoyur;
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

LOGO_IMG = '<img class="logo-img" src="/edde-assets/logo.png" alt="EDDE Global">'
TOGGLE_JS = ('<script>(function(){var t=document.getElementById("navToggle"),n=document.getElementById("mainNav");'
  'if(!t||!n)return;function c(){n.classList.remove("open");t.setAttribute("aria-expanded","false")}'
  't.addEventListener("click",function(){var o=n.classList.toggle("open");t.setAttribute("aria-expanded",o)});'
  'n.querySelectorAll("a").forEach(function(a){a.addEventListener("click",c)});'
  'n.querySelectorAll(".dd").forEach(function(d){d.addEventListener("click",function(){d.parentElement.classList.toggle("mega-open")})});'
  'document.addEventListener("keydown",function(e){if(e.key==="Escape")c()});})();</script>')

def cut(html, start_marker, end_marker):
    """start_marker-dən end_marker-ə (daxil) qədər hissəni kəsir; (qalan, kəsilən) qaytarır."""
    i = html.find(start_marker)
    if i < 0:
        return html, ''
    j = html.find(end_marker, i) + len(end_marker)
    return html[:i] + html[j:], html[i:j]

def move_sections_to_header(html):
    """dp: sol sidebar (<nav class="snav">) və mobil çip menyusu (.mnav) əvəzinə bölmələri header-də sağa qoyur (əsas saytdakı .main-nav).
    Linklər, data-sec və data-l atributları saxlanılır ki, dp-nin JS-i (scroll-spy, dilə görə ünvan) dəyişməsin."""
    if '<nav class="snav"' not in html:
        return html
    html, _ = cut(html, '<nav class="mnav"', '</nav>')
    html, block = cut(html, '<nav class="snav"', '</nav>')
    aria = (re.search(r'aria-label="([^"]*)"', block) or [0, 'Menu'])[1]
    h6 = re.findall(r'<h6>(.*?)</h6>', block)
    useful = h6[1] if len(h6) > 1 else 'Links'
    secs = re.findall(r'<a href="(#[^"]*)" data-sec="([^"]+)">(?:<i>.*?</i>)?<span>(.*?)</span></a>', block, re.S)
    lk = re.search(r'<div class="lk">(.*?)</div>', block, re.S)
    cta = re.search(r'<a class="cta".*?</a>', block, re.S)
    items = ''.join(f'<li><a href="{h}" data-sec="{d}">{t}</a></li>' for h, d, t in secs)
    nav = (f'<nav class="snav main-nav" id="mainNav" aria-label="{aria}"><ul>{items}'
           f'<li class="has-mega"><span class="dd" tabindex="0">{useful}</span><div class="mega-menu"><div class="mega-menu__col--links">'
           f'<span class="mega-menu__label">{useful}</span>{lk.group(1).strip() if lk else ""}{cta.group(0) if cta else ""}'
           f'</div></div></li></ul></nav>')
    html = html.replace('<nav class="tnav"', nav + '<nav class="tnav"', 1)
    toggle = '<button class="nav-toggle" id="navToggle" aria-label="Menu" aria-expanded="false"><span></span><span></span><span></span></button>'
    html = html.replace('</div></header>', toggle + '</div></header>', 1)
    return html.replace('</body>', TOGGLE_JS + '\n</body>', 1)

def add_logo(html):
    """Header-ə əsas saytın rəngli logosunu əlavə edir. Orijinal (ağ) <img> DOM-da qalır — JS PDF üçün onun src-ni oxuyur."""
    i = html.find('<header class="top"')
    j = html.find('</header>', i)
    if i < 0 or 'class="logo-img"' in html[i:j]:
        return html
    k = html.find('<img', i)
    if k < 0 or k > j:
        return html
    e = html.find('>', k) + 1
    return html[:e] + LOGO_IMG + html[e:]

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
    html = move_sections_to_header(html)
    html = add_logo(html)
    html = FOOT.sub(lambda m: footer_html(lang), html, count=1)
    return html.replace('</head>', '<style id="edde-brand">\n' + css + '</style>\n</head>', 1)

def main(src, dst):
    here = pathlib.Path(__file__).parent
    css = ''.join((here / n).read_text(encoding='utf8') for n in ('edde-brand.css', 'edde-footer.css'))
    src, dst = pathlib.Path(src), pathlib.Path(dst)
    shutil.copytree(here / 'edde-assets', dst / 'edde-assets', dirs_exist_ok=True)  # <sayt-kökü>/edde-assets/: bg-home.jpg, logo.png
    for f in sorted(src.rglob('*.html')):
        out = dst / f.relative_to(src)
        out.parent.mkdir(parents=True, exist_ok=True)
        out.write_text(patch(f.read_text(encoding='utf8'), css), encoding='utf8')
        print('OK', out)

if __name__ == '__main__':
    if len(sys.argv) != 3:
        sys.exit(__doc__)
    main(sys.argv[1], sys.argv[2])
