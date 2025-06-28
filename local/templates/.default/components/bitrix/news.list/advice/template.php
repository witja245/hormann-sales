<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="adv-tiles wow" data-wow-offset="200">
    <?foreach ($arResult['ITEMS'] as $item):?>
        <a class="adv-tile" href="<?=$item['DETAIL_PAGE_URL']?>">
            <div class="at-img">
                <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>">
            </div>
            <div class="at-txt">
                <p><?=$item['NAME']?></p>
            </div>
        </a>
    <?endforeach;?>
</div>