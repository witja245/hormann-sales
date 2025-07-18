<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="sked__col">
    <a class="sked__item js-sked-open" href="/ajax/product_without_listing.php/?id=<?=$arResult['ITEM']['ID']?>" style="background-image:url(<?=$arResult['ITEM']['PREVIEW_PICTURE']['SRC']?>)">
        <div class="sked__item__text"><?=$arResult['ITEM']['NAME']?></div>
    </a>
</div>
