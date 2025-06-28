<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
if(!is_array($arResult['TAGS']))
    $arResult['TAGS'] = [];
$tagsChunk = array_chunk($arResult['TAGS'], 5);
?>
<?php if ($arResult['TAGS']):?>
<div class="catalogue__type">
    <?php foreach ($tagsChunk as $chunk): ?>
        <div class="catalogue__type__row">
            <? foreach ($chunk as $item): ?>
                <a href="<?= $item['URL'] ?>" class="btn btn_white" type="button"><?= $item['NAME'] ?></a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php endif;?>
