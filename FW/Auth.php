<?php

namespace FW;

class Auth {
    // todo user role check
    public static  function isAuth() {
        return isset($_SESSION['id']) && $_SESSION['id'] != '';
    }

    public static function getUserId() {
        if (self::isAuth()) {
            return $_SESSION['id'];
        }

        return null;
    }

    public static function setAuth($id) {
        $_SESSION['id'] = $id;
    }

    public static function isUserInRole(array $roles = array()) {
        if (!self::isAuth()) {
            return false;
        }

        if (count($roles) == 0) {
            return true;
        }

        $appInstance = App::getInstance();
        $userRole = new DB();
        $userRole = $userRole
            ->prepare('Select ' .
                $appInstance->getConfig()->app['role_table']['role_name_column'] .
                ' From ' .
                $appInstance->getConfig()->app['role_table']['name'] .
                ' as r join ' .  $appInstance->getConfig()->app['user_role_table']['name'] .
                ' as ur on ur.' .
                $appInstance->getConfig()->app['user_role_table']['role_id_column'] .
                '=r.' . $appInstance->getConfig()->app['role_table']['id_column'] .
                ' where ur.' .
                $appInstance->getConfig()->app['user_role_table']['user_id_column'] .
                '=?');
        $userRole->execute(array(self::getUserId()));

        foreach($userRole->fetchAllAssoc() as $role) {
            if (in_array($role[$appInstance->getConfig()->app['role_table']['role_name_column']], $roles)) {
                return true;
            }
        }

        return false;
    }

    public static function validateUser($username, $password) {
        $appInstance = App::getInstance();
        $user = new DB();
        $user = $user
            ->prepare('Select ' .
                $appInstance->getConfig()->app['user_table']['id'] .
                ' From ' .
                $appInstance->getConfig()->app['user_table']['name'] .
                ' where ' .
                $appInstance->getConfig()->app['user_table']['username'] .
                '=? and ' .
                $appInstance->getConfig()->app['user_table']['password'] .
                '=?');
        $user->execute(array($username, password_hash($password, PASSWORD_BCRYPT)));
        $result = $user->fetchAllAssoc();
        if (count($result) > 1) {
            throw new \Exception('there are more than 1 user with this credentials', 500);
        }
        if (count($result) < 1) {
            return false;
        }

        $_SESSION['id'] = $result[0][$appInstance->getConfig()->app['user_table']['id']];
        return true;
    }
} 