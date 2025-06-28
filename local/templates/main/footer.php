
<? if (CSite::InDir('/products/')): ?>
<div class="footer-bnft">
    <div class="container">
        <div class="bnft">
            <div class="bnft__item">
                <div class="bnft__item-icon"><img src="/img/bnft-icon-1.svg"></div>
                <div class="bnft__item-title">12 филиалов и более 160 официальных дистрибьюторов в РФ — оставьте заявку в ближайшем к вам центре</div>
                <div class="bnft__item-desc">Бесплатный выезд на замер осуществляется в течение 0-5 дней. Доставка, разгрузка и установка под ключ — 1 день. Готовые комплекты ворот стандартных размеров всегда в наличии на складе, возможность производства под заказ.</div>
            </div>
            <div class="bnft__item">
                <div class="bnft__item-icon"><img src="/img/bnft-icon-2.svg"></div>
                <div class="bnft__item-title">Все от одного производителя — быстрее, надежнее и технологичнее</div>
                <div class="bnft__item-desc">С 1935 года разрабатываем решения для устройства въезда/выезда в гараж частного дома, коммерческого объекта, производственного помещения. Предложим несколько вариантов на выбор и оптимальную комплектацию под параметры вашего проема и бюджет.</div>
            </div>
            <div class="bnft__item">
                <div class="bnft__item-icon"><img src="/img/bnft-icon-3.svg"></div>
                <div class="bnft__item-title">Немецкое качество для нескольких поколений</div>
                <div class="bnft__item-desc">Ворота рассчитаны на 25 000 циклов. Срок службы продукции Hormann — более 25 лет. Подтвержден длительными испытаниями на прочность и долговечность в реальных условиях, а также личным опытом наших клиентов. Оригинальные запчасти в наличии.</div>
            </div>
            <div class="bnft__item">
                <div class="bnft__item-icon"><img src="/img/bnft-icon-4.svg"></div>
                <div class="bnft__item-title">Выбирайте инновационные технологии и экологически безопасные материалы</div>
                <div class="bnft__item-desc">Ворота, двери, автоматика, комплектующие, перегрузочная техника и системы контроля доступа изготавливаются с учетом строгих экологических требований, обеспечивают нулевой уровень выбросов CO2. Стройматериалы и оборудование, используемые Hormann, включены в Green Book.</div>
            </div>
        </div>
    </div>
</div>
<? endif;?>

<footer class="is-footer">
    <div class="container">
        <div class="is-footer__container">
            <div class="is-footer__info">
                <ul>
                    <li>
                        <a href="mailto:<?= \COption::GetOptionString("askaron.settings", "UF_MAIL")[0] ?>">
                            <svg>
                                <use xlink:href="/static/build/images/sprites.svg#letter"></use>
                            </svg>
                            <span><?= \COption::GetOptionString("askaron.settings", "UF_MAIL")[1] ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="tel:<?= \COption::GetOptionString("askaron.settings", "UF_PHONE")[0] ?>">
                            <svg>
                                <use xlink:href="/static/build/images/sprites.svg#phone"></use>
                            </svg>
                            <span><?= \COption::GetOptionString("askaron.settings", "UF_PHONE")[1] ?></span>
                            <span class="is-footer__info_date"><?= \COption::GetOptionString("askaron.settings", "UF_TIME") ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/ask/">
                            <svg>
                                <use xlink:href="/static/build/images/sprites.svg#point"></use>
                            </svg>
                            <span>Задать <br> вопрос</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="is-footer__left">
                <a class="is-footer__logo" <?= $APPLICATION->GetCurPage() != "/" ? ' href="/"' : '' ?>>
                    <img class="responsive-img" src="/static/build/images/logo.svg" alt="logo" width="176" height="40">
                </a>
                <ul class="is-footer__nav">
                    <li class="is-footer__nav-item">
                        <a href="/products/garazhnye-vorota/" class="is-link is-footer__nav-text">Гаражные ворота</a>
                    </li>
                                <li class="is-footer__nav-item">
                        <a href="/products/vkhodnye-dveri/" class="is-link is-footer__nav-text">Двери</a>
                    </li>
                                <li class="is-footer__nav-item">
                        <a href="/products/avtomatika-dlya-vorot/" class="is-link is-footer__nav-text">Электроприводы для дистанционного открывания ворот</a>
                    </li>
                                <li class="is-footer__nav-item">
                        <a href="/products/promyshlennye-vorota/" class="is-link is-footer__nav-text">Промышленные ворота</a>
                    </li>
                                <li class="is-footer__nav-item">
                        <a href="/products/peregruzochnoe-oborudovanie/" class="is-link is-footer__nav-text">Перегрузочное оборудование</a>
                    </li>
                                <li class="is-footer__nav-item">
                        <a href="/products/sistemy-kontrolya-vezda/" class="is-link is-footer__nav-text">Системы контроля проезда<br>транспорта на территорию</a>
                    </li>
                </ul>
                <div class="ya-rating">
					<div class="ya-rating__title">Честные отзывы</div>
                    <iframe src="https://yandex.ru/sprav/widget/rating-badge/48495365425?type=rating" width="150" height="50" frameborder="0"></iframe>
                </div>
            </div>

            <div class="is-footer__center">
                <ul class="is-footer__nav">
                    <li class="is-footer__nav-item">
                        <div>Покупателю</div>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="/about/" class="is-link is-footer__nav-text">О бренде Hörmann</a>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="#" class="is-link is-footer__nav-text">Быстрая доставка<br>и удобная оплата</a>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="#" class="is-link is-footer__nav-text">Гарантия на изделия до 10 лет</a>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="/business/service/" class="is-link is-footer__nav-text">Услуги по ремонту, диагностике<br>и постгарантийному<br>обслуживанию</a>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="/advice/" class="is-link is-footer__nav-text">Статьи, советы и инструкции</a>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="#" class="is-link is-footer__nav-text">Сертификаты</a>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="/portfolio/" class="is-link is-footer__nav-text">Проекты</a>
                    </li>
                </ul>
                <ul class="is-footer__nav">
                    <li class="is-footer__nav-item">
                        <div>Партнерам</div>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="/media/documents/" class="is-link is-footer__nav-text">Документация по монтажу<br>и эксплуатации</a>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="/media/" class="is-link is-footer__nav-text">Каталоги товаров с<br>характеристиками и фото</a>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="https://hormann-sales.ru/architect/" class="is-link is-footer__nav-text">Архитекторам и<br>проектировщикам</a>
                    </li>
                    <li class="is-footer__nav-item">
                        <a href="/for-dealers/" class="is-link is-footer__nav-text">Как стать дилером?</a>
                    </li>
                </ul>
            </div>

            <div class="is-footer__right">
                <div class="is-footer__r-contacts">
                    <a class="phone is-link" href="tel:<?= \COption::GetOptionString("askaron.settings", "UF_PHONE")[0] ?>"><?= \COption::GetOptionString("askaron.settings", "UF_PHONE")[1] ?></a>
                    
                    <div class="footer-address">
                        <span class="scedule"><span>Центральный офис:</span><br>Московская область,<br>Ленинский городской округ,<br>рабочий поселок<br>Горки Ленинские,<br>Зеленое шоссе, 9</span>
                        <span class="scedule"><span>Время работы:</span> <?= \COption::GetOptionString("askaron.settings", "UF_TIME") ?></span>
                    </div>

                    <a class="is-link is-link--has-icon is-footer__r-actions" href="/contacts/">
                        <svg width="16" height="23" viewBox="0 0 16 23" fill="#003a7d" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.014 1.75743C10.7846 0.996125 9.44355 0.615479 7.99069 0.615479C6.91036 0.615479 5.87661 0.843866 4.88941 1.30065C3.90221 1.75743 3.05161 2.36964 2.3376 3.13729C1.62359 3.90494 1.05549 4.8058 0.633295 5.8399C0.211096 6.87401 0 7.94933 0 9.06591C0 10.5505 0.372523 12.1301 1.11758 13.805C1.6267 14.7186 2.21963 15.6575 2.89639 16.6218C3.57315 17.5861 4.18471 18.3982 4.73108 19.058C5.27746 19.7178 5.84245 20.3712 6.42608 21.0183C7.0097 21.6654 7.40396 22.0937 7.60885 22.303C7.81374 22.5124 7.97206 22.6678 8.08382 22.7693L9.08964 21.5893C9.76019 20.7899 10.648 19.6512 11.7532 18.173C12.8584 16.6948 13.8393 15.2642 14.6962 13.8811C15.5654 12.0667 16 10.4299 16 8.97075C16 7.48621 15.643 6.10319 14.929 4.82166C14.215 3.54013 13.2433 2.51873 12.014 1.75743ZM8 4.02396C9.22399 4.02396 10.2707 4.4407 11.1402 5.27418C12.0097 6.10766 12.4444 7.11423 12.4444 8.29393C12.4444 9.47363 12.0097 10.477 11.1402 11.3041C10.2707 12.1311 9.22399 12.5447 8 12.5447C6.77602 12.5447 5.72929 12.1311 4.8598 11.3041C3.9903 10.477 3.55556 9.47363 3.55556 8.29393C3.55556 7.11423 3.9903 6.10766 4.8598 5.27418C5.72929 4.4407 6.77602 4.02396 8 4.02396Z" fill="#003A7D"></path>
                        </svg>
                        <span>Шоу-румы в Москве</span>
                    </a>

                    <a class="is-link is-link--has-icon is-footer__r-actions" href="mailto:<?= \COption::GetOptionString("askaron.settings", "UF_MAIL")[0] ?>">
                        <svg fill="#003a7d" height="14" viewBox="0 0 16 14" width="16" xmlns="http://www.w3.org/2000/svg">
                            <path d="m.333333.333333h15.333367c.0889 0 .1422.022222.16.066667.0266.044444.0044.102222-.0667.173333l-7.52 7.559997c-.07111.07111-.15111.10667-.24.10667s-.16889-.03556-.24-.10667l-7.52-7.559997c-.071111-.071111-.097778-.128889-.08-.173333.026667-.044445.084444-.066667.173333-.066667zm-.093333 2.906667 3.52 3.52c.07111.07111.10667.15111.10667.24s-.03556.16889-.10667.24l-3.52 3.52c-.071111.0711-.128889.0978-.1733333.08-.0444445-.0267-.0666667-.0844-.0666667-.1733v-7.33337c0-.08889.0222222-.14222.0666667-.16.0444443-.02666.1022223-.00444.1733333.06667zm12 3.52 3.52-3.52c.0711-.07111.1289-.09333.1733-.06667.0445.01778.0667.07111.0667.16v7.33337c0 .0889-.0222.1466-.0667.1733-.0444.0178-.1022-.0089-.1733-.08l-3.52-3.52c-.0711-.07111-.1067-.15111-.1067-.24s.0356-.16889.1067-.24zm-1.3333 1.81333 4.8533 4.85337c.0711.0711.0933.1289.0667.1733-.0178.0444-.0711.0667-.16.0667h-15.333367c-.088889 0-.146666-.0223-.173333-.0667-.017778-.0444.008889-.1022.08-.1733l4.85333-4.85337c.07111-.07111.15111-.10666.24-.10666s.16889.03555.24.10666l2.18667 2.18667c.07111.0711.15111.1067.24.1067s.16889-.0356.24-.1067l2.1867-2.18667c.0711-.07111.1511-.10666.24-.10666s.1689.03555.24.10666z" fill="#003a7d"></path>
                        </svg>
                        <span><?= \COption::GetOptionString("askaron.settings", "UF_MAIL")[0] ?></span>
                    </a>

                    <div class="footer-btn">
                        <a class="btn js-order-gate-open" href="/ask/"><span>Получить консультацию</span></a>
                        <a class="btn js-order-gate-open" href="#" data-id=""><span>Обратная связь</span></a>
                    </div>

                    <div class="is-footer__social">
                        <ul class="social-list">
                            <li class="social-list__item"><a href="https://vk.com/hormann_russia" target="_blank"><img src="/img/vk.png"></a></li>
                            <li class="social-list__item"><a href="https://dzen.ru/id/61e688499f1f78798c81dd64" target="_blank"><img src="/img/dzen.png"></a></li>
                            <li class="social-list__item"><a href="https://rutube.ru/channel/43487913/" target="_blank"><img src="/img/rutube.png"></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="is-footer__bottom">
        <div class="container">
            <div class="is-footer__b-cont">
                <div class="is-footer__b-main">
                    <div>&copy; <?=date("Y")?> Представительство ООО &laquo;Хёрманн Руссия&raquo;</div>
                </div>
                <div class="is-footer__b-main">
                    <a class="is-link item" href="/privacy/">Политика конфиденциальности</a>
                    <a class="is-link item" href="/output/">Выходные данные</a>
                    <a class="is-link item" href="/site-map/">Карта сайта</a>
                </div>
                <div class="is-footer__b-right">
                    <a class="is-link item" target="_blank" href="https://proton-marketing.ru/">Продвижение сайта proton-marketing.ru</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<button class="up-btn" type="button" data-app="up-btn"></button>
<div class="hidden">
    <? $APPLICATION->IncludeComponent("itech:city-hidden", "", [
        'CITY' => $city,
        'IBLOCK_ID' => IBLOCK_ID_CIRIES,
    ]); ?>
</div>
</div>
<?php
//use Bitrix\Main\Page\Asset;
//
//Asset::getInstance()->addJs('/static/build/js/vendor.js', true);
//Asset::getInstance()->addJs('/static/build/js/main.js', true);
//Asset::getInstance()->addJs('/dist/js/sticky.min.js', true);

?>

<script src="/static/build/js/vendor.js?v=1637848494197"></script>
<script src="/static/build/js/main.js?v=1637848494197"></script>
<script src="/dist/js/sticky.min.js?v=1637848494197"></script>
<script>
    const prevImg = document.querySelector('.fixed_block');
    const prevImgMask = document.querySelector(".fixed_block_position-mobile-mask")
    var sticky = new Sticky('.fixed_block');
</script>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KVCKJJS"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Calltouch -->
<!-- calltouch request-->
<script>
    Element.prototype.matches || (Element.prototype.matches = Element.prototype.matchesSelector || Element.prototype.webkitMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector), Element.prototype.closest || (Element.prototype.closest = function (e) { for (var t = this; t;) { if (t.matches(e)) return t; t = t.parentElement } return null });
    var ct_get_val = function (form, selector) { if (!!form.querySelector(selector)) { return form.querySelector(selector).value; } else { return ''; } }
    document.addEventListener('click', function (e) { if (e.target.closest('form button[type="submit"]')) { SendCalltouch(e.target.closest('form')) } });
    function GetElem(form, value) {
        const regex = new RegExp(value, 'i');
        const elements = form.querySelectorAll('div.form__label');
        let result = '';
        elements.forEach(el => {
            const text = el.textContent.trim(); if (regex.test(text)) {
                console.log(el.closest('div.form__input')); result = el.closest('div.form__input').querySelector('input').value; return false;
            }
        });
        return result;
    }
    function SendCalltouch(f) {
        if (!f.closest('div').getAttribute('class').includes('b24-form')) {
            try {
                var fio = ct_get_val(f, 'input[name="name"]') !== '' ? ct_get_val(f, 'input[name="name"]') : GetElem(f, 'имя|ф.и.о.');
                var phone = ct_get_val(f, 'input[type="tel"]') !== '' ? ct_get_val(f, 'input[type="tel"]') : GetElem(f, 'телефон|номер|Телефон');
                var email = ct_get_val(f, 'input[type="email"]') !== '' ? ct_get_val(f, 'input[type="email"]') : GetElem(f, 'почта|mail');
                var comment = ct_get_val(f, 'textarea:not([name="g-recaptcha-response"])');
                var check = !!f.querySelector('input[name="checkbox"]') ? f.querySelector('input[name="checkbox"]').checked : true;
                var ct_site_id = '27335';
                var sub = !!f.querySelector('div.title-text, div.h2') ? f.querySelector('div.title-text, div.h2').textContent.trim() : 'Заявка с ' + location.hostname;
                var ct_data = {
                    fio: !!fio ? fio : '',
                    phoneNumber: !!phone ? phone : '',
                    email: !!email ? email : '',
                    subject: sub,
                    comment: comment,
                    requestUrl: location.href,
                    sessionId: call_value
                };
                var post_data = Object.keys(ct_data).reduce(function (a, k) { if (!!ct_data[k]) { a.push(k + '=' + encodeURIComponent(ct_data[k])); } return a }, []).join('&');
                var CT_URL = 'https://api.calltouch.ru/calls-service/RestAPI/requests/' + ct_site_id + '/register/';
                var req_inp = f.querySelectorAll('input[required],textarea[required]');
                var ct_valid = Array.from(req_inp).every(inp => inp.value.trim() != '') && (phone.replace(/[^0-9]/gim, '').length > 9 || !!email);
                var captcha = !!f.querySelector('textarea[name="g-recaptcha-response"]') ? f.querySelector('textarea[name="g-recaptcha-response"]').value.length > 0 : true;
                console.log(ct_data, ct_valid, captcha, check)
                if (ct_valid && check && captcha && !window.ct_snd_flag) {
                    window.ct_snd_flag = 1; setTimeout(function () { window.ct_snd_flag = 0; }, 20000);
                    var request = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
                    request.open("POST", CT_URL, true); request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    request.send(post_data);
                }
            } catch (e) { console.log(e); }
        }
    }
</script>
<script type="text/javascript">
    var _ctreq_b24 = function (data) {
        var sid = '27335';
        var request = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
        var post_data = Object.keys(data).reduce(function (a, k) { if (!!data[k]) { a.push(k + '=' + encodeURIComponent(data[k])); } return a }, []).join('&');
        var url = 'https://api.calltouch.ru/calls-service/RestAPI/' + sid + '/requests/orders/register/';
        request.open("POST", url, true); request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); request.send(post_data);
    };
    window.addEventListener('b24:form:submit', function (e) {
        var form = event.detail.object;
        if (form.validated) {
            var fio = ''; var phone = ''; var email = ''; var comment = '';
            form.getFields().forEach(function (el) {
                if (el.name == 'LEAD_NAME' || el.name == 'CONTACT_NAME') { fio = el.value(); }
                if (el.name == 'LEAD_PHONE' || el.name == 'CONTACT_PHONE') { phone = el.value(); }
                if (el.name == 'LEAD_EMAIL' || el.name == 'CONTACT_EMAIL') { email = el.value(); }
                if (el.name == 'LEAD_COMMENTS' || el.name == 'DEAL_COMMENTS ' || el.name == 'CONTACT_COMMENTS') { comment = el.value(); }
            });
            var sub = !!form.title ? form.title : 'Заявка с формы Bitrix24 ' + location.hostname;
            var ct_data = { fio: fio, phoneNumber: phone, email: email, comment: comment, subject: sub, requestUrl: location.href, sessionId: window.call_value };
            console.log(ct_data);
            if (!!phone || !!email) _ctreq_b24(ct_data);
        }
    });
</script>
<!-- calltouch request-->
<!-- Calltouch -->
</body>
</html>