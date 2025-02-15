<?php
$db_name = 'mysql:host=localhost;dbname=store';
$user_name = 'root';
$user_password = '';
try{
    $conn = new PDO($db_name, $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //there are other modes too.like ERRMODE_SILENT->which is default and doesnot show any error while ERRMODE_WARNING ->show the error but it continu running script but ERRMODE_EXCEPTION is best in environment production it show error and does not execute the further code.

}catch(Exception $e){
    echo $e->getMessage();
}
?>