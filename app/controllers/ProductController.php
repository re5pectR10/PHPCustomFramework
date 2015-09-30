<?php

namespace Controllers;


use FW\App;
use FW\Auth;
use FW\DB;
use FW\View;
use Models\Category;
use Models\Comment;
use Models\Product;

class ProductController {

    public function index() {
        $category = new Category();
        $products = new Product();
        $result['products']=$products->getProducts();
        $result['categories']=$category->getCategories();
        $result['title']='Shop';
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
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
        $category = new Category();
        $comments = new Comment();
        $product = new Product();
        $result['product']=$product->getProduct($id);
        $result['comments']=$comments->getCommentsByProduct($id);
        $result['categories']=$category->getCategories();
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