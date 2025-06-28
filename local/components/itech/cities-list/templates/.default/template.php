<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="hidden">
    <div class="modal modal-contacts" id="modal-contacts">
        <div class="h2">Выберите город</div>
        <div class="modal__row">
            <? foreach ($arResult['ITEMS'] as $chunk): ?>
                <div class="modal__col">
                    <div class="modal__list">
                        <ul>
                            <? foreach ($chunk as $item): ?>
                                <li>
                                    <a href="?set-city=<?= $item['FIELDS']['NAME'] ?>"><?= $item['FIELDS']['NAME'] ?></a>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>
