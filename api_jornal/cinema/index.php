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
               
                $sql = "SELECT pk_id, titulo, sinopse, elenco, imagem
                        FROM cinema";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
 
                $dados = $stmt->fetchall(PDO::FETCH_OBJ);
 
                $result["cinema"]=$dados;
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
 
                $sql= "SELECT pk_id, titulo, elenco, sinopse, imagem
                        FROM cinema
                        WHERE pk_id=:id";
               
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
 
                $dado = $stmt->fetch(PDO::FETCH_OBJ);
                $result['cinema'] = $dado;
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
     
       
        $titulo = trim($dados->titulo); // acessa valor de um OBJETO
        $sinopse= trim($dados->sinopse); // acessa valor de um OBJETO
        $elenco= trim($dados->elenco); // acessa valor de um OBJETO
        $imagem = trim($dados->imagem); // acessa valor de um OBJETO
       
        try {
           
 
            if(empty($dados->titulo) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor da titulo é inválido", 1);
            }
           
            if(empty($dados->sinopse) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor da sinopse é inválido", 1);
            }
 
            if(empty($dados->elenco) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor do elenco é inválido", 1);
            }
 
            if(empty($dados->imagem) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor da imagem é inválido", 1);
            }
           
            $sql = "INSERT INTO cinema(titulo, sinopse, elenco, imagem)
                    VALUES (:titulo, :sinopse, :elenco,:imagem)";
 
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":titulo", $titulo);
            $stmt->bindParam(":sinopse", $sinopse);
            $stmt->bindParam(":elenco", $elenco);
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
 
            if(empty($dados->titulo) ){
                // está vazio  : ERRO
                throw new ErrorException("titulo é um campo obrigatório", 1);
            }
           
            if(empty($dados->sinopse) ){
                // está vazio  : ERRO
                throw new ErrorException("sinopse é um campo obrigatório", 1);
            }
 
            if(empty($dados->elenco) ){
                // está vazio  : ERRO
                throw new ErrorException("elenco é um campo obrigatório", 1);
            }
 
            if(empty($dados->imagem) ){
                // está vazio  : ERRO
                throw new ErrorException("imagem é um campo obrigatório", 1);
            }
         
           // função trim retira espaços que estão sobrando
       
           $id = trim($dados->id); // acessa valor de um OBJETO
           $titulo = trim($dados->titulo);
           $sinopse = trim($dados->sinopse);
           $elenco = trim($dados->elenco);
           $imagem = trim($dados->imagem);
 
           
            $sql = "UPDATE cinema SET titulo=:titulo, sinopse=:sinopse,
                    elenco=:elenco, imagem=:imagem
                    WHERE pk_id=:id";
 
         
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":titulo", $titulo);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":sinopse", $sinopse);
            $stmt->bindParam(":elenco", $elenco);
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
 
        $sql= "DELETE FROM cinema
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