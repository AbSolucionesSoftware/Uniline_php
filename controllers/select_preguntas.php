<?php 
require_once '../Modelos/Conexion.php';

$conexion = New Modelos\Conexion();
$bloque = $_GET['bloque'];

if(isset($bloque)) {
    $id_examen = $conexion->consultaPreparada(
        array($bloque),
        "SELECT idexamen FROM examen WHERE bloque = ?",
        2,
        "s",
        false,
        null
    );

    if($id_examen) {
        $preguntas = $conexion->consultaPreparada(
            array($id_examen[0][0]),
            "SELECT idpregunta, pregunta FROM pregunta WHERE examen = ?",
            2,
            "s",
            false,
            null
        );

        if($preguntas){
            echo json_encode($preguntas);
        }else {
            echo 0;
        }
    } else {
        echo 0;
    }

}
?>