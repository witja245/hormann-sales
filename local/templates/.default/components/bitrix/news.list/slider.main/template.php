<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="index-hero wow">
    <div class="index-hero__container" data-is="index-slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php $i = 0; ?>
                <?php foreach ($arResult['ITEMS'] as $item):?>
                    <div class="swiper-slide">
                        <div class="index-hero__item">
                            <div class="index-hero__image swiper-lazy" data-background="<?=$item['PREVIEW_PICTURE']['SRC']?>"></div>
                            <div class="index-hero__content-wrapper">
                                <div class="index-hero__content wrapper wrapper--md">
                                    <div class="index-hero__content-inner">
                                        <div class="b-label"><?=$item['PREVIEW_TEXT']?></div>
                                        <?php if($i == 0): ?>
                                            <h1 class="h1 index-hero__title"><?=$item['NAME']?></h1>
                                        <?php else: ?>
                                            <div class="h1 index-hero__title"><?=$item['NAME']?></div>
                                        <?php endif; ?>
                                        <p class="index-hero__small-text"><?=$item['DETAIL_TEXT']?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-lazy-preloader"></div>
                    </div>
                    <?php $i++; ?>
                <?php endforeach;?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="b-arr-nav index-hero__nav">
                <div class="b-arr-nav__btn b-arr-nav__btn--prev js_btn-prev">
                    <svg>
                        <use xlink:href="/static/build/images/sprites.svg#arrow"></use>
                    </svg>
                </div>
                <div class="b-arr-nav__btn b-arr-nav__btn--next js_btn-next">
                    <svg>
                        <use xlink:href="/static/build/images/sprites.svg#arrow"></use>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
