<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<style>
ul { 
		margin-bottom: 56px;
   }
</style>
<div class="news-detail wow page-text-list" data-wow-offset="200">
    <p class="date">
        <?= $arResult["DISPLAY_ACTIVE_FROM"] ?>
    </p>
    <h1 class="h2"><?= $arResult["~NAME"] ?></h1>
    <div class="news-detail__img" style="background-image:url(<?= $arResult["PREVIEW_PICTURE"]["SRC"] ?>)"></div>
	<p><?= $arResult["~PREVIEW_TEXT"] ?></p>
    <h4><?= $arResult["PROPERTIES"]["TEXT"]["VALUE"] ?></h4>
	<p><?= $arResult["~DETAIL_TEXT"] ?></p>
</div>
