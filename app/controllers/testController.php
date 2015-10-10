<?php

namespace Controllers;

use Asd\uuu;
use Controllers\Admin\Index;
use FW\View;

class testController{

    public function EditUser3() {

        $r=new Index();
        $ra = new uuu();
        $r->aeee = 'stani e';
        View\View::useType(array('Controllers\Admin\Index'))->make('test', array('model'=>$r))->render();
        //View::useType(array('Controllers\Admin\Index'))->make('test', array('model'=>$r,'wrong' => $ra))->render();
    }
} 