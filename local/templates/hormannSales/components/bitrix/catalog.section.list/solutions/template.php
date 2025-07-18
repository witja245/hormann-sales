<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="items__row">

<? foreach ($arResult['SECTIONS'] as $item): ?>

    <div class="items__col">
        <a class="items__item" href="<?=$item['SECTION_PAGE_URL']?>">
            <div class="items__item__image"><img src="/static/build/images/temp/43.jpg" alt=""></div>
            <div class="title-text"><?=$item['~NAME']?></div>
        </a>
    </div>

<? endforeach; ?>

</div>
