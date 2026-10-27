"""eddeglobal.az altlığının (parts/edde-footer.php) statik HTML versiyası: az / en / ru."""
import base64, pathlib

SITE = 'https://eddeglobal.az'
_LOGO = base64.b64encode((pathlib.Path(__file__).with_name('edde-logo.png')).read_bytes()).decode()

T = {
 'az': dict(
    about='2018-ci ildən bəri tələbələrin xaricdə təhsil arzularını gerçəkləşdirməsinə kömək edən etibarlı təhsil şirkəti.',
    study='Xaricdə təhsil', academy='EDDE Academy', contact='Əlaqə',
    study_links=[('Foundation Təhsili','foundation'),('Bakalavr','bakalavr'),('Magistratura','magistratura'),
                 ('Doktorantura','doktorantura'),('Təqaüd Proqramları','teqaud'),('Ölkələr və universitetlər','olkeler')],
    academy_links=[('IELTS','ielts'),('TOEFL','toefl'),('PTE Academic','pte-academic'),('SAT','sat'),
                   ('Alman Dili Kursları','alman-dili-kurslari'),('FAQ','faq')],
    address='Əliyar Əliyev 159, N.Nərimanov ray., Bakı, AZ1052',
    privacy='Məxfilik siyasəti', wa='WhatsApp ilə yazın', path=''),
 'en': dict(
    about='A trusted education company that has been helping students make their study-abroad dreams come true since 2018.',
    study='Study abroad', academy='EDDE Academy', contact='Contact',
    study_links=[('Foundation','foundation'),("Bachelor's",'bakalavr'),("Master's",'magistratura'),
                 ('Doctorate','doktorantura'),('Scholarship Programs','teqaud'),('Countries & universities','olkeler')],
    academy_links=[('IELTS','ielts'),('TOEFL','toefl'),('PTE Academic','pte-academic'),('SAT','sat'),
                   ('German Language Courses','alman-dili-kurslari'),('FAQ','faq')],
    address='159 Aliyar Aliyev, Narimanov district, Baku, AZ1052',
    privacy='Privacy policy', wa='Message us on WhatsApp', path=''),
 'ru': dict(
    about='Надёжная образовательная компания, которая с 2018 года помогает студентам осуществить мечту об учёбе за рубежом.',
    study='Учёба за рубежом', academy='EDDE Academy', contact='Контакты',
    study_links=[('Foundation','foundation'),('Бакалавриат','bakalavr'),('Магистратура','magistratura'),
                 ('Докторантура','doktorantura'),('Стипендиальные программы','teqaud'),('Страны и университеты','olkeler')],
    academy_links=[('IELTS','ielts'),('TOEFL','toefl'),('PTE Academic','pte-academic'),('SAT','sat'),
                   ('Курсы немецкого языка','alman-dili-kurslari'),('FAQ','faq')],
    address='ул. Алияра Алиева 159, Наримановский р-н, Баку, AZ1052',
    privacy='Политика конфиденциальности', wa='Написать в WhatsApp', path=''),
}

def footer_html(lang):
    t = T.get(lang, T['az'])
    links = lambda items: '\n'.join(f'      <a href="{SITE}/{p}/">{n}</a>' for n, p in items)
    return f'''<footer class="site-footer" id="contact">
  <div class="container footer__grid">
    <div class="footer__col footer__col--brand">
      <a href="{SITE}/" class="logo logo--light"><img src="data:image/png;base64,{_LOGO}" alt="EDDE Global" class="logo-img"></a>
      <p>{t['about']}</p>
      <div class="footer__social">
        <a href="https://www.facebook.com/eddeglobalaz" target="_blank" rel="noopener">Facebook</a>
        <a href="https://www.instagram.com/eddeglobal/" target="_blank" rel="noopener">Instagram</a>
        <a href="https://www.linkedin.com/company/edde-global/" target="_blank" rel="noopener">LinkedIn</a>
        <a href="https://www.youtube.com/@eddeglobal6894" target="_blank" rel="noopener">YouTube</a>
      </div>
    </div>
    <div class="footer__col footer__col--links">
      <h4>{t['study']}</h4>
{links(t['study_links'])}
    </div>
    <div class="footer__col footer__col--links">
      <h4>{t['academy']}</h4>
{links(t['academy_links'])}
    </div>
    <div class="footer__col footer__col--links">
      <h4>{t['contact']}</h4>
      <a href="tel:+994772555658">077 255 56 58</a>
      <a href="tel:+994708332004">070 833 20 04</a>
      <a href="tel:+994124096789">012 409 67 89</a>
      <a href="mailto:info@eddeglobal.az">info@eddeglobal.az</a>
      <span>{t['address']}</span>
    </div>
  </div>
  <div class="container footer__bottom">
    <span>© 2018–2026 EDDE Global.<br>Site by: Naila.</span>
    <div class="footer__bottom-right">
      <div class="footer__icef"><span id="iasBadge" data-account-id="5105"></span><script async defer crossorigin="anonymous" src="https://www-cdn.icef.com/scripts/iasbadgeid.js"></script></div>
      <a href="{SITE}/mexfilik-siyaseti/">{t['privacy']}</a>
    </div>
  </div>
</footer>

<a href="https://wa.me/994772555658" class="floating-btn whatsapp" aria-label="{t['wa']}" target="_blank" rel="noopener">💬</a>
'''
