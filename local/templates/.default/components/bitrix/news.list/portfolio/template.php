<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="wrapper wrapper--md">
    <div class="is-tabs is-tabs__nav left" data-is="tabs-nav" data-tab-body="tabs-body-b">
        <? foreach ($arResult['ITEMS'] as $section): ?>
            <span class="is-tabs__link is-link" tabindex="0" role="button"><?= $section['NAME'] ?></span>
        <? endforeach; ?>
    </div>
</div>
<div class="is-tabs is-tabs__container tabs-body-b">
    <div class="is-tabs__wrapper">
        <? foreach ($arResult['ITEMS'] as $section): ?>
            <? if ($section['ITEMS']): ?>
                <div class="is-tabs__tab">
                    <div class="port-tiles wow" data-wow-offset="200">
                        <? foreach ($section['ITEMS'] as $item): ?>
                            <a class="port-tile" href="<?= $item['DETAIL_PAGE_URL'] ?>">
                                <div class="pt-img">
                                    <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>">
                                    <?if ($item['PROPERTIES']['LABEL']['VALUE']):?>
                                        <span class="b-label state-white"><?= $item['PROPERTIES']['LABEL']['VALUE'] ?></span>
                                    <?endif;?>
                                </div>
                                <div class="pt-txt">
                                    <p><?= $item['NAME'] ?></p>
                                </div>
                            </a>
                        <? endforeach; ?>
                    </div>
                </div>
            <? endif; ?>
        <? endforeach; ?>
    </div>
</div>