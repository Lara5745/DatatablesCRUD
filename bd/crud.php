<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS   

$actividad = (isset($_POST['actividad'])) ? $_POST['actividad'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$avance = (isset($_POST['avance'])) ? $_POST['avance'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$prioridad = (isset($_POST['prioridad'])) ? $_POST['prioridad'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO actividades (Actividad, EstadoDeLaActividad, AvancePorcentaje, Area,PrioridadDeLaActividad) VALUES('$actividad', '$estado', '$avance', '$area', '$prioridad') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM actividades ORDER BY IdActividad DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        header("index.php");
        break;
    case 2: //modificación
        $consulta = "UPDATE actividades SET Actividad='$actividad', EstadoDeLaActividad='$estado', AvancePorcentaje='$avance', Area='$area', PrioridadDeLaActividad='$prioridad' WHERE IdActividad='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM actividades WHERE IdActividad='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        header("index.php");
        break;        
    case 3://baja
        $consulta = "DELETE FROM actividades WHERE IdActividad='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        header("index.php");                       
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

header("index.php");