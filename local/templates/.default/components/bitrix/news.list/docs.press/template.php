<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<? foreach ($arResult["ITEMS"] as $item): ?>


    <? $arFile = CFile::GetFileArray($item["PROPERTIES"]["FILE"]["VALUE"]); ?>
    <? $ext = strtolower(substr($arFile["FILE_NAME"], strrpos($arFile["FILE_NAME"], '.') + 1)) ?>

    <? $icon = $ext == "zip" ? $ext : "pdf" ?>

    <a class="press__file" href="<?= $arFile["SRC"] ?>" download>
        <div class="press__file__icon">
            <svg>
                <use xlink:href="/static/build/images/sprites.svg#<?= $icon ?>"></use>
            </svg>
        </div>
        <div class="press__file__content">
            <div class="press__file__title"><?= $item["NAME"] ?></div>
            <div class="press__file__text">(<?= strtoupper($ext) ?>, <?= CFile::FormatSize($arFile["FILE_SIZE"], 2) ?>)</div>
        </div>
    </a>

<? endforeach; ?>

