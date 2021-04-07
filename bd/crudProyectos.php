<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS   

$actividad = (isset($_POST['actividad'])) ? $_POST['actividad'] : '';
$responsable = (isset($_POST['responsable'])) ? $_POST['responsable'] : '';
$colaborador = (isset($_POST['colaborador'])) ? $_POST['colaborador'] : '';
$coordinacion = (isset($_POST['coordinacion'])) ? $_POST['coordinacion'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO proyectos (Actividad, Responsable, Colaborador, Coordinacion,Tipo) VALUES('$actividad', '$responsable', '$colaborador', '$coordinacion', '$tipo') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM proyectos ORDER BY IdProyecto DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        header("proyectos.php");
        break;
    case 2: //modificación
        $consulta = "UPDATE proyectos SET Actividad='$actividad', Responsable='$responsable', Colaborador='$colaborador', Coordinacion='$coordinacion', Tipo='$tipo' WHERE IdProyecto='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM proyectos WHERE IdProyecto='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        header("proyectos.php");
        break;        
    case 3://baja
        $consulta = "DELETE FROM proyectos WHERE IdProyecto='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        header("proyectos.php");                       
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

header("proyectos.php");