<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php
//$page = \Itech\PageService::getInstance()->get("magazine");
$page = $arParams['PAGE'];
?>

<div class="magazine wow" data-wow-offset="200">
    <div class="magazine__content">
        <div class="title-text"><?= $page->UF_TITLE ?></div>
        <div class="text"><?= $page->UF_DESC ?></div>
        <a class="btn" href="<?= $page->UF_LINK ?>"><span><?= $page->UF_TEXT ?></span></a>
    </div>
    <div class="magazine__image"><img src="<?= CFile::getPath($page->UF_IMG) ?>" alt=""></div>
</div>
