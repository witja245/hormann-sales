<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<p class="date"><?=$arResult['PROPERTIES']['DATE']['VALUE']?></p>
<h1 class="h2"><?=$arResult['~NAME']?></h1>
<div class="news-detail__img" style="background-image:url(<?=$arResult['PREVIEW_PICTURE']['SRC']?>)"></div>
<p><?=$arResult['PREVIEW_TEXT']?></p>
<h4><?=$arResult['PROPERTIES']['SUB_TITLE']['VALUE']?></h4>
<p><?=$arResult['DETAIL_TEXT']?></p>