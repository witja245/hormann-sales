<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<h1 class="h2 wow" data-wow-offset="200"><?= $arResult['NAME'] ?></h1>
<div class="term wow" data-wow-offset="200">
    <div class="term__item"><span>Город</span><?= $arResult['PROPERTIES']['CITY']['VALUE'] ?></div>
    <div class="term__item"><span>Сроки реализации</span><?= $arResult['PROPERTIES']['DATE']['VALUE'] ?></div>
</div>
<div class="text width-605 margin-72 wow" data-wow-offset="200"><?= $arResult['PREVIEW_TEXT'] ?></div>
<?php if ($arResult['PROPERTIES']['PICTURES']['VALUE']): ?>
    <div class="slider margin-72 wow" data-wow-offset="200" data-app="slider-images">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <? foreach ($arResult['PROPERTIES']['PICTURES']['VALUE'] as $item) : ?>
                    <div class="swiper-slide">
                        <div class="slider__img"><img src="<?= CFile::GetPath($item) ?>" alt=""></div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
        <? if (count($arResult['PROPERTIES']['PICTURES']['VALUE']) > 3): ?>
            <div class="slider__pager"></div>
        <? endif; ?>
    </div>
<?php endif; ?>
<div class="width-605 margin-56">
    <?= $arResult['DETAIL_TEXT'] ?>
    <?php if ($arResult['PROPERTIES']['EQUIPMENT']['VALUE'] || $arResult['PROPERTIES']['PECULIARITIES']['VALUE']): ?>
        <div class="width-605">
            <?php if ($arResult['PROPERTIES']['EQUIPMENT']['VALUE']): ?>
                <div class="title-text wow animated" data-wow-offset="200" style="visibility: visible;">Оборудование детально
                </div>
                <div class="text-list margin-72 wow animated" data-wow-offset="200" style="visibility: visible;">
                    <ul>
                        <? foreach ($arResult['PROPERTIES']['EQUIPMENT']['~VALUE'] as $item): ?>
                            <li><?= $item ?></li>
                        <? endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($arResult['PROPERTIES']['PECULIARITIES']['VALUE']): ?>
                <div class="title-text wow animated" data-wow-offset="200" style="visibility: visible;">Особенности
                </div>
                <div class="text margin-72 wow animated" data-wow-offset="200"
                     style="visibility: visible;"><?= $arResult['PROPERTIES']['PECULIARITIES']['~VALUE'] ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>