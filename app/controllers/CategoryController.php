<?php

namespace Controllers;


use FW\Auth;
use FW\DB;
use FW\View;

class CategoryController {

    public function getCategory($id) {
        $db=new DB();
        $db->prepare('select p.id,p.name,p.quantity,p.price,p.description,(select count(*) from comments where product_id=p.id) as comments_count from products as p where p.is_deleted=false and p.category_id=?');
        $db->execute(array($id));
        $result['products']=$db->fetchAllAssoc();
        $db->prepare('select id,name from categories');
        $db->execute();
        $result['categories']=$db->fetchAllAssoc();
        $result['title']='Shop';
        $result['currentCategory']=$id;
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
} 