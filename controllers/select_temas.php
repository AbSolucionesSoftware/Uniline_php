<?php 
require_once '../Modelos/Conexion.php';

$conexion = New Modelos\Conexion();
$bloque = $_GET['bloque'];
$query = "SELECT * FROM tema WHERE bloque = ?";

$temas = $conexion->consultaPreparada(
   array($bloque),
   $query,
   2,
   "s",
   false,
   null
);

if($temas) {
   echo json_encode($temas);
}else {
   echo 0;
}
?>