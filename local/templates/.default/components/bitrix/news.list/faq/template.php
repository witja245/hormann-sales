<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<h2 class="wow" data-wow-offset="200"><?= $arResult["NAME"] ?></h2>

<div class="accordion accordion_program wow" data-wow-offset="200" data-app="accordion">

<? foreach ($arResult["SECTION_LIST"] as $section): ?>

    <? if ($arResult["SECTIONS"][$section["ID"]]): ?>

        <div class="accordion__item">
            <div class="title-text"><?= $section["NAME"] ?></div>
            <div class="accordion__drop">

            <? $section = $arResult["SECTIONS"][$section["ID"]]; ?>
            <? foreach ($section as $item): ?>

                <? if ($item["PROPERTIES"]["DONT_SHOW_TITLE"]["VALUE"] != "Y"):?>
                    <div class="subtext"><span><?= $item["NAME"] ?></span></div>
                <? endif; ?>

                <? if ($item["PREVIEW_TEXT"]): ?>
                    <div class="text"><?= $item["PREVIEW_TEXT"] ?></div>
                <? endif; ?>

                <? if ($item["PREVIEW_PICTURE"]): ?>
                    <div class="accordion__drop__image"><img src="<?= $item["PREVIEW_PICTURE"]["SRC"] ?>" alt=""></div>
                <? endif; ?>

            <? endforeach; ?>

            </div>
        </div>

    <? endif; ?>

<? endforeach; ?>

</div>
