<?= form_open(base_url() . 'citas/nuevo', $form) ?>
<fieldset>
    <div class="modal-body">
        <div class="row" style="margin-top: 2%">
            <div style="margin: 20px;">
                <div id="panel-nueva-cita" class="login-panel panel panel-primary">
                    <div class="panel-body">

                        <div id="error_hora_cita" class="alert alert-danger alert-dismissable"
                             style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Alerta: </strong>Ya existe una cita médica programada a la hora seleccionada
                        </div>
                        <div class="form-group">
                            <label>Fecha:</label>
                            <?php date_default_timezone_set('America/Lima'); $date = date("Y-m-d"); ?>
                            <input id="fecha_cita" type="date" name="fecha" min="<?= $fecha_actual ?>" value="<?= $fecha_actual ?>" id="fecha_nueva_cita" class="form-control" size="16" style="width: 170px;" required>
                        </div>
                        <div class="form-group">
                            <label>Hora:</label>
                            <input id="hora_cita" type="time" name="hora" class="form-control" value="<?= $hora_actual ?>" style="width: 100px;" required>
                        </div>
                        <div class="form-group">
                            <label>Médico: </label>
                            <?= form_dropdown('medico', $medicos, array(), 'class="form-control"') ?>
                        </div>
                        <div class="form-group">
                            <label>Paciente: </label>
                            <?= form_input($paciente) ?>
                        </div>
                        <div class="form-group">
                            <label>Observación: </label>
                            <?= form_textarea($observacion) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="msj_error_pac_cita" class="alert alert-danger" style="display: none;">
            El paciente ingresado no se encuentra registrado.<br>
            <strong>Por favor, haga click <a href="<?= base_url() ?>paciente">aquí</a> para registrar el paciente.</strong>
        </div>
    </div>
    <div class="modal-footer">
        <div style="float: right;">
            <?= form_button($cancelar_nueva_cita) ?>
            <?= form_submit($registrar_nueva_cita) ?>
        </div>
    </div>
</fieldset>
<?= form_close() ?>
<script>
    $(document).ready(function() {

        $.ajax({
            url: base_url + 'usuario/get_paciente_autocomplete',
            type: 'post',
            success: function(resultado) {
                var pacientes = $.parseJSON(resultado);
                $("#paciente_cit").autocomplete({
                    source: pacientes
                });
            }
        });

//        $("#paciente_cit").blur(function() {
//            if ($("#paciente_cit").val() != "") {
//                $.ajax({
//                    data: {'hora': $("#hora_cita").val(), 'fecha': $("#fecha_cita").val()},
//                    url: base_url + 'citas/verificar_hora_cita',
//                    type: 'post',
//                    success: function(resultado) {
//                        if (resultado == "error") {
//                            $("#error_hora_cita").css("display", "inherit");
//                            $('input[name="registar_nueva_cita"').prop("disabled", true);
//                            $("#paciente_cit").prop("disabled", true);
//                        } else {
//                            $("#paciente_cit").prop("disabled", false);
//                            $.ajax({
//                                data: {'nombre': $("#paciente_cit").val()},
//                                url: base_url + 'usuario/verificar_paciente_cita',
//                                type: 'post',
//                                success: function(resultado) {
//                                    if (resultado == "error") {
//                                        $('input[name="registar_nueva_cita"').prop("disabled", true);
//                                        $("#msj_error_pac_cita").css("display", "inherit");
//                                    } else {
//                                        $("#error_hora_cita").css("display", "none");
//                                        $("#msj_error_pac_cita").css("display", "none");
//                                        $('input[name="registar_nueva_cita"').prop("disabled", false);
//                                    }
//                                }
//                            });
//                        }
//                    }
//                });
//            } else {
//                $('input[name="registar_nueva_cita"').prop("disabled", true);
//                $("#msj_error_pac_cita").css("display", "none");
//            }
//        });

        $(".modal-body").on("click", ".ui-menu-item", function() {

//            $.ajax({
//                data: {'hora': $("#hora_cita").val(), 'fecha': $("#fecha_cita").val()},
//                url: base_url + 'citas/verificar_hora_cita',
//                type: 'post',
//                success: function(resultado) {
//                    if (resultado == "error") {
//                        $("#error_hora_cita").css("display", "inherit");
//                        $('input[name="registar_nueva_cita"').prop("disabled", true);
//                    } else {
//                        $("#error_hora_cita").css("display", "none");
//                        $('input[name="registar_nueva_cita"').prop("disabled", false);
//                        $("#msj_error_pac_cita").css("display", "none");
//                    }
//                }
//            });

        });

        $("#observa_cit").css("max-width", $("#observa_cit").css("width"));
        $("#observa_cit").css("max-height", "75px");

//        $("#hora_cita").blur(function() {
//            $.ajax({
//                data: {'hora': $("#hora_cita").val(), 'fecha': $("#fecha_cita").val()},
//                url: base_url + 'citas/verificar_hora_cita',
//                type: 'post',
//                success: function(resultado) {
//                    if (resultado == "error") {
//                        $("#error_hora_cita").css("display", "inherit");
//                        $('input[name="registar_nueva_cita"').prop("disabled", true);
//                        $("#paciente_cit").prop("disabled", true);
//                    } else {
//                        $("#paciente_cit").prop("disabled", false);
//                        $("#error_hora_cita").css("display", "none");
//
//                        if ($("#paciente_cit").val() != "") {
//                            $.ajax({
//                                data: {'nombre': $("#paciente_cit").val()},
//                                url: base_url + 'usuario/verificar_paciente_cita',
//                                type: 'post',
//                                success: function(resultado) {
//                                    if (resultado == "error") {
//                                        $('input[name="registar_nueva_cita"').prop("disabled", true);
//                                        $("#msj_error_pac_cita").css("display", "inherit");
//                                    } else {
//                                        $('input[name="registar_nueva_cita"').prop("disabled", false);
//                                        $("#msj_error_pac_cita").css("display", "none");
//                                    }
//                                }
//                            });
//                        } else {
//                            $('input[name="registar_nueva_cita"').prop("disabled", true);
//                            $("#msj_error_pac_cita").css("display", "none");
//                        }
//                    }
//                }
//            });
//        });
//        $("#fecha_cita").blur(function() {
//            $.ajax({
//                data: {'hora': $("#hora_cita").val(), 'fecha': $("#fecha_cita").val()},
//                url: base_url + 'citas/verificar_hora_cita',
//                type: 'post',
//                success: function(resultado) {
//                    if (resultado == "error") {
//                        $("#error_hora_cita").css("display", "inherit");
//                        $('input[name="registar_nueva_cita"').prop("disabled", true);
//                        $("#paciente_cit").prop("disabled", true);
//                    } else {
//                        $("#paciente_cit").prop("disabled", false);
//                        $("#error_hora_cita").css("display", "none");
//
//                        if ($("#paciente_cit").val() != "") {
//                            $.ajax({
//                                data: {'nombre': $("#paciente_cit").val()},
//                                url: base_url + 'usuario/verificar_paciente_cita',
//                                type: 'post',
//                                success: function(resultado) {
//                                    if (resultado == "error") {
//                                        $('input[name="registar_nueva_cita"').prop("disabled", true);
//                                        $("#msj_error_pac_cita").css("display", "inherit");
//                                    } else {
//                                        $('input[name="registar_nueva_cita"').prop("disabled", false);
//                                        $("#msj_error_pac_cita").css("display", "none");
//                                    }
//                                }
//                            });
//                        } else {
//                            $('input[name="registar_nueva_cita"').prop("disabled", true);
//                            $("#msj_error_pac_cita").css("display", "none");
//                        }
//                    }
//                }
//            });
//        });
    });
</script>