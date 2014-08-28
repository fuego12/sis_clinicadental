var diente = -1;
var estado = -1;
var select;


var tabla_enfermedad = [];
var num_diente_enf = [];
var tabla_procedimiento = [];
var num_diente_pro = [];

$("#table-historial_enfermedad").DataTable();
$("#table-historial_procedimiento").DataTable();

//$("#finalizar_cita").click(function() {
//    var r = confirm("¿Estás seguro de que desea finalizar la cita médica?");
//    if (r == true) {
//        //
//        $("#finalizar_cita").html("Finalizando cita médica... Espere un momento");
//        $("#finalizar_cita").prop("disabled", true);
//        var parametros = {
//            'tbl_diente': JSON.stringify(tabla_diente),
//            'tbl_enfermedad': JSON.stringify(tabla_enfermedad),
//            'tbl_procedimiento': JSON.stringify(tabla_procedimiento),
//            'total': $("#total_pro").val(),
//            'cita': codigo
//        };
//
//        $.ajax({
//            data: parametros,
//            url: base_url + 'citas/finalizar_cita',
//            type: 'post',
//            success: function(e) {
////                alert(e);
//                $(location).attr('href', base_url + "citas");
//            }
//        });
//    }
//});

$("#form_finalizar_cita").submit(function() {
    var r = confirm("¿Estás seguro de que desea finalizar la cita médica?");
    if (r == true) {
        //
        $("#finalizar_cita").val("Finalizando cita médica... Espere un momento");
        $("#finalizar_cita").prop("disabled", true);

        $("#fin_codi_cit").val(codigo);
        $("#fin_tbl_diente").val(JSON.stringify(tabla_diente));
        $("#fin_tbl_enfermedad").val(JSON.stringify(tabla_enfermedad));
        $("#fin_tbl_procedimiento").val(JSON.stringify(tabla_procedimiento));
        $("#fin_total").val($("#total_pro").val());
    }
    
});

$("#agregar_pro").click(function() {

    var diente = $("#diente_pro").val();
    var codigo_tar = $("#codigo_pro").val();
    var aseguradora = $("#aseg_pro").val();

    var procedimiento = $("#codigo_pro option:selected").html();

    var sw_enf = true;

    for (var i = 0; i < tabla_procedimiento.length; i++) {

        if (tabla_procedimiento[i][0] == diente && tabla_procedimiento[i][1] == codigo_tar) {
            sw_enf = false;
        }

    }

    if (sw_enf) {

        var index = procedimiento.indexOf("S/. ") + 3;
        var costo = procedimiento.substring(index);

        var total_unit = parseFloat(costo) - (parseFloat(costo) * (parseFloat(aseguradora) / 100));
        var total_ant = parseFloat($("#total_pro").val());
        var total = total_unit + total_ant;

        $("#total_pro").val(total);

        tabla_procedimiento.push([diente, codigo_tar, aseguradora, procedimiento, total_unit]);
        num_diente_pro.push(diente);

        $("#tabla_procedimiento tbody").append("<tr><td>" + diente + "</td><td>" + procedimiento.substring(0, index) + " " + total_unit + "</td><td>" + aseguradora + "%</td><td style='display:none;'>" + codigo_tar + "</td><td>" + '<input type="button" class="quitar_proc btn btn-danger btn-circle fa" value="&#xf05e;">' + "</td></tr>");

//        $('#diente_pro option[value="' + diente + '"]:contains("' + $("#diente_pro option:selected").html() + '")').remove();

//        if (tabla_enfermedad.length == tabla_procedimiento.length) {
//            $("#agregar_pro").prop('disabled', true);
//            $("#diente_pro").prop('disabled', true);
//            $("#codigo_pro").prop('disabled', true);
//            $("#aseg_pro").prop('disabled', true);
//        } else {
//            $("#agregar_pro").prop('disabled', false);
//            $("#diente_pro").prop('disabled', false);
//            $("#codigo_pro").prop('disabled', false);
//            $("#aseg_pro").prop('disabled', false);
//        }

        if (tabla_procedimiento.length == 0) {
            $("#finalizar_cita").prop("disabled", true);
        } else {
            $("#finalizar_cita").prop("disabled", false);
        }

    } else {
        alert("Ya se ha agregado el procedimiento " + procedimiento + " para el diente " + diente);
    }

});

$("#tabla_procedimiento").on("click", ".quitar_proc", function() {
    var diente = $(this).parent().parent().find("td").eq(0).html();
    var procedimiento = $(this).parent().parent().find("td").eq(1).html();
    var index = num_diente_pro.indexOf(diente);
    if (index > -1) {
        tabla_procedimiento.splice(index, 1);
        num_diente_pro.splice(index, 1);
    }
    $(this).parent().parent().remove();

    var index = num_diente_enf.indexOf(diente);

    $("#diente_pro").append('<option value="' + diente + '">' + diente + ' - ' + tabla_enfermedad[index][2] + '</option>');

    $("#agregar_pro").prop('disabled', false);
    $("#diente_pro").prop('disabled', false);
    $("#codigo_pro").prop('disabled', false);
    $("#aseg_pro").prop('disabled', false);
    $("#aseg_pro").val("0");

//    alert(JSON.stringify(tabla_diente));

    if (tabla_procedimiento.length == 0) {
        $("#finalizar_cita").prop("disabled", true);
    } else {
        $("#finalizar_cita").prop("disabled", false);
    }

    var total_ant = parseFloat($("#total_pro").val());

    var index = procedimiento.indexOf("S/. ") + 3;
    var costo = parseFloat(procedimiento.substring(index));
    var total = total_ant - costo;
    $("#total_pro").val(total);
});

$("#procedimiento_cita").click(function() {
    $("#diente_pro").html("");

    for (i = 0; i < num_diente_enf.length; i++) {
        $("#diente_pro").append('<option value="' + num_diente_enf[i] + '">' + num_diente_enf[i] + ' - ' + tabla_enfermedad[i][2] + '</option>');
    }
    $("#ModalEnfermedad").modal("hide");
    $("#ModalProcedimiento").modal("show");
});


$("#agregar_enf").click(function() {

    var diente = $("#diente_enf").val();
    var codigo_enf = $("#codigo_enf").val();
    var enfermedad = $("#codigo_enf option:selected").html();

    var sw_enf = true;

    for (var i = 0; i < tabla_enfermedad.length; i++) {

        if (tabla_enfermedad[i][0] == diente && tabla_enfermedad[i][1] == codigo_enf) {
            sw_enf = false;
        }

    }

    if (sw_enf) {

        tabla_enfermedad.push([diente, codigo_enf, enfermedad]);
        num_diente_enf.push(diente);

        $("#tabla_enfermedad tbody").append("<tr><td>" + diente + "</td><td>" + enfermedad + "</td><td style='display:none;'>" + codigo_enf + "</td><td>" + '<input type="button" class="quitar_enfermedad btn btn-danger btn-circle fa" value="&#xf05e;">' + "</td></tr>");



//    $('#diente_enf option[value="' + diente + '"]').remove();

//    if (num_diente_enf.length == num_diente.length) {
//        $("#agregar_enf").prop('disabled', true);
//        $("#diente_enf").prop('disabled', true);
//        $("#codigo_enf").prop('disabled', true);
//    } else {
//        $("#agregar_enf").prop('disabled', false);
//        $("#diente_enf").prop('disabled', false);
//        $("#codigo_enf").prop('disabled', false);
//    }

        if (tabla_enfermedad.length == 0) {
            $("#procedimiento_cita").prop("disabled", true);
        } else {
            $("#procedimiento_cita").prop("disabled", false);
        }

    } else {
        alert("Ya se ha agregado la enfermedad " + enfermedad + " del diente " + diente);
    }
});

$("#atras_enfermedad").click(function() {
    var r = confirm("¿Está seguro de que desea volver atrás? Podría perder los cambios realizados en esta sección(Enfermedades)");
    if (r == true) {
        tabla_enfermedad = [];
        num_diente_enf = [];

        $("#tabla_enfermedad tbody tr").each(function() {
            $(this).remove();
        });

        if (tabla_enfermedad.length == 0) {
            $("#procedimiento_cita").prop("disabled", true);
        } else {
            $("#procedimiento_cita").prop("disabled", false);
        }

        $("#ModalEnfermedad").modal("hide");
        $("#ModalStartCita").modal("show");
    }
});

$("#atras_procedimiento").click(function() {
    var r = confirm("¿Está seguro de que desea volver atrás? Podría perder los cambios realizados en esta sección(Procedimiento)");
    if (r == true) {
        tabla_procedimiento = [];
        num_diente_pro = [];

        $("#tabla_procedimiento tbody tr").each(function() {
            $(this).remove();
        });

        $("#agregar_pro").prop('disabled', false);
        $("#diente_pro").prop('disabled', false);
        $("#codigo_pro").prop('disabled', false);
        $("#aseg_pro").prop('disabled', false);

        $("#ModalProcedimiento").modal("hide");
        $("#ModalEnfermedad").modal("show");
    }
});

$("#tabla_enfermedad").on("click", ".quitar_enfermedad", function() {
    var diente = $(this).parent().parent().find("td").eq(0).html();
    var index = num_diente_enf.indexOf(diente);
    if (index > -1) {
        tabla_enfermedad.splice(index, 1);
        num_diente_enf.splice(index, 1);
    }
    $(this).parent().parent().remove();

//    alert(JSON.stringify(tabla_diente));

    if (tabla_enfermedad.length == 0) {
        $("#procedimiento_cita").prop("disabled", true);
    } else {
        $("#procedimiento_cita").prop("disabled", false);
    }
});

$("#enfermedad_cita").click(function() {

    $("#diente_enf").html("");

    for (i = 0; i < num_diente.length; i++) {
        $("#diente_enf").append('<option value="' + num_diente[i] + '">' + num_diente[i] + '</option>');
    }

    $("#ModalStartCita").modal("hide");
    $("#ModalEnfermedad").modal("show");
});


$(".estado_diente li").click(function() {
    select = $(this).parent().parent().find("a");
    diente = $(this).parent().parent().find("span").html();
    var estado_s = $(this).find("a").html();
    var index = estado_s.indexOf('= ') + 2;
    estado = estado_s.substring(index);

    restaurarDientes();
    if (diente == "18" || diente == "17" || diente == "16" || diente == "15" || diente == "14" || diente == "24" || diente == "25" || diente == "26" || diente == "27" || diente == "28") {
        $("#pie_inc").parent().parent().css("display", "none");
        $("#pie_lin").parent().parent().css("display", "none");
    } else if (diente == "48" || diente == "47" || diente == "46" || diente == "45" || diente == "44" || diente == "34" || diente == "35" || diente == "36" || diente == "37" || diente == "38") {
        $("#pie_pal").parent().parent().css("display", "none");
        $("#pie_inc").parent().parent().css("display", "none");
    } else if (diente == "13" || diente == "12" || diente == "11" || diente == "21" || diente == "22" || diente == "23") {
        $("#pie_lin").parent().parent().css("display", "none");
        $("#pie_ocl").parent().parent().css("display", "none");
    } else if (diente == "43" || diente == "42" || diente == "41" || diente == "31" || diente == "32" || diente == "33") {
        $("#pie_pal").parent().parent().css("display", "none");
        $("#pie_ocl").parent().parent().css("display", "none");
    }

    $("#ModalPiezasDie").modal("show");
});

$("#aceptar_piezas").click(function() {

    if ($("#pie_all").is(':checked') || $("#pie_mes").is(':checked') || $("#pie_dis").is(':checked') || $("#pie_ocl").is(':checked') || $("#pie_pal").is(':checked') || $("#pie_lin").is(':checked') || $("#pie_ves").is(':checked') || $("#pie_inc").is(':checked')) {

        var partes = "";
        var partes_desc = "";

        if ($("#pie_mes").is(":checked")) {
            partes += "M";
            partes_desc += " Mesial ";

            select.find(".parte_izquierda").css("background", "red");
        } else {
            partes += "0";
        }
        if ($("#pie_dis").is(":checked")) {
            partes += "D";
            partes_desc += " Distal ";

            select.find(".parte_derecha").css("background", "red");
        } else {
            partes += "0";
        }
        if ($("#pie_ves").is(":checked")) {
            partes += "V";
            partes_desc += " Vestibular ";

            select.find(".parte_superior").css("background", "red");
        } else {
            partes += "0";
        }
        if ($("#pie_pal").is(":checked") || $("#pie_lin").is(":checked")) {

            if ($("#pie_pal").is(":checked")) {
                partes += "P";
                partes_desc += " Palatino ";
            } else if ($("#pie_lin").is(":checked")) {
                partes += "L";
                partes_desc += " Lingual ";
            }

            select.find(".parte_inferior").css("background", "red");
        } else {
            partes += "0";
        }
        if ($("#pie_ocl").is(":checked") || $("#pie_inc").is(":checked")) {

            if ($("#pie_ocl").is(":checked")) {
                partes += "O";
                partes_desc += " Oclusal ";
            } else if ($("#pie_inc").is(":checked")) {
                partes += "I";
                partes_desc += " Incisal ";
            }

            select.find(".parte_central").css("background", "red");
        } else {
            partes += "0";
        }

        if (partes.indexOf("0") == -1) {
            partes_desc = "Pieza completa";
        }

        tabla_diente.push([diente, estado, partes, partes_desc]);
        num_diente.push(diente);
        $("#dientes_seleccionados tbody").append("<tr><td>" + diente + "</td><td>" + estado + "</td><td>" + partes_desc + "</td><td style='display:none;'>" + partes + "</td><td>" + '<input type="button" class="quitar_diente btn btn-danger btn-circle fa" value="&#xf05e;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar diente">&nbsp;<input type="button" class="editar_diente btn btn-primary btn-circle fa" value="&#xf044;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar diente">' + "</td></tr>");

        $(".editar_diente").tooltip();
        $(".quitar_diente").tooltip();

        select.prop("disabled", true);
        select.addClass("disabled");

        var codi_edi = "";

        $("#estados_rep option").each(function() {
            if (estado == $(this).html()) {
                codi_edi = $(this).val();
                return false;
            }
        });
        $("#img_estados li").each(function() {
            if (diente + "_" + codi_edi + ".jpg" == $(this).html()) {
                $(".btn-group a span:contains('" + diente + "')").parent().find("img").attr("src", base_url + "resources/images/odontograma/" + diente + "/" + $(this).html());
            }
        });

        diente = -1;
        estado = -1;

        $("#pie_all").prop("checked", true);
        $("#pie_mes").prop("checked", true);
        $("#pie_dis").prop("checked", true);
        $("#pie_ocl").prop("checked", true);
        $("#pie_pal").prop("checked", true);
        $("#pie_lin").prop("checked", true);
        $("#pie_ves").prop("checked", true);
        $("#pie_inc").prop("checked", true);

//        alert(JSON.stringify(tabla_diente));

        if (tabla_diente.length == 0) {
            $("#enfermedad_cita").prop("disabled", true);
        } else {
            $("#enfermedad_cita").prop("disabled", false);
        }

        $("#ModalPiezasDie").modal("hide");
    } else {
        alert("Debe seleccionar una pieza del diente");
    }

});

var diente_edit = -1;
var index = -1;
var estado_edit = "";

$(document).on("click", ".editar_diente", function() {

    $("#aceptar_piezas").css("display", "none");
    $("#cancelar_piezas").css("display", "none");
    $("#editar_piezas").css("display", "inherit");
    $("#cancelar_editar_piezas").css("display", "inherit");

    diente_edit = $(this).parent().parent().find("td").eq(0).html();
    index = num_diente.indexOf(diente_edit);

    estado_edit = tabla_diente[index][1];

    $('input[value="' + estado_edit + '"]').eq(0).prop("checked", true);

    $("#ModalEstadoDie").modal("show");

});

$(document).on("click", "#cancelar_estado", function() {
    $("#aceptar_piezas").css("display", "inherit");
    $("#cancelar_piezas").css("display", "inherit");
    $("#editar_piezas").css("display", "none");
    $("#cancelar_editar_piezas").css("display", "none");
});

$(document).on("click", "#aceptar_estado", function() {

    estado_edit = $('input[name="estado_diente"]:checked').val();

//    alert(diente_edit);

    $("#dientes_seleccionados td:contains('" + diente_edit + "')").parent().find("td").eq(1).html(estado_edit);

    tabla_diente[index][1] = estado_edit;

    var partes = tabla_diente[index][2];

    if (partes.indexOf("0") == -1) {
        $("#pie_all").prop("checked", true);
        $("#pie_mes").prop("checked", true);
        $("#pie_dis").prop("checked", true);
        $("#pie_ocl").prop("checked", true);
        $("#pie_pal").prop("checked", true);
        $("#pie_lin").prop("checked", true);
        $("#pie_ves").prop("checked", true);
        $("#pie_inc").prop("checked", true);
    } else {
        $("#pie_all").prop("checked", false);
        $("#pie_mes").prop("checked", false);
        $("#pie_dis").prop("checked", false);
        $("#pie_ocl").prop("checked", false);
        $("#pie_pal").prop("checked", false);
        $("#pie_lin").prop("checked", false);
        $("#pie_ves").prop("checked", false);
        $("#pie_inc").prop("checked", false);
        if (partes.charAt(0) == "M") {
            $("#pie_mes").prop("checked", true);
        }
        if (partes.charAt(1) == "D") {
            $("#pie_dis").prop("checked", true);
        }
        if (partes.charAt(2) == "V") {
            $("#pie_ves").prop("checked", true);
        }
        if (partes.charAt(3) == "P") {
            $("#pie_pal").prop("checked", true);
        } else if (partes.charAt(3) == "L") {
            $("#pie_lin").prop("checked", true);
        }
        if (partes.charAt(4) == "O") {
            $("#pie_ocl").prop("checked", true);
        } else if (partes.charAt(4) == "I") {
            $("#pie_inc").prop("checked", true);
        }

    }


    restaurarDientes();
    if (diente_edit == "18" || diente_edit == "17" || diente_edit == "16" || diente_edit == "15" || diente_edit == "14" || diente_edit == "24" || diente_edit == "25" || diente_edit == "26" || diente_edit == "27" || diente_edit == "28") {
        $("#pie_inc").parent().parent().css("display", "none");
        $("#pie_lin").parent().parent().css("display", "none");
    } else if (diente_edit == "48" || diente_edit == "47" || diente_edit == "46" || diente_edit == "45" || diente_edit == "44" || diente_edit == "34" || diente_edit == "35" || diente_edit == "36" || diente_edit == "37" || diente_edit == "38") {
        $("#pie_pal").parent().parent().css("display", "none");
        $("#pie_inc").parent().parent().css("display", "none");
    } else if (diente_edit == "13" || diente_edit == "12" || diente_edit == "11" || diente_edit == "21" || diente_edit == "22" || diente_edit == "23") {
        $("#pie_lin").parent().parent().css("display", "none");
        $("#pie_ocl").parent().parent().css("display", "none");
    } else if (diente_edit == "43" || diente_edit == "42" || diente_edit == "41" || diente_edit == "31" || diente_edit == "32" || diente_edit == "33") {
        $("#pie_pal").parent().parent().css("display", "none");
        $("#pie_ocl").parent().parent().css("display", "none");
    }

    var codi_edi = "";
    $("#estados_rep option").each(function() {
        if (estado_edit == $(this).html()) {
            codi_edi = $(this).val();
            return false;
        }
    });
    var sw_img = true;
    $("#img_estados li").each(function() {
        if (diente_edit + "_" + codi_edi + ".jpg" == $(this).html()) {
            $(".btn-group a span:contains('" + diente_edit + "')").parent().find("img").attr("src", base_url + "resources/images/odontograma/" + diente_edit + "/" + $(this).html());
            sw_img = false;
        }
    });
    if (sw_img) {
        $(".btn-group a span:contains('" + diente_edit + "')").parent().find("img").attr("src", base_url + "resources/images/odontograma/" + diente_edit + "/" + diente_edit + ".jpg");
    }

    $("#ModalEstadoDie").modal("hide");
    $("#ModalPiezasDie").modal("show");

});

$(document).on("click", "#cancelar_editar_piezas", function() {
    $("#pie_all").prop("checked", true);
    $("#pie_mes").prop("checked", true);
    $("#pie_dis").prop("checked", true);
    $("#pie_ocl").prop("checked", true);
    $("#pie_pal").prop("checked", true);
    $("#pie_lin").prop("checked", true);
    $("#pie_ves").prop("checked", true);
    $("#pie_inc").prop("checked", true);

    $("#aceptar_piezas").css("display", "inherit");
    $("#cancelar_piezas").css("display", "inherit");
    $("#editar_piezas").css("display", "none");
    $("#cancelar_editar_piezas").css("display", "none");
});

$(document).on("click", "#editar_piezas", function() {

    if ($("#pie_all").is(':checked') || $("#pie_mes").is(':checked') || $("#pie_dis").is(':checked') || $("#pie_ocl").is(':checked') || $("#pie_pal").is(':checked') || $("#pie_lin").is(':checked') || $("#pie_ves").is(':checked') || $("#pie_inc").is(':checked')) {

        var select = $(".btn-group a span:contains('" + diente_edit + "')").parent();

        select.find(".parte_superior").css("background", "none");
        select.find(".parte_izquierda").css("background", "none");
        select.find(".parte_central").css("background", "none");
        select.find(".parte_derecha").css("background", "none");
        select.find(".parte_inferior").css("background", "none");

        var partes = "";
        var partes_desc = "";

        if ($("#pie_mes").is(":checked")) {
            partes += "M";
            partes_desc += " Mesial ";

            select.find(".parte_izquierda").css("background", "red");
        } else {
            partes += "0";
        }
        if ($("#pie_dis").is(":checked")) {
            partes += "D";
            partes_desc += " Distal ";

            select.find(".parte_derecha").css("background", "red");
        } else {
            partes += "0";
        }
        if ($("#pie_ves").is(":checked")) {
            partes += "V";
            partes_desc += " Vestibular ";

            select.find(".parte_superior").css("background", "red");
        } else {
            partes += "0";
        }
        if ($("#pie_pal").is(":checked") || $("#pie_lin").is(":checked")) {

            if ($("#pie_pal").is(":checked")) {
                partes += "P";
                partes_desc += " Palatino ";
            } else if ($("#pie_lin").is(":checked")) {
                partes += "L";
                partes_desc += " Lingual ";
            }

            select.find(".parte_inferior").css("background", "red");
        } else {
            partes += "0";
        }
        if ($("#pie_ocl").is(":checked") || $("#pie_inc").is(":checked")) {

            if ($("#pie_ocl").is(":checked")) {
                partes += "O";
                partes_desc += " Oclusal ";
            } else if ($("#pie_inc").is(":checked")) {
                partes += "I";
                partes_desc += " Incisal ";
            }

            select.find(".parte_central").css("background", "red");
        } else {
            partes += "0";
        }

        if (partes.indexOf("0") == -1) {
            partes_desc = "Pieza completa";
        }

//                tabla_diente.push([diente_edit, estado_edit, partes, partes_desc]);
        tabla_diente[index][2] = partes;
        tabla_diente[index][3] = partes_desc;

//                num_diente.push(diente_edit);
        $("#dientes_seleccionados td:contains('" + diente_edit + "')").parent().find("td").eq(2).html(partes_desc);
//                $("#dientes_seleccionados tbody").append("<tr><td>" + diente_edit + "</td><td>" + estado_edit + "</td><td>" + partes_desc + "</td><td style='display:none;'>" + partes + "</td><td>" + '<input type="button" class="quitar_diente btn btn-danger btn-circle fa" value="&#xf05e;">&nbsp;<input type="button" class="editar_diente btn btn-primary btn-circle fa" value="&#xf044;">' + "</td></tr>");

        diente = -1;
        diente_edit = -1;
        estado = -1;
        estado_edit = "";
        index = -1;

        $("#pie_all").prop("checked", true);
        $("#pie_mes").prop("checked", true);
        $("#pie_dis").prop("checked", true);
        $("#pie_ocl").prop("checked", true);
        $("#pie_pal").prop("checked", true);
        $("#pie_lin").prop("checked", true);
        $("#pie_ves").prop("checked", true);
        $("#pie_inc").prop("checked", true);

        $("#aceptar_piezas").css("display", "inherit");
        $("#cancelar_piezas").css("display", "inherit");
        $("#editar_piezas").css("display", "none");
        $("#cancelar_editar_piezas").css("display", "none");

        if (tabla_diente.length == 0) {
            $("#enfermedad_cita").prop("disabled", true);
        } else {
            $("#enfermedad_cita").prop("disabled", false);
        }
        $("#ModalPiezasDie").modal("hide");
    } else {
        alert("Debe seleccionar una pieza del diente");
    }
});


$("#dientes_seleccionados").on("click", ".quitar_diente", function() {
    var diente = $(this).parent().parent().find("td").eq(0).html();
    var index = num_diente.indexOf(diente);
    if (index > -1) {
        tabla_diente.splice(index, 1);
        num_diente.splice(index, 1);
    }
    $(this).parent().parent().remove();
    $("span:contains('" + diente + "')").parent().prop("disabled", false);
    $("span:contains('" + diente + "')").parent().removeClass("disabled");
//    alert(JSON.stringify(tabla_diente));

    var select = $(".btn-group a span:contains('" + diente + "')").parent();

    select.find(".parte_izquierda").css("background", "none");
    select.find(".parte_derecha").css("background", "none");
    select.find(".parte_central").css("background", "none");
    select.find(".parte_superior").css("background", "none");
    select.find(".parte_inferior").css("background", "none");

    $(".btn-group a span:contains('" + diente + "')").parent().find("img").attr("src", base_url + "resources/images/odontograma/" + diente + "/" + diente + ".jpg");

    if (tabla_diente.length == 0) {
        $("#enfermedad_cita").prop("disabled", true);
    } else {
        $("#enfermedad_cita").prop("disabled", false);
    }
});

$("#cancelar_piezas").click(function() {

    diente = -1;
    estado = -1;

    $("#pie_all").prop("checked", true);
    $("#pie_mes").prop("checked", true);
    $("#pie_dis").prop("checked", true);
    $("#pie_ocl").prop("checked", true);
    $("#pie_pal").prop("checked", true);
    $("#pie_lin").prop("checked", true);
    $("#pie_ves").prop("checked", true);
    $("#pie_inc").prop("checked", true);

});

$("#pie_all").click(function() {
    if ($(this).is(':checked')) {
        $("#pie_mes").prop("checked", true);
        $("#pie_dis").prop("checked", true);
        $("#pie_ocl").prop("checked", true);
        $("#pie_pal").prop("checked", true);
        $("#pie_lin").prop("checked", true);
        $("#pie_ves").prop("checked", true);
        $("#pie_inc").prop("checked", true);
    } else {
        $("#pie_mes").prop("checked", false);
        $("#pie_dis").prop("checked", false);
        $("#pie_ocl").prop("checked", false);
        $("#pie_pal").prop("checked", false);
        $("#pie_lin").prop("checked", false);
        $("#pie_ves").prop("checked", false);
        $("#pie_inc").prop("checked", false);
    }
});

$("#pie_mes").click(function() {
    if ($(this).is(':checked')) {
        verificarPiezasSeleccionadas();
    } else {
        if ($("#pie_all").is(':checked')) {
            $("#pie_mes").prop("checked", true);
            $("#pie_dis").prop("checked", false);
            $("#pie_ocl").prop("checked", false);
            $("#pie_pal").prop("checked", false);
            $("#pie_lin").prop("checked", false);
            $("#pie_ves").prop("checked", false);
            $("#pie_inc").prop("checked", false);
        }
        $("#pie_all").prop("checked", false);
    }
});
$("#pie_dis").click(function() {
    if ($(this).is(':checked')) {
        verificarPiezasSeleccionadas();
    } else {

        if ($("#pie_all").is(':checked')) {
            $("#pie_dis").prop("checked", true);
            $("#pie_mes").prop("checked", false);
            $("#pie_ocl").prop("checked", false);
            $("#pie_pal").prop("checked", false);
            $("#pie_lin").prop("checked", false);
            $("#pie_ves").prop("checked", false);
            $("#pie_inc").prop("checked", false);
        }

        $("#pie_all").prop("checked", false);
    }
});
$("#pie_ocl").click(function() {
    if ($(this).is(':checked')) {
        verificarPiezasSeleccionadas();
        $("#pie_inc").prop("checked", false);
    } else {

        if ($("#pie_all").is(':checked')) {
            $("#pie_ocl").prop("checked", true);
            $("#pie_mes").prop("checked", false);
            $("#pie_dis").prop("checked", false);
            $("#pie_pal").prop("checked", false);
            $("#pie_lin").prop("checked", false);
            $("#pie_ves").prop("checked", false);
            $("#pie_inc").prop("checked", false);
        }

        $("#pie_all").prop("checked", false);
    }
});
$("#pie_pal").click(function() {
    if ($(this).is(':checked')) {

        verificarPiezasSeleccionadas();
        $("#pie_lin").prop("checked", false);
    } else {

        if ($("#pie_all").is(':checked')) {
            $("#pie_pal").prop("checked", true);
            $("#pie_mes").prop("checked", false);
            $("#pie_dis").prop("checked", false);
            $("#pie_ocl").prop("checked", false);
            $("#pie_lin").prop("checked", false);
            $("#pie_ves").prop("checked", false);
            $("#pie_inc").prop("checked", false);
        }

        $("#pie_all").prop("checked", false);
    }
});
$("#pie_lin").click(function() {
    if ($(this).is(':checked')) {

        verificarPiezasSeleccionadas();
        $("#pie_pal").prop("checked", false);
    } else {

        if ($("#pie_all").is(':checked')) {
            $("#pie_lin").prop("checked", true);
            $("#pie_mes").prop("checked", false);
            $("#pie_dis").prop("checked", false);
            $("#pie_ocl").prop("checked", false);
            $("#pie_pal").prop("checked", false);
            $("#pie_ves").prop("checked", false);
            $("#pie_inc").prop("checked", false);
        }

        $("#pie_all").prop("checked", false);
    }
});
$("#pie_ves").click(function() {
    if ($(this).is(':checked')) {

        verificarPiezasSeleccionadas();
    } else {

        if ($("#pie_all").is(':checked')) {
            $("#pie_ves").prop("checked", true);
            $("#pie_mes").prop("checked", false);
            $("#pie_dis").prop("checked", false);
            $("#pie_ocl").prop("checked", false);
            $("#pie_pal").prop("checked", false);
            $("#pie_lin").prop("checked", false);
            $("#pie_inc").prop("checked", false);
        }

        $("#pie_all").prop("checked", false);
    }
});
$("#pie_inc").click(function() {
    if ($(this).is(':checked')) {

        verificarPiezasSeleccionadas();
        $("#pie_ocl").prop("checked", false);
    } else {

        if ($("#pie_all").is(':checked')) {
            $("#pie_inc").prop("checked", true);
            $("#pie_mes").prop("checked", false);
            $("#pie_dis").prop("checked", false);
            $("#pie_ocl").prop("checked", false);
            $("#pie_pal").prop("checked", false);
            $("#pie_lin").prop("checked", false);
            $("#pie_ves").prop("checked", false);
        }

        $("#pie_all").prop("checked", false);
    }
});

function verificarPiezasSeleccionadas() {
    if ($("#pie_mes").is(':checked') && $("#pie_dis").is(':checked') && ($("#pie_ocl").is(':checked') || $("#pie_inc").is(':checked')) && ($("#pie_pal").is(':checked') || $("#pie_lin").is(':checked')) && $("#pie_ves").is(':checked')) {
        $("#pie_all").prop("checked", true);
    }
}
function restaurarDientes() {
    $("#pie_mes").parent().parent().css("display", "inherit");
    $("#pie_dis").parent().parent().css("display", "inherit");
    $("#pie_ocl").parent().parent().css("display", "inherit");
    $("#pie_pal").parent().parent().css("display", "inherit");
    $("#pie_lin").parent().parent().css("display", "inherit");
    $("#pie_ves").parent().parent().css("display", "inherit");
    $("#pie_inc").parent().parent().css("display", "inherit");
}