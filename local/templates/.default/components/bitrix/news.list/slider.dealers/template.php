<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="edge__slider">

    <div class="edge__number">
        <div class="swiper-container">
            <div class="swiper-wrapper">

                <?php foreach ($arResult['ITEMS'] as $id => $item):?>
                    <div class="swiper-slide">
                        <div class="subtext"><?= strlen($id) > 1 ? ($id + 1) : "0" . ($id + 1)?></div>
                    </div>
                <?php endforeach;?>

            </div>
        </div>
    </div>

    <div class="edge__inner">
        <div class="swiper-container">
            <div class="swiper-wrapper">

                <?php foreach ($arResult['ITEMS'] as $item):?>
                    <div class="swiper-slide">
                        <div class="edge__inner__row">
                            <div class="edge__inner__img"><img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt=""></div>
                            <div class="edge__inner__content">
                                <div class="subtext"><?=$item['NAME']?></div>
                                <div class="text"><?=$item['PREVIEW_TEXT']?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>

            </div>
        </div>
    </div>

</div>
