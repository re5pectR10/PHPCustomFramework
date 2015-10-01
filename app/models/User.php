<?php

namespace Models;


use FW\DB;

class User extends Model {

    public function getPromotion($criteria) {
        $this->db->prepare('select max(discount) as disc, criteria as disc from promotoins where exp_date>? group by criteria');
        $this->db->execute(array($criteria, date("Y-m-d H:i:s")));
        return $this->db->fetchAllAssoc();
    }

    public function register($username, $email, $pass) {
        if ($this->userExist($username)) {
            return 'this user already exist';
        }
        $this->db->prepare('insert into users(username,email,password,cash,created_at) values (?,?,?,?,?)');
        $this->db->execute(array($username,$email,password_hash($pass, PASSWORD_BCRYPT),500,date("Y-m-d H:i:s")));
        return $this->db->getAffectedRows();
    }

    public function userExist($username) {
        $this->db->prepare('select id from users where username=?');
        $this->db->execute(array($username));
        return $this->db->getAffectedRows();
    }

    public function getUser($id) {
        $this->db->prepare('select username,password,email from users where id=?');
        $this->db->execute(array($id));
        return $this->db->fetchRowAssoc();
    }

    public function editUser($id, $email, $password, $oldPassword) {
        $user = $this->getUser($id);
        if (!password_verify($oldPassword, $user['password'])) {
            return false;
        }

        if (strlen($password) > 0) {
            $this->db->prepare('update users set email=?,password=? where id=?');
            $this->db->execute(array($email, password_hash($password, PASSWORD_BCRYPT), $id));
        } else {
            $this->db->prepare('update users set email=? where id=?');
            $this->db->execute(array($email, $id));
        }

        return $this->db->getAffectedRows();
    }

    public function getUserMoney($id) {
        $this->db->prepare('select cash from users where id=?');
        $this->db->execute(array($id));
        return $this->db->fetchRowAssoc()['cash'];
    }

    public function changeUserCash($id, $totalSum) {
        $this->db->prepare('update users set cash=cash-? where cash>=? and id=?');
        $this->db->execute(array($totalSum, $totalSum, $id));
        return $this->db->getAffectedRows();
    }

    public function getUsersWithRoles() {
        $this->db->prepare('select u.id,u.username,r.role from users as u left join user_roles as ur on u.id=ur.user_id left join roles as r on r.id=ur.role_id');
        $this->db->execute();
        return $this->db->fetchAllAssoc();
    }

    public function setRole($userId, $roleName) {
        $this->db->prepare('select id from roles where role=?');
        $this->db->execute(array($roleName));
        $roleId = $this->db->fetchRowAssoc()['id'];
        $this->deleteUserRole($userId);
        $this->db->prepare('insert into user_roles(user_id,role_id) values (?,?)');
        $this->db->execute(array($userId, $roleId));
        return $this->db->getAffectedRows();
    }

    public function deleteUserRole($userId) {
        $this->db->prepare('delete from user_roles where user_id=?');
        $this->db->execute(array($userId));
        return $this->db->getAffectedRows();
    }
} 