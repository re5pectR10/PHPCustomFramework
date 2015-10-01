<?php

namespace Models;


use FW\DB;

class Category extends Model {

    public function getPromotion($id) {
        $this->db->prepare('select max(discount) as discount from promotoins where category_id=? and exp_date>?');
        $this->db->execute(array($id, date("Y-m-d")));
        return $this->db->fetchRowAssoc()['discount'];
    }

    public function getCategory($id) {
        $this->db->prepare('select id,name from categories where id=?');
        $this->db->execute(array($id));
        return $this->db->fetchRowAssoc();
    }

    public function getCategories() {
        $this->db->prepare('select id,name,(select max(discount) from promotoins where category_id=id and exp_date>?) as discount from categories');
        $this->db->execute(array(date("Y-m-d H:i:s")));
        return $this->db->fetchAllAssoc();
    }

    public function delete($id) {
        $this->db->prepare('select count(*) as c from  products where category_id=?');
        $this->db->execute(array($id));
        if ($this->db->fetchRowAssoc()['c'] != 0) {
            return false;
        }
        $this->db->prepare('delete from categories where id=?');
        $this->db->execute(array($id));
        return $this->db->getAffectedRows();
    }

    public function add($name) {
        $this->db->prepare('insert into categories(name) values(?)');
        $this->db->execute(array($name));
        return $this->db->getAffectedRows();
    }

    public function edit($id, $name) {
        $this->db->prepare('update categories set name=? where id=?');
        $this->db->execute(array($name, $id));
        return $this->db->getAffectedRows();
    }
} 