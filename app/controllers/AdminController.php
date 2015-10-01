<?php

namespace Controllers;


use FW\Auth;
use FW\Redirect;
use FW\Session;
use FW\View;
use Models\User;

class AdminController {

    public function getUsers() {
        $users = new User();
        $result['users'] = $users->getUsersWithRoles();
        $result['title']='Shop';
        $result['isEditor'] = Auth::isUserInRole(array('editor', 'admin'));
        $result['isAdmin'] = Auth::isUserInRole(array('admin'));
        View::make('admin.roles', $result);
        View::appendTemplateToLayout('topBar', 'top_bar/user');
        View::appendTemplateToLayout('header', 'includes/header')
            ->appendTemplateToLayout('footer', 'includes/footer')
            ->render();
    }

    public function setRole($id, $role) {
        if (!in_array($role, array('admin', 'editor', 'user'))) {
            Session::setError('incorrect role');
            Redirect::back();
        }

        $users = new User();
        if ($role == 'user') {
            if ($users->deleteUserRole($id) === 0) {
                Session::setError('something went wrong');
                Redirect::back();
            }

            Session::setMessage('Done');
            Redirect::to('/admin/users');
        }
        if ($users->setRole($id, $role) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('Done');
        Redirect::to('/admin/users');
    }

    public function banUser($id) {
        $user = new User();
        if ($user->banUser($id) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('Done');
        Redirect::to('/admin/users');
    }
} 