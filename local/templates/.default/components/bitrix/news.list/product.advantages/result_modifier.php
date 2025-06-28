<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

foreach ($arResult['ITEMS'] as &$item){
    $arFileTmp = CFile::ResizeImageGet(
        $item['PREVIEW_PICTURE']['ID'],
        array("width" => 96, "height" => 80),
        BX_RESIZE_IMAGE_EXACT,
        true,
        false
    );
    $item['PREVIEW_PICTURE'] = $arFileTmp['src'];
}
