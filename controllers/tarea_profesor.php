<?php

require_once '../Modelos/Conexion.php';
include '../Modelos/Archivos.php';

$conexion = new Modelos\Conexion();
$request = $_SERVER['REQUEST_METHOD'];

switch ($request) {

   case "POST":

      if (!isset($_POST['editar_tarea']) && !isset($_POST['eliminar'])) {

         $bloque = $_POST['bloque'];

         if (isset($bloque)) {
            echo $conexion->consultaPreparada(
               array($_POST['nombre-tarea'], $_POST['descripcion-tarea'], subir_archivo('archivo-tarea'), $bloque),
               "INSERT INTO tarea (nombre, descripcion, archivo_bajada, bloque) VALUES(?,?,?,?)",
               1,
               "ssss",
               false,
               null
            );
         } else {
            echo 0;
         }
      } else if (!isset($_POST['editar_tarea']) && $_POST['eliminar']) {
         if ($conexion->consultaPreparada(
            array($_POST['id_eliminar']),
            "DELETE tarea,tarea_completada,evaluacion_tarea_completada
               FROM tarea
               LEFT JOIN tarea_completada ON tarea.idtarea = tarea_completada.tarea
               LEFT JOIN evaluacion_tarea_completada ON tarea_completada.id= tarea_completada
               WHERE idtarea = ?",
            1,
            "s",
            false,
            null
         )) {
            echo "eliminado";
         }
      } else {
         $bloque = $_POST['bloque'];
         $id_tarea = $conexion->consultaPreparada(
            array($bloque),
            "SELECT idtarea,archivo_bajada from tarea WHERE bloque = ?",
            2,
            "i",
            false, // se reestructira la fila se cambia el id que esta en la primera columna hacia la ultima para que el bind de las variables en la consulta coincida
            null
         );

         $ruta = subir_archivo('archivo-tarea-edit');
         
         if (!empty($id_tarea) && empty($ruta)) {
            $ruta = $id_tarea[0][1]; //si hay una archivo registrado en el sistema y si no hay una carga nueva de archivo optene el archivo existente registrado
         } else if (!empty($id_tarea) && !empty($ruta)) {
            unlink($id_tarea[0][1]);
         }

         echo $conexion->consultaPreparada(
            array($id_tarea[0][0], $_POST['nombre-tarea-edit'], $_POST['descripcion-tarea-edit'], $ruta, $bloque),
            "UPDATE tarea SET nombre = ?, descripcion = ?, archivo_bajada = ?, bloque = ? WHERE idtarea = ? ",
            1,
            "ssssi",
            true, // se reestructira la fila se cambia el id que esta en la primera columna hacia la ultima para que el bind de las variables en la consulta coincida
            null
         );
      }

      break;

   case "GET":
      $bloque = $_GET['bloque'];

      if (isset($bloque)) {
         $datos_tarea = $conexion->consultaPreparada(
            array($bloque),
            "SELECT nombre, descripcion FROM tarea WHERE bloque = ?",
            3,
            "s",
            false,
            null
         );

         if ($datos_tarea) {
            echo json_encode($datos_tarea);
         } else {
            echo 0;
         }
      }
      break;
}
