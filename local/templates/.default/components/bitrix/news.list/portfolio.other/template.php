<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<h2 class="wow" data-wow-offset="200">Другие проекты</h2>

<div class="items wow" data-wow-offset="200">
    <div class="items__row">
        <?foreach ($arResult['ITEMS'] as $item):?>
        <div class="items__col">
            <a class="items__item" href="<?=$item['DETAIL_PAGE_URL']?>">
                <div class="items__item__image">
                    <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="">
                </div>
                <div class="title-text"><?=$item['NAME']?></div>
            </a>
        </div>
        <?endforeach;?>
    </div>
</div>