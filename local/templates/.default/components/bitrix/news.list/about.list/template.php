<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="container container_width-1038">
    <? foreach ($arResult['ITEMS'] as $key => $item): ?>
        <? if ($key % 2 == 0): ?>
            <div class="bitmap bitmap_img-left-384">
                <div class="bitmap__image">
                    <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="">
                </div>
                <div class="bitmap__content">
                    <h2><?= $item['NAME'] ?></h2>
                    <div class="text"><?= $item['PREVIEW_TEXT'] ?></div>
                </div>
            </div>
        <? else: ?>
            <div class="bitmap bitmap_img-right-384">
                <div class="bitmap__content">
                    <h2><?= $item['NAME'] ?></h2>
                    <div class="text"><?= $item['PREVIEW_TEXT'] ?></div>
                </div>
                <div class="bitmap__image">
                    <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="">
                </div>
            </div>
        <? endif; ?>
    <? endforeach; ?>
</div>