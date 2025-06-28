<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$getiblock = CIBlockSection::GetList(
    Array("SORT"=>"ASC"),
    Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], 'ACTIVE'=>'Y')
);

while($sectionwhile = $getiblock->GetNext())
{
    $arS[] = $sectionwhile;
}

foreach($arS as $arSec){

    foreach($arResult["ITEMS"] as $key=>$arItem){

        if($arItem['IBLOCK_SECTION_ID'] == $arSec['ID']){
            $arSec['ELEMENTS'][] =  $arItem;
        }
    }

    $arElementGroups[] = $arSec;

}

$arResult['SECTIONS'] = $arS;
$arResult["ITEMS"] = $arElementGroups;

//$slider = [];
//$cities = [];
//foreach ($arResult['ITEMS'] as $key => $item){
//    $cities[$key] = $item['NAME'];
//    foreach ($item['PROPERTIES']['SLIDER']['VALUE'] as $slide){
//        $file = CFile::ResizeImageGet($slide, array('width' => 696, 'height' => 367), BX_RESIZE_IMAGE_PROPORTIONAL, true);
//        $slider[$key]['PICTURES'][] = $file['src'];
//    }
//    $slider[$key]['TITLE']=$item['PREVIEW_TEXT'];
//    $slider[$key]['TEXT']=$item['DETAIL_TEXT'];
//}
//
//$cities = array_chunk($cities, ((int)(count($cities)/2))?:1,true);
//$arResult['CITIES'] = $cities;
//$arResult['SLIDER'] = $slider;
