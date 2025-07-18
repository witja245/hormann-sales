<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

$type = [];
$material = [];
foreach ($arResult['ITEMS'] as $item) {
    $type[$item['PROPERTIES']['TYPE']['VALUE']] = $item['PROPERTIES']['TYPE']['VALUE'];
    $material[$item['PROPERTIES']['MATERIAL']['VALUE']] = $item['PROPERTIES']['MATERIAL']['VALUE'];
}

$type = array_unique($type);
$material = array_unique($material);

Loader::includeModule("highloadblock");

$hlblock = HL\HighloadBlockTable::getById(HL_TYPE)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();

$filter = array(
    "filter" => ['UF_XML_ID' => $type],
    "select" => array("*"),
    "order" => array(),
);

$rsData = $entity_data_class::getList($filter);

$result = false;

$arType = [];
while ($data = $rsData->fetch()) {
    $arType[$data['UF_XML_ID']] = $data['UF_NAME'];
}

$hlblock = HL\HighloadBlockTable::getById(HL_MATERIAL)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();

$filter = array(
    "filter" => ['UF_XML_ID' => $material],
    "select" => array("*"),
    "order" => array(),
);

$rsData = $entity_data_class::getList($filter);

$result = false;

$arMaterial = [];
while ($data = $rsData->fetch()) {
    $arMaterial[$data['UF_XML_ID']] = $data['UF_NAME'];
}

foreach ($arResult['ITEMS'] as &$item) {
    $item['PROPERTIES']['TYPE']['VALUE'] = $arType[$item['PROPERTIES']['TYPE']['VALUE']];
    $item['PROPERTIES']['MATERIAL']['VALUE'] = $arMaterial[$item['PROPERTIES']['MATERIAL']['VALUE']];
    $price = [];
    foreach ($item['OFFERS'] as $offer) {
        $price[] = $offer['PRICES']['BASE']['VALUE'];
    }
    $item['PROPERTIES']['MIN_PRICE'] = min($price);
    $item['PROPERTIES']['MIN_PRICE'] = strrev($item['PROPERTIES']['MIN_PRICE']);
    $item['PROPERTIES']['MIN_PRICE'] = chunk_split($item['PROPERTIES']['MIN_PRICE'], 3, ' ');
    $item['PROPERTIES']['MIN_PRICE'] = strrev($item['PROPERTIES']['MIN_PRICE']);
}