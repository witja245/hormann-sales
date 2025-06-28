<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php if ($arResult['ITEMS']):?>
<h2 class="wow" data-wow-offset="200">Аргументы в пользу Hörmann</h2>
<div class="slider slider_width-488 wow" data-wow-offset="200" data-app="slider-item">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?foreach ($arResult['ITEMS'] as $item):?>
            <div class="swiper-slide">
                <div class="slider__item">
                    <div class="slider__item__image">
                        <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="">
                    </div>
                    <div class="title-text"><?=$item['NAME']?></div>
                    <div class="slider__item__text"><?=$item['PREVIEW_TEXT']?></div>
                </div>
            </div>
            <?endforeach;?>
        </div>
    </div>
    <div class="slider__pager"></div>
</div>
<?php endif;?>