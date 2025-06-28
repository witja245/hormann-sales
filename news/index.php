<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Новости немецкого концерна Hormann");
$APPLICATION->SetPageProperty("description", "Все новости от компании Hormann.");
$APPLICATION->SetTitle("Новости");
?>
<? $APPLICATION->IncludeComponent("bitrix:news", "news", Array(
    "COMPONENT_TEMPLATE" => ".default",
    "IBLOCK_TYPE" => "content",
    "IBLOCK_ID" => IBLOCK_ID_NEWS,
    "NEWS_COUNT" => "10",
    "SORT_BY1" => "ACTIVE_FROM",
    "SORT_ORDER1" => "DESC",
    "SORT_BY2" => "SORT",
    "SORT_ORDER2" => "ASC",
    "CHECK_DATES" => "Y",
    "SEF_MODE" => "Y",
    "SEF_FOLDER" => "/news/",
    "SEF_URL_TEMPLATES" => Array(
        "detail" => "#ELEMENT_CODE#/",
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
    "META_KEYWORDS" => "Y",
    "META_DESCRIPTION" => "Y",
    "BROWSER_TITLE" => "Y",
    "DETAIL_SET_CANONICAL_URL" => "N",
    "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_TEMPLATE" => ".default",
    "SET_STATUS_404" => "N",
    "SHOW_404" => "N",
    "MESSAGE_404" => "",
    "PROPERTY_CODE" => Array("*"),
    "DETAIL_FIELD_CODE" => Array("PREVIEW_PICTURE", "PREVIEW_TEXT"),
    "ACTIVE_DATE_FORMAT" => "j F Y",
),
    false
); ?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
