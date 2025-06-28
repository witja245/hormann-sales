<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 * @var array $arParams
 * @global CMain $APPLICATION
 * @var string $templateName
 * @var string $componentPath
 */

CJSCore::init(['ajax']);
\Bitrix\Main\UI\Extension::load("ui");
\Bitrix\Main\UI\Extension::load("ui.hint");
\Bitrix\Main\UI\Extension::load('asteq.calculator');
//\Bitrix\Main\UI\Extension::load('ui.bootstrap4');
?>

<script type="text/javascript">
    BX.ready(function() {
        setTimeout(function () {
            BX.UI.Hint.init(BX('calculator-container'));
        }, 5000);
    })
</script>