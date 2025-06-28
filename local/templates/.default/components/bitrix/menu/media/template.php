<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="links-tabs wow" data-wow-offset="200">
    <div class="links-tabs__row">
        <?php foreach ($arResult as $item): ?>
            <a class="subtext<?=$item['SELECTED']?' is-active':''?>" href="<?=$item['LINK']?>"><?=$item['TEXT']?></a>
        <?php endforeach; ?>
    </div>
</div>