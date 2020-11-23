<?php
include '../Modelos/Archivos.php';
require_once '../Modelos/Conexion.php';
session_start();


if(isset($_POST['info-cursos'])){
    $conexion = new Modelos\Conexion();
    $consulta = "SELECT * FROM usuario WHERE tipo = 'Maestro'";
    echo json_encode($conexion->obtenerDatosDeTabla($consulta));
}

if(isset($_POST['SProfesor'])){
    $_SESSION['idusuario'] = $_POST['SProfesor'];
    echo $_SESSION['idusuario'];
}
if(isset($_POST['SCurso'])){
    $_SESSION['idcurso'] = $_POST['SCurso'];
    echo $_SESSION['idcurso'];
}
if(isset($_POST['SBloque'])){
    $_SESSION['idbloque'] = $_POST['SBloque'];
    echo $_SESSION['idbloque'];
}
if(isset($_POST['SExamen'])){
    $_SESSION['idexamen'] = $_POST['SExamen'];
    echo $_SESSION['idexamen'];
}

if(isset($_POST['info-profesores'])){
    $conexion = new Modelos\Conexion();
    $consulta = "SELECT * FROM usuario";
    $resultado = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $resultado;

}

?>