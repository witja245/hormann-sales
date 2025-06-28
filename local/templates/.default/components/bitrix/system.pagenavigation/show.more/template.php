<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}
?>

<ul>
    <?

    $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
    $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
    ?>
    <span class="modern-page-title"><?=GetMessage("pages")?></span>
    <?
    if($arResult["bDescPageNumbering"] === true):
        $bFirst = true;
        if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
            if($arResult["bSavePage"]):
                ?>
                <li><a class="pagination__prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a></li>
            <?
            else:
                if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):
                    ?>

                    <li><a class="pagination__prev" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"></a></li>
                <?
                else:
                    ?>
                    <li><a class="pagination__prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a></li>
                <?
                endif;
            endif;

            if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
                $bFirst = false;
                if($arResult["bSavePage"]):
                    ?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">01</a></li>
                <?
                else:
                    ?>
                    <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">01</a></li>
                <?
                endif;
                if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
                    ?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=intval($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2)?>">...</a></li>
                <?
                endif;
            endif;
        endif;
        do
        {
            $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;

            if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                ?>
                <li><a class="is-active"><?= strlen($NavRecordGroupPrint) > 1 ? $NavRecordGroupPrint : "0" . $NavRecordGroupPrint?></a></li>
            <?
            elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
                ?>
                <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?= strlen($NavRecordGroupPrint) > 1 ? $NavRecordGroupPrint : "0" . $NavRecordGroupPrint?></a></li>
            <?
            else:
                ?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?= strlen($NavRecordGroupPrint) > 1 ? $NavRecordGroupPrint : "0" . $NavRecordGroupPrint?></a></li>
            <?
            endif;

            $arResult["nStartPage"]--;
            $bFirst = false;
        } while($arResult["nStartPage"] >= $arResult["nEndPage"]);

        if ($arResult["NavPageNomer"] > 1):
            if ($arResult["nEndPage"] > 1):
                if ($arResult["nEndPage"] > 2):
                    ?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] / 2)?>">...</a></li>
                <?
                endif;
                ?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?= strlen($NavRecordGroupPrint) > 1 ? $NavRecordGroupPrint : "0" . $NavRecordGroupPrint?></a></li>
            <?
            endif;

            ?>
            <li><a class="pagination__next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"></a></li>
        <?
        endif;




    else:
        $bFirst = true;

        if ($arResult["NavPageNomer"] > 1):
            if($arResult["bSavePage"]):
                ?>
                <li><a class="pagination__prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"></a></li>
            <?
            else:
                if ($arResult["NavPageNomer"] > 2):
                    ?>
                    <li><a class="pagination__prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"></a></li>
                <?
                else:
                    ?>
                    <li><a class="pagination__prev" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"></a></li>
                <?
                endif;

            endif;

            if ($arResult["nStartPage"] > 1):
                $bFirst = false;
                if($arResult["bSavePage"]):
                    ?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">01</a></li>
                <?
                else:
                    ?>
                    <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">01</a></li>
                <?
                endif;
                if ($arResult["nStartPage"] > 2):
                    ?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nStartPage"] / 2)?>">...</a></li>
                <?
                endif;
            endif;
        endif;

        do
        {
            if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                ?>
                <li><a class="is-active"><?= strlen($arResult["nStartPage"]) > 1 ? $arResult["nStartPage"] : "0" . $arResult["nStartPage"]?></a></li>
            <?
            elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                ?>
                <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?= strlen($arResult["nStartPage"]) > 1 ? $arResult["nStartPage"] : "0" . $arResult["nStartPage"]?></a></li>
            <?
            else:
                ?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?= strlen($arResult["nStartPage"]) > 1 ? $arResult["nStartPage"] : "0" . $arResult["nStartPage"]?></a></li>
            <?
            endif;
            $arResult["nStartPage"]++;
            $bFirst = false;
        } while($arResult["nStartPage"] <= $arResult["nEndPage"]);

        if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
            if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
                if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
                    ?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>">...</a></li>
                <?
                endif;
                ?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?= strlen($arResult["NavPageCount"]) > 1 ? $arResult["NavPageCount"] : "0" . $arResult["NavPageCount"]?></a></li>
            <?
            endif;
            ?>
            <li><a class="pagination__next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a></li>
        <?
        endif;
    endif;
    ?>
</ul>

<? if ($arResult["NavPageCount"] > 1): ?>

    <? if ($arResult["NavPageNomer"] + 1 <= $arResult["nEndPage"]): ?>
        <?
        $plus = $arResult["NavPageNomer"] + 1;
        $url = $arResult["sUrlPathParams"] . "PAGEN_".$arResult["NavNum"]."=".$plus; ?>

        <div class="pagination__more">
            <a style="cursor: pointer" class="load-more" data-url="<?= $url ?>">Показать еще</a>
        </div>

    <? endif ?>

<? endif ?>


<? /*
<ul>

    <? if ($arResult["NavPageNomer"] > 1): ?>
        <li><a class="pagination__prev" href="<?=$arResult["sUrlPathParams"] ?><?=$navQueryString ?>PAGEN_<?=$arResult["NavNum"] ?>=<?=$arResult["NavPageNomer"]-1?>"></a></li>
    <? else: ?>
        <li class="hidden"><a class="pagination__prev"></a></li>
    <? endif; ?>


    <?php while ($arResult["nStartPage"] <= $arResult["nEndPage"]) { ?>
        <?php if ($arResult["nStartPage"] == $arResult["NavPageNomer"]) { ?>
            <li><a class="is-active"><?= strlen($arResult["nStartPage"]) > 1 ? $arResult["nStartPage"] : "0" . $arResult["nStartPage"]?></a></li>
        <?php } else { ?>
            <li><a href="<?=$arResult["sUrlPathParams"] ?><?=$navQueryString ?>PAGEN_<?=$arResult["NavNum"] ?>=<?=$arResult["nStartPage"] ?>"><?= strlen($arResult["nStartPage"]) > 1 ? $arResult["nStartPage"] : "0" . $arResult["nStartPage"]?></a></li>
        <?php } ?>
        <?php $arResult["nStartPage"]++ ?>
    <?php } ?>


    <? if ($arResult["NavPageNomer"] < $arResult["nEndPage"]): ?>
        <li><a class="pagination__next" href="<?=$arResult["sUrlPathParams"] ?><?=$navQueryString ?>PAGEN_<?=$arResult["NavNum"] ?>=<?=$arResult["NavPageNomer"]+1?>"></a></li>
    <? else: ?>
        <li class="hidden"><a class="pagination__next" href="#"></a></li>
    <? endif; ?>

</ul>
*/ ?>
