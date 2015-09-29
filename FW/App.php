<?php
namespace FW;

include_once 'Loader.php';


class App {

    private static $_instance = null;
    private $_config = null;
    private $router = null;
    private $_dbConnections = array();
    /**
     * @var \FW\Session
     */
    private $_session = null;

    /**
     *
     * @var \FW\FrontController
     */
    private $_frontController = null;

    private function __construct() {
        set_exception_handler(array($this, '_exceptionHandler'));
        Loader::registerNamespace('FW', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
        $this->_config = Config::getInstance();
        //if config folder is not set, use defaultone
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }

        include_once '../routes.php';
        include_once '../dependencies.php';
    }

    public function setConfigFolder($path) {
        $this->_config->setConfigFolder($path);
    }

    public function getConfigFolder() {
        return $this->_config->getConfigFolder();
    }

    public function getRouter() {
        return $this->router;
    }

    public function setRouter($router) {
        $this->router = $router;
    }

    /**
     * 
     * @return \FW\Config
     */
    public function getConfig() {
        return $this->_config;
    }

    public function run() {
        //if config folder is not set, use defaultone
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../app/config');
        }
        $this->_frontController = FrontController::getInstance();
        if ($this->router instanceof Routers\IRouter) {
            $this->_frontController->setRouter($this->router);
        } else {
            $this->_frontController->setRouter(new Routers\DefaultRouter());
        }

        $_sess = $this->_config->app['session'];
        if ($_sess['autostart']) {
            if ($_sess['type'] == 'native') {
                $_s = new Session($_sess['name'], $_sess['lifetime'], $_sess['path'], $_sess['domain'], $_sess['secure']);
            } else {
                throw new \Exception('No valid session', 500);
            }
            $this->setSession($_s);
        }

//unset($_SESSION['cart']);
        $_SESSION['id']=1;//$_SESSION['cart'][]=array('id'=>1,'quantity'=>1,'name'=>'test2','price'=>223);
//Auth::removeAuth();

// Auth::setSess = $_SESSION;

        $this->_frontController->dispatch();
    }

   // public function setSession(\GF\Session\ISession $session) {
    //    $this->_session = $session;
    //}

    /**
     * 
    // * @return \FW\Session\ISession
     */
    public function getSession() {
        return $this->_session;
    }

    public function setSession($sess) {
        $this->_session = $sess;
    }

    public function getDBConnection($connection = 'default') {
        if (!$connection) {
            throw new \Exception('No connection identifier provider', 500);
        }
        if ($this->_dbConnections[$connection]) {
            return $this->_dbConnections[$connection];
        }
        $_cnf = $this->getConfig()->database;
        if (!$_cnf[$connection]) {
            throw new \Exception('No valid connection identificator is provided', 500);
        }
        $dbh = new \PDO($_cnf[$connection]['connection_uri'], $_cnf[$connection]['username'],
                        $_cnf[$connection]['password'], $_cnf[$connection]['pdo_options']);
        $this->_dbConnections[$connection] = $dbh;
        return $dbh;
    }

    /**
     * 
     * @return \FW\App
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }
    
    public function _exceptionHandler(\Exception $ex) {        
        if ($this->_config && $this->_config->app['debug'] == true) {
            echo '<pre>' . print_r($ex, true) . '</pre>';
        } else {
            $this->displayError($ex->getCode());
        }
    }

    public function displayError($error) {
        try {
            View::make('errors.' . $error)->render();
        } catch (\Exception $exc) {
            Common::headerStatus($error);
            echo '<h1>' . $error . '</h1>';
            exit;
        }
    }
    
    public function __destruct() {
        if ($this->_session != null) {
            $this->_session->saveSession();
        }
    }
}