<?php
class LoaderApp {
    public function register() {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function loadClass($class){        
        if (file_exists($class.".php")) {
            require_once $class.".php";
            return true;
        }
    }
}
