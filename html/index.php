<?php
/**Created by PhpStorm.
 * User: Oleg
 * Date: 16.10.2018
 * Time: 23:29 */
// FRONT CONTROLLER
// 1. Общие настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Подключение файлов системы
define('ROOT', dirname(__FILE__));

require_once (ROOT.'/components/Router.php');
require_once (ROOT.'/components/Db.php');
require_once (ROOT.'/components/Paginator.php');
require_once (ROOT.'/models/Products.php');
require_once (ROOT.'/models/Config.php');

// 3. Установка соединения с БД

// 4. Устанавливаем глобальное свойство фона сайта
define('BGBODY', Config::getBgImg()); //Определяем фон сайта)
define('BGHEAD', Config::getHBg()); //Определяем фон шапки

// 5. Вызов Router
$router = new Router();
$router->run();

