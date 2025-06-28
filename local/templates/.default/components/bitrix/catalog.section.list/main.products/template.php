<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<section class="is-section wow" data-wow-offset="100">
    <div class="wrapper wrapper--md">
        <div class="is-tabs is-tabs__nav" data-is="tabs-nav" data-tab-body="tabs-body-a">
            <? foreach ($arResult['SECTIONS'] as $section): ?>
                <span class="is-tabs__link is-link" tabindex="0" role="button"><?= $section['NAME'] ?></span>
            <? endforeach; ?>
        </div>
    </div>
    <div class="is-tabs is-tabs__container tabs-body-a">
        <div class="is-tabs__wrapper">
            <? foreach ($arResult['SECTIONS'] as $section): ?>
                <?
                $desktopItems = $section['ITEMS'];
                $mobileChunkItems = array_chunk($section['ITEMS'], 3);
                ?>
                <div class="is-tabs__tab">
                    <div class="slider hidden-mobile wow" data-wow-offset="200" data-app="slider-list">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <? foreach ($mobileChunkItems as $chunk): ?>
                                    <div class="swiper-slide">
                                        <div class="slider__row">
                                            <? foreach ($chunk as $key => $item): ?>
                                                <? if ($key == 0): ?>
                                                    <div class="slider__col slider__col_width-73">
                                                        <a class="slider__pic" href="<?= $item['SECTION_PAGE_URL'] ?>">
                                                            <div class="slider__pic__image"
                                                                 style="background-image:url(<?= $item['PICTURE']['SRC'] ?>)"></div>
                                                            <div class="slider__pic__content">
                                                                <div class="title-text"><?//= $item['NAME'] ?><?=$item["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]?></div>
                      
                                                            </div>
                                                        </a>
                                                    </div>
                                                <? else: ?>
                                                    <? if ($key == 1): ?>
                                                        <div class="slider__col slider__col_width-35">
                                                    <? endif; ?>
                                                    <a class="slider__pic" href="<?= $item['SECTION_PAGE_URL'] ?>">
                                                        <div class="slider__pic__image"
                                                             style="background-image:url(<?= $item['PICTURE']['SRC'] ?>)"></div>
                                                        <div class="slider__pic__content">
                                                            <div class="title-text"><?//= $item['NAME'] ?><?=$item["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]?></div>
                                                        </div>
                                                    </a>
                                                    <? if ($key == 2 || end($chunk) == $item): ?>
                                                        </div>
                                                    <? endif; ?>
                                                <? endif; ?>
                                            <? endforeach; ?>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                        <div class="slider__pager"></div>
                    </div>
                    <div class="slider hidden-desktop wow" data-wow-offset="200" data-app="slider-list">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <? foreach ($desktopItems as $key => $item): ?>
                                    <div class="swiper-slide">
                                        <a class="slider__pic" href="<?= $item['SECTION_PAGE_URL'] ?>">
                                            <div class="slider__pic__image"
                                                 style="background-image:url(<?= $item['PICTURE']['SRC'] ?>)">
                                            </div>
                                            <div class="slider__pic__content">
                                                <div class="title-text"><?= $item['NAME'] ?></div>
                                            </div>
                                        </a>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                        <div class="slider__pager"></div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</section>

