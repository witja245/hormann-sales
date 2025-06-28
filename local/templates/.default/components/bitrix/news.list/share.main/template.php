<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<?php if ($arResult['ITEMS'][0]): ?>
    <?php if ($arParams['FILTER_NAME'] == 'filterFirst'): ?>
        <section class="is-section wow" data-wow-offset="200">
            <div class="wrapper wrapper--sm">
                <a href="<?= $arResult['ITEMS'][0]['DETAIL_PAGE_URL'] ?>" class="is-link">
                    <div class="is-columns b-offer b-offer--type1">
                        <div class="col b-offer__text-cont">
                            <span class="b-label b-label-1"><?= $arResult['ITEMS'][0]['PROPERTIES']['TEXT']['VALUE'] ?></span>
                            <div class="b-offer__text-block">
                                <div class="b-offer__title"><?= $arResult['ITEMS'][0]['NAME'] ?></div>
                                <p class="b-offer__text"><?= $arResult['ITEMS'][0]['PREVIEW_TEXT'] ?></p>
                            </div>
                        </div>
                        <div class="col b-offer__img">
                            <div class="b-offer__img__block" style="background-image:url(<?= $arResult['ITEMS'][0]['PREVIEW_PICTURE']['SRC'] ?>)"></div>
                        </div>
                    </div>
                </a>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($arParams['FILTER_NAME'] == 'filterSecond'): ?>
        <section class="is-section page-index__special-offer-sect wow" data-wow-offset="200">
            <div class="wrapper wrapper--sm">
                <a href="<?= $arResult['ITEMS'][0]['DETAIL_PAGE_URL'] ?>" class="is-link">
                    <div class="is-columns b-offer b-offer--type2">
                        <div class="col b-offer__text-cont">
                            <span class="b-label b-label-1"><?= $arResult['ITEMS'][0]['PROPERTIES']['TEXT']['VALUE'] ?></span>
                            <div class="b-offer__text-block">
                                <div class="b-offer__title"><?= $arResult['ITEMS'][0]['NAME'] ?></div>
                                <p class="b-offer__text"><?= $arResult['ITEMS'][0]['PREVIEW_TEXT'] ?></p>
                            </div>
                        </div>
                        <div class="col b-offer__img">
                            <div class="b-offer__img__block" style="background-image:url(<?= $arResult['ITEMS'][0]['PREVIEW_PICTURE']['SRC'] ?>)"></div>
                            <span class="c-label"><?= $arResult['ITEMS'][0]['PROPERTIES']['PRICE']['VALUE'] ?></span>
                        </div>
                    </div>
                </a>
            </div>
        </section>
    <?php endif; ?>

<?php endif; ?>

