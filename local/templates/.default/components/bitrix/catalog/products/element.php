<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */
$page = \Itech\PageService::getInstance()->get('/products/');
if ($arResult['VARIABLES']['ELEMENT_CODE']) {
    $req = \CIBlockElement::getList(
        [],
        [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => IBLOCK_ID_CATALOG,
            '=CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
        ]
    );
    if ($res = $req->GetNextElement()) {
        $arCurElement = $res->GetFields();
        $arCurElement['PROPERTIES'] = [
            'ARTICLE' => current($res->GetProperties(false, ['CODE' => 'ARTICLE'])),
            'UF_ARTICLE_PICTURE' => current($res->GetProperties(false, ['CODE' => 'UF_ARTICLE_PICTURE'])),
            'UF_BENEFITS' => current($res->GetProperties(false, ['CODE' => 'UF_BENEFITS'])),
            'UF_LINES' => current($res->GetProperties(false, ['CODE' => 'UF_LINES'])),
            'UF_DOCUMENTS' => current($res->GetProperties(false, ['CODE' => 'UF_DOCUMENTS'])),
            'UF_DESCRIPTION' => current($res->GetProperties(false, ['CODE' => 'UF_DESCRIPTION'])),
        ];
    }
}
if ($arCurElement['PROPERTIES']['ARTICLE']['VALUE']) {
    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/element_article.php");
} else {
    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/element_common.php");

}
?>
