<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<h1 class="h2"><?=$arResult['~NAME']?></h1>
<div class="news-detail__img" style="background-image:url(<?=$arResult['DETAIL_PICTURE']['SRC']?:$arResult['PREVIEW_PICTURE']['SRC']?>)"></div>
<?php if ($arResult['PREVIEW_TEXT']):?>
<p><?=$arResult['PREVIEW_TEXT']?></p>
<?php endif;?>
<?php if ($arResult['PROPERTIES']['SUB_TITLE']['VALUE']):?>
<h4><?=$arResult['PROPERTIES']['SUB_TITLE']['VALUE']?></h4>
<?php endif;?>
<?php if ($arResult['DETAIL_TEXT']):?>
<p><?=$arResult['DETAIL_TEXT']?></p>
<?php endif;?>