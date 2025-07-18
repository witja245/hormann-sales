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
$this->setFrameMode(true);?>


<form action="<?=$arResult["FORM_ACTION"]?>" class="header_search-form">
    <?if($arParams["USE_SUGGEST"] === "Y"):?><?$APPLICATION->IncludeComponent(
        "bitrix:search.suggest.input",
        "",
        array(
            "NAME" => "q",
            "VALUE" => "",
            "INPUT_SIZE" => 15,
            "DROPDOWN_SIZE" => 10,
        ),
        $component, array("HIDE_ICONS" => "Y")
    );?><?else:?>
        <input type="text" name="q" value="" class="header_search-inp" placeholder="Поиск по сайту"/><?endif;?>

    <button class="header_search-btn"><img src="<?= DEFAULT_TEMPLATE_MAIN_PATH ?>/img/search.svg"
                                           alt=""></button>
</form>


