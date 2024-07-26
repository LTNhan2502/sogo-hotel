<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();

    $act = "admin_bill_list";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    switch ($act) {
        case 'admin_bill_list':
            include_once "View/admin/admin_bill_list.php";
            break;
        case "pages":
            if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['page']) && isset($_GET['limit'])){
                //Phân trang
                $checkout = new checkout();
                $limit = $_GET['limit']; //Giới hạn số bill trong 1 trang
                $page = new page();
                $start = $page->findStart($limit); //Lấy được sản phẩm bắt đầu trong 1 trang
                $result = $checkout->getBillPage($start, $limit);
                $res = $result->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($res);
            }  
            break;
        case "search":
            if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['page']) && isset($_GET['limit'])){
                $checkout = new checkout();
                $limit = $_GET['limit']; // Giới hạn số bill trong 1 trang
                $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                $page = new page();
                $start = $page->findStart($limit); // Lấy được sản phẩm bắt đầu trong 1 trang
                $result = $checkout->getBillSearchPage($keyword, $start, $limit);
                $res = $result->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($res);
            }  
            break;
            
    }

    
?>