<?php
/**
 * Created by PhpStorm.
 * User: Re5PecT
 * Date: 15-9-29
 * Time: 19:33
 */

namespace Controllers;


use FW\App;
use FW\Auth;
use FW\DB;
use FW\Redirect;
use FW\View;

class CartController {

    public  function getAll() {
        $sess=App::getInstance()->getSession();
        $cart = array();
        if ($sess->containKey('cart')) {
            $cart = $sess->cart;
        }
        $result['title']='Shop';
        $result['cart'] = $cart;
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

        $db=new DB();
        $db->prepare('select id,name,price,category_id from products where is_deleted=false and quantity>0 and id=?');
        $db->execute(array($id));
        $result=$db->fetchRowAssoc();
        if (!array_key_exists($id, $sess->cart)) {
            $sess->cart = array_merge($sess->cart, array($id =>
                array(
                'quantity' => 1,
                'name' => $result['name'],
                'price' => $result['price']
                )
            ));
        }

        Redirect::to('/category/'.$result['category_id']);
    }

    public function changeQuantity($id, $quantity) {
        $sess=App::getInstance()->getSession();
        if (!$sess->containKey('cart') || !array_key_exists($id, $sess->cart)) {
            throw new \Exception('This products dont exist in your cart', 500);
        }

        $_SESSION['cart'][$id]['quantity'] = $quantity;
        Redirect::to('user/cart');
    }

    public function removeProduct($id) {
        $sess=App::getInstance()->getSession();
        if (!$sess->containKey('cart') || !array_key_exists($id, $sess->cart)) {
            throw new \Exception('This products dont exist in your cart', 500);
        }

        unset($_SESSION['cart'][$id]);
        Redirect::to('user/cart');
    }

    public function buy() {
        $sess=App::getInstance()->getSession();
        $cart = $sess->cart;
        $db=new DB();
        $db->prepare('begin tran');
        $db->execute();

        foreach($cart as $id => $item) {

        }

        unset($_SESSION['cart']);
    }
} 