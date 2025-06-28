<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?php if ($arResult['ITEMS']):?>
<div class="bitmap bitmap_row wow" data-wow-offset="200">
    <?foreach ($arResult['ITEMS'] as $item):?>
    <div class="bitmap__col">
        <div class="bitmap__item">
            <div class="bitmap__item__image"><img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt=""></div>
            <div class="h2"><?=$item['NAME']?></div>
            <div class="text"><?=$item['PREVIEW_TEXT']?></div>
        </div>
    </div>
    <?endforeach;?>
</div>
<?php endif;?>