<?php

namespace Controllers;


use FW\Auth;
use FW\Redirect;
use FW\Session;
use FW\Validation;
use Models\Comment;

class CommentController {

    public function post($id, $content) {
        $validator = new Validation();
        $validator->setRule('required', $content);
        if (!$validator->validate()) {
            Session::setError($validator->getErrors());
            Redirect::back();
        }

        $comment = new Comment();
        if ($comment->add(Auth::getUserId(), $id, $content) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('Done');
        Redirect::to('/product/' . $id);
    }

    public function delete($id) {
        $comment = new Comment();
        if (Auth::isUserInRole(array('admin')) || $comment->getComment($id)['id'] == Auth::getUserId()) {
            if ($comment->delete($id) !== 1) {
                Session::setError('something went wrong');
                Redirect::back();
            }

            Session::setMessage('Done');
            Redirect::back();
        }

        Redirect::back();
    }
} 