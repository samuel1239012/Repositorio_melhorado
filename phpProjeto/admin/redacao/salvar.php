<?php
  include("../validar_sessao.php");
 
    if (!empty($_POST)){
       
 
        if(empty($_POST["nome"])){
            $msg= "Campo nome obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
   
 
        if(empty($_POST["salario"])){
            $msg= "Campo salario obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
   
       
        if(empty($_POST["telefone"])){
            $msg= "Campo telefone obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
   
       
 
        if(empty($_POST["cpf"])){
            $msg= "Campo cpf obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
   
 
 
        // endpoint da API
        $end_point = "http://localhost/api_jornal/redacao/";
 
        // Inicializa o CURL
        $curl = curl_init();
 
        $id = "";
        if(empty($_POST["id"])){
            // se ID é vazio será realizado POST
            $method = "POST";
           
        }else{
            //se ID não é vazio será realizado put
            $method = "PUT";
            $id = $_POST['id'];
        }
        $nome = $_POST["nome"];
        $salario = $_POST["salario"];
        $telefone = $_POST["telefone"];
        $cpf = $_POST["cpf"];
      
       
        $post_body = json_encode([
            'id' => $id,
            'nome'=> $nome,
            'salario'=> $salario,
            'telefone'=> $telefone,
            'cpf'=>$cpf,
           
        ]);
     
       
        // configurações do CURL
        curl_setopt_array($curl,[
            CURLOPT_URL => $end_point,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $post_body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
 
        // envio do comando CURL e armazenamento da resposta
        $response = curl_exec($curl);
 
        // conersão do JSON para ARRAY
        $dado = json_decode($response, TRUE);
 
   
 
        // testar retorno da api
        if($dado["status"]=='fail'){
            $msg = "Erro ao inserir o registro";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
 
        // tudo OK - inserio informação com sucesso
        $msg = "Registro inserido com sucesso";
        $status = 'success';
        header("location: index.php?msg=$msg&status=$status");
        exit;
 
    }else{
        $msg= "Padrão errado do protocolo de comunicação. Informe o Suporte!";
        $status = 'fail';
        header("location: index.php?msg=$msg&status=$status");
        exit;
    }
 
 
?>