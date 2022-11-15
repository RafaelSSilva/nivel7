<?php
class LoaderApp {
    public function register():void {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function loadClass(string $class):bool{ 
        if (file_exists($class.".php")) {
            require_once $class.".php";
            return true;
        }

        if (file_exists("classes/".$class.".php")) {
            require_once "classes/".$class.".php";
            return true;
        }
    }
}
