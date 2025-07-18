<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<? if ($arResult['~UF_TOP_BLOCK']): ?>
    <div class="topic margin-120">
        <div class="topic__item wow" data-wow-offset="200"
             style="background-image:url(<?= CFile::GetPAth($arResult['UF_TOP_BLOCK_IMAGE']) ?>)">
            <div class="topic__info">
                <?= $arResult['~UF_TOP_BLOCK'] ?>
            </div>
        </div>
    </div>
<? endif; ?>