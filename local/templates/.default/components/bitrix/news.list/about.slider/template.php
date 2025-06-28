<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="make" data-app="make">
    <div class="container">
        <h2>Производство</h2>
        <div class="make__row">
            <div class="make__content">
                <div class="text"><?=$arParams['~TEXT']?></div>
                <div class="make__list">
                        <ul>
                            <? $count = count($arResult['ITEMS']);
                            $middleCount = ($count%2==0?$count:$count+1)/2-1;

                            ?>
                            <?foreach ($arResult['ITEMS'] as $key => $section): ?>
                                <li><a <?=$key+1==1?'class="is-active"':''?> href="#" data-target="<?=$key?>"><?=$section['NAME']?> </a></li>
                                <?if ($key == $middleCount):?>
                                </ul><ul>
                                <?endif;?>
                            <?endforeach;?>
                        </ul>
                </div>
            </div>
            <?foreach ($arResult['ITEMS'] as $key => $section): ?>
                <div class="make__item <?=$key==0?'is-active':''?>" data-item="<?=$key?>">
                    <div class="make__slider">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <?foreach ($section['ELEMENTS'] as $item):?>
                                    <div class="swiper-slide">
                                        <div class="make__slider__item">
                                            <div class="make__slider__item__img"><img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt=""></div>
                                            <div class="make__slider__item__title"><?=$item['NAME']?></div>
                                            <div class="make__slider__item__text"><?=$item['PREVIEW_TEXT']?></div>
                                        </div>
                                    </div>
                                <?endforeach;?>
                            </div>
                        </div>
                        <button class="make__slider__arrow make__slider__arrow_prev" type="button">
                            <svg>
                                <use xlink:href="/static/build/images/sprites.svg#arrow"></use>
                            </svg>
                        </button>
                        <button class="make__slider__arrow make__slider__arrow_next" type="button">
                            <svg>
                                <use xlink:href="/static/build/images/sprites.svg#arrow"></use>
                            </svg>
                        </button>
                        <div class="make__slider__pager"></div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
</div>
