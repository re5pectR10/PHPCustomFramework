<?php

namespace Controllers;
use FW\View;

class UsersController {

    public function EditUser2($sas, $sss){
        echo $sas;echo $sss;
    }

    public function index2(){
        View::make('test')
            ->with('username', 'aaaaaaaazzzzzzzz')
            //->appendTemplateToLayout('body','admin.index')
            //->appendTemplateToLayout('body2','index')
            ->with('data', array(1,2,3,4,8))
            ->render();
    }
    public function testmethod($test1, $a, $paka='1111111'){
        echo $test1;
        echo $a;
        echo $paka;
    }
} 