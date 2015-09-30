<?php

namespace FW;

class View {

    private static $___viewPath = null;
    private static $___viewDir = null;
    private static $___data = array();
    private static $___extension = '.php';
    private static $___layoutParts = array();
    private static $___layoutData = array();
    private static $___layout = null;
    private static $type = null;
    private  static function initViewPath() {
        
        self::$___viewPath = App::getInstance()->getConfig()->app['viewsDirectory'];
        if (self::$___viewPath == null) {
            self::$___viewPath = realpath('../views/');
        }
    }
    
    public static function setViewDirectory($path) {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_dir($path) && is_readable($path)) {
                self::$___viewDir = $path;
            } else {
                //todo
                throw new \Exception('view path',500);
            }
        } else {
            //todo
            throw new \Exception('view path',500);
        }
    }
    
//     public function display($name, $data = array(), $returnAsString = false) {
//
//        if (is_array($data)) {
//            $this->___data = array_merge($this->___data, $data);
//        }
//
//        if (count($this->___layoutParts) > 0) {
//            foreach ($this->___layoutParts as $k => $v) {
//                $r = $this->_includeFile($v);
//                if ($r) {
//                    $this->___layoutData[$k] = $r;
//                }
//            }
//        }
//
//        if ($returnAsString) {
//            return $this->_includeFile($name);
//        } else {
//            echo $this->_includeFile($name);
//        }
//    }

    public static function make($layout, $data = array()) {
        self::$___layout = $layout;
        if (is_array($data)) {
            self::$___data = array_merge(self::$___data, $data);
        }

        return new static;
    }

    public static function getLayoutData($name){
        return self::$___layoutData[$name];
    }

    public static function with($key, $data) {
        self::$___data[$key] = $data;

        return new static;
    }

    public static function render() {
        self::initViewPath();
        if (self::$type !== null) {
            if (isset(self::$___data[0])) {
                if (get_class(self::$___data[0]) != self::$type) {
                    throw new \Exception('', 500);
                }
            }
        }

        if (count(self::$___layoutParts) > 0) {
            foreach (self::$___layoutParts as $k => $v) {
                $r = self::_includeFile($v);
                if ($r) {
                    self::$___layoutData[$k] = $r;
                }
            }
        }
        if (self::$___layout !== null) {
            echo self::_includeFile(self::$___layout);
        } else {
            throw new \Exception('The layout is missing', 500);
        }
    }

    public static function useType($class) {
        if(!class_exists($class)) {
            throw new \Exception('The class' . $class . 'is not defined', 500);
        }

        self::$type = $class;
        return new static;
    }

    public static function removeType() {
        self::$type = null;
        return new static;
    }

    public static function appendTemplateToLayout($key, $template) {
        if ($key && $template) {
            self::$___layoutParts[$key] = $template;
        } else {
            throw new \Exception('Layout required valid key and template', 500);
        }

        return new static;
    }

    private static function _includeFile($___file) {
        if (self::$___viewDir == null) {
            self::setViewDirectory(self::$___viewPath);
        }       
        $___fl = self::$___viewDir . str_replace('.', DIRECTORY_SEPARATOR, $___file) . self::$___extension;
        if (file_exists($___fl) && is_readable($___fl)) {
            ob_start();
            extract(self::$___data);
            include $___fl;            
            return ob_get_clean();
        } else {
            throw new \Exception('View ' . $___file . ' cannot be included', 500);
        }        
    }
    
//    public static function __set($name, $value) {
//        self::$___data[$name] = $value;
//    }
//
//    public static function __get($name) {
//        return self::$___data[$name];
//    }
}


