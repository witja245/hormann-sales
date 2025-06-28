<?php


namespace Itech;


class Search
{

    public static function search(string $q): array
    {
        \Bitrix\Main\Loader::includeModule('search');

        $arGoodsId = [];
        // для дальшейшего поиска разделов
        $arSearchesId = [];

        $obSearch = new \CSearch();
        $obSearch->Search([
            "SITE_ID" => SITE_ID,
            "QUERY" => $q,
            "MODULE_ID" => "iblock",
            "!ITEM_ID" => array("S%"),
            "PARAM1" => 'catalog',],
            []);

        if ($obSearch->errorno == 0) {
            $catalogs = Helper::getIblockIds('catalog');
            if ($catalogs) {
                while ($ar = $obSearch->Fetch()) {
                    if ($ar['ITEM_ID'][0] != 'S' && in_array($ar['PARAM2'], $catalogs)) {
                        $arGoodsId[] = $ar['ITEM_ID'];
                        $arSearchesId[] = $ar['ID'];
                    }
                }
            }
        }

        if ($arGoodsId) {
            $sections = [];
            $connection = \Bitrix\Main\Application::getConnection();
            $sql = "SELECT PARAM_VALUE FROM b_search_content_param WHERE PARAM_NAME='iblock_section' AND SEARCH_CONTENT_ID IN (" . implode(',', $arSearchesId) . ")";
            $recordset = $connection->query($sql);
            while ($record = $recordset->fetch()) {
                $sections[] = $record['PARAM_VALUE'];
            }
        }

        return [
            'SECTIONS' => $sections,
            'ELEMENTS' => $arGoodsId
        ];
    }
}