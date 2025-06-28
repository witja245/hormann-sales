<?php


namespace Itech;


class Stores
{
    private static function getHlEntityByCode(string $code): ?string
    {
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['NAME' => $code]])->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        return $entity->getDataClass();
    }

    public static function getStoresByProductId(int $productId): ?array
    {
        $stores = null;
        $rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
            'filter' => ['=PRODUCT_ID' => $productId, 'STORE.ACTIVE' => 'Y', '>AMOUNT' => 0],
            'select' => ['AMOUNT', 'STORE_ID', 'STORE_XML_ID' => 'STORE.XML_ID'],
            'cache' => [
                'ttl' => 360000,
                'cache-joins' => true
            ]
        ));

        while ($arStoreProduct = $rsStoreProduct->fetch()) {
            $stores[] = $arStoreProduct;
        }

        return $stores;
    }

    public static function getStoreOrShop(array $storesXmlId): ?array
    {
        $element = null;

        $entity = self::getHlEntityByCode('Sklady');
        $elements = [];
        $elementsDb = $entity::getList([
            'filter' => ['UF_XML_ID' => $storesXmlId, 'UF_POMETKAUDALENIYA' => false, '!UF_PODRAZDELENIE' => ''],
            'group' => ['UF_PODRAZDELENIE'],
            'select' => ['UF_PODRAZDELENIE']
        ]);
        while ($el = $elementsDb->fetch()) {
            $elements[] = $el['UF_PODRAZDELENIE'];
        }

        if (!$elements)
            return null;

        $elements = [];
        $storesIblockElements = \CIBlockElement::getList(
            ['SORT' => 'ASC'],
            ['ACTIVE' => 'Y', 'NAME' => $elements, 'IBLOCK_ID' => IBLOCK_ID_STORES]
        );

        while ($store = $storesIblockElements->GetNextElement()) {
            $elements[] = [
                'FIELDS' => $store->getFields(),
                'PROPERTIES' => $store->getProperties()
            ];
        }


        return $elements;

    }
}