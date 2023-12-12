<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $method = $_SERVER["REQUEST_METHOD"];
    include("../connection/connection.php");

    if($method == "GET"){
        //echo "GET";

        if (!isset($_GET["id"])){

            // listar todos os registros
            try {
                
                $sql = "SELECT pk_id, palavra_chave, texto, titulo, sub_titulo, data_postagem, imagem 
                        FROM noticia";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $dados = $stmt->fetchall(PDO::FETCH_OBJ);

                $result["noticia"]=$dados;
                $result["status"] = "success";

                http_response_code(200);

            } catch (PDOException $ex) {
                // echo "error: ". $ex->getMEssage();
                $result =["status"=> "fail", "error"=> $ex->getMEssage()];
                http_response_code(200);
            }finally{
                $conn = null;
                echo json_encode($result);
            }
        }else{
            // listar um registro
            try{

                if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
                    // está vazio ou não é numérico : ERRO
                    throw new ErrorException("Valor inválido", 1);
                }
                $id = $_GET["id"];

                $sql= "SELECT pk_id, palavra_chave, texto, titulo, sub_titulo, data_postagem, imagem 
                        FROM noticia
                        WHERE pk_id=:id";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                $dado = $stmt->fetch(PDO::FETCH_OBJ);
                $result['noticia'] = $dado;
                $result["status"] = "success";

            }catch(PDOException $ex){
                $result =["status"=> "fail", "error"=> $ex->getMEssage()];
                http_response_code(200);
            }catch(Exception $ex){
                $result =["status"=> "fail", "error"=> $ex->getMEssage()];
                http_response_code(200);
            }finally{
                $conn = null;
                echo json_encode($result);
            }
            
        }

       
    }
    if($method=="POST"){
       
        // recupera dados do corpo (body) de uma requisão POST
        $dados = file_get_contents("php://input");

        // decodifica JSON, sem opção TRUE
        $dados = json_decode($dados); // isso retorna um OBJETO

        // função trim retira espaços que estão sobrando
      
       
        $palavra_chave = trim($dados->palavra_chave); // acessa valor de um OBJETO
        $texto= trim($dados->texto); // acessa valor de um OBJETO
        $titulo= trim($dados->titulo); // acessa valor de um OBJETO
        $sub_titulo = trim($dados->sub_titulo); // acessa valor de um OBJETO
        $imagem = trim($dados->imagem); // acessa valor de um OBJETO
        
        try {
            

            if(empty($dados->palavra_chave) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor da palavra_chave é inválido", 1);
            }
            
            if(empty($dados->texto) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor do texto é inválido", 1);
            }

            if(empty($dados->titulo) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor do titulo é inválido", 1);
            }

            if(empty($dados->sub_titulo) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor do sub_titulo é inválido", 1);
            }
            if(empty($dados->imagem) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor da imagem é inválido", 1);
            }
            
            $sql = "INSERT INTO noticia(palavra_chave, texto, titulo, sub_titulo, data_postagem, imagem) 
                    VALUES (:palavra_chave, :texto, :titulo, :sub_titulo, now(), :imagem)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":palavra_chave", $palavra_chave);
            $stmt->bindParam(":texto", $texto);
            $stmt->bindParam(":titulo", $titulo);
            $stmt->bindParam(":sub_titulo", $sub_titulo);
            $stmt->bindParam(":imagem", $imagem);
            $stmt->execute();

            $result = array("status"=>"success");




        } catch (PDOException $ex) {
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
            http_response_code(200);
        }catch(Exception $ex){
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
            http_response_code(200);
        }finally{
            $conn = null;
            echo json_encode($result);
        }



    }
    if($method=="PUT"){
        // recupera dados do corpo (body) de uma requisão PUT
        $dados = file_get_contents("php://input");

        // decodifica JSON, sem opção TRUE
        $dados = json_decode($dados); // isso retorna um OBJETO    
        
        try {

            if(empty($dados->id) ){
                // está vazio  : ERRO
                throw new ErrorException("ID é um campo obrigatório", 1);
            }

            if(empty($dados->palavra_chave) ){
                // está vazio  : ERRO
                throw new ErrorException("palavra_chave é um campo obrigatório", 1);
            }
            
            if(empty($dados->texto) ){
                // está vazio  : ERRO
                throw new ErrorException("texto é um campo obrigatório", 1);
            }

            if(empty($dados->titulo) ){
                // está vazio  : ERRO
                throw new ErrorException("titulo é um campo obrigatório", 1);
            }

            if(empty($dados->sub_titulo) ){
                // está vazio  : ERRO
                throw new ErrorException("sub_titulo é um campo obrigatório", 1);
            }
            if(empty($dados->imagem) ){
                // está vazio  : ERRO
                throw new ErrorException("imagem é um campo obrigatório", 1);
            }
         
           // função trim retira espaços que estão sobrando
        
           $id = trim($dados->id); // acessa valor de um OBJETO
           $palavra_chave = trim($dados->palavra_chave);
           $texto = trim($dados->texto);
           $titulo = trim($dados->titulo);
           $sub_titulo = trim($dados->sub_titulo);
           $imagem = trim($dados->imagem);

           
            $sql = "UPDATE noticia SET palavra_chave=:palavra_chave, texto=:texto, 
                    titulo=:titulo, sub_titulo=:sub_titulo, data_postagem=now(), imagem=:imagem 
                    WHERE pk_id=:id";

          
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":titulo", $titulo);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":palavra_chave", $palavra_chave);
            $stmt->bindParam(":texto", $texto);
            $stmt->bindParam(":sub_titulo", $sub_titulo);
            $stmt->bindParam(":imagem", $imagem);
            $stmt->execute();

            $result = array("status"=>"success");

        } catch (PDOException $ex) {
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
            http_response_code(200);
        }catch(Exception $ex){
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
            http_response_code(200);
        }finally{
            $conn = null;
            echo json_encode($result);
        }
   }
   if($method=="DELETE"){
    try{

        if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
            // está vazio ou não é numérico : ERRO
            throw new ErrorException("Valor inválido", 1);
        }
        $id = $_GET["id"];

        $sql= "DELETE FROM noticia
                WHERE pk_id=:id";
       
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

   
        $result["status"] = "success";

    }catch(PDOException $ex){
        $result =["status"=> "fail", "error"=> $ex->getMEssage()];
        http_response_code(200);
    }catch(Exception $ex){
        $result =["status"=> "fail", "error"=> $ex->getMEssage()];
        http_response_code(200);
    }finally{
        $conn = null;
        echo json_encode($result);
    }



}







?>