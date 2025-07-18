<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?=$arResult["FORM_NOTE"]?>
    <div id="popup_call"  class="popup_call" style="display: none;">
        <div class="popup_call-img"><img src="<?= $arResult['FORM_IMAGE']['URL'] ?>" alt=""></div>
        <div class="popup_info">
            <div class="popup_title"><?= $arResult["arForm"]['NAME'] ?></div>
            <div class="popup_text"><?= $arResult["arForm"]['DESCRIPTION'] ?></div>
            <div class="popup_form">
                <form  name="<?=$arResult["arForm"]['VARNAME']?>" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data" method="post" data-app="form">
                    <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult["arForm"]['ID'] ?>">
                    <?= bitrix_sessid_post() ?>
                    <input type="text" name="form_<?= $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["ID"] ?>" id="" class="popup_inp" placeholder="Ваше имя">
                    <input type="tel" name="form_<?= $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["ID"] ?>" id="" class="popup_inp" placeholder="Номер телефона">

                    <div class="g-recaptcha" id="g-recaptcha" data-sitekey="6Lc5kI8qAAAAAGY_fMXZuEdoeKsn3PpWk0VlB0oc"></div>


                    <input type="submit" class="btn_popup btn" name="web_form_submit" value="<?= $arResult["arForm"]['NAME'] ?>">
                    <div class="popup_ok">
                        <input type="checkbox" checked> Нажимая кнопку, Вы автоматически соглашаетесь с
                        условиями <a href="">Политики
                            конфиденциальности</a> и обработкой данных</div>
                    <input type="hidden" name="web_form_submit" value="Сохранить">
                </form>

            </div>
        </div>
    </div>