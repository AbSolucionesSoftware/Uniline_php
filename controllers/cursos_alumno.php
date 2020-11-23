<?php
use Modelos\Conexion;
session_start();
require_once '../Modelos/Conexion.php';

$conexion = new Modelos\Conexion();

$consulta = "SELECT i.alumno, i.curso, c.idcurso, c.nombre, c.descripcion, c.imagen
FROM inscripcion i INNER JOIN curso c ON i.curso = c.idcurso WHERE i.alumno = ?";
$datos = array($_SESSION['idusuario']);
$resultado = json_encode($conexion->consultaPreparada($datos,$consulta,2,'i', false, null));

if($resultado != "[]"){   
    echo $resultado;
}else{
    echo "sin-alumnos";
}


?>