<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="news-list">

    <? foreach ($arResult["ITEMS"] as $item): ?>

        <div class="news-list__item wow" data-wow-offset="200">
            <div class="nl-item__img" style="background-image:url(<?= $item["PREVIEW_PICTURE"]["SRC"] ?>)"></div>
            <div class="nl-item__aside"><a class="h3" href="<?= $item["DETAIL_PAGE_URL"] ?>"><?= $item["~NAME"] ?></a>
                <p><?= $item["DISPLAY_ACTIVE_FROM"] ?></p>
                <p class="desc"><?= $item["PREVIEW_TEXT"] ?></p>

                    <? if ($item["PROPERTIES"]["DOCS"]["VALUE"]): ?>

                        <? foreach ($item["PROPERTIES"]["DOCS"]["VALUE"] as $id => $doc): ?>

                            <? $arFile = CFile::GetFileArray($doc); ?>

                            <a href="<?= CFile::getPath($doc) ?>">
                            <svg>
                                <use xlink:href="/static/build/images/sprites.svg#press-release-full"></use>
                            </svg>
                                <span>
                                    <?= $item["PROPERTIES"]["DOCS"]["DESCRIPTION"][$id] ?>
                                </span>
                                <span>(
                                    <?= strtoupper(substr($arFile["FILE_NAME"], strrpos($arFile["FILE_NAME"], '.') + 1)) ?>,
                                    <?= CFile::FormatSize($arFile["FILE_SIZE"], 2) ?>)</span>
                            </a>
                        <? endforeach; ?>

                    <? else: ?>
                        <div class="link-arrow"><a href="<?= $item["DETAIL_PAGE_URL"] ?>">Подробнее</a></div>
                    <? endif; ?>
            </div>
        </div>

    <? endforeach; ?>

</div>
<div class="pagination wow" data-wow-offset="200">

    <?if($arResult['NAV_RESULT']->NavPageCount != 1):?>
        <?=$arResult['NAV_STRING']?>
    <?endif;?>

</div>
