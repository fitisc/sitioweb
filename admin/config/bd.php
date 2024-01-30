<?php

//conectarse a la bbdd
$host="localhost";
$bd="sitio_web";
$usuario="root";
$contrasenia="";

try{//crear una var que llame a pdo que se encarga de conectar a la bbdd
    $conexion= new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasenia );
    //if($conexion){ echo "Conectado al sistema";}
}catch(Exception $e){
    echo $e->getMessage();


}
?>