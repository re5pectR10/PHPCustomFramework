<?php

namespace Controllers;
use FW\View;

class Index {
    public function index2(){        

        View\View::make('test')
            ->with('username', 'aaaaaaaazzzzzzzz')
            //->appendTemplateToLayout('body','admin.index')
            //->appendTemplateToLayout('body2','index')
            ->with('data', array('c'=>array(1,2,3,4,8)))
            ->render();
    }
}

