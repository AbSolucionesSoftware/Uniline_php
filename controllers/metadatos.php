<?php
require_once '../Modelos/Conexion.php';

$conexion = new Modelos\Conexion();
$data = array($_SESSION['idcurso']);
$consuta = "SELECT idcurso, nombre, imagen FROM curso  WHERE idcurso = ?";
$resultado = json_encode($conexion->consultaPreparada($data,$consuta,2,"i",false,null));

$result = json_decode($resultado);
$explode = explode("/", $result[0][2]);
$url = $explode[1] . "/res_" . $explode[2];

echo '
<title>'.$result[0][1].'</title>
<meta property="og:title" content="'.$result[0][1].'">
<meta property="og:description" content="Aprende en nuestra escuela en linea UNILINE.">
<meta property="og:image" content="https://www.escuelaalreves.com/'.$url.'">
<meta property="og:url" content="https://www.escuelaalreves.com/views/descripcioncursos.php?idcurso='.$result[0][0].'">

'


?>