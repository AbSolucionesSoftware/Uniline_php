<?php
session_start();
require_once '../Modelos/Conexion.php';
include '../Modelos/Archivos.php';
include '../Modelos/Fecha.php';


if(isset($_POST['calificacio_curso_usuarion'])){
    $conexion = new Modelos\Conexion();
    echo $conexion->consultaPreparada(
        array("",$_SESSION['idcurso'],$_POST['calificacio_curso_usuarion'],$_SESSION['idusuario'],$_POST['cometareio']),
        "INSERT INTO calificacion (idcalificacion,curso,calificacion,usuario,comentario) VALUES(?,?,?,?,?)",
         1,"iiiis",false, null);
}

if (isset($_POST["id_cometario"])) {
    $conexion = new Modelos\Conexion();
    $consulta_comentario = "SELECT u.imagen,u.nombre,c.comentario FROM comentarios c 
    INNER JOIN usuario u ON u.idusuario = c.usuario
    WHERE c.idComentario = ?";
    $datos_camentario = array($_POST["id_cometario"]);
    echo json_encode($conexion->consultaPreparada($datos_camentario, $consulta_comentario, 2, "i", false, null));
}

if (isset($_POST['mostrarCursos'])) {
    $conexion = new Modelos\Conexion();
    $consulta = "SELECT * FROM curso WHERE idcurso = ?";
    $datos = array($_SESSION['idcurso']);
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "i", false, null));
}

if (isset($_POST['datos_lista'])) {
    $conexion = new Modelos\Conexion();
    // consulta que trae los bloques del curso  
    $consulta_bloque_curso = "SELECT b.idbloque,b.nombre FROM bloque b WHERE b.curso = ?";
    $datos_bloques = array($_SESSION['idcurso']);
    $datos_consulta_bloque = $conexion->consultaPreparada($datos_bloques, $consulta_bloque_curso, 2, "i", false, null);

    $array_datos_examen = array();
    $array_datos_temas = array();
    $array_datos_tarea = array();
    $array_datos_total_examen_curso = array();

    for ($i = 0; $i < count($datos_consulta_bloque); $i++) {

        // <<< consulta que trae los Examenenes del curso y si el usuario ya lo contesto  >>> 
        $consulta_examen_bloque = "SELECT a.idexamen,a.nombre,a.descripcion,b.calificacion,case when b.examen is null then 0 else 1 end as examenes_realizados 
        FROM examen a LEFT JOIN (SELECT * FROM examen_completado tm WHERE tm.usuario = ?) b on a.idexamen = b.examen INNER JOIN bloque c ON c.idbloque = a.bloque 
        WHERE c.curso = ? AND a.bloque = ?";
        $datos_examen = array($_SESSION['idusuario'], $_SESSION['idcurso'], $datos_consulta_bloque[$i][0]);
        $array_temporales_examen = $conexion->consultaPreparada($datos_examen, $consulta_examen_bloque, 2, "iis", false, null);
        //echo json_encode($array_temporales_examen); 

        // <<< consulta que trae los temas del curso del usuario  >>> 
        $datos_consulta_temas = array($_SESSION['idusuario'], $datos_consulta_bloque[$i][0], $_SESSION['idcurso']);
        $consulta_temas_bloque = "SELECT a.idtema,a.nombre,a.descripcion,a.video,a.archivo,case when b.tema is null then 0 else 1 end as temas_vistos 
        FROM tema a LEFT JOIN (SELECT * FROM tema_completado tm WHERE tm.usuario = ?) b on a.idtema = b.tema 
        INNER JOIN bloque c ON c.idbloque = a.bloque
        WHERE a.bloque = ? AND c.curso = ? ORDER BY preferencia";
        $array_temporales_temas = $conexion->consultaPreparada($datos_consulta_temas, $consulta_temas_bloque, 2, "isi", false, null);

        // <<< consulta que trae las tareas del curso>>> 
        $consulta_tarea_curso = "SELECT * FROM tarea WHERE bloque = ?";
        $bloque_actual = array($datos_consulta_bloque[$i][0]);
        $array_datos_tarea = $conexion->consultaPreparada($bloque_actual, $consulta_tarea_curso, 2, "i", false, null);

        // echo count($datos_consulta_bloque[$i])+2;
        // Funcion que restructur el arreglo final donde llevara toda oa infomacion
        for ($y = 0; $y < count($datos_consulta_bloque[$i]) + 3; $y++) {
            if ($y == 0) {
                //Metemos el examen en la pocicion 0
                $array_datos_exame[$y] = $array_temporales_examen[$y];
            } else if ($y == count($datos_consulta_bloque[$i]) + 1) {
                //Metemos los temas del examen en la penultima posicion del arreglo
                $array_datos_exame[$y] = $array_temporales_temas;
            } else if ($y == count($datos_consulta_bloque[$i]) + 2) {
                //Metemos las tareas en la ultima posicion del arreglo
                $array_datos_exame[$y] = $array_datos_tarea;
            } else {
                //Metemos la demas infomacion del bloque
                $array_datos_exame[$y] = $datos_consulta_bloque[$i][$y - 1];
            }
        }
        //Le damos a un array global que llevara el bloque ya estructurado para mostrar en el frente
        $array_datos_total_examen_curso[$i] = $array_datos_exame;
    }
    //Imprimimos el array con los bloques estructurados
    echo json_encode($array_datos_total_examen_curso);
}

if (isset($_POST['examenBLoques'])) {
    $conexion = new Modelos\Conexion();
    $datos_examen = array($_POST['examenBLoques']);
    $consulta_examen_bloque = "SELECT e.descripcion,p.idpregunta,p.pregunta,p.respuestas,p.respuesta_correcta 
    FROM pregunta p INNER JOIN examen e ON e.idexamen = p.examen WHERE p.examen = ?";
    echo json_encode($conexion->consultaPreparada($datos_examen, $consulta_examen_bloque, 2, "i", false, null));
}

if (isset($_POST['DatosTemaAcutual'])) {
    $conexion = new Modelos\Conexion();
    $datos_tema = array($_POST['DatosTemaAcutual']);
    $consulta = "SELECT t.video,t.nombre,t.descripcion,t.archivo FROM tema t WHERE t.idtema = ?";
    echo json_encode($conexion->consultaPreparada($datos_tema, $consulta, 2, "i", false, null));
}

if (isset($_POST['temaCompleto'])) {
    $conexion = new Modelos\Conexion();
    $datos_tema = array($_POST['temaCompleto'], $_SESSION['idusuario']);
    $consulta = "INSERT INTO tema_completado (tema,usuario) VALUES (?,?)";
    echo $conexion->consultaPreparada($datos_tema, $consulta, 1, "ii", false, null);
}

if (isset($_POST['respuestaExamen'])) {
    $conexion = new Modelos\Conexion();
    //echo $_POST['respuestaExamen'];
    $respuestas_usuario = explode("$", $_POST['respuestas_examen']);
    $id_preguntas = explode("$", $_POST['preguntas_id']);
    var_dump($id_preguntas);
    var_dump($respuestas_usuario);
    $consulta = "INSERT INTO respuesta_usuario (idpregunta,usuario,respuesta) VALUES (?,?,?)";
    for ($i = 1; $i < count($respuestas_usuario); $i++) {
        $datos = array($id_preguntas[$i], $_SESSION['idusuario'], $respuestas_usuario[$i]);
        $result = $conexion->consultaPreparada($datos, $consulta, 1, "iis", false, null);
    }
    if ($result == 1) {
        $dato = array($id_preguntas[1]);
        $consulta_extraer_idexamen = "SELECT examen FROM pregunta WHERE idpregunta = ?";
        $result2 = $conexion->consultaPreparada($dato, $consulta_extraer_idexamen, 2, "i", false, null);
        if ($result2[0][0] != '') {
            $consulta_insert_examen = "INSERT INTO examen_completado (examen,usuario,calificacion) VALUES(?,?,?)";
            $datos = array($result2[0][0], $_SESSION['idusuario'], $_POST['puntaje_alumno']);
            $result = $conexion->consultaPreparada($datos, $consulta_insert_examen, 1, "iii", false, null);
        }
    }
    echo  $result;
}

if (isset($_POST['archivo'])) {
    $conexion = new Modelos\Conexion();
    $datos_verificacion = array($_SESSION['idusuario'], $_POST['bloque-tarea']);
    $consulta_verificacion = "SELECT tm.id,tm.archivo FROM tarea_completada tm INNER JOIN tarea t ON t.idtarea = tm.tarea
    INNER JOIN bloque b ON b.idbloque = t.bloque WHERE tm.usuario = ? AND b.idbloque = ?";
    $result = json_encode($conexion->consultaPreparada($datos_verificacion, $consulta_verificacion, 2, "ii", false, null));

    if ($result == "[]") {
        if (strlen($_FILES['Fimagen']['tmp_name']) != 0) {
            $archivo = subir_archivo('Fimagen', 2);
            if ($archivo != "error") {
                $consulta = "INSERT INTO tarea_completada(id,tarea,usuario,archivo) VALUES (?,?,?,?)";
                $nada = "";
                $datos = array($nada, $_POST['tarea'], $_SESSION['idusuario'], $archivo);
                echo $conexion->consultaPreparada($datos, $consulta, 1, "iiis", false, null);
            } else {
                echo 0;
            }
        }
    } else {
        if (strlen($_FILES['Fimagen']['tmp_name']) != 0) {
            $archivo = subir_archivo('Fimagen', 2);
            if ($archivo != "error") {
                $nomas = json_decode($result);
                $datos = array($archivo, $nomas[0][0]);
                $consulta_update = "UPDATE tarea_completada SET archivo = ? WHERE id = ?";
                $very = $conexion->consultaPreparada($datos, $consulta_update, 1, "si", false, null);
                if ($very == 1) {
                    unlink($nomas[0][1]);
                    echo $very;
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
        }
    }
}

if (isset($_POST['tabla-bloque'])) {
    $conexion = new Modelos\Conexion();
    $consulta = "SELECT u.imagen,tm.archivo,tm.id FROM tarea_completada tm INNER JOIN tarea t ON t.idtarea = tm.tarea
    INNER JOIN usuario u ON u.idusuario = tm.usuario 
    WHERE tm.usuario = ? AND t.bloque = ?";
    $datos_verificacion = array($_SESSION['idusuario'], $_POST['tabla-bloque']);
    echo json_encode($conexion->consultaPreparada($datos_verificacion, $consulta, 2, "ii", false, null));
}

if (isset($_POST['tabla_tareas_bloque'])) {
    /*     $consulta = "SELECT c.calificacion FROM comentarios c 
    INNER JOIN tarea_completada tm ON tm.id = c.id_relacion WHERE tm.usuario = 1"; */
    $conexion = new Modelos\Conexion();
    $consulta_temas = "SELECT u.idusuario,u.imagen,tm.archivo,tm.id FROM tarea_completada tm INNER JOIN tarea t ON t.idtarea = tm.tarea
    INNER JOIN usuario u ON u.idusuario = tm.usuario WHERE t.bloque = ?";
    $datos = array($_POST['tabla_tareas_bloque']);
    $tareas_bloque = $conexion->consultaPreparada($datos, $consulta_temas, 2, "i", false, null);

    $consulta_calificacion = "SELECT SUM(c.calificacion) / COUNT(c.calificacion) AS calificacion FROM comentarios c 
    INNER JOIN tarea_completada tm ON tm.id = c.id_relacion INNER JOIN tarea t ON t.idtarea = tm.tarea
    WHERE tm.usuario = ? AND t.bloque = ?";

    $calificacion_total = "SELECT c.calificacion,c.idComentario AS calificacion FROM comentarios c 
    INNER JOIN tarea_completada tm ON tm.id = c.id_relacion
    INNER JOIN tarea t ON t.idtarea = tm.tarea 
    WHERE tm.usuario = ? AND t.bloque = ?";

    $cali_temporal = 0;
    $array_final_1 = array();
    $array_final_2 = array();
    //echo json_encode($tareas_bloque);

    for ($i = 0; $i < count($tareas_bloque); $i++) {
        $datos_calificacion_bloque = array($tareas_bloque[$i][0], $_POST['tabla_tareas_bloque']);
        $calificaion = $conexion->consultaPreparada($datos_calificacion_bloque, $consulta_calificacion, 2, "ii", false, null);
        $cali_temporal = round($calificaion[0][0]);
        $cali_total = $conexion->consultaPreparada($datos_calificacion_bloque, $calificacion_total, 2, "ii", false, null);

        for ($y = 1; $y < count($tareas_bloque[$i]) + 3; $y++) {
            if ($y == 4) {
                $array_final_1[$y - 1] = $cali_total;
            } else if ($y == 5) {
                $array_final_1[$y - 1] = $cali_temporal;
            } else if ($y < 5) {
                $array_final_1[$y - 1] = $tareas_bloque[$i][$y - 1];
            } else if ($y > 5) {
                $array_final_1[$y - 1] = $tareas_bloque[$i][$y - 3];
            }
        }
        $array_final_2[$i] = $array_final_1;
    }
    echo json_encode($array_final_2);
}

if (isset($_POST['id_calificar_tarea'])) {
    $conexion = new Modelos\Conexion();
    $datos = array(NULL, $_POST['id_calificar_tarea'], $_SESSION['idusuario'], $_POST['comentario'], $_POST['valor_estrellas']);
    $consulta = "INSERT INTO comentarios (idComentario,id_relacion,usuario,comentario,calificacion) VALUES(?,?,?,?,?)";
    echo $conexion->consultaPreparada($datos, $consulta, 1, "iiisi", false, null);
}

if (isset($_POST['registro-coment'])) {
    $conexion = new Modelos\Conexion();
    $fecha = new Modelos\Fecha();
    $consulta = "INSERT INTO comentarios (idComentario,id_relacion,usuario,comentario,fecha,hora) VALUES(?,?,?,?,?,?)";
    $datos = array(null, $_SESSION['idcurso'], $_SESSION['idusuario'], $_POST['registro-coment'], $fecha->getFecha(), $fecha->getHora());
    echo $conexion->consultaPreparada($datos, $consulta, 1, "iiisss", false, null);
}

if (isset($_POST['comentariosCurso'])) {
    $conexion = new Modelos\Conexion();
    $consulta = "SELECT u.nombre,c.comentario,c.hora,c.fecha FROM comentarios c 
    INNER JOIN usuario u ON u.idusuario = c.usuario WHERE c.id_relacion = ?";
    $datos = array($_SESSION['idcurso']);
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "i", false, null));
}

if (isset($_POST['confeti'])) {

    $conexion = new Modelos\Conexion();
    $datos_tema = array($_SESSION['idcurso']);
    $cosulta_temas_curso = "SELECT COUNT(idtema) AS cantidadTemas FROM tema t 
                                  INNER JOIN bloque b ON t.bloque = b.idbloque WHERE b.curso = ?";
    $result = $conexion->consultaPreparada($datos_tema, $cosulta_temas_curso, 2, "i", false, null);

    $temas_curso = $result[0][0];

    $consulta_temas_alumno = "SELECT COUNT(tema) FROM tema_completado tm 
                                  INNER JOIN tema t ON t.idtema = tm.tema 
                                  INNER JOIN bloque b ON b.idbloque = t.bloque WHERE b.curso = ? AND tm.usuario = ?";
    $datos_temas_vistos = array($_SESSION['idcurso'], $_SESSION['idusuario']);

    $result2 = $conexion->consultaPreparada($datos_temas_vistos, $consulta_temas_alumno, 2, "ii", false, null);
    $temas_vistos = $result2[0][0];

    if($temas_curso == $temas_vistos){
        echo "completado";
    }
}
