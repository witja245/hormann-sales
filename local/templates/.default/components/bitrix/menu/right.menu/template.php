<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php foreach ($arResult as $subMenu): ?>
    <nav class="dd-menu__section">
        <ul class="dd-menu__nav">
            <? foreach ($subMenu['ITEMS'] as $item): ?>
                <li class="dd-menu__nav-item">
                    <a href="<?= $item['LINK'] ?>" class="dd-menu__text is-link <?=($item["SELECTED"])? 'active' : ''?>"><?= $item['TEXT'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
<?php endforeach; ?>