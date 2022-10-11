<?php
    function initDbConnection(){
        $servername = "localhost";
        $username = "apc";
        $password = "password";
        $db = "campusvis";

        $connection = mysqli_connect($servername, $username, $password, $db);
        if (!$connection){
            die("DB connection failed" . mysqli_connect_error());
        }
        return $connection;
    }
?>