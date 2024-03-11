<?php
namespace Freeway;

define(__NAMESPACE__ . '\METHOD', $_SERVER['REQUEST_METHOD']);
define(__NAMESPACE__ . '\PATH', trim($_SERVER['PATH_INFO'] ?? '', '/'));
define(__NAMESPACE__ . '\START', $_SERVER['REQUEST_TIME_FLOAT']);

enum Freeway {

	/**
	 * Launch the application.
	 *
	 * @return void
	 */
	public static function hit() {
		ini_set('display_errors', $_ENV['APP_DEV'] ?? false);
	}

	/**
	 * Transfer to the router.
	 *
	 * @return void
	 */
	public static function transfer() {
		$router = str_starts_with(REQUEST_PATH, 'api')
			? 'Api' : 'Gui';

		require_once PROJECT_DIR . "/App/Router/$router.php";

		Router::deliver();
	}
}
