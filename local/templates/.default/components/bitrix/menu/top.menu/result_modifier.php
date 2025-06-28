<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 * @var array $arParams
 */
if ($arResult) {
    if (\CModule::includeModule('iblock')) {
        $req = \CIBlockSection::GetList(
            ['SORT' => 'ASC'],
            [
                'ACTIVE' => 'Y',
                'IBLOCK_ID' => IBLOCK_ID_CATALOG,
                '<DEPTH_LEVEL' => 3,
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
            $res['TEXT'] = $res['NAME'];
            $res['LINK'] = $res['SECTION_PAGE_URL'];
            if ($res['DEPTH_LEVEL'] == 1) {
                $parents[$res['ID']] = $res;
            } else {
                $children[] = $res;
                if ($res['UF_HOME']) {
                    $forHome[] = $res['ID'];
                }
                if ($res['UF_BUSINESS']) {
                    $forBusiness[] = $res['ID'];
                }
            }
        }
        foreach ($children as $child) {
            if ($parents[$child['IBLOCK_SECTION_ID']]) {
                if (in_array($child['ID'], $forHome)) {
                    $parents[$child['IBLOCK_SECTION_ID']]['FOR_HOME'][] = $child;
                }
                if (in_array($child['ID'], $forBusiness)) {
                    $parents[$child['IBLOCK_SECTION_ID']]['FOR_BUSINESS'][] = $child;
                }
            }
        }
        foreach ($arResult as $key => $value) {
            foreach ($parents as $parent) {
                if ($parent['FOR_HOME']) {
                    if ($value['PARAMS']['LOWER'] == 'FOR_HOME') {
                        $arResult[$key]['LOWER_ITEMS'][] = $parent;
                    }
                }
                if ($parent['FOR_BUSINESS']) {
                    if ($value['PARAMS']['LOWER'] == 'FOR_BUSINESS') {
                        $arResult[$key]['LOWER_ITEMS'][] = $parent;
                    }
                }
            }
        }
        $arResult = ['ITEMS' => $arResult];
        if ($arParams['SETTINGS']) {
            if ($arParams['SETTINGS']['UF_FOR_HOME_PICTURE']) {
                $arResult['IMAGES']['FOR_HOME']['SRC'] = \CFile::GetPath($arParams['SETTINGS']['UF_FOR_HOME_PICTURE']);
            }
            if ($arParams['SETTINGS']['UF_FOR_BUSINESS_PICTURE']) {
                $arResult['IMAGES']['FOR_BUSINESS']['SRC'] = \CFile::GetPath($arParams['SETTINGS']['UF_FOR_BUSINESS_PICTURE']);
            }
            if ($arParams['SETTINGS']['UF_FOR_HOME_TEXT']) {
                $arResult['IMAGES']['FOR_HOME']['TEXT'] = $arParams['SETTINGS']['UF_FOR_HOME_TEXT'];
            }
            if ($arParams['SETTINGS']['UF_FOR_BUSINESS_TEXT']) {
                $arResult['IMAGES']['FOR_BUSINESS']['TEXT'] = $arParams['SETTINGS']['UF_FOR_BUSINESS_TEXT'];
            }
            if ($arParams['SETTINGS']['UF_FOR_HOME_RECS']) {
                $req = \CIBlockElement::GetList(
                    ['SORT' => 'ASC',],
                    ['IBLOCK_ID' => IBLOCK_ID_CATALOG, 'ACTIVE' => 'Y', 'ID' => $arParams['SETTINGS']['UF_FOR_HOME_RECS']]
                );
                while ($res = $req->GetNextElement()) {
                    $element = $res->GetFields();
                    $forHomeRecs[] = [
                        'TEXT' => $element['NAME'],
                        'LINK' => $element['DETAIL_PAGE_URL'],
                    ];
                }
            }
            if ($arParams['SETTINGS']['UF_FOR_BUSINESS_RECS']) {
                $req = \CIBlockElement::GetList(
                    ['SORT' => 'ASC',],
                    ['IBLOCK_ID' => IBLOCK_ID_CATALOG, 'ACTIVE' => 'Y', 'ID' => $arParams['SETTINGS']['UF_FOR_BUSINESS_RECS']]
                );
                while ($res = $req->GetNextElement()) {
                    $element = $res->GetFields();
                    $forBusinessRecs[] = [
                        'TEXT' => $element['NAME'],
                        'LINK' => $element['DETAIL_PAGE_URL'],
                    ];
                }
            }
            $arResult['RECS'] = ['FOR_BUSINESS' => $forBusinessRecs, 'FOR_HOME' => $forHomeRecs];
        }
    }
}