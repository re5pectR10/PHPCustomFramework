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
use Models\Product;
use Models\User;

class CartController {

    public  function getAll() {
        $sess=App::getInstance()->getSession();
        $cart = array();
        if ($sess->containKey('cart')) {
            $cart = $sess->cart;
        }
        $result['title']='Shop';
        $result['cart'] = $cart;
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
        $db=new DB();
        $db->prepare('select id,name,price,category_id from products where is_deleted=false and quantity>0 and id=?');
        $db->execute(array($id));
        $result=$db->fetchRowAssoc();
        if (!array_key_exists($id, $cart)) {
            $cart[$id] = array(
                'quantity' => 1,
                'name' => $result['name'],
                'price' => $result['price']
            );
        }

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
        $db=new DB();
        $db->prepare('START TRANSACTION');
        $db->execute();

        foreach($cart as $id => $item) {
            if (!$this->changeQuantityInDb($id, $item['quantity'])) {
                $db->prepare('ROLLBACK');
                $db->execute();
                Redirect::back();
            }

            $totalSum += $item['price']*$item['quantity'];
        }

        $db->prepare('update users set cash=cash-? where cash>=? and id=?');
        $db->execute(array($totalSum, $totalSum, Auth::getUserId()));
        if ($db->getAffectedRows()!==1) {
            $db->prepare('ROLLBACK');
            $db->execute();
            Redirect::back();
        }

        $db->prepare('COMMIT');
        $db->execute();
        unset($_SESSION['cart']);
        Redirect::to('user/cart');
    }

    private function changeQuantityInDb($id,$quantity) {
        $db=new DB();
        $db->prepare('update products set quantity=quantity-? where is_deleted=false and quantity>=? and id=?');
        $db->execute(array($quantity, $quantity, $id));
        if ($db->getAffectedRows()!==1) {
            return false;
        }

        return true;
    }
    private function isProductQuantityAvailable($id, $quantity) {
        $db=new DB();
        $db->prepare('select id from products where is_deleted=false and quantity>=? and id=?');
        $db->execute(array($id, $quantity));
        $result=$db->fetchRowAssoc();
        if($result!==null) {
            return true;
        }

        return false;
    }
} 