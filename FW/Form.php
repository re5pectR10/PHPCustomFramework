<?php

namespace FW;

class Form {

    public static function open($options = array()) {
        $method = 'post';
        $action = '';
        $name = '';
        $class = '';
        $id = '';
        foreach($options as $key => $value) {
            $$key = $value;
        }

        return '<form id="'.$id.'" class="'.$class.'" name="'.$name.'" method="'.$method.'" action="'.$action.'">';
    }
} 