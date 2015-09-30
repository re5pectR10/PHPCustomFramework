<?php

namespace FW;

class Session{
    public function __construct($name, $lifetime = 3600, $path = null, $domain = null, $secure = false) {
        if(strlen($name)<1){
            $name='_sess';
        }
        session_name($name);
        session_set_cookie_params($lifetime, $path, $domain, $secure, true);
        session_start();
    }

    public function __get($name) {
        return $_SESSION[$name];
    }

    public function __set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public static function getError() {
        if (!isset($_SESSION['error'])) {
            $_SESSION['error'] = '';
        }
        $error = $_SESSION['error'];
        $_SESSION['error'] = '';
        return $error;
    }

    public static function hasError() {
        if (isset($_SESSION['error'])) {
            if (is_array($_SESSION['error'])) {
                return !empty($_SESSION['error']);
            }

            return strlen($_SESSION['error']) > 0;
        }

        return false;
    }

    public static function hasMessage() {
        if (isset($_SESSION['message'])) {
            if (is_array($_SESSION['message'])) {
                return !empty($_SESSION['message']);
            }

            return strlen($_SESSION['message']) > 0;
        }

        return false;
    }

    public static function setError($error) {
        $_SESSION['error'] = $error;
    }

    public static function getMessage() {
        if (!isset($_SESSION['message'])) {
            $_SESSION['message'] = '';
        }
        $message = $_SESSION['message'];
        $_SESSION['message'] = '';
        return $message;
    }

    public static function setMessage($message) {
        $_SESSION['message'] = $message;
    }

    public static function setOldInput(array $input) {
        $_SESSION['old_input'] = $input;
    }

    public static function oldInput() {
        if (!isset($_SESSION['old_input'])) {
            $_SESSION['old_input'] = array();
        }

        return $_SESSION['old_input'];
    }

    public function getSession() {
        return $_SESSION;
    }

    public function containKey($key) {
        return isset($_SESSION[$key]);
    }

    public function destroySession() {
        session_destroy();
    }

    public function getSessionId() {
        return session_id();
    }

    public function saveSession() {
        session_write_close();
    }
}



