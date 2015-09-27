<?php

namespace FW;

class Route {

    private static $routes = array();
    private static $prefix = '';
    private static $index = 0;

    public static function GET($url, $details = array()){
        self::addRoute('GET', $url, $details);
        //array_push(self::$routes, array('url' => self::$prefix . $url, 'details' => $details, 'method' => 'GET'));
    }

    public static function POST($url, $details = array()){
        self::addRoute('POST', $url, $details);
    }

    public static function PUT($url, $details = array()){
        self::addRoute('PUT', $url, $details);
    }

    public static function DELETE($url, $details = array()){
        self::addRoute('DELETE', $url, $details);
    }

    public static function Group($prefix, $details = array(), $func){
        if ($func instanceof \Closure) {
            self::$prefix .= $prefix;
            call_user_func($func);
            self::$prefix = substr(self::$prefix, 0, strlen(self::$prefix) - strlen($prefix));
        } else {
            throw new \Exception('Invalid routes function', 500);
        }
    }

    public static function getRouters(){
        return self::$routes;
    }

    private static function addRoute($type, $url, $details = array()) {
        if (isset($details['name'])) {
            if ($details['name'] == '') {
                throw new \Exception('The route name can not be empty string', 500);
            }
            if (array_key_exists($details['name'], self::$routes)) {
                throw new \Exception('There are duplicate route names', 500);
            }

            $key = $details['name'];
        } else {
            $key = self::$index;
            self::$index++;
        }

        self::$routes[$key] = array('url' => self::$prefix . $url, 'details' => $details, 'method' => $type);
    }
}