<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="products">
    <div class="products__row">
        <?foreach ($arResult['SECTIONS'] as $section):?>
        <div class="products__col">
            <div class="products__item wow" data-wow-offset="200">
                <div class="products__item__image">
                    <img src="<?=$section['PICTURE']?>" alt=""></div>
                <div class="products__item__content">
                    <div class="title-text">
                        <a href="<?=$section['SECTION_PAGE_URL']?>"><?=$section['NAME']?></a>
                    </div>
                    <div class="text">
                        <?foreach ($section['ITEMS'] as $item):?>
                            <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <?endforeach;?>
    </div>
</div>