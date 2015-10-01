<?php

namespace Controllers;


use FW\Auth;
use FW\DB;
use FW\Redirect;
use FW\Session;
use FW\View;
use Models\Category;
use Models\Product;

class CategoryController {

    public function getCategory($id) {
        $category = new Category();
        $products = new Product();
        $result['products']=$products->getProductWithCommentsCountForCategory($id);
        $result['categories']=$category->getCategories();
        $result['title']='Shop';
        $result['currentCategory']=$id;
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
        $result['isAdmin'] = Auth::isUserInRole(array('admin'));
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

    public function deleteCategory($id) {
        $category = new Category();
        if ($category->delete($id) !== 1) {
            Session::setError('can not delete this category');
            Redirect::back();
        }

        Session::setMessage('done');
        Redirect::to('');
    }

    public function getAdd() {
        $result['title']='Shop';
        $result['action'] = '/category/add';
        $result['submit'] = 'add';
        View::make('category.add', $result);
        if (Auth::isAuth()) {
            View::appendTemplateToLayout('topBar', 'top_bar/user');
        } else {
            View::appendTemplateToLayout('topBar', 'top_bar/guest');
        }

        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->render();
    }

    public function postAdd($name) {
        $category = new Category();
        if ($category->add($name) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('done');
        Redirect::to('');
    }

    public function getEdit($id) {
        $cat = new Category();
        $result = array('category' => $cat->getCategory($id));
        $result['title']='Shop';
        $result['action'] = '/category/edit/' . $result['category']['id'];
        $result['submit'] = 'edit';
        View::make('category.add', $result);
        if (Auth::isAuth()) {
            View::appendTemplateToLayout('topBar', 'top_bar/user');
        } else {
            View::appendTemplateToLayout('topBar', 'top_bar/guest');
        }

        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->render();
    }

    public function postEdit($id, $name) {
        $category = new Category();
        if ($category->edit($id, $name) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('done');
        Redirect::to('');
    }
} 