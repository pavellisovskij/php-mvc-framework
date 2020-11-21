<?php

namespace app\core;

class Router
{
    static private $params      = [];
    static private $extraParams = [];

    public static function redirect($url)
    {
        header('location: ' . $url);
        exit();
    }

    public static function run()
    {
        $match = self::match();

        if ($match !== false) {
            $path = 'app\controllers\\' . ucfirst(self::$params['controller']) . 'Controller';

            if (class_exists($path)) {
                $controller = new $path(self::$params, self::$extraParams);
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

    private static function match()
    {
        $url    = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $routes = require 'app/config/routes.php';

        $numberOfUrlParts = count($url);
        $found            = false;

        foreach ($routes as $route => $params) {
            $route = explode('/', trim($route, '/'));
            $extraParams = [];

            if (count($route) === $numberOfUrlParts) {
                $conformity = false;

                for ($i = 0; $i < $numberOfUrlParts; $i++) {
                    $result = self::isCoincidence($url[$i], $route[$i]);

                    if ($result === true) $conformity = true;
                    elseif ($result === false) {
                        $conformity = false;
                        break;
                    }
                    else {
                        $conformity    = true;
                        $extraParams[] = $result;
                    }
                }
            }
            else continue;

            if ($conformity === true) {
                self::$params       = $params;
                self::$extraParams  = $extraParams;
                $found = true;
                break;
            }
            else {
                $found = false;
                continue;
            }
        }

        return $found;
    }

    private static function isCoincidence(string $urlPart, string $routePart) {
        if ($urlPart === $routePart) return true;
        elseif (self::isParam($routePart) === true) {
            $result = self::isCoincidenceWithParam($urlPart, $routePart);

            if ($result !== false) return $result;
            else return false;
        }
        else return false;
    }

    private static function isCoincidenceWithParam(string $urlPart, string $routePart) {
        $routePart = explode('_', trim($routePart, '{}'));

        try {
            if ($routePart[0] === 'int') $pattern = '#^\d+$#';
            elseif ($routePart[0] === 'str') $pattern = '#^[а-яА-ЯёЁa-zA-Z0-9\-_\.@]+$#';
            else throw new \Exception('Ошибка в наименовании параметров. Параметр должен иметь приставку "int_" или "str_".');
        } catch (\Exception $e) {
            View::error_page_with_message($e->getMessage());
        }

        if (preg_match($pattern, $urlPart) === 1) return $urlPart;
        else return false;
    }

    private static function isParam(string $str) {
        if (
            substr($str, 0, 1) === '{' &&
            substr($str, strlen($str) - 1, 1) === '}'
        ) return true;
        else return false;
    }
}