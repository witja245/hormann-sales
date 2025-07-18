<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

Loader::includeModule("highloadblock");

function getHLProps($arFilter, $iblockId)
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

        if ($iblockId!=9) {
            $result[$data['UF_XML_ID']] = $data['UF_NAME'];
        }
        else {
            $result[$data['UF_XML_ID']] = $data;
        }
    }
    return $result;
}

$arFileTmp = CFile::ResizeImageGet(
    $arResult["PREVIEW_PICTURE"]["ID"],
    array("width" => 800, "height" => 752),
    BX_RESIZE_IMAGE_EXACT,
    true,
    false
);
$arResult["PREVIEW_PICTURE"]["SRC"] = $arFileTmp['src'];

//свойства торговых предложений
$color = [];
$gofr = [];
$surface = [];
$glazing = [];
$price = [];

foreach ($arResult['OFFERS'] as $item) {
    $color[$item['PROPERTIES']['COLOR']['VALUE']] = $item['PROPERTIES']['COLOR']['VALUE'];
    $gofr[$item['PROPERTIES']['GOFR']['VALUE']] = $item['PROPERTIES']['GOFR']['VALUE'];
    $surface[$item['PROPERTIES']['SURFACE']['VALUE']] = $item['PROPERTIES']['SURFACE']['VALUE'];
    $glazing[$item['PROPERTIES']['GLAZING']['VALUE']] = $item['PROPERTIES']['GLAZING']['VALUE'];
    $price[] = $item['PRICES']['BASE']['VALUE'];
}

$color = array_unique($color);
$gofr = array_unique($gofr);
$surface = array_unique($surface);
$glazing = array_unique($glazing);
$price = min($price);

$arColor = getHLProps($color, HL_COLORS);
$arGofr = getHLProps($gofr, HL_GOFR);
$arSurface = getHLProps($surface, HL_SURFACE);
$arGlazing = getHLProps($glazing, HL_GLAZING);

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

foreach ($arGlazing as &$item){
    $item['PICTURE'] = $filesDB[$item['UF_IMG']];
}

var_dump($arColor);

$arResult['OFFERS_PROPS'] = [
    'COLOR' => $arColor,
    'GOFR' => $arGofr,
    'SURFACE' => $arSurface,
    'GLAZING' => $arGlazing,
    'PRICE' => $price,
];

//свойтсва товара
$type = [];
$material = [];

$type[$arResult['PROPERTIES']['TYPE']['VALUE']] = $arResult['PROPERTIES']['TYPE']['VALUE'];
$material[$arResult['PROPERTIES']['MATERIAL']['VALUE']] = $arResult['PROPERTIES']['MATERIAL']['VALUE'];

$arType = getHLProps($type, HL_TYPE);
$arMaterial = getHLProps($material, HL_MATERIAL);

$arResult['PROPERTIES']['TYPE']['VALUE'] = $arType[$arResult['PROPERTIES']['TYPE']['VALUE']];
$arResult['PROPERTIES']['MATERIAL']['VALUE'] = $arMaterial[$arResult['PROPERTIES']['MATERIAL']['VALUE']];