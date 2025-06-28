<? require( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php' );
use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;

Loader::includeModule("highloadblock");

$hlblock = HL\HighloadBlockTable::getById(HL_ALL_CITIES)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();

$filt = array(
    "select" => array("*"),
    "order" => array(),
);
if ($_REQUEST['term'])
    $filt["filter"] = ['UF_NAME' => $_REQUEST['term'].'%'];

$rsData = $entity_data_class::getList($filt);

$result = false;

while ($data = $rsData->fetch()) {
    $result['results'][] = [
        'id' => $data['ID'],
        'text' => $data['UF_NAME'],
    ];
}
header('Content-Type: application/json');
echo json_encode($result);