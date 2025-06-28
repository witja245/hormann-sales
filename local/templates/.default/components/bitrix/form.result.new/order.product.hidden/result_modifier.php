<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

Loader::includeModule("highloadblock");

    $arFileTmp = CFile::ResizeImageGet(
        $arParams['PRODUCT']['PREVIEW_PICTURE'],
        array("width" => 96, "height" => 80),
        BX_RESIZE_IMAGE_PROPORTIONAL ,
        true,
        false
    );
    $arParams['PRODUCT']['PREVIEW_PICTURE'] = $arFileTmp['src'];

?>