<div class="table-responsive">
    <table id="table-procedimientos" class="table table-bordered">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Procedimiento</th>
                <th>Categotia</th>
                <th>Costo</th>
                <th>Grupo</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultado as $row) { ?>
                <tr style="background-color: none;">
                    <td><?= $row->codi_tar ?></td>
                    <td><?= $row->desc_pro ?></td>
                    <td><?= $row->nomb_cat ?></td>
                    <td><?= $row->cost_tar ?></td>
                    <td><?= $row->grup_pro ?></td>
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>

    $(document).ready(function() {

        $("#table-procedimientos").DataTable();

        $("#table-procedimientos_paginate").on('click', function() {
            $('#table-procedimientos tbody tr').css('background-color', '#FFF');
            $('#table-procedimientos tbody tr').css('color', '#000');
            if (codi_pro != -1) {
                var sw = false;
                $('#table-procedimientos tbody tr').each(function() {
                    if ($(this).find('td').eq(0).html() == codi_pro) {
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

        $("#table-procedimientos_filter input").blur(function() {
            $('#table-procedimientos tbody tr').css('background-color', '#FFF');
            $('#table-procedimientos tbody tr').css('color', '#000');
            if (codi_pro != -1) {
                var sw = false;
                $('#table-procedimientos tbody tr').each(function() {
                    if ($(this).find('td').eq(0).html() == codi_pro) {
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

        $('#table-procedimientos').on('click', 'tbody tr', function() {

            var tr_select = $(this);

            if ((tr_select.css("background-color") == "rgb(255, 255, 255)") || (tr_select.css("background-color") == "rgba(0, 0, 0, 0)")) {

                $('#table-procedimientos tbody tr').css('background-color', '#FFF');
                $('#table-procedimientos tbody tr').css('color', '#000');
                tr_select.css('background-color', '#bce8f1');
                tr_select.css('color', '#31708f');
                codi_pro = tr_select.find("td").eq(0).html();

                $('#btnEditarModalMedico').prop("disabled", false);
                $('#btnDeshabilitarMedico').prop("disabled", false);

            } else if (tr_select.css("background-color") == 'rgb(188, 232, 241)') {

                $('#table-procedimientos tbody tr').css('background-color', '#FFF');
                $('#table-procedimientos tbody tr').css('color', '#000');
                codi_pro = -1;

                $('#btnEditarModalMedico').prop("disabled", true);
                $('#btnDeshabilitarMedico').prop("disabled", true);
            }

        });
        

        
    });
</script>


