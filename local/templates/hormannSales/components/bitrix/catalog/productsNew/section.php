<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 */

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

$arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y",
    "GLOBAL_ACTIVE" => "Y",
    //"ID" => $arResult['VARIABLES']['SECTION_ID'],
    "CODE" => $arResult['VARIABLES']['SECTION_CODE'],
);
$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
    $arCurSection = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    $arCurSection = array();
    if (Loader::includeModule("iblock")) {
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID", "NAME", "DESCRIPTION", "PICTURE", "UF_*"));

        if (defined("BX_COMP_MANAGED_CACHE")) {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");

            if ($arCurSection = $dbRes->Fetch())
                $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);

            $CACHE_MANAGER->EndTagCache();
        } else {
            if (!$arCurSection = $dbRes->Fetch())
                $arCurSection = array();
        }
    }

    $obCache->EndDataCache($arCurSection);
}
$page = \Itech\PageService::getInstance()->get('/products/');

Loader::includeModule("highloadblock");

$arFileTmp = CFile::ResizeImageGet(
    $page->UF_TYPE_FILE,
    array("width" => 297, "height" => 291),
    BX_RESIZE_IMAGE_PROPORTIONAL,
    true,
    false
);

if ($arCurSection['UF_LEND']) {
    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/section_lend.php");
//} elseif ($arCurSection['UF_WITHOUT_LISTING']) {
//    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/section_without_listing.php");
} elseif ($arCurSection['UF_ARTICLE']) {
    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/section_article.php");
} else {
    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/section_common.php");
}
