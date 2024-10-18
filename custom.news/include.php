<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
// TODO проверять установлен ли уже модуль более изящно
if (!\Bitrix\Main\Loader::includeModule('custom.news')) {
	// Если модуль не установлен, можно сделать что-то, например, вывести ошибку
	die("Модуль 'Custom News' не установлен.");
}
// дополнительные классы или функции, которые будут использоваться в модуле