<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Информация для архитекторов от немецкой компании Hormann");
$APPLICATION->SetPageProperty("description", "Вся информация необходимая архитекторам. Документация, продукция, особенности от немецкой компании Hormann.");
$APPLICATION->SetTitle("Архитекторам");
$APPLICATION->SetPageProperty("HEADER_CLASS", 'header-homepage');
?>

<?php
$page = \Itech\PageService::getInstance()->get("magazine");
$pageMain = \Itech\PageService::getInstance()->get('/architect/');
?>


<div class="content content_homepage">
    <div class="upper wow" data-wow-offset="200" style="background-image:url(<?=CFile::GetPath($pageMain->PREVIEW_PICTURE)?>)">
        <div class="container">


            <div class="upper__content" style="color: #fff;">
                <h1><?$APPLICATION->ShowTitle(false) ?></h1>
                <div class="upper__text"><?= $pageMain->UF_DESC ?></div>
            </div>

        </div>
    </div>


    <div class="container container_width-1038">
        <div class="breadcrumbs" style="margin-bottom: 29px">
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
                    <div class="h2"><?= $pageMain->UF_TITLE_ARCH ?></div>
                    <div class="text"><?= $pageMain->UF_DESC_ARCH ?></div>
                    <div class="link-icon">
                        <a href="<?= $pageMain->UF_CONTACT_LINK ?>">
                            <svg class="link-icon_width-24">
                                <use xlink:href="/static/build/images/sprites.svg#book"></use>
                            </svg><span><?= $pageMain->UF_CONTACT_LINK_T ?></span>
                        </a>
                    </div>
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
                        "IBLOCK_ID" => IBLOCK_ID_SLIDER_ARCHITECT,
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
    </div>


    <div class="container">

        <div class="doc wow" data-wow-offset="200">
            <div class="doc__item">
                <div class="title-text"><?= $pageMain->UF_T_BLOCK1 ?></div>
                <div class="text"><?= $pageMain->UF_D_BLOCK1 ?></div>
                <a class="btn" href="<?= $pageMain->UF_L_BLOCK1 ?>"><span><?= $pageMain->UF_LT_BLOCK1 ?></span></a>
            </div>
            <div class="doc__item">
                <div class="title-text"><?= $pageMain->UF_T_BLOCK2 ?></div>
                <div class="text"><?= $pageMain->UF_D_BLOCK2 ?></div>
                <a class="btn" href="<?= $pageMain->UF_L_BLOCK2 ?>"><span><?= $pageMain->UF_LT_BLOCK2 ?></span></a>
            </div>
        </div>
        <div class="bitmap bitmap_program wow" data-wow-offset="200">
            <div class="bitmap__image"><img src="/static/build/images/temp/76.jpg" alt=""></div>
            <div class="bitmap__content">
                <div class="title-text"><?= $pageMain->UF_T_BLOCK3 ?></div>
                <div class="text"><?= $pageMain->UF_D_BLOCK3 ?></div>
                <div class="link-arrow"><a href="<?= $pageMain->UF_L_BLOCK3 ?>"><?= $pageMain->UF_LT_BLOCK3 ?></a></div>
            </div>
        </div>


        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => "/local/php_interface/include/pages/magazine.php",
                "EDIT_TEMPLATE" => "standard.php",
                "PAGE" => $page,
            )
        );?>


        <? $APPLICATION->IncludeComponent("bitrix:form.result.new",
            "become.partner",
            Array(
                "SEF_MODE" => "N",
                "WEB_FORM_ID" => FORM_ID_BECOME_PARTNER,
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
