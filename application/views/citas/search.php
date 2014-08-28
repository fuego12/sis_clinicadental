<table id="table-citas-medicas" class="table table-bordered">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Médico</th>
            <th>Paciente</th>
            <th>Hora</th>
            <th>Observación</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php

        function get_name_status_citas($status) {
            if ($status == "A") {
                return "Pendiente";
            } else if ($status == "T") {
                return "Finalizado";
            }
        }

        foreach ($citas as $row) {
            ?>
            <tr class="<?= get_name_status_citas($row->esta_cit) ?>">
                <td style="text-align: center;"><?= $row->codi_cit ?></td>
                <td><?= $row->apel_med . ', ' . $row->nomb_med ?></td>
                <td><?= $row->apel_pac . ', ' . $row->nomb_pac ?></td>
                <td style="text-align: center;"><?php
                    date_default_timezone_set('America/Lima');
                    $date = new DateTime($row->fech_cit);
                    echo date('h:i A', $date->getTimestamp());
                    ?></td>
                <td style="text-align: center;"><?php if ($row->obsv_cit != "") { ?><button type="button" class="btn btn-default btn-sm ver-observa2"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver observación"><i class="fa fa-eye-slash"></i></button><input type="hidden" value="<?= $row->obsv_cit ?>" class="txt-observa2"><?php } ?></td>
                <td style="text-align: center;"><?= get_name_status_citas($row->esta_cit) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {

        $("#table-citas-medicas").DataTable({"ordering": false});

        $('.ver-observa2').tooltip();

        $("#table-citas-medicas").on("click", ".ver-observa2", function(e) {
            var tr = $(this).parent().parent();
            var key = tr.find(".txt-observa2").val();

            if (tr.parent().find(".popover").is(":visible")) {
                $(this).popover("destroy");
                $(this).attr("data-toggle", "tooltip");
                $(this).attr("data-content", "Ver observación");
                $(this).attr("title", "Ver observación");
                $(this).attr("data-original-title", "Ver observación");
                $(this).tooltip();
            } else {
                $(this).tooltip("destroy");
                $(this).attr("data-toggle", "popover");
                $(this).attr("data-content", key);
                $(this).attr("title", "");
                $(this).attr("data-original-title", "Observación");
                $(this).popover("show");
                $('.popover-title').css('color', 'black');
                $('.popover-content').css('color', 'black');
            }

            e.stopPropagation();
        });

        $('#table-citas-medicas').on('click', 'tbody tr', function() {

            $("#editar_cita").prop("disabled", false);
            $("#editar_cita").html("Actualizar");

            codigo = $(this).find("td").eq(0).html();
            var medico = $(this).find("td").eq(1).html();
            var paciente = $(this).find("td").eq(2).html();
            var hora = $(this).find("td").eq(3).html();
            observa = $(this).find("td").eq(4).find('.txt-observa2').val();
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
            if (observa != "" && observa != "undefined") {
                $("#panel_row_citas .panel-body").append("<strong>Observación: </strong><br>" + observa + '<br>');
            }

            $("#ModalAccionesCita").modal("show");

        });

    });
</script>