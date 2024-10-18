<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;

class CCustomNewsComponent extends CBitrixComponent {

	public function onPrepareComponentParams($arParams) {
		return $arParams;
	}

	private function getNews($filter) {
		// Получаем соединение с базой данных
		$connection = Application::getConnection();
		$query = "SELECT * FROM custom_news ORDER BY date DESC";

		// Выполняем запрос к базе данных
		$result = $connection->query($query);

		$arResult = [];  // Создаем локальную переменную для результата
		while ($row = $result->fetch()) {
			$news[] = $row;  // Добавляем каждую запись в массив
		}

		return $news;  // Возвращаем массив новостей
	}

	public function executeComponent() {
		if($this->arParams['CACHE_TYPE'] != "N")
		{
			// TODO дописать проверку по фильтрам
			// Проверяем кэш
			$cache = Bitrix\Main\Data\Cache::createInstance();
			$cacheId = 'custom_news_list';
			$cacheDir = '/custom/news';

			if($cache->initCache($this->arParams['CACHE_TIME'], $cacheId, $cacheDir))
			{
				// Получаем данные из кеша
				$this->arResult = $cache->getVars();
			}
			elseif($cache->startDataCache())
			{
				// Получаем новости из базы данных
				$this->arResult['ITEMS'] = $this->getNews($this->arParams['filter']);
				// Сохраняем результаты в кэш
				$cache->endDataCache($this->arResult);
			}
		} else {
			$this->arResult['ITEMS'] = $this->getNews($this->arParams['filter']);
		}

		$this->includeComponentTemplate();
	}
}