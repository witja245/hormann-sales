<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Все новости от компании Hormann");
$APPLICATION->SetTitle("Новости немецкого концерна в Москве | Hormann");
?>

<?php
$page = \Itech\PageService::getInstance()->get();
?>


<div class="content content_homepage">
    <div class="upper" style="background-image:url(<?=CFile::GetPath($page->PREVIEW_PICTURE)?>)">
        <div class="container">
        </div>
    </div>
    <div class="container">
        <div class="breadcrumbs" style="margin-bottom: 29px; margin-top: -40px">
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
        <h1 class="h2 wow" data-wow-offset="200"><?=$page->PREVIEW_TEXT?></h1>
        <div class="text width-605 margin-16 wow" data-wow-offset="200"><?=$page->UF_SUBTITLE?></div>
        <div class="text margin-120 wow" data-wow-offset="200">
            <?if($page->UF_ADDR):?>
                <?=$page->UF_ADDR?><br>
            <?endif;?>
            <?if($page->UF_PHONE1):?>
                <br>Teл.: <a href="tel:<?=$page->UF_PHONE1?>]"><?=$page->UF_PHONE1?></a>
            <?endif;?>
            <?if($page->UF_PHONE2):?>
                <br>факс: <a href="tel:<?=$page->UF_PHONE2?>]"><?=$page->UF_PHONE2?></a>
            <?endif;?>
            <?if($page->UF_EMAIL):?>
                <br>E-mail: <a href="mailto:<?=$page->UF_EMAIL?>"><?=$page->UF_EMAIL?></a>
            <?endif;?>
        </div>
        <div class="press wow" data-wow-offset="200">
            <!--<div class="press__item">
                <div class="title-text">Скачайте пресс-кит о компании</div>-->

                <?/*$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "docs.press",
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
                        "IBLOCK_ID" => IBLOCK_ID_DOCS_PRESS,
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
                        "PROPERTY_CODE" => array("*"),
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
                );*/?>

            <!--</div>-->
			<a class="press__item" href="<?=$page->UF_LINK?>">
                <div class="title-text"><?=$page->UF_LINK_TEXT?></div>
			</a>
        </div>
    </div>
</div>


<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>