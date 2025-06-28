<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$formId = $_REQUEST["WEB_FORM_ID"];
$status = $_REQUEST["formresult"];


if (isset($formId) && $formId == $arParams["WEB_FORM_ID"]) {
    $APPLICATION->RestartBuffer();
    if ($status == "addok") {
        echo json_encode([
            'result' => true,
            'message' => 'Спасибо, Ваша заявка принята! В ближайшее время наш менеджер свяжется с Вами!',
        ]);
    } else {
        echo json_encode([
            'result' => false,
            'message' => $arResult["FORM_ERRORS_TEXT"],
        ]);
    }
    exit();
}