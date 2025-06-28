<?php

namespace Itech;

use Bitrix\Iblock\EO_Iblock;
use Bitrix\Iblock\EO_Section;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Loader;
use Bitrix\Iblock\EO_Section_Collection;

class Helper
{
    /**
     * Функция для получения элементов раздела инфоблока
     * @param $id - идентификатор раздела инфоблока
     * @return array - элементы раздела инфоблока
     */
    public static function getElementsByIBlockSectionID(int $id): array
    {
        $arSelect = array("ID", "NAME", "CODE", "LINK", "DETAIL_PAGE_URL", "IBLOCK_ID", "IBLOCK_SECTION_ID");
        $arFilter = array('SECTION_ID' => $id, 'ACTIVE' => 'Y');
        $elements = array();
        $elements_list = \CIBlockElement::GetList(array("SORT" => "DECS"), $arFilter, false, false, $arSelect);
        while ($element = $elements_list->GetNext()) {
            $elements[] = array(
                $element['NAME'],
                $element['DETAIL_PAGE_URL'],
                array(),
                array(),
                ''
            );
        }
        return $elements;
    }
    public static function getUniqueArray($key, $array)
    {
        $arrayKeys = array();
        $resultArray = array();
        foreach ($array as $one) {
            if (!in_array($one[$key], $arrayKeys)) {
                $arrayKeys[] = $one[$key];
                $resultArray[] = $one;
            }
        }
        return $resultArray;
    }
    public static function buildSectionsStructureFull($iblock_id = IBLOCK_ID_CATALOG)
    {
        $result = [];
        $sectionsReq = \CIBlockSection::GetList(
            [],
            ['ACTIVE' => 'Y', 'IBLOCK_ID' => $iblock_id, 'GLOBAL_ACTIVE' => 'Y',]
        );
        while ($sectionsRes = $sectionsReq->GetNext()) {
            $sectionsRes['FULL_PATH'] = $sectionsRes['SECTION_PAGE_URL'];
            $sections[] = $sectionsRes;
        }
        $depth_level = 25;
        while ($depth_level > 0) {
            foreach ($sections as $key => $parentItem) {
                if ($parentItem['DEPTH_LEVEL'] == $depth_level) {
                    foreach ($sections as $key2 => $childItem) {
                        if ($childItem['IBLOCK_SECTION_ID'] == $parentItem['ID']) {
                            $sections[$key]['CHILDREN'][] = $childItem;
                            unset($sections[$key2]);
                        }
                    }
                }
            }
            $depth_level--;
        }
        if ($sections) {
            $result = $sections;
        }
        return $result;
    }
    public static function buildElementsStructureFull($iblock_id = IBLOCK_ID_CATALOG)
    {
        $result = [];
        $sectionsReq = \CIBlockElement::GetList(
            [],
            ['ACTIVE' => 'Y', 'IBLOCK_ID' => $iblock_id, 'GLOBAL_ACTIVE' => 'Y',]
        );
        while ($sectionsRes = $sectionsReq->GetNext()) {
            $sectionsRes['FULL_PATH'] = $sectionsRes['DETAIL_PAGE_URL'];
            $sections[] = $sectionsRes;
        }
        $depth_level = 25;
        while ($depth_level > 0) {
            foreach ($sections as $key => $parentItem) {
                if ($parentItem['DEPTH_LEVEL'] == $depth_level) {
                    foreach ($sections as $key2 => $childItem) {
                        if ($childItem['IBLOCK_SECTION_ID'] == $parentItem['ID']) {
                            $sections[$key]['CHILDREN'][] = $childItem;
                            unset($sections[$key2]);
                        }
                    }
                }
            }
            $depth_level--;
        }
        if ($sections) {
            $result = $sections;
        }
        return $result;
    }

    public static function getHlEntityByCode(string $code): ?string
    {
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['NAME' => $code]])->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        return $entity->getDataClass();
    }

    public static function getHlList(string $hlEntity, array $select): array
    {
        $result = [];
        $dbList = $hlEntity::getList(['select' => $select]);
        while ($el = $dbList->fetch()) {
            $result[$el[$select[0]]] = $el[$select[1]];
        }
        return $result;
    }

    /**
     * Получение разделов по элементам инфоблока
     * @param array $arResult массив элементов например $arResult из news.list
     * @param array $sectionsIds массив id разделов
     * @param array $select массив с кода полей, которые нужно выбрать
     * @return array|null
     * @throws \Exception
     */
    public static function getSectionsForIblockElements(array $arResult = [], array $sectionsIds = [], array $select = ['ID', 'NAME', 'CODE']): ?array
    {
        if (!$sectionsIds) {
            $sectionsIds = [];
            foreach ($arResult as $item) {
                if (!array_key_exists('IBLOCK_SECTION_ID', $item)) {
                    throw new \Exception('У элемента нет IBLOCK_SECTION_ID: ' . print_r($item, 1));
                }
                $sectionsIds[] = $item['IBLOCK_SECTION_ID'];
            }
            $sectionsIds = array_unique($sectionsIds);
        }

        $sections = SectionTable::getList([
            'select' => $select,
            'filter' => ['ID' => $sectionsIds],
            'cache' => [
                'ttl' => 3600,
                'cache_joins' => true
            ]
        ])->fetchCollection()->getAll();

        $result = [];
        foreach ($sections as $section) {
            $result[$section->getId()] = $section;
        }

        return $result;
    }

    /**
     * Проверка на наличие товаров в корзине текущего пользователя
     * @return bool - наличие товаров в корзине
     * @throws \Bitrix\Main\ArgumentException
     */
    public static function isBasketEmpty(): bool
    {
        $basket = \Bitrix\Sale\Basket::getList([
            'select' => ['NAME', 'QUANTITY'],
            'filter' => [
                '=FUSER_ID' => \Bitrix\Sale\Fuser::getId(),
                '=ORDER_ID' => null,
                '=LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
                '=CAN_BUY' => 'Y',
            ]
        ]);

        return !($basket->getSelectedRowsCount());
    }

    /**
     * Функция для того, чтобы скрыть разделы от неавторизованного пользователя
     * @param string $section раздел, который надо скрыть
     * @param string $redirect_to url, на который будет перенаправлен неавторизованный пользователь
     */
    public static function forAuthorizedUser(string $section, string $redirect_to)
    {
        global $USER;
        $uri = \Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getRequestUri();
        if (strpos($uri, $section) !== false && !$USER->isAuthorized()) {
            LocalRedirect($redirect_to);
        }
    }

    /**
     * Получение последнего заказа текущего пользователя
     * @return array - ассоциативный массив с данными о последнем заказе пользователя
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public static function getLastUserOrder(): array
    {
        global $USER;
        $order = \Bitrix\Sale\Order::loadByFilter([
            'order' => ['DATE_INSERT' => 'DESC'],
            'filter' => [
                'USER_ID' => $USER->GetID(),
            ],
            'limit' => 1
        ]);

        if (!$order) {
            return [];
        }
        $order = array_shift($order);
        $order_status_id = $order->getField('STATUS_ID');

        $result = [];

        $result['ORDER'] = $order;
        $result['BASKET'] = count($order->getBasket()->getBasketItems());
        $result['STATUS'] = \CSaleStatus::GetByID($order_status_id);

        return $result;
    }

    /**
     * Формирование ссылки для выхода из учетной записи
     * @return string сслыка для выхода
     */
    public static function logoutLink(): string
    {
        global $APPLICATION;
        return $APPLICATION->GetCurPageParam("logout=yes", array(
            "login",
            "logout",
            "register",
            "forgot_password",
            "change_password"
        ));
    }

    /**
     * Функция для получения имени интупа для веб формы
     * @param string $input_name - код вопроса из админки
     * @param array $arResult - результирующий массив компонента
     * @return string - имя для интупа
     */
    public static function formInputName(string $input_name, array &$arResult): string
    {
        return 'form_' . $arResult["QUESTIONS"][$input_name]["STRUCTURE"][0]["FIELD_TYPE"] . '_' . $arResult["QUESTIONS"][$input_name]["STRUCTURE"][0]["ID"] . '';
    }

    /**
     * Функция для получения окончания
     * @param int $value - число
     * @param array $status - варианты окончания
     * @return string - окончание
     */
    public static function getDecNum($value = 1, $status = array('', 'а', 'ов')): string
    {
        $array = array(2, 0, 1, 1, 1, 2);
        return $status[($value % 100 > 4 && $value % 100 < 20) ? 2 : $array[($value % 10 < 5) ? $value % 10 : 5]];
    }


    public static function getIblockElements(int $iblockId = 0, bool $properties = true, array $filter = [], array $select = [
        "ID", "NAME", "IBLOCK_ID", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_TEXT", "CODE",
        "DETAIL_PICTURE", "ACTIVE_FROM", "SECTION_ID", 'DETAIL_PAGE_URL', 'PROPERTY_*'
    ]): array
    {
        if (!Loader::IncludeModule("iblock"))
            return [];

        if ($iblockId) {
            $filter["IBLOCK_ID"] = $iblockId;
        }
        $rs = \CIBlockElement::GetList(["SORT" => "ASC"], $filter, false, false, $select);

        $elements = array();

        while ($ar = $rs->GetNextElement()) {
            $element = $ar->GetFields();
            if ($properties)
                $element["PROPERTIES"] = $ar->GetProperties();

            $elements[] = $element;
        }

        return $elements;
    }

    public static function getIblockSections(int $iblockId = 0, array $filter = [], array $select = [
        "ID", "NAME", "IBLOCK_ID", "DETAIL_PICTURE", "IBLOCK_SECTION_ID", 'SECTION_PAGE_URL'
    ]): array
    {
        if (!Loader::IncludeModule("iblock"))
            return false;

        if ($iblockId > 0) {
            $filter["IBLOCK_ID"] = $iblockId;
        }
        $rs = \CIBlockSection::GetList(["SORT" => "ASC"], $filter, false, $select);

        $elements = [];

        while ($element = $rs->GetNext()) {

            $elements[$element["ID"]] = $element;
        }

        return $elements;
    }

    public static function arraySearchById($id, $array, $param = "ID"): ?array
    {
        foreach ($array as $item) {
            if ($item[$param] == $id) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Метод для определения типа видео контента по ссылке
     * @param string $link ссылка на видео
     * @return bool true если видео на youtube
     */
    static function isYoutube(string $link): bool
    {
        return strpos($link, 'youtu') !== false;
    }

    /**
     * Метод убирает лишние символы из номера телефона
     * @param string $phone номер телефона
     * @return string очищенный номер телефона
     */
    static function trimPhone(string $phone): string
    {
        return str_replace(['-', '+', '(', ')', ' '], '', $phone);
    }

    public static function getBaseLink(): string
    {
        $protocol = \CMain::IsHTTPS() ? 'https://' : 'http://';
        return $protocol . SITE_SERVER_NAME;
    }

    public static function getIblockIdByCode(string $code): ?int
    {
        $iblock = self::getIblockByCode($code);
        if ($iblock) {
            return $iblock->getId();
        }
        return null;
    }

    public static function getIblockByCode(string $code): EO_Iblock
    {
        /* @var EO_Iblock $iblock */
        $iblock = IblockTable::getList([
            'filter' => ['CODE' => $code],
            'cache' => [
                'ttl' => 360000,
                'cache_joins' => true
            ]
        ])->fetchObject();

        return $iblock;
    }

    public static function getFavorites(): ?array
    {
        $favorites = explode('|', $_COOKIE['fav']);
        return $favorites ?? null;
    }

    public static function getSectionByCode(string $code): EO_Section
    {
        /* @var EO_Section $iblock */
        $section = SectionTable::getList([
            'filter' => ['CODE' => $code],
            'cache' => [
                'ttl' => 360000,
                'cache_joins' => true
            ]
        ])->fetchObject();

        return $section;
    }

    public static function getSectionIdByCode(string $code): int
    {
        /* @var EO_Section $iblock */
        $section = self::getSectionByCode($code);
        return $section->getId();
    }

    public static function getIblockById(int $id): EO_Iblock
    {
        return ManagedCache::cache('iblock' . $id, 360000, function () use ($id) {
            return IblockTable::getById($id)->fetchObject();
        });
    }

    public static function getCompareCount(string $sessionKey): int
    {
        return count(self::getCompareIds()) ?? 0;
    }

    /**
     * @return array
     */
    public static function getTreeSectionsForEcommerce()
    {
        $return = [];
        $obCache = new \CPHPCache();

        if ($obCache->InitCache(36000, serialize(['SECTIONS' => IBLOCK_ID_PAGES]), "/iblock/catalog/sections")) {
            $return = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            \Bitrix\Main\Loader::includeModule('iblock');

            $rs = \Bitrix\Iblock\sectionTable::getList([
                'select' => ['ID', 'NAME', 'DEPTH_LEVEL'],
                'filter' => [
                    'IBLOCK_ID' => IBLOCK_ID_PAGES
                ]
            ]);

            while ($ar = $rs->fetch()) {

                $path = '';

                if ($ar['DEPTH_LEVEL'] > 1) {

                    $nav = \CIBlockSection::GetNavChain(false, $ar['ID']);

                    $list = [];

                    while ($sect = $nav->fetch()) {

                        $list[] = $sect['NAME'];
                    }

                    $path = implode(' / ', $list);
                } else {

                    $path = $ar['NAME'];
                }

                $return[$ar['ID']] = $path;
            }


            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");
            $CACHE_MANAGER->RegisterTag("iblock_id_" . IBLOCK_ID_PAGES);
            $CACHE_MANAGER->EndTagCache();

            $obCache->EndDataCache($return);
        }

        return $return;
    }

    /**
     * @param $sectionId
     * @return string
     */
    public static function getSectionPathBySectionId(int $sectionId): ?string
    {
        $arr = self::getTreeSectionsForEcommerce();

        return $arr[$sectionId];
    }

    /**
     * @param int $count
     * @return array|null
     */
    public static function getPopularProducts(int $count = 10): ?array
    {
        $result = null;

        $productsDb = \CIblockElement::getList(['SORT' => 'ASC'], ['>PROPERTY_HIT' => 0, 'IBLOCK_ID' => [10, 11, 12, 13, 14]], false, ['nPageSize' => $count], ['ID']);
        while ($product = $productsDb->fetch()) {
            $result[] = $product['ID'];
        }
        return $result;
    }

    /**
     * @param int $count
     * @return array|null
     */
    public static function getNewProducts(int $count = 10): ?array
    {
        $result = null;

        $productsDb = \CIblockElement::getList(['SORT' => 'ASC'], ['>PROPERTY_NEW' => 0, 'IBLOCK_ID' => [10, 11, 12, 13, 14]], false, ['nPageSize' => $count], ['ID']);
        while ($product = $productsDb->fetch()) {
            $result[] = $product['ID'];
        }
        return $result;
    }

    public static function getIblockIds(string $type)
    {
        $ids = [];
        $iblocks = IblockTable::getList([
            'filter' => ['IBLOCK_TYPE_ID' => 'catalog', 'ACTIVE' => 'Y'],
            'select' => ['ID'],
            'cache' => [
                'ttl' => 36000
            ]
        ])->fetchCollection();
        foreach ($iblocks as $iblock) {
            $ids[] = $iblock->getId();
        }
        return $ids;
    }

    public static function isWeekend(): bool
    {
        return (date('N', time()) >= 6);
    }

    /**
     * Возвращает id товаров из списка сравнения
     * @return array|null
     */
    public static function getCompareIds(): ?array
    {
        $ids = null;

        foreach ($_SESSION['CATALOG_COMPARE_LIST'] as $iblock) {
            foreach ($iblock['ITEMS'] as $item) {
                if ($item['ID']) {
                    $ids[] = $item['ID'];
                }
            }
        }

        return $ids;
    }

    public static function getLast1cImport(): ?array
    {
        \Bitrix\Main\Loader::includeModule('highloadblock');
        $code = 'Imports1c';
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['NAME' => $code]])->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $hlEntity = $entity->getDataClass();

        return $hlEntity::getList([
            'limit' => 1,
            'order' => ['ID' => 'DESC']
        ])->Fetch();
    }
}