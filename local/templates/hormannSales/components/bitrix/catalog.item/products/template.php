<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="catalogue__col">
    <div class="catalogue__item">
        <a href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>" class="catalogue__item__image">
            <img src="<?= $arResult['ITEM']['PREVIEW_PICTURE']['SRC'] ?>" alt="">
            <? if ($arResult['ITEM']['PROPERTIES']['LABEL']['VALUE']): ?>
                <div class="catalogue__item__action"><?= $arResult['ITEM']['PROPERTIES']['LABEL']['VALUE'] ?></div>
            <? endif; ?>
        </a>
        <div class="catalogue__item__content">
            <div class="catalogue__item__title"><a
                        href="<?= $arResult['ITEM']['DETAIL_PAGE_URL'] ?>"><?= $arResult['ITEM']['NAME'] ?></a></div>
            <div class="catalogue__item__info">
                <ul>
                    <? if ($arResult['GOFR_STR']): ?>
                        <li>Мотив: <?= $arResult['GOFR_STR'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['COLOR_STR']): ?>
                        <li>Цвет: <?= $arResult['COLOR_STR'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['DRIVE_UNIT']): ?>
                        <li>Привод: <?= $arResult['DRIVE_UNIT'] ?></li>
                    <? endif; ?>
                    <?/*
                    <? if ($arResult['ITEM']['PROPERTIES']['TYPE']['VALUE']): ?>
                        <li>Серия: <?= $arResult['ITEM']['PROPERTIES']['TYPE']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['CANVAS_MATERIAL']['VALUE']): ?>
                        <li>Мотив полотна: <?= $arResult['ITEM']['PROPERTIES']['CANVAS_MATERIAL']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['CONTROL']['VALUE']): ?>
                        <li>Управление: <?= $arResult['ITEM']['PROPERTIES']['CONTROL']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['MATERIAL']['VALUE']): ?>
                        <li>Материал: <?= $arResult['ITEM']['PROPERTIES']['MATERIAL']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['TIME']['VALUE']): ?>
                        <li>Срок изготовления: <?= $arResult['ITEM']['PROPERTIES']['TIME']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['CONSTRUCTION']['VALUE']): ?>
                        <li>Конструкция: <?= $arResult['ITEM']['PROPERTIES']['CONSTRUCTION']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['TIME']['VALUE']): ?>
                        <li>Срок поставки: <?= $arResult['ITEM']['PROPERTIES']['TIME']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['COUNTRY_OF_ORIGIN']['VALUE']): ?>
                        <li>Страна производства: <?= $arResult['ITEM']['PROPERTIES']['COUNTRY_OF_ORIGIN']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['APPOINTMENT']['VALUE']): ?>
                        <li>Назначение: <?= $arResult['ITEM']['PROPERTIES']['APPOINTMENT']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['ISOLATION']['VALUE']): ?>
                        <li>Теплоизоляция, Вт/м²∙К: <?= $arResult['ITEM']['PROPERTIES']['ISOLATION']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['GUARANTEE']['VALUE']): ?>
                        <li>Гарантия: <?= $arResult['ITEM']['PROPERTIES']['GUARANTEE']['VALUE'] ?></li>
                    <? endif; ?>
                    <? if ($arResult['ITEM']['PROPERTIES']['PANEL']['VALUE']): ?>
                        <li>Толщина панели: <?= $arResult['ITEM']['PROPERTIES']['PANEL']['VALUE'] ?></li>
                    <? endif; ?>
*/?>
                </ul>
            </div>
            <div class="catalogue__item__row">
                <div class="catalogue__item__price">По запросу</div>
               <?/* <div class="catalogue__item__price">от <?= $arResult['ITEM']['PROPERTIES']['MIN_PRICE'] ?> ₽</div>*/?>
                 <a class="btn js-order-gate-open" href="#"
                   data-id="<?= $arResult['ITEM']['ID'] ?>"><span>Заказать</span></a>
<?/*<script data-b24-form="click/25/xkz4uv" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://hormann-crm.ru/upload/crm/form/loader_25_xkz4uv.js');</script>
                <a class="btn" href="#"><span>Заказать</span></a>*/?>
            </div>
        </div>
    </div>
</div>