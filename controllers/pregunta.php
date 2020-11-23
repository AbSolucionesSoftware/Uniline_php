<?php
session_start();
require_once '../Modelos/Conexion.php';

if (!empty($_POST['accion'])) {

    $conexion = new Modelos\Conexion();

    switch ($_POST['accion']) {

        case "insertar":
            if (isset($_POST['idpregunta']) && !empty($_POST['TPregunta']) && !empty($_POST['respuestas']) && !empty($_SESSION['idexamen'])) {
                    echo $conexion->consultaPreparada(
                    array($_POST['idpregunta'], $_POST['TPregunta'], $_POST['respuestas'], $_SESSION['idexamen']),
                    "INSERT INTO pregunta (idpregunta,pregunta,respuestas,examen) VALUES (?,?,?,?)",
                    1,
                    "ssss",
                    false,
                    2
                );
            } else {
                echo "los post no estan llegando correctamente";
            }
            break;

        case "editar":
            if (isset($_POST['idpregunta']) && !empty($_POST['TPregunta']) && !empty($_POST['respuestas']) && !empty($_SESSION['idexamen'])) {
               echo $conexion->consultaPreparada(
                    array($_POST['idpregunta'], $_POST['TPregunta'], $_POST['respuestas'], $_SESSION['idexamen']),
                    "UPDATE pregunta SET pregunta = ?, respuestas = ?, examen = ? WHERE idpregunta = ? ",
                    1,
                    "ssss",
                    true, // se reestructira la fila se cambia el id que esta en la primera columna hacia la ultima para que el bind de las variables en la consulta coincida
                    null
                );
            } else {
                echo "los post no estan llegando correctamente";
            }
            break;

        case "items":
            echo json_encode($conexion->consultaPreparada(
                array($_SESSION['idbloque']),
                "SELECT idexamen,examen.nombre FROM examen INNER JOIN bloque ON bloque = idbloque WHERE bloque = ?",
                2,
                "s",
                false,
                null
            ));
            break;

        case 'tabla':
            echo json_encode($conexion->consultaPreparada(
                array($_SESSION['idbloque']),
                "SELECT idpregunta,pregunta,respuestas,examen FROM pregunta p 
                INNER JOIN examen e ON e.idexamen = p.examen WHERE e.bloque = ?",
                2,
                "s",
                false,
                null
            ));
            
            $datos = $conexion->consultaPreparada(array($_SESSION['idbloque']),
            "SELECT idexamen FROM examen INNER JOIN bloque ON bloque = idbloque WHERE bloque = ?",
            2,
            "s",
            false,
            null
            );
            if($datos == null){
                echo '';
            }else{
               $_SESSION['idexamen'] = $datos[0][0]; 
            }
            
            break;

        default:
            echo "El tipo de accion no existe";
            break;
    }
}
