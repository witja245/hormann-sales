<form class="modal modal-order" id="order-gate" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data"
      method="post"
      data-app="order-gate||form" data-url="/ajax/product_ajax.php" data-type="this">
    <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult["arForm"]['ID'] ?>">
    <?= bitrix_sessid_post() ?>
    <div class="h2">Заказать <? //=$arParams['PRODUCT']?></div>
    <div class="modal__product"></div>
    <div class="form form-no-bg">
        <div class="form__input">
            <div class="form__label">Ваше имя<span style="color: red;">*</span></div>
            <div class="form__field">
                <input type="text"
                       name="form_<?= $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["ID"] ?>"
                       data-validation="{&quot;regex&quot;:[&quot;^[a-zA-Zа-яА-Я\\s]+$&quot;,&quot;ig&quot;],&quot;maxlength&quot;:300}"
                       required>
            </div>
        </div>
        <div class="form__input">
            <div class="form__label">Город<span style="color: red;">*</span></div>
            <div class="form__field">
                <input type="text"
                       name="form_<?= $arResult["QUESTIONS"]["CITY"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["CITY"]["STRUCTURE"][0]["ID"] ?>"
                       data-validation="{&quot;regex&quot;:[&quot;^[a-zA-Zа-яА-Я\\s]+$&quot;,&quot;ig&quot;],&quot;maxlength&quot;:300}"
                       required>
            </div>
        </div>
        <div class="form__input">
            <div class="form__label">Телефон<span style="color: red;">*</span></div>
            <div class="form__field">
                <input type="tel" placeholder="+7 (___) ___ __-__" data-app="mask"
                       data-mask="+7 (999) 999 99-99" inputmode="text"
                       name="form_<?= $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["ID"] ?>"
                       required>
            </div>
        </div>
        <div class="form__input">
            <div class="form__label">Email<span style="color: red;">*</span></div>
            <div class="form__field">
                <input type="email" placeholder="example@example.com"
                       name="form_<?= $arResult["QUESTIONS"]["EMAIL"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["EMAIL"]["STRUCTURE"][0]["ID"] ?>"
                       data-validation="{&quot;regex&quot;:[&quot;^\\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,6}\\b$&quot;,&quot;i&quot;],&quot;maxlength&quot;:254}"
                       required>
            </div>
        </div>

        <div class="g-recaptcha" id="g-recaptcha" data-sitekey="6Lc5kI8qAAAAAGY_fMXZuEdoeKsn3PpWk0VlB0oc"></div>

        <div class="form__submit">
            <button class="btn" type="submit"><span>Отправить</span></button>
            <div class="checkbox">
                <label>
                    <input type="checkbox" checked name="checkbox" required><i></i><span>Я ознакомлен и согласен с условиями сбора и обработки персональных данных в рамках <a
                                href="/privacy/">Политики конфиденциальности</a></span>
                </label>
            </div>
        </div>
    </div>
    <input type="hidden" name="web_form_submit" value="Сохранить">
</form>