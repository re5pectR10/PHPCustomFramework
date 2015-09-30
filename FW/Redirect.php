<?php

namespace FW;


class Redirect {

    public static function to($uri) {
        header('Location: ' . Common::getBaseURL() . $uri);
        exit;
    }

    public static function toRoute($name) {
        if (!isset(Route::getRouters()[$name])) {
            throw new \Exception('Not found route with that name', 500);
        }
        $route = Route::getRouters()[$name]['url'];
        self::to($route);
    }

    public static function back() {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
} 