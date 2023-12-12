<?php
  include("../validar_sessao.php");

    if (!empty($_POST)){
        

        $arquivo = $_FILES["imagem"];

        // echo"<pre>";
        // var_dump($arquivo);
        // echo"</pre>";

        // exit;
        
        if(!empty($arquivo["name"])){
            
            $caminho_absoluto = $_SERVER["DOCUMENT_ROOT"].'\assets\img\noticia';
            $caminho_relativo = "assets/img/noticia/".$arquivo["name"];
                        
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


        if(empty($_POST["palavra_chave"])){
            $msg= "Campo palavra_chave obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
    

        if(empty($_POST["texto"])){
            $msg= "Campo texto obrigatório";
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
   
        

        if(empty($_POST["sub_titulo"])){
            $msg= "Campo sub_titulo obrigatório";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }
   



        // endpoint da API
        $end_point = "http://localhost/api_jornal/noticia/";

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
       $palavra_chave = $_POST["palavra_chave"];
        $texto = $_POST["texto"];
        $titulo = $_POST["titulo"];
        $sub_titulo = $_POST["sub_titulo"];
        
        
        $post_body = json_encode([
            'id' => $id,
            'palavra_chave'=> $palavra_chave,
            'texto'=> $texto,
            'titulo'=> $titulo,
            'sub_titulo'=>$sub_titulo,
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