<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<h2>История компании</h2>
<div class="slider">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?foreach ($arResult['ITEMS'] as $item):?>
                <div class="swiper-slide">
                    <div class="slider__item">
                        <div class="slider__item__image">
                            <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="">
                        </div>
                        <div class="slider__item__label"><?=$item['PREVIEW_TEXT']?></div>
                        <div class="slider__item__text"><?=$item['DETAIL_TEXT']?></div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
</div>