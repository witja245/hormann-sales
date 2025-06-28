<?
namespace Itech;

use Bitrix\Sale\Location\GeoIp;

class Location{
    const SESSION_NAME = 'ITECH_LOCATION_ID';

    static public function getCity(){
        if(empty($_SESSION[self::SESSION_NAME])){

            \Bitrix\Main\Loader::includeModule('sale');

            $ipAddress = \Bitrix\Main\Service\GeoIp\Manager::getRealIp();

            $locId = GeoIp::getLocationId($ipAddress, LANGUAGE_ID);

            if(empty($locId)){

                $locId = 1036;
            }

            if($locId){

                $rs = \Bitrix\Sale\Location\LocationTable::getList(array(
                    'filter' => ['ID' => $locId, '=NAME.LANGUAGE_ID' => 'ru'],
                    'select' => ['ID','CODE','NAME_RU' => 'NAME.NAME'],
                ));

                if($ar = $rs->fetch()){
                    $_SESSION[self::SESSION_NAME] = $ar;
                }
            }
        }
        return $_SESSION[self::SESSION_NAME];
    }

    static public function setCity($value){

        \Bitrix\Main\Loader::includeModule('sale');

        //Ищем город в справочнике
        $rs = \Bitrix\Sale\Location\LocationTable::getList(array(
            'filter' => ['ID'=>$value, '=NAME.LANGUAGE_ID' => 'ru'],
            'select' => ['ID','CODE','NAME_RU' => 'NAME.NAME']
        ));

        if($ar = $rs->fetch()){

            $_SESSION[self::SESSION_NAME] = $ar;
        }

        return false;
    }

    static public function getCodeCity(){

        \Bitrix\Main\Loader::includeModule('sale');

        $value = self::getCity();

        $rs = \Bitrix\Sale\Location\LocationTable::getList(array(
            'filter' => array('=TYPE.ID' => '5', '=NAME.LANGUAGE_ID' => LANGUAGE_ID, '=NAME.NAME'=>$value),
            'select' => array('NAME_RU' => 'NAME.NAME','CODE')
        ));

        if($ar = $rs->fetch()){

            return $ar['CODE'];
        }

        return false;
    }

    static public function getNameByCode($code){
        \Bitrix\Main\Loader::includeModule('sale');

        //Ищем город в справочнике
        $rs = \Bitrix\Sale\Location\LocationTable::getList(array(
            'filter' => ['CODE'=>$code],
            'select' => ['ID','CODE','NAME_RU' => 'NAME.NAME']
        ));

        $result = false;

        if($ar = $rs->fetch()){

            $result = $ar;
        }

        return $result;
    }
}