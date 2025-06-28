<?php

/** @global CMain $APPLICATION */
/** @global CDatabase $DB */

/** @global CUser $USER */

use Bitrix\Main\Loader,
    Bitrix\Main,
    Bitrix\Main\Application;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

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
\Bitrix\Main\Loader::includeModule('highloadblock');

\Bitrix\Main\UI\Extension::load("ui.alerts");
\Bitrix\Main\UI\Extension::load("ui.buttons");

$action = $APPLICATION->GetCurUri();

if ($_REQUEST['parse'] == 'Y' && $_FILES['price']) {
    $filePath = $_FILES['price']['tmp_name'];

    $reader = ReaderEntityFactory::createXLSXReader();

    $reader->open($filePath);

    $colors = [];
    $prices = [];


    /* @var Box\Spout\Reader\XLSX\Sheet $sheet */
    foreach ($reader->getSheetIterator() as $sheet) {
        foreach ($sheet->getRowIterator() as $row) {
            $cells = $row->getCells();
            $val = [$cells[0]->getValue(), $cells[1]->getValue()];
            if ($sheet->getIndex() == 0) {
                $colors[] = $val;
            } else {
                $prices[] = $val;
            }
        }
    }

    $reader->close();
    unset($prices[0], $colors[0]);

    if ($colors && $prices) {
        $dataToSave = [];

        $hlPrice = Itech\Helper::getHlEntityByCode('CalcColor');
        $exestsIds = [];
        $exestsIdsDb = $hlPrice::getList(['select' => ['ID']]);
        while ($el = $exestsIdsDb->fetch()) {
            $exestsIds[] = $el['ID'];
        }

        foreach ($colors as $color) {
            $priceCode = $color[0];
            $name = $color[1];
            $colorPrice = 0;

            foreach ($prices as $price) {
                $code = $price[0];
                if ($priceCode == $code) {
                    $colorPrice = $price[1];
                }
            }

            if ($name) {
                $dataToSave[] = [
                    'UF_NAME' => $name,
                    'UF_PRICE' => $colorPrice
                ];
            }
        }

        foreach ($dataToSave as $data) {
            $hlPrice::add($data);
        }

        if ($exestsIds) {
            foreach ($exestsIds as $id) {
                $hlPrice::delete($id);
            }
        }

    }
}
?>

    <form method="post" id="form" enctype="multipart/form-data">

        <input type="hidden" name="parse" value="Y">
        <div class="ui-alert ui-alert-warning">
            <span class="ui-alert-message"><strong>Внимание!</strong> Текущие записи будут удалены.</span>
        </div>

        <label>Цены: <input type="file" name="price"></label>

        <button type="submit" class="ui-btn ui-btn-success">Парсить</button>

    </form>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>