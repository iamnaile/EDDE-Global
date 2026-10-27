#!/usr/bin/env python3
"""edde-brand.css-i alt-saytların HTML fayllarına yeridir (təkrar işlədəndə köhnə versiyanı əvəz edir).

İstifadə:  python3 apply_brand.py <giriş_qovluğu> <çıxış_qovluğu>
Qovluqdakı bütün *.html faylları (alt qovluqlar daxil) işlənir, struktur saxlanılır.
Nə edir:
  1) IBM Plex Sans Google Fonts link-ini Manrope + Inter link-i ilə əvəz edir;
  0) mənbədə qırıq </head> varsa ("</script>head>") düzəldir;
  2) </head>-dən əvvəl  <style id="edde-brand">…edde-brand.css…</style>  əlavə edir.
Başqa heç nəyə (JS, SRI, forma, honeypot, Clarity) toxunmur.
"""
import re, sys, pathlib

FONTS = ('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
         'family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap">')
PLEX = re.compile(r'<link rel="stylesheet" href="https://fonts\.googleapis\.com/css2\?family=IBM\+Plex\+Sans[^"]*">')
OLD = re.compile(r'<style id="edde-brand">.*?</style>\n?', re.S)

BROKEN_HEAD = re.compile(r'(</script>)head>(\s*<body)')

def patch(html, css):
    html = OLD.sub('', html)
    if '</head>' not in html:  # test.eddeglobal.az/index.html-də "</head>" yerinə "head>" yazılıb
        html = BROKEN_HEAD.sub(r'\1</head>\2', html)
    if 'family=Manrope' not in html:
        html, n = PLEX.subn(FONTS, html, count=1)
        if n == 0:
            html = html.replace('</head>', FONTS + '\n</head>', 1)
    return html.replace('</head>', '<style id="edde-brand">\n' + css + '</style>\n</head>', 1)

def main(src, dst):
    css = (pathlib.Path(__file__).with_name('edde-brand.css')).read_text(encoding='utf8')
    src, dst = pathlib.Path(src), pathlib.Path(dst)
    for f in sorted(src.rglob('*.html')):
        out = dst / f.relative_to(src)
        out.parent.mkdir(parents=True, exist_ok=True)
        out.write_text(patch(f.read_text(encoding='utf8'), css), encoding='utf8')
        print('OK', out)

if __name__ == '__main__':
    if len(sys.argv) != 3:
        sys.exit(__doc__)
    main(sys.argv[1], sys.argv[2])
