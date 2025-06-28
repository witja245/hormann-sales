<?php


namespace Itech;

use Bitrix\Iblock\ElementPropertyTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\EO_Property;
use Bitrix\Iblock\PropertyTable;
use \Bitrix\Main\Loader;
use \Itech\Helper;
use \Bitrix\Main\Data\Cache;

class Tag
{
    private $tagCode;

    public function __construct(string $tagCode)
    {
        if (!Loader::includeModule('iblock'))
            exit('Модуль инфоблок недоступен');

        $this->tagCode = $tagCode;
    }

    private function getData(): array
    {
        global $APPLICATION;
        $tagCode = $this->tagCode;

        $tagDb = ElementTable::getList([
            'filter' => ['IBLOCK_ID' => IBLOCK_ID_TAGS, 'ACTIVE' => 'Y', 'CODE' => $tagCode],
            'select' => ['ID', 'NAME', 'CODE']
        ])->fetchObject();

        if (!$tagDb) {
            \Bitrix\Iblock\Component\Tools::process404(
                "", true, true, true, ""
            );
        }

        $tagId = $tagDb->getId();
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(IBLOCK_ID_TAGS, $tagId);
        $seo = $ipropValues->getValues();

        if (!$seo) {
            $seo['ELEMENT_PAGE_TITLE'] = $tagDb->getName();
        }

        $result = [];
        $iterator = \CIBlockElement::GetProperty(IBLOCK_ID_TAGS, $tagId, [], array("CODE" => "PRODUCTS"));
        while ($row = $iterator->Fetch()) {
            $result['PRODUCTS'][] = $row['VALUE'];
        }
        $result['SEO'] = $seo;

        return $result;
    }

    public function getProducts(): array
    {
        $data = \Itech\ManagedCache::cache('/tags/' . $this->tagCode, 360000, function () {
            return $this->getData();
        });

        if ($data['SEO']) {
            $this->setSeo($data['SEO']);
        }

        return $data['PRODUCTS'];
    }

    private function setSeo(array $seo): void
    {
        global $APPLICATION;
        $chainName = $seo['ELEMENT_PAGE_TITLE'];
        $title = $seo['ELEMENT_META_TITLE'];
        $description = $seo['ELEMENT_META_DESCRIPTION'];

        if ($chainName) {
            $APPLICATION->SetTitle($chainName);
        }

        if ($title) {
            $APPLICATION->SetPageProperty('title', $title);
        }

        if ($description) {
            $APPLICATION->SetPageProperty('description', $description);
        }

        $APPLICATION->AddChainItem($chainName, '');
    }
}