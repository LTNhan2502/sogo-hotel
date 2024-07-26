<?php
    function checkAuthority($uri = false){
        $uri = $uri == false ? $_SERVER['REQUEST_URI'] : $uri;
        if(empty($_SESSION['current_user']['authorities'])){
            return false;
        }
        
        $authorities = $_SESSION['current_user']['authorities'];
        //Gộp các đường link lại để kiểm tra
        $authorities = implode("|", $authorities);
        //Kiểm tra nếu vào 1 trong các đường link trên thì cho phép, ngoài đường link thì không cho vào
        preg_match('/admin_home\.php$|'.$authorities.'/', $uri, $matches);
        return !empty($matches);
    }

    //Chuyển sang 404 page khi không có quyền truy cập mà có được link truy cập
    function redirectTo404(){
        header("Location: admin_index.php?action=404");
        exit();
    }
?>