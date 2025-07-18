<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult['ITEMS']): ?>
    <h2 class="wow" data-wow-offset="200">Рекомендуем</h2>
    <div class="slider wow" data-wow-offset="200" data-app="slider-goods">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <? foreach ($arResult['ITEMS'] as $item): ?>
                    <div class="swiper-slide">
                        <a class="slider__goods" href="<?= $item['DETAIL_PAGE_URL'] ?>">
                            <div class="slider__goods__image">
                                <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="">
                            </div>
                            <div class="slider__goods__title"><?= $item['NAME'] ?></div>
                        </a>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
        <? if (count($arResult['ITEMS']) > 3): ?>
            <div class="slider__pager"></div>
        <? endif; ?>
    </div>
<?php endif; ?>