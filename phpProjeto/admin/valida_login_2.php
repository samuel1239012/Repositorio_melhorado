<?php


    // receber os dados do formulário login
    $email = $_POST["e_mail"];
    $password = $_POST["password"];

    // verifica se email OU password estão vazios
    if( empty($email) || empty($password) ){
        // redireciona para a tela de login
        header("location: login.php");
        exit;
    }

    // utilização do hash para criptografar a senha
    $password = hash('sha256', $password);

    // endpoint da API
    $end_point = "http://localhost/api_jornal/login/get.php?email=$email&password=$password";

    // Inicializa o CURL
    $curl = curl_init();

    // configurações do CURL
    curl_setopt_array($curl,[
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $end_point
    ]);

    // envio do comando CURL e armazenamento da resposta
    $response = curl_exec($curl);

    // conersão do JSON para ARRAY
    $dado = json_decode($response, TRUE);

    // testa o retorno da API. Se houver falha, redireciona para o login.php
    if ($dado["status"]=='fail'){
        $smg = "Falha no processo de login. Tente novamente";
        header('location: login.php');
        exit;
    }

    // caso estaja tudo certo, redireciona para o index.php (painel Administrativo)
    session_start();
    $_SESSION["autenticacao"] = true;
    $_SESSION["e_mail"] = $email;
    header('location: index.php');
    exit;
?>