<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<h2 class="wow" data-wow-offset="200"><a href="/products/">Каталог</a></h2>
<div class="roll wow" data-wow-offset="200">
    <div class="roll__row">
        <? foreach ($arResult['SECTIONS'] as $subSection): ?>
            <div class="roll__col">
                <a class="roll__item" href="<?= $subSection['SECTION_PAGE_URL'] ?>">
                    <div class="roll__item__image"><img src="<?= $subSection['PICTURE']['SRC'] ?>" alt=""></div>
                    <div class="title-text"><?= $subSection['NAME'] ?></div>
                </a>
            </div>
        <? endforeach; ?>
    </div>
</div>
