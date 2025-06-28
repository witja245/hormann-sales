<form class="form wow" name="<?=$arResult["arForm"]['VARNAME']?>" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data" method="post" data-app="form">

    <input type="hidden" name="WEB_FORM_ID" value="<?=$arResult["arForm"]['ID']?>">
    <?=bitrix_sessid_post()?>
    <div class="form__box">
        <div class="form__row form__row_width-33">
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Ваше имя<span style="color: red;">*</span></div>
                    <div class="form__field">
                        <input type="text" name="form_<?= $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["ID"] ?>" data-validation="{&quot;regex&quot;:[&quot;^[a-zA-Zа-яА-Я\\s]+$&quot;,&quot;ig&quot;],&quot;maxlength&quot;:300}" required>
                    </div>
                </div>
            </div>
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Компания<span style="color: red;">*</span></div>
                    <div class="form__field">
                        <input type="text" name="form_<?= $arResult["QUESTIONS"]["COMPANY"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["COMPANY"]["STRUCTURE"][0]["ID"] ?>" data-validation="{&quot;maxlength&quot;:300}" required>
                    </div>
                </div>
            </div>
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Город<span style="color: red;">*</span></div>
                    <div class="form__field">
                        <input type="text" name="form_<?= $arResult["QUESTIONS"]["CITY"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["CITY"]["STRUCTURE"][0]["ID"] ?>" data-validation="{&quot;maxlength&quot;:300}" required>
                    </div>
                </div>
            </div>
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Телефон<span style="color: red;">*</span></div>
                    <div class="form__field">
                        <input type="tel" placeholder="+7 (___) ___ __-__" data-app="mask" data-mask="+7 (999) 999 99-99" inputmode="text" name="form_<?= $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["ID"] ?>" required>
                    </div>
                </div>
            </div>
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Email<span style="color: red;">*</span></div>
                    <div class="form__field">
                        <input type="email" name="form_<?= $arResult["QUESTIONS"]["EMAIL"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["EMAIL"]["STRUCTURE"][0]["ID"] ?>"  data-validation="{&quot;regex&quot;:[&quot;^\\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,6}\\b$&quot;,&quot;i&quot;],&quot;maxlength&quot;:254}" required>
                    </div>
                </div>
            </div>
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Сайт компании(если есть)</div>
                    <div class="form__field">
                        <input type="text" name="form_<?= $arResult["QUESTIONS"]["SITE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["SITE"]["STRUCTURE"][0]["ID"] ?>" data-validation="{&quot;maxlength&quot;:254}">
                    </div>
                </div>
            </div>
        </div>
        <div class="g-recaptcha" id="g-recaptcha" data-sitekey="6Lc5kI8qAAAAAGY_fMXZuEdoeKsn3PpWk0VlB0oc"></div>
        <div class="form__input">
            <div class="form__label">Сообщение<span style="color: red;">*</span></div>
            <div class="form__field">
                <textarea name="form_<?= $arResult["QUESTIONS"]["MESSAGE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["MESSAGE"]["STRUCTURE"][0]["ID"] ?>" placeholder="Расскажите об объекте и укажите, что нужно рассчитать" data-validation="{&quot;maxlength&quot;:2000}" required></textarea>
            </div>
        </div>
        <div class="form__submit">
            <button class="btn" type="submit"><span>Отправить</span></button>
            <div class="checkbox">

                <label>
                    <input type="checkbox" required checked id ="82" name="form_checkbox_CHECBOX[]" value="82"><i></i><span>Я ознакомлен и согласен с условиями сбора и обработки персональных данных в рамках <a href="/privacy/">Политики конфиденциальности</a></span>
                  
                </label>
            </div>
        </div>
    </div>
    <input type="hidden" name="web_form_submit" value="Сохранить">
</form>
