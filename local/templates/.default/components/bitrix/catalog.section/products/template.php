<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

    <div class="catalogue__content">
    <? $APPLICATION->IncludeComponent("itech:tag-list", "", [
        'IBLOCK_ID' => IBLOCK_ID_TAGS,
        'ITEMS' => $arResult['ITEMS'],
    ]); ?>

        <div class="catalogue__list">
        <div class="catalogue__row">
            <? foreach ($arResult['ITEMS'] as $item): ?>
                <? $APPLICATION->IncludeComponent(
                    'bitrix:catalog.item',
                    'products',
                    array(
                        'RESULT' => array(
                            'ITEM' => $item,
//                            'AREA_ID' => $areaIds[$item['ID']],
                            "SECTION" => $arResult["SECTIONS"][$item["IBLOCK_SECTION_ID"]],
                            'TYPE' => 'CARD',
                            'BIG_LABEL' => 'N',
                            'BIG_DISCOUNT_PERCENT' => 'N',
                            'BIG_BUTTONS' => 'N',
                            'SCALABLE' => 'N',
                            "TAG" => $arResult["TAGS"][$item["PROPERTIES"]["TEXTURE"]["VALUE"]],
//                            "LIKED" => in_array($item["ID"], $favorites),
                        ),
                        'PARAMS' => array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                ); ?>
            <? endforeach; ?>
        </div>
        <? if ($arResult['NAV_RESULT']->NavPageCount != 1): ?>
            <div class="pagination wow" data-wow-offset="200">
                <div class="pagination__row">
                    <?= $arResult['NAV_STRING'] ?>
                </div>
            </div>
        <? endif; ?>
        <div class="subtext wow page-text-list" data-wow-offset="200"><?=$arResult['~UF_BOTTOM_SECTION_TEXT']?></div>
    </div>
</div>

<script>
  window.productCount = {"count": <?=count($arResult['ITEMS'])?>};
</script>