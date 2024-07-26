<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();

    $act = "kind";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }
    switch($act){
        case "kind":
            include_once "View/user/home.php";
            break;
        case "single":
            include_once "View/user/kind.php";
            break;
        case "family":
            include_once "View/user/kind.php";
            break;
        case "presidential":
            include_once "View/user/kind.php";
            break;
    }
?>