<?php

namespace Controllers;


use FW\Auth;
use FW\Redirect;
use FW\Session;
use FW\View;

class CategoryController {

    /**
     * @var \Models\Category
     */
    private $category;
    /**
     * @var \Models\Product
     */
    private $product;
    /**
     * @var \Models\Promotion
     */
    private $promotion;
    public function getCategory($id) {
        $result['categories']=$this->category->getCategories();
        $result['title']='Shop';
        $result['currentCategory']=$id;
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
        $result['isAdmin'] = Auth::isUserInRole(array('admin'));
        if ($result['isEditor']) {
            $result['products']=$this->product->getProductsForCategoryWitnUnavailable($id);
        } else {
            $result['products']=$this->product->getProductsForCategory($id);
        }
        $all_promotion = $this->promotion->getHighestActivePromotion();
        foreach($result['products'] as $k => $p) {
            $productPromotion = max($all_promotion['discount'], $p['discount'], $p['category_discount']);
            if (is_numeric($productPromotion)) {
                $result['products'][$k]['promotion_price'] = $p['price'] - ($p['price'] * ($productPromotion / 100));
            }
        }

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
        if ($this->category->delete($id) !== 1) {
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
        if ($this->category->add($name) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('done');
        Redirect::to('');
    }

    public function getEdit($id) {
        $result = array('category' => $this->category->getCategory($id));
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
        if ($this->category->edit($id, $name) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('done');
        Redirect::to('');
    }
} 