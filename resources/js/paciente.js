var nomb_pac = "";
var apel_pac = "";
var dni_pac = "";
var telf_pac = "";
var dire_pac = "";
var emai_pac = "";
var enfe_pac = "";
var aler_pac = "";
var afil_pac = "";
var titu_pac = "";
var fena_pac = "";
var sexo_pac = "";
var civil_pac = "";

$(document).ready(function() {

    $('button[name="cancelar_paciente"]').click(function() {

        nomb_pac = "";
        apel_pac = "";
        dni_pac = "";
        telf_pac = "";
        dire_pac = "";
        emai_pac = "";
        enfe_pac = "";
        aler_pac = "";
        afil_pac = "";
        titu_pac = "";
        fena_pac = "";
        sexo_pac = "";
        civil_pac = "";
        $('input[name="codigo"]').val("");

        $("#panel-paciente").removeClass("panel-primary");
        $("#panel-paciente").addClass("panel-success");
        $("#panel-paciente").find(".panel-heading h3").html("Registro de paciente");

        $('input[name="registrar_paciente"]').css("display", "inherit");
        $('button[name="buscar_paciente"]').css("display", "inherit");
        $('input[name="limpiar_paciente"]').css("display", "inherit");
        $('input[name="editar_paciente"]').css("display", "none");
        $('button[name="cancelar_paciente"]').css("display", "none");

        $('#error_nomb_apel_1_pac').css("display", "none");
        $('#error_dni_paciente').css("display", "none");
        $('#error_dni_pac_1').css("display", "none");
        $('#error_telf_paciente').css("display", "none");
        $('#error_email_pac_1').css("display", "none");
        $('#error_email_pac_2').css("display", "none");

        $("#dni_pac").parent().removeClass("has-error");
        $("#dni_pac").parent().removeClass("has-success");
        $("#email_pac").parent().removeClass("has-error");
        $("#email_pac").parent().removeClass("has-success");

        $('input[name="limpiar_paciente"]').click();
    });

    var emai_pac_reg_1 = true;
    var emai_pac_reg_2 = true;
    var dni_pac_reg = true;

    $("#btnCancelarModalPaciente").click(function() {
        $("#ValorPaciente").val("");
    });

    $('button[name="buscar_paciente"]').click(function() {

        $.ajax({
            url: base_url + 'usuario/search_paciente',
            type: 'post',
            success: function(resultado) {
                $("#ResultadoPaciente").html(resultado);
            }
        });
    });

    function verificar_input_nombre_apellido_pac() {

        var nombre = $("#nombre_pac").val();
        var apellido = $("#apellido_pac").val();

        $.ajax({
            data: {'nombre': nombre, 'apellido': apellido},
            url: base_url + 'usuario/validar_input_nombre_apellido_pac',
            type: 'post',
            success: function(mensaje) {
                if (mensaje == "error") {
                    $("#error_nomb_apel_1_pac").css("display", "inherit");
                } else {
                    $("#error_nomb_apel_1_pac").css("display", "none");
                }
            }
        });
    }

    $("#nombre_pac").blur(function() {
        verificar_input_nombre_apellido_pac();
    });
    $("#apellido_pac").blur(function() {
        verificar_input_nombre_apellido_pac();
    });

    $("#dni_pac").blur(function() {
        if ((dni_pac != "" && dni_pac != $("#dni_pac").val()) || dni_pac == "") {
            validar_dni_pac_reg();
        } else {
            $("#dni_pac").parent().removeClass("has-error");
            $("#dni_pac").parent().removeClass("has-success");
            $("#error_dni_pac_1").css("display", "none");
            dni_pac_reg = true;
        }
    });

    function validar_dni_pac_reg() {
        $.ajax({
            data: {'dni': $("#dni_pac").val()},
            url: base_url + '/usuario/validar_exists_dni_pac',
            type: 'post',
            success: function(mensaje) {
                if (mensaje == "error") {
                    $("#dni_pac").parent().addClass("has-error");
                    $("#error_dni_pac_1").css("display", "inherit");
                    dni_pac_reg = false;
                } else {
                    dni_pac_reg = true;
                }
            }
        });
    }

    $("#form_pac").submit(function() {
        if ($("#dni_pac").val().length != 8) {
            alert("El D.N.I. debe contener 8 números");
            $("#dni_pac").focus();
            return false;
        }
        if (dni_pac != "" && dni_pac != $("#dni_pac").val()) {
            if (!dni_pac_reg) {
                alert("El D.N.I. ingresado ya se encuentra asociado con otro paciente");
                $("#dni_pac").focus();
                return false;
            }
        }
        if (!emai_pac_reg_1) {
            alert("Formato de email no válido");
            $("#email_pac").focus();
            return false;
        }
        if (emai_pac != "" && emai_pac != $("#dni_pac").val()) {
            if (!emai_pac_reg_2) {
                alert("El email ingresado ya se encuentra asociado con otro paciente");
                $("#email_pac").focus();
                return false;
            }
        } else {
            $("#email_pac").parent().removeClass("has-error");
            $("#email_pac").parent().removeClass("has-success");
            $("#error_email_pac_2").css("display", "none");
        }
    });
    // Datepicker: Fecha de nacimiento - Paciente
    $("#dp_fecha_pac").datepicker();
    // Validar entrada DNI - Paciente 
    $("#dni_pac").keydown(function(e) {
//        alert(e.which);
        $('#error_dni_paciente').css("display", "none");
        var claves_numericas = ["48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "8", "37", "39",
            "96", "97", "98", "99", "100", "101", "102", "103", "104", "105", "9"];
        for (x = 0; x < claves_numericas.length; x++) {

            if (e.which == claves_numericas[x]) {
                return true;
            }
        }
        $('#error_dni_paciente').css("display", "inline");
        setTimeout(function() {
            $('#error_dni_paciente').slideUp(1000);
        }, 2000);
        return false;
    });
    $("#dni_pac").blur(function(e) {

        var dni = $("#dni_pac").val();
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
        $("#dni_pac").val(dni_mod);
        if (dni_mod.length > 0) {

            if ($('input[name="registrar_paciente"]').is(':visible')) {
                validar_dni_pac_reg();
            } else {
                $("#dni_pac").parent().removeClass("has-error");
                $("#dni_pac").parent().removeClass("has-success");
                $("#error_dni_pac_1").css("display", "none");
                dni_pac_reg = true;
            }

        } else {
            $("#dni_pac").parent().removeClass("has-error");
            $("#dni_pac").parent().removeClass("has-success");
            $("#error_dni_pac_1").css("display", "none");
        }
    });
    $("#telefono_pac").keydown(function(e) {
//        alert(e.which);
        $('#error_telf_paciente').css("display", "none");
        var claves_numericas = ["48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "8", "37", "39",
            "96", "97", "98", "99", "100", "101", "102", "103", "104", "105", "9", "32", "189", "16"];
        for (x = 0; x < claves_numericas.length; x++) {

            if (e.which == claves_numericas[x]) {
                return true;
            }
        }
        $('#error_telf_paciente').css("display", "inline");
        setTimeout(function() {
            $('#error_telf_paciente').slideUp(1000);
        }, 2000);
        return false;
    });
    $("#telefono_pac").blur(function(e) {

        var telefono = $("#telefono_pac").val();
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
        $("#telefono_pac").val(telefono_mod);
    });
    $("#email_pac").blur(function(e) {
        $("#error_email_pac_1").css("display", "none");
        $("#error_email_pac_2").css("display", "none");
        
        var email_pac = $("#email_pac").val();
        if (email_pac.length > 0) {
            if (emai_pac != "" && emai_pac != email_pac) {
                $.ajax({
                    data: {'email': email_pac},
                    url: base_url + 'usuario/validar_input_email',
                    type: 'post',
                    success: function(mensaje) {
                        if (mensaje == "error") {
                            $("#email_pac").parent().addClass("has-error");
                            $("#error_email_pac_1").css("display", "inherit");
                            emai_pac_reg_1 = false;
                        } else {
                            emai_pac_reg_1 = true;
                            $("#email_pac").parent().removeClass("has-error");
                            $("#error_email_pac_1").css("display", "none");
                            $.ajax({
                                data: {'email_2': email_pac},
                                url: base_url + 'usuario/validar_exists_email_pac',
                                type: 'post',
                                success: function(mensaje) {
                                    if (mensaje == "error") {
                                        $("#email_pac").parent().addClass("has-error");
                                        $("#error_email_pac_2").css("display", "inherit");
                                        emai_pac_reg_2 = false;
                                    } else {
                                        $("#email_pac").parent().removeClass("has-error");
                                        $("#email_pac").parent().addClass("has-success");
                                        $("#error_email_pac_2").css("display", "none");
                                        emai_pac_reg_2 = true;
                                    }
                                }
                            });
                        }
                    }
                });
            } else if (emai_pac == "") {
                $.ajax({
                    data: {'email': email_pac},
                    url: base_url + 'usuario/validar_input_email',
                    type: 'post',
                    success: function(mensaje) {
                        if (mensaje == "error") {
                            $("#email_pac").parent().addClass("has-error");
                            $("#error_email_pac_1").css("display", "inherit");
                            emai_pac_reg_1 = false;
                        } else {
                            emai_pac_reg_1 = true;
                            $("#email_pac").parent().removeClass("has-error");
                            $("#error_email_pac_1").css("display", "none");
                            $.ajax({
                                data: {'email_2': email_pac},
                                url: base_url + 'usuario/validar_exists_email_pac',
                                type: 'post',
                                success: function(mensaje) {
                                    if (mensaje == "error") {
                                        $("#email_pac").parent().addClass("has-error");
                                        $("#error_email_pac_2").css("display", "inherit");
                                        emai_pac_reg_2 = false;
                                    } else {
                                        $("#email_pac").parent().removeClass("has-error");
                                        $("#email_pac").parent().addClass("has-success");
                                        $("#error_email_pac_2").css("display", "none");
                                        emai_pac_reg_2 = true;
                                    }
                                }
                            });
                        }
                    }
                });
            }
        } else {
            $("#email_pac").parent().removeClass("has-error");
            $("#email_pac").parent().removeClass("has-success");
            $("#error_email_pac_1").css("display", "none");
            $("#error_email_pac_2").css("display", "none");
        }

    });
});