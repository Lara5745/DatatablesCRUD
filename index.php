<?php
header("Refresh:1");
// header("Refresh:.5");
header("Refresh:1000000000");

include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM actividades";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />  
    <title>Tutorial DataTables</title>
      
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="main.css">  
      
      
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">  

    <style>
    /* Centrar verticalmente td y th */
    .table td,  .table thead th {
    vertical-align: middle;
    }     
    
    </style>
  </head>
    
  <body> 
     <header>
<!--         <h3 class="text-center text-light">Tutorial</h3>-->
         <h4 class="text-center text-light">CRUD con <span class="badge badge-danger">DATATABLES</span></h4>
         <a href="proyectos.php" style="color:red; font-size:20px">Tabla proyectos</a> 
     </header>    
      
    <div class="container">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Nuevo</button>    
            </div>    
        </div>    
    </div>    
    <br>  
    <div class="container">
        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaPersonas" class="table table-striped table-bordered table-condensed text-center" style="width:100%">
                        <thead class="text-center text-white" style="background:#007bff;">
                            <tr>
                                <th>Id</th>
                                <th>Nombre del proyecto</th>
                                <th>Estado</th>                                
                                <th>Avance</th>  
                                <th>Área</th>
                                <th>Prioridad</th>  
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {    
                            ?>
                            <tr>
                                <td><?php echo $dat['IdActividad'] ?></td>
                                <td><?php echo $dat['Actividad'] ?></td>
                                <td><?php echo $dat['EstadoDeLaActividad'] ?></td>
                                <td><?php echo $dat['AvancePorcentaje']?>%<div class="progress"> <div class="progress-bar" style="width:<?php echo $dat['AvancePorcentaje'] ?>%"></div></div></td> 
                                <td><?php echo $dat['Area'] ?></td>
                                <td><?php echo $dat['PrioridadDeLaActividad'] ?></td>   
                                <td></td>
                            </tr>
                            <?php
                                }
                            ?>                                
                        </tbody>        
                       </table>                    
                    </div>
                </div>
        </div>  
    </div>    
      
<!--Modal para CRUD-->
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</s pan>
                </button>
            </div>
        <form id="formPersonas">    
            <div class="modal-body">
                <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                <label for="actividad" class="col-form-label">actividad:</label>
                <input type="text" class="form-control" id="actividad">
                </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group">
                <label for="estado" class="col-form-label">estado:</label>
                <input type="text" class="form-control" id="estado">
                </div>  
                </div>
                <div class="col-lg-6">              
                <div class="form-group">
                <label for="avance" class="col-form-label">avance:</label>
                <input type="number" class="form-control" id="avance">
                </div>    
                </div>  
                <div class="col-lg-6">              
                <div class="form-group">
                <label for="area" class="col-form-label">area:</label>
                <input type="text" class="form-control" id="area">
                </div>    
                </div> 
                <div class="col-lg-6">              
                <div class="form-group">
                <label for="prioridad" class="col-form-label">prioridad:</label>
                <input type="text" class="form-control" id="prioridad">
                </div>    
                </div>       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </div>
        </form>    
    </div>
</div> 
</div> 
      
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>  
    
    
  </body>
</html>
