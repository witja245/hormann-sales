<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$sections = [];

foreach ($arResult['ITEMS'] as $item){
    $sections[] = $item['IBLOCK_SECTION_ID'];
}

$sections = array_unique($sections);

$sectionName = [];
foreach ($sections as $item){
    $res = CIBlockSection::GetByID($item)->GetNext();
    $sectionName[$res['ID']]['NAME']=$res['NAME'];
    $sectionName[$res['ID']]['CODE']=$res['CODE'];
}

foreach ($arResult['ITEMS'] as $item){
    $sectionName[$item['IBLOCK_SECTION_ID']]['ITEMS'][] = $item;
}

$arResult['ITEMS'] = $sectionName;

