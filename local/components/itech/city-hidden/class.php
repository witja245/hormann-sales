<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

class ItechCitiesHidden extends \CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {

        return $arParams;
    }

    public function executeComponent()
    {
        $result                     = $this->getCities($this->arParams['IBLOCK_ID']);
        $this->arResult['ITEMS']    = $result['elements'];
        $this->arResult['BRANCHES'] = $result['branches'];

        $this->includeComponentTemplate();
    }

    private function getCities($iblockId)
    {
        if (CModule::IncludeModule('iblock'))
        {
            $arSelect = [];
            $arFilter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'];
            $res      = CIBlockElement::GetList(['SORT' => 'ASC'], $arFilter, false, false, $arSelect);
            $elements = [];
            $main     = '';

            while ($element = $res->GetNextElement())
            {
                $arFields     = $element->GetFields();
                $arProperties = $element->GetProperties();
                $arElement    = [
                    'FIELDS'     => $arFields,
                    'PROPERTIES' => $arProperties,
                ];

                // Если свойство HAS_BRANCH заполнено, добавляем элемент в массив $branches
                if (!empty($arProperties['HAS_BRANCH']['VALUE']))
                {
                    $branches[] = $arElement;
                }

                // Определяем букву, с которой начинается название города
                $firstLetter = mb_substr(mb_strtoupper($arFields['NAME']), 0, 1);

                // Проверяем, существует ли уже подмассив для этой буквы, и создаем его, если нет
                if (!isset($elements[$firstLetter]))
                {
                    $elements[$firstLetter] = [];
                }

                // Добавляем город в соответствующий подмассив
                $elements[$firstLetter][] = $arElement;

                // Если город - Москва, сохраняем его в особом подмассиве
                if ($arFields['NAME'] == 'Москва')
                {
                    $main = $arElement;
                }
            }

            // Сортируем подмассивы по ключам (буквам алфавита) в алфавитном порядке
            ksort($elements);

            // Добавляем город Москву в основной подмассив
            $elements['MAIN'] = $main;

            return ['elements' => $elements, 'branches' => $branches];;
        }

        return false;
    }
}
