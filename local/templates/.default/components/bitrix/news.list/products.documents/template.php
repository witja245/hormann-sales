<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult['ITEMS']):?>
<h2 class="wow" data-wow-offset="200">Документация</h2>
<div class="records wow" data-wow-offset="200">
    <div class="records__row">
        <? foreach ($arResult['ITEMS'] as $item): ?>
            <div class="records__col">
                <a class="records__item" href="<?= $item['PROPERTIES']['FILE']['SRC'] ?>" download>
                    <div class="records__item__image">
                        <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="">
                    </div>
                    <div class="records__item__title"><?= $item['NAME'] ?></div>
                    <div class="records__item__text"><?echo strtoupper($item['PROPERTIES']['FILE']['EXTENSION']).', '.$item['PROPERTIES']['FILE']['FILE_SIZE'] ?></div>
                </a>
            </div>
        <? endforeach; ?>
    </div>
</div>
<?php endif;?>