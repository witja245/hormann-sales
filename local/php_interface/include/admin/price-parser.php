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

\Bitrix\Main\Loader::includeModule('highloadblock');

\Bitrix\Main\UI\Extension::load("ui.alerts");
\Bitrix\Main\UI\Extension::load("ui.buttons");

$action = $APPLICATION->GetCurUri();

if ($_REQUEST['parse'] == 'Y' && $_FILES['excel']) {
    $filePath = $_FILES['excel']['tmp_name'];

    $reader = ReaderEntityFactory::createXLSXReader();

    $reader->open($filePath);

    $rows = [];

    foreach ($reader->getSheetIterator() as $sheet) {
        foreach ($sheet->getRowIterator() as $row) {
            $cells = $row->getCells();
            $rows[] = $cells;
        }
    }

    $reader->close();
    unset($rows[0]);

    if ($rows) {
        $dataToSave = [];

        $hlPrice = Itech\Helper::getHlEntityByCode('CalcPrice');
        $exestsIds = [];
        $exestsIdsDb = $hlPrice::getList(['select' => ['ID']]);
        while ($el = $exestsIdsDb->fetch()) {
            $exestsIds[] = $el['ID'];
        }

        $hlSurface = Itech\Helper::getHlEntityByCode('CalcSurface');
        $surfaces = Itech\Helper::getHlList($hlSurface, ['UF_NAME', 'ID']);

        $hlBase = Itech\Helper::getHlEntityByCode('CalcBase');
        $bases = Itech\Helper::getHlList($hlBase, ['UF_NAME', 'ID']);

        $hlGateType = Itech\Helper::getHlEntityByCode('CalcGateType');
        $gateTypes = Itech\Helper::getHlList($hlGateType, ['UF_NAME', 'ID']);


        foreach ($rows as $row) {
            $gateType = $row[0]->getValue();
            $base = $row[1]->getValue();
            $surface = $row[2]->getValue();
            $available = $row[4]->getValue() == 'Да' || $row[4]->getValue() == 'да';
            $width = $row[5]->getValue();
            $height = $row[6]->getValue();
            $price = $row[7]->getValue();

            if ($gateType && $base && $surface) {

                $dataToSave[] = [
                    'UF_AVAILABLE' => $available,
                    'UF_GATE' => $gateTypes[$gateType],
                    'UF_BASE' => $bases[$base],
                    'UF_SURFACE' => $surfaces[strtolower($surface)],
                    'UF_WIDTH' => $width,
                    'UF_HEIGHT' => $height,
                    'UF_PRICE' => $price
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

        <input type="file" name="excel">

        <button type="submit" class="ui-btn ui-btn-success">Парсить</button>

    </form>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>