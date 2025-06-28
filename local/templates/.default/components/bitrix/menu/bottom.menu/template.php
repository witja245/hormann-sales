<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="is-footer__center">
    <?php foreach ($arResult as $subMenu): ?>
        <ul class="is-footer__nav">
            <? foreach ($subMenu as $item): ?>
                <li class="is-footer__nav-item">
                    <a href="<?=$item['LINK']?>" class="is-link is-footer__nav-text"><?=$item['TEXT']?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</div>