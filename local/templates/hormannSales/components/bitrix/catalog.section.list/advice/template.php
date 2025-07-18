<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arParams['ELEMENT_CODE']) {
    $res = CIBlockElement::GetList([],['CODE' => $arParams['ELEMENT_CODE']]);
    $element = $res->GetNext();
    $sections = CIBlockElement::GetElementGroups($element['ID'], true);
    while ($section = $sections->GetNext()): ?>
        <a class="e-label" href="<?=$section['SECTION_PAGE_URL']?>"><?=$section['~NAME']?></a>
    <?php endwhile;
} else {?>
    <? foreach ($arResult['SECTIONS'] as $item): ?>
        <a class="e-label" href="<?=$item['SECTION_PAGE_URL']?>"><?=$item['~NAME']?></a>
    <? endforeach; ?>
<?php }?>
