

<?php 

 require_once '../Modelos/Conexion.php';

$conexion = new Modelos\Conexion();

$consultar_bloques = "SELECT * FROM bloque WHERE curso = ?";
$id_curso = array($_GET['curso']);
$resultado = $conexion->consultaPreparada($id_curso,$consultar_bloques,2,'s', false, null);


if($resultado){
  echo json_encode($resultado);
}else{
   echo 0;
}

?>