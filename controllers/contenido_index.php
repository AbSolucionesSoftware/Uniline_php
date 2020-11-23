<?php
session_start();
require_once '../Modelos/Conexion.php';

if(isset($_POST['cursos'])){
    $conexion = new Modelos\Conexion();
    $consuta = "SELECT c.idcurso,c.nombre,c.descripcion,c.imagen,c.calificacion,c.horas,u.nombre,u.imagen,c.costo
    FROM curso c INNER JOIN usuario u ON c.profesor = u.idusuario WHERE c.publicacion = ?";
    echo json_encode($conexion->consultaPreparada(array(1),$consuta,2,'s',false,null));
    
}

if(isset($_POST['cursos-modal'])){
    $conexion = new Modelos\Conexion();
    $data = array($_POST['cursos-modal']);
    $consuta = "SELECT c.idcurso,c.nombre,c.descripcion,c.calificacion,c.horas,u.nombre,u.imagen,c.costo,c.video
    FROM curso c INNER JOIN usuario u ON c.profesor = u.idusuario WHERE c.idcurso = ?";
    echo json_encode($conexion->consultaPreparada($data,$consuta,2,"i",false,null));
}

if(isset($_POST['cursos-contenido'])){
    $conexion = new Modelos\Conexion();
    $data = array($_POST['cursos-contenido']);
    $consuta = "SELECT * FROM bloque b WHERE b.curso = ?";
    echo json_encode($conexion->consultaPreparada($data,$consuta,2,"i",false,null));
}
if(isset($_POST['temas-bloque'])){
    $conexion = new Modelos\Conexion();
    $data = array($_POST['temas-bloque']);
    $consuta = "SELECT t.idtema,t.nombre FROM tema t WHERE t.bloque = ? ORDER BY preferencia asc";
    echo json_encode($conexion->consultaPreparada($data,$consuta,2,"i",false,null));
}
if(isset($_POST['cursos-descripcion'])){
    $conexion = new Modelos\Conexion();
    $data = array($_SESSION['idcurso']);
    $consuta = "SELECT c.idcurso,c.nombre,c.descripcion,c.imagen,c.calificacion,c.horas,u.nombre,u.imagen,c.costo,c.video, u.trabajo 
    FROM curso c INNER JOIN usuario u ON c.profesor = u.idusuario WHERE c.idcurso = ?";
    echo $resultado = json_encode($conexion->consultaPreparada($data,$consuta,2,"i",false,null));

    $result = json_decode($resultado);
    $exlpode = explode("/", $result[0][3]);
    $url = $exlpode[1] . "/res_" . $exlpode[2];
    $_SESSION['imagen_curso'] = $url;
    $_SESSION['nombre_curso'] = $result[0][1];
}