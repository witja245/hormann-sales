<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="program">

    <div class="program__row wow" data-wow-offset="200">
        <div class="program__col">
            <div class="program__item">
                <?/*<div class="text"><?= $arResult["DESCRIPTION"] ?></div>*/?>
                <div class="text">Программа создана специально для архитекторов, чтобы облегчить их работу и поиск информации об оборудовании Hörmann. В ней можно выбрать продукты с BIM-моделями, отфильтровать оборудование по назначению и категориям. Интерфейс интуитивно понятный, поиск корректный — с их помощью вы получите быстрый доступ к описаниям и чертежам в формате DWG и PDF.</div>
            </div>
        </div>
        <div class="program__col program__col_mob-order">
            <div class="program__image"><img src="<?= CFile::getPath($arResult["PICTURE"]) ?>" alt=""></div>
        </div>
    </div>

    <div class="program__row wow" data-wow-offset="200">

        <? foreach ($arResult["ITEMS"] as $item): ?>
        <div class="program__col">
            <div class="program__item">
                <div class="title-text"><?= $item["NAME"] ?></div>
                <div class="text"><?= $item["PREVIEW_TEXT"] ?></div>

                <? if($item["PROPERTIES"]["LINK"]["VALUE"]): ?>
                    <a class="btn" href="<?= $item["PROPERTIES"]["LINK"]["VALUE"] ?>"><span><?= $item["PROPERTIES"]["LINK"]["DESCRIPTION"] ?></span></a>
                <? endif; ?>

                <? if($item["PROPERTIES"]["FILE"]["VALUE"]): ?>
                    <a class="btn" href="<?= CFile::getPath($item["PROPERTIES"]["FILE"]["VALUE"])?>" download><span><?= $item["PROPERTIES"]["FILE"]["DESCRIPTION"] ?></span></a>
                <? endif; ?>

                <? foreach ($item["PROPERTIES"]["DESC"]["VALUE"] as $el): ?>
                    <div class="program__item__desc"><?= $el ?></div>
                <? endforeach; ?>
            </div>
        </div>
        <? endforeach; ?>

    </div>
</div>

