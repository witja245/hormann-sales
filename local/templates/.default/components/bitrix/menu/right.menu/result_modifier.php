<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
$result = [];
foreach ($arResult as $item){
    switch ($item["PARAMS"]["LINE"]){
        case 1:
            $result[1]["ITEMS"][] = $item;
            break;
        case 2:
            $result[2]["ITEMS"][] = $item;
            break;
        case 3:
            $result[3]["ITEMS"][] = $item;
            break;
    }
}
$arResult = $result;