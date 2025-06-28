<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="wrapp__content">
    <? foreach ($arResult['ITEMS'] as $section): ?>
        <? if ($section['ITEMS']): ?>
            <div class="title-text wow" data-wow-offset="200" id="<?= $section['CODE'] ?>"><?= $section['NAME'] ?></div>
            <div class="media wow" data-wow-offset="200" data-app="media">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <? foreach ($section['ITEMS'] as $item): ?>
                            <div class="swiper-slide">
                                <a class="media__item" href="<?= CFile::GetPath($item['PROPERTIES']['FILE']['VALUE']) ?>">
                                    <div class="media__item__image"><img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="">
                                        <div class="media__item__image__box">PDF</div>
                                    </div>
                                    <div class="media__item__text"><?= $item['NAME'] ?></div>
                                </a>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        <? endif; ?>
    <? endforeach; ?>
</div>