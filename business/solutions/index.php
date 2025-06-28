<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "➤ Специальные решения для перегрузочной техники ✔️ Выгодные цены от производителя ✔️ высокое качество ✔️ большой ассортимент на официальном сайте Hormann в Москве");
$APPLICATION->SetTitle("Специальные решения для перегрузочной техники от производителя в Москве | Hormann ");
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

        <? $APPLICATION->IncludeComponent("bitrix:news", "solutions", Array(
            "COMPONENT_TEMPLATE" => ".default",
            "IBLOCK_TYPE" => "content",
            "IBLOCK_ID" => IBLOCK_ID_SOLUTIONS,
            "NEWS_COUNT" => "20",
            "SORT_BY1" => "SORT",
            "SORT_ORDER1" => "ASC",
            "SORT_BY2" => "ACTIVE_FROM",
            "SORT_ORDER2" => "ASC",
            "CHECK_DATES" => "Y",
            "SEF_MODE" => "Y",
            "SEF_FOLDER" => "/business/solutions/",
            "SEF_URL_TEMPLATES" => Array(
                "detail" => "#SECTION_CODE#/",
                "news" => "",
            ),
            "AJAX_MODE" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "SET_LAST_MODIFIED" => "N",
            "SET_TITLE" => "Y",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "Y",
            "ADD_ELEMENT_CHAIN" => "Y",
            "USE_PERMISSIONS" => "N",
            "STRICT_SECTION_CHECK" => "N",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "DISPLAY_NAME" => "Y",
            "META_KEYWORDS" => "-",
            "META_DESCRIPTION" => "-",
            "BROWSER_TITLE" => "-",
            "DETAIL_SET_CANONICAL_URL" => "N",
            "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "PAGER_SHOW_ALL" => "N",
            "SET_STATUS_404" => "N",
            "SHOW_404" => "N",
            "MESSAGE_404" => "",
        ),
            false
        ); ?>


        <? $APPLICATION->IncludeComponent("bitrix:form.result.new",
            "contact-us",
            Array(
                "SEF_MODE" => "N",
                "WEB_FORM_ID" => FORM_ID_CONTACT_US,
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
                "VARIABLE_ALIASES" => Array('WEB_FORM_ID', 'RESULT_ID')
            )
        ); ?>


    </div>
</div>


<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
