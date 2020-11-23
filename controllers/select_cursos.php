<?php 
session_start();
 require_once '../Modelos/Conexion.php';

$conexion = new Modelos\Conexion();

$consultar_cursos = "SELECT * FROM curso WHERE profesor = ?";
$id_profesor = array($_SESSION['idusuario']);
$resultado = $conexion->consultaPreparada($id_profesor,$consultar_cursos,2,'s', false, null);
session_write_close();

if($resultado){
  echo json_encode($resultado);
}else{
   echo false;
}

?>