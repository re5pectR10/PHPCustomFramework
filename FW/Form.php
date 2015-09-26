<?php

namespace FW;

class Form {

    public static function open(array $options = array()) {
        if (!array_key_exists('method', $options)) {
            $options['method'] = 'POST';
        }

        return '<form' . self::getAttributesAsString($options) . '>';
    }

    public static function close() {
        return '</form>';
    }

    public static function text(array $options = array()) {
        return self::getInputFormElement('text', $options);
    }

    public static function radio(array $options = array()) {
        return self::getInputFormElement('radio', $options);
    }

    public static function check(array $options = array()) {
        return self::getInputFormElement('checkbox', $options);
    }

    public static function password(array $options = array()) {
        return self::getInputFormElement('password', $options);
    }

    public static function hidden(array $options = array()) {
        return self::getInputFormElement('hidden', $options);
    }

    public static function submit(array $options = array()) {
        return self::getInputFormElement('submit', $options);
    }

    public static function textarea(array $options = array()) {
        return '<textarea' . self::getAttributesAsString($options) . '></textarea>';
    }

    public static function select(array $options = array(), array $elements = array()) {
        $output = '<select' . self::getAttributesAsString($options) . '>';
        foreach ($elements as $el) {
            $output .= '<option';
            $output .= isset($el['options']) ? self::getAttributesAsString($el['options']) : '';
            $output .= '>';
            $output .= isset($el['text']) ? $el['text'] : '';
            $output .= '</option>';
        }
        $output .= '</select>';
        return $output;
    }

    public static function csrf() {

    }

    private static function getInputFormElement($type, array $options = array()) {
        return '<input type="' . $type . '"' . self::getAttributesAsString($options) . '>';
    }

    private static function getAttributesAsString(array $attr = array()) {
        $attributes = '';
        foreach($attr as $key => $value) {
            $attributes .= ' ' . $key . '="' . $value . '"';
        }

        return $attributes;
    }
} 