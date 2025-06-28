<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="news-detail wow" data-wow-offset="200">
    <p class="date">
        <?= $arResult["DISPLAY_ACTIVE_FROM"] ?>
    </p>
    <h1 class="h2"><?= $arResult["~NAME"] ?></h1>
    <div class="news-detail__img" style="background-image:url(<?= $arResult["DETAIL_PICTURE"]["SRC"]?$arResult["DETAIL_PICTURE"]["SRC"]:$arResult["PREVIEW_PICTURE"]["SRC"] ?>)"></div>
    <p><?= $arResult["PREVIEW_TEXT"] ?></p>
    <h4><?= $arResult["PROPERTIES"]["SUBTITLE"]["VALUE"] ?></h4>
    <?= $arResult["DETAIL_TEXT"] ?>
</div>
