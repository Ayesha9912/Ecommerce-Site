<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
if(isset($_POST['submit'])){
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Host       = 'smtp.gmail.com';  
    $mail->Username   = 'ayeshauni99@gmail.com';                     //SMTP username
    $mail->Password   = 'pyebqleksouvfbtw';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('ayeshauni99@gmail.com', 'Ayesha');      //Add a recipient
  

    

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Contcat Us Form';
    $mail->Body = '
    <h2>Name:'.$name.'</h2>;
    <h2>Email:'.$email.'</h2>;
    <h2>Message:'.$message.'</h2>;';

    if($mail->send()){
        $_SESSION['status'] = "Message Has Been Sent";
        header("Location:{$_SERVER["HTTP_REFERER"]}");
        exit(0);
    }else{
        $_SESSION['status'] = "Message Has not Been Sent";
        exit(0);
    }
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}else{
    echo 'Message Not sent';
    exit(0);
}