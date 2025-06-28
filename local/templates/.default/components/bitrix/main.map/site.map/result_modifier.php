<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 */
array_unshift($arResult['arMapStruct'], ['NAME' => 'Главная страница', 'FULL_PATH' => '/']);
$arResult['arMapStruct'] = \Itech\Helper::getUniqueArray('FULL_PATH', $arResult['arMapStruct']);
foreach ($arResult['arMapStruct'] as $key_parent => $parent) {
    if ($parent['FULL_PATH'] == '/site-map/') {
        unset($arResult['arMapStruct'][$key_parent]);
    }
    if ($parent['FULL_PATH'] == '/products/') {
        $res = \Itech\Helper::buildSectionsStructureFull();
        $arResult['arMapStruct'][$key_parent]['CHILDREN'] = $res;
    }
    if ($parent['FULL_PATH'] == '/share/') {
        $res = \Itech\Helper::buildElementsStructureFull(IBLOCK_ID_SHARE);
        $arResult['arMapStruct'][$key_parent]['CHILDREN'] = $res;
    }
    foreach ($parent['CHILDREN'] as $key_child => $child) {
        if ($child['FULL_PATH'] == $parent['FULL_PATH']) {
            unset($arResult['arMapStruct'][$key_parent]['CHILDREN'][$key_child]);
        }
    }
}

if (!function_exists('GetSiteMap')) {
    function GetSiteMap($arr)
    {
        $tree = '<ul>';
        
        foreach ($arr as $item) {
            $tree .= '<li><a href="' . $item['FULL_PATH'] . '" target="_blank">' . $item['NAME'] . '</a>';
            if ( $item['CHILDREN'][0] > 0) {
                $tree .= GetSiteMap($item['CHILDREN']);
            }
        }
        $tree .= '</ul>';
        return $tree;
    }
}