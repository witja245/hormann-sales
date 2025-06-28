<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ItechCities extends \CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {

        return $arParams;
    }

    public function executeComponent()
    {
        $this->arResult['ITEMS'] = $this->getCities($this->arParams['IBLOCK_ID']);

        $this->includeComponentTemplate();
    }

    private function getCities($iblockId)
    {
        if (CModule::IncludeModule('iblock')) {
            $arSelect = [];
            $arFilter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y',];
            $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
            $elements = [];
            while ($element = $res->GetNextElement()) {

                $arFields = $element->GetFields();
                $arProperties = $element->GetProperties();
                $arElement = [
                    'FIELDS' => $arFields,
                    'PROPERTIES' => $arProperties,
                ];

                $elements[] = $arElement;
            }

            $elements=array_chunk($elements,17, true);
            
            return $elements;
        }
        return false;
    }
}
