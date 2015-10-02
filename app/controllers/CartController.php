<?php

namespace Controllers;


use FW\App;
use FW\Auth;
use FW\DB;
use FW\Redirect;
use FW\Session;
use FW\View;
use Models\Product;
use Models\Promotion;
use Models\User;

class CartController {

    public  function getAll() {
        $sess=App::getInstance()->getSession();
        $cart = array();
        if ($sess->containKey('cart')) {
            $cart = $sess->cart;
        }
        $result['title']='Shop';
        $result['products'] = $this->getProductsFromCart($cart);
        //var_dump($result['products']);
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
        $result['isAdmin'] = Auth::isUserInRole(array('admin'));
        $user = new User();
        $result['user_cash'] = $user->getUserMoney(Auth::getUserId());
        View::make('cart', $result);
        if (Auth::isAuth()) {
            View::appendTemplateToLayout('topBar', 'top_bar/user');
        } else {
            View::appendTemplateToLayout('topBar', 'top_bar/guest');
        }
//var_dump($_SESSION);
        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->appendTemplateToLayout('catMenu', 'side_bar/category_menu')
            ->render();
    }

    public function add($id) {
        $sess=App::getInstance()->getSession();
        if (!$sess->containKey('cart')) {
            $sess->cart = array();
        }
        $cart = $sess->cart;
        $product = new Product();
        $result = $product->getProduct($id);
        if (!array_key_exists($id, $cart)) {
            $cart[$id] = array(
                'quantity' => 1,
                'name' => $result['name'],
                'price' => $result['price']
            );
        }

        Session::setMessage('added to cart');
        $sess->cart = $cart;
        Redirect::to('/category/'.$result['category_id']);
    }

    public function changeQuantity($id, $quantity) {
        $sess=App::getInstance()->getSession();
        if (!$sess->containKey('cart') || !array_key_exists($id, $sess->cart)) {
            throw new \Exception('This products dont exist in your cart', 500);
        }

        $_SESSION['cart'][$id]['quantity'] = $quantity;
        Redirect::to('/user/cart');
    }

    public function removeProduct($id) {
        $sess=App::getInstance()->getSession();
        if (!$sess->containKey('cart') || !array_key_exists($id, $sess->cart)) {
            throw new \Exception('This products dont exist in your cart', 500);
        }

        unset($_SESSION['cart'][$id]);
        Redirect::to('/user/cart');
    }

    public function buy() {
        $totalSum = 0;
        $sess=App::getInstance()->getSession();
        $cart = $sess->cart;
        $products = new Product();
        $user = new User();

        $products->startTran();
        $productsFromCart = $this->getProductsFromCart($cart);
        foreach($productsFromCart as $item) {
            if ($products->changeQuantity($item['id'], $item['cart_quantity']) !== 1) {
                $products->rollback();
                Session::setError('not enough available product');
                Redirect::back();
            }

            $totalSum += $item['price']*$item['cart_quantity'];
        }

        $user = new User();
        if ($user->changeUserCash(Auth::getUserId(), $totalSum) !== 1) {
            $products->rollback();
            Session::setError('not enough money');
            Redirect::back();
        }
        foreach($productsFromCart as $item) {
            if ($user->addProduct(Auth::getUserId(), $item['id'], $item['cart_quantity'], $item['price']) !== 1) {
                $products->rollback();
                Session::setError('something went wrong');
                Redirect::back();
            }
        }
        $products->commit();
        unset($_SESSION['cart']);
        Session::setMessage('Done');
        Redirect::to('user/cart');
    }

    private function getProductsFromCart($cart) {
        $products = new Product();
        $prom = new Promotion();
        $all_promotion = $prom->getHighestActivePromotion();
        $productsFromCart = array();
        foreach($cart as $id => $q) {
            if (($currentProduct = $products->getProduct($id))) {
                $productPromotion = max($all_promotion['discount'], $currentProduct['discount'], $currentProduct['category_discount']);
                if (is_numeric($productPromotion)) {
                    $currentProduct['price'] = $currentProduct['price'] - ($currentProduct['price'] * ($productPromotion / 100));
                }
                $currentProduct['cart_quantity'] = $q['quantity'];
                $productsFromCart[] = $currentProduct;
            }
        }

        return $productsFromCart;
    }
} 