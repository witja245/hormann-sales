<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<? foreach ($arResult["ITEMS"] as $item): ?>


    <? $arFile = CFile::GetFileArray($item["PROPERTIES"]["FILE"]["VALUE"]); ?>
    <? $ext = strtolower(substr($arFile["FILE_NAME"], strrpos($arFile["FILE_NAME"], '.') + 1)) ?>

    <div class="swiper-slide">
        <a class="ss-card" target="_blank" href="<?= $arFile["SRC"] ?>">
            <div class="ss-card-image" style="background-image:url(<?= $item["PREVIEW_PICTURE"]["SRC"]?>)"></div>
            <div class="ss-card-name"></div>
            <?= $item["NAME"] ?><br>(<?= strtoupper($ext) ?>, <?= CFile::FormatSize($arFile["FILE_SIZE"], 2) ?>)
        </a>
    </div>

<? endforeach; ?>

