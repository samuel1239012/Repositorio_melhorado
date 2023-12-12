<?php

    session_start();
    $url = "http://localhost:4200/admin";
    if($_SESSION["autenticacao"] != true){
        header("location: $url/login.php");
        exit;
    }

?>