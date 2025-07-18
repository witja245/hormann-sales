<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$sections = [];
foreach ($arResult['SECTIONS'] as $item) {
    $sections[$item['ID']] = $item['ID'];
}

$res = CIBlockElement::GetList([],['IBLOCK_ID' => $arParams['IBLOCK_ID']]);
unset($sections);
while ($element = $res->GetNext()){
    $sections[$element['IBLOCK_SECTION_ID']][] = $element;
}
$setSections = [];
foreach ($sections as $key => $section){
    if (count($section)){
        $setSections[] = $key;
    }
}
foreach ($arResult['SECTIONS'] as $key => $item) {
    if (!in_array($item['ID'],$setSections)){
        unset($arResult['SECTIONS'][$key]);
    }
}