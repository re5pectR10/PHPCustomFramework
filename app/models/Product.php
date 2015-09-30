<?php

namespace Models;


use FW\DB;

class Product extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts() {
        $this->db->prepare('select p.id,name,quantity,price,description,(select count(*) from comments where product_id=p.id) as comments_count from products as p where quantity>=0 and is_deleted=false');
        $this->db->execute();
        return $this->db->fetchAllAssoc();
    }

    public function getPromotion($id) {
        $this->db->prepare('select max(discount) as disc from promotoins where product_id=? and exp_date>?');
        $this->db->execute(array($id, date("Y-m-d H:i:s")));
        return $this->db->fetchRowAssoc()['disc'];
    }

    public function getProduct($id) {
        $this->db->prepare('select id,name,price,category_id from products where is_deleted=false and quantity>0 and id=?');
        $this->db->execute(array($id));
        return $this->db->fetchRowAssoc();
    }

    public function changeQuantity($id,$quantity) {
        $this->db->prepare('update products set quantity=quantity-? where is_deleted=false and quantity>=? and id=?');
        $this->db->execute(array($quantity, $quantity, $id));
        return $this->db->getAffectedRows();
    }

    public function getProductWithCommentsCountForCategory($id) {
        $this->db->prepare('select p.id,p.name,p.quantity,p.price,p.description,(select count(*) from comments where product_id=p.id) as comments_count from products as p where quantity>=0 and  p.is_deleted=false and p.category_id=?');
        $this->db->execute(array($id));
        return $this->db->fetchAllAssoc();
    }
} 