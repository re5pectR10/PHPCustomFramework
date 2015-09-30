<?php

namespace Models;


use FW\DB;

class User {

    public function getPromotion($criteria) {
        $db=new DB();
        $db->prepare('select max(discount) as disc, criteria as disc from promotoins where exp_date>? group by criteria');
        $db->execute(array($criteria, date("Y-m-d H:i:s")));
        return $db->fetchAllAssoc();
    }

    public function register($username, $email, $pass) {
        $db=new DB();
        if ($this->userExist($username)) {
            return array('error' => 'this user already exist');
        }
        $db->prepare('insert into users(username,email,password,cash,created_at) values (?,?,?,?,?)');
        $db->execute(array($username,$email,password_hash($pass, PASSWORD_BCRYPT),500,date("Y-m-d H:i:s")));
        return $db->getAffectedRows();
    }

    public function userExist($username) {
        $db=new DB();
        $db->prepare('select id from users where username=?');
        $db->execute(array($username));
        return $db->getAffectedRows();
    }

    public function getUser($id) {
        $db=new DB();
        $db->prepare('select username,password,email from users where id=?');
        $db->execute(array($id));
        return $db->fetchRowAssoc();
    }

    public function editUser($id, $email, $password, $oldPassword) {
        $db=new DB();
        $user = $this->getUser($id);
        if (!password_verify($oldPassword, $user['password'])) {
            return false;
        }

        if (strlen($password) > 0) {
            $db->prepare('update users set email=?,password=? where id=?');
            $db->execute(array($email, password_hash($password, PASSWORD_BCRYPT), $id));
        } else {
            $db->prepare('update users set email=? where id=?');
            $db->execute(array($email, $id));
        }

        return $db->getAffectedRows();
    }

    public function getUserMoney($id) {
        $db=new DB();
        $db->prepare('select cash from users where id=?');
        $db->execute(array($id));
        return $db->fetchRowAssoc()['cash'];
    }
} 