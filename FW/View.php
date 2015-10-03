<?php

namespace FW;

class View {

    private static $viewPath = null;
    private static $viewDir = null;
    private static $data = array();
    private static $extension = '.php';
    private static $layoutParts = array();
    private static $layoutData = array();
    private static $layout = null;
    private static $type = null;
    private  static function initViewPath() {
        
        self::$viewPath = App::getInstance()->getConfig()->app['viewsDirectory'];
        if (self::$viewPath == null) {
            self::$viewPath = realpath('../views/');
        }
    }
    
    public static function setViewDirectory($path) {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_dir($path) && is_readable($path)) {
                self::$viewDir = $path;
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
        self::$layout = $layout;
        if (is_array($data)) {
            self::$data = array_merge(self::$data, $data);
        }

        return new static;
    }

    public static function getLayoutData($name){
        return self::$layoutData[$name];
    }

    public static function with($key, $data) {
        self::$data[$key] = $data;

        return new static;
    }

    public static function render() {
        self::initViewPath();
        if (self::$type !== null) {
            if (count(self::$data) != 1) {
                throw new \Exception('you have passed multiple objects to strong type view', 500);
            }
            reset(self::$data);
            $first_key = key(self::$data);
            if (get_class(self::$data[$first_key]) != self::$type) {
                throw new \Exception('Wrong object type', 500);
            }
        }

        if (count(self::$layoutParts) > 0) {
            foreach (self::$layoutParts as $k => $v) {
                $r = self::_includeFile($v);
                if ($r) {
                    self::$layoutData[$k] = $r;
                }
            }
        }
        if (self::$layout !== null) {
            echo self::_includeFile(self::$layout);
        } else {
            throw new \Exception('The layout is missing', 500);
        }
         //$rc = new \ReflectionClass( self::$___viewDir . str_replace('.', DIRECTORY_SEPARATOR, self::$___layout) . self::$___extension);
        //var_dump($rc->getDocComment());
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
            self::$layoutParts[$key] = $template;
        } else {
            throw new \Exception('Layout required valid key and template', 500);
        }

        return new static;
    }

    private static function _includeFile($___file) {
        if (self::$viewDir == null) {
            self::setViewDirectory(self::$viewPath);
        }       
        $___fl = self::$viewDir . str_replace('.', DIRECTORY_SEPARATOR, $___file) . self::$extension;
        if (file_exists($___fl) && is_readable($___fl)) {
            ob_start();
            extract(self::$data);
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


