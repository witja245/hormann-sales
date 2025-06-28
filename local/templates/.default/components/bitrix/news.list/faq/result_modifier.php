<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

$temp = array();

foreach ($arResult["ITEMS"] as $item) {
    $temp[$item["IBLOCK_SECTION_ID"]][] = $item;
}

$arResult["SECTIONS"] = $temp;


$arResult["SECTION_LIST"] = array();
$rsSections = CIBlockSection::GetList(["SORT" => "ASC"], ["IBLOCK_ID" => $arParams["IBLOCK_ID"]]);
while ($arSection = $rsSections->Fetch())
{
    $arResult["SECTION_LIST"][] = $arSection;
}


?>
