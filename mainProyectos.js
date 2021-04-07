$(document).ready(function() {
    tablaProyectos = $("#tablaProyectos").DataTable({
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
        $("#formProyectos").trigger("reset");
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
        responsable = fila.find('td:eq(2)').text();
        colaborador = fila.find('td:eq(3)').text();
        coordinacion = fila.find('td:eq(4)').text();
        tipo = fila.find('td:eq(5)').text();

        $("#actividad").val(actividad);
        $("#responsable").val(responsable);
        $("#colaborador").val(colaborador);
        $("#coordinacion").val(coordinacion);
        $("#tipo").val(tipo);
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
                url: "bd/crudProyectos.php",
                type: "POST",
                dataType: "json",
                data: { opcion: opcion, id: id },
                success: function() {
                    tablaProyectos.row(fila.parents('tr')).remove().draw();
                }
            });
            window.location.href = "proyectos.php";
        }
        // window.location.replace("proyectos.php");
    });

    $("#formProyectos").submit(function(e) {
        // e.preventDefault();
        actividad = $.trim($("#actividad").val());
        responsable = $.trim($("#responsable").val());
        colaborador = $.trim($("#colaborador").val());
        coordinacion = $.trim($("#coordinacion").val());
        tipo = $.trim($("#tipo").val());
        $.ajax({
            url: "bd/crudProyectos.php",
            type: "POST",
            dataType: "json",
            data: { actividad: actividad, responsable: responsable, colaborador: colaborador, coordinacion: coordinacion, tipo: tipo, id: id, opcion: opcion },
            success: function(data) {
                console.log(data);
                id = data[0].id;
                actividad = data[0].actividad;
                responsable = data[0].responsable;
                colaborador = data[0].colaborador;
                coordinacion = data[0].coordinacion;
                tipo = data[0].tipo;
                if (opcion == 1) {
                    tablaProyectos.row.add([id, actividad, responsable, colaborador, coordinacion, tipo]).draw();
                    // window.location.replace("proyectos.php");
                } else {
                    tablaProyectos.row(fila).data([id, actividad, responsable, colaborador, coordinacion, tipo]).draw();
                    // window.location.replace("proyectos.php");
                }
                window.location.href = "proyectos.php";
            }
        });
        $("#modalCRUD").modal("hide");
        window.location.replace("proyectos.php");
    });
});