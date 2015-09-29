<?php

namespace Controllers;


use FW\App;
use FW\Auth;
use FW\DB;
use FW\View;

class ProductController {

    public function index() {
        $db=new DB();
        $db->prepare('select p.id,name,quantity,price,description,(select count(*) from comments where product_id=p.id) as comments_count from products as p where is_deleted=false');
        $db->execute();
        $result['products']=$db->fetchAllAssoc();
        $db->prepare('select id,name from categories');
        $db->execute();
        $result['categories']=$db->fetchAllAssoc();
        $result['title']='Shop';
        View::make('index', $result);
        if (Auth::isAuth()) {
            View::appendTemplateToLayout('topBar', 'top_bar/user');
        } else {
            View::appendTemplateToLayout('topBar', 'top_bar/guest');
        }

        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->appendTemplateToLayout('catMenu', 'side_bar/category_menu')
            ->render();
    }

    public function getProduct($id) {
        $db=new DB();
        $db->prepare('select id,name,quantity,price,description,category_id from products where is_deleted=false and id=?');
        $db->execute(array($id));
        $result['product']=$db->fetchRowAssoc();
        $db->prepare('select c.id,c.content,c.posted_on,c.user_id,u.username from comments as c join users as u on u.id=c.user_id where c.product_id=?');
        $db->execute(array($id));
        $result['comments']=$db->fetchAllAssoc();
        $db->prepare('select id,name from categories');
        $db->execute();
        $result['categories']=$db->fetchAllAssoc();
        $result['title']='Shop';
        $result['currentCategory']=$result['product']['category_id'];
        View::make('product', $result);
        if (Auth::isAuth()) {
            View::appendTemplateToLayout('topBar', 'top_bar/user');
        } else {
            View::appendTemplateToLayout('topBar', 'top_bar/guest');
        }

        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->appendTemplateToLayout('catMenu', 'side_bar/category_menu')
            ->render();
    }
} 