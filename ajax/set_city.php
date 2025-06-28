<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use \Itech\Geo as Geo;

if (!empty($_POST['city'])) {
	Geo::setCity($_POST['city']);
	echo 'success';
}
