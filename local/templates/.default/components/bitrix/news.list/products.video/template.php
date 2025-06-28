<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult['ITEMS']):?>
<div class="slider wow" data-wow-offset="200" data-app="slider-videos">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?foreach ($arResult['ITEMS'] as $item):?>
            <div class="swiper-slide">
                <a class="slider__video" href="<?=$item['PREVIEW_TEXT']?>" style="background-image:url(<?=$item['PREVIEW_PICTURE']['SRC']?>)" data-fancybox>
                    <div class="slider__video__icon">
                        <svg>
                            <use xlink:href="/static/build/images/sprites.svg#play"></use>
                        </svg>
                    </div>
                    <div class="slider__video__title"><?=$item['NAME']?></div>
                </a>
            </div>
            <?endforeach;?>
        </div>
    </div>
    <div class="slider__pager"></div>
</div>
<?php endif;?>