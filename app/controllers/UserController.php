<?php

namespace Controllers;
use FW\Auth;
use FW\Redirect;
use FW\Session;
use FW\Validation;
use FW\View;
use Models\Product;
use Models\User;
use Models\UserModel;

class UserController{

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

        $userModel = new User();
        if (($result = $userModel->register($user->username, $user->email, $user->password)) !== 1) {
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

        $u = new User();
        if ($u->isBanned(Auth::getUserId())['is_banned'] == true) {
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
        $user = new User();
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
        $result['isAdmin'] = Auth::isUserInRole(array('admin'));
        $result['user'] = $user->getUser(Auth::getUserId());
        View::make('user.profile', $result);
        View::appendTemplateToLayout('topBar', 'top_bar/user');
        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->appendTemplateToLayout('catMenu', 'side_bar/category_menu')
            ->render();
    }

    public function editProfile(UserModel $user, $new_password) {
        $userDB = new User();
        $validator = new Validation();
        $validator->setRule('required', $user->email);
        $validator->setRule('required', $user->password);
        $validator->setRule('email', $user->email);
        if (!$validator->validate()) {
            Redirect::back();
        }

        if ($userDB->editUser(Auth::getUserId(), $user->email, $new_password, $user->password) !== 1) {
            Redirect::back();
        }

        Redirect::to('');
    }

    public function getProducts($id) {
        if (!(Auth::isUserInRole(array('admin')) || $id == Auth::getUserId())) {
            Redirect::back();
        }

        $user = new User();
        $result['products'] = $user->getProducts(Auth::getUserId());
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
        $result['isAdmin'] = Auth::isUserInRole(array('admin'));
        View::make('user.products', $result);
        View::appendTemplateToLayout('topBar', 'top_bar/user');
        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->render();
    }

    public function sellProduct($id, $quantity) {
        $user = new User();
        $product = new Product();
        $user->startTran();

        if ($user->changeProductQuantity(Auth::getUserId(), $id, $quantity) !== 1) {
            Session::setError('not enough products');
            $user->rollback();
            Redirect::back();
        }

        $userProduct = $user->getProduct(Auth::getUserId(), $id);
        if ($userProduct['quantity'] < 1) {
            if ($user->deleteProduct(Auth::getUserId(), $id) !== 1) {
                Session::setError('something went wrong');
                $user->rollback();
                Redirect::back();
            }
        }

        $soldProducts = $product->getProduct($id);
        if ($product->addQuantity($soldProducts['id'], $quantity) !== 1) {
            Session::setError('something went wrong');
            $user->rollback();
            Redirect::back();
        }

        if ($user->addCash(Auth::getUserId(), $soldProducts['price'] * $quantity) !== 1) {
            Session::setError('something went wrong');
            $user->rollback();
            Redirect::back();
        }

        $user->commit();
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