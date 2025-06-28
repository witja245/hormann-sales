<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Вся актуальная информация о немецком концерне Hormann");
$APPLICATION->SetPageProperty("description", "Бизнес-презентация концерна Hormann: когда сегодня на рынке строительных элементов идёт речь о воротах, дверях, коробках и приводах, то сразу подразумевается имя Hormann");
$APPLICATION->SetTitle("О нас");
$APPLICATION->SetPageProperty("HEADER_CLASS", 'header-homepage');
?><?php
    $page = \Itech\PageService::getInstance()->get();
?>
    <div class="content content_homepage">
        <div class="upper upper_color-white" style="background-image:url(<?=CFile::GetPath($page->PREVIEW_PICTURE)?>);margin-bottom: 80px">
            <a class="upper__play" href="<?=$page->UF_VIDEO_LINK?>" data-fancybox>
                <div class="upper__play__icon">
                    <svg>
                        <use xlink:href="/static/build/images/sprites.svg#play-circle"></use>
                    </svg>
                </div>
                <div class="h1">Смотреть</div>
            </a>
        </div>
        <div class="edge edge_border wow" data-app="edge" data-wow-offset="200">
            <div class="container container_width-1038">
                <div class="breadcrumbs" style="margin-bottom: 29px">
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
                <div class="edge__box">
                    <div class="edge__content">
                        <h1 class="h2"><?=$page->PREVIEW_TEXT?></h1>
                        <div class="text"><?=$page->DETAIL_TEXT?></div>
                        <div class="link-icon">
                            <a href="/contacts/">
                                <svg class="link-icon_width-24">
                                    <use xlink:href="/static/build/images/sprites.svg#book"></use>
                                </svg>
                                <span>Контакты компании</span>
                            </a>
                        </div>
                    </div>
                    <div class="edge__slider">
                        <div class="edge__number">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="subtext">01</div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="subtext">02</div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="subtext">03</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="edge__inner">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="edge__inner__row">
                                            <div class="edge__inner__img">
                                                <img src="<?=CFile::GetPath($page->UF_PICTURE1)?>" alt="">
                                            </div>
                                            <div class="edge__inner__content">
                                                <div class="subtext"><?=$page->UF_TITLE1?></div>
                                                <div class="text"><?=$page->UF_TEXT1?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="edge__inner__row">
                                            <div class="edge__inner__img">
                                                <img src="<?=CFile::GetPath($page->UF_PICTURE2)?>" alt="">
                                            </div>
                                            <div class="edge__inner__content">
                                                <div class="subtext"><?=$page->UF_TITLE2?></div>
                                                <div class="text"><?=$page->UF_TEXT2?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="edge__inner__row">
                                            <div class="edge__inner__img">
                                                <img src="<?=CFile::GetPath($page->UF_PICTURE3)?>" alt="">
                                            </div>
                                            <div class="edge__inner__content">
                                                <div class="subtext"><?=$page->UF_TITLE3?></div>
                                                <div class="text"><?=$page->UF_TEXT3?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "about.list",
            Array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("", ""),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => IBLOCK_ID_ABOUT_LIST,
                "IBLOCK_TYPE" => "content",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "N",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "999",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array(""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "NAME",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N",
            )
        ); ?>

        <div class="story" data-app="story">
            <div class="container">
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "about.history",
                    Array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "N",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => IBLOCK_ID_ABOUT_HISTORY,
                        "IBLOCK_TYPE" => "content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "N",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "999",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array(""),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "SORT",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N",
                    )
                ); ?>
                <div class="story__tabs">
                    <div class="story__tabs__content">
                        <div class="story__tabs__list">
                            <ul>
                                <li><a class="is-active" href="#" data-target="1">В мире</a></li>
                                <li><a href="#" data-target="2">В России</a></li>
                            </ul>
                        </div>
                        <div class="story__tabs__item is-active" data-item="1">
                            <div class="title-text"><?=$page->UF_TITLE_INTL?></div>
                            <div class="text"><?=$page->UF_TEXT_INTL?></div>
                        </div>
                        <div class="story__tabs__item" data-item="2">
                            <div class="title-text"><?=$page->UF_TITLE_RUSSIA?></div>
                            <div class="text"><?=$page->UF_TEXT_RUSSIA?></div>
                        </div>
                    </div>
                    <div class="story__tabs__image"><img src="<?=CFile::GetPath($page->DETAIL_PICTURE)?>" alt=""></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="bitmap bitmap_sire">
                <div class="bitmap__content">
                    <div class="title-text">Все от одного производителя</div>
                    <div class="text"><?=$page->UF_TEXT_SAME_PROD?></div>
                </div>
                <div class="bitmap__image"><img src="/static/build/images/temp/84.jpg" alt=""></div>
            </div>
        </div>
        <?php $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "about.slider",
            Array(
                "TEXT" => $page->UF_TEXT_PROD,
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("", ""),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => IBLOCK_ID_ABOUT_SLIDER_NEW,
                "IBLOCK_TYPE" => "content",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "N",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "999",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("SLIDER"),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "ID",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N",
            )
        ); ?>
        <div class="container">
            <div class="educ">
                <h2>Учебно-выставочный центр Hörmann Forum</h2>
                <div class="educ__row">
                    <div class="educ__content"><?=$page->UF_LEARN_TEXT?></div>
                    <div class="educ__slider" data-app="slider-educ">
                        <div class="swiper-container">
                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:news.list",
                                "about.learn",
                                Array(
                                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                    "ADD_SECTIONS_CHAIN" => "N",
                                    "AJAX_MODE" => "N",
                                    "AJAX_OPTION_ADDITIONAL" => "",
                                    "AJAX_OPTION_HISTORY" => "N",
                                    "AJAX_OPTION_JUMP" => "N",
                                    "AJAX_OPTION_STYLE" => "N",
                                    "CACHE_FILTER" => "N",
                                    "CACHE_GROUPS" => "Y",
                                    "CACHE_TIME" => "36000000",
                                    "CACHE_TYPE" => "A",
                                    "CHECK_DATES" => "Y",
                                    "DETAIL_URL" => "",
                                    "DISPLAY_BOTTOM_PAGER" => "N",
                                    "DISPLAY_DATE" => "Y",
                                    "DISPLAY_NAME" => "Y",
                                    "DISPLAY_PICTURE" => "Y",
                                    "DISPLAY_PREVIEW_TEXT" => "Y",
                                    "DISPLAY_TOP_PAGER" => "N",
                                    "FIELD_CODE" => array("", ""),
                                    "FILTER_NAME" => "",
                                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                    "IBLOCK_ID" => IBLOCK_ID_ABOUT_LEARN,
                                    "IBLOCK_TYPE" => "content",
                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                    "INCLUDE_SUBSECTIONS" => "N",
                                    "MESSAGE_404" => "",
                                    "NEWS_COUNT" => "999",
                                    "PAGER_BASE_LINK_ENABLE" => "N",
                                    "PAGER_DESC_NUMBERING" => "N",
                                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "",
                                    "PAGER_SHOW_ALL" => "N",
                                    "PAGER_SHOW_ALWAYS" => "N",
                                    "PAGER_TEMPLATE" => ".default",
                                    "PAGER_TITLE" => "",
                                    "PARENT_SECTION" => "",
                                    "PARENT_SECTION_CODE" => "",
                                    "PREVIEW_TRUNCATE_LEN" => "",
                                    "PROPERTY_CODE" => array("SLIDER"),
                                    "SET_BROWSER_TITLE" => "N",
                                    "SET_LAST_MODIFIED" => "N",
                                    "SET_META_DESCRIPTION" => "N",
                                    "SET_META_KEYWORDS" => "N",
                                    "SET_STATUS_404" => "N",
                                    "SET_TITLE" => "N",
                                    "SHOW_404" => "N",
                                    "SORT_BY1" => "SORT",
                                    "SORT_BY2" => "SORT",
                                    "SORT_ORDER1" => "ASC",
                                    "SORT_ORDER2" => "ASC",
                                    "STRICT_SECTION_CHECK" => "N",
                                )
                            ); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="greenbook">
                <div class="edge wow" data-app="edge" style="background-image:url(<?=CFile::GetPath($page->UF_BACK_ECO)?>)" data-wow-offset="200">
                    <div class="edge__box">
                        <div class="edge__content">
                            <div class="h2">Экология</div>
                            <div class="text"><?=$page->UF_ECO_TEXT?></div>
                        </div>
                        <div class="edge__slider">
                            <div class="edge__number">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="subtext">01</div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="subtext">02</div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="subtext">03</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="edge__inner">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="edge__inner__row">
                                                <div class="edge__inner__img">
                                                    <img src="<?=CFile::GetPath($page->UF_FILE_ECO1)?>" alt="">
                                                </div>
                                                <div class="edge__inner__content">
                                                    <div class="subtext"><?=$page->UF_TITLE_ECO1?></div>
                                                    <div class="text"><?=$page->UF_TEXT_ECO1?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="edge__inner__row">
                                                <div class="edge__inner__img">
                                                    <img src="<?=CFile::GetPath($page->UF_FILE_ECO2)?>" alt="">
                                                </div>
                                                <div class="edge__inner__content">
                                                    <div class="subtext"><?=$page->UF_TITLE_ECO2?></div>
                                                    <div class="text"><?=$page->UF_TEXT_ECO2?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="edge__inner__row">
                                                <div class="edge__inner__img">
                                                    <img src="<?=CFile::GetPath($page->UF_FILE_ECO3)?>" alt="">
                                                </div>
                                                <div class="edge__inner__content">
                                                    <div class="subtext"><?=$page->UF_TITLE_ECO3?></div>
                                                    <div class="text"><?=$page->UF_TEXT_ECO3?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="greenbook__info">
                    <div class="greenbook__logo">
                        <img src="<?=CFile::GetPath($page->UF_GREEN_FILE)?>" alt="">
                    </div>
                    <div class="greenbook__row"><?=$page->UF_GREEN_TEXT?></div>
                </div>
            </div>
            <div class="bitmap bitmap_logic">
                <div class="bitmap__content">
                    <h2>Логистика</h2>
                    <div class="text"><?=$page->UF_LOG_TEXT?></div>
                </div>
                <div class="bitmap__image"><img src="<?=CFile::GetPath($page->UF_LOG_FILE)?>" alt=""></div>
            </div>
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

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
