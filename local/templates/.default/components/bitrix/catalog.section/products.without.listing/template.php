<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<h2 class="wow" data-wow-offset="200"><a href="/products/">Каталог</a></h2>
<div class="sked wow" data-wow-offset="200">
    <div class="sked__row">
        <? foreach ($arResult['ITEMS'] as $item): ?>
            <? $APPLICATION->IncludeComponent(
                'bitrix:catalog.item',
                'products.without.listing',
                array(
                    'RESULT' => array(
                        'ITEM' => $item,
                        "SECTION" => $arResult["SECTIONS"][$item["IBLOCK_SECTION_ID"]],
                        'TYPE' => 'CARD',
                        'BIG_LABEL' => 'N',
                        'BIG_DISCOUNT_PERCENT' => 'N',
                        'BIG_BUTTONS' => 'N',
                        'SCALABLE' => 'N',
                        "TAG" => $arResult["TAGS"][$item["PROPERTIES"]["TEXTURE"]["VALUE"]],
                    ),
                    'PARAMS' => array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            ); ?>
        <? endforeach; ?>
        <div class="sked__col">
            <div class="sked__box">
                <div class="subtext">Нужна консультация по промышленным&nbsp;воротам?</div>
                <div class="sked__box__row">
                    <div class="sked__box__tel"><a href="tel:<?echo \COption::GetOptionString( "askaron.settings", "UF_PHONE" )[1];?>"><?echo \COption::GetOptionString( "askaron.settings", "UF_PHONE" )[1];?></a></div>
                    <div class="sked__box__email"><a href="mailto:<?echo \COption::GetOptionString( "askaron.settings", "UF_MAIL" )[0];?>"><?echo \COption::GetOptionString( "askaron.settings", "UF_MAIL" )[0];?></a></div>
                </div>
                <div class="sked__box__link"><a href="/ask/">Задать вопрос</a></div>
            </div>
        </div>
    </div>
</div>