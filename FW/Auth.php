<?php

namespace FW;

class Auth {
    // todo user role check
    public static  function isAuth() {
        return isset($_SESSION['id']) && $_SESSION['id'] != '';
    }

    public static function getUserId() {
        return $_SESSION['id'];
    }

    public static function isUserInRole(array $roles = array()) {
        if (!self::isAuth()) {
            return false;
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

            return false;
        }
    }
} 