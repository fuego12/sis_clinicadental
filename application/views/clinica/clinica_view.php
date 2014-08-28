<div>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li><a href="<?= base_url() ?>">Inicio</a>
                </li>
                <li class="active">Datos de Clinica</li>
            </ol>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 2%">
    <div class="col-md-5 col-md-offset-4">
        <div id="panel-paciente" class="login-panel panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Datos de Clinica</h3>
            </div>
            <div class="panel-body">
                
                <label>Logo de la clinica: <span style="font-size:10px">(Formato: JPG, PNG, GIF, JPEG - Tamaño màximo: 600 x 500 px)</span></label>
                
                <?= form_open_multipart(base_url() . 'clinica', $form) ?>
                
                <fieldset>
                    <?php if ($this->session->userdata('error_clinica_1') && $this->session->userdata('error_clinica_1') != "") { ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->userdata('error_clinica_1') ?>
                        </div>
                        <?php
                        $this->session->unset_userdata('error_clinica_1');
                    }
                    ?>
                    <div id="error_nomb_apel_1_pac" class="alert alert-warning alert-dismissable"
                         style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Alerta: </strong> Los datos no son válidos
                    </div>
                    
                    <div class="form-group">
                        <input type="file" id="fileClinica" name="userfile" size="20" />
                    </div>                    

                    <div class="form-group">
                        <label>Nombre: *</label>
                        <?= form_input($nombre) ?>
                    </div>
                    <div class="form-group">
                        <label>Dirección: *</label>
                        <?= form_input($direccion) ?>
                    </div>
                    <div class="form-group">
                        <label>RUC: *</label>
                        <?= form_input($ruc) ?>
                        <label class="text-danger" id="error_dni_paciente" style="display: none;">&nbsp;Carácter no válido</label>
                    </div>
                    <div class="form-group">
                        <label>Número de teléfono: *</label>
                        <?= form_input($telefono) ?>
                        <label class="text-danger" id="error_telf_paciente" style="display: none;">&nbsp;Carácter no válido</label>
                    </div>
                    <div class="form-group">
                        <label>E-mail:</label>
                        <?= form_input($email) ?>
                        <label class="text-danger" id="error_email_pac_1" style="display: none;">&nbsp;Formato de email no válido</label>
                    </div>                    
                    <p class="text-muted" style="font-style: italic;">(*) Los campos con asterisco son obligatorios.</p>
                    <hr>
                    <?= form_submit($editar_clinica) ?>
                    <?= form_reset($limpiar_clinica) ?>
                </fieldset>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>