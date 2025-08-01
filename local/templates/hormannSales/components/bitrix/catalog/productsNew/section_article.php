<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arCurSection
 */
?>
<?php
$page = \Itech\PageService::getInstance()->get('/products/');
$section = CIBlockSection::GetByID($arResult['VARIABLES']['SECTION_ID'])->Fetch();

if ($section && !empty($section['PICTURE'])) {
    $imagePath = CFile::GetPath($section['PICTURE']);
}
$mas = explode('/', $arParams['URL']);
$code = $mas[2];
if (count($mas) == 5) {
    $code = $mas[3];
}

$arFilter = array('IBLOCK_ID' => 33, 'ID' => $arResult['VARIABLES']['SECTION_ID']);
$rsSections = CIBlockSection::GetList([], $arFilter, false, ['*', 'UF_*']);

$section = $rsSections->Fetch();

$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(33, $section['ID']);

$IPROPERTY = $ipropValues->getValues();

?>

<section class="main main_index">
    <div class="container">
        <div class="main_wrapper">
            <div class="main_info">
                <div class="main_img">
                    <picture>
                        <source srcset="<?= $imagePath ?>" media="(max-width: 676px)">
                        <img src="<?= $imagePath ?>" alt="">
                    </picture>
                </div>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "mainNew",
                    array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1"
                    )
                ); ?>
                <h1 class="main_title"><?= $IPROPERTY['SECTION_PAGE_TITLE'] ?></h1>
                <?php if ($section['UF_TOP_BLOCK']):
                    echo htmlspecialcharsBack($section['UF_TOP_BLOCK']);
                endif;?>

            </div>
        </div>
    </div>
</section>
<?

global $subSections;
$subSections = [
    "DEPTH_LEVEL" => 2
];
$APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "products.subSectionNew",
    array(
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "SECTION_ID" => '',
        "SECTION_CODE" => $arResult['VARIABLES']['SECTION_CODE'],
        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
        'ADD_SECTIONS_CHAIN' => 'N',
        'FILTER_NAME' => 'subSections',
        "SECTION_USER_FIELDS" => []
    ),
    $component
);
?>
<?php

?>

<div class="content">
    <div class="container">

        <?

        foreach ($section as $sectionKey => $sectionValue) {

            if ($sectionKey == 'UF_TEXT'
                || $sectionKey == 'UF_1BLOCK'
                || $sectionKey == 'UF_2BLOCK'
                || $sectionKey == 'UF_3BLOCK'
                || $sectionKey == 'UF_SHORT_TEXT'
                || $sectionKey == 'UF_LOGO_TITLE'
                || $sectionKey == 'UF_UNDER_LOGO_BLOCK'
                || $sectionKey == 'UF_BOTTOM_SECTION_TEXT'
                || $sectionKey == 'UF_UPPER_TITLE'
                || $sectionKey == 'UF_TITLE_UNDER_BANNER'
            ){

                echo htmlspecialcharsBack($sectionValue);

            }

        }
        ?>
    </div>


</div>
