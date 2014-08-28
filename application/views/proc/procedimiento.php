<div>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li><a href="<?= base_url() ?>">Inicio</a>
                </li>
                <li class="active">Registro de tarifas</li>
            </ol>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 2%">
    <div class="col-md-5 col-md-offset-4">
        <div id="panel-medico" class="login-panel panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Registro de tarifas</h3>
            </div>
            <div class="panel-body">
                
                <?php if($no){?>
                
                <div class="alert alert-danger">
                    Debe registrar por lo menos a un procedimiento y una categoria para poder registrar una tarifa.
                </div>
                
                <?php } ?>
                
                <?= form_open(base_url() . 'procedimiento', $form) ?>
                <fieldset>
                    <?php if ($this->session->userdata('error_procedimiento_1') && $this->session->userdata('error_procedimiento_1') != "") { ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->userdata('error_procedimiento_1') ?>
                        </div>
                        <?php
                        $this->session->unset_userdata('error_procedimiento_1');
                    }
                    ?>
                    <div id="error_nomb_apel_1" class="alert alert-warning alert-dismissable"
                         style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Alerta: </strong>El nombre y apellido ingresados ya se encuentra registrado
                    </div>

                    <?= form_hidden('codigo', '') ?>
                    <div class="form-group">
                        <label>Procedimiento: *</label>
                        <button type="button" class="btn btn-primary" style="padding: 2px 10px; margin-left: 10px;" data-toggle="modal" data-target="#ModalNuevoProcedimiento"><i class="fa fa-plus"></i></button>                    
                        <?= form_dropdown('procedimiento', $nomb_pro, array(), 'id="codi_pro" class="form-control" style="margin-top: 10px;"') ?>
                    </div>

                    <div class="form-group">
                        <label>Categoria: *</label>
                        <button type="button" class="btn btn-primary" style="padding: 2px 10px; margin-left: 10px;" data-toggle="modal" data-target="#ModalNuevaCategoria"><i class="fa fa-plus"></i></button>                    
                        <?= form_dropdown('categoria', $categorias, array(), 'id="codi_cat" class="form-control" style="margin-top: 10px;"') ?>
                    </div>
                    <div class="form-group">
                        <label>Costo: *</label>
                        <?= form_input($costo) ?>
                    </div>
                    <?= form_hidden('accion', 'registrar') ?>
                    <?= form_submit($registrar_pro) ?>
                    <?= form_button($buscar_pro) ?>
                    <?= form_button($cancelar_pro) ?>
                    <?= form_submit($editar_pro) ?>
                    <?= form_reset($limpiar_pro) ?>
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
                <h4 class="modal-title" id="myModalLabel">Buscar Procedimiento</h4>
            </div>
            <div class="modal-body">
                <div id="ResultadoMedico">
                </div>
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarModalMedico" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnEditarModalMedico" type="button" class="btn btn-primary" data-dismiss="modal" disabled>Editar</button>
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

<!--<div class="modal fade" id="ModalNuevaCategoria" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content panel panel-success">
            <div class="modal-header panel-heading">
                <h4 class="modal-title" id="myModalLabel">Nueva categoria</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre Categoria: *</label>
                    
                </div>
                
            </div>
            <div class="modal-footer">
                <div style="float: right;">
                    <button id="btnCancelarModalNProc" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnAgregarProc" name="agregar_pro" type="button" class="btn btn-success" data-dismiss="modal">Registrar</button>
                    
                </div>
            </div>
        </div>
    </div>
</div>-->

<input id="sw_proc" type="hidden" value="<?php if ($this->session->userdata('sw_proc') && $this->session->userdata('sw_proc')!="") {
    echo $this->session->userdata('sw_proc');
} ?>">
<div class="modal fade" id="ModalNuevoProcedimiento" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content panel panel-success">
            <?= form_open(base_url() . 'procedimientos/agregar_proc', $form) ?>
            <div class="modal-header panel-heading">
                <h4 class="modal-title" id="myModalLabel">Nuevo procedimiento</h4>
            </div>
            <div class="modal-body">
                <?php if ($this->session->userdata('sw_proc') && $this->session->userdata('sw_proc') != "") { ?>
                        <div class="alert alert-<?= $this->session->userdata('sw_proc_bck') ?> alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->userdata('sw_proc') ?>
                        </div>
                        <?php
                        $this->session->unset_userdata('sw_proc');
                        $this->session->unset_userdata('sw_proc_bck');
                    }
                    ?>
                <div class="form-group">
                    <label>Nombre Procedimiento: *</label>
                    <?= form_input($procedimiento) ?>
                </div>
                <div class="form-group">
                    <label>Nombre Grupo: *</label>
                    <?= form_input($grupo) ?>
                </div>
            </div>
            <div class="modal-footer">
                <div>
                    <?= form_submit($agregar_pro) ?>
                    <button id="btnCancelarModalNProc" type="button" class="btn btn-lg btn-default btn-block" data-dismiss="modal">Cancelar</button>
                    <!--<button id="btnEditarModalNProc" type="button" class="btn btn-success" data-dismiss="modal">Registrar</button>-->
                </div>
            </div>
             <?= form_close() ?>
        </div>
    </div>
</div>

<input id="sw_cat" type="hidden" value="<?php if ($this->session->userdata('sw_cat') && $this->session->userdata('sw_cat')!="") {
    echo $this->session->userdata('sw_cat');
} ?>">
<div class="modal fade" id="ModalNuevaCategoria" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content panel panel-success">
            <?= form_open(base_url() . 'procedimientos/agregar_cate', $form) ?>
            <div class="modal-header panel-heading">
                <h4 class="modal-title" id="myModalLabel">Nueva Categoria</h4>
            </div>
            <div class="modal-body">
                <?php if ($this->session->userdata('sw_cat') && $this->session->userdata('sw_cat') != "") { ?>
                        <div class="alert alert-<?= $this->session->userdata('sw_cat_bck') ?> alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->userdata('sw_cat') ?>
                        </div>
                        <?php
                        $this->session->unset_userdata('sw_cat');
                        $this->session->unset_userdata('sw_cat_bck');
                    }
                    ?>
                <div class="form-group">
                    <label>Nombre Categoria: *</label>
                    <?= form_input($cate) ?>
                </div>
               
            </div>
            <div class="modal-footer">
                <div>
                    <?= form_submit($agregar_cat) ?>
                    <button id="btnCancelarModalNCat" type="button" class="btn btn-lg btn-default btn-block" data-dismiss="modal">Cancelar</button>
                    <!--<button id="btnEditarModalNProc" type="button" class="btn btn-success" data-dismiss="modal">Registrar</button>-->
                </div>
            </div>
             <?= form_close() ?>
        </div>
    </div>
</div>

<select id="tarifas-rep" style="display: none;">
    <?php foreach ($tarifas as $row) { ?>
        <option value="<?= $row->codi_cat ?>"><?= $row->codi_pro ?></option>
    <?php } ?>
</select>