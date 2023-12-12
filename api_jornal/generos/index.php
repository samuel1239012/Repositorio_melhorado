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
                
                $sql = "SELECT pk_id, tipo_genero
                        FROM generos";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $dados = $stmt->fetchall(PDO::FETCH_OBJ);

                $result["generos"]=$dados;
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

                $sql= "SELECT pk_id, tipo_genero
                        FROM generos
                        WHERE pk_id=:id";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                $dado = $stmt->fetch(PDO::FETCH_OBJ);
                $result['generos'] = $dado;
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
      
       
        $tipo_genero = trim($dados->tipo_genero); // acessa valor de um OBJETO
        
        try {
            

            if(empty($dados->tipo_genero) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor da tipo_genero é inválido", 1);
            }
            
            
            $sql = "INSERT INTO generos(tipo_genero) 
                    VALUES (:tipo_genero)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":tipo_genero", $tipo_genero);
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

            if(empty($dados->tipo_genero) ){
                // está vazio  : ERRO
                throw new ErrorException("Tipo_genero é um campo obrigatório", 1);
            }
            
           
         
           // função trim retira espaços que estão sobrando
        
           $id = trim($dados->id); // acessa valor de um OBJETO
           $tipo_genero = trim($dados->tipo_genero);

           
            $sql = "UPDATE generos SET tipo_genero=:tipo_genero 
                    WHERE pk_id=:id";

          
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":tipo_genero", $tipo_genero);
            $stmt->bindParam(":id", $id);
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

        $sql= "DELETE FROM generos
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