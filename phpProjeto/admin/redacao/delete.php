<?php
    include("../validar_sessao.php");
 
    if (isset($_GET['id']) && is_numeric($_GET['id'])){
        $id = $_GET["id"];
 
 
        // endpoint da API
        $end_point = "http://localhost/api_jornal/redacao/?id=$id";
 
        // Inicializa o CURL
        $curl = curl_init();
         
        // configurações do CURL
        curl_setopt_array($curl,[
            CURLOPT_URL => $end_point,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
 
        // envio do comando CURL e armazenamento da resposta
        $response = curl_exec($curl);
 
        // conersão do JSON para ARRAY
        $dado = json_decode($response, TRUE);
 
        // testar Retorno da API
        if ($dado["status"] == 'fail'){
            $msg = "Erro ao excluir o registro";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        };
 
        // tudo OK - inserido informação com sucesso
        $msg = "Registro excluido com sucesso";
        $status = 'success';
        header("location: index.php?msg=$msg&status=$status");
        exit;
 
    }else{ //se estiver vazio ira voltar para index
        $msg = "Valor inválido";
        $status = "fail";
        header("location: index.php?msg=$msg&status=$status");
        exit;
    }
 
 
?>