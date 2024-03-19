<?php
include "config.php";
include "utils.php";
$dbConn =  connect($db);
// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['idRol']))
    {
      //Mostrar un post
      $idRol = $_GET['idRol'];
      $sql = $dbConn->prepare("SELECT * from tblRol where idRol =:idRol");
      $sql->bindValue(':idRol', $idRol);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
   
	  }

	  else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM tblRol");
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
                  tblRol(idRol, 
                         descripcionRol, 
                         estadoRol) 
           VALUES (NULL, 
           :descripcionRol, 
           :estadoRol)";
     $statement = $dbConn->prepare($sql);
     bindAllValues($statement, $input);
     $statement->execute();
     $postCodigo = $dbConn->lastInsertId();
     if($postCodigo)
     {
       $input['idRol'] = $postCodigo;
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
	$codigo = $_GET['idRol'];
  $statement = $dbConn->prepare("DELETE FROM  tblRol where idRol=:idRol");
  $statement->bindValue(':idRol', $codigo);
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
          UPDATE tblRol
          SET $fields
          WHERE idRol='$postCodigo'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}
?>