<?php

namespace FW;

class Route {

    private static $routes = array();
    private static $prefix = '';

    public static function GET($url, $details = array()){
        array_push(self::$routes, array('url' => self::$prefix . $url, 'details' => $details, 'method' => 'GET'));
    }

    public static function POST($url, $details = array()){
        array_push(self::$routes, array('url' => self::$prefix . $url, 'details' => $details, 'method' => 'POST'));
    }

    public static function PUT($url, $details = array()){
        array_push(self::$routes, array('url' => self::$prefix . $url, 'details' => $details, 'method' => 'PUT'));
    }

    public static function DELETE($url, $details = array()){
        array_push(self::$routes, array('url' => self::$prefix . $url, 'details' => $details, 'method' => 'DELETE'));
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
}