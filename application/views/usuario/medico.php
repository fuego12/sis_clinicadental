<div>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li><a href="<?= base_url() ?>">Inicio</a>
                </li>
                <li class="active">Registro de médicos</li>
            </ol>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 2%">
    <div class="col-md-5 col-md-offset-4">
        <div id="panel-medico" class="login-panel panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Registro de médico</h3>
            </div>
            <div class="panel-body">
                <?= form_open(base_url() . 'medico', $form) ?>
                <fieldset>
                    <?php if ($this->session->userdata('error_medico_1') && $this->session->userdata('error_medico_1') != "") { ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->userdata('error_medico_1') ?>
                        </div>
                        <?php
                        $this->session->unset_userdata('error_medico_1');
                    }
                    ?>
                    <div id="error_nomb_apel_1" class="alert alert-warning alert-dismissable"
                         style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Alerta: </strong>El nombre y apellido ingresados ya se encuentra registrado
                    </div>

                    <?= form_hidden('codigo', '') ?>
                    <div class="form-group">
                        <label>Nombres: *</label>
                        <?= form_input($nombres) ?>
                    </div>
                    <div class="form-group">
                        <label>Apellidos: *</label>
                        <?= form_input($apellidos) ?>
                    </div>
                    <div class="form-group">
                        <label>Documento nacional de identidad (D.N.I.): *</label>
                        <?= form_input($dni) ?>
                        <label class="text-danger" id="error_dni_medico" style="display: none;">&nbsp;Carácter no válido</label>
                        <label class="text-danger" id="error_dni_med_1" style="display: none;">&nbsp;Ya se encuentra asociado a otro médico</label>
                    </div>
                    <div class="form-group">
                        <label>Número de teléfono: *</label>
                        <?= form_input($telefono) ?>
                        <label class="text-danger" id="error_telf_medico" style="display: none;">&nbsp;Carácter no válido</label>
                    </div>
                    <div class="form-group">
                        <label>Dirección:</label>
                        <?= form_input($direccion) ?>
                    </div>
                    <div class="form-group">
                        <label>E-mail:</label>
                        <?= form_input($email) ?>
                        <label class="text-danger" id="error_email_med_1" style="display: none;">&nbsp;Formato de email no válido</label>
                        <label class="text-danger" id="error_email_med_2" style="display: none;">&nbsp;Ya se encuentra asociado a otro médico</label>
                    </div>
                    <label>Fecha de nacimiento: *</label>
                    <div class="date form-group input-group" id="dp_fecha_med" data-date="1970-01-01" data-date-format="yyyy-mm-dd" style="width: 170px;">

                        <?= form_input($fecha) ?>
                        <span class="input-group-addon add-on"><i class="fa fa-calendar"></i></span>
                    </div>
                    <div class="form-group">
                        <label>Sexo: *</label><br>
                        <label class="radio-inline">
                            <?= form_radio($masculino) ?> Masculino
                        </label>
                        <label class="radio-inline">
                            <?= form_radio($femenino) ?> Femenino
                        </label>
                    </div>
                    <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
                    <hr>
                    <?= form_submit($registrar_medico) ?>
                    <?= form_submit($editar_medico) ?>
                    <?= form_button($cancelar_medico) ?>
                    <?= form_button($buscar_medico) ?>
                    <?= form_reset($limpiar_medico) ?>
                </fieldset>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalMedico" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Buscar médico</h4>
            </div>
            <div class="modal-body">
                <div id="ResultadoMedico">
                </div>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarModalMedico" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnEditarModalMedico" type="button" class="btn btn-primary" disabled>Editar</button>
                    <button id="btnDeshabilitarMedico" type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDeshabilitar" disabled>Deshabilitar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDeshabilitar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; top: 25%;">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;">¿Estás seguro de que desea deshabilitar?</h4>
            </div>
            <div class="modal-footer" style="margin: 0px; border: 0px; padding: 0px;">
                <div style="text-align: center">
                    <button type="button" class="btn btn-default" data-dismiss="modal" 
                            style="padding-top: 20px; padding-bottom: 20px; width: 49%; float: left; margin:0px; border: none; border-radius: 0px;">No</button>
                    <button id="deshabilitarMedico" type="button" class="btn btn-danger" style="padding-top: 20px; padding-bottom: 20px; width: 49%; float: right; margin:0px; border: none; border-radius: 0px;">Si</button>
                </div>
            </div>
        </div>
    </div>
</div>