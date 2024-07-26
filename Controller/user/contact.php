<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();

    $act = "contact";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    switch($act){
        case "contact":
            include_once "View/user/contact.php";
            break;        
    }    
?>