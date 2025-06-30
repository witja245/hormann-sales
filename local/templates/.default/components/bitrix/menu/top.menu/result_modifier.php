<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 * @var array $arParams
 */


if ($arResult) {
    if (\CModule::includeModule('iblock')) {
        $sections = [];
        $req = \CIBlockSection::GetList(
            ['SORT' => 'ASC'],
            [
                'ACTIVE' => 'Y',
                'IBLOCK_ID' => 33,
                
            ],
            false,
            [
                'ID',
                'NAME',
                'IBLOCK_SECTION_ID',
                'DEPTH_LEVEL',
                'UF_HOME',
                'UF_BUSINESS',
                'CODE',
                'IBLOCK_ID',
                'SECTION_PAGE_URL',
                'SORT'
            ]
        );
        while ($res = $req->GetNext(true, false)) {
            $sections[$res['ID']] = $res;
        }
        function buildTree($sections)
        {
            $tree = [];

            // Сначала создаём плоский массив с указанием родительских разделов
            foreach ($sections as $id => $section) {
                $sections[$id]['CHILDREN'] = []; // Инициализируем массив для дочерних разделов
            }

            // Строим дерево
            foreach ($sections as $id => $section) {
                if ($section['IBLOCK_SECTION_ID']) {
                    // Если у раздела есть родитель, добавляем его в CHILDREN родителя
                    $sections[$section['IBLOCK_SECTION_ID']]['CHILDREN'][] = &$sections[$id];
                } else {
                    // Если это корневой раздел, добавляем его в дерево
                    $tree[] = &$sections[$id];
                }
            }

            return $tree;
        }

        $treeSectionsMenu = buildTree($sections);


        foreach ($arResult as $key => $result){
            if ($result['PARAMS']['PRODUCTS'] == 'Y'){
                $arResult[$key]['PARENT'] = $treeSectionsMenu;
            }
        }


        $arResult = ['ITEMS' => $arResult];

    }
}