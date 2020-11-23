<?php
require_once '../Modelos/Conexion.php';
 $conexion = new Modelos\Conexion();
 $conulta = "UPDATE pregunta SET respuestas = 'local mente,#De internet,De steam,Solo de descarga' WHERE idpregunta = ?";

 for($i = 1; $i <= 7; $i++){
    $datos = array($i);
    echo $conexion->consultaPreparada($datos,$conulta,1,"i",false,null);
 }
