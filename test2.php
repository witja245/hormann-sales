<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test2");
use Classes\Menu;
$result = Menu::echo();
p($result);
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>