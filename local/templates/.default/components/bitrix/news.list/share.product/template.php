<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<?php if (count($arResult['ITEMS'])!=0):?>
<a class="banner wow" href="<?= $arResult['ITEMS'][0]['DETAIL_PAGE_URL'] ?>" data-wow-offset="200">
    <div class="banner__content">
        <div class="title-text"><?= $arResult['ITEMS'][0]['NAME'] ?></div>
        <div class="banner__text"><?= $arResult['ITEMS'][0]['PREVIEW_TEXT'] ?></div>
    </div>
    <div class="banner__image"><img src="<?= $arResult['ITEMS'][0]['PREVIEW_PICTURE']['SRC'] ?>" alt=""></div>
</a>
<?php endif;?>