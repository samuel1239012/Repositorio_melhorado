<?php 

    require_once("../conexao.php");

    $email = $_POST["email"];
    $codigo = $_POST["codigo"];
    $senha1 = $_POST["senha1"];
    $senha2 = $_POST["senha2"];

    if($senha1 != $senha2){
        echo "As senhas não sao iguais";
        exit;
    }

    $sql = "SELECT pk_id FROM usuarios 
        WHERE e_mail='$email'AND recuperar_senha='$codigo'";

        $query = mysqli_query($conecta, $sql);

        if(mysqli_num_rows($query)==0){
            echo "E-mail ou codigo não são validos";
            exit;
        }

    $sql = "UPDATE usuarios SET senha=SHA2('$senha1', 256), recuperar_senha='' 
            WHERE e_mail='$email'";
            
    
        
        $query = mysqli_query($conecta, $sql);

        header("location: ../login.php");
        exit;

?>