<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
/**
 * @var array $arResult
 */
?>
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
if (!empty($arResult)) {
    global $APPLICATION;
    $itemSize = count($arResult);
    $strReturn = '<ul>';
    for ($index = 0; $index < $itemSize; $index++) {
        $title = htmlspecialcharsex(strip_tags($arResult[$index]["TITLE"]));
        if ($index != $itemSize - 1) {
            $strReturn .= '<li>';
            $strReturn .= '<a href="' . $arResult[$index]['LINK'] . '">' . $title . '</a>';
            $strReturn .= '</li>';
        } else {
            $strReturn .= '<li>';
            $strReturn .= $title;
            $strReturn .= '</li>';
        }
    }
    $strReturn .= '</ul>';
    $arItems = [];
    for ($index = 0; $index < $itemSize; $index++) {
        $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
        $arItems[] = [
            '@type' => 'ListItem',
            'position' => $index,
            'item' => [
                '@id' => $arResult[$index]["LINK"],
                'name' => $title
            ]
        ];
    }
    $microData =
        '<script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": ' . \Bitrix\Main\Web\Json::encode($arItems) . '
        }
    </script>';
    return $strReturn . $microData;
}
?>