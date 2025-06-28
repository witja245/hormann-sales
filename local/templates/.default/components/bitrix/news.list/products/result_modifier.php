<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$sections = [];
foreach ($arResult['ITEMS'] as $item) {
    $sections[] = $item['IBLOCK_SECTION_ID'];
}
$sections = array_unique($sections);

$sectionName = [];
foreach ($sections as $item) {
    $res = CIBlockSection::GetByID($item)->GetNext();
    $sectionName[$res['ID']]['NAME'] = $res['NAME'];
    $sectionName[$res['ID']]['CODE'] = $res['CODE'];
    $sectionName[$res['ID']]['SECTION_PAGE_URL'] = $res['SECTION_PAGE_URL'];
    $sectionName[$res['ID']]['PICTURE'] = CFile::GetPath($res['PICTURE']);
}

foreach ($arResult['ITEMS'] as $item) {
    $sectionName[$item['IBLOCK_SECTION_ID']]['ITEMS'][] = $item;
}

$arResult['SECTIONS'] = $sectionName;
unset($arResult['ITEMS']);