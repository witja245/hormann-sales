<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Результаты поиска по запросу на сайте | Hormann в Москве");
$APPLICATION->SetTitle("Результаты поиска | Hormann"); ?>
<?php
$page = \Itech\PageService::getInstance()->get();
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
            <? $arFilter = [
                0 => "iblock_content",
                1 => "iblock_Catalog",
            ];
            $arFilterIblock = [5, 13, 33];
            if ($_REQUEST['PRODUCT']) {
                $arFilterIblock = [33];
                $arFilter = [
                    0 => "iblock_Catalog",
                ];
            }
            elseif ($_REQUEST['NEWS']){
                $arFilterIblock = [5, 13];
                $arFilter = [
                    0 => "iblock_content",
                ];
            }
            $APPLICATION->IncludeComponent(
                "bitrix:search.page",
                "main",
                array(
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_SHADOW" => "Y",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "NO_WORD_LOGIC" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "",
                    "PAGER_TITLE" => "Результаты поиска",
                    "PAGE_RESULT_COUNT" => "5",
                    "PATH_TO_USER_PROFILE" => "",
                    "RATING_TYPE" => "",
                    "RESTART" => "N",
                    "SHOW_ITEM_TAGS" => "Y",
                    "SHOW_RATING" => "",
                    "SHOW_WHEN" => "N",
                    "SHOW_WHERE" => "N",
                    "TAGS_INHERIT" => "Y",
                    "TAGS_PAGE_ELEMENTS" => "150",
                    "TAGS_SORT" => "NAME",
                    "USE_LANGUAGE_GUESS" => "Y",
                    "USE_SUGGEST" => "N",
                    "USE_TITLE_RANK" => "N",
                    "COMPONENT_TEMPLATE" => "main",
                    "DEFAULT_SORT" => "rank",
                    "FILTER_NAME" => "",
                    "arrFILTER" => $arFilter,
                    "arrFILTER_iblock_content" => $arFilterIblock
                ),
                false
            ); ?>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>