<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="modal modal-order" id="order-gate">
    <div class="h2">Заказать продукцию</div>
    <div class="modal__product">
        <div class="modal__product__image"><img src="<?=$arParams['PRODUCT']['PREVIEW_PICTURE']?>" alt=""></div>
        <div class="modal__product__content">
            <div class="title-text"><a href="<?=$arParams['PRODUCT']['DETAIL_PAGE_URL']?>"><?=$arParams['PRODUCT']['NAME']?></a></div>
            <!--<div class="text"><a href="#">секционные, алюминий</a></div>-->
        </div>
    </div>
    <form class="form form-no-bg" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data" method="post" data-app="form">
        <input type="hidden" name="WEB_FORM_ID" value="<?=$arResult["arForm"]['ID']?>">
        <?=bitrix_sessid_post()?>
        <input type="hidden" name="form_<?= $arResult["QUESTIONS"]["PRODUCT"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PRODUCT"]["STRUCTURE"][0]["ID"] ?>" value="<?=$arParams['PRODUCT']['NAME']?>">
        <div class="form__input">
            <div class="form__label">Ваше имя<span style="color: red;">*</span></div>
            <div class="form__field">
                <input type="text" name="form_<?= $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["ID"] ?>" data-validation="{&quot;regex&quot;:[&quot;^[a-zA-Zа-яА-Я\\s]+$&quot;,&quot;ig&quot;],&quot;maxlength&quot;:300}" required>
            </div>
        </div>
        <div class="form__input">
            <div class="form__label">Город<span style="color: red;">*</span></div>
            <div class="form__field">
                <input type="text" name="form_<?= $arResult["QUESTIONS"]["CITY"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["CITY"]["STRUCTURE"][0]["ID"] ?>" data-validation="{&quot;regex&quot;:[&quot;^[a-zA-Zа-яА-Я\\s]+$&quot;,&quot;ig&quot;],&quot;maxlength&quot;:300}" required>
            </div>
        </div>
        <div class="form__input">
            <div class="form__label">Телефон<span style="color: red;">*</span></div>
            <div class="form__field">
                <input type="tel" placeholder="+7 (___) ___ __-__" data-app="mask" data-mask="+7 (999) 999 99-99" inputmode="text" name="form_<?= $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["ID"] ?>" required>
            </div>
        </div>
        <div class="form__input">
            <div class="form__label">Email<span style="color: red;">*</span></div>
            <div class="form__field">
                <input type="email" name="form_<?= $arResult["QUESTIONS"]["EMAIL"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["EMAIL"]["STRUCTURE"][0]["ID"] ?>" data-validation="{&quot;regex&quot;:[&quot;^\\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,6}\\b$&quot;,&quot;i&quot;],&quot;maxlength&quot;:254}" required>
            </div>
        </div>
        <div class="g-recaptcha" id="g-recaptcha" data-sitekey="6Lc5kI8qAAAAAGY_fMXZuEdoeKsn3PpWk0VlB0oc"></div>
        <div class="form__submit">
            <button class="btn"  type="submit">
                <span>Отправить</span>
            </button>
            <div class="checkbox">
                <label>
                    <input type="checkbox" checked name="checkbox" required><i></i><span>Я ознакомлен и согласен с условиями сбора и обработки персональных данных в рамках <a href="/privacy/">Политики конфиденциальности</a></span>
                </label>
            </div>
        </div>
        <input type="hidden" name="web_form_submit" value="Сохранить">
    </form>
</div>
