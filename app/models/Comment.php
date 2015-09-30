<?php

namespace Models;


class Comment extends Model {

    public function getCommentsByProduct($id) {
        $this->db->prepare('select c.id,c.content,c.posted_on,c.user_id,u.username from comments as c join users as u on u.id=c.user_id where c.product_id=?');
        $this->db->execute(array($id));
        return $this->db->fetchAllAssoc();
    }
} 