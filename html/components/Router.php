<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 16.10.2018
 * Time: 23:59
 */

class Router
{

    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * @returns request string
     */
    private function getURI()
    {
        if (!empty ($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }


    public function run()
    {
        //Перед получением строки запроса задаем дефолтные значения
        //$controllerName и $actionName на случай неправильного урл.
        $controllerName = 'p404';
        $actionName = 'a404';
        $params = null;

        // Получить строку запроса
        $uri = $this->getURI();
        // echo 'uri : '; var_dump($uri); echo '</br>'; //для дебага

        if (!$uri) {
            $controllerName = 'NewsController';
            $actionName = 'actionIndex';
            }
        else {
            // Если есть совпадение, определить какой контроллер
            // и action обрабатывают запрос
            foreach ($this->routes as $uriPattern => $path) {

                // Сравниваем $uriPattern и $uri
                if (preg_match("~$uriPattern~", $uri)) {
                    //Определить какой контроллер и action обрабатывают запрос
                    $segments = explode('/', $path);

                    //Определяем параметры экшина. Параметрами могут быть например:
                    //категория или id новости
                    $params = explode('/', $uri);
                    array_shift($params);
        /* echo 'segments : '; var_dump($segments); echo '</br>'; */ //для дебага

                    $controllerName = array_shift($segments) . 'Controller';
                    $controllerName = ucfirst($controllerName);

                    $actionName = 'action' . ucfirst(array_shift($segments));
                    break;
                }

            }
        }
        // Подключить файл класса-контроллера

        $controllerFile = ROOT.'/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            include_once($controllerFile);
        }

        // Создать объект, вызвать метод (т.е. action)
        $controllerObject = new $controllerName;
        $result = $controllerObject->$actionName($params);
        if ($result != null) {
            return;
        }
    }

}