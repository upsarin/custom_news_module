<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Application;

class custom_news extends CModule {
	public function __construct() {
		$this->MODULE_ID = 'custom.news';
		$this->MODULE_NAME = 'Custom News Module';
		$this->MODULE_DESCRIPTION = 'Модуль по созданию кастомной таблицы новостей и выводу их';
		$this->MODULE_VERSION = '1.0.0';
		$this->MODULE_VERSION_DATE = '2024-10-18';
	}

	public function DoInstall() {
		// Установка базы данных
		$this->InstallDB();

		// Заполнение данных
		$this->FillData();

		// Копирование файлов компонента
		$this->CopyComponent();

		APPLICATION::IncludeAdminFile('Installing Module', __DIR__ . '/step.php');
	}

	public function DoUninstall() {
		// Удаление базы данных
		$this->UninstallDB();

		// Удаление компонента
		$this->RemoveComponent();

		APPLICATION::IncludeAdminFile('Uninstalling Module', __DIR__ . '/step.php');
	}

	private function InstallDB() {
		$connection = Application::getConnection();

		// Создание таблицы
		$connection->query("
			CREATE TABLE IF NOT EXISTS custom_news (
				id INT AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(255) NOT NULL,
				content TEXT,
				preview_image_id INT,
				date DATETIME DEFAULT CURRENT_TIMESTAMP
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
	}

	private function UninstallDB() {
		$connection = Application::getConnection();
		$connection->query("DROP TABLE IF EXISTS custom_news");
	}

	private function FillData() {
		$connection = Application::getConnection();

		// делаем тестовые записи ибо лень заполнять вручную
		for ($i = 1; $i <= 12; $i++) {
			$name = "Название новости № $i";
			$content = "Наполнение новости № $i. <br />
				Ну и стандартная тестовая фигня: <br />
				Lorem ipsum dolor sit amet, <br />
				consectetuer adipiscing elit.  <br />
				Aenean commodo ligula eget dolor.  <br />
				Aenean massa.
			";
			$preview_image_id = "";

			// Используем подготовленный запрос для вставки данных
			$connection->query("INSERT INTO custom_news (name, content, preview_image_id) VALUES (?, ?, ?)", [$name, $content, $preview_image_id]);
		}
	}

	private function CopyComponent() {
		// Папка установки компонента
		$localComponentPath = $_SERVER['DOCUMENT_ROOT'] . '/local/components/custom/news.list/';

		// Создание директории, если она не существует
		if (!is_dir($localComponentPath)) {
			mkdir($localComponentPath, 0755, true);
		}

		// Копирование файлов компонента
		$this->CopyDir($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/custom.news/components/custom/news.list/', $localComponentPath);
	}

	private function RemoveComponent() {
		// Удаление компонента
		$localComponentPath = $_SERVER['DOCUMENT_ROOT'] . '/local/components/custom/news.list/';
		if (is_dir($localComponentPath)) {
			$this->DeleteDir($localComponentPath);
		}
	}

	private function CopyDir($src, $dest) {
		if (is_dir($src)) {
			@mkdir($dest);
			$files = scandir($src);
			foreach ($files as $file) {
				if ($file == '.' || $file == '..') continue;
				if (is_dir($src . $file)) {
					$this->CopyDir($src . $file . '/', $dest . $file . '/');
				} else {
					copy($src . $file, $dest . $file);
				}
			}
		}
	}

	private function DeleteDir($dir) {
		if (is_dir($dir)) {
			$files = scandir($dir);
			foreach ($files as $file) {
				if ($file == '.' || $file == '..') continue;
				if (is_dir($dir . '/' . $file)) {
					$this->DeleteDir($dir . '/' . $file);
				} else {
					unlink($dir . '/' . $file);
				}
			}
			rmdir($dir);
		}
	}
}