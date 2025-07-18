<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?
$sections = [];
foreach ($arResult['SECTIONS'] as $item){
    if ($item['DEPTH_LEVEL']=='1'){
        $sections[$item['ID']]['NAME'] = $item['NAME'];
        $sections[$item['ID']]['CODE'] = $item['CODE'];
        $sections[$item['ID']]['SECTION_PAGE_URL'] = $item['SECTION_PAGE_URL'];
        $sections[$item['ID']]['PICTURE'] = CFile::GetPath($item['PICTURE']['ID']);
        continue;
    }
    $sections[$item['IBLOCK_SECTION_ID']]['ITEMS'][$item['ID']]['NAME'] = $item['NAME'];
    $sections[$item['IBLOCK_SECTION_ID']]['ITEMS'][$item['ID']]['CODE'] = $item['CODE'];
    $sections[$item['IBLOCK_SECTION_ID']]['ITEMS'][$item['ID']]['SECTION_PAGE_URL'] = $item['SECTION_PAGE_URL'];
    $sections[$item['IBLOCK_SECTION_ID']]['ITEMS'][$item['ID']]['PICTURE'] = CFile::GetPath($item['PICTURE']['ID']);
}
$arResult['SECTIONS'] = $sections;
?>
