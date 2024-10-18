<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новости");
?>

<?$APPLICATION->IncludeComponent(
	"custom:news.list", "custom",
	[
		"SORT_BY" => "date",
		"SORT_ORDER" => "DESC",
		"CACHE_TYPE" => "Y",
		"CACHE_TIME" => "36000000",
	],
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>