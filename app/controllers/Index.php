<?php

namespace Controllers;
class Index {
    public function index2(){        
        
        $view=  \FW\View::getInstance();
        $view->username='gatakka1111';
        $view->appendToLayout('body','admin.index');
        $view->appendToLayout('body2','index');
        $view->display('test',array('c'=>array(1,2,3,4,8)),false);
    }
}

