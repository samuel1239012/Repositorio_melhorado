<?php

    // $host = "localhost";            // host onde está o banco de dados
    // $db_name = "projet_jornal";      // nome do banco de dados
    // $user = "root";                 // usuário de conexão ao banco de dados
    // $password = "";                 // senha de conexão para o banco de dados

    define('caminho','localhost');
define('nome_banco','projet_jornal');
define('usuario','root');
define('senha','');

    $conecta = mysqli_connect(caminho, usuario, senha, nome_banco);

    if(!$conecta) {
     echo '<h2>Falha ao se comunicar com a base de dados!</h2>';
        exit;
    }

?>