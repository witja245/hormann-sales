<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

$rsOffers = CIBlockElement::GetList(array(),array('IBLOCK_ID' => 36, 'PROPERTY_71' => $arResult['ITEM']['ID']));
$colorId = [];
$gofrId = [];
$driveUnit = [];
while ($element = $rsOffers->GetNextElement()){
    $properties = $element->GetProperties();
    $colorId[$properties['COLOR']['VALUE']] = $properties['COLOR']['VALUE'];
    $gofrId[$properties['GOFR']['VALUE']] = $properties['GOFR']['VALUE'];
    $driveUnit[$properties['DRIVE_UNIT']['VALUE']] = $properties['DRIVE_UNIT']['VALUE'];
}

Loader::includeModule("highloadblock");

$hlblock = HL\HighloadBlockTable::getById(HL_COLORS)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();

$filter = array(
    "filter" => ['UF_XML_ID' => $colorId],
    "select" => array("*"),
    "order" => array(),
);

$rsData = $entity_data_class::getList($filter);

$result = false;

$countColor = 0;
while ($data = $rsData->fetch()) {
    $countColor++;
}
if ($countColor>0){
    $strColor = $countColor . ' цвет' . Itech\Helper::getDecNum($countColor,['','а','ов']);
} else {
    $strColor = false;
}

$hlblock = HL\HighloadBlockTable::getById(HL_GOFR)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();

$filter = array(
    "filter" => ['UF_XML_ID' => $gofrId],
    "select" => array("*"),
    "order" => array(),
);

$rsData = $entity_data_class::getList($filter);

$result = false;

$strGofr = '';
while ($data = $rsData->fetch()) {
    $strGofr .= $data['UF_NAME'] . ', ';
}
$strGofr = substr($strGofr, 0, strlen($strGofr) - 2);

$strDriveUnit = '';
foreach ($driveUnit as $item){
    $strDriveUnit .= $item . ', ';
}
$strDriveUnit = substr($strDriveUnit, 0, strlen($strDriveUnit)-2);
$arResult['GOFR_STR'] = $strGofr;
$arResult['COLOR_STR'] = $strColor;
$arResult['DRIVE_UNIT'] = $strDriveUnit;