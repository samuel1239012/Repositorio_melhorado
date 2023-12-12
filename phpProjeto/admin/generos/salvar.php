<?php
  include("../validar_sessao.php");
 
    if (!empty($_POST)){
       
       
       
        // Move o arquivo da pasta temporaria de upload para a pasta de destino
       
 
        if(empty($_POST["tipo_genero"])){
            $msg= "Campo Tipo Genero obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
   
       
 
 
        // endpoint da API
        $end_point = "http://localhost/api_jornal/generos/";
 
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
       
        $tipo_genero = $_POST["tipo_genero"];
       
        $post_body = json_encode([
            'id' => $id,
            'tipo_genero'=> $tipo_genero,
           
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