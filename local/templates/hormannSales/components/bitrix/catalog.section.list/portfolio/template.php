<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arParams['ELEMENT_CODE']) {
    $res = CIBlockElement::GetList([], ['CODE' => $arParams['ELEMENT_CODE']]);
    $element = $res->GetNext();
    $sections = CIBlockElement::GetElementGroups($element['ID'], true);
    while ($section = $sections->GetNext()): ?>
        <span class="is-tabs__link is-link" tabindex="0" role="button"><?= $section['~NAME'] ?></span>
    <?php endwhile;
} else { ?>
    <? foreach ($arResult['SECTIONS'] as $item): ?>
        <span class="is-tabs__link is-link" tabindex="0" role="button"><?= $item['~NAME'] ?></span>
    <? endforeach; ?>
<?php } ?>