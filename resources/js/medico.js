var nomb_med = "";
var apel_med = "";
var dni_med = "";
var telf_med = "";
var dire_med = "";
var emai_med = "";
var fena_med = "";
var sexo_med = "";

$(document).ready(function() {

    $('button[name="cancelar_medico"]').click(function() {

        nomb_med = "";
        apel_med = "";
        dni_med = "";
        telf_med = "";
        dire_med = "";
        emai_med = "";
        fena_med = "";
        sexo_med = "";
        $('input[name="codigo"]').val("");

        $("#panel-medico").removeClass("panel-primary");
        $("#panel-medico").addClass("panel-success");
        $("#panel-medico").find(".panel-heading h3").html("Registro de médico");

        $('input[name="registar_medico"]').css("display", "inherit");
        $('button[name="buscar_medico"]').css("display", "inherit");
        $('input[name="limpiar_medico"]').css("display", "inherit");
        $('input[name="editar_medico"]').css("display", "none");
        $('button[name="cancelar_medico"]').css("display", "none");

        $('#error_nomb_apel_1').css("display", "none");
        $('#error_dni_medico').css("display", "none");
        $('#error_dni_med_1').css("display", "none");
        $('#error_telf_medico').css("display", "none");
        $('#error_email_med_1').css("display", "none");
        $('#error_email_med_2').css("display", "none");

        $("#dni_med").parent().removeClass("has-error");
        $("#dni_med").parent().removeClass("has-success");
        $("#email_med").parent().removeClass("has-error");
        $("#email_med").parent().removeClass("has-success");
        
        $('input[name="limpiar_medico"]').click();
    });

    var emai_med_reg_1 = true;
    var emai_med_reg_2 = true;
    var dni_med_reg = true;

    $("#btnCancelarModalMedico").click(function() {
        $("#ValorMedico").val("");
    });

    $('button[name="buscar_medico"]').click(function() {

        $.ajax({
            url: base_url + 'usuario/search_medico',
            type: 'post',
            success: function(resultado) {
                $("#ResultadoMedico").html(resultado);
            }
        });
    });

    function verificar_input_nombre_apellido() {

        var nombre = $("#nombre_med").val();
        var apellido = $("#apellido_med").val();

        $.ajax({
            data: {'nombre': nombre, 'apellido': apellido},
            url: base_url + 'usuario/validar_input_nombre_apellido_med',
            type: 'post',
            success: function(mensaje) {
                if (mensaje == "error") {
                    $("#error_nomb_apel_1").css("display", "inherit");
                } else {
                    $("#error_nomb_apel_1").css("display", "none");
                }
            }
        });
    }

    $("#nombre_med").blur(function() {
        verificar_input_nombre_apellido();
    });
    $("#apellido_med").blur(function() {
        verificar_input_nombre_apellido();
    });

    $("#dni_med").blur(function() {
        if ((dni_med != "" && dni_med != $("#dni_med").val()) || dni_med == "") {
            validar_dni_med_reg();
        } else {
            $("#dni_med").parent().removeClass("has-error");
            $("#dni_med").parent().removeClass("has-success");
            $("#error_dni_med_1").css("display", "none");
            dni_med_reg = true;
        }
    });

    function validar_dni_med_reg() {
        $.ajax({
            data: {'dni': $("#dni_med").val()},
            url: base_url + 'usuario/validar_exists_dni_med',
            type: 'post',
            success: function(mensaje) {
                if (mensaje == "error") {
                    $("#dni_med").parent().addClass("has-error");
                    $("#error_dni_med_1").css("display", "inherit");
                    dni_med_reg = false;
                } else {
                    dni_med_reg = true;
                }
            }
        });
    }

    $("#form_med").submit(function() {
        if ($("#dni_med").val().length != 8) {
            alert("El D.N.I. debe contener 8 números");
            $("#dni_med").focus();
            return false;
        }
        if (dni_med != "" && dni_med != $("#dni_med").val()) {
            if (!dni_med_reg) {
                alert("El D.N.I. ingresado ya se encuentra asociado con otro médico");
                $("#dni_med").focus();
                return false;
            }
        }
        if (!emai_med_reg_1) {
            alert("Formato de email no válido");
            $("#email_med").focus();
            return false;
        }
        if (emai_med != "" && emai_med != $("#dni_med").val()) {
            if (!emai_med_reg_2) {
                alert("El email ingresado ya se encuentra asociado con otro médico");
                $("#email_med").focus();
                return false;
            }
        } else {
            $("#email_med").parent().removeClass("has-error");
            $("#email_med").parent().removeClass("has-success");
            $("#error_email_med_2").css("display", "none");
        }
    });
    // Datepicker: Fecha de nacimiento - Medico
    $("#dp_fecha_med").datepicker();
    // Validar entrada DNI - Medico 
    $("#dni_med").keydown(function(e) {
//        alert(e.which);
        $('#error_dni_medico').css("display", "none");
        var claves_numericas = ["48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "8", "37", "39",
            "96", "97", "98", "99", "100", "101", "102", "103", "104", "105", "9"];
        for (x = 0; x < claves_numericas.length; x++) {

            if (e.which == claves_numericas[x]) {
                return true;
            }
        }
        $('#error_dni_medico').css("display", "inline");
        setTimeout(function() {
            $('#error_dni_medico').slideUp(1000);
        }, 2000);
        return false;
    });
    $("#dni_med").blur(function(e) {

        var dni = $("#dni_med").val();
        var claves_numericas = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        var caracter_no_valido = [];
        for (var i = 0; i < dni.length; i++) {
            var caracter = dni.charAt(i);
            var caracter_valido = false;
            for (x = 0; x < claves_numericas.length; x++) {

                if (caracter == claves_numericas[x]) {
                    caracter_valido = true;
                }
            }

            if (!caracter_valido) {

                var find_caracter_no_valido = false;
                for (x = 0; x < caracter_no_valido.length; x++) {

                    if (caracter == caracter_no_valido[x]) {
                        find_caracter_no_valido = true;
                    }
                }
                if (!find_caracter_no_valido) {
                    caracter_no_valido.push(caracter);
                }
            }
        }
        var dni_mod = dni;
        for (var i = 0; i < dni.length; i++) {
            var char = dni.charAt(i);
            for (x = 0; x < caracter_no_valido.length; x++) {
                if (char == caracter_no_valido[x]) {
                    dni_mod = dni_mod.replace(caracter_no_valido[x], '');
                    break;
                }
            }
        }
        $("#dni_med").val(dni_mod);
        if (dni_mod.length > 0) {

            if ($('input[name="registar_medico"]').is(':visible')) {
                validar_dni_med_reg();
            } else {
                $("#dni_med").parent().removeClass("has-error");
                $("#dni_med").parent().removeClass("has-success");
                $("#error_dni_med_1").css("display", "none");
                dni_med_reg = true;
            }

        } else {
            $("#dni_med").parent().removeClass("has-error");
            $("#dni_med").parent().removeClass("has-success");
            $("#error_dni_med_1").css("display", "none");
        }
    });
    $("#telefono_med").keydown(function(e) {
//        alert(e.which);
        $('#error_telf_medico').css("display", "none");
        var claves_numericas = ["48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "8", "37", "39",
            "96", "97", "98", "99", "100", "101", "102", "103", "104", "105", "9", "32", "189", "16"];
        for (x = 0; x < claves_numericas.length; x++) {

            if (e.which == claves_numericas[x]) {
                return true;
            }
        }
        $('#error_telf_medico').css("display", "inline");
        setTimeout(function() {
            $('#error_telf_medico').slideUp(1000);
        }, 2000);
        return false;
    });
    $("#telefono_med").blur(function(e) {

        var telefono = $("#telefono_med").val();
        var claves_numericas = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "(", ")", " ", "-"];
        var caracter_no_valido = [];
        for (var i = 0; i < telefono.length; i++) {
            var caracter = telefono.charAt(i);
            var caracter_valido = false;
            for (x = 0; x < claves_numericas.length; x++) {

                if (caracter == claves_numericas[x]) {
                    caracter_valido = true;
                }
            }

            if (!caracter_valido) {

                var find_caracter_no_valido = false;
                for (x = 0; x < caracter_no_valido.length; x++) {

                    if (caracter == caracter_no_valido[x]) {
                        find_caracter_no_valido = true;
                    }
                }
                if (!find_caracter_no_valido) {
                    caracter_no_valido.push(caracter);
                }

            }
        }
        var telefono_mod = telefono

        for (var i = 0; i < telefono.length; i++) {
            var char = telefono.charAt(i);
            for (x = 0; x < caracter_no_valido.length; x++) {
                if (char == caracter_no_valido[x]) {
                    telefono_mod = telefono_mod.replace(caracter_no_valido[x], '');
                    break;
                }
            }
        }
        $("#telefono_med").val(telefono_mod);
    });
    $("#email_med").blur(function(e) {
        $("#error_email_med_1").css("display", "none");
        $("#error_email_med_2").css("display", "none");
        
        var email_med = $("#email_med").val();
        if (email_med.length > 0) {
            if (emai_med != "" && emai_med != email_med) {
                $.ajax({
                    data: {'email': email_med},
                    url: base_url + 'usuario/validar_input_email',
                    type: 'post',
                    success: function(mensaje) {
                        if (mensaje == "error") {
                            $("#email_med").parent().addClass("has-error");
                            $("#error_email_med_1").css("display", "inherit");
                            emai_med_reg_1 = false;
                        } else {
                            emai_med_reg_1 = true;
                            $("#email_med").parent().removeClass("has-error");
                            $("#error_email_med_1").css("display", "none");
                            $.ajax({
                                data: {'email_2': email_med},
                                url: base_url + 'usuario/validar_exists_email_med',
                                type: 'post',
                                success: function(mensaje) {
                                    if (mensaje == "error") {
                                        $("#email_med").parent().addClass("has-error");
                                        $("#error_email_med_2").css("display", "inherit");
                                        emai_med_reg_2 = false;
                                    } else {
                                        $("#email_med").parent().removeClass("has-error");
                                        $("#email_med").parent().addClass("has-success");
                                        $("#error_email_med_2").css("display", "none");
                                        emai_med_reg_2 = true;
                                    }
                                }
                            });
                        }
                    }
                });
            } else if (emai_med == "") {
                $.ajax({
                    data: {'email': email_med},
                    url: base_url + '/usuario/validar_input_email',
                    type: 'post',
                    success: function(mensaje) {
                        if (mensaje == "error") {
                            $("#email_med").parent().addClass("has-error");
                            $("#error_email_med_1").css("display", "inherit");
                            emai_med_reg_1 = false;
                        } else {
                            emai_med_reg_1 = true;
                            $("#email_med").parent().removeClass("has-error");
                            $("#error_email_med_1").css("display", "none");
                            $.ajax({
                                data: {'email_2': email_med},
                                url: base_url + 'usuario/validar_exists_email_med',
                                type: 'post',
                                success: function(mensaje) {
                                    if (mensaje == "error") {
                                        $("#email_med").parent().addClass("has-error");
                                        $("#error_email_med_2").css("display", "inherit");
                                        emai_med_reg_2 = false;
                                    } else {
                                        $("#email_med").parent().removeClass("has-error");
                                        $("#email_med").parent().addClass("has-success");
                                        $("#error_email_med_2").css("display", "none");
                                        emai_med_reg_2 = true;
                                    }
                                }
                            });
                        }
                    }
                });
            }
        } else {
            $("#email_med").parent().removeClass("has-error");
            $("#email_med").parent().removeClass("has-success");
            $("#error_email_med_1").css("display", "none");
            $("#error_email_med_2").css("display", "none");
        }

    });
});