<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="hidden">
    <div class="modal modal-drive" id="help-drive">
        <div class="h2"><?= $arResult['NAME'] ?></div>
        <div class="modal__row">
            <? foreach ($arResult['ITEMS'] as $item): ?>
                <div class="modal__col">
                    <div class="modal__item">
                        <div class="modal__item__image"><img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt=""></div>
                        <div class="title-text"><?= $item['NAME'] ?></div>
                        <div class="modal__item__list">
                            <ul>
                                <? foreach ($item['PROPERTIES']['CHARAC']['VALUE'] as $charac): ?>
                                    <li>• <?= $charac ?></li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>
