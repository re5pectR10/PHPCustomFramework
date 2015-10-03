<?php

namespace Controllers;

use Controllers\Admin\Index;
use FW\View;

class testController{

    public function EditUser3($id) {

        $r=new Index();
        $r->aeee = 'stani e';
        View::useType('Controllers\Admin\Index')->make('test', array('model'=>$r))->render();
    }
} 