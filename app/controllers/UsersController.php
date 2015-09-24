<?php

namespace Controllers;

class UsersController {

    public function EditUser2($sas, $sss){
        echo $sas;echo $sss;
    }

    public function index2(){
        $view=  \FW\View::getInstance();
        $view->display('test',array('c'=>array(1,2,3,4,8)),false);
    }
    public function testmethod($test1, $a, $paka='1111111'){
        echo $test1;
        echo $a;
        echo $paka;
    }
} 