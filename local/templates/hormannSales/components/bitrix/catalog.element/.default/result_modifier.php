<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

Loader::includeModule("highloadblock");


//material
$hlblock = HL\HighloadBlockTable::getById(HL_MATERIAL)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();

$filter = array(
    "filter" => ['UF_XML_ID' => $arResult['PROPERTIES']['MATERIAL']['VALUE']],
    "select" => array("*"),
    "order" => array(),
);

$rsData = $entity_data_class::getList($filter);

if ($data = $rsData->fetch()) {
    $arResult['PROPERTIES']['MATERIAL']['VALUE'] = $data['UF_NAME'];
}

//size
$size = [];
$glazing = [];
$color = [];
foreach ($arResult['OFFERS'] as $offer){
    $size[$offer['PROPERTIES']['SIZE']['VALUE']] = $offer['PROPERTIES']['SIZE']['VALUE'];
    $glazing[$offer['PROPERTIES']['GLAZING']['VALUE']] = $offer['PROPERTIES']['GLAZING']['VALUE'];
    $color[$offer['PROPERTIES']['COLOR']['VALUE']] = $offer['PROPERTIES']['COLOR']['VALUE'];
}

$hlblock = HL\HighloadBlockTable::getById(HL_SIZE)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();

$filter = array(
    "filter" => ['UF_XML_ID' => $size],
    "select" => array("*"),
    "order" => array(),
);

$rsData = $entity_data_class::getList($filter);

$maxSize = '';
$sizeTmp = '';
while ($data = $rsData->fetch()) {
    $data['SIZE'] = explode(' x ', $data['UF_NAME']);
    $temp = $data['SIZE'][0]*$data['SIZE'][1];
    if ($maxSize<$temp){
        $maxSize = $temp;
        $sizeTmp = $data['UF_NAME'];
    }
}
$arResult['PROPERTIES']['SIZE']['VALUE'] = $sizeTmp;

//glazing

function getHLProps($arFilter, $iblockId, $flag=false)
{
    $hlblock = HL\HighloadBlockTable::getById($iblockId)->fetch();

    $entity = HL\HighloadBlockTable::compileEntity($hlblock);

    $entity_data_class = $entity->getDataClass();

    $filter = array(
        "filter" => ['UF_XML_ID' => $arFilter],
        "select" => array("*"),
        "order" => array(),
    );

    $rsData = $entity_data_class::getList($filter);

    $result = [];
    while ($data = $rsData->fetch()) {

        if (!$flag) {
            $result[$data['UF_XML_ID']] = $data['UF_NAME'];
        }
        else {
            $result[$data['UF_XML_ID']] = $data;
        }
    }
    return $result;
}


$arColor = getHLProps($color, HL_COLORS, true);
$arGlazing = getHLProps($glazing, HL_GLAZING, true);

$files = [];
foreach ($arGlazing as $item) {
    $files[] = $item['UF_IMG'];
}
$filesDB = [];
$res = \Bitrix\Main\FileTable::GetList([
    'filter' => ['ID' => $files],
    'select' => ['ID', 'FILE_SIZE', 'SUBDIR', 'FILE_NAME', 'SRC'],
    'runtime' => [
        new Entity\ExpressionField('SRC',
            'CONCAT("/upload/", %s, "/", %s)', ['SUBDIR', 'FILE_NAME']
        )
    ]
]);
while ($filesRes = $res->fetch()) {
    $filesDB[$filesRes['ID']] = $filesRes;
}
foreach ($filesDB as &$item) {
    $item['EXTENSION'] = pathinfo($item['SRC'])['extension'];
    $item['FILE_SIZE'] = CFile::FormatSize($item['FILE_SIZE']);
    $item['WIDTH'] = getimagesize($_SERVER['DOCUMENT_ROOT'].$item['SRC'])[0];
}
unset($item);

foreach ($arGlazing as &$item){
    $item['PICTURE'] = $filesDB[$item['UF_IMG']];
}
unset($item);

$arResult['GLAZING'] = $arGlazing;

$files = [];
foreach ($arColor as $item) {
    $files[] = $item['UF_IMG'];
}
$filesDB = [];

$res = \Bitrix\Main\FileTable::GetList([
    'filter' => ['ID' => $files],
    'select' => ['ID', 'FILE_SIZE', 'SUBDIR', 'FILE_NAME', 'SRC'],
    'runtime' => [
        new Entity\ExpressionField('SRC',
            'CONCAT("/upload/", %s, "/", %s)', ['SUBDIR', 'FILE_NAME']
        )
    ]
]);
while ($filesRes = $res->fetch()) {
    $filesDB[$filesRes['ID']] = $filesRes;
}

foreach ($filesDB as &$item) {
    $item['EXTENSION'] = pathinfo($item['SRC'])['extension'];
    $item['FILE_SIZE'] = CFile::FormatSize($item['FILE_SIZE']);
    $item['WIDTH'] = getimagesize($_SERVER['DOCUMENT_ROOT'].$item['SRC'])[0];
}
unset($item);

foreach ($arColor as &$item){
    $item['PICTURE'] = $filesDB[$item['UF_IMG']];
}
unset($item);

$arResult['COLORS'] = $arColor;