<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "edustaff";


    $conn = mysqli_connect($host, $user, $password, $db);
    if (!$conn) {
        
    die("connection error");
    }

    mysqli_set_charset($conn, "utf8");
    mysqli_select_db($conn, $db);

    class Connection {
        public static function getConnection() {
            global $conn;
            return $conn;
        }
    }

    ?>