<?php

namespace Itech;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\PropertyTable;
use Itech\PageService;
use Itech\TabProp;
use Itech\Location;

/**
 * Class Event для обработчиков событий Битрикс
 * @package Itech
 */
class Event
{
    public static function tabPropHandler()
    {
        $tabset = new TabProp();
        return [
            'TABSET' => 'custom_props',
            'Check' => [$tabset, 'check'],
            'Action' => [$tabset, 'action'],
            'GetTabs' => [$tabset, 'getTabList'],
            'ShowTab' => [$tabset, 'showTabContent'],
        ];
    }

    public static function beforePrologHandler()
    {
        global $APPLICATION;

        if (defined('ERROR_404') && ERROR_404 != 'Y' && !isset($_SERVER['REAL_FILE_PATH'])) {
            PageService::getInstance()->init();
        }

        $context = \Bitrix\Main\Application::getInstance()->getContext();

        $request = $context->getRequest();

        $response = $context->getResponse();

        if ($value = $request->get("setCity")) {

            Location::setCity(intval($value));

            $redirectUrl = $APPLICATION->GetCurPageParam("", ['setCity']);

            LocalRedirect($redirectUrl);
        }
    }

    public static function beforeUserAddHandler(&$arFields)
    {
        if ($arFields['ID'] == 1) return;
        if ($arFields["EMAIL"]) {
            $arFields["LOGIN"] = $arFields["EMAIL"];
        }
    }

    public static function beforeUserRegisterHandler(&$args)
    {
        if ($args['ID'] == 1) return;
        if ($args["EMAIL"]) {
            $args["LOGIN"] = $args["EMAIL"];
        }

        return $args;
    }

    /**
     * Обновляет рейтинг у товара в том случае, когда отзыв на него прошел модерацию и был активирован
     * @param $arFields
     * @return false
     */
    public static function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == IBLOCK_ID_REVIEWS) {
            $propertyDb = PropertyTable::getList([
                'filter' => ['CODE' => 'PRODUCT', 'IBLOCK_ID' => $arFields['IBLOCK_ID']],
                'select' => ['ID']])->fetchObject();
            if (!$propertyDb) {
                return false;
            }
            $propertyId = $propertyDb->getId();

            $productId = $arFields['PROPERTY_VALUES'][$propertyId][$arFields['ID'] . ':' . $propertyId]['VALUE'];

            $propertyDb = PropertyTable::getList([
                'filter' => ['CODE' => 'RATING_VALUE', 'IBLOCK_ID' => $arFields['IBLOCK_ID']],
                'select' => ['ID']])->fetchObject();
            if (!$propertyDb) {
                return false;
            }
            $propertyId = $propertyDb->getId();
            $ratingValue = (int)$arFields['PROPERTY_VALUES'][$propertyId][$arFields['ID'] . ':' . $propertyId]['VALUE'];
            $productDb = \CIblockElement::getList([], ['ID' => $productId], false, false, ['ID', 'IBLOCK_ID', 'PROPERTY_RATING', 'PROPERTY_RATING_AVG', 'PROPERTY_RATING_COUNT'])->fetch();

            $ratingObj = (array)json_decode($productDb['PROPERTY_RATING_VALUE']);
            $ratingCount = (int)$productDb['PROPERTY_RATING_COUNT_VALUE'];
            if ($arFields['ACTIVE'] == 'Y') {
                // добавляем рейтинг
                if (!$ratingObj) {
                    $ratingObj = [
                        '5e' => 0,
                        '4e' => 0,
                        '3e' => 0,
                        '2e' => 0,
                        '1e' => 0
                    ];
                    $ratingObj[strval($ratingValue) . 'e'] = 1;
                } else {
                    $ratingObj[strval($ratingValue) . 'e'] = $ratingObj[strval($ratingValue) . 'e'] + 1;
                }
                $ratingCount += 1;
            } else {
                if ($ratingObj[strval($ratingValue) . 'e']) {
                    $ratingObj[strval($ratingValue) . 'e'] = $ratingObj[strval($ratingValue) . 'e'] - 1;
                } else {
                    $ratingObj[strval($ratingValue) . 'e'] = 0;
                }
                if ($ratingCount) {
                    $ratingCount -= 1;
                }
            }

            $ratingAvg = 0;
            if ($ratingCount != 0) {
                foreach ($ratingObj as $key => $value) {
                    $ratingAvg += $key * $value;
                }
                $ratingAvg = round($ratingAvg / $ratingCount, 1);
            }

            $ratingObj = json_encode($ratingObj);
            \CIBlockElement::SetPropertyValuesEx($productId, $productDb['IBLOCK_ID'], array('RATING' => $ratingObj));
            \CIBlockElement::SetPropertyValuesEx($productId, $productDb['IBLOCK_ID'], array('RATING_COUNT' => $ratingCount));
            \CIBlockElement::SetPropertyValuesEx($productId, $productDb['IBLOCK_ID'], array('RATING_AVG' => $ratingAvg));
        }
    }

    public static function OnBeforeIndexHandler($arFields)
    {
        if ($arFields["MODULE_ID"] == "iblock") {
            $itemID = $arFields['ITEM_ID'];
            $elementDb = ElementTable::getList([
                'filter' => ['ID' => $itemID],
                'select' => ['ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID']
            ])->fetchObject();
            if ($elementDb) {
                $iblockSectionId = $elementDb->getIblockSectionId();
                $arFields["PARAMS"]["iblock_section"][] = $iblockSectionId;
            }
        }

        return $arFields;
    }

    public static function OnCompleteCatalogImport1C($arParams, $ABS_FILE_NAME)
    {
        \Bitrix\Main\Loader::includeModule('highloadblock');
        $code = 'Imports1c';
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['NAME' => $code]])->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $hlEntity = $entity->getDataClass();
        $hlEntity::add([
            'UF_DATE' => new \Bitrix\Main\Type\DateTime()
        ]);
    }

    public static function modifyAdminMenu(&$adminMenu, &$moduleMenu)
    {
//        $moduleMenu[] = array(
//            "parent_menu" => "global_menu_content",
//            "section" => "",
//            "sort" => 1,
//            "url" => "/bitrix/admin/price-parser.php?lang=" . LANG,
//            "text" => 'Парсер прайса ворот',
//            "title" => 'Парсер прайса ворот',
//            "icon" => "fav_menu_icon_yellow",
//            "page_icon" => "fav_menu_icon_yellow",
//            "items_id" => "menu_parser",
//            "items" => array()
//        );

//        $moduleMenu[] = array(
//            "parent_menu" => "global_menu_content",
//            "section" => "",
//            "sort" => 1,
//            "url" => "/bitrix/admin/color-parser.php?lang=" . LANG,
//            "text" => 'Парсер цветов',
//            "title" => 'Парсер цветов',
//            "icon" => "fav_menu_icon_yellow",
//            "page_icon" => "fav_menu_icon_yellow",
//            "items_id" => "menu_parser",
//            "items" => array()
//        );

        $moduleMenu[] = array(
            "parent_menu" => "global_menu_content",
            "section" => "Импорт товаров",
            "sort" => 11,
            "url" => "/bitrix/admin/goods-parser.php?lang=" . LANG,
            "text" => 'Импорт товаров из таблицы Excel',
            "title" => 'Импорт товаров',
            "icon" => "fav_menu_icon_yellow",
            "page_icon" => "fav_menu_icon_yellow",
            "items_id" => "menu_parser",
            "items" => array()
        );
    }
}
