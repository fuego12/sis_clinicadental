<div class="table-responsive">
    <table id="table-search-medico" class="table table-bordered">
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
                    <td><?= $row->codi_med ?></td>
                    <td><?= $row->apel_med . ', ' . $row->nomb_med ?></td>
                    <td><?= $row->dni_med ?></td>
                    <td><?= $row->telf_med ?></td>
                    <td><?= $row->emai_med ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>

    $(document).ready(function() {

        $("#table-search-medico").DataTable();

        var codi_med = -1;

        $("#table-search-medico_paginate").on('click', function() {
            $('#table-search-medico tbody tr').css('background-color', '#FFF');
            $('#table-search-medico tbody tr').css('color', '#000');
            if (codi_med != -1) {
                var sw = false;
                $('#table-search-medico tbody tr').each(function() {
                    if ($(this).find('td').eq(0).html() == codi_med) {
                        sw = true;
                        $(this).css('background-color', '#bce8f1');
                        $(this).css('color', '#31708f');
                    }
                });
                if (!sw) {
                    $('#btnEditarModalMedico').prop("disabled", true);
                    $('#btnDeshabilitarMedico').prop("disabled", true);
                } else {
                    $('#btnEditarModalMedico').prop("disabled", false);
                    $('#btnDeshabilitarMedico').prop("disabled", false);
                }
            } else {
                $('#btnEditarModalMedico').prop("disabled", true);
                $('#btnDeshabilitarMedico').prop("disabled", true);
            }
        });

        $("#table-search-medico_filter input").blur(function() {
            $('#table-search-medico tbody tr').css('background-color', '#FFF');
            $('#table-search-medico tbody tr').css('color', '#000');
            if (codi_med != -1) {
                var sw = false;
                $('#table-search-medico tbody tr').each(function() {
                    if ($(this).find('td').eq(0).html() == codi_med) {
                        sw = true;
                        $(this).css('background-color', '#bce8f1');
                        $(this).css('color', '#31708f');
                    }
                });
                if (!sw) {
                    $('#btnEditarModalMedico').prop("disabled", true);
                    $('#btnDeshabilitarMedico').prop("disabled", true);
                } else {
                    $('#btnEditarModalMedico').prop("disabled", false);
                    $('#btnDeshabilitarMedico').prop("disabled", false);
                }
            } else {
                $('#btnEditarModalMedico').prop("disabled", true);
                $('#btnDeshabilitarMedico').prop("disabled", true);
            }
        });

        $('#table-search-medico').on('click', 'tbody tr', function() {

            var tr_select = $(this);

            if ((tr_select.css("background-color") == "rgb(255, 255, 255)") || (tr_select.css("background-color") == "rgba(0, 0, 0, 0)")) {

                $('#table-search-medico tbody tr').css('background-color', '#FFF');
                $('#table-search-medico tbody tr').css('color', '#000');
                tr_select.css('background-color', '#bce8f1');
                tr_select.css('color', '#31708f');
                codi_med = tr_select.find("td").eq(0).html();

                $('#btnEditarModalMedico').prop("disabled", false);
                $('#btnDeshabilitarMedico').prop("disabled", false);

            } else if (tr_select.css("background-color") == 'rgb(188, 232, 241)') {

                $('#table-search-medico tbody tr').css('background-color', '#FFF');
                $('#table-search-medico tbody tr').css('color', '#000');
                codi_med = -1;

                $('#btnEditarModalMedico').prop("disabled", true);
                $('#btnDeshabilitarMedico').prop("disabled", true);
            }

        });
        $('#btnEditarModalMedico').click(function() {

            $.ajax({
                data: {'codi_med': codi_med},
                url: base_url + 'usuario/get_medico',
                type: 'post',
                success: function(resultado) {
                    var medico = $.parseJSON(resultado);

                    nomb_med = medico[0]['nomb_med'];
                    apel_med = medico[0]['apel_med'];
                    dni_med = medico[0]['dni_med'];
                    telf_med = medico[0]['telf_med'];
                    dire_med = medico[0]['dire_med'];
                    emai_med = medico[0]['emai_med'];
                    fena_med = medico[0]['fena_med'];
                    sexo_med = medico[0]['sexo_med'];

                    $('input[name="codigo"]').val(codi_med);
                    $("#nombre_med").val(nomb_med);
                    $("#apellido_med").val(apel_med);
                    $("#dni_med").val(dni_med);
                    $("#telefono_med").val(telf_med);
                    $("#direccion_med").val(dire_med);
                    $("#email_med").val(emai_med);
                    $("#fecha_med").val(fena_med);
                    if (sexo_med == "M") {
                        $("#masculino_med").prop("checked", true);
                    } else if (sexo_med == "F") {
                        $("#femenino_med").prop("checked", true);
                    }

                    $("#panel-medico").removeClass("panel-success");
                    $("#panel-medico").addClass("panel-primary");
                    $("#panel-medico").find(".panel-heading h3").html("Editar médico");


                    $('input[name="registar_medico"]').css("display", "none");
                    $('button[name="buscar_medico"]').css("display", "none");
                    $('input[name="limpiar_medico"]').css("display", "none");
                    $('input[name="editar_medico"]').css("display", "inherit");
                    $('button[name="cancelar_medico"]').css("display", "inherit");

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

                    $("#btnCancelarModalMedico").click();
                }
            });

        });

        $("#deshabilitarMedico").click(function() {
            $.ajax({
                data: {'codi_med': codi_med},
                url: base_url + 'usuario/deshabilitar_medico',
                type: 'post',
                success: function(e) {
                    $(location).attr('href', base_url + "medico");
                }
            });
        });
    });
</script>
