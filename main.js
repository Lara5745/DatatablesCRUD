$(document).ready(function() {
    tablaPersonas = $("#tablaPersonas").DataTable({
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnBorrar'>Borrar</button></div></div>"
        }],

        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
    });

    $("#btnNuevo").click(function() {
        $("#formPersonas").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Persona");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        actividad = fila.find('td:eq(1)').text();
        estado = fila.find('td:eq(2)').text();
        avance = parseInt(fila.find('td:eq(3)').text());
        area = fila.find('td:eq(4)').text();
        prioridad = fila.find('td:eq(5)').text();

        $("#actividad").val(actividad);
        $("#estado").val(estado);
        $("#avance").val(avance);
        $("#area").val(area);
        $("#prioridad").val(prioridad);
        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Persona");
        $("#modalCRUD").modal("show");
    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);
        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3; //borrar
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");
        if (respuesta) {
            $.ajax({
                url: "bd/crud.php",
                type: "POST",
                dataType: "json",
                data: { opcion: opcion, id: id },
                success: function() {
                    tablaPersonas.row(fila.parents('tr')).remove().draw();
                }
            });
            window.location.href = "index.php";
        }
        // window.location.replace("index.php");
    });

    $("#formPersonas").submit(function(e) {
        // e.preventDefault();
        actividad = $.trim($("#actividad").val());
        estado = $.trim($("#estado").val());
        avance = $.trim($("#avance").val());
        area = $.trim($("#area").val());
        prioridad = $.trim($("#prioridad").val());
        $.ajax({
            url: "bd/crud.php",
            type: "POST",
            dataType: "json",
            data: { actividad: actividad, estado: estado, avance: avance, area: area, prioridad: prioridad, id: id, opcion: opcion },
            success: function(data) {
                console.log(data);
                id = data[0].id;
                actividad = data[0].actividad;
                estado = data[0].estado;
                avance = data[0].avance;
                area = data[0].area;
                prioridad = data[0].prioridad;
                if (opcion == 1) {
                    tablaPersonas.row.add([id, actividad, estado, avance, area, prioridad]).draw();
                    // window.location.replace("index.php");
                } else {
                    tablaPersonas.row(fila).data([id, actividad, estado, avance, area, prioridad]).draw();
                    // window.location.replace("index.php");
                }
                window.location.href = "index.php";
            }
        });
        $("#modalCRUD").modal("hide");
        window.location.replace("index.php");
    });
});