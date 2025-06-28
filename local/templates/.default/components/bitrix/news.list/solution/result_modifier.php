<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php

$arTemp = array();

foreach($arResult["ITEMS"] as $item) {
    if($item["PREVIEW_PICTURE"]) {
        $arTemp["TOP"][] = $item;
    }
    else {
        $arTemp["TEXT"][] = $item;
    }
}

$arResult["ITEMS"] = $arTemp;


$dbSection = CIBlockSection::GetList(Array(), array("ID" => $arParams["PARENT_SECTION"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, Array("UF_TEXT"));
if($arSection = $dbSection->GetNext()){
    $arResult["SECTION"] = $arSection;
}

?>
