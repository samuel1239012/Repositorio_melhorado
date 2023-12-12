<?php
  include("../validar_sessao.php");

    if (!empty($_POST)){
        

        $arquivo = $_FILES["imagem"];

        // echo"<pre>";
        // var_dump($arquivo);
        // echo"</pre>";

        // exit;
        
        if(!empty($arquivo["name"])){
            
            $caminho_absoluto = $_SERVER["DOCUMENT_ROOT"].'\assets\img\cinema';
            $caminho_relativo = "assets/img/cinema/".$arquivo["name"];
                        
            // Move o arquivo da pasta temporaria de upload para a pasta de destino 
            if (move_uploaded_file($arquivo["tmp_name"], $caminho_absoluto."/".$arquivo["name"])) { 
                echo "Arquivo enviado com sucesso!"; 
            } 
            else { 
                echo "Erro, o arquivo n&atilde;o pode ser enviado."; 
            }        
        }else{
            $msg= "Campo imagem obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
           
        }
    
        if(empty($_POST["elenco"])){
            $msg= "Campo elenco obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }

      
   
        
        if(empty($_POST["titulo"])){
            $msg= "Campo titulo obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
   
        

        if(empty($_POST["sinopse"])){
            $msg= "Campo sinopse obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
   



        // endpoint da API
        $end_point = "http://localhost/api_jornal/cinema/";

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
     
        $titulo = $_POST["titulo"];
        $sinopse = $_POST["sinopse"];
        $elenco = $_POST["elenco"];
        
        
        $post_body = json_encode([
            'id' => $id,
            'sinopse'=> $sinopse,
            'elenco'=> $elenco,
            'titulo'=> $titulo,
            'imagem'=> $caminho_relativo,
            
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