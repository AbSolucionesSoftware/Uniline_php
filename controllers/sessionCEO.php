<?php
//Iniciar una nueva sesión o reanudar la existente.
session_start();
//Si existe la sesión "cliente"..., la guardamos en una variable.

if (empty($_SESSION['CEO'])){
    header('Location: ../views/mainpage.php');
}else if($_SESSION['CEO'] != 'CEO'){
    header('Location: ../views/mainpage.php');
}
