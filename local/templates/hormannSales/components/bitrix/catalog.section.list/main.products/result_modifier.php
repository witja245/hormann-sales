<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$home = ['NAME' => 'Для дома'];
$business = ['NAME' => 'Для бизнеса'];
foreach ($arResult['SECTIONS'] as $item){
    if ($item['UF_HOME'])
        $home['ITEMS'][] = $item;
    if ($item['UF_BUSINESS'])
        $business['ITEMS'][] = $item;
}
$architect = [
    'NAME' => 'Архитекторам',
    'ITEMS' => $arResult['SECTIONS']
];
$arResult['SECTIONS'] = [];
$arResult['SECTIONS'][0] = $home;
$arResult['SECTIONS'][1] = $business;
//$arResult['SECTIONS'][2] = $architect;