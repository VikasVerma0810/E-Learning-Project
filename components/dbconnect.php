<?php
    $servername = "Localhost";
    $db_username = "root";
    $db_password = "";
    $database_name = "elearningdb";

    $conn = mysqli_connect( $servername , $db_username,$db_password, $database_name  );
    if(!$conn){
        echo "Could not connect to database";
    }

    function unique_id() {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $rand = array();
        $length = strlen($str) - 1;
        for ($i = 0; $i < 20; $i++) {
            $n = mt_rand(0, $length);
            $rand[] = $str[$n];
        }
        return implode($rand);
     }
?>