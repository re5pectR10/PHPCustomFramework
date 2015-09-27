<?php

namespace FW;

class Auth {
    // todo user role check
    public static  function isAuth() {
        return isset($_SESSION['id']) && $_SESSION['id'] != '';
    }
} 