<?php
    class connect{
        var $db = null;
        function __construct(){
            $dsn = 'mysql:host=localhost;dbname=sogo_hotel';
            $user = 'root';
            $pass = '';
            try{
                $this->db = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));

            }catch(\Throwable $th){
                echo $th;
            }
        }

        //Câu lệnh thực hiện select thực thi, thuộc về class PDO
        function getList($select){
            $result = $this->db->query($select);
            return $result;
        }

        //Phương thức trả về một dòng dữ liệu
        function getInstance($select){
            $results = $this->db->query($select);
            $result = $results->fetch();
            return $result;
        }

        //Phương thức chạy các câu lệnh insert, delete, update trong mysql
        function exec($query){
            $result = $this->db->exec($query);
            return $result;
        }

        //Phương thức thực thi tất cả, dùng prepare
        function execp($query){
            $statement = $this->db->prepare($query);
            return $statement;
        }
    }
?>