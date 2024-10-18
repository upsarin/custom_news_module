<?if (!check_bitrix_sessid()) return;

use Bitrix\Main\ModuleManager;

if ($_REQUEST['action'] == 'install')
	ModuleManager::registerModule('custom.news');
elseif ($_REQUEST['action'] == 'uninstall')
	ModuleManager::unregisterModule('custom.news');

// Сообщение о завершении
echo "Module installed successfully!";