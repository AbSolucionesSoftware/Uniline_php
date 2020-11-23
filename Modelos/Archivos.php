<?php
####
## Función para redimencionar las imágenes
## utilizando las liberías de GD de PHP
####

function resizeImagen($ruta, $nombre, $alto, $ancho, $nombreN, $extension)
{
    $img_original = "";
    $rutaImagenOriginal = $ruta . $nombre;
    if ($extension == 'GIF' || $extension == 'gif') {
        $img_original = imagecreatefromgif($rutaImagenOriginal);
    } else if ($extension == 'jpg' || $extension == 'JPG' || $extension == 'jpeg') {
        $img_original = imagecreatefromjpeg($rutaImagenOriginal);
    } else if ($extension == 'png' || $extension == 'PNG') {
        $img_original = imagecreatefrompng($rutaImagenOriginal);
    }
    $max_ancho = $ancho;
    $max_alto = $alto;
    list($ancho, $alto) = getimagesize($rutaImagenOriginal);
    $x_ratio = $max_ancho / $ancho;
    $y_ratio = $max_alto / $alto;
    if (($ancho <= $max_ancho) && ($alto <= $max_alto)) { //Si ancho 
        $ancho_final = $ancho;
        $alto_final = $alto;
    } else if (($x_ratio * $alto) < $max_alto) {
        $alto_final = ceil($x_ratio * $alto);
        $ancho_final = $max_ancho;
    } else {
        $ancho_final = ceil($y_ratio * $ancho);
        $alto_final = $max_alto;
    }
    $tmp = imagecreatetruecolor($ancho_final, $alto_final);
    imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
    imagedestroy($img_original);
    $calidad = 70;
    imagejpeg($tmp, $ruta . $nombreN, $calidad);
}

function subir_imagen($nombre)
{
    // comprobar que han seleccionado una archivo
    if (!empty($_FILES[$nombre]['name'])) { // El campo del formulario enviado contiene un archivo...
        // Primero, hay que validar que se trata de un JPG/GIF/PNG y que su tamano sea menor a 1mb
        $pedazos = explode(".", $_FILES[$nombre]["name"]);
        $extension = end($pedazos);
        if (
            mime_content_type($_FILES[$nombre]["tmp_name"]) == "image/jpeg"
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == "image/png"
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == "image/jpg"
            &&  $_FILES[$nombre]['size'] <= 1000000
        ) {
            // el archivo es un JPG/GIF/PNG, entonces...

            $pedazos = explode(".", $_FILES[$nombre]["name"]);
            $extension = end($pedazos);

            $foto = substr(md5(uniqid(rand())), 0, 10) . "." . $extension;
            $directorio = $_SERVER['DOCUMENT_ROOT'] . "/Uniline/img/"; // directorio de tu elección

            // almacenar imagen en el servidor
            if (move_uploaded_file($_FILES[$nombre]['tmp_name'], $directorio  . $foto)) {
                $minFoto = 'min_' . $foto;
                $resFoto = 'res_' . $foto;
                resizeImagen($directorio . '/', $foto, 65, 65, $minFoto, $extension);
                resizeImagen($directorio . '/', $foto, 500, 500, $resFoto, $extension);
                unlink($directorio . '/' . $foto);
                return "../img/" . $foto;
            } else {
                return "error al subir";
            }
        } else {
            return "img no valida";
        }
    } else {  // El campo foto NO contiene una imagen

        return NULL; // como no se envio un archivo por post en la base de datos e registrara null

    }
}

function subir_archivo($nombre)
{
    if (!empty($_FILES[$nombre]['name'])) {
        if (
            mime_content_type($_FILES[$nombre]["tmp_name"]) == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == "application/vnd.ms-excel"
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == 'application/msword'
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == 'application/vnd.ms-powerpoint'
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == "application/x-msaccess"
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == "application/vnd.openxmlformats-officedocument.presentationml.presentation"
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == 'application/pdf'
            ||  mime_content_type($_FILES[$nombre]["tmp_name"]) == "application/x-rar"

        ) {

            $temp = explode(".", $_FILES[$nombre]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            $archivo = $_SERVER['DOCUMENT_ROOT'] . "/Uniline/archivos/" . $newfilename;
            if (move_uploaded_file($_FILES[$nombre]["tmp_name"], $archivo)) {
                return "../archivos/" . $newfilename . "";
            } else {
                die("error al subir");
            }
        } else {
            die("archivo no soportado");
        }
    } else {
        return NULL;
    }
    
}
