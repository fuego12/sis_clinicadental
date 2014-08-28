<div>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li><a href="<?= base_url() ?>">Inicio</a>
                </li>
                <li class="active">Registro de enfermedades</li>
            </ol>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 2%">
    <div class="col-md-8 col-md-offset-2">
        <div id="panel-cie" class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Registro de enfermedades</h3>
            </div>
            <div class="panel-body">
                <?php if ($this->session->userdata('mensaje_cie') && $this->session->userdata('mensaje_cie') != "") { ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->userdata('mensaje_cie') ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('mensaje_cie');
                }
                ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNuevaEnfermedad">Nueva enfermedad</button>
                <br><br>
                <div class="table-responsive">
                    <table id="table-cie" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Codigo</th>
                                <th style="text-align: center;">Título</th>
                                <th style="text-align: center;">Descripción</th>
                                <th style="text-align: center;">Estado</th>
                                <th style="text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($enfermedades as $row) { ?>
                                <tr style="background-color: none;">
                                    <td style="text-align: center;"><?= $row->codi_enf ?></td>
                                    <td style="text-align: center;"><?= $row->titu_enf ?></td>
                                    <td><?= $row->desc_enf ?></td>
                            <td style="text-align: center;"><?php if ($row->esta_enf == "A"){ echo "Activo"; } else if ($row->esta_enf == "D") { echo "Desactivo"; } ?></td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <button type="button" class="tooltip-cie btn btn-success btn-circle editar_cie" data-toggle="tooltip" data-placement="top" title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <?php if ($row->esta_enf == "D"){ ?>
                                        <span>
                                        <?= form_open(base_url() . 'cie', $form_a) ?>
                                        <input type="hidden" name="codigo" value="<?= $row->codi_enf ?>">
                                        <input type="hidden" name="descripcion" value="<?= $row->desc_enf ?>">
                                        <input name="activar" type="submit" class="tooltip-cie btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                        <?= form_close() ?>
                                        </span>
                                        <?php } else if ($row->esta_enf == "A"){ ?>
                                        <span>
                                         <?= form_open(base_url() . 'cie', $form_a) ?>
                                        <input type="hidden" name="codigo" value="<?= $row->codi_enf ?>">
                                        <input type="hidden" name="descripcion" value="<?= $row->desc_enf ?>">
                                        <input name="desactivar" type="submit" class="tooltip-cie btn btn-danger btn-circle fa" value="&#xf05e;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                        <?= form_close() ?>
                                        </span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalNuevaEnfermedad" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            <?= form_open(base_url() . 'cie', $form) ?>
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Nueva enfermedad</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Código: *</label>
                    <?= form_input($codigo) ?>
                </div>
                <div class="form-group">
                    <label>Título: *</label>
                    <?= form_input($titulo) ?>
                </div>
                <div class="form-group">
                    <label>Descripción: *</label>
                    <?= form_input($descripcion) ?>
                </div>

            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNuevaEnf" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($registrar) ?>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarEnfermedad" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content" style="border-color: #428bca; border-style: inset;">
            <?= form_open(base_url() . 'cie', $form_editar) ?>
            <div class="modal-header" style="
                 padding: 10px 15px;
                 border-bottom: 1px solid transparent;
                 border-top-left-radius: 3px;
                 border-top-right-radius: 3px;
                 color: #fff;
                 background-color: #428bca;
                 border-color: #428bca;
                 ">
                <h4 class="modal-title" id="myModalLabel">Editar enfermedad</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Código: *</label>
                    <?= form_input($codigo_e) ?>
                </div>
                <div class="form-group">
                    <label>Título: *</label>
                    <?= form_input($titulo_e) ?>
                </div>
                <div class="form-group">
                    <label>Descripción: *</label>
                    <?= form_input($descripcion_e) ?>
                </div>

            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarNuevaEnf" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <?= form_submit($editar) ?>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDeshabilitarCita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; top: 25%;">
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
                    <button id="deshabilitarCita" type="button" class="btn btn-danger" style="padding-top: 20px; padding-bottom: 20px; width: 49%; float: right; margin:0px; border: none; border-radius: 0px;">Si</button>
                </div>
            </div>
        </div>
    </div>
</div>

<ul id="enfermedades-rep" style="display: none;">
    <?php foreach($enfermedades as $row) { ?>
        <li><?= $row->codi_enf ?></li>
    <?php } ?>
</ul>
<table id="enfermedades-det" style="display: none;">
<?php foreach ($enfermedades as $row) { ?>
    <tr><td><?= $row->codi_enf ?></td>
    <td><?= $row->titu_enf ?></td>
    <td><?= $row->desc_enf ?></td>
    <td><?= $row->esta_enf ?></td></tr>
<?php } ?>
</table>