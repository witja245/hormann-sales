<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Entity;

$files = [];
foreach ($arResult['ITEMS'] as $item){
    $files[] = $item['PROPERTIES']['FILE']['VALUE'];
}
$filesDB = [];
$res = \Bitrix\Main\FileTable::GetList([
    'filter' => ['ID' => $files],
    'select' => ['ID','FILE_SIZE','SUBDIR','FILE_NAME','SRC'],
    'runtime' => [
        new Entity\ExpressionField('SRC',
            'CONCAT("/upload/", %s, "/", %s)', ['SUBDIR', 'FILE_NAME']
        )
    ]
]);
while ($filesRes = $res->fetch()){
    $filesDB[$filesRes['ID']]=$filesRes;
}

foreach ($filesDB as &$item){
    $item['EXTENSION'] = pathinfo($item['SRC'])['extension'];
    $item['FILE_SIZE'] = CFile::FormatSize($item['FILE_SIZE']);
}

foreach ($arResult['ITEMS'] as &$item){
    $item['PROPERTIES']['FILE'] = $filesDB[$item['PROPERTIES']['FILE']['VALUE']];
}