<?php

    $host = "localhost";            // host onde está o banco de dados
    $db_name = "projet_jornal";      // nome do banco de dados
    $user = "root";                 // usuário de conexão ao banco de dados
    $password = "";                 // senha de conexão para o banco de dados


    try {
        $conn = new PDO("mysql:host={$host};dbname={$db_name}", $user, $password);
        // echo "Connection Successfuly";
    } catch (PDOException $ex) {
        die("Connection error: " .$ex->getMessage());
    }

?>