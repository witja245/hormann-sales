<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<?php if ($arResult['ITEMS']): ?>
    <h2 class="wow" data-wow-offset="200">Преимущества продукции Hoermann</h2>
    <div class="items items_bg wow" data-wow-offset="200">
        <div class="items__row items__row_width-25">
            <? foreach ($arResult['ITEMS'] as $item): ?>
                <div class="items__col">
                    <div class="items__item"><?= $item['NAME'] ?></div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
<?php endif; ?>
