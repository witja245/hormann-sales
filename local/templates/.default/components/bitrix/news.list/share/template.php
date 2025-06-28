<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="offers-list">
    <? foreach ($arResult['ITEMS'] as $item): ?>
        <div class="li-item wow" data-wow-offset="200">
            <a class="li-item-image" href="<?= $item['DETAIL_PAGE_URL'] ?>">
                <div class="full-img" style="background-image:url(<?= $item['PREVIEW_PICTURE']['SRC'] ?>)"></div>
            </a>
            <div class="li-item-content">
                <div class="c-date"><?= $item['PROPERTIES']['TEXT']['VALUE'] ?></div>
                <div class="c-header"><a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['NAME'] ?></a></div>
                <div class="c-preview"><?= $item['PREVIEW_TEXT'] ?></div>
                <div class="c-button"><a class="btn" href="<?= $item['DETAIL_PAGE_URL'] ?>"><span>Подробнее</span></a>
                </div>
            </div>
        </div>
    <? endforeach; ?>
</div>

<? if ($arResult['NAV_RESULT']->NavPageCount != 1): ?>
    <div class="pagination wow" data-wow-offset="200"><?= $arResult['NAV_STRING'] ?></div>
<? endif; ?>
        