<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Автоматические ворота Hormann купить в Москве и области с установкой под ключ | Херманн Руссия официальный сайт");
$APPLICATION->SetPageProperty("description", "Автоматические ворота Hormann (Херман) с дистанционным управлением по выгодной цене: гаражные, промышленные, автоматика ✔️ Немецкое качество от производителя ✔️ Доставка по России ✔️ Дилерская сеть");
$APPLICATION->SetTitle("Hormann");
$APPLICATION->SetPageProperty("HEADER_CLASS", 'header-homepage');
?>
<?php
$page = \Itech\PageService::getInstance()->get();
?>
    <div class="content content_homepage">
        <main class="page-index">
            <?php $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "slider.main",
                Array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "CACHE_FILTER" => "Y",
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
                    "IBLOCK_ID" => IBLOCK_ID_MAIN_SLIDER,
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
                    "SORT_BY2" => "NAME",
                    "SORT_ORDER1" => "ASC",
                    "SORT_ORDER2" => "DESC",
                    "STRICT_SECTION_CHECK" => "N",
                )
            ); ?>

            <?
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main.products",
                Array(
                    "IBLOCK_ID" => IBLOCK_ID_CATALOG,
                    "SECTION_ID" => '',
                    "SECTION_CODE" => '',
                    "CACHE_TYPE" => 'A',
                    'ADD_SECTIONS_CHAIN' => 'N',
                    'FILTER_NAME' => '',
                    "SECTION_USER_FIELDS" => [
                        'UF_HOME',
                        'UF_BUSINESS'
                    ]
                )
            );
            ?>

            <?php global $filterFirst;
            $filterFirst = ['PROPERTY_FIRST_VALUE'=>'Y'];
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "share.main",
                Array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "CACHE_FILTER" => "Y",
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
                    "FILTER_NAME" => "filterFirst",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => IBLOCK_ID_SHARE,
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
                    "PROPERTY_CODE" => array("PRICE", "TEXT"),
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

            <div class="edge edge_images wow" data-app="edge" data-wow-offset="200">
                <div class="edge__image">
                    <img src="<?= CFile::GetPath($page->UF_BACK1) ?>" alt="edge__image-1">
                    <img src="<?= CFile::GetPath($page->UF_BACK2) ?>" alt="edge__image-2">
                    <img src="<?= CFile::GetPath($page->UF_BACK3) ?>" alt="edge__image-3">
                </div>
                <div class="container">
                    <div class="edge__box">
                        <div class="edge__content">
                            <div class="h2"><?= $page->PREVIEW_TEXT ?></div>
                            <div class="text"><?= $page->DETAIL_TEXT ?></div>
                            <div class="link-arrow">
                                <a href="/about/">О компании</a>
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
                                                    <img src="<?= CFile::GetPath($page->UF_FILE1) ?>" alt="<?= $page->UF_TEXT1 ?>" width="66" height="80">
                                                </div>
                                                <div class="edge__inner__content">
                                                    <div class="subtext"><?= $page->UF_TITLE1 ?></div>
                                                    <div class="text"><?= $page->UF_TEXT1 ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="edge__inner__row">
                                                <div class="edge__inner__img">
                                                    <img src="<?= CFile::GetPath($page->UF_FILE2) ?>" alt="<?= $page->UF_TEXT2 ?>" width="66" height="80">
                                                </div>
                                                <div class="edge__inner__content">
                                                    <div class="subtext"><?= $page->UF_TITLE2 ?></div>
                                                    <div class="text"><?= $page->UF_TEXT2 ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="edge__inner__row">
                                                <div class="edge__inner__img">
                                                    <img src="<?= CFile::GetPath($page->UF_FILE3) ?>" alt="<?= $page->UF_TEXT3 ?>" width="66" height="80">
                                                </div>
                                                <div class="edge__inner__content">
                                                    <div class="subtext"><?= $page->UF_TITLE3 ?></div>
                                                    <div class="text"><?= $page->UF_TEXT3 ?></div>
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

            <section class="is-section is-section--colored wow" data-wow-offset="200">
                <div class="wrapper wrapper--md">
                    <div class="advice wow" data-wow-offset="200">
                        <div class="title-row">
                            <div class="h2">Советы Hörmann</div>
                            <div class="link-icon"><a href="/advice/">
                                    <svg>
                                        <use xlink:href="/static/build/images/sprites.svg#blocks"></use>
                                    </svg>
                                    <span>Смотреть все</span>
                                </a>
                            </div>

                        </div>
                        <? $APPLICATION->IncludeComponent("bitrix:news.list", "advice.main",
                            Array(
                                "DISPLAY_DATE" => "Y",
                                "DISPLAY_NAME" => "Y",
                                "DISPLAY_PICTURE" => "Y",
                                "DISPLAY_PREVIEW_TEXT" => "Y",
                                "AJAX_MODE" => "Y",
                                "IBLOCK_TYPE" => "news",
                                "IBLOCK_ID" => IBLOCK_ID_ADVICE,
                                "NEWS_COUNT" => "3",
                                "SORT_BY1" => "ACTIVE_FROM",
                                "SORT_ORDER1" => "DESC",
                                "SORT_BY2" => "SORT",
                                "SORT_ORDER2" => "ASC",
                                "FILTER_NAME" => "",
                                "FIELD_CODE" => Array(""),
                                "PROPERTY_CODE" => Array(""),
                                "CHECK_DATES" => "Y",
                                "DETAIL_URL" => "",
                                "PREVIEW_TRUNCATE_LEN" => "",
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "SET_TITLE" => "N",
                                "SET_BROWSER_TITLE" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                                "ADD_SECTIONS_CHAIN" => "Y",
                                "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                                "PARENT_SECTION" => "",
                                "PARENT_SECTION_CODE" => "",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "CACHE_TYPE" => "A",
                                "CACHE_TIME" => "3600",
                                "CACHE_FILTER" => "Y",
                                "CACHE_GROUPS" => "Y",
                                "DISPLAY_TOP_PAGER" => "Y",
                                "DISPLAY_BOTTOM_PAGER" => "Y",
                                "PAGER_TITLE" => "Новости",
                                "PAGER_SHOW_ALWAYS" => "Y",
                                "PAGER_TEMPLATE" => "",
                                "PAGER_DESC_NUMBERING" => "Y",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "Y",
                                "PAGER_BASE_LINK_ENABLE" => "Y",
                                "SET_STATUS_404" => "Y",
                                "SHOW_404" => "Y",
                                "MESSAGE_404" => "",
                                "PAGER_BASE_LINK" => "",
                                "PAGER_PARAMS_NAME" => "arrPager",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "AJAX_OPTION_HISTORY" => "N",
                                "AJAX_OPTION_ADDITIONAL" => ""
                            )
                        ); ?>
                    </div>
                </div>
            </section>


            <?php global $filterSecond;
            $filterSecond = ['PROPERTY_SECOND_VALUE'=>'Y'];
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "share.main",
                Array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "CACHE_FILTER" => "Y",
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
                    "FILTER_NAME" => 'filterSecond',
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => IBLOCK_ID_SHARE,
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
                    "PROPERTY_CODE" => array("PRICE", "TEXT"),
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

            <section class="is-section page-index__map-sect wow" data-wow-offset="200">
                <div class="wrapper wrapper--md">
                    <div class="map-img" data-img="<?= CFile::GetPath($page->UF_SUBSIDIARY_PICTURE) ?>">
                        <div class="b-center">
                            <div class="h4"><?= $page->UF_SUBSIDIARY_TITLE ?></div>
                            <p class="is-text"><?= $page->UF_SUBSIDIARY_TEXT ?></p>
                            <a href="/contacts/" class="button button--md button--primary">
                                <span class="button__text">Найти дилера</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "main.bottom.block",
                Array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "CACHE_FILTER" => "Y",
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
                    "FILTER_NAME" => '',
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => IBLOCK_ID_MAIN_BOTTOM,
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
                    "PROPERTY_CODE" => array("PRICE", "TEXT"),
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

        </main>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
