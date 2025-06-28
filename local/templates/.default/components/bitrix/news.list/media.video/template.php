<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="items wow" data-wow-offset="200">
    <div class="items__row">
        <?foreach ($arResult['ITEMS'] as $item):?>
        <div class="items__col">
            <a class="items__item" href="<?=$item['PREVIEW_TEXT']?>" data-fancybox>
                <div class="items__item__image">
                    <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="">
                    <div class="items__item__image__play">
                        <svg>
                            <use xlink:href="/static/build/images/sprites.svg#play"></use>
                        </svg>
                    </div>
                </div>
                <div class="subtext"><?=$item['~NAME']?></div>
            </a>
        </div>
        <?endforeach;?>
    </div>
</div>
