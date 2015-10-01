<?php

namespace Controllers;


use FW\Auth;
use FW\Redirect;
use FW\Session;
use FW\Validation;
use FW\View;
use Models\Category;
use Models\Comment;
use Models\Product;
use Models\ProductModel;
use Models\Promotion;

class ProductController {

    public function index() {
        $category = new Category();
        $products = new Product();
        $prom = new Promotion();
        $result['products']=$products->getProducts();
        $result['categories']=$category->getCategories();
        $result['title']='Shop';
        $all_promotion = $prom->getHighestActivePromotion();
        foreach($result['products'] as $k => $p) {
            $productPromotion = max($all_promotion['discount'], $p['discount'], $p['category_discount']);
            if (is_numeric($productPromotion)) {
                $result['products'][$k]['promotion_price'] = $p['price'] - ($p['price'] * ($productPromotion / 100));
            }
        }
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
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
        $result['isAdmin'] = Auth::isUserInRole(array('admin'));
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

    public function getAdd() {
        $result['title']='Shop';
        $result['action'] = '/product/add';
        $result['submit'] = 'add';
        $cat = new Category();
        $categories = $cat->getCategories();
        foreach($categories as $c) {
            $currentCategory = array();
            $currentCategory['text'] = $c['name'];
            $currentCategory['options'] = array('value' => $c['id']);
            $result['categories'][] = $currentCategory;
        }
        View::make('product.add', $result);
        if (Auth::isAuth()) {
            View::appendTemplateToLayout('topBar', 'top_bar/user');
        } else {
            View::appendTemplateToLayout('topBar', 'top_bar/guest');
        }

        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->render();
    }

    public function postAdd(ProductModel $product) {
        $validator = new Validation();
        $validator->setRule('required', $product->name, null, 'name');
        $validator->setRule('required', $product->description, null, 'description');
        $validator->setRule('required', $product->price, null, 'price');
        $validator->setRule('required', $product->quantity, null, 'quantity');
        $validator->setRule('required', $product->category_id, null, 'category');
        $validator->setRule('numeric', $product->quantity, null, 'quantity');
        $validator->setRule('numeric', $product->price, null, 'price');
        if (!$validator->validate()) {
            Session::setError($validator->getErrors()[0]);
            Redirect::back();
        }
        $productDB = new Product();
        if ($productDB->add($product->name, $product->description,$product->price,$product->quantity,$product->category_id) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('done');
        Redirect::to('');
    }

    public function getEdit($id) {
        $product = new Product();
        $result = array('product' => $product->getProduct($id));
        $result['title']='Shop';
        $result['action'] = '/product/edit/' . $result['product']['id'];
        $result['submit'] = 'edit';
        $cat = new Category();
        $categories = $cat->getCategories();
        foreach($categories as $c) {
            $currentCategory = array();
            $currentCategory['text'] = $c['name'];
            $currentCategory['options'] = array('value' => $c['id']);
            if ($id == $c['id']) {
                $currentCategory['options']['selected'] = 'true';
            }
            $result['categories'][] = $currentCategory;
        }
        View::make('product.add', $result);
        if (Auth::isAuth()) {
            View::appendTemplateToLayout('topBar', 'top_bar/user');
        } else {
            View::appendTemplateToLayout('topBar', 'top_bar/guest');
        }

        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->render();
    }

    public function postEdit($id, ProductModel $product) {
        $validator = new Validation();
        $validator->setRule('required', $product->name, null, 'name');
        $validator->setRule('required', $product->description, null, 'description');
        $validator->setRule('required', $product->price, null, 'price');
        $validator->setRule('required', $product->quantity, null, 'quantity');
        $validator->setRule('required', $product->category_id, null, 'category');
        $validator->setRule('numeric', $product->quantity, null, 'quantity');
        $validator->setRule('numeric', $product->price, null, 'price');
        if (!$validator->validate()) {
            Session::setError($validator->getErrors()[0]);
            Redirect::back();
        }
        $productDB = new Product();
        if ($productDB->edit($id, $product->name, $product->description,$product->price,$product->quantity,$product->category_id) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('done');
        Redirect::to('');
    }

    public function delete($id) {
        $product = new Product();
        if ($product->delete($id) !== 1) {
            Session::setError('can not delete this product');
            Redirect::back();
        }

        Session::setMessage('done');
        Redirect::to('');
    }
} 