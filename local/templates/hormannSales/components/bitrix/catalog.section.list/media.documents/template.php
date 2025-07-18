<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<ul>
<?php if ($arParams['ELEMENT_CODE']) {
    $res = CIBlockElement::GetList([],['CODE' => $arParams['ELEMENT_CODE']]);
    $element = $res->GetNext();
    $sections = CIBlockElement::GetElementGroups($element['ID'], true);
    while ($section = $sections->GetNext()): ?>
        <li><a class="js-goto" href="#<?=$section['CODE']?>" data-target="#<?=$section['CODE']?>"><?=$section['~NAME']?></a></li>
    <?php endwhile;
} else {?>
    <? foreach ($arResult['SECTIONS'] as $item): ?>
        <li><a class="js-goto" href="#<?=$item['CODE']?>" data-target="#<?=$item['CODE']?>"><?=$item['~NAME']?></a></li>
    <? endforeach; ?>
<?php }?>
</ul>

