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

    public static function close() {
        return '</form>';
    }

    public static function text($id = '', $class = '', $name = '') {
        return self::getInputFormElement('text', $id, $class, $name);
    }

    private static function getInputFormElement($type, $id = '', $class = '', $name = '') {
        return '<input id="'.$id.'" class="'.$class.'" type="'.$type.'" name="'.$name.'">';
    }
} 