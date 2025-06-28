<?php

use Bitrix\Main\Loader,
    Bitrix\Main,
    Bitrix\Main\Application;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
Loader::includeModule("iblock");
Loader::includeModule("highloadblock");
Cmodule::IncludeModule('catalog');
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/iblock/prolog.php");
IncludeModuleLangFile(__FILE__);
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/interface/admin_lib.php");

$APPLICATION->SetTitle('Импорт товаров из таблицы Excel');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php"); ?>

    <form action="<?= $APPLICATION->GetCurUri() ?>" method="post" enctype="multipart/form-data">
        <p>
            <label>Файл товаров
                <input type="file" name="goods" id="table">
            </label>
        </p>
        <p>
            <button>
                Загрузить
            </button>
        </p>
    </form>
    <p>
        <a href="/upload/template.xlsx" target="_blank">Шаблон документа</a>
    </p>
    <p>
        Перед загрузкой убедитесь в корректности файла!
    </p>
    <p>
        Загрузка может занять несколько минут!
    </p>
<?php
if ($_FILES['goods']['tmp_name']) {
    \Bitrix\Main\Loader::includeModule('iblock');
    $file_path = $_FILES['goods']['tmp_name'];
    $reader = ReaderEntityFactory::createXLSXReader();
    $reader->open($file_path);
    $rows = [];
    $data = [];
    foreach ($reader->getSheetIterator() as $keySheet => $sheet) {
        foreach ($sheet->getRowIterator() as $key => $row) {
            if ($key == 1 || $key == 3) { // Название полей товара и ТП
                continue;
            }
            $cells = $row->getCells();
            $rows[$keySheet][] = $cells;
        }
    }
    $reader->close();

    //параметры торговых предложений
    $arSurfaceName = [];
    $arGofrName = [];
    $arColorName = [];
    $arGlazingName = [];
    $arSizeName = [];
    $arSoundName = [];
    $arIsolationName = [];
    $arEnergyName = [];

    //параметры товаров
    $arTypeName = [];
    $arMaterialName = [];

    //свойства типа список
    $arControl = [];
    $arCountry = [];
    $arAvailability = [];
    $arControlName = [];
    $arCountryName = [];
    $arAvailabilityName = [];
    $arLeafWidthName = [];
    $arLeafWidthTPName = [];
    $arLeafHeightName = [];
    $arLeafHeightTPName = [];
    $driveUnit = [];
    $driveUnitName = [];
    //

    //привязка к элемантам
    $arTags = [];
    $arTagsName = [];
    //

    $arSliderLinks = [];

    $arColorCode = [];
    $arColorFile = [];
    $data = [];
    $arGoodsName = [];
    $arOffersName = [];
    $arSectionName = [];
    foreach ($rows as $keySheet => $elements) {
        foreach ($elements as $keyRows => $items) {
            if ($keyRows == 0) {
                $arGoodsName[$keySheet.$keyRows] = $items[0]->getValue();
//                $arTypeName[$items[10]->getValue()] = $items[10]->getValue();
                $arTypeName[$items[1]->getValue()] = $items[1]->getValue();
//                $arMaterialName[$items[11]->getValue()] = $items[11]->getValue();
                $arMaterialName[$items[2]->getValue()] = $items[2]->getValue();
//                $arSectionName[$items[12]->getValue()] = $items[12]->getValue();
                $arSectionName[$items[3]->getValue()] = $items[3]->getValue();
//                $isolation = $items[13]->getValue();
                $isolation = $items[4]->getValue();
                $isolation = str_replace(',', '.', $isolation);
                $isolation = round($isolation);
//                $energy = $items[14]->getValue();
                $energy = $items[5]->getValue();
                $energy = str_replace(',', '.', $energy);
                $energy = round($energy);
//                $sound = $items[15]->getValue();
                $sound = $items[6]->getValue();
                $sound = str_replace(',', '.', $sound);
                $sound = round($sound);
//                $arControlName[] = $items[18]->getValue();
                $arControlName[] = $items[9]->getValue();
//                $arCountryName[] = $items[21]->getValue();
                $arCountryName[] = $items[12]->getValue();
//                $tmpTags = $items[27]->getValue();
                $tmpTags = $items[18]->getValue();
                $arTagsName = explode(',', $tmpTags);
                $arTagsName = array_map('trim', $arTagsName);
                $arTagsName = array_unique($arTagsName);
//                $tmpSlider = $items[33]->getValue();
                $tmpSlider = $items[24]->getValue();
                $arSliderLinks = explode(',', $tmpSlider);
                $arSliderLinks = array_map('trim', $arSliderLinks);
                $arSliderFiles = [];
                foreach ($arSliderLinks as $link){
                    $tmp = \CFile::MakeFileArray($link);
                    if (strstr($tmp['type'],'image')!==false){
                        $arSliderFiles[] = $tmp;
                    }
                }
//                $tmp = \CFile::MakeFileArray(trim($items[30]->getValue()));
                $tmp = \CFile::MakeFileArray(trim($items[21]->getValue()));
                if (strstr($tmp['type'],'image')!==false){
                    $previewPicture = $tmp;
                } else {
                    $previewPicture = null;
                }
//                $tmp = \CFile::MakeFileArray(trim($items[32]->getValue()));
                $tmp = \CFile::MakeFileArray(trim($items[23]->getValue()));
                if (strstr($tmp['type'],'image')!==false){
                    $detailPicture = $tmp;
                } else {
                    $detailPicture = null;
                }
//                $tmp = \CFile::MakeFileArray(trim($items[31]->getValue()));
                $tmp = \CFile::MakeFileArray(trim($items[22]->getValue()));
                if (strstr($tmp['type'],'image')!==false){
                    $customDetailPicture = $tmp;
                } else {
                    $customDetailPicture = null;
                }

                $arLeafWidthName[] = $items[25]->getValue();
                $arLeafHeightName[] = $items[26]->getValue();

                $data[$keySheet]['MAIN'] = [
                    'NAME' => $items[0]->getValue(),
//                    'SECTION' => $items[12]->getValue(),
                    'SECTION' => $items[3]->getValue(),
//                    'TYPE' => $items[10]->getValue(), //handbook
                    'TYPE' => $items[1]->getValue(), //handbook
//                    'MATERIAL' => $items[11]->getValue(), //handbook
                    'MATERIAL' => $items[2]->getValue(), //handbook
                    'ISOLATION' => $isolation, //list
                    'ENERGY' => $energy, //list
                    'SOUND' => $sound, //list
//                    'CONSTRUCTION' => $items[16]->getValue(), //str
                    'CONSTRUCTION' => $items[7]->getValue(), //str
//                    'PANEL' => $items[17]->getValue(), //str
                    'PANEL' => $items[8]->getValue(), //str
//                    'CONTROL' => $items[18]->getValue(),
                    'CONTROL' => $items[9]->getValue(),
//                    'MOUNTING_TYPE' => $items[19]->getValue(),
                    'MOUNTING_TYPE' => $items[10]->getValue(),
//                    'TIME' => $items[20]->getValue(),
                    'TIME' => $items[11]->getValue(),
//                    'COUNTRY_OF_ORIGIN' => $items[21]->getValue(),
                    'COUNTRY_OF_ORIGIN' => $items[12]->getValue(),
//                    'APPOINTMENT' => $items[22]->getValue(),
                    'APPOINTMENT' => $items[13]->getValue(),
//                    'CANVAS_MATERIAL' => $items[23]->getValue(),
                    'CANVAS_MATERIAL' => $items[14]->getValue(),
//                    'ISOLATION_V' => $items[24]->getValue(),
                    'ISOLATION_V' => $items[15]->getValue(),
//                    'GUARANTEE' => $items[25]->getValue(),
                    'GUARANTEE' => $items[16]->getValue(),
//                    'DRIVE_UNIT' => $items[26]->getValue(),
                    'DRIVE_UNIT' => $items[17]->getValue(),
                    'TAGS' => $arTagsName,
//                    'PREVIEW_TEXT' => $items[28]->getValue(),
                    'PREVIEW_TEXT' => $items[19]->getValue(),
//                    'DETAIL_TEXT' => $items[29]->getValue(),
                    'DETAIL_TEXT' => $items[20]->getValue(),
                    'PREVIEW_PICTURE' => $previewPicture,
                    'DETAIL_PICTURE' => $detailPicture,
                    'CUSTOM_DETAIL_PICTURE' => $customDetailPicture,
                    'SLIDER' => $arSliderFiles,
                    'DOOR_LEAF_WIDTH' => $items[25]->getValue(),
                    'DOOR_LEAF_HEIGHT' => $items[26]->getValue(),
                    'DOOR_WEIGHT' => $items[27]->getValue(),
                    'NUTRITION' => $items[28]->getValue(),
                    'NOMINAL_FORCE' => $items[29]->getValue(),
                    'MAXIMUM_FORCE' => $items[30]->getValue(),
                    'MAXIMUM_GATE_TRAVEL_SPEED' => $items[31]->getValue(),
                    'TEMPERATURE_RANGE' => $items[32]->getValue(),
                    'DRIVE_DEGREE_OF_PROTECTION' => $items[33]->getValue(),
                    'TYPE_OF_LIMIT_SWITCH' => $items[34]->getValue(),
                    'AUTO_CLOSE' => $items[35]->getValue(),
                    'MAXIMUM_GATE_AREA' => $items[36]->getValue(),
                    'FREQUENCY' => $items[37]->getValue(),
                    'NUMBER_OF_CHANNELS' => $items[38]->getValue(),
                    'TYPE_OF_FEEDER' => $items[39]->getValue(),
                    'RADIO_SIGNAL' => $items[40]->getValue(),
                    'ITEM_NUMBER' => $items[41]->getValue(),
                    'WXHXH_DIMENSIONS' => $items[42]->getValue(),
                    'WIRE_TYPE' => $items[43]->getValue(),
                    'PACKAGE_CONTENTS' => $items[44]->getValue(),
                    'PROTECTION_LEVEL' => $items[45]->getValue(),
                    'CABLE_LENGTH' => $items[46]->getValue(),
                    'DIAMETER_OF_THE_HOLE' => $items[47]->getValue(),
                ];
            } else {
                $arColorCode[$items[6]->getValue()] = $items[7]->getValue();
                $arOffersName[$items[0]->getValue()] = $items[0]->getValue();
                $arSurfaceName[$items[5]->getValue()] = $items[5]->getValue();
                $arGofrName[$items[4]->getValue()] = $items[4]->getValue();
                $arColorName[$items[6]->getValue()] = $items[6]->getValue();
                $arGlazingName[$items[8]->getValue()] = $items[8]->getValue();
                $arLeafWidthTPName[] = $items[13]->getValue();
                $arLeafHeightTPName[] = $items[14]->getValue();
                $arSizeName[$items[2]->getValue() . ' x ' . $items[3]->getValue()] = $items[2]->getValue() . ' x ' . $items[3]->getValue();
//                $isolation = $items[12]->getValue();
                $isolation = $items[10]->getValue();
//                $isolation = str_replace(',','.', $isolation);
//                $isolation = round($isolation);
//                $energy = $items[13]->getValue();
                $energy = $items[11]->getValue();
//                $energy = str_replace(',','.', $energy);
//                $energy = round($energy);
//                $sound = $items[14]->getValue();
                $sound = $items[12]->getValue();
//                $sound = str_replace(',','.', $sound);
//                $sound = round($sound);
                $arAvailabilityName[] = $items[9]->getValue();
                $driveUnitName[] = $items[47]->getValue();
                $arSoundName[strval($sound)] = strval($sound);
                $arIsolationName[strval($isolation)] = strval($isolation);
                $arEnergyName[strval($energy)] = strval($energy);

                $tmp = \CFile::MakeFileArray(trim($items[7]->getValue()));
                if (strstr($tmp['type'],'image')!==false){
                    $arColorFile[$items[6]->getValue()] = $tmp;
                } else {
                    $arColorFile[$items[6]->getValue()] = null;
                }
                $previewPictureOffer = false;
                $tmp = \CFile::MakeFileArray(trim($items[48]->getValue()));
                if (strstr($tmp['type'],'image')!==false){
                    $previewPictureOffer = $tmp;
                } else {
                    $previewPictureOffer = null;
                }

                $data[$keySheet]['OFFERS'][] = [
                    'NAME' => $items[0]->getValue(),
                    'PREVIEW_PICTURE' => $previewPictureOffer,
                    'PRICE' => $items[1]->getValue(),
                    'SIZE' => $items[2]->getValue() . ' x ' . $items[3]->getValue(), //handbook
                    'GOFR' => $items[4]->getValue(), //handbook
                    'SURFACE' => $items[5]->getValue(), //handbook
                    'COLOR_NAME' => $items[6]->getValue(), //handbook
//                    'COLOR_CODE' => $items[7]->getValue(), //str
                    'COLOR_FILE' => $items[7]->getValue(), //array
                    'GLAZING_NAME' => $items[8]->getValue(), //handbook
                    'ISOLATION' => $isolation, //handbook
                    'ENERGY' => $energy, //handbook
                    'SOUND' => $sound, //handbook
                    'AVAILABILITY' => $items[9]->getValue(), //list
                    'DOOR_LEAF_WIDTH' => $items[13]->getValue(), //list
                    'DOOR_LEAF_HEIGHT' => $items[14]->getValue(), //list
                    'DOOR_WEIGHT' => $items[15]->getValue(), //str
                    'NUTRITION' => $items[16]->getValue(), //str
                    'NOMINAL_FORCE' => $items[17]->getValue(), //str
                    'MAXIMUM_FORCE' => $items[18]->getValue(), //str
                    'MAXIMUM_GATE_TRAVEL_SPEED' => $items[19]->getValue(), //str
                    'TEMPERATURE_RANGE' => $items[20]->getValue(), //str
                    'DRIVE_DEGREE_OF_PROTECTION' => $items[21]->getValue(), //str
                    'TYPE_OF_LIMIT_SWITCH' => $items[22]->getValue(), //str
                    'APPOINTMENT' => $items[23]->getValue(), //str
                    'CANVAS_MATERIAL' => $items[24]->getValue(), //str
                    'ISOLATION_V' => $items[25]->getValue(), //str
                    'SEALANT' => $items[26]->getValue(), //str
                    'WEB_THICKNESS' => $items[27]->getValue(), //str
                    'BOX_THICKNESS' => $items[28]->getValue(), //str
                    'HINGE_TYPE' => $items[29]->getValue(), //str
                    'THERMAL_BREAK_DOOR' => $items[30]->getValue(), //str
                    'THERMAL_BREAK_BOX' => $items[31]->getValue(), //str
                    'ANTI_REMOVABLE_BAR' => $items[32]->getValue(), //str
                    'LOCK' => $items[33]->getValue(), //str
                    'FILLING' => $items[34]->getValue(), //str
                    'MAXIMUM_GATE_AREA' => $items[35]->getValue(), //str
                    'FREQUENCY' => $items[36]->getValue(), //str
                    'NUMBER_OF_CHANNELS' => $items[37]->getValue(), //str
                    'TYPE_OF_FEEDER' => $items[38]->getValue(), //str
                    'RADIO_SIGNAL' => $items[39]->getValue(), //str
                    'ITEM_NUMBER' => $items[40]->getValue(), //str
                    'WXHXH_DIMENSIONS' => $items[41]->getValue(), //str
                    'WIRE_TYPE' => $items[42]->getValue(), //str
                    'PACKAGE_CONTENTS' => $items[43]->getValue(), //str
                    'PROTECTION_LEVEL' => $items[44]->getValue(), //str
                    'CABLE_LENGTH' => $items[45]->getValue(), //str
                    'DIAMETER_OF_THE_HOLE' => $items[46]->getValue(), //str
                    'DRIVE_UNIT' => $items[47]->getValue(), //list
                ];
            }
        }
    }
    $arMaterialName = array_diff($arMaterialName, ['']);
    $arTypeName = array_diff($arTypeName, ['']);
    $arSizeName = array_diff($arSizeName, ['']);
    $arGlazingName = array_diff($arGlazingName, ['']);
    $arColorName = array_diff($arColorName, ['']);
    $arGofrName = array_diff($arGofrName, ['']);
    $arSurfaceName = array_diff($arSurfaceName, ['']);
    $arOffersName = array_diff($arOffersName, ['']);
    $arGoodsName = array_diff($arGoodsName, ['']);
    $arSoundName = array_diff($arSoundName, ['']);
    $arIsolationName = array_diff($arIsolationName, ['']);
    $arEnergyName = array_diff($arEnergyName, ['']);
    $driveUnitName = array_diff($driveUnitName, ['']);

    $arLeafWidthName = array_diff($arLeafWidthName, ['']);
    $arLeafWidthTPName = array_diff($arLeafWidthTPName, ['']);
    $arLeafHeightName = array_diff($arLeafHeightName, ['']);
    $arLeafHeightTPName = array_diff($arLeafHeightTPName, ['']);

    $arSectionHas = [];
    $res = CIBlockSection::GetList(Array(), ['NAME' => $arSectionName], true);
    while ($section = $res->GetNext()) {
        $arSectionHas[$section['NAME']] = $section['ID'];
    }
    $arGoodsHas = [];
    $arSelect = Array("ID", "NAME");
    $arFilter = Array("IBLOCK_ID" => 33, 'NAME' => $arGoodsName);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arGoodsHas[$arFields['ID']] = mb_strtolower($arFields['NAME']);
    }
    $arOffersHas = [];
    $arSelect = Array("ID", "NAME");
    $arFilter = Array("IBLOCK_ID" => 36, 'NAME' => $arOffersName);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arProperties = $ob->GetProperties();
        $arOffersHas[$arFields['ID']] = $arFields['NAME'];
    }

    function checkElementsAddNew($data, $iblockId){
        $result = [];
        $res = CIBlockElement::GetList([],['IBLOCK_ID' => $iblockId]);
        while ($element = $res->GetNext()){
            $result[$element['ID']] = mb_strtolower($element['NAME']);
        }
        $arDiff = array_diff($data, $result);
        foreach ($arDiff as $item){
            $el = new CIBlockElement;
            $arFields = [
                'NAME' => $item,
                'CODE' => translit($item),
                'IBLOCK_ID' => $iblockId,
                'ACTIVE' => 'Y',
                'IBLOCK_SECTION_ID' => false,
                'MODIFIED_BY' => 1,
            ];
            if ($id = $el->Add($arFields)){
                $result[$id] = $item;
            } else {
                var_dump($el->LAST_ERROR);
            }
        }

        return $result;
    }

    function checkHLProps($arFilter, $iblockId)
    {
        $hlblock = HL\HighloadBlockTable::getById($iblockId)->fetch();

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);

        $entity_data_class = $entity->getDataClass();

        $filter = array(
            "filter" => ['UF_NAME' => $arFilter],
            "select" => array("*"),
            "order" => array(),
        );

        $rsData = $entity_data_class::getList($filter);

        $result = [];
        while ($data = $rsData->fetch()) {
            $result[$data['UF_XML_ID']] = $data['UF_NAME'];
        }
        return $result;
    }

    function checkListProps($code, $iblockId)
    {
        $res = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => $iblockId, 'CODE' => $code]);
        $result = [];
        while ($prop = $res->GetNext()) {
            $result[$prop['ID']] = $prop['VALUE'];
        }

        return $result;
    }

    function addNewProps($names, &$had, $hlId)
    {
        foreach ($names as $item) {
            if (!in_array($item, $had)) {
                $hlblock = HL\HighloadBlockTable::getById($hlId)->fetch();
                $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                $entity_data_class = $entity->getDataClass();

                $arFields = array(
                    "UF_NAME" => $item,
                    "UF_XML_ID" => md5($item),
                );

                $result = $entity_data_class::add($arFields);
                $had[$arFields['UF_XML_ID']] = $arFields['UF_NAME'];
            }
        }
    }

    function addNewListProps($names, &$had, $iblockId, $propId)
    {
        foreach ($names as $item) {
            if (!in_array($item, $had)) {
                $prop = new \CIBlockPropertyEnum;
                if ($PropID = $prop->Add(Array('IBLOCK_ID' => $iblockId, 'PROPERTY_ID' => $propId, 'VALUE' => $item))) {
                    $had[$PropID] = $item;
                }
            }
        }
    }

    function translit($s)
    {
        $s = (string)$s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    $arTagsHas = checkElementsAddNew($arTagsName, 42);

    $arAvailabilityHas = checkListProps('AVAILABILITY', 36);
    $arControlHas = checkListProps('CONTROL', IBLOCK_ID_CATALOG);
    $arCountryHas = checkListProps('COUNTRY_OF_ORIGIN', IBLOCK_ID_CATALOG);
    $arLeafWidthHas = checkListProps('DOOR_LEAF_WIDTH', IBLOCK_ID_CATALOG);
    $arLeafWidthTPHas = checkListProps('DOOR_LEAF_WIDTH', 36);
    $arLeafHeightHas = checkListProps('DOOR_LEAF_HEIGHT', IBLOCK_ID_CATALOG);
    $arLeafHeightTPHas = checkListProps('DOOR_LEAF_HEIGHT', 36);
    $driveUnitHas = checkListProps('DRIVE_UNIT', 36);

    $arSurfaceHas = checkHLProps($arSurfaceName, HL_SURFACE);
    $arGofrHas = checkHLProps($arGofrName, HL_GOFR);
    $arColorHas = checkHLProps($arColorName, HL_COLORS);
    $arGlazingHas = checkHLProps($arGlazingName, HL_GLAZING);
    $arSizeHas = checkHLProps($arSizeName, HL_SIZE);
    $arTypeHas = checkHLProps($arTypeName, HL_TYPE);
    $arMaterialHas = checkHLProps($arMaterialName, HL_MATERIAL);
    $arSoundHas = checkHLProps($arSoundName, HL_SOUND);
    $arIsolationHas = checkHLProps($arIsolationName, HL_ISOLATION);
    $arEnergyHas = checkHLProps($arEnergyName, HL_ENERGY);

//    $arGofrName = [];
//    $arGlazingName = [];
//    $arSizeName = [];
//    $arTypeName = [];
//    $arMaterialName = [];
    foreach ($arColorName as $item) {
        if (!in_array($item, $arColorHas)) {
            $hlblock = HL\HighloadBlockTable::getById(HL_COLORS)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();

            $arFields = array(
//                "UF_COLOR_CODE" => $arColorCode[$item],
                "UF_NAME" => $item,
                "UF_XML_ID" => md5($item),
            );
            if ($arColorFile[$item]) {
                $arFields["UF_IMG"] = $arColorFile[$item];
            }

            $result = $entity_data_class::add($arFields);
            $id = $result->getID();
            array_push($arColorHas, [$id => $item]);
        }
    }


    $arControl = array_unique($arControlName);
    $arCountry = array_unique($arCountryName);
    $arAvailability = array_unique($arAvailabilityName);
    $driveUnit = array_unique($driveUnitName);

    $arLeafWidth = array_unique($arLeafWidthName);
    $arLeafWidthTP = array_unique($arLeafWidthTPName);
    $arLeafHeight = array_unique($arLeafHeightName);
    $arLeafHeightTP = array_unique($arLeafHeightTPName);

    addNewListProps($arControl, $arControlHas, IBLOCK_ID_CATALOG, 115);
    addNewListProps($arCountry, $arCountryHas, IBLOCK_ID_CATALOG, 111);
    addNewListProps($arLeafWidth, $arLeafWidthHas, IBLOCK_ID_CATALOG, 157);
    addNewListProps($arLeafHeight, $arLeafHeightHas, IBLOCK_ID_CATALOG, 158);
    addNewListProps($arLeafWidthTP, $arLeafWidthTPHas, 36, 146);
    addNewListProps($arLeafHeightTP, $arLeafHeightTPHas, 36, 147);
    addNewListProps($driveUnit, $driveUnitHas, 36, 208);

    addNewProps($arSurfaceName, $arSurfaceHas, HL_SURFACE);
    addNewProps($arGofrName, $arGofrHas, HL_GOFR);
    addNewProps($arGlazingName, $arGlazingHas, HL_GLAZING);
    addNewProps($arSizeName, $arSizeHas, HL_SIZE);
    addNewProps($arTypeName, $arTypeHas, HL_TYPE);
    addNewProps($arMaterialName, $arMaterialHas, HL_MATERIAL);
    addNewProps($arSoundName, $arSoundHas, HL_SOUND);
    addNewProps($arIsolationName, $arIsolationHas, HL_ISOLATION);
    addNewProps($arEnergyName, $arEnergyHas, HL_ENERGY);

    $arProperties = [];
//    $properties = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => IBLOCK_ID_CATALOG, "CODE" => ['ISOLATION', 'ENERGY', 'SOUND']));
//    $properties = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => 36, "CODE" => ['ISOLATION', 'ENERGY', 'SOUND']));
//    while ($field = $properties->GetNext()) {
//        $arProperties[$field['PROPERTY_CODE']][$field['VALUE']] = $field['ID'];
//    }

//    foreach ($arSurfaceName as $item){
//        if (!in_array($item,$arSurfaceHas)){
//            $hlblock = HL\HighloadBlockTable::getById(HL_SURFACE)->fetch();
//            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
//            $entity_data_class = $entity->getDataClass();
//
//            $arFields = array(
//                "UF_NAME" => $item,
//                "UF_XML_ID" => md5($item),
//            );
//
//            $result = $entity_data_class::add($arFields);
//            $id = $result->getID();
//            array_push($arSurfaceHas,[$id=>$item]);
//        }
//    }
//    foreach ($arGofrName as $item){
//        if (!in_array($item,$arGofrHas)){
//            $hlblock = HL\HighloadBlockTable::getById(HL_GOFR)->fetch();
//            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
//            $entity_data_class = $entity->getDataClass();
//
//            $arFields = array(
//                "UF_NAME" => $item,
//                "UF_XML_ID" => md5($item),
//            );
//
//            $result = $entity_data_class::add($arFields);
//            $id = $result->getID();
//            array_push($arGofrHas,[$id=>$item]);
//        }
//    }

    $element = new CIBlockElement;
    $catalog = new CCatalogProduct;

    foreach ($data as $dataItem) {
        $productId = false;
        $tags = [];
        $index = 0;
        foreach ($dataItem['MAIN']['TAGS'] as $tag){
            $tags['n'.$index] = array_search($tag, $arTagsHas);
            $index++;
        }
        $slider = [];
        foreach ($dataItem['MAIN']['SLIDER'] as $file){
            $slider[] = ['VALUE' => $file, 'DESCRIPTION' => ''];
        }
        if ($productId = array_search(mb_strtolower($dataItem['MAIN']['NAME']), $arGoodsHas)) {
            $arFields = [
//                "ISOLATION" => $arProperties['ISOLATION'][$dataItem['MAIN']['ISOLATION']],
                "ISOLATION" => $dataItem['OFFERS'][0]['ISOLATION'] ? $dataItem['OFFERS'][0]['ISOLATION'] : '-',
//                "ENERGY" => $arProperties['ENERGY'][$dataItem['MAIN']['ENERGY']],
                "ENERGY" => $dataItem['OFFERS'][0]['ENERGY'] ? $dataItem['OFFERS'][0]['ENERGY'] : '-',
//                "SOUND" => $arProperties['SOUND'][$dataItem['MAIN']['SOUND']],
                "SOUND" => $dataItem['OFFERS'][0]['SOUND'] ? $dataItem['OFFERS'][0]['SOUND'] : '-',
                "CONSTRUCTION" => $dataItem['MAIN']['CONSTRUCTION'],
                "PANEL" => $dataItem['MAIN']['PANEL'],
                "TYPE" => array_search($dataItem['MAIN']['TYPE'], $arTypeHas),
                "MATERIAL" => array_search($dataItem['MAIN']['MATERIAL'], $arMaterialHas),
                'CONTROL' => array_search($dataItem['MAIN']['CONTROL'], $arControlHas),
                'MOUNTING_TYPE' => $dataItem['MAIN']['MOUNTING_TYPE'],
                'TIME' => $dataItem['MAIN']['TIME'],
                'COUNTRY_OF_ORIGIN' => array_search($dataItem['MAIN']['COUNTRY_OF_ORIGIN'], $arCountryHas),
                'APPOINTMENT' => $dataItem['MAIN']['APPOINTMENT'],
                'CANVAS_MATERIAL' => $dataItem['MAIN']['CANVAS_MATERIAL'],
                'ISOLATION_V' => $dataItem['MAIN']['ISOLATION_V'],
                'GUARANTEE' => $dataItem['MAIN']['GUARANTEE'],
                'DRIVE_UNIT' => $dataItem['MAIN']['DRIVE_UNIT'],
                'TAGS' => $tags,
                'CUSTOM_DETAIL_PICTURE' => $dataItem['MAIN']['CUSTOM_DETAIL_PICTURE'],
                'DOOR_LEAF_WIDTH' => array_search($dataItem['MAIN']['DOOR_LEAF_WIDTH'], $arLeafWidthHas),
                'DOOR_LEAF_HEIGHT' => array_search($dataItem['MAIN']['DOOR_LEAF_HEIGHT'], $arLeafHeightHas),
                'DOOR_WEIGHT' => $dataItem['MAIN']['DOOR_WEIGHT'],
                'NUTRITION' => $dataItem['MAIN']['NUTRITION'],
                'NOMINAL_FORCE' => $dataItem['MAIN']['NOMINAL_FORCE'],
                'MAXIMUM_FORCE' => $dataItem['MAIN']['MAXIMUM_FORCE'],
                'MAXIMUM_GATE_TRAVEL_SPEED' => $dataItem['MAIN']['MAXIMUM_GATE_TRAVEL_SPEED'],
                'TEMPERATURE_RANGE' => $dataItem['MAIN']['TEMPERATURE_RANGE'],
                'DRIVE_DEGREE_OF_PROTECTION' => $dataItem['MAIN']['DRIVE_DEGREE_OF_PROTECTION'],
                'TYPE_OF_LIMIT_SWITCH' => $dataItem['MAIN']['TYPE_OF_LIMIT_SWITCH'],
                'AUTO_CLOSE' => $dataItem['MAIN']['AUTO_CLOSE'],
                'MAXIMUM_GATE_AREA' => $dataItem['MAIN']['MAXIMUM_GATE_AREA'],
                'FREQUENCY' => $dataItem['MAIN']['FREQUENCY'],
                'NUMBER_OF_CHANNELS' => $dataItem['MAIN']['NUMBER_OF_CHANNELS'],
                'TYPE_OF_FEEDER' => $dataItem['MAIN']['TYPE_OF_FEEDER'],
                'RADIO_SIGNAL' => $dataItem['MAIN']['RADIO_SIGNAL'],
                'ITEM_NUMBER' => $dataItem['MAIN']['ITEM_NUMBER'],
                'WXHXH_DIMENSIONS' => $dataItem['MAIN']['WXHXH_DIMENSIONS'],
                'WIRE_TYPE' => $dataItem['MAIN']['WIRE_TYPE'],
                'PACKAGE_CONTENTS' => $dataItem['MAIN']['PACKAGE_CONTENTS'],
                'PROTECTION_LEVEL' => $dataItem['MAIN']['PROTECTION_LEVEL'],
                'CABLE_LENGTH' => $dataItem['MAIN']['CABLE_LENGTH'],
                'DIAMETER_OF_THE_HOLE' => $dataItem['MAIN']['DIAMETER_OF_THE_HOLE'],
            ];
            $res = CIBlockElement::SetPropertyValuesEx($productId, IBLOCK_ID_CATALOG, $arFields);
            if ($slider) {
                $db_props = CIBlockElement::GetProperty(IBLOCK_ID_CATALOG, $productId, [], ["CODE"=>"SLIDER"]);
                while ($ar_props = $db_props->Fetch()) {
                    $res = CIBlockElement::SetPropertyValueCode($productId, 'SLIDER', [$ar_props['PROPERTY_VALUE_ID'] => ['del' => 'Y', 'tmp_name' => '']]);
                    CFile::Delete($ar_props['VALUE']);
                }
                $PROPERTY_VALUE = array(
                    0 => array("VALUE"=>"","DESCRIPTION"=>"")
                );
                $res = CIBlockElement::SetPropertyValuesEx($productId, IBLOCK_ID_CATALOG, ['SLIDER' => $PROPERTY_VALUE]);
                $res = CIBlockElement::SetPropertyValueCode($productId, 'SLIDER', $slider);
            }

            $arFields = [
                "IBLOCK_SECTION_ID" => $arSectionHas[$dataItem['MAIN']['SECTION']],
                'PREVIEW_TEXT' => $dataItem['MAIN']['PREVIEW_TEXT'],
                'PREVIEW_PICTURE' => $dataItem['MAIN']['PREVIEW_PICTURE'],
                'DETAIL_TEXT' => $dataItem['MAIN']['DETAIL_TEXT'],
                'DETAIL_PICTURE' => $dataItem['MAIN']['DETAIL_PICTURE'],
            ];

            $element->Update($productId, $arFields);
        } else {
            $arFields = Array(
                "IBLOCK_SECTION_ID" => $arSectionHas[$dataItem['MAIN']['SECTION']],
                "IBLOCK_ID" => IBLOCK_ID_CATALOG,
                "PROPERTY_VALUES" => [
//                "ISOLATION" => $arProperties['ISOLATION'][$dataItem['MAIN']['ISOLATION']],
                    "ISOLATION" => $dataItem['OFFERS'][0]['ISOLATION'],
//                "ENERGY" => $arProperties['ENERGY'][$dataItem['MAIN']['ENERGY']],
                    "ENERGY" => $dataItem['OFFERS'][0]['ENERGY'],
//                "SOUND" => $arProperties['SOUND'][$dataItem['MAIN']['SOUND']],
                    "SOUND" => $dataItem['OFFERS'][0]['SOUND'],
                    "CONSTRUCTION" => $dataItem['MAIN']['CONSTRUCTION'],
                    "PANEL" => $dataItem['MAIN']['PANEL'],
                    "TYPE" => array_search($dataItem['MAIN']['TYPE'], $arTypeHas),
                    "MATERIAL" => array_search($dataItem['MAIN']['MATERIAL'], $arMaterialHas),
                    'CONTROL' => array_search($dataItem['MAIN']['CONTROL'], $arControlHas),
                    'MOUNTING_TYPE' => $dataItem['MAIN']['MOUNTING_TYPE'],
                    'TIME' => $dataItem['MAIN']['TIME'],
                    'COUNTRY_OF_ORIGIN' => array_search($dataItem['MAIN']['COUNTRY_OF_ORIGIN'], $arCountryHas),
                    'APPOINTMENT' => $dataItem['MAIN']['APPOINTMENT'],
                    'CANVAS_MATERIAL' => $dataItem['MAIN']['CANVAS_MATERIAL'],
                    'ISOLATION_V' => $dataItem['MAIN']['ISOLATION_V'],
                    'GUARANTEE' => $dataItem['MAIN']['GUARANTEE'],
                    'DRIVE_UNIT' => $dataItem['MAIN']['DRIVE_UNIT'],
                    'TAGS' => $tags,
                    'CUSTOM_DETAIL_PICTURE' => $dataItem['MAIN']['CUSTOM_DETAIL_PICTURE'],
                    'DOOR_LEAF_WIDTH' => array_search($dataItem['MAIN']['DOOR_LEAF_WIDTH'], $arLeafWidthHas),
                    'DOOR_LEAF_HEIGHT' => array_search($dataItem['MAIN']['DOOR_LEAF_HEIGHT'], $arLeafHeightHas),
                    'DOOR_WEIGHT' => $dataItem['MAIN']['DOOR_WEIGHT'],
                    'NUTRITION' => $dataItem['MAIN']['NUTRITION'],
                    'NOMINAL_FORCE' => $dataItem['MAIN']['NOMINAL_FORCE'],
                    'MAXIMUM_FORCE' => $dataItem['MAIN']['MAXIMUM_FORCE'],
                    'MAXIMUM_GATE_TRAVEL_SPEED' => $dataItem['MAIN']['MAXIMUM_GATE_TRAVEL_SPEED'],
                    'TEMPERATURE_RANGE' => $dataItem['MAIN']['TEMPERATURE_RANGE'],
                    'DRIVE_DEGREE_OF_PROTECTION' => $dataItem['MAIN']['DRIVE_DEGREE_OF_PROTECTION'],
                    'TYPE_OF_LIMIT_SWITCH' => $dataItem['MAIN']['TYPE_OF_LIMIT_SWITCH'],
                    'AUTO_CLOSE' => $dataItem['MAIN']['AUTO_CLOSE'],
                    'MAXIMUM_GATE_AREA' => $dataItem['MAIN']['MAXIMUM_GATE_AREA'],
                    'FREQUENCY' => $dataItem['MAIN']['FREQUENCY'],
                    'NUMBER_OF_CHANNELS' => $dataItem['MAIN']['NUMBER_OF_CHANNELS'],
                    'TYPE_OF_FEEDER' => $dataItem['MAIN']['TYPE_OF_FEEDER'],
                    'RADIO_SIGNAL' => $dataItem['MAIN']['RADIO_SIGNAL'],
                    'ITEM_NUMBER' => $dataItem['MAIN']['ITEM_NUMBER'],
                    'WXHXH_DIMENSIONS' => $dataItem['MAIN']['WXHXH_DIMENSIONS'],
                    'WIRE_TYPE' => $dataItem['MAIN']['WIRE_TYPE'],
                    'PACKAGE_CONTENTS' => $dataItem['MAIN']['PACKAGE_CONTENTS'],
                    'PROTECTION_LEVEL' => $dataItem['MAIN']['PROTECTION_LEVEL'],
                    'CABLE_LENGTH' => $dataItem['MAIN']['CABLE_LENGTH'],
                    'DIAMETER_OF_THE_HOLE' => $dataItem['MAIN']['DIAMETER_OF_THE_HOLE'],
                ],
                'PREVIEW_TEXT' => $dataItem['MAIN']['PREVIEW_TEXT'],
                'PREVIEW_PICTURE' => $dataItem['MAIN']['PREVIEW_PICTURE'],
                'DETAIL_TEXT' => $dataItem['MAIN']['DETAIL_TEXT'],
                'DETAIL_PICTURE' => $dataItem['MAIN']['DETAIL_PICTURE'],
                "NAME" => $dataItem['MAIN']['NAME'],
                "CODE" => translit($dataItem['MAIN']['NAME']),
                "ACTIVE" => "Y",
            );
            if ($productId = $element->Add($arFields)){
                $res = CIBlockElement::SetPropertyValueCode($productId, 'SLIDER', $slider);
            } else {
                var_dump($element->LAST_ERROR);
            }
        }
        foreach ($dataItem['OFFERS'] as $offer) {
//            if ($offerId = array_search($offer['NAME'], $arOffersHas)) {
//                unset($arOffersHas[$offerId]);
//                var_dump($offerId);
//                $arFields = Array(
//                    "SIZE" => array_search($offer['SIZE'], $arSizeHas),
//                    "GOFR" => array_search($offer['GOFR'], $arGofrHas),
//                    "SURFACE" => array_search($offer['SURFACE'], $arSurfaceHas),
//                    "COLOR" => array_search($offer['COLOR_NAME'], $arColorHas),
//                    "GLAZING" => array_search($offer['GLAZING_NAME'], $arGlazingHas),
//                );
//                $res = CIBlockElement::SetPropertyValuesEx($offerId, 36, $arFields);
//                var_dump($res);
//            }
            $arFields = Array(
                "PROPERTY_VALUES" => [
                    "SIZE" => array_search($offer['SIZE'], $arSizeHas),
                    "GOFR" => array_search($offer['GOFR'], $arGofrHas),
                    "SURFACE" => array_search($offer['SURFACE'], $arSurfaceHas),
                    "COLOR" => array_search($offer['COLOR_NAME'], $arColorHas),
                    "GLAZING" => array_search($offer['GLAZING_NAME'], $arGlazingHas),
                    "CML2_LINK" => $productId,
//                    "ISOLATION" => $arProperties['ISOLATION'][(int)$offer['ISOLATION']],
                    "ISOLATION" => array_search(strval($offer['ISOLATION']), $arIsolationHas),
//                    "ENERGY" => $arProperties['ENERGY'][(int)$offer['ENERGY']],
                    "ENERGY" => array_search(strval($offer['ENERGY']), $arEnergyHas),
//                    "SOUND" => $arProperties['SOUND'][(int)$offer['SOUND']],
                    "SOUND" => array_search(strval($offer['SOUND']), $arSoundName),
                    "AVAILABILITY" => array_search($offer['AVAILABILITY'], $arAvailabilityHas),'DOOR_LEAF_WIDTH' => $items[13]->getValue(), //list
                    'DOOR_LEAF_HEIGHT' => array_search($offer['DOOR_LEAF_WIDTH'], $arLeafHeightTPHas), //list
                    'DOOR_WEIGHT' => array_search($offer['DOOR_WEIGHT'], $arLeafWidthTPHas), //list
                    'NUTRITION' => $offer['NUTRITION'], //str
                    'NOMINAL_FORCE' => $offer['NOMINAL_FORCE'], //str
                    'MAXIMUM_FORCE' => $offer['MAXIMUM_FORCE'], //str
                    'MAXIMUM_GATE_TRAVEL_SPEED' => $offer['MAXIMUM_GATE_TRAVEL_SPEED'], //str
                    'TEMPERATURE_RANGE' => $offer['TEMPERATURE_RANGE'], //str
                    'DRIVE_DEGREE_OF_PROTECTION' => $offer['DRIVE_DEGREE_OF_PROTECTION'], //str
                    'TYPE_OF_LIMIT_SWITCH' => $offer['TYPE_OF_LIMIT_SWITCH'], //str
                    'APPOINTMENT' => $offer['APPOINTMENT'], //str
                    'CANVAS_MATERIAL' => $offer['CANVAS_MATERIAL'], //str
                    'ISOLATION_V' => $offer['ISOLATION_V'], //str
                    'SEALANT' => $offer['SEALANT'], //str
                    'WEB_THICKNESS' => $offer['WEB_THICKNESS'], //str
                    'BOX_THICKNESS' => $offer['BOX_THICKNESS'], //str
                    'HINGE_TYPE' => $offer['HINGE_TYPE'], //str
                    'THERMAL_BREAK_DOOR' => $offer['THERMAL_BREAK_DOOR'], //str
                    'THERMAL_BREAK_BOX' => $offer['THERMAL_BREAK_BOX'], //str
                    'ANTI_REMOVABLE_BAR' => $offer['ANTI_REMOVABLE_BAR'], //str
                    'LOCK' => $offer['LOCK'], //str
                    'FILLING' => $offer['FILLING'], //str
                    'MAXIMUM_GATE_AREA' => $offer['MAXIMUM_GATE_AREA'], //str
                    'FREQUENCY' => $offer['FREQUENCY'], //str
                    'NUMBER_OF_CHANNELS' => $offer['NUMBER_OF_CHANNELS'], //str
                    'TYPE_OF_FEEDER' => $offer['TYPE_OF_FEEDER'], //str
                    'RADIO_SIGNAL' => $offer['RADIO_SIGNAL'], //str
                    'ITEM_NUMBER' => $offer['ITEM_NUMBER'], //str
                    'WXHXH_DIMENSIONS' => $offer['WXHXH_DIMENSIONS'], //str
                    'WIRE_TYPE' => $offer['WIRE_TYPE'], //str
                    'PACKAGE_CONTENTS' => $offer['PACKAGE_CONTENTS'], //str
                    'PROTECTION_LEVEL' => $offer['PROTECTION_LEVEL'], //str
                    'CABLE_LENGTH' => $offer['CABLE_LENGTH'], //str
                    'DIAMETER_OF_THE_HOLE' => $offer['DIAMETER_OF_THE_HOLE'], //str
                    'DRIVE_UNIT' => array_search($offer['DRIVE_UNIT'], $driveUnitHas), //list
                ],
                "NAME" => $offer['NAME'],
                "PREVIEW_PICTURE" => $offer['PREVIEW_PICTURE'],
//                "CODE" => translit($offer['NAME']),
                "ACTIVE" => "Y",
                "IBLOCK_ID" => 36,
            );
            if (!$offerId = $element->add($arFields)){
                var_dump($element->LAST_ERROR);
            }
            $offerIdSup = $offerId;
            $arFields = array('ID' => $offerId, 'AVAILABLE' => 'Y', 'QUANTITY' => 0,);
            if (!$offerId = $catalog->Add($arFields)){
                var_dump($catalog->LAST_ERROR);
            }
            $arFieldsPrice = array(
                "PRODUCT_ID" => $offerIdSup,
                "CATALOG_GROUP_ID" => 1,
                "PRICE" => preg_replace("/[^,.0-9]/", '', $offer['PRICE']),
                "CURRENCY" => "RUB",
            );
            if (!$res = CPrice::Add($arFieldsPrice)){
                var_dump($res);
            }
        }
    }
}