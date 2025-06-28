<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="advice__list" data-app="slider-advice">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <? foreach ($arResult['ITEMS'] as $item): ?>
                <div class="swiper-slide">
                    <a class="advice__list__item" href="<?=$item['DETAIL_PAGE_URL']?>">
                        <div class="advice__list__item__image">
                            <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="<?=$item['~NAME']?>" width="370" height="235">
                        </div>
                        <div class="subtext"><?=$item['~NAME']?></div>
                    </a>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>