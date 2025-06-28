<?php

namespace Itech;

use Bitrix\Sale\Location\GeoIp;
use Bitrix\Main\Loader;

class Geo
{

    public const DEFAULT_CITY = "Москва";
    public const COOKIE_NAME_CITY = "user_city";
    public const COOKIE_NAME_COORDS = "user_coords";

    /**
     * Отправляет запрос на api.sypexgeo.net и возвращает город, если его удалось получить
     * @return bool|array
     */
    static private function defineCity()
    {
        // Проверка на бота
        $is_bot = preg_match(
            "~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i",
            $_SERVER['HTTP_USER_AGENT']
        );
        $result = false;

        if (!$is_bot) {
            $ip = \Bitrix\Main\Service\GeoIp\Manager::getRealIp();;
            $protocol = $_SERVER["HTTP"] ? "https" : "http";
            $format = "json";
            $site = "api.sypexgeo.net";
            $request = $protocol . "://" . $site . "/" . $format . "/" . $ip;
            $result = json_decode(file_get_contents($request), true);
            if ($result["city"]) {
                $result = $result["city"];
            }
        }
        return $result;
    }

    /**
     * Функция рассчитывает расстояние(км?) между городами по широте и долготе
     * @param $fromCoords array
     * @param $toCoords array
     * @return String
     */
    static public function getCitiesDistance($fromCoords, $toCoords)
    {
        $r = 6371;
        $sin1 = sin((deg2rad($fromCoords['LAT']) - deg2rad($toCoords['LAT'])) / 2);
        $sin2 = sin((deg2rad($fromCoords['LON']) - deg2rad($toCoords['LON'])) / 2);
        return intval(2 * $r * asin(sqrt($sin1 * $sin1 + $sin2 * $sin2 * cos(deg2rad($fromCoords['LAT'])) * cos(deg2rad($toCoords['LAT'])))));
    }

    /*static private function updateCookie()
    {
        $result = [];
        $city = self::defineCity(); // Пробуем определить город

        if ($city && $city["name_ru"]) { // Если город определён
            $city_name = $city["name_ru"];
            $result["CITY"] = $city_name;
            setcookie(self::COOKIE_NAME_CITY, $city_name);
        }
        return $result ? $result : false;
    }*/

    static public function getCoords()
    {
        $coords = $_COOKIE[self::COOKIE_NAME_COORDS];
        if (!$coords) {
            $coords = self::updateCookie()["COORDS"];
        }
        if ($coords) {
            $coords_ar = explode(",", $coords);
            $result = ["LAT" => $coords_ar[0], "LON" => $coords_ar[1]];
        } else {
            $result = false;
        }
        return $result;
    }

    static public function setCookieArray($name, $ar)
    {
        foreach ($ar as $key => $value) {
            setcookie($name . "[" . $key . "]", $value, 0, "/");
        }
    }

    /**
     * Функция возвращает элемент города, имя которого было определено
     * @param bool $city_name string
     * @return array|bool
     * @throws \Bitrix\Main\LoaderException
     */
    static public function getCity()
    {
        $city = $_COOKIE[self::COOKIE_NAME_CITY];
//        if(!$city["NAME"] || $city["CODE"] || $city["LAT"] || $city["LON"])){
//
//        }

        if (!$city) {
            $define_city = self::defineCity();
            if (!$define_city['name_ru']) {
                $define_city["name_ru"] = 'Москва';
                $define_city["lat"] = '55.751244';
                $define_city["lon"] = '37.618423';
            }
            $translit_params = [
                "replace_space" => "-",
                "replace_other" => "-"
            ];
            $city = [
                "NAME" => $define_city["name_ru"],
                "LAT" => $define_city["lat"],
                "LON" => $define_city["lon"],
                "CODE" => \Cutil::translit($define_city["name_ru"], "ru", $translit_params),
            ];
            self::setCookieArray(self::COOKIE_NAME_CITY, $city);
        }

        return $city ? $city : false;
    }

    static public function getDealersCities($cities_filter = false)
    {

        $filter = [
            "IBLOCK_ID" => IBLOCK_ID_SHOPS,
            "ACTIVE" => "Y",
            "GLOBAL_ACTIVE" => "Y",
        ];

        $select = ["ID", "PROPERTY_CITY"];
        $db_res = \CIBlockElement::GetList([], $filter, false, false, $select);
        $shops = [];
        $cities_ids = [];
        while ($shop_el = $db_res->GetNext()) {
            if ($shop_el["PROPERTY_CITY_VALUE"]) {
                $cities_ids[] = $shop_el["PROPERTY_CITY_VALUE"];
            }
            $shops[] = $shop_el;
        }
        $cities_ids = array_unique($cities_ids);

        $order = ["NAME" => "ASC"];
        $filter = [
            "IBLOCK_ID" => IBLOCK_ID_CITIES,
            "ACTIVE" => "Y",
            "GLOBAL_ACTIVE" => "Y",
            "ID" => $cities_ids,
        ];
        if($cities_filter) {
            $filter = array_merge($filter, $cities_filter);
        }
        $select = ["ID", "NAME", "CODE", "PROPERTY_MAP", "IBLOCK_SECTION_ID", "PROPERTY_BOLD"];
        $db_res = \CIBlockElement::GetList($order, $filter, false, false, $select);
        $cities = [];
        $translit_params = [
            "replace_space" => "-",
            "replace_other" => "-"
        ];
        while ($city_el = $db_res->GetNext()) {
            $coords = explode(",", $city_el["PROPERTY_MAP_VALUE"]);
            $city = [
                "ID" => $city_el["ID"],
                "NAME" => $city_el["NAME"],
                "LAT" => $coords[0],
                "LON" => $coords[1],
                "CODE" => \Cutil::translit($city_el["NAME"], "ru", $translit_params),
                "COUNTRY_ID" => $city_el["IBLOCK_SECTION_ID"],
                "BOLD" => $city_el["PROPERTY_BOLD_VALUE"],
            ];
            $cities[] = $city;
        }

        return $cities;
    }

    static public function getNearestCity($current_city = false, $cities = false, $country = false)
    {
        $nearest_city = false;

        if (!$current_city) {
            $current_city = self::getCity();
        }

        if (!$cities) {
            $filter = false;
            if ($country) {
                $filter = [
                    "IBLOCK_SECTION_ID" => $country
                ];
            }

            $cities = self::getDealersCities($filter);
        }

        if ($current_city && $cities) {
            $current_coords = [
                "LAT" => $current_city["LAT"],
                "LON" => $current_city["LON"],
            ];
            $distances = [];
            foreach ($cities as $key => $city) {
                $coords = [
                    "LAT" => $city["LAT"],
                    "LON" => $city["LON"],
                ];
                $distance = self::getCitiesDistance($coords, $current_coords);
                $distances[$distance] = ['ID' => $key, 'DISTANCE' => $distance];
            }
            ksort($distances);

            $item = array_shift($distances);

//            if ($item['ID']==10)
//                $nearest_index = 9;
//            else
                $nearest_index = $item['ID'];

            $nearest_city = $cities[$nearest_index];
//            if ($item['DISTANCE']<100){
//                $nearest_city = $cities[$nearest_index];
//            }
        }

//        return $nearest_city ? $nearest_city : '';
        return $nearest_city;
        /*$city = self::GetCity();
        if($city){
            $order = [];
            $filter = [
                "IBLOCK_ID" => IBLOCK_ID_SHOPS,
                "ACTIVE" => "Y",
                "GLOBAL_ACTIVE" => "Y",
            ];
            $select = ["ID", "PROPERTY_MAP", "PROPERTY_CITY.NAME"];
            $db_res = \CIBlockElement::GetList($order, $filter, false ,false, $select);
            $cities = [];
            while($city_el = $db_res->GetNext()){
                $cities[] = $city_el;
            }
        }

        return $cities;

        /*if (!$city_id) {
            return false;
        }

        $coords = self::GetCoords();

        $filter = [
            "IBLOCK_ID" => IBLOCK_ID_SHOPS,
            "ACTIVE" => "Y",
        ];

        if ($country) {
            $filter["PROPERTY_CITY_VALUE.IBLOCK_SECTION_ID"] = $country;
        }

        $select = ["ID", "PROPERTY_MAP", "PROPERTY_CITY.NAME"];
        $dbRes = \CIBlockElement::GetList([], $filter, false, false, $select);
        $shops = [];
        while ($shop = $dbRes->GetNext()) {
            $shop_coords = explode(",", $shop["PROPERTY_MAP_VALUE"]);
            $shop_coords_ar = [
                "LAT" => $shop_coords[0],
                "LON" => $shop_coords[1]
            ];
            $shop["DISTANCE"] = self::getCitiesDistance($coords, $shop_coords_ar);
            $shops[] = $shop;
        }

        if (!$shops) {
            return false;
        }

        usort($shops, function ($a, $b) {
            if ($a["DISTANCE"] == $b["DISTANCE"]) {
                return 0;
            }
            return ($a["DISTANCE"] < $b["DISTANCE"]) ? -1 : 1;
        });

        $section_name = $shops[0];

        $city = self::getCity($section_name);

        if ($city) {
            return $city;
        } else {
            return false;
        }*/
    }

    /**
     * Функция устанавливает новое имя города в куки и возвращает его, если город был определён
     * @param $city_name string
     * @return string|bool
     */
    static public function setCity($city_name)
    {
        $filter = array(
            'filter' => ["=UF_NAME" => $city_name],
            'select' => ["UF_NAME", "UF_LAT", "UF_LON"],
        );
        $city = array_pop((new \Itech\References(HL_ALL_CITIES))->get_list($filter));

        if ($city) {
            $translit_params = [
                "replace_space" => "-",
                "replace_other" => "-"
            ];
            $city = [
                "NAME" => $city["UF_NAME"],
                "LAT" => $city["UF_LAT"],
                "LON" => $city["UF_LON"],
                "CODE" => \Cutil::translit($city["UF_NAME"], "ru", $translit_params),
            ];
            self::setCookieArray(self::COOKIE_NAME_CITY, $city);
        }
    }
}
