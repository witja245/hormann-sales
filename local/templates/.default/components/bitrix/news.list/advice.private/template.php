<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="container">
    <div class="title-row">
        <div class="h2">Советы Hörmann</div>
        <div class="link-icon">
            <a href="/advice/">
                <svg>
                    <use xlink:href="/static/build/images/sprites.svg#blocks"></use>
                </svg><span>Смотреть все</span>
            </a>
        </div>
    </div>
    <div class="advice__list" data-app="slider-advice">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?foreach ($arResult['ITEMS'] as $item):?>
                <div class="swiper-slide">
                    <a class="advice__list__item" href="<?=$item['DETAIL_PAGE_URL']?>">
                        <div class="advice__list__item__image">
                            <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="">
                        </div>
                        <div class="subtext"><?=$item['~NAME']?></div>
                    </a>
                </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
</div>
