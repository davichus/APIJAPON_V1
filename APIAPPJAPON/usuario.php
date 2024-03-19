<?php
include "config.php";
include "utils.php";
$dbConn =  connect($db);
// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['idUsuario']))
    {
      //Mostrar un post
      $idUsuario = $_GET['idUsuario'];
      $sql = $dbConn->prepare("SELECT * from tblUsuario where idUsuario =:idUsuario");
      $sql->bindValue(':idUsuario', $idUsuario);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
   
	  }

	  else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM tblUsuario");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	}
}

//INSERTAR
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
     $input = $_POST;
     $sql="INSERT INTO 
              tblUsuario(idUsuario, 
                         cedulaUsuario, 
                         nombresUsuario,
                         apellidosUsuarios,
                         correoUsuario,
                         nomloginUsuario,
                         contraseniaUsario,
                         idRol) 
           VALUES (NULL, 
           :cedulaUsuario, 
           :nombresUsuario,
           :apellidosUsuarios,
           :correoUsuario,
           :nomloginUsuario,
           :contraseniaUsario,
           :idRol)";
     $statement = $dbConn->prepare($sql);
     bindAllValues($statement, $input);
     $statement->execute();
     $postCodigo = $dbConn->lastInsertId();
     if($postCodigo)
     {
       $input['idUsuario'] = $postCodigo;
       header("HTTP/1.1 200 OK");
       echo json_encode($input);
       exit();
      }else{
        echo json_encode("ERROR");
      }
    
}
//Eliminar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	$codigo = $_GET['idUsuario'];
  $statement = $dbConn->prepare("DELETE FROM tblUsuario where idUsuario=:idUsuario");
  $statement->bindValue(':idUsuario', $codigo);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}
//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $postCodigo = $input['idRol'];
    $fields = getParams($input);

    $sql = "
          UPDATE tblUsuario
          SET $fields
          WHERE idUsuario='$postCodigo'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}
?>