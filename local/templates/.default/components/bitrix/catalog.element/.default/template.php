<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
    'STICKER_ID' => $mainId . '_sticker',
//    'BIG_SLIDER_ID' => $mainId . '_big_slider',
    'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
//    'SLIDER_CONT_ID' => $mainId . '_slider_cont',
    'OLD_PRICE_ID' => $mainId . '_old_price',
    'PRICE_ID' => $mainId . '_price',
    'DESCRIPTION_ID' => $mainId . '_description',
    'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
    'PRICE_TOTAL' => $mainId . '_price_total',
//    'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
    'QUANTITY_ID' => $mainId . '_quantity',
    'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
    'QUANTITY_UP_ID' => $mainId . '_quant_up',
    'QUANTITY_MEASURE' => $mainId . '_quant_measure',
    'QUANTITY_LIMIT' => $mainId . '_quant_limit',
    'BUY_LINK' => $mainId . '_buy_link',
    'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
    'COMPARE_LINK' => $mainId . '_compare_link',
    'TREE_ID' => $mainId . '_skudiv',
    'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
    'OFFER_GROUP' => $mainId . '_set_group_',
    'BASKET_PROP_DIV' => $mainId . '_basket_prop',
    'SUBSCRIBE_LINK' => $mainId . '_subscribe',
    'TABS_ID' => $mainId . '_tabs',
    'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
    'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
$offerPictures = [];
$dividedOfferPictures = [];
if ($haveOffers) {
    $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
        ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
        : reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['MORE_PHOTO_COUNT'] > 1) {
            $showSliderControls = true;
//            break;
        }
        $file = CFile::ResizeImageGet($offer['PREVIEW_PICTURE'], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_EXACT , true);
        $offerPictures[$offer['ID']] = [
            'XML_ID' => $offer['PROPERTIES']['COLOR']['VALUE'],
            'PREVIEW_PICTURE' => $file['src'],
        ];
        $dividedOfferPictures[$offer['PROPERTIES']['GOFR']['VALUE']][$offer['PROPERTIES']['COLOR']['VALUE']] = $file['src'];
    }
} else {
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y') {
    $skuDescription = false;
    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '') {
            $skuDescription = true;
            break;
        }
    }
    $showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
} else {
    $showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}
?>
    <div class="card wow" id="<?= $itemIds['ID'] ?>" itemscope
         itemtype="http://schema.org/Product" data-wow-offset="200">
        <div class="card__image">
            <img    class="js-card__image"
                    src="<?= $arResult['PROPERTIES']['CUSTOM_DETAIL_PICTURE']['VALUE'] ? CFile::GetPath($arResult['PROPERTIES']['CUSTOM_DETAIL_PICTURE']['VALUE']) : $arResult['PREVIEW_PICTURE']['SRC'] ?>"
                    alt=""
                    data-main-picture="<?= $arResult['PROPERTIES']['CUSTOM_DETAIL_PICTURE']['VALUE'] ? CFile::GetPath($arResult['PROPERTIES']['CUSTOM_DETAIL_PICTURE']['VALUE']) : $arResult['PREVIEW_PICTURE']['SRC'] ?>"
            >
        </div>

        <div class="card__content" id="<?= $itemIds['TREE_ID'] ?>">
            <h1 class="h2" itemprop="name"><?= $name ?></h1>
            <div class="card__text" itemprop="offers" itemscope 
            itemtype="https://schema.org/Offer"><?= $arResult['PREVIEW_TEXT'] ?></div>
            <?
            foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName) {
                switch ($blockName) {
                    case 'sku':
                        if ($haveOffers && !empty($arResult['OFFERS_PROP'])) {
                            ?>
                            <?
                            foreach ($arResult['SKU_PROPS'] as $propId => $skuProperty) {
                                if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
                                    continue;

                                $propertyId = $skuProperty['ID'];
                                $skuProps[] = array(
                                    'ID' => $propertyId,
                                    'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                                    'VALUES' => $skuProperty['VALUES'],
                                    'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
                                );
                                ?>
                                <? if ($skuProperty['CODE'] == 'SIZE'): ?>
                                    <div class="card__item" data-entity="sku-line-block">
                                        <div class="card__label"><?= htmlspecialcharsEx($skuProperty['NAME']) ?></div>
                                        <div class="card__item__select">
                                            <select class="main-props" name="<?= $skuProperty['CODE'] ?>">
                                                <?
                                                $flag = true;
                                                foreach ($skuProperty['VALUES'] as $key => &$value) {
                                                    if ($value == end($skuProperty['VALUES'])) {
//                                                        unset($skuProperty['VALUES'][$key]);
                                                        continue;
                                                    }
                                                    ?>
                                                    <option class="props"
                                                            data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                            data-onevalue="<?= $value['ID'] ?>"
                                                            value="<?= $key ?>">
                                                        <?= $value['NAME'] ?>
                                                    </option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                <?endif; ?>
                                <? if ($skuProperty['CODE'] == 'GOFR' || $skuProperty['CODE'] == 'SURFACE'): ?>
                                    <div class="card__item" data-entity="sku-line-block">
                                        <div class="card__label"><?= htmlspecialcharsEx($skuProperty['NAME']) ?>
                                            <? if ($skuProperty['CODE'] == 'GOFR'): ?>
                                                <a class="help" href="#help-gofr" data-fancybox>?</a>
                                            <? elseif ($skuProperty['CODE'] == 'SURFACE'): ?>
                                                <a class="help" href="#help-surface" data-fancybox>?</a>
                                            <? endif; ?>
                                        </div>
                                        <div class="card__item__row">
                                            <?
                                            $flag = true;
                                            foreach ($skuProperty['VALUES'] as $key => &$value) {
                                                if ($value == end($skuProperty['VALUES'])) {
//                                                        unset($skuProperty['VALUES'][$key]);
                                                    continue;
                                                }
                                                $value['NAME'] = htmlspecialcharsbx($value['NAME']); ?>
                                                <div class="radio">
                                                    <label>
                                                        <input class="main-props props <?= $skuProperty['CODE'] == 'GOFR'?'js-gofr-help':'' ?>" type="radio"
                                                               name="<?= $skuProperty['CODE'] ?>"
                                                               title="<?= $value['NAME'] ?>"
                                                               data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                               data-onevalue="<?= $value['ID'] ?>"
                                                               data-key="<?= $key ?>"
                                                               <?= $flag ? 'checked' : '' ?>>
                                                        <i></i>
                                                        <span><?= $value['NAME'] ?></span>
                                                    </label>
                                                </div>
                                                <?
                                                $flag = false;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <? elseif ($skuProperty['CODE'] == 'COLOR'): ?>
                                    <div class="card__item" data-entity="sku-line-block">
                                        <div class="card__label"><?= htmlspecialcharsEx($skuProperty['NAME']) ?>: <span>Ночной дуб</span>
                                        </div>
                                        <div class="color">
                                            <?
                                            $flag = true;
                                            foreach ($skuProperty['VALUES'] as $key => &$value) {
                                                if ($value == end($skuProperty['VALUES'])) {
//                                                        unset($skuProperty['VALUES'][$key]);
                                                    continue;
                                                }

                                                $value['PICT'] = $arResult['COLORS'][$value['XML_ID']]['PICTURE'];
                                                $value['NAME'] = htmlspecialcharsbx($value['NAME']);
//                                                    if ($value['PICT']['SRC']) {
                                                ?>
                                                <label> <?/*style="background: <?=$arResult['COLORS'][$value['XML_ID']]['UF_COLOR_CODE']?>"*/
                                                    ?>
                                                    <input class="main-props props1 js-color-help <?= $flag ? 'js-color-setup' : '' ?>" type="radio"
                                                           name="<?= $skuProperty['CODE'] ?>"
                                                           <?= $flag ? 'checked' : '' ?>
                                                           title="<?= $value['NAME'] ?>"
                                                           data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                           data-onevalue="<?= $value['ID'] ?>">
                                                    <?if($flag):?>
                                                        <script>document.querySelector('.js-color-setup').click()</script>
                                                    <?endif;?>
                                                    <img src="<?= $value['PICT']['SRC'] ?>">
                                                    <i></i>
                                                </label>
                                                <?
//                                                    }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <? elseif ($skuProperty['CODE'] == 'GLAZING'): ?>
                                    <?
                                    $glazingFlag = false;
                                    foreach ($skuProperty['VALUES'] as $key => $value) {
                                        if ($value['PICT']) {
                                            $glazingFlag = true;
                                            break;
                                        }
                                    } ?>
                                    <div class="card__item" data-entity="sku-line-block">
                                        <div class="card__label">
                                            <?= htmlspecialcharsEx($skuProperty['NAME']) ?>: <span>Мотив S2</span>
                                            <a class="help" href="#help-glazing" data-fancybox>?</a>
                                        </div>
                                        <? if ($glazingFlag): ?>
                                            <div class="card__glazing">
                                                <?
                                                $flag = true;
                                                foreach ($skuProperty['VALUES'] as $key => &$value) {
                                                    if ($value == end($skuProperty['VALUES'])) {
                                                        //                                                        unset($skuProperty['VALUES'][$key]);
                                                        continue;
                                                    }
                                                    $value['PICT'] = $arResult['GLAZING'][$value['XML_ID']]['PICTURE'];
                                                    $value['NAME'] = htmlspecialcharsbx($value['NAME']);
                                                    ?>
                                                    <? if (!$value['PICT']['SRC']): ?>
                                                        <label>
                                                            <input class="main-props props1" type="radio"
                                                                   name="<?= $skuProperty['CODE'] ?>"
                                                                   <?= $flag ? 'checked' : '' ?>
                                                                   title="<?= $value['NAME'] ?>"
                                                                   data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                                   data-onevalue="<?= $value['ID'] ?>">
                                                            <i></i>
                                                        </label>
                                                    <? elseif ($value['PICT']['WIDTH'] <= 44): ?>
                                                        <label>
                                                            <input class="main-props props1" type="radio"
                                                                   name="<?= $skuProperty['CODE'] ?>"
                                                                   <?= $flag ? 'checked' : '' ?>
                                                                   title="<?= $value['NAME'] ?>"
                                                                   data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                                   data-onevalue="<?= $value['ID'] ?>">
                                                            <img src="<?= $value['PICT']['SRC'] ?>" alt="">
                                                        </label>
                                                    <? else: ?>
                                                        <label class="width-88">
                                                            <input class="main-props props1" type="radio"
                                                                   name="<?= $skuProperty['CODE'] ?>"
                                                                   <?= $flag ? 'checked' : '' ?>
                                                                   title="<?= $value['NAME'] ?>"
                                                                   data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                                   data-onevalue="<?= $value['ID'] ?>">
                                                            <img src="<?= $value['PICT']['SRC'] ?>" alt="">
                                                        </label>
                                                    <? endif; ?>
                                                    <?
                                                }
                                                ?>
                                            </div>
                                        <? endif; ?>
                                    </div>
                                <? endif; ?>
                                <? if ($skuProperty['CODE'] == 'ISOLATION' || $skuProperty['CODE'] == 'ENERGY' || $skuProperty['CODE'] == 'SOUND'): ?>
                                    <div class="card__item" data-entity="sku-line-block" style="display: none">
                                        <div class="card__item__row">
                                            <?
                                            $flag = true;
                                            foreach ($skuProperty['VALUES'] as $key => &$value) {
                                                if ($value == end($skuProperty['VALUES'])) {
//                                                        unset($skuProperty['VALUES'][$key]);
                                                    continue;
                                                }
                                                $value['NAME'] = htmlspecialcharsbx($value['NAME']); ?>
                                                <div class="radio">
                                                    <label>
                                                        <input class="main-props props1" type="radio"
                                                               name="<?= $skuProperty['CODE'] ?>"
                                                               title="<?= $value['NAME'] ?>"
                                                               data-type="<?= $skuProperty['CODE'] ?>"
                                                               data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                               data-onevalue="<?= $value['ID'] ?>"
                                                               <?= $flag ? 'checked' : '' ?>>
                                                        <i></i>
                                                        <span><?= $value['NAME'] ?></span>
                                                    </label>
                                                </div>
                                                <?
                                                $flag = false;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <? endif; ?>
                                <?
                            }
                            ?>
                            <?
                        }
                        break;
                }
            }
            ?>
            <?
            foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName) {
                switch ($blockName) {

                    case 'price':
                        ?>
                        <div id="<?= $itemIds['PRICE_ID'] ?>" class="card__price">
                            <span>По запросу</span>
<!--                            <span>--><?php //= $price['PRINT_RATIO_PRICE'] ?><!--</span>-->
                        </div>
                        <?
                        break;
                    case 'buttons':
                        ?>
                        <div class="card__buy">
<!--                            <a id="--><?php //= $itemIds['BASKET_ACTIONS_ID'] ?><!--" class="btn" href="#order-gate"-->
<!--                               data-fancybox><span>Заказать</span></a>-->

                            <script data-b24-form="click/25/xkz4uv" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://hormann-crm.ru/upload/crm/form/loader_25_xkz4uv.js');</script>
                            <a class="btn" href="#"><span>Заказать</span></a>
                            <div class="card__link">
                                <a href="/contacts/">
                                    <svg>
                                        <use xlink:href="/static/build/images/sprites.svg#pin"></use>
                                    </svg>
                                    <span>Где купить</span>
                                </a>
                            </div>
                        </div>
                        <?
                        break;
                }
            }
            ?>
        </div>
    </div>
    <div class="feature wow" data-wow-offset="200">
        <div class="feature__content">
            <div class="title-text">Характеристики</div>
            <div class="feature__info">
                <ul>
                    <? if ($arResult['PROPERTIES']['MATERIAL']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Материал</div>
                            <span><?= $arResult['PROPERTIES']['MATERIAL']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['CONSTRUCTION']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Конструкция</div>
                            <span><?= $arResult['PROPERTIES']['CONSTRUCTION']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['CONTROL']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Управление</div>
                            <span><?= $arResult['PROPERTIES']['CONTROL']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['TIME']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Срок поставки</div>
                            <span><?= $arResult['PROPERTIES']['TIME']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['COUNTRY_OF_ORIGIN']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">
                                <nobr>Страна производства</nobr>
                            </div>
                            <span><?= $arResult['PROPERTIES']['COUNTRY_OF_ORIGIN']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['APPOINTMENT']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Назначение</div>
                            <span><?= $arResult['PROPERTIES']['APPOINTMENT']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['CANVAS_MATERIAL']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Материал полотна</div>
                            <span><?= $arResult['PROPERTIES']['CANVAS_MATERIAL']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['ISOLATION_V']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Теплоизоляция, Вт/м²∙К</div>
                            <span><?= $arResult['PROPERTIES']['ISOLATION_V']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['GUARANTEE']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Гарантия</div>
                            <span><?= $arResult['PROPERTIES']['GUARANTEE']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['PANEL']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Толщина панели</div>
                            <span><?= $arResult['PROPERTIES']['PANEL']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['SOUND']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Звукоизоляция</div>
                            <div class="feature__info__img sound"><?= $arResult['PROPERTIES']['SOUND']['VALUE'] ?>
                                <!--                                --><? // for ($i = 0; $i < $arResult['PROPERTIES']['SOUND']['VALUE']; $i++): ?>
                                <!--                                    <img src="/static/build/images/temp/25.jpg" alt="">-->
                                <!--                                --><? // endfor; ?>
                            </div>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['ISOLATION']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Теплоизоляция</div>
                            <div class="feature__info__img isolation"><?= $arResult['PROPERTIES']['ISOLATION']['VALUE'] ?>
                                <!--                                --><? // for ($i = 0; $i < $arResult['PROPERTIES']['ISOLATION']['VALUE']; $i++): ?>
                                <!--                                    <img src="/static/build/images/temp/26.jpg" alt="">-->
                                <!--                                --><? // endfor; ?>
                            </div>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['ENERGY']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Энергосбережение</div>
                            <div class="feature__info__img energy"><?= $arResult['PROPERTIES']['ENERGY']['VALUE'] ?>
                                <!--                                --><? // for ($i = 0; $i < $arResult['PROPERTIES']['ENERGY']['VALUE']; $i++): ?>
                                <!--                                    <img src="/static/build/images/temp/27.jpg" alt="">-->
                                <!--                                --><? // endfor; ?>
                            </div>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['PROPERTIES']['SIZE']['VALUE']): ?>
                        <li>
                            <div class="feature__info__label">Max размеры:</div>
                            <span><?= $arResult['PROPERTIES']['SIZE']['VALUE'] ?></span>
                        </li>
                    <? endif; ?>
                </ul>
            </div>
        </div>
        <div class="feature__image">
            <img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" alt="">
        </div>
    </div>
<? /*
    <div class="row">
        <div class="col-xs-12">
            <?
            if ($haveOffers) {
                if ($arResult['OFFER_GROUP']) {
                    foreach ($arResult['OFFER_GROUP_VALUES'] as $offerId) {
                        ?>
                        <span id="<?= $itemIds['OFFER_GROUP'] . $offerId ?>" style="display: none;">
								<?
                                $APPLICATION->IncludeComponent(
                                    'bitrix:catalog.set.constructor',
                                    '.default',
                                    array(
                                        'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                        'IBLOCK_ID' => $arResult['OFFERS_IBLOCK'],
                                        'ELEMENT_ID' => $offerId,
                                        'PRICE_CODE' => $arParams['PRICE_CODE'],
                                        'BASKET_URL' => $arParams['BASKET_URL'],
                                        'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
                                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                        'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
                                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                        'CURRENCY_ID' => $arParams['CURRENCY_ID']
                                    ),
                                    $component,
                                    array('HIDE_ICONS' => 'Y')
                                );
                                ?>
							</span>
                        <?
                    }
                }
            } else {
                if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP']) {
                    $APPLICATION->IncludeComponent(
                        'bitrix:catalog.set.constructor',
                        '.default',
                        array(
                            'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                            'ELEMENT_ID' => $arResult['ID'],
                            'PRICE_CODE' => $arParams['PRICE_CODE'],
                            'BASKET_URL' => $arParams['BASKET_URL'],
                            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                            'CACHE_TIME' => $arParams['CACHE_TIME'],
                            'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                            'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
                            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                            'CURRENCY_ID' => $arParams['CURRENCY_ID']
                        ),
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                }
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?
            if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')) {
                $APPLICATION->IncludeComponent(
                    'bitrix:sale.prediction.product.detail',
                    '.default',
                    array(
                        'BUTTON_ID' => $showBuyBtn ? $itemIds['BUY_LINK'] : $itemIds['ADD_BASKET_LINK'],
                        'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                        'POTENTIAL_PRODUCT_TO_BUY' => array(
                            'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
                            'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
                            'PRODUCT_PROVIDER_CLASS' => isset($arResult['~PRODUCT_PROVIDER_CLASS']) ? $arResult['~PRODUCT_PROVIDER_CLASS'] : '\Bitrix\Catalog\Product\CatalogProvider',
                            'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
                            'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

                            'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
                            'SECTION' => array(
                                'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
                                'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
                                'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
                                'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
                            ),
                        )
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
            }

            if ($arResult['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')) {
                ?>
                <div data-entity="parent-container">
                    <?
                    if (!isset($arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y') {
                        ?>
                        <div class="catalog-block-header" data-entity="header" data-showed="false"
                             style="display: none; opacity: 0;">
                            <?= ($arParams['GIFTS_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFT_BLOCK_TITLE_DEFAULT')) ?>
                        </div>
                        <?
                    }

                    CBitrixComponent::includeComponentClass('bitrix:sale.products.gift');
                    $APPLICATION->IncludeComponent(
                        'bitrix:sale.products.gift',
                        '.default',
                        array(
                            'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                            'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                            'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],

                            'PRODUCT_ROW_VARIANTS' => "",
                            'PAGE_ELEMENT_COUNT' => 0,
                            'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
                                SaleProductsGiftComponent::predictRowVariants(
                                    $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
                                    $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']
                                )
                            ),
                            'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],

                            'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
                            'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                            'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
                            'PRODUCT_DISPLAY_MODE' => 'Y',
                            'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],
                            'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
                            'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
                            'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

                            'TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],

                            'LABEL_PROP_' . $arParams['IBLOCK_ID'] => array(),
                            'LABEL_PROP_MOBILE_' . $arParams['IBLOCK_ID'] => array(),
                            'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

                            'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
                            'MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
                            'MESS_BTN_ADD_TO_BASKET' => $arParams['~GIFTS_MESS_BTN_BUY'],
                            'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
                            'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],

                            'SHOW_PRODUCTS_' . $arParams['IBLOCK_ID'] => 'Y',
                            'PROPERTY_CODE_' . $arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE'],
                            'PROPERTY_CODE_MOBILE' . $arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE_MOBILE'],
                            'PROPERTY_CODE_' . $arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
                            'OFFER_TREE_PROPS_' . $arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
                            'CART_PROPERTIES_' . $arResult['OFFERS_IBLOCK'] => $arParams['OFFERS_CART_PROPERTIES'],
                            'ADDITIONAL_PICT_PROP_' . $arParams['IBLOCK_ID'] => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
                            'ADDITIONAL_PICT_PROP_' . $arResult['OFFERS_IBLOCK'] => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),

                            'HIDE_NOT_AVAILABLE' => 'Y',
                            'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
                            'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
                            'PRICE_CODE' => $arParams['PRICE_CODE'],
                            'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
                            'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                            'BASKET_URL' => $arParams['BASKET_URL'],
                            'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
                            'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
                            'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
                            'USE_PRODUCT_QUANTITY' => 'N',
                            'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                            'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                            'POTENTIAL_PRODUCT_TO_BUY' => array(
                                'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
                                'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
                                'PRODUCT_PROVIDER_CLASS' => isset($arResult['~PRODUCT_PROVIDER_CLASS']) ? $arResult['~PRODUCT_PROVIDER_CLASS'] : '\Bitrix\Catalog\Product\CatalogProvider',
                                'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
                                'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

                                'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
                                    ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID']
                                    : null,
                                'SECTION' => array(
                                    'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
                                    'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
                                    'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
                                    'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
                                ),
                            ),

                            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                            'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
                        ),
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                    ?>
                </div>
                <?
            }

            if ($arResult['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')) {
                ?>
                <div data-entity="parent-container">
                    <?
                    if (!isset($arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y') {
                        ?>
                        <div class="catalog-block-header" data-entity="header" data-showed="false"
                             style="display: none; opacity: 0;">
                            <?= ($arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFTS_MAIN_BLOCK_TITLE_DEFAULT')) ?>
                        </div>
                        <?
                    }

                    $APPLICATION->IncludeComponent(
                        'bitrix:sale.gift.main.products',
                        '.default',
                        array(
                            'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                            'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
                            'LINE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
                            'HIDE_BLOCK_TITLE' => 'Y',
                            'BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

                            'OFFERS_FIELD_CODE' => $arParams['OFFERS_FIELD_CODE'],
                            'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],

                            'AJAX_MODE' => $arParams['AJAX_MODE'],
                            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],

                            'ELEMENT_SORT_FIELD' => 'ID',
                            'ELEMENT_SORT_ORDER' => 'DESC',
                            //'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
                            //'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
                            'FILTER_NAME' => 'searchFilter',
                            'SECTION_URL' => $arParams['SECTION_URL'],
                            'DETAIL_URL' => $arParams['DETAIL_URL'],
                            'BASKET_URL' => $arParams['BASKET_URL'],
                            'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
                            'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                            'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],

                            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                            'CACHE_TIME' => $arParams['CACHE_TIME'],

                            'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                            'SET_TITLE' => $arParams['SET_TITLE'],
                            'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
                            'PRICE_CODE' => $arParams['PRICE_CODE'],
                            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                            'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

                            'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                            'HIDE_NOT_AVAILABLE' => 'Y',
                            'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
                            'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                            'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],

                            'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
                            'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
                            'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

                            'ADD_PICT_PROP' => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
                            'LABEL_PROP' => (isset($arParams['LABEL_PROP']) ? $arParams['LABEL_PROP'] : ''),
                            'LABEL_PROP_MOBILE' => (isset($arParams['LABEL_PROP_MOBILE']) ? $arParams['LABEL_PROP_MOBILE'] : ''),
                            'LABEL_PROP_POSITION' => (isset($arParams['LABEL_PROP_POSITION']) ? $arParams['LABEL_PROP_POSITION'] : ''),
                            'OFFER_ADD_PICT_PROP' => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),
                            'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : ''),
                            'SHOW_DISCOUNT_PERCENT' => (isset($arParams['SHOW_DISCOUNT_PERCENT']) ? $arParams['SHOW_DISCOUNT_PERCENT'] : ''),
                            'DISCOUNT_PERCENT_POSITION' => (isset($arParams['DISCOUNT_PERCENT_POSITION']) ? $arParams['DISCOUNT_PERCENT_POSITION'] : ''),
                            'SHOW_OLD_PRICE' => (isset($arParams['SHOW_OLD_PRICE']) ? $arParams['SHOW_OLD_PRICE'] : ''),
                            'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                            'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                            'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                            'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                            'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
                            'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
                            'DISPLAY_COMPARE' => (isset($arParams['DISPLAY_COMPARE']) ? $arParams['DISPLAY_COMPARE'] : ''),
                            'COMPARE_PATH' => (isset($arParams['COMPARE_PATH']) ? $arParams['COMPARE_PATH'] : ''),
                        )
                        + array(
                            'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
                                ? $arResult['ID']
                                : $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
                            'SECTION_ID' => $arResult['SECTION']['ID'],
                            'ELEMENT_ID' => $arResult['ID'],

                            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                            'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
                        ),
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                    ?>
                </div>
                <?
            }
            ?>
        </div>
    </div>
    </div>

    <meta itemprop="name" content="<?= $name ?>"/>
    <meta itemprop="category" content="<?= $arResult['CATEGORY_PATH'] ?>"/>
*/ ?>
<?
if ($haveOffers) {
    foreach ($arResult['JS_OFFERS'] as $offer) {

        $currentOffersList = array();

        if (!empty($offer['TREE']) && is_array($offer['TREE'])) {
            foreach ($offer['TREE'] as $propName => $skuId) {
                $propId = (int)mb_substr($propName, 5);

                foreach ($skuProps as $key => $prop) {
                    if ($prop['ID'] == $propId) {
                        foreach ($prop['VALUES'] as $propId => $propValue) {
                            if ($propValue['XML_ID'] == $offerPictures[$offer['ID']]['XML_ID']){
                                $skuProps[$key]['VALUES'][$propId]['PREVIEW_PICTURE'] = $offerPictures[$offer['ID']]['PREVIEW_PICTURE'];
                            }
                            if ($propId == $skuId) {
                                $currentOffersList[] = $propValue['NAME'];
                                break;
                            }
                        }
                    }
                }
            }
        }

        $offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
        ?>
        <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="sku" content="<?= htmlspecialcharsbx(implode('/', $currentOffersList)) ?>"/>
<!--				<meta itemprop="price" content="--><?php //= $offerPrice['RATIO_PRICE'] ?><!--"/>-->
				<meta itemprop="priceCurrency" content="<?= $offerPrice['CURRENCY'] ?>"/>
				<link itemprop="availability"
                      href="http://schema.org/<?= ($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock') ?>"/>
			</span>
        <?
    }
    unset($offerPrice, $currentOffersList);
} else {
    ?>
    <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<!--			<meta itemprop="price" content="--><?php //= $price['RATIO_PRICE'] ?><!--"/>-->
			<meta itemprop="priceCurrency" content="<?= $price['CURRENCY'] ?>"/>
			<link itemprop="availability"
                  href="http://schema.org/<?= ($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock') ?>"/>
		</span>
    <?
}
?>

<?
if ($haveOffers) {
    $offerIds = array();
    $offerCodes = array();

    $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

    foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer) {
        $offerIds[] = (int)$jsOffer['ID'];
        $offerCodes[] = $jsOffer['CODE'];

        $fullOffer = $arResult['OFFERS'][$ind];
        $measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

        $strAllProps = '';
        $strMainProps = '';
        $strPriceRangesRatio = '';
        $strPriceRanges = '';

        if ($arResult['SHOW_OFFERS_PROPS']) {
            if (!empty($jsOffer['DISPLAY_PROPERTIES'])) {
                foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property) {
                    $current = '<dt>' . $property['NAME'] . '</dt><dd>' . (
                        is_array($property['VALUE'])
                            ? implode(' / ', $property['VALUE'])
                            : $property['VALUE']
                        ) . '</dd>';
                    $strAllProps .= $current;

                    if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']])) {
                        $strMainProps .= $current;
                    }
                }

                unset($current);
            }
        }

        if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1) {
            $strPriceRangesRatio = '(' . Loc::getMessage(
                    'CT_BCE_CATALOG_RATIO_PRICE',
                    array('#RATIO#' => ($useRatio
                            ? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
                            : '1'
                        ) . ' ' . $measureName)
                ) . ')';

            foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range) {
                if ($range['HASH'] !== 'ZERO-INF') {
                    $itemPrice = false;

                    foreach ($jsOffer['ITEM_PRICES'] as $itemPrice) {
                        if ($itemPrice['QUANTITY_HASH'] === $range['HASH']) {
                            break;
                        }
                    }

                    if ($itemPrice) {
                        $strPriceRanges .= '<dt>' . Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_FROM',
                                array('#FROM#' => $range['SORT_FROM'] . ' ' . $measureName)
                            ) . ' ';

                        if (is_infinite($range['SORT_TO'])) {
                            $strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                        } else {
                            $strPriceRanges .= Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_TO',
                                array('#TO#' => $range['SORT_TO'] . ' ' . $measureName)
                            );
                        }

                        $strPriceRanges .= '</dt><dd>' . ($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']) . '</dd>';
                    }
                }
            }

            unset($range, $itemPrice);
        }

        $jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
        $jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
        $jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
        $jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
    }

    $templateData['OFFER_IDS'] = $offerIds;
    $templateData['OFFER_CODES'] = $offerCodes;
    unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => true,
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
            'OFFER_GROUP' => $arResult['OFFER_GROUP'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
//            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
//            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null,
            'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
            'DISPLAY_PREVIEW_TEXT_MODE' => $arParams['DISPLAY_PREVIEW_TEXT_MODE']
        ),
        'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
        'VISUAL' => $itemIds,
        'DEFAULT_PICTURE' => array(
            'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
            'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
        ),
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'NAME' => $arResult['~NAME'],
            'CATEGORY' => $arResult['CATEGORY_PATH'],
            'DETAIL_TEXT' => $arResult['DETAIL_TEXT'],
            'DETAIL_TEXT_TYPE' => $arResult['DETAIL_TEXT_TYPE'],
            'PREVIEW_TEXT' => $arResult['PREVIEW_TEXT'],
            'PREVIEW_TEXT_TYPE' => $arResult['PREVIEW_TEXT_TYPE']
        ),
        'BASKET' => array(
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'BASKET_URL' => $arParams['BASKET_URL'],
            'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        ),
        'OFFERS' => $arResult['JS_OFFERS'],
        'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
        'TREE_PROPS' => $skuProps
    );
} else {
    $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
    if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties) {
        ?>
        <div id="<?= $itemIds['BASKET_PROP_DIV'] ?>" style="display: none;">
            <?
            if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {
                foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo) {
                    ?>
                    <input type="hidden" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]"
                           value="<?= htmlspecialcharsbx($propInfo['ID']) ?>">
                    <?
                    unset($arResult['PRODUCT_PROPERTIES'][$propId]);
                }
            }

            $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
            if (!$emptyProductProperties) {
                ?>
                <table>
                    <?
                    foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo) {
                        ?>
                        <tr>
                            <td><?= $arResult['PROPERTIES'][$propId]['NAME'] ?></td>
                            <td>
                                <?
                                if (
                                    $arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
                                    && $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
                                ) {
                                    foreach ($propInfo['VALUES'] as $valueId => $value) {
                                        ?>
                                        <label>
                                            <input type="radio"
                                                   name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]"
                                                   value="<?= $valueId ?>"
                                                   <?= ($valueId == $propInfo['SELECTED'] ? '"checked"' : '') ?>>
                                            <?= $value ?>
                                        </label>
                                        <br>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <select name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]">
                                        <?
                                        foreach ($propInfo['VALUES'] as $valueId => $value) {
                                            ?>
                                            <option value="<?= $valueId ?>"
                                                    <?= ($valueId == $propInfo['SELECTED'] ? '"selected"' : '') ?>>
                                                <?= $value ?>
                                            </option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                    <?
                                }
                                ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
                <?
            }
            ?>
        </div>
        <?
    }

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
//            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
//            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null
        ),
        'VISUAL' => $itemIds,
        'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'PICT' => reset($arResult['MORE_PHOTO']),
            'NAME' => $arResult['~NAME'],
            'SUBSCRIPTION' => true,
            'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
            'ITEM_PRICES' => $arResult['ITEM_PRICES'],
            'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
            'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
            'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
            'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
            'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
//            'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
//            'SLIDER' => $arResult['MORE_PHOTO'],
            'CAN_BUY' => $arResult['CAN_BUY'],
            'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
            'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
            'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
            'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
            'CATEGORY' => $arResult['CATEGORY_PATH']
        ),
        'BASKET' => array(
            'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'EMPTY_PROPS' => $emptyProductProperties,
            'BASKET_URL' => $arParams['BASKET_URL'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        )
    );
    unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE']) {
    $jsParams['COMPARE'] = array(
        'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
        'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH']
    );
}
?>
    <script>
        window.previewPictures = <?=json_encode($dividedOfferPictures)?>;
      BX.message({
        ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
        TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
        TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
        BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
        BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
        BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
        BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
        BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
        TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
        COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
        COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
        COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
        BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
        PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
        PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
        RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
        RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
        SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
      });

      var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    </script>
<?
unset($actualItem, $itemIds, $jsParams);