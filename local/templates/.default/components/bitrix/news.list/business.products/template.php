<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult['ITEMS']):?>
<div class="title-row">
    <h2 class="wow" data-wow-offset="200">Лидеры продаж</h2>
    <div class="link-icon wow" data-wow-offset="200"><a href="/products/">
            <svg>
                <use xlink:href="/static/build/images/sprites.svg#blocks"></use>
            </svg>
            <span>Весь каталог</span></a></div>
</div>
<div class="slider hidden-mobile wow" data-wow-offset="200" data-app="slider-list">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <? foreach ($arResult['CHUNK_ITEMS'] as $chunk): ?>
                <div class="swiper-slide">
                    <div class="slider__row">
                        <? foreach ($chunk as $key => $item): ?>
                            <? if ($key == 0): ?>
                                <div class="slider__col slider__col_width-35">
                            <? endif; ?>
                            <? if ($key != 2): ?>
                                <a class="slider__pic" href="<?= $item['DETAIL_PAGE_URL'] ?>">
                                    <div class="slider__pic__image"
                                         style="background-image:url(<?= $item['PREVIEW_PICTURE']['SRC'] ?>)"></div>
                                    <div class="slider__pic__content">
                                        <div class="title-text"><?= $item['NAME'] ?></div>
                                    </div>
                                </a>
                            <? endif; ?>
                            <? if ($key == 1 || ($item == end($chunk)&&count($chunk)<2)): ?>
                                </div>
                            <? endif; ?>
                            <? if ($key == 2): ?>
                                <div class="slider__col slider__col_width-73">
                                    <a class="slider__pic" href="<?= $item['DETAIL_PAGE_URL'] ?>">
                                        <div class="slider__pic__image"
                                             style="background-image:url(<?= $item['PREVIEW_PICTURE']['SRC'] ?>)"></div>
                                        <div class="slider__pic__content">
                                            <div class="title-text"><?= $item['NAME'] ?></div>
                                        </div>
                                    </a>
                                </div>
                            <? endif; ?>
                        <? endforeach; ?>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
    <?if (count($arResult['CHUNK_ITEMS'])>1):?>
        <div class="slider__pager"></div>
    <?php endif;?>
</div>
<div class="slider hidden-desktop wow" data-wow-offset="200" data-app="slider-list">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <? foreach ($arResult['ITEMS'] as $item): ?>
                <div class="swiper-slide">
                    <a class="slider__pic" href="<?= $item['DETAIL_PAGE_URL'] ?>">
                        <div class="slider__pic__image"
                             style="background-image:url(<?= $item['PREVIEW_PICTURE']['SRC'] ?>)">
                        </div>
                        <div class="slider__pic__content">
                            <div class="title-text"><?= $item['NAME'] ?></div>
                        </div>
                    </a>
                </div>
            <? endforeach; ?>
        </div>
    </div>
    <?if (count($arResult['ITEMS'])>1):?>
        <div class="slider__pager"></div>
    <?php endif;?>
</div>
<?php endif;?>