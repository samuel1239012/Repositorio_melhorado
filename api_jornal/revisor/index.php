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
               
                $sql = "SELECT pk_id, nome, salario, telefone, cpf
                        FROM revisor";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
 
                $dados = $stmt->fetchall(PDO::FETCH_OBJ);
 
                $result["revisor"]=$dados;
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
 
                $sql= "SELECT pk_id, nome, salario, telefone, cpf
                        FROM revisor
                        WHERE pk_id=:id";
               
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
 
                $dado = $stmt->fetch(PDO::FETCH_OBJ);
                $result['revisor'] = $dado;
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
     
       
        $nome = trim($dados->nome); // acessa valor de um OBJETO
        $salario= trim($dados->salario); // acessa valor de um OBJETO
        $telefone= trim($dados->telefone); // acessa valor de um OBJETO
        $cpf = trim($dados->cpf); // acessa valor de um OBJETO
       
        try {
           
 
            if(empty($dados->nome) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor  Nome é inválido", 1);
            }
           
            if(empty($dados->salario) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor  Salário é inválido", 1);
            }
 
            if(empty($dados->telefone) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor do Telefone é inválido", 1);
            }
 
            if(empty($dados->cpf) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor do CPF é inválido", 1);
            }
           
           
            $sql = "INSERT INTO revisor(nome, salario, telefone, cpf)
                    VALUES (:nome, :salario , :telefone , :cpf )";
 
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":salario", $salario);
            $stmt->bindParam(":telefone", $telefone);
            $stmt->bindParam(":cpf", $cpf);
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
 
            if(empty($dados->nome) ){
                // está vazio  : ERRO
                throw new ErrorException("nome é um campo obrigatório", 1);
            }
           
            if(empty($dados->salario) ){
                // está vazio  : ERRO
                throw new ErrorException("salario é um campo obrigatório", 1);
            }
 
            if(empty($dados->telefone) ){
                // está vazio  : ERRO
                throw new ErrorException("telefone é um campo obrigatório", 1);
            }
 
            if(empty($dados->cpf) ){
                // está vazio  : ERRO
                throw new ErrorException("cpf é um campo obrigatório", 1);
            }
           
           // função trim retira espaços que estão sobrando
       
           $id = trim($dados->id); // acessa valor de um OBJETO
           $nome = trim($dados->nome);
           $salario = trim($dados->salario);
           $telefone = trim($dados->telefone);
           $cpf = trim($dados->cpf);
 
            $sql = "UPDATE revisor SET nome=:nome, salario=:salario,
                    telefone=:telefone, cpf=:cpf
                    WHERE pk_id=:id";
 
         
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":salario", $salario);
            $stmt->bindParam(":telefone", $telefone);
            $stmt->bindParam(":cpf", $cpf);
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
 
        $sql= "DELETE FROM revisor
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