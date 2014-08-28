var codigo;
var observa;
var paciente = "";
var estado;
var hora_edit;
var fecha_edit;

var tabla_diente = [];
var num_diente = [];

$(document).ready(function() {

    if ($("#error_nueva_cita").val() == "A" || $("#error_nueva_cita").val() == "B") {
        $.ajax({
            url: base_url + 'citas/mostrar_formulario_nuevo',
            type: 'post',
            success: function(html) {
                $("#frm_nueva_cita").html(html);
                if ($("#error_nueva_cita").val() == "A") {
                    $("#error_hora_cita").css("display", "inherit");
                } else if ($("#error_nueva_cita").val() == "B") {
                    $("#msj_error_pac_cita").css("display", "inherit");
                }
                $("#ModalNuevaCita").modal("show");
            }
        });
    }

    if ($("#error_editar_cita").val() == "A") {
        $("#error_hora_cita_edit").css("display", "inherit");

        $("#codigo_cit_edit").val($('#error_editar_cita_codigo').val());

        $('#citas-det tr').each(function() {
            if ($(this).find("td").eq(0).html() == $('#error_editar_cita_codigo').val()) {
                $("#fecha_cita_edit").val($("#fecha_cit").val());
                $("#hora_cita_edit").val($(this).find("td").eq(1).html().substring(11, 16));

                $('select[name="medico_edit"] option[value="' + $(this).find("td").eq(2).html() + '"]').prop("selected", true);
                $("#paciente_cit_edit").val($(this).find("td").eq(3).html() + " " + $(this).find("td").eq(4).html());

                $("#observa_cit_edit").val(observa);

                fecha_edit = $("#fecha_cit").val();
                hora_edit = $(this).find("td").eq(1).html().substring(11, 16);

                $('input[name="fecha_ori"]').val($("#fecha_cit").val());
                $('input[name="hora_ori"]').val($(this).find("td").eq(1).html().substring(11, 16));

                $("#ModalAccionesCita").modal("hide");
                $("#ModalEditarCita").modal("show");
            }
        });
    }

    if ($("#mensaje_cit").is(":contains('finalizada')")) {
        $("#iframe_comprobante").empty()
        $("#iframe_comprobante").append('<iframe src="' + base_url + 'factura/show_pdf" style="display:block; width:100%; height: 100%; border:none;" frameborder="0" scrolling="no"></iframe>');
        $("#ModalComprobante").modal("show");
    }

    $("#comenzar_cita").click(function() {

        var sw_cargar = false;
        var sw_cargar_sol = false;
        $('#last_estados tr').each(function() {
            if ($(this).find('td').eq(3).html() == paciente && sw_cargar_sol == false) {
                sw_cargar_sol = true;
                var cargar = confirm("¿Desea cargar el último resultado de diagnóstico?");
                if (cargar == true) {
                    sw_cargar = true;
                }
            }
        });
        if (sw_cargar) {
            $('#last_estados tr').each(function() {
                if ($(this).find('td').eq(3).html() == paciente) {
                    var partes = $(this).find('td').eq(2).html();
                    var partes_desc = "";
                    var diente = $(this).find('td').eq(1).html();
                    var codi_edi = $(this).find('td').eq(4).html();
                    var estado = $(this).find('td').eq(5).html();

                    var select = $(".btn-group a span:contains('" + diente + "')").parent();

                    if (partes.charAt(0) == "M") {
                        partes_desc += " Mesial ";
                        select.find(".parte_izquierda").css("background", "red");
                    }
                    if (partes.charAt(1) == "D") {
                        partes_desc += " Distal ";
                        select.find(".parte_derecha").css("background", "red");
                    }
                    if (partes.charAt(2) == "V") {
                        partes_desc += " Vestibular ";
                        select.find(".parte_superior").css("background", "red");
                    }
                    if (partes.charAt(3) == "P") {
                        partes_desc += " Palatino ";
                        select.find(".parte_inferior").css("background", "red");
                    }
                    if (partes.charAt(3) == "L") {
                        partes_desc += " Lingual ";
                        select.find(".parte_inferior").css("background", "red");
                    }
                    if (partes.charAt(4) == "O") {
                        partes_desc += " Oclusal ";
                        select.find(".parte_central").css("background", "red");
                    }
                    if (partes.charAt(4) == "I") {
                        partes_desc += " Incisal ";
                        select.find(".parte_central").css("background", "red");
                    }
                    if (partes.indexOf("0") == -1) {
                        partes_desc = "Pieza completa";
                    }

                    select.prop("disabled", true);
                    select.addClass("disabled");

                    tabla_diente.push([diente, estado, partes, partes_desc]);
                    num_diente.push(diente);
                    $("#dientes_seleccionados tbody").append("<tr><td>" + diente + "</td><td>" + estado + "</td><td>" + partes_desc + "</td><td style='display:none;'>" + partes + "</td><td>" + '<input type="button" class="quitar_diente btn btn-danger btn-circle fa" value="&#xf05e;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar diente">&nbsp;<input type="button" class="editar_diente btn btn-primary btn-circle fa" value="&#xf044;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar diente">' + "</td></tr>");

                    $("#img_estados li").each(function() {
                        if (diente + "_" + codi_edi + ".jpg" == $(this).html()) {
                            $(".btn-group a span:contains('" + diente + "')").parent().find("img").attr("src", base_url + "resources/images/odontograma/" + diente + "/" + $(this).html());
                        }
                    });

                    if (tabla_diente.length == 0) {
                        $("#enfermedad_cita").prop("disabled", true);
                    } else {
                        $("#enfermedad_cita").prop("disabled", false);
                    }
                }
            });
        }

        $("#ModalAccionesCita").modal("hide");
        $("#ModalStartCita").modal("show");

    });

    $("#CancelarCita").click(function() {
        $(location).attr('href', base_url + 'citas');
    });



    $("#table-citas-medicas").DataTable();
    $("#dp_fecha_cit").datepicker({minDate: 0});

    $('button[name="nueva_cita"]').click(function() {
        $.ajax({
            url: base_url + 'citas/mostrar_formulario_nuevo',
            type: 'post',
            success: function(html) {
                $("#frm_nueva_cita").html(html);
            }
        });
    });

    $('#table-citas-medicas').on('click', 'tbody tr', function() {

        $("#editar_cita").prop("disabled", false);
        $("#editar_cita").html("Actualizar");

        codigo = $(this).find("td").eq(0).html();
        var medico = $(this).find("td").eq(1).html();
        paciente = $(this).find("td").eq(2).html();
        var hora = $(this).find("td").eq(3).html();
        observa = $(this).find("td").eq(4).html();
        estado = $(this).find("td").eq(5).html();

        $("#panel_row_citas").removeClass("panel-info");
        $("#panel_row_citas").removeClass("panel-green");

        if (estado == "Pendiente") {
            $("#panel_row_citas").addClass("panel-info");
            $("#panel_row_citas .panel-heading").html("Cita médica pendiente");
            $('button[name="comenzar_cita"]').css("display", "inherit");
            $('button[name="deshabilitar_cita"]').css("display", "inherit");
        } else {
            $("#panel_row_citas").addClass("panel-green");
            $("#panel_row_citas .panel-heading").html("Cita médica finalizada");
            $('button[name="comenzar_cita"]').css("display", "none");
            $('button[name="deshabilitar_cita"]').css("display", "none");
        }

        $("#panel_row_citas .panel-body").html("");
        $("#panel_row_citas .panel-body").append("<strong>Código: </strong>" + codigo + '<br>');
        $("#panel_row_citas .panel-body").append("<strong>Paciente: </strong>" + paciente + '<br>');
        $("#panel_row_citas .panel-body").append("<strong>Médico: </strong>" + medico + '<br>');
        $("#panel_row_citas .panel-body").append("<strong>Fecha: </strong>" + $("#fecha_cit").val() + " " + hora + '<br>');
        if (observa != "") {
            $("#panel_row_citas .panel-body").append("<strong>Observación: </strong><br>" + observa + '<br>');
        }

        $("#ModalAccionesCita").modal("show");

    });

    $('button[name="deshabilitar_cita"').click(function() {

        $("#ModalDeshabilitarCita").modal("show");

    });

    $("#deshabilitarCita").click(function() {

        $.ajax({
            data: {'codigo': codigo},
            url: base_url + 'citas/deshabilitar',
            type: 'post',
            success: function(e) {
                $(location).attr('href', base_url + 'citas');
            }
        });

    });

    $("#editar_cita").click(function() {

        $("#error_hora_cita_edit").css("display", "none");

        $("#editar_cita").prop("disabled", true);
        $("#editar_cita").html("Cargando...");

        $("#codigo_cit_edit").val(codigo);

        $('#citas-det tr').each(function() {
            if ($(this).find("td").eq(0).html() == codigo) {
                $("#fecha_cita_edit").val($("#fecha_cit").val());
                $("#hora_cita_edit").val($(this).find("td").eq(1).html().substring(11, 16));

                $('select[name="medico_edit"] option[value="' + $(this).find("td").eq(2).html() + '"]').prop("selected", true);
                $("#paciente_cit_edit").val($(this).find("td").eq(4).html() + " " + $(this).find("td").eq(5).html());

                $("#observa_cit_edit").val(observa);

                fecha_edit = $("#fecha_cit").val();
                hora_edit = $(this).find("td").eq(1).html().substring(11, 16);

                $('input[name="fecha_ori"]').val($("#fecha_cit").val());
                $('input[name="hora_ori"]').val($(this).find("td").eq(1).html().substring(11, 16));

                $("#ModalAccionesCita").modal("hide");
                $("#ModalEditarCita").modal("show");
            }
        });

    });

});