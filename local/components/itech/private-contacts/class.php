<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ItechPrivateContacts extends \CBitrixComponent
{
    public $setSections = [];

    public function onPrepareComponentParams($arParams)
    {

        return $arParams;
    }

    public function executeComponent()
    {
        $city = $this->getCityId($this->arParams['CITY']);

        $sections = $this->getRepresentativeSection($this->arParams['IBLOCK_ID']);

        $elements = $this->getRepresentativeElement($this->arParams['IBLOCK_ID'], $sections, $city['FIELDS']['ID']);

        foreach ($sections as $key=>$section){
            if (!in_array($key,$this->setSections)){
                unset($sections[$key]);
            }
        }

        $this->arResult['SECTIONS'] = $sections;

        $this->arResult['ELEMENTS'] = $elements;

        $this->includeComponentTemplate();
    }

    private function getRepresentativeSection($iblockId)
    {
        if (CModule::IncludeModule('iblock')) {
            $arSelect = ['ID', 'IBLOCK_ID', 'NAME',];
            $arFilter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'];
            $res = CIBlockSection::GetList([], $arFilter, false, $arSelect, []);
            $arSections = [];
            $index = 0;
            while ($element = $res->GetNext()) {
                $index++;
                $arSections[$element['ID']] = $element;
                $arSections[$element['ID']]['TYPE'] = $index;
            }
            return $arSections;
        }
        return false;
    }

    private function getRepresentativeElement($iblockId, $sections, $cityId)
    {
        if (CModule::IncludeModule('iblock')) {
            $arSelect = [];
            $arFilter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y', 'PROPERTY_CITY' => $cityId];
            $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
            $elements = [];
            while ($element = $res->GetNextElement()) {

                $arFields = $element->GetFields();
                $arProperties = $element->GetProperties();
                $arElement = [
                    'FIELDS' => $arFields,
                    'PROPERTIES' => $arProperties,
                ];
                $resSections = CIBlockElement::GetElementGroups($arElement['FIELDS']['ID'], true);

                while ($section = $resSections->GetNext()) {

                    $arElement['SECTIONS'][$section['ID']] = $section;
                    $this->setSections[$section['ID']] = $section['ID'];
                }

                $elements[] = $arElement;
            }

            return $elements;

//            foreach ($elements as $section){
//                foreach ($section['SECTIONS'] as $item) {
//                    $sections[$item['ID']]['ITEMS'][] = $section;
//                }
//            }
//            foreach ($elements as $section){
//                foreach ($section['SECTIONS'] as $item) {
//                    $sections[$item['ID']]['ITEMS'][] = $section;
//                }
//            }

//            return $sections;
        }
        return false;
    }

    private function getCityId($city)
    {
        if (CModule::IncludeModule('iblock')) {
            $arSelect = [];
            $arFilter = ['CODE' => $city['CODE'], 'ACTIVE' => 'Y'];
            $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
            $city = false;
            if ($element = $res->GetNextElement()) {
                $arFields = $element->GetFields();
                $arProperties = $element->GetProperties();
                $city = [
                    'FIELDS' => $arFields,
                    'PROPERTIES' => $arProperties,
                ];
            }
            return $city;
        }
        return false;
    }
}
