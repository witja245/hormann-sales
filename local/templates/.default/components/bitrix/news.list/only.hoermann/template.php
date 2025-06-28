<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?php if ($arResult['ITEMS']):?>
<h2 class="wow" data-wow-offset="200">Только у Hoermann</h2>
<div class="but wow" data-wow-offset="200">
    <div class="but__row">
        <?foreach ($arResult['ITEMS'] as $item):?>
            <div class="but__col">
                <div class="but__item">
                    <div class="but__item__image"><img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt=""></div>
                    <div class="title-text"><?=$item['NAME']?></div>
                    <div class="subtext"><?=$item['PREVIEW_TEXT']?></div>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>
<?php endif;?>