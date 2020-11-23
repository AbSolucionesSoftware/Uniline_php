<?php 
require_once '../Modelos/Conexion.php';

$request = $_SERVER['REQUEST_METHOD'];
$conexion = new Modelos\Conexion();

switch($request) {

    case "POST":

            if(!isset($_POST['editar_bloque']) && !isset($_POST['eliminar'])){
                echo $conexion->consultaPreparada(
                    array($_POST['nombre_bloque'], $_POST['id_curso']),
                    "INSERT INTO bloque (nombre,curso) VALUES (?,?)",
                    1,
                    "ss",
                    false,
                    null
                );
            } else if($_POST['eliminar']){
                if($conexion->consultaPreparada(
                   array($_POST['id_eliminar']),
                   "DELETE bloque,tema,tema_completado,tarea,tarea_completada,evaluacion_tarea_completada,examen ,examen_completado,pregunta,respuesta_usuario
                    FROM bloque
                    LEFT JOIN tema ON idbloque = tema.bloque
                    LEFT JOIN tema_completado ON tema.idtema = tema_completado.tema
                    LEFT JOIN tarea ON idbloque = tarea.bloque
                    LEFT JOIN tarea_completada ON tarea.idtarea = tarea_completada.tarea
                    LEFT JOIN evaluacion_tarea_completada ON tarea_completada.id= tarea_completada
                    LEFT JOIN examen ON idbloque = examen.bloque
                    LEFT JOIN examen_completado ON idexamen = examen_completado.examen
                    LEFT JOIN pregunta ON pregunta.examen = idexamen
                    LEFT JOIN respuesta_usuario ON pregunta.idpregunta = respuesta_usuario.idpregunta
                    WHERE idbloque = ?",
                    1,
                    "s",
                    false,
                    null
               )){
               echo "eliminado";
            }else {
                echo "error";
            }
          } else {
                echo $conexion->consultaPreparada(
                    array($_POST['id_bloque'], $_POST['nombre_bloque'], $_POST['id_curso']),
                    "UPDATE bloque SET nombre = ?, curso = ? WHERE idbloque = ? ",
                    1,
                    "sss",
                    true,
                    null
                );
            }
    break;

    case "GET":
        if(isset($_GET['bloque'])){
            $bloque = $conexion->consultaPreparada(
                array($_GET['bloque']),
                "SELECT nombre FROM bloque WHERE idbloque = ?",
                3,
                "s",
                false,
                null
            );

            echo json_encode($bloque);
        }
    break;
}

?>