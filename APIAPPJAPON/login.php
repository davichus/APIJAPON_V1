<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['nomloginUsuario']) && isset($_GET['contraseniaUsario']))
    {
      //Mostrar un post

      $sql = $dbConn->prepare("SELECT * from tblUsuario where nomloginUsuario=:nomloginUsuario or correoUsuario=:nomloginUsuario and contraseniaUsario =:contraseniaUsario");
      //$hashedPassword = hash('sha256', $_GET['contrasenia_usuario']);  
      $sql->bindValue(':nomloginUsuario', $_GET['nomloginUsuario']);
     // $sql->bindValue(':contrasenia_usuario', $hashedPassword);
     $sql->bindValue(':contraseniaUsario', $_GET['contraseniaUsario']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      //echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      echo json_encode( $sql->fetchAll()  );
      exit();
	  }

	  else {
      //Mostrar lista de post
      //$sql = $dbConn->prepare("SELECT * FROM tblUsuario");
      //$sql->execute();
      //$sql->setFetchMode(PDO::FETCH_ASSOC);
      //header("HTTP/1.1 200 OK");
      //echo json_encode( $sql->fetchAll()  );
      //exit();
       // Devolver mensaje de error
       header("HTTP/1.1 400 Bad Request");
       echo json_encode(array("message" => "Por favor, ingrese todos los parámetros necesarios (nomloginUsuario y contraseniaUsario)."));
       exit();
	}
}
?>