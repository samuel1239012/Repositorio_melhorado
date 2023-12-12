<?php
    $email = $_POST["email"];
    $password = hash('sha256',$_POST["password"]);
    // $cargo = $_GET["ADM"];
    $url = "http://localhost/api_jornal/login/";
    
    $post_body =json_encode([
        'email' => $email,
        'password' => $password,
        ]) ;

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $post_body,
        CURLOPT_RETURNTRANSFER => true,
    ]);
    $resultado = curl_exec($ch);
    curl_close($ch);

    $dado = json_decode($resultado, TRUE);

    // testa o retorno da API. Se houver falha, redireciona para o login.php
    if ($dado["status"]=='fail'){
        $msg = "Falha no processo de login. Tente novamente";
        $status = "fail";
        header("location: login.php?msg=$msg&status=$status");
        exit;
    }
    // verifica se usuário está habilitado

    $login = $dado["login"];

    // echo "<pre>";
    //     print_r($dado);
    //     echo "</pre>";
    // exit;

    if($login["habilita"]==0){
        $msg = "Usuário não está habilitado para fazer login!";
        $status = "fail";
        header("location: login.php?msg=$msg&status=$status");
        exit;
    }



    // caso estaja tudo certo, redireciona para o index.php (painel Administrativo)
    session_start();
    $_SESSION["autenticacao"] = true;
    $_SESSION["email"] = $email;
    $_SESSION["cargo"] =$login["cargo"];
    $msg = "Login efetuado com sucesso!";
    $status = "success";
    header("location:  /admin/usuarios/index.php?msg=$msg&status=$status");
    exit;
   
?>

