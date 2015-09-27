<?php

namespace FW;


class Redirect {

    public static function to($uri) {
        header('Location: ' . Common::getBaseURL() . '/' . $uri);
        exit;
    }

    public static function toRoute($name) {
        $route = Route::getRouters()[$name]['url'];
        self::to($route);
    }
} 