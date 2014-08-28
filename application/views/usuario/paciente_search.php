<div class="table-responsive">
    <table id="table-search-paciente" class="table table-bordered">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombres y apellidos</th>
                <th>D.N.I.</th>
                <th>Teléfono</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultado as $row) { ?>
                <tr style="background-color: none;">
                    <td><?= $row->codi_pac ?></td>
                    <td><?= $row->apel_pac . ', ' . $row->nomb_pac ?></td>
                    <td><?= $row->dni_pac ?></td>
                    <td><?= $row->telf_pac ?></td>
                    <td><?= $row->emai_pac ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>

    $(document).ready(function() {

        $("#table-search-paciente").DataTable();

        var codi_pac = -1;

        $("#table-search-paciente_paginate").on('click', function() {
            $('#table-search-paciente tbody tr').css('background-color', '#FFF');
            $('#table-search-paciente tbody tr').css('color', '#000');
            if (codi_pac != -1) {
                var sw = false;
                $('#table-search-paciente tbody tr').each(function() {
                    if ($(this).find('td').eq(0).html() == codi_pac) {
                        sw = true;
                        $(this).css('background-color', '#bce8f1');
                        $(this).css('color', '#31708f');
                    }
                });
                if (!sw) {
                    $('#btnEditarModalPaciente').prop("disabled", true);
                    $('#btnDeshabilitarPaciente').prop("disabled", true);
                } else {
                    $('#btnEditarModalPaciente').prop("disabled", false);
                    $('#btnDeshabilitarPaciente').prop("disabled", false);
                }
            } else {
                $('#btnEditarModalPaciente').prop("disabled", true);
                $('#btnDeshabilitarPaciente').prop("disabled", true);
            }
        });

        $("#table-search-paciente_filter input").blur(function() {
            $('#table-search-paciente tbody tr').css('background-color', '#FFF');
            $('#table-search-paciente tbody tr').css('color', '#000');
            if (codi_pac != -1) {
                var sw = false;
                $('#table-search-paciente tbody tr').each(function() {
                    if ($(this).find('td').eq(0).html() == codi_pac) {
                        sw = true;
                        $(this).css('background-color', '#bce8f1');
                        $(this).css('color', '#31708f');
                    }
                });
                if (!sw) {
                    $('#btnEditarModalPaciente').prop("disabled", true);
                    $('#btnDeshabilitarPaciente').prop("disabled", true);
                } else {
                    $('#btnEditarModalPaciente').prop("disabled", false);
                    $('#btnDeshabilitarPaciente').prop("disabled", false);
                }
            } else {
                $('#btnEditarModalPaciente').prop("disabled", true);
                $('#btnDeshabilitarPaciente').prop("disabled", true);
            }
        });

        $('#table-search-paciente').on('click', 'tbody tr', function() {

            var tr_select = $(this);

            if ((tr_select.css("background-color") == "rgb(255, 255, 255)") || (tr_select.css("background-color") == "rgba(0, 0, 0, 0)")) {

                $('#table-search-paciente tbody tr').css('background-color', '#FFF');
                $('#table-search-paciente tbody tr').css('color', '#000');
                tr_select.css('background-color', '#bce8f1');
                tr_select.css('color', '#31708f');
                codi_pac = tr_select.find("td").eq(0).html();

                $('#btnEditarModalPaciente').prop("disabled", false);
                $('#btnDeshabilitarPaciente').prop("disabled", false);

            } else if (tr_select.css("background-color") == 'rgb(188, 232, 241)') {

                $('#table-search-paciente tbody tr').css('background-color', '#FFF');
                $('#table-search-paciente tbody tr').css('color', '#000');
                codi_pac = -1;

                $('#btnEditarModalPaciente').prop("disabled", true);
                $('#btnDeshabilitarPaciente').prop("disabled", true);
            }

        });
        $('#btnEditarModalPaciente').click(function() {

            $.ajax({
                data: {'codi_pac': codi_pac},
                url: base_url + 'usuario/get_paciente',
                type: 'post',
                success: function(resultado) {
                    var paciente = $.parseJSON(resultado);

                    nomb_pac = paciente[0]['nomb_pac'];
                    apel_pac = paciente[0]['apel_pac'];
                    dni_pac = paciente[0]['dni_pac'];
                    telf_pac = paciente[0]['telf_pac'];
                    dire_pac = paciente[0]['dire_pac'];
                    emai_pac = paciente[0]['emai_pac'];
                    enfe_pac = paciente[0]['enfe_pac'];
                    afil_pac = paciente[0]['afil_pac'];
                    titu_pac = paciente[0]['titu_pac'];
                    aler_pac = paciente[0]['aler_pac'];
                    fena_pac = paciente[0]['fena_pac'];
                    sexo_pac = paciente[0]['sexo_pac'];
                    civil_pac = paciente[0]['civil_pac'];

                    $('input[name="codigo"]').val(codi_pac);
                    $("#nombre_pac").val(nomb_pac);
                    $("#apellido_pac").val(apel_pac);
                    $("#dni_pac").val(dni_pac);
                    $("#telefono_pac").val(telf_pac);
                    $("#direccion_pac").val(dire_pac);
                    $("#email_pac").val(emai_pac);
                    $("#enfermedad_pac").val(enfe_pac);
                    $("#afiliacion_pac").val(afil_pac);
                    $("#titular_pac").val(titu_pac);
                    $("#alergia_pac").val(aler_pac);
                    $("#fecha_pac").val(fena_pac);
                    if (sexo_pac == "M") {
                        $("#masculino_pac").prop("checked", true);
                    } else if (sexo_pac == "F") {
                        $("#femenino_pac").prop("checked", true);
                    }
                    if (civil_pac == "S") {
                        $("#soltero_pac").prop("checked", true);
                    } else if (civil_pac == "C") {
                        $("#casado_pac").prop("checked", true);
                    } else if (civil_pac == "D") {
                        $("#divorciado_pac").prop("checked", true);
                    }

                    $("#panel-paciente").removeClass("panel-success");
                    $("#panel-paciente").addClass("panel-primary");
                    $("#panel-paciente").find(".panel-heading h3").html("Editar paciente");

                    $('input[name="registrar_paciente"]').css("display", "none");
                    $('button[name="buscar_paciente"]').css("display", "none");
                    $('input[name="limpiar_paciente"]').css("display", "none");
                    $('input[name="editar_paciente"]').css("display", "inherit");
                    $('button[name="cancelar_paciente"]').css("display", "inherit");

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

                    $("#btnCancelarModalPaciente").click();
                }
            });

        });

        $("#deshabilitarPaciente").click(function() {
            $.ajax({
                data: {'codi_pac': codi_pac},
                url: base_url + 'usuario/deshabilitar_paciente',
                type: 'post',
                success: function(e) {
                    $(location).attr('href', base_url + "paciente");
                }
            });
        });
    });
</script>
