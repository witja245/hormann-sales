<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<form class="title-row" action="/search/" method="get">
    <h1 class="h2 wow" data-wow-offset="200">Результаты поиска по запросу</h1>
    <div class="title-row__search wow" data-wow-offset="200">
        <input type="text" name="q" placeholder="Поиск по сайту" data-validation="{&quot;maxlength&quot;:300}" required
               value="<?= $arResult['REQUEST']['~QUERY'] ?>">
        <button type="submit">
            <svg>
                <use xlink:href="/static/build/images/sprites.svg#search"></use>
            </svg>
        </button>
    </div>
</form>
<div class="wrapp wow" data-wow-offset="200">
    <div class="wrapp__side wrapp__side_margin">
        <a class="btn<?= !$_REQUEST['PRODUCT'] && !$_REQUEST['NEWS'] ? '' : ' btn_white' ?>"
           href="/search/?q=<?= $arResult['REQUEST']['~QUERY'] ?>">Все</a>
        <a class="btn<?= $_REQUEST['PRODUCT'] ? '' : ' btn_white' ?>"
           href="/search/?PRODUCT=product&q=<?= $arResult['REQUEST']['~QUERY'] ?>">Продукция</a>
        <a class="btn<?= $_REQUEST['NEWS'] ? '' : ' btn_white' ?>"
           href="/search/?NEWS=news&q=<?= $arResult['REQUEST']['~QUERY'] ?>">Новости и советы</a>
    </div>
    <div class="wrapp__content">
        <div class="search">
            <? if ($arResult['SEARCH'] || !$arResult['REQUEST']['~QUERY']): ?>
                <? foreach ($arResult['SEARCH'] as $item): ?>
                    <a class="search__item" href="<?= $item['URL_WO_PARAMS'] ?>">
                        <div class="title-text"><?= $item['~TITLE'] ?></div>
                        <div class="text"><?= $item['~BODY_FORMATED'] ?></div>
                    </a>
                <? endforeach; ?>
            <? else: ?>
                К сожалению, по вашему запросу "<?= $arResult['REQUEST']['~QUERY'] ?>" ничего не найдено, попробуйте переформулировать запрос или ввести новый.
            <? endif; ?>
        </div>
        <? if ($arResult['NAV_RESULT']->NavPageCount != 1): ?>
            <div class="pagination wow" data-wow-offset="200"><?= $arResult['NAV_STRING'] ?></div>
        <? endif; ?>
    </div>
</div>