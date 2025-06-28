<?php

/** @global CMain $APPLICATION */
/** @global CDatabase $DB */

/** @global CUser $USER */

use Bitrix\Main\Loader,
    Bitrix\Main,
    Bitrix\Iblock,
    Bitrix\Iblock\IblockTable,
    Bitrix\Main\Application;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
Loader::includeModule("iblock");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/iblock/prolog.php");
IncludeModuleLangFile(__FILE__);
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/interface/admin_lib.php");

$APPLICATION->SetTitle('Парсер прайсов');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isAjaxRequest()) {
    $APPLICATION->restartBuffer();

    $data = [];

    echo \Bitrix\Main\Web\Json::encode($data);
    die();
}

CJSCore::Init(["jquery"]);
\Bitrix\Main\UI\Extension::load("ui.alerts");
\Bitrix\Main\UI\Extension::load("ui.forms");
\Bitrix\Main\UI\Extension::load("ui.buttons");
?>

    <form method="post">
        <div class="ui-alert ui-alert-warning">
            <span class="ui-alert-message"><strong>Внимание!</strong> Текущие записи будут удалены.</span>
        </div>
        <div class="ui-ctl ui-ctl-textbox">
            <input type="file" name="file" class="ui-ctl-element"
        </div>
        <button class="ui-btn ui-btn-clock">Парсить</button>
    </form>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>