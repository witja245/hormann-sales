<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<?php if ($arResult['ITEMS']): ?>
    <h2 class="wow" data-wow-offset="200"><a href="#">Галерея, список</a></h2>
    <div class="items wow" data-wow-offset="200">
        <div class="items__row">
            <?php foreach ($arResult['ITEMS'] as $item): ?>
                <div class="items__col">
                    <div class="items__item">
                        <div class="items__item__image"><img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt=""></div>
                        <div class="title-text"><a href="#"><?= $item['NAME'] ?></a></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>