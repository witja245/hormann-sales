<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!CModule::IncludeModule("iblock"))
    return;

$res = CIBlockElement::GetByID($_REQUEST["id"]);
$product = [];
$container = '';
if ($ar_res = $res->GetNext()) {
    $product = [
        'NAME' => $ar_res['NAME'],
        'PICTURE' => CFile::GetPath($ar_res["PREVIEW_PICTURE"]),
        'DETAIL_PAGE_URL' => $ar_res['DETAIL_PAGE_URL']
    ];
    $sec_res = CIBlockSection::GetByID($ar_res["IBLOCK_SECTION_ID"]);
    if($ar_sec_res = $sec_res->GetNext())
    {
        $product['SECTION'] = $ar_sec_res['NAME'];
        $product['SECTION_PAGE_URL'] = $ar_sec_res['SECTION_PAGE_URL'];
    }


    $container = "<div class='modal__product__image'>
    <img src='".$product["PICTURE"]."' alt=''>
</div>
<div class='modal__product__content'>
    <div class='title-text'>
        <a href='".$product["DETAIL_PAGE_URL"]."'>".$product["NAME"]."</a>
    </div>
    <div class='text'>
        <a href='".$product["SECTION_PAGE_URL"]."'>".$product['SECTION']."</a>
    </div>
</div>
<input type='hidden' name='form_text_66' value='".$product["NAME"]."'>
";
    header('Content-Type: application/json');
    echo json_encode(['product'=>$container]);
}
