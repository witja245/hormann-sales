<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

class ItechTagList extends \CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {

        return $arParams;
    }

    public function executeComponent()
    {
        $this->arResult['TAGS'] = $this->getTags($this->arParams['IBLOCK_ID'], $this->arParams['ITEMS']);

        $this->includeComponentTemplate();
    }

    private function getTags($iblockId, $items)
    {
        if (CModule::IncludeModule('iblock')) {

            $tagsId = [];
            foreach ($items as $item){
                foreach ($item['PROPERTIES']['TAGS']['VALUE'] as $tag){
                    $tagsId[$tag] = $tag;
                }
            }

            $tags = [];

            if ($tagsId){
                $arFilter = [
                    "IBLOCK_ID" => $iblockId,
                    'ID' => $tagsId,
                    'ACTIVE' => 'Y',
                ];
                $tagsRes = CIBlockElement::GetList([], $arFilter, false, [], ['ID', 'NAME', 'DETAIL_PAGE_URL', 'PROPERTY_ALT_NAME']);
                while($tag = $tagsRes->GetNext()){
                    $tags[$tag['ID']] = [
                        "NAME" => $tag['~PROPERTY_ALT_NAME_VALUE']?:$tag['~NAME'],
                        "URL" => $tag['DETAIL_PAGE_URL'],
                    ];
                }

                return $tags;
            }
            return false;
        }
        return false;
    }
}
