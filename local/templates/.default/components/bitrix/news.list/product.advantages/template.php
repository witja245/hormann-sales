<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<?php if ($arResult['ITEMS']): ?>
    <?php if ($arParams['TITLE']):?>
    <h2 class="wow" data-wow-offset="200">Преимущества Hoermann</h2>
    <?php endif;?>
    <div class="items wow" data-wow-offset="200">
        <div class="items__row">
            <? foreach ($arResult['ITEMS'] as $item): ?>
                <div class="items__col">
                    <div class="items__item">
                        <div class="items__item__row">
                            <div class="items__item__image"><img src="<?=$item['PREVIEW_PICTURE']?>" alt=""></div>
                            <div class="subtext"><?=$item['NAME']?></div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
<?php endif; ?>