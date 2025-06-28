<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="choice wow" data-wow-offset="200" data-app="choice">
    <div class="choice__list">
        <div class="choice__list__menu">
            <button class="choice__list__menu__btn" type="button"></button>
            <ul>
                <?foreach ($arResult['ITEMS'] as $key => $item):?>
                    <li><a <?=$key==0?'class="is-active-mob" ':''?>href="#" data-target="<?=$key+1?>"><?=$item['NAME']?></a></li>
                <?endforeach;?>
            </ul>
        </div>
        <?foreach ($arResult['ITEMS'] as $key => $item):?>
        <div class="choice__item is-active-mob" data-item="<?=$key+1?>">
            <div class="subtext"><?=$key+1?>. <?=$item['NAME']?></div>
            <div class="choice__item__text"><?=$item['PREVIEW_TEXT']?></div>
            <div class="choice__item__drop">
                <?foreach ($item['PROPERTIES']['LINK']['VALUE'] as $i => $link): ?>
                    <a href="<?=$link?>"><?=$item['PROPERTIES']['LINK']['DESCRIPTION'][$i]?></a>
                <?endforeach;?>
            </div>
        </div>
        <?endforeach;?>
    </div>
    <div class="choice__image">
        <img src="<?=CFile::GetPath($arParams['PAGE']->UF_HOME_FILE)?>" alt="">
        <?foreach ($arResult['ITEMS'] as $key => $item):?>
        <div class="choice__image__pin" style="<?=$item['PROPERTIES']['POSITION']['VALUE']?>" data-target="<?=$key+1?>">
            <button class="choice__image__pin__btn" type="button"><?=$key+1?></button>
            <div class="choice__image__info">
                <div class="subtext"><?=$item['NAME']?></div>
                <?foreach ($item['PROPERTIES']['LINK']['VALUE'] as $i => $link): ?>
                    <a href="<?=$link?>"><?=$item['PROPERTIES']['LINK']['DESCRIPTION'][$i]?></a>
                <?endforeach;?>
            </div>
        </div>
        <?endforeach;?>
    </div>
</div>