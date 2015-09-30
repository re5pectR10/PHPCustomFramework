<?php

namespace Models;


use FW\DB;

class Product {

    public function getPromotion($id) {
        $db=new DB();
        $db->prepare('select max(discount) as disc from promotoins where product_id=? and exp_date>?');
        $db->execute(array($id, date("Y-m-d H:i:s")));
        return $db->fetchRowAssoc()['disc'];
    }

    public function getProduct($id) {

    }
} 