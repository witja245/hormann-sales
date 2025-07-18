<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult['SECTIONS']): ?>
    <div class="breeding_links-block">
        <div class="container">
            <div class="breeding_links">
                <? foreach ($arResult['SECTIONS'] as $subSection):?>

                    <a href="<?= $subSection['SECTION_PAGE_URL'] ?>" class="breeding_link">
                        <img src="<?= $subSection['PICTURE']['SRC'] ?>" alt="<?= $subSection['NAME'] ?>">
                        <?= $subSection['NAME'] ?>
                    </a>
                <? endforeach; ?>

            </div>
        </div>
    </div>

    <? foreach ($arResult['SECTIONS'] as $key => $subSectionDesc):?>

        <?php if ($key % 2 == 0): ?>
            <section class="series">
                <div class="container">
                    <h2 class="title"><?= $subSectionDesc['NAME'] ?></h2>
                    <div class="series_content active">
                        <div class="series_content-wrapper">
                            <div class="series_info">
                                <?= $subSectionDesc['DESCRIPTION'] ?>
                                <a href="<?= $subSectionDesc['SECTION_PAGE_URL'] ?>" class="series_btn btn">Подробнее</a>
                            </div>
                            <div class="series_img"><img src="<?= $subSectionDesc['PICTURE']['SRC'] ?>" alt="<?= $subSectionDesc['NAME'] ?>"></div>
                        </div>
                    </div>
                </div>
            </section>
        <?php else: ?>
            <section class="series reverse">
                <div class="container">
                    <h2 class="title"><?= $subSectionDesc['NAME'] ?></h2>
                    <div class="series_content active">
                        <div class="series_content-wrapper">

                            <div class="series_info">
                                <?= $subSectionDesc['DESCRIPTION'] ?>
                                <a href="<?= $subSectionDesc['SECTION_PAGE_URL'] ?>" class="series_btn btn">Подробнее</a>
                            </div>
                            <div class="series_img"><img src="<?= $subSectionDesc['PICTURE']['SRC'] ?>" alt="<?= $subSectionDesc['NAME'] ?>"></div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <? endforeach; ?>

<?php endif; ?>