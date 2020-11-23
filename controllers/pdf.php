<?php
session_start();
require_once '../Modelos/Conexion.php';
require('../APIs/fpdf/fpdf.php');


/* if(isset($_POST['certificacion'])){ */
    $_SESSION['idusuario'] = 20;
    $conexion = new Modelos\Conexion();

    $conexion->cambiarDatos();


    $result =$conexion->consultaPreparada(
        array($_SESSION['idusuario']),
        "SELECT u.nombre,ci.nombre,DATE_FORMAT(c.fecha_inicio,'%W %d de %M '),DATE_FORMAT(c.fecha_fin,'%W %d de %M del %Y') FROM usuario u INNER JOIN inscripcion c ON c.alumno = u.idusuario INNER JOIN curso ci ON ci.idcurso = c.curso WHERE u.idusuario = ?",
        2,
        "i",
        false,
        null
    );

    $alumno = $result[0][0];
    $curso = "'".$result[0][1]."'";
    $fecha_inicial = $result[0][2];
    $fecha_final = $result[0][3];
    $temp = explode("-", $result[0][3]);
    $anoDelCurso = $temp[0];

    $fechaFinal = "Del $fecha_inicial al $fecha_final ";

    class PDF extends FPDF {  
    // Cabecera de página
    function Header(){
        // Logo
        $this->Image('../img/certificacion.png',0,0,300);
        // Arial bold 15
        // Movernos a la derecha
        $this->Cell(20);
        // Título
        // Salto de línea
        $this->Ln(20);
    }
    function Footer(){
        $maestro = "Diego Alonso Leon De Dios";

        // Posición: a 1,5 cm del final
        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('Arial','I',12);
        $this->SetTextColor(1,102,147);
        // Número de página
        $this->Cell(152,8,utf8_decode(''),0,0,'C');
        $this->Cell(60,6,utf8_decode($maestro),0,1,'C');
    }
    }

    $pdf = new PDF("L");
    $pdf->AddPage();


    $pdf->Cell(19,88,utf8_decode(''),0,1,'C');

    $pdf->Cell(152,8,utf8_decode(''),0,0,'C');

    $pdf->SetTextColor(1,102,147);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(60,8,utf8_decode($alumno),0,1,'C');

    $pdf->Cell(19,1,utf8_decode(''),0,1,'C');

    $pdf->Cell(152,6,utf8_decode(''),0,0,'C');

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(60,6,utf8_decode('Por hacer acreditado sactisfactoriamente el curso:'),0,1,'C');
    $pdf->SetFont('Arial','I',12);

    $pdf->Cell(152,6,utf8_decode(''),0,0,'C');
    $pdf->Cell(60,6,utf8_decode($curso),0,1,'C');
    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(152,6,utf8_decode(''),0,0,'C');
    $pdf->Cell(60,6,utf8_decode($fechaFinal),0,1,'C');
    $pdf->Cell(152,6,utf8_decode(''),0,0,'C');
    $pdf->Cell(60,6,utf8_decode("En la Escuela Al Reves de AB 'Uniline'"),0,1,'C');
    
    $pdf->Output("F","../archivos/NAme.pdf");
/* } */
?>