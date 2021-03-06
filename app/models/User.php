<?php

namespace Models;

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
        $this->db->prepare('select u.id,u.username,r.role,u.is_banned from users as u left join user_roles as ur on u.id=ur.user_id left join roles as r on r.id=ur.role_id');
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

    public function banUser($id) {
        $this->db->prepare('update users set is_banned=true where id=?');
        $this->db->execute(array($id));
        return $this->db->getAffectedRows();
    }

    public function isBanned($id) {
        $this->db->prepare('select is_banned from users where id=?');
        $this->db->execute(array($id));
        return $this->db->fetchRowAssoc();
    }

    public function addProduct($user_id, $product_id, $quantity, $price) {
        $this->db->prepare('insert into user_products(user_id,product_id,quantity,bought_price,bought_on) values(?,?,?,?,?)');
        $this->db->execute(array($user_id, $product_id, $quantity, $price, date("Y-m-d")));
        return $this->db->getAffectedRows();
    }

//    public function productExist($user_id, $product_id) {
//        $this->db->prepare('select id from user_products where user_id=? and product_id=?');
//        $this->db->execute(array($user_id, $product_id));
//        return $this->db->getAffectedRows();
//    }
//
//    public function decreaseProductQuantity($user_id, $product_id, $quantity, $user_product_id) {
//        $this->db->prepare('update user_products set quantity=quantity-? where user_id=? and product_id=? and quantity>=? and id=?');
//        $this->db->execute(array($quantity, $user_id, $product_id, $quantity, $user_product_id));
//        return $this->db->getAffectedRows();
//    }

    public function getProducts($user_id) {
        $this->db->prepare('select up.id as user_product_id,p.id,p.name,up.quantity,up.bought_price,up.bought_on,p.price as current_price from user_products as up join products as p on p.id=up.product_id where up.user_id=?');
        $this->db->execute(array($user_id));
        return $this->db->fetchAllAssoc();
    }

    public function getProduct($user_id, $product_id, $upid) {
        $this->db->prepare('select p.id,p.name,up.quantity,up.bought_price,up.bought_on,p.price as current_price from user_products as up join products as p on p.id=up.product_id where up.user_id=? and p.id=? and up.id=?');
        $this->db->execute(array($user_id, $product_id, $upid));
        return $this->db->fetchRowAssoc();
    }

    public function changeProductQuantity($user_id, $product_id, $quantity, $user_product_id) {
        $this->db->prepare('update user_products set quantity=quantity-? where user_id=? and product_id=? and quantity>=? and id=?');
        $this->db->execute(array($quantity, $user_id, $product_id, $quantity, $user_product_id));
        return $this->db->getAffectedRows();
    }

    public function deleteProduct($user_id, $product_id, $user_product_id) {
        $this->db->prepare('delete from user_products where user_id=? and product_id=? and quantity<1 and id=?');
        $this->db->execute(array($user_id, $product_id, $user_product_id));
        return $this->db->getAffectedRows();
    }

    public function addCash($id, $money) {
        $this->db->prepare('update users set cash=cash+? where id=?');
        $this->db->execute(array($money, $id));
        return $this->db->getAffectedRows();
    }
}