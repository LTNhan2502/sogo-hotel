<?php
    $act = "admin_room_cancel";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    switch ($act){
        case 'admin_room_cancel':
            include_once "View/admin/admin_room_cancel.php";
            break;
    }
?>