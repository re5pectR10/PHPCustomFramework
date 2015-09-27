<?php

namespace FW;

use Controllers\test;

class FrontController {

    private static $_instance = null;
    private $ns = null;   
    private $controller = null;
    private $method = null;
     /**
     *
     * @var \FW\Routers\iRouter;
     */
    private $router=null;
    private function __construct() {
        
    }
    
    public function getRouter() {
        return $this->router;
    }

    public function setRouter(Routers\IRouter $router) {
        $this->router = $router;
    }

    public function dispatch(){
        $_uri = $this->router->getURI();
        $uriParams = array_filter(explode('/', $_uri), 'strlen');
        $controllerName = '';
        $controllerMethod = '';
        $paramsFromGET = array();
        foreach(Route::getRouters() as $route){
            $paramsFromGET = array();
            if($route['method'] != $_SERVER['REQUEST_METHOD'] ){
                continue;
            }

            // todo if auth
            $filter = explode('|', $route['details']['before']);
            if (in_array('auth', $filter)) {
                if (!Auth::isAuth()) {
                    continue;
                }
            }
            $roles = explode('|', $route['details']['roles']);
            if (!Auth::isUserInRole($roles)) {
                continue;
            }

            $routeParams = array_filter(explode('/', $route['url']), 'strlen');
            $nonRequiredFieldsForRoute = $this->getNonRequiredFieldsCount($routeParams);
            if(count($uriParams) < count($routeParams) - $nonRequiredFieldsForRoute || count($uriParams) > count($routeParams)) {
                continue;
            }
            for($i = 0; $i < count($uriParams); $i++) {
                if(!Common::startsWith($routeParams[$i], '{') && !Common::endsWith($routeParams[$i], '}')) {
                    if($uriParams[$i]!=$routeParams[$i]){
                        continue 2;
                    }
                } else {
                    if(!$this->isParameterValid($uriParams[$i], $routeParams[$i])) {
                        continue 2;
                    }
                    $paramName = explode(':', $routeParams[$i])[0];
                    $paramName = substr($paramName, 1);
                    if(Common::endsWith($paramName, '?}')) {
                        $paramName = substr($paramName, 0, strlen($paramName) - 2);
                    } else if(Common::endsWith($paramName, '}')){
                        $paramName = substr($paramName, 0, strlen($paramName) - 1);
                    }

                    $paramsFromGET[$paramName] = $uriParams[$i];
                }

                if(count($uriParams)-1 == $i) {
                    $controllerData = explode('@', $route['details']['use']);
                    $controllerName = App::getInstance()->getConfig()->app['controllers_namespace']. '\\'.$controllerData[0];
                    $controllerMethod = $controllerData[1];
                    break 2;
                }
            }

            $paramsFromGET = array();
        }
        if($controllerMethod === '') {
            if(App::getInstance()->getConfig()->app['enable_default_routing']) {
                $controllerName = App::getInstance()->getConfig()->app['controllers_namespace']. '\\'.$uriParams[0].'Controller';
                $controllerMethod = $uriParams[1];
                for($i = 2; $i < count($uriParams); $i++) {
                    array_push($paramsFromGET, $uriParams[$i]);
                }
            } else {
                $controllerName = App::getInstance()->getConfig()->app['controllers_namespace']. '\\'.App::getInstance()->getConfig()->app['default_controller'];
                $controllerMethod = App::getInstance()->getConfig()->app['default_method'];
            }
        }
        $input =  InputData::getInstance();
        $input->setGet($paramsFromGET);
        $input->setPost($_POST);
//var_dump(Route::getRouters());
        $class = new \ReflectionClass($controllerName);
        $method=$class->getMethod($controllerMethod);
        $methodRequiredParams = $method->getNumberOfRequiredParameters();
        $methodParams = $method->getParameters();
        $requestInput = array();
        foreach($methodParams as $par) {
            if ($par->getClass()->name !== null) {
                $paramClass = new \ReflectionClass($par->getClass()->name);
                $paramClassProperties = $paramClass->getProperties();
                $paramClassInstance = new $paramClass->name();
                foreach($paramClassProperties as $property) {
                    foreach($input->getPost() as $key => $value) {
                        $propertyName = $property->name;
                        if ($property->name == $key) {
                            $paramClassInstance->$propertyName = $value;
                        }
                    }
                }

                $requestInput[$par->name] = $paramClassInstance;
            }

            if(isset($input->getGet()[$par->name])) {
                $requestInput[$par->name] = $input->getGet()[$par->name];
            } else if(isset($input->getPost()[$par->name])) {
                $requestInput[$par->name] = $input->getPost()[$par->name];
            }
        }
        //if ($methodRequiredparams != count($paramsFromGET) + )
        //var_dump($method->getParameters()[0]);
        //var_dump(extract($requestInput));

//$help=new HelpPage(Route::getRouters());
//        $h = $help->getData();
//        foreach($h as $m) {
//            echo '<h1>'.$m['url'].'</h1>';
//            echo '<h3>'.$m['method'].'</h3>';
//            echo '<pre>'.$m['params'].'</pre>';
//        }

        if($methodRequiredParams > count($requestInput)) {
            throw new \Exception('parameters in the request not equal to parameters declared in method', 500);
        }
        $controller = new $controllerName();
        $controller = DependencyProvider::injectDependenciesToController($controller);
        call_user_func_array(array($controller, $controllerMethod), $requestInput);
    }

    private function isParameterValid($paramFromUrl, $paramFromRoute) {
        $split = explode(':', $paramFromRoute);
        if(!isset($split[1])) {
            return true;
        }
        if(Common::startsWith($split[1], 'int')) {
            return is_numeric($paramFromUrl) && $paramFromUrl == ceil($paramFromUrl);
        }
        if(Common::startsWith($split[1], 'bool')) {
            return is_bool($paramFromUrl);
        }
        if(Common::startsWith($split[1], 'float')) {
            return is_numeric($paramFromUrl);
        }
        if(Common::startsWith($split[1], 'double')) {
            return is_numeric($paramFromUrl);
        }
        if(Common::startsWith($split[1], 'long')) {
            return is_long($paramFromUrl);
        }
        return false;
    }

    private function getNonRequiredFieldsCount($routeParams) {
        $paramsCount = 0;
        for($i = count($routeParams) - 1; $i >= 0; $i--) {
            if(Common::endsWith($routeParams[$i], '?}')) {
                $paramsCount++;
            } else {
                return $paramsCount;
            }
        }

        return $paramsCount;
    }

    public function getDefaultController() {
        $controler = App::getInstance()->getConfig()->app['default_controller'];
        if ($controler) {
            return strtolower($controler);
        }
        return 'index';
    }

    public function getDefaultMethod() {
        $method = App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return strtolower($method);
        }
        return 'index';
    }

    /**
     * 
     * @return \FW\FrontController
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }
        return self::$_instance;
    }

}

