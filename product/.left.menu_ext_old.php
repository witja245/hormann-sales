<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use classes\CAllcorp3;
$aMenuLinksExt = array();
$arMenuParametrs = [
    "MENU"=>"Y",
    "MENU_SHOW_ELEMENTS"=>"N",
    "MENU_SHOW_SECTIONS"=>"Y",
];
if($arMenuParametrs)
{
    tl($arMenuParametrs, '$arMenuParametrs');
    $iblock_id = 33;
    $arExtParams = array(
        'IBLOCK_ID' => $iblock_id,
        'MENU_PARAMS' => $arMenuParametrs,
        'SECTION_FILTER' => array('UF_MENU_HIDDEN' => false),	// пользовательский фильтр для разделов (через array_merge)
        'SECTION_SELECT' => array(),	// пользовательский выбор разделов (через array_merge)
        'ELEMENT_FILTER' => array(),	// пользовательский фильтр для элементов (через array_merge)
        'ELEMENT_SELECT' => array(),	//пользовательский выбор элементов (через array_merge)
        'MENU_TYPE' => 'catalog',
    );

    CAllcorp3::getMenuChildsExt($arExtParams, $aMenuLinksExt);
}



$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

?>