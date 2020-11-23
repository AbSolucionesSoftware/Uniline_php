<?php
//Iniciar una nueva sesión o reanudar la existente.
if (empty($_SESSION['acceso'])) {
    header('Location: ../views/mainpage.php');
} else if (empty($_SESSION['verificado'])) {
    header('Location: ../views/mainpage.php');
} else if (empty($_SESSION['idusuario'])) {
    header('Location: ../views/mainpage.php');
}

