<?php
    include("../connection/connection.php");


    $method = $_SERVER['REQUEST_METHOD'];

    // echo $method;

    if($method=="GET"){

        if (isset($_GET["email"]) && 
        isset($_GET["password"]) && 
        !empty($_GET["email"]) && 
        !empty($_GET["password"])) {
        
            $email = $_GET["email"];
            // $password = hash('sha256', $_GET["password"]);
            $password = $_GET["password"];
        
            try{
                $sql = "SELECT * FROM usuarios 
                    WHERE e_mail = :e_mail 
                    AND senha= :password 
                    AND habilita=1";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(":e_mail", $email);
                $stmt->bindParam(":password", $password);

                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!empty($row)){
                    echo json_encode(array("status"=>"success"));
                }else{
                    echo json_encode(array("status"=>"fail"));
                }

            }catch(PDOException $ex){
                die("ERROR: ". $ex->getMessage());
            }

        }else{
            // retornar erro (false)
            echo "erro falta informação";
        }
    }
    // FIM do GET


?>