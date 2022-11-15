<?php
require_once "loaderApp.php";

$loader = new LoaderApp;
$loader->register();

$classe = $_REQUEST['class'];
$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : null;

if (class_exists($classe)) {
    $pagina = new $classe($_REQUEST);

    if (!empty($method) AND (method_exists($classe, $method))) {
       $pagina->$method($_REQUEST);
    }
    
    $pagina->show();  
}