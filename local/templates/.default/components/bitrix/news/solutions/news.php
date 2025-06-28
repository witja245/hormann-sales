<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

    <h1 class="h2 wow" data-wow-offset="200">Решения</h1>

        <?
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "solutions",
            Array(
                "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                "SECTION_ID" => '',
                "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                'ADD_SECTIONS_CHAIN' => 'N',
                'FILTER_NAME' => '',
                "SECTION_USER_FIELDS" => []
            ),
            $component
        );
        ?>

