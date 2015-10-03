<?php

namespace Controllers;


use FW\Auth;
use FW\Redirect;
use FW\Session;
use FW\Validation;

class CommentController {

    /**
     * @var \Models\Comment
     */
    private $comment;
    public function post($id, $content) {
        $validator = new Validation();
        $validator->setRule('required', $content);
        if (!$validator->validate()) {
            Session::setError($validator->getErrors());
            Redirect::back();
        }

        if ($this->comment->add(Auth::getUserId(), $id, $content) !== 1) {
            Session::setError('something went wrong');
            Redirect::back();
        }

        Session::setMessage('Done');
        Redirect::to('/product/' . $id);
    }

    public function delete($id) {
        if (Auth::isUserInRole(array('admin')) || $this->comment->getComment($id)['user_id'] == Auth::getUserId()) {
            if ($this->comment->delete($id) !== 1) {
                Session::setError('something went wrong');
                Redirect::back();
            }

            Session::setMessage('Done');
            Redirect::back();
        }

        Redirect::back();
    }
} 