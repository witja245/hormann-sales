<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="swiper-wrapper">
    <?foreach ($arResult['ITEMS'] as $item):?>
        <? $file = CFile::ResizeImageGet($item['PREVIEW_PICTURE']['ID'], array('width' => 384, 'height' => 240), BX_RESIZE_IMAGE_PROPORTIONAL, true); ?>
        <div class="swiper-slide">
            <div class="educ__slider__img">
                <img src="<?=$file['src']?>" alt="">
            </div>
        </div>
    <?endforeach;?>
</div>