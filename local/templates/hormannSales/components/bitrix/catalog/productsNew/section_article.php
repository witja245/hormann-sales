<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arCurSection
 * @var CMain $APPLICATION
 */

use \Bitrix\IBlock;

$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(IBLOCK_ID_CATALOG, $arCurSection['ID']);
$sectionSeoValues = $ipropValues->getValues();
$APPLICATION->SetPageProperty('title', $sectionSeoValues['SECTION_META_TITLE']);
$APPLICATION->SetPageProperty('description', $sectionSeoValues['SECTION_META_DESCRIPTION']);
$APPLICATION->SetTitle($sectionSeoValues['SECTION_PAGE_TITLE'] ?: $arCurSection['NAME']);
$sectionNavChain = \CIBlockSection::GetNavChain(false, $arCurSection['ID'], array(), true);
if (count($sectionNavChain) >= 1) {
    foreach ($sectionNavChain as $key => $sectionChain) {
        if ($key != count($sectionNavChain) - 1) {
            $APPLICATION->AddChainItem($sectionChain['NAME'], \CIBlock::ReplaceDetailUrl($sectionChain['SECTION_PAGE_URL'], $sectionChain, true, 'S'));
        }
    }
}
// $APPLICATION->AddChainItem($arCurSection['NAME']);
//замена
$APPLICATION->AddChainItem($sectionSeoValues['SECTION_PAGE_TITLE'] ?: $arCurSection['NAME']);

if ($arCurSection['UF_ARTICLE_PICTURE']) {
    $articlePicture = \CFile::GetPath($arCurSection['UF_ARTICLE_PICTURE']);
}
if ($arCurSection['UF_BENEFITS']) {
    $req = \CIBlockElement::GetList(
        ['SORT' => 'ASC',],
        [
            'IBLOCK_SECTION_ID' => $arCurSection['UF_BENEFITS'],
            'IBLOCK_ID' => IBLOCK_ID_ARTICLES_CONTENT,
        ]
    );
    while ($res = $req->GetNextElement()) {
        $element = $res->GetFields();
        $ipropValues = new Iblock\InheritedProperty\ElementValues($element["IBLOCK_ID"], $element["ID"]);
        $element["IPROPERTY_VALUES"] = $ipropValues->getValues();
        Iblock\Component\Tools::getFieldImageData(
            $element,
            array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
            Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
            'IPROPERTY_VALUES'
        );
        $benefits[] = $element;
    }
}
if ($arCurSection['UF_LINES']) {
    $req = \CIBlockElement::GetList(
        ['SORT' => 'ASC',],
        [
            'IBLOCK_SECTION_ID' => $arCurSection['UF_LINES'],
            'IBLOCK_ID' => IBLOCK_ID_ARTICLES_CONTENT,
        ]
    );
    while ($res = $req->GetNextElement()) {
        $element = $res->GetFields();
        $element['PROPERTIES'] = [
            'LINES_LIST' => current($res->GetProperties(false, ['CODE' => 'LINES_LIST'])),
            'LINES_SUBTITLE' => current($res->GetProperties(false, ['CODE' => 'LINES_SUBTITLE'])),
            'LINES_TEXT' => current($res->GetProperties(false, ['CODE' => 'LINES_TEXT'])),
            'LINES_TEXT_TOP' => current($res->GetProperties(false, ['CODE' => 'LINES_TEXT_TOP'])),
            'LINES_LONGNAME' => current($res->GetProperties(false, ['CODE' => 'LINES_LONGNAME'])),
        ];
        $ipropValues = new Iblock\InheritedProperty\ElementValues($element["IBLOCK_ID"], $element["ID"]);
        $element["IPROPERTY_VALUES"] = $ipropValues->getValues();
        Iblock\Component\Tools::getFieldImageData(
            $element,
            array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
            Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
            'IPROPERTY_VALUES'
        );
        $lines[] = $element;
    }
}
if ($arCurSection['UF_DOCUMENTS_ELEMENT']) {
    $req = \CIBlockElement::GetList(
        ['SORT' => 'ASC',],
        [
            'IBLOCK_ID' => IBLOCK_ID_DOCUMENTS,
        ]
    );
    while ($res = $req->GetNextElement()) {
        $element = $res->GetFields();
        $element['PROPERTIES'] = [
            'DOCUMENTS_CODE' => current($res->GetProperties(false, ['CODE' => 'DOCUMENTS_CODE'])),
            'DOCUMENTS_DATE' => current($res->GetProperties(false, ['CODE' => 'DOCUMENTS_DATE'])),
            'DOCUMENTS_FILE' => current($res->GetProperties(false, ['CODE' => 'DOCUMENTS_FILE'])),
        ];
        foreach ($element['PROPERTIES'] as $pid => &$arProp) {
            if ((is_array($arProp["VALUE"]) && count($arProp["VALUE"]) > 0) ||
                (!is_array($arProp["VALUE"]) && strlen($arProp["VALUE"]) > 0)) {
                $element["DISPLAY_PROPERTIES"][$pid] = \CIBlockFormatProperties::GetDisplayValue($element, $arProp, '');
            }
        }
        $documents[] = $element;
    }
}
/*
if ($arCurSection['UF_DOCUMENTS']) {
    $req = \CIBlockElement::GetList(
        ['SORT' => 'ASC',],
        [
            'IBLOCK_SECTION_ID' => $arCurSection['UF_DOCUMENTS'],
            'IBLOCK_ID' => IBLOCK_ID_ARTICLES_CONTENT,
        ]
    );
    while ($res = $req->GetNextElement()) {
        $element = $res->GetFields();
        $element['PROPERTIES'] = [
            'DOCUMENTS_CODE' => current($res->GetProperties(false, ['CODE' => 'DOCUMENTS_CODE'])),
            'DOCUMENTS_DATE' => current($res->GetProperties(false, ['CODE' => 'DOCUMENTS_DATE'])),
            'DOCUMENTS_FILE' => current($res->GetProperties(false, ['CODE' => 'DOCUMENTS_FILE'])),
        ];
        foreach ($element['PROPERTIES'] as $pid => &$arProp) {
            if ((is_array($arProp["VALUE"]) && count($arProp["VALUE"]) > 0) ||
                (!is_array($arProp["VALUE"]) && strlen($arProp["VALUE"]) > 0)) {
                $element["DISPLAY_PROPERTIES"][$pid] = \CIBlockFormatProperties::GetDisplayValue($element, $arProp, '');
            }
        }
        $documents[] = $element;
    }
}
*/
?>
<div class="content">
    <div class="container">
        <div class="breadcrumbs">
            <?php $APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "main",
                array(
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => "s1"
                )
            ); ?>
        </div>
        <?/*?>
        <h1 class="h2 wow" data-wow-offset="200"><?= $arCurSection['NAME'] ?></h1>
        <?*/?>
        <?/*//замена*/?>
        <h1 class="h2 wow" data-wow-offset="200"><?=$sectionSeoValues['SECTION_PAGE_TITLE'];?></h1>
        <?php if ($arCurSection['UF_ARTICLE_PICTURE']): ?>
            <div class="topic">
                <div class="topic__item wow" data-wow-offset="200"
                     style="background-image:url(<?= $articlePicture ?>)">
                    <?php if ($arCurSection['UF_UPPER_TITLE']): ?>
                        <div class="subtext">
                            <?= $arCurSection['UF_UPPER_TITLE'] ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        <?php endif ?>
        <?php if ($arCurSection['UF_BENEFITS']): ?>
            <h2 class="wow" data-wow-offset="200">Преимущества</h2>
            <div class="slider slider_width-488 wow" data-wow-offset="200" data-app="slider-item">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($benefits as $benefit): ?>
                            <div class="swiper-slide">
                                <div class="slider__item">
                                    <div class="slider__item__image">
                                        <img src="<?= $benefit['PREVIEW_PICTURE']['SRC'] ?>"
                                             alt="<?= $benefit['NAME'] ?>">
                                    </div>
                                    <div class="title-text"><?= $benefit['NAME'] ?></div>
                                    <div class="slider__item__text">
                                        <?= $benefit['~PREVIEW_TEXT'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="slider__pager"></div>
            </div>
        <?php endif ?>
        <?php if ($arCurSection['UF_LINES']): ?>
            <h2 class="wow" data-wow-offset="200">Линейка</h2>
            <div class="ruler">
                <?php foreach ($lines as $key => $line): ?>
                    <div class="ruler__item wow" data-wow-offset="200">
                        <?php if ($key % 2 != 0): ?>
                            <?php if ($line['PREVIEW_PICTURE']): ?>
                                <div class="ruler__item__image ruler__item__image--left">
                                    <img src="<?= $line['PREVIEW_PICTURE']['SRC'] ?>"
                                         alt="<?= $line['PROPERTIES']['LINES_LONGNAME']['~VALUE'] ?: $line['NAME'] ?>">
                                </div>
                            <?php endif ?>
                        <?php endif ?>
                        <div class="ruler__item__content">
                            <div class="ruler__item__title">
                                <?= $line['PROPERTIES']['LINES_LONGNAME']['~VALUE'] ?: $line['NAME'] ?>
                            </div>
                            <?php if ($line['PROPERTIES']['LINES_TEXT_TOP']['VALUE']): ?>
                                <div class="ruler__item__text">
                                    <?= $line['PROPERTIES']['LINES_TEXT_TOP']['~VALUE'] ?>
                                </div>
                            <?php endif ?>
                            <?php if ($line['PROPERTIES']['LINES_LIST']['VALUE']): ?>
                                <div class="ruler__item__list">
                                    <ol>
                                        <?php foreach ($line['PROPERTIES']['LINES_LIST']['VALUE'] as $lineItem): ?>
                                            <li><?= $lineItem ?></li>
                                        <?php endforeach ?>
                                    </ol>
                                </div>
                            <?php endif ?>
                            <?php if ($line['PROPERTIES']['LINES_SUBTITLE']['VALUE']): ?>
                                <div class="ruler__item__subtitle"><?= $line['PROPERTIES']['LINES_SUBTITLE']['~VALUE'] ?></div>
                            <?php endif ?>
                            <?php if ($line['PROPERTIES']['LINES_TEXT']['VALUE']): ?>
                                <div class="ruler__item__text">
                                    <?= $line['PROPERTIES']['LINES_TEXT']['~VALUE'] ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php if ($key % 2 == 0): ?>
                            <?php if ($line['PREVIEW_PICTURE']): ?>
                                <div class="ruler__item__image">
                                    <img src="<?= $line['PREVIEW_PICTURE']['SRC'] ?>"
                                         alt="<?= $line['PROPERTIES']['LINES_LONGNAME']['~VALUE'] ?: $line['NAME'] ?>">
                                </div>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
        <?php if ($arCurSection['UF_DOCUMENTS_ELEMENT']): ?>
            <div class="booklet wow" data-wow-offset="200" style="margin-bottom: 80px">
                <div class="booklet__row" style="margin: 120px">
                    <?php foreach ($documents as $document): ?>
                        <div class="booklet__col">
                            <div class="booklet__item">
                                <div class="booklet__item__head">
                                    <div class="booklet__item__icon">
                                        <svg>
                                            <use xlink:href="/static/build/images/sprites.svg#pdf-2"></use>
                                        </svg>
                                    </div>
                                    <div class="booklet__item__content">
                                        <div class="booklet__item__title"><?= $document['NAME'] ?></div>
                                        <?php if ($document['PREVIEW_TEXT']): ?>
                                            <div class="booklet__item__text"><?= $document['~PREVIEW_TEXT'] ?></div>
                                        <?php endif ?>
                                        <?php if ($document['PROPERTIES']['DOCUMENTS_CODE']['VALUE'] || $document['PROPERTIES']['DOCUMENTS_DATE']['VALUE']): ?>
                                            <div class="booklet__item__desc">
                                                <?php if ($document['PROPERTIES']['DOCUMENTS_CODE']['VALUE']): ?>
                                                    <div class="booklet__item__art"><?= 'Арт. ' . $document['PROPERTIES']['DOCUMENTS_CODE']['~VALUE'] ?></div>
                                                <?php endif ?>
                                                <?php if ($document['PROPERTIES']['DOCUMENTS_DATE']['VALUE']): ?>
                                                    <div class="booklet__item__date"><?= $document['PROPERTIES']['DOCUMENTS_DATE']['~VALUE'] ?></div>
                                                <?php endif ?>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <?php
                                $file_info = pathinfo($document['DISPLAY_PROPERTIES']['DOCUMENTS_FILE']['FILE_VALUE']['SRC']);
                                ?>
                                <div class="booklet__item__bottom">
                                    <a class="btn"
                                       href="<?= $document['DISPLAY_PROPERTIES']['DOCUMENTS_FILE']['FILE_VALUE']['SRC'] ?>"
                                       download>
                                        <span>Скачать</span>
                                    </a>
                                    <div class="booklet__item__size"><?= \CFile::FormatSize(filesize($_SERVER['DOCUMENT_ROOT'] . $document['DISPLAY_PROPERTIES']['DOCUMENTS_FILE']['FILE_VALUE']['SRC']), 0) ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endif ?>
        <?/*
        <?php if ($arCurSection['UF_DOCUMENTS']): ?>
            <div class="booklet wow" data-wow-offset="200" style="margin-bottom: 80px">
                <div class="booklet__row" style="margin: 120px">
                    <?php foreach ($documents as $document): ?>
                        <div class="booklet__col">
                            <div class="booklet__item">
                                <div class="booklet__item__head">
                                    <div class="booklet__item__icon">
                                        <svg>
                                            <use xlink:href="/static/build/images/sprites.svg#pdf-2"></use>
                                        </svg>
                                    </div>
                                    <div class="booklet__item__content">
                                        <div class="booklet__item__title"><?= $document['NAME'] ?></div>
                                        <?php if ($document['PREVIEW_TEXT']): ?>
                                            <div class="booklet__item__text"><?= $document['~PREVIEW_TEXT'] ?></div>
                                        <?php endif ?>
                                        <?php if ($document['PROPERTIES']['DOCUMENTS_CODE']['VALUE'] || $document['PROPERTIES']['DOCUMENTS_DATE']['VALUE']): ?>
                                            <div class="booklet__item__desc">
                                                <?php if ($document['PROPERTIES']['DOCUMENTS_CODE']['VALUE']): ?>
                                                    <div class="booklet__item__art"><?= 'Арт. ' . $document['PROPERTIES']['DOCUMENTS_CODE']['~VALUE'] ?></div>
                                                <?php endif ?>
                                                <?php if ($document['PROPERTIES']['DOCUMENTS_DATE']['VALUE']): ?>
                                                    <div class="booklet__item__date"><?= $document['PROPERTIES']['DOCUMENTS_DATE']['~VALUE'] ?></div>
                                                <?php endif ?>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <?php
                                $file_info = pathinfo($document['DISPLAY_PROPERTIES']['DOCUMENTS_FILE']['FILE_VALUE']['SRC']);
                                ?>
                                <div class="booklet__item__bottom">
                                    <a class="btn"
                                       href="<?= $document['DISPLAY_PROPERTIES']['DOCUMENTS_FILE']['FILE_VALUE']['SRC'] ?>"
                                       download>
                                        <span>Скачать</span>
                                    </a>
                                    <div class="booklet__item__size"><?= \CFile::FormatSize(filesize($_SERVER['DOCUMENT_ROOT'] . $document['DISPLAY_PROPERTIES']['DOCUMENTS_FILE']['FILE_VALUE']['SRC']), 0) ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endif ?>
*/?>
        <?php $APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"order.product", 
	array(
		"PRODUCT" => $arCurSection["NAME"],
		"SEF_MODE" => "N",
		"WEB_FORM_ID" => FORM_ID_ORDER_PRODUCT,
		"LIST_URL" => "",
		"EDIT_URL" => "",
		"SUCCESS_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "Y",
		"USE_EXTENDED_ERRORS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SEF_FOLDER" => "/",
		"COMPONENT_TEMPLATE" => "order.product",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
); ?>
    </div>
</div>

