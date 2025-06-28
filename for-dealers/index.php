<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Информация для дилеров от немецкой компании Hormann");
$APPLICATION->SetPageProperty("description", "Информация для дилеров компании Hormann. Вся необходимая информация для дилеров Hormann.");
$APPLICATION->SetTitle("Дилерам");
?>

<?php
$page = \Itech\PageService::getInstance()->get();
?>

<div class="content">
    <div class="container">

        <div class="breadcrumbs">
            <?$APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "main",
                Array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0"
                )
            );?>
        </div>


        <div class="edge wow" data-app="edge" data-wow-offset="200">
            <div class="edge__box">
                <div class="edge__content">
                    <h1 class="h2"><?=$page->UF_TITLE1?></h1>
                    <div class="text"><?=$page->UF_TEXT1?></div>
                </div>


                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "slider.dealers",
                    Array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "Y",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "IBLOCK_ID" => IBLOCK_ID_SLIDER_DEALERS,
                        "IBLOCK_TYPE" => "content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "20",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("",""),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "Y",
                        "SET_META_KEYWORDS" => "Y",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "SORT",
                        "SORT_BY2" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "ASC",
                        "SORT_ORDER2" => "DESC",
                        "STRICT_SECTION_CHECK" => "N"
                    )
                );?>


            </div>
        </div>


        <h2 class="wow" data-wow-offset="200"><?=$page->UF_TITLE2?></h2>
        <div class="text width-605 margin-72 wow" data-wow-offset="200"><?=$page->UF_TEXT2?></div>


        <?$APPLICATION->IncludeComponent(
            "bitrix:form.result.new",
            "contact-us",
            Array(
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "N",
                "CHAIN_ITEM_LINK" => "",
                "CHAIN_ITEM_TEXT" => "",
                "EDIT_URL" => "",
                "IGNORE_CUSTOM_TEMPLATE" => "Y",
                "LIST_URL" => "",
                "SEF_FOLDER" => "/",
                "SEF_MODE" => "N",
                "SUCCESS_URL" => "",
                "USE_EXTENDED_ERRORS" => "Y",
                "VARIABLE_ALIASES" => Array('WEB_FORM_ID','RESULT_ID'),
                "WEB_FORM_ID" => FORM_ID_CONTACT_US
            )
        );?>


    </div>
</div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
