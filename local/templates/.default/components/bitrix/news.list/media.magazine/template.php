<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="items items_media wow" data-wow-offset="200">
    <div class="items__row">
        <? foreach ($arResult['ITEMS'] as $item): ?>
            <div class="items__col">
                <a class="items__item" target="_blank" href="<?= CFile::GetPath($item['PROPERTIES']['FILE']['VALUE']) ?>">
                    <div class="items__item__image">
                        <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="">
                        <div class="items__item__image__box">PDF</div>
                    </div>
                    <div class="subtext"><?= $item['NAME'] ?></div>
                </a>
            </div>
        <? endforeach; ?>
    </div>
</div>