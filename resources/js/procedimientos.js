var codi_pro = -1;

$(document).ready(function() {

    $("#form_pro").submit(function() {
        var codi_pro = $("#codi_pro").val();
        var codi_cat = $("#codi_cat").val();

        var sw_pro = false;

        $("#tarifas-rep option").each(function() {
            var cat = $(this).val();
            var pro = $(this).html();

            if (cat == codi_cat && codi_pro == pro) {
                sw_pro = true;
            }

        });

        if (sw_pro) {
            var dialogo = confirm("Ya existe una tarifa del procedimiento y categoría seleccionados. ¿Desea actualizar el costo?");
            if (dialogo == true) {
                $('input[name="accion"]').val("actualizar");
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    });

    $('#table-procedimientos').on('click', 'tbody tr', function() {
        codigo = $(this).find("td").eq(0).html();
    });

    $('button[name="buscar_pro"]').click(function() {

        $.ajax({
            url: base_url + 'procedimientos/search_procedimiento',
            type: 'post',
            success: function(resultado) {
                $("#ResultadoMedico").html(resultado);
            }
        });
    });

    $("#btnEditarModalMedico").click(function() {

        //$("#error_hora_cita_edit").css("display", "none");

        //$("#btnEditarModalMedico").prop("disabled", true);
        //$("#btnEditarModalMedico").html("Cargando...");
        //alert(codi_pro);
        $.ajax({
            data: {'codigo': codi_pro},
            url: base_url + 'procedimientos/get_data_tarifa',
            type: 'post',
            success: function(data_php) {

                var data = $.parseJSON(data_php);

                //alert(data['desc_pro']);

                $('input[name="codigo"]').val(codi_pro);
                $('select[name="categoria"] option[value="' + data["codi_cat"] + '"]').prop("selected", true);
                $('select[name="procedimiento"] option[value="' + data["codi_pro"] + '"]').prop("selected", true);
                $("#costo_pro").val(data['cost_tar']);
                $("#myModalLabel").modal("hide");

                $('input[name="editar_pro"]').css("display", "inherit");
                $('input[name="registar_pro"]').css("display", "none");
                $('button[name="buscar_pro"]').css("display", "none");
                $('button[name="cancelar_pro"]').css("display", "inherit");
                $('input[name="limpiar_pro"]').css("display", "none");
            }
        });
    });

    $("#deshabilitarMedico").click(function() {
        $.ajax({
            data: {'codigo': codi_pro},
            url: base_url + 'procedimientos/deshabilitar_tarifa',
            type: 'post',
            success: function(e) {
                $(location).attr('href', base_url + "procedimiento");
            }
        });
    });

    if ($("#sw_proc").val() != "") {
        $("#ModalNuevoProcedimiento").modal("show");
    }

    if ($("#sw_cat").val() != "") {
        $("#ModalNuevaCategoria").modal("show");
    }

});