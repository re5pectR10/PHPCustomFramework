<?php

namespace Controllers;
use FW\Auth;
use FW\Redirect;
use FW\Session;
use FW\Validation;
use FW\View;
use Models\UserModel;

class UserController{

    /**
     * @var \Models\Product
     */
    private $product;
    /**
     * @var \Models\User
     */
    private $user;

    public function getRegister() {
        $result['title']='Shop';
        View::make('user.register', $result);
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

    public function postRegister(UserModel $user) {
        $validator = new Validation();
        $validator->setRule('required', $user->username, null, 'username');
        $validator->setRule('required', $user->password, null, 'password');
        $validator->setRule('email', $user->email, null, 'email');
        if (!$validator->validate()) {
            Session::setError($validator->getErrors());
            Redirect::back();
        }

        if (($result = $this->user->register($user->username, $user->email, $user->password)) !== 1) {
            Session::setError($result);
            Redirect::back();
        }

        Session::setMessage('registered successfully');
        Redirect::to('');
    }

    public function getLogin() {
        $result['title']='Shop';
        View::make('user.login', $result);
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

    public function postLogin(UserModel $user) {
        if (!Auth::validateUser($user->username, $user->password)) {
            Session::setError('wrong credentials');
            Redirect::back();
        }

        if ($this->user->isBanned(Auth::getUserId())['is_banned'] == true) {
            Auth::removeAuth();
            Session::setError('you are banned');
            Redirect::back();
        }

        Redirect::to('');
    }

    public function logout() {
        Auth::removeAuth();
        Redirect::to('');
    }

    public function getProfile() {
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
        $result['isAdmin'] = Auth::isUserInRole(array('admin'));
        $result['user'] = $this->user->getUser(Auth::getUserId());
        View::make('user.profile', $result);
        View::appendTemplateToLayout('topBar', 'top_bar/user');
        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->appendTemplateToLayout('catMenu', 'side_bar/category_menu')
            ->render();
    }

    public function editProfile(UserModel $user, $new_password) {
        $validator = new Validation();
        $validator->setRule('required', $user->email);
        $validator->setRule('required', $user->password);
        $validator->setRule('email', $user->email);
        if (!$validator->validate()) {
            Redirect::back();
        }

        if ($this->user->editUser(Auth::getUserId(), $user->email, $new_password, $user->password) !== 1) {
            Redirect::back();
        }

        Redirect::to('');
    }

    public function getProducts($id) {
        if (!(Auth::isUserInRole(array('admin')) || $id == Auth::getUserId())) {
            Redirect::back();
        }

        $result['products'] = $this->user->getProducts($id);
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
        $result['isAdmin'] = Auth::isUserInRole(array('admin'));
        View::make('user.products', $result);
        View::appendTemplateToLayout('topBar', 'top_bar/user');
        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->render();
    }

    public function sellProduct($id, $quantity, $upid) {
        $this->user->startTran();

        if ($this->user->changeProductQuantity(Auth::getUserId(), $id, $quantity, $upid) !== 1) {
            Session::setError('not enough products');
            $this->user->rollback();
            Redirect::back();
        }

        $userProduct = $this->user->getProduct(Auth::getUserId(), $id, $upid);
        if ($userProduct['quantity'] < 1) {
            if ($this->user->deleteProduct(Auth::getUserId(), $id, $upid) !== 1) {
                Session::setError('something went wrong');
                $this->user->rollback();
                Redirect::back();
            }
        }

        $soldProducts = $this->product->getProduct($id);
        if ($this->product->addQuantity($soldProducts['id'], $quantity) !== 1) {
            Session::setError('something went wrong');
            $this->user->rollback();
            Redirect::back();
        }

        if ($this->user->addCash(Auth::getUserId(), $soldProducts['price'] * $quantity) !== 1) {
            Session::setError('something went wrong');
            $this->user->rollback();
            Redirect::back();
        }

        $this->user->commit();
        Session::setMessage('You sold ' . $quantity . ' of ' . $userProduct['name']);
        Redirect::to('/user/' . Auth::getUserId() . '/products');
    }
//    /**
//     * @var test
//     */
//    private $name;
//
//    public function EditUser2($sas, $sss) {
//        echo($this->name->e->ui);
//        echo $sas;echo $sss;
//    }
//    public function EditUser3($id){
//        echo $this->name->azzz;
//        echo 'oooooooooooooooooooo';
//    }
//    public function index2(){
//        View::make('test')
//            ->with('username', 'aaaaaaaazzzzzzzz')
//            //->appendTemplateToLayout('body','admin.index')
//            //->appendTemplateToLayout('body2','index')
//            ->with('data', array(1,2,3,4,8))
//            ->render();
//    }
//    public function testmethod($test1, $a, $paka='1111111'){
//        echo $test1;
//        echo $a;
//        echo $paka;
//    }
} 