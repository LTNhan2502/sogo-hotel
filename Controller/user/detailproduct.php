<?php
    $act = "detailproduct";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }
    switch($act){
        case "detailproduct":
            include_once "View/user/detailproduct.php";
            break;
        
    }
?>