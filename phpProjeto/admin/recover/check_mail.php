<?php 

    require_once("../conexao.php");

     $email = $_POST["email"];

        $sql = "SELECT e_mail, senha, pk_id, habilita FROM usuarios WHERE e_mail='$email'";
        $query = mysqli_query($conecta, $sql);

    if(mysqli_num_rows($query)== 0){
        echo "não existe esse e-mail";
        // redirecionar para login
        exit;

    }

    date_default_timezone_set('America/Sao_Paulo');

    echo "e-mail valido";
    $row = mysqli_fetch_object($query);
    $senha = $row->senha;
    $pk_id = $row->pk_id;
    $habilita = $row->habilita;
    $data = date('d/m/Y H:i:s');

    echo "<br>" . $codigo_temp =$email . $senha . $pk_id . $data;

    echo "<br>" . $codigo_temp = hash('sha512', $codigo_temp);

    $nome = "SENAC";
    echo'<hr>';
    // echo "<br>" . substr($codigo_temp, 0);

    echo "<br>" . substr($codigo_temp, 0, 4);
    echo "<br>" . substr($codigo_temp, -4);
    echo "<br>";
    echo $codigo = substr($codigo_temp, 0, 4).substr($codigo_temp, -4, 4);

    echo $sql="UPDATE usuarios SET recuperar_senha='$codigo' WHERE pk_id=$pk_id"; 

    mysqli_query($conecta, $sql);

        require_once("../../vendor/plugins/PHPMailer/src/PHPMailer.php");
        require_once("../../vendor/plugins/PHPMailer/src/SMTP.php");
        require_once("../../vendor/plugins/PHPMailer/src/Exception.php");



//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.glaucosantos.com.br';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ti_manha@glaucosantos.com.br';                 //SMTP username
    $mail->Password   = 'Senac2023';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('ti_manha@glaucosantos.com.br', 'TI Manhã'); //remetente
    $mail->addAddress($email, $nome);     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);   
    $mail->charset="UTF-8";                               //Set email format to HTML
    $mail->Subject = 'Recuperar senha';
    $mail->Body    = "Este é o seu código para recuperação de senha: $codigo";
    $mail->AltBody = "Este é o seu código para recuperação de senha: $codigo";

    $mail->send();
    // echo 'E-mail enviado com sucesso!';
    header("location: recover-password.php");
} catch (Exception $e) {
    echo "E-mail não pode ser enviado. Error: {$mail->ErrorInfo}";
}

?>