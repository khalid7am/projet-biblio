<?php

    $DATABASE_NAME = "librairie";
    $DATABASE_PASSWORD = "";
    $DATABASE_USER = "root";
    $DATABASE_HOST = "localhost";

    try {
        $con = new PDO('mysql:host='.$DATABASE_HOST.';dbname='.$DATABASE_NAME.';charset=utf8mb4', $DATABASE_USER, $DATABASE_PASSWORD);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  
    } catch (PDOException $e) {
        echo "Connection failed : ". $e->getMessage();
    }

    session_start();
    ini_set('error_reporting', 0);
    ini_set('display_errors', 0);
    
?>