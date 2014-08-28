<input id="error_nueva_cita" type="hidden" value="<?= $this->session->userdata('error_nueva_cita') ?>">
<input id="error_editar_cita" type="hidden" value="<?= $this->session->userdata('error_editar_cita') ?>">
<input id="error_editar_cita_codigo" type="hidden" value="<?= $this->session->userdata('error_editar_cita_codigo') ?>">
<?php $this->session->unset_userdata('error_nueva_cita'); ?>
<?php $this->session->unset_userdata('error_editar_cita'); ?>
<?php $this->session->unset_userdata('error_editar_cita_codigo'); ?>
<div>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li><a href="<?= base_url() ?>">Inicio</a>
                </li>
                <li class="active">Citas médicas</li>
            </ol>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 2%">
    <div class="col-md-10 col-md-offset-1">
        <div id="panel-paciente" class="login-panel panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Citas médicas</h3>
            </div>
            <div class="panel-body">
                <?php if ($this->session->userdata('mensaje_cita') && $this->session->userdata('mensaje_cita') != "") { ?>
                    <div id="mensaje_cit" class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->userdata('mensaje_cita') ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('mensaje_cita');
                }
                ?>

                <div style="float: left;">
                    <label>Fecha de citas médicas: </label>
                    <div class="date form-group input-group" id="dp_fecha_cit" data-date="<?= $fecha_actual ?>" data-date-format="yyyy-mm-dd" style="width: 170px;">

                        <?= form_input($fecha) ?>
                        <span class="input-group-addon add-on"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
                <?= form_button($nueva_cita) ?>
                <br><br><br>
                <hr>
                <div id="resultado_citas_medicas" class="table-responsive">
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
                                    <td style="text-align: center;"><?php if($row->obsv_cit!="") { ?><button type="button" class="btn btn-default btn-sm ver-observa"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver observación"><i class="fa fa-eye-slash"></i></button><input type="hidden" value="<?= $row->obsv_cit ?>" class="txt-observa"><?php } ?></td>
                                    <td style="text-align: center;"><?= get_name_status_citas($row->esta_cit) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalNuevaCita" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading" style="text-align: center;">
                <h4 class="modal-title" id="myModalLabel">Nueva cita médica</h4>
            </div>
            <div id="frm_nueva_cita" class="panel-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarCita" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading" style="text-align: center;">
                <h4 class="modal-title" id="myModalLabel">Editar cita médica</h4>
            </div>
            <div class="panel-body">
                <form action="<?= base_url() ?>citas/editar" method="post" accept-charset="utf-8" role="form" id="form_editar_cita">
                    <fieldset>
                        <div class="modal-body">
                            <div class="row" style="margin-top: 2%">
                                <div style="margin: 20px;">
                                    <div id="panel-editar-cita" class="login-panel panel panel-primary">
                                        <div class="panel-body">

                                            <div id="error_hora_cita_edit" class="alert alert-danger alert-dismissable"
                                                 style="display: none;">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <strong>Alerta: </strong>Ya existe una cita médica programada a la hora seleccionada
                                            </div>
                                            <div class="form-group">
                                                <label>Codigo: </label>
                                                <input type="text" name="codigo" value="" id="codigo_cit_edit" class="form-control" maxlength="50" required="true" autocomplete="off" readonly="true" style="display: inline; width: 150px; margin-left: 8px;">
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha:</label>
                                                <input id="fecha_cita_edit" type="date" name="fecha" value="" class="form-control" size="16" style="width: 170px;" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Hora:</label>
                                                <input id="hora_cita_edit" type="time" name="hora" class="form-control" value="" style="width: 100px;" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Médico: </label>
                                                <?= form_dropdown('medico_edit', $medicos, array(), 'class="form-control"') ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Paciente: </label>
                                                <input type="text" name="paciente" value="" id="paciente_cit_edit" class="form-control" maxlength="50" required="true" autocomplete="off" readonly="true">
                                            </div>
                                            <div class="form-group">
                                                <label>Observación: </label>
                                                <textarea name="observacion" cols="40" rows="3" id="observa_cit_edit" class="form-control" maxlength="125" autocomplete="off" style="max-width: 256px; max-height: 75px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div style="float: right;">
                                <button name="cancelar_editar_cita" type="button" class="btn btn-lg btn-default" value="true" data-dismiss="modal">Cancelar</button>
                                <input type="submit" name="editar_cita_medica" value="Actualizar" class="btn btn-lg btn-primary">
                            </div>
                        </div>
                        <input type="hidden" name="fecha_ori">
                        <input type="hidden" name="hora_ori">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditarCita" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading" style="text-align: center;">
                <h4 class="modal-title" id="myModalLabel">Editar cita médica</h4>
            </div>
            <div id="frm_editar_cita" class="panel-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAccionesCita" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">¿Qué desea realizar?</h4>
            </div>
            <div class="modal-body">
                <div id="panel_row_citas" class="panel">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                        <p></p>
                    </div>
                </div>
                <?= form_button($editar_cita) ?>
                <?= ($admin) ? form_button($comenzar_cita) : '' ?> 
                <?= form_button($deshabilitar_cita) ?>
                <?= form_button($cancelar_cita) ?>
            </div>
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

<div class="modal fade" id="ModalStartCita" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 98%;">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <h4 class="modal-title" id="myModalLabel">Odontograma</h4>
            </div>
            <div class="modal-body" style="overflow: scroll; height: 600px;">

                <div class="row">
                    <div class="col-lg-12">

                        <?php
                        $limit = 32;
                        for ($i = 0; $i < $limit; $i++) {
                            $diente = $dientes[$i];
                            $estado = 1;
                            ?>

                            <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">

                                    <?php if ($i + 1 <= 16) { ?>

                                        <img class="img-responsive" src="<?= base_url('resources/images/odontograma/' . $diente . '/' . $diente  . '.jpg') ?>" alt="<?= $diente ?>">
                                        <div>
                                            <div style="width:36px">
                                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                                <div class="<?= $diente ?>_1 parte_superior" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                            </div>
                                            <div style="width:36px">
                                                <div class="<?= $diente ?>_4 parte_izquierda" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                                <div class="<?= $diente ?>_5 parte_central" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                                <div class="<?= $diente ?>_2 parte_derecha" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                            </div>
                                            <div style="width:36px">
                                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                                <div class="<?= $diente ?>_3 parte_inferior" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                            </div>
                                        </div><br><br>
                                        <span><?= $diente ?></span>

                                    <?php } else { ?>

                                        <span><?= $diente ?></span>
                                        <div>
                                            <div style="width:36px">
                                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                                <div class="<?= $diente ?>_1 parte_superior" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                            </div>
                                            <div style="width:36px">
                                                <div class="<?= $diente ?>_4 parte_izquierda" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                                <div class="<?= $diente ?>_5 parte_central" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                                <div class="<?= $diente ?>_2 parte_derecha" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                            </div>
                                            <div style="width:36px">
                                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                                <div class="<?= $diente ?>_3 parte_inferior" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                            </div>
                                        </div>
                                        <img class="img-responsive" src="<?= base_url('resources/images/odontograma/' . $diente . '/' . $diente . '.jpg') ?>" alt="<?= $diente ?>">

                                    <?php } ?>

                                </a>
                                <ul class="dropdown-menu estado_diente">

                                    <?php foreach ($estado_diente as $ed) { ?>

                                        <li><a href="#"> <?= $ed->titu_edi . ' = ' . $ed->nomb_edi ?></a></li>

                                    <?php } ?>

                                </ul>

                            </div>

                            <?php if ($i + 1 == 16) { ?>

                            </div>

                            <div class="col-lg-12">

                                <?php
                            }
                        }
                        ?>

                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dientes_seleccionados" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Estado</th>
                                <th>Partes</th>
                                <th style="display: none;">Partes_num</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br>
                <button type="button" id="enfermedad_cita" class="btn btn-lg btn-primary btn-block" disabled>Enfermedad >></button>
                <button type="button" class="btn btn-lg btn-default btn-block" id="CancelarCita" >Cancelar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-sm" id="ModalPiezasDie" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="mySmallModalLabel" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Seleccione las piezas del diente:</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" style="font-size: 16px; padding-left: 20%;">
                    <div class="checkbox">
                        <label>
                            <input id="pie_all" type="checkbox" value="" checked="true">Pieza completa
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="pie_mes" type="checkbox" value="" checked="true">Mesial
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="pie_dis" type="checkbox" value="" checked="true">Distal
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="pie_ocl" type="checkbox" value="" checked="true">Oclusal
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="pie_inc" type="checkbox" value="" checked="true">Incisal
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="pie_pal" type="checkbox" value="" checked="true">Palatino
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="pie_lin" type="checkbox" value="" checked="true">Lingual
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="pie_ves" type="checkbox" value="" checked="true">Vestibular
                        </label>
                    </div>
                </div>
                <br>
                <button id="aceptar_piezas" type="button" class="btn btn-primary btn-block">Aceptar</button>
                <button id="editar_piezas" type="button" class="btn btn-primary btn-block" style="display: none;">Editar</button>
                <button id="cancelar_piezas" type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancelar</button>
                <button id="cancelar_editar_piezas" type="button" class="btn btn-default btn-block" data-dismiss="modal" style="display: none;">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade bs-example-modal-sm" id="ModalEstadoDie" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="mySmallModalLabel" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Seleccione el estado del diente:</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" style="font-size: 16px; padding-left: 20%;">
                    <?php foreach ($estado_diente as $ed) { ?>

                        <div class="radio">
                            <label>
                                <input type="radio" name="estado_diente" value="<?= $ed->nomb_edi ?>" checked=""> <?= $ed->nomb_edi ?>
                            </label>
                        </div>

                    <?php } ?>

                </div>
                <br>
                <button id="aceptar_estado" type="button" class="btn btn-primary btn-block">Aceptar</button>
                <button id="cancelar_estado" type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="ModalEnfermedad" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 75%;">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <h4 class="modal-title" id="myModalLabel">Enfermedad</h4>
            </div>
            <div class="modal-body" style="overflow: scroll; height: 600px;">
                <div class="form-group">
                    <label>Diente</label>
                    <select id="diente_enf" class="form-control" name="num_die" style="width: 90px;"></select>
                    <br>
                    <label>Enfermedad</label>
                    <select id="codigo_enf" class="form-control" name="codi_enf"> <?php foreach ($enfermedad as $row) { ?> <option value="<?= $row->codi_enf ?>"> <?= $row->titu_enf . ' - ' . $row->desc_enf ?> </option> <?php } ?> </select>
                    <br>
                    <button type="button" id="agregar_enf" class="btn btn-lg btn-primary btn-block">Agregar</button>
                </div>
                <h4>Diagnóstico</h4>
                <div class="table-responsive">
                    <table id="tabla_enfermedad" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th># Diente</th>
                                <th>Enfermedad</th>
                                <th style="display: none;">Codigo</th>
                                <th>Quitar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br>
                <button type="button" id="procedimiento_cita" class="btn btn-lg btn-primary btn-block" disabled>Procedimiento >></button>
                <button type="button" id="atras_enfermedad" class="btn btn-lg btn-default btn-block">Atrás</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalProcedimiento" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 75%;">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <h4 class="modal-title" id="myModalLabel">Procedimiento</h4>
            </div>
            <div class="modal-body" style="overflow: scroll; height: 600px;">
                <div class="form-group">
                    <label>Diente - Enfermedad</label>
                    <select id="diente_pro" class="form-control" name="diente_pro"></select>
                    <br>
                    <label>Procedimiento</label>
                    <select id="codigo_pro" class="form-control" name="codi_pro"> <?php foreach ($procedimiento as $row) { ?> <option value="<?= $row->codi_tar ?>"> <?= $row->desc_pro . '(' . $row->grup_pro . ') - ' . $row->nomb_cat . ' S/. ' . $row->cost_tar ?> </option> <?php } ?> </select>
                    <br>
                    <label>Aseguradora</label>
                    <input type="number" min="0" value="0" max="100" id="aseg_pro" name="aseg_pro" class="form-control" style="width: 90px;">
                    <br>
                    <button type="button" id="agregar_pro" class="btn btn-lg btn-primary btn-block">Agregar</button>
                </div>
                <h4>Procedimientos agregados</h4>
                <div class="table-responsive">
                    <table id="tabla_procedimiento" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th># Diente</th>
                                <th>Procedimiento</th>
                                <th>Aseg.</th>
                                <th style="display: none;">Codigo</th>
                                <th>Quitar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <label>Total a cancelar: </label>
                <div class="form-group input-group" style="width: 250px;">
                    <span class="input-group-addon">S/. </span>
                    <input id="total_pro" type="text" class="form-control" readonly="true" style="background-color: white;" value="0">
                    <span class="input-group-addon">.00</span>
                </div>
                <br>

                <form action="<?= base_url() ?>citas/finalizar_cita" method="post" accept-charset="utf-8" role="form" id="form_finalizar_cita">
                    <input id="fin_codi_cit" type="hidden" name="cita">
                    <input id="fin_tbl_diente" type="hidden" name="tbl_diente">
                    <input id="fin_tbl_enfermedad" type="hidden" name="tbl_enfermedad">
                    <input id="fin_tbl_procedimiento" type="hidden" name="tbl_procedimiento">
                    <input id="fin_total" type="hidden" name="total">
                    
                    <input type="submit" value="Finalizar" id="finalizar_cita" class="btn btn-lg btn-success btn-block" disabled />
                </form>
                <button type="button" id="atras_procedimiento" class="btn btn-lg btn-default btn-block">Atrás</button>
            </div>
        </div>
    </div>
</div>

<div class="portfolio-modal modal fade" id="ModalComprobante" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-content" style="height: 100%">
        <div class="container" style="height: 100%">
            <div class="row" style="height: 100%">
                <div class="col-lg-8 col-lg-offset-2" style="height: 100%; text-align: center;">
                    <div class="modal-body" style="height: 90%">
                        <h2>La cita médica ha sido finalizada con éxito</h2>
                        <hr class="star-primary">
                        <div id="iframe_comprobante" style="height: 85%"></div>
                    </div>
                    <button id="cerrarComprobante" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<ul id="img_estados" style="display: none;">
    <?php
        foreach ($img_estados as $row) { ?>
        <li><?= $row ?></li>
    <?php    }
    ?>
</ul>
<select id="estados_rep" style="display: none;">
    <?php
        foreach ($estado_diente as $row) { ?>
            <option value="<?= $row->codi_edi ?>"><?= $row->nomb_edi ?></option>
    <?php    }
    ?>
</select>
<table id="citas-det" style="display: none;">
<?php foreach ($citas_his as $row) { ?>
    <tr>
        <td><?= $row->codi_cit ?></td>
        <td><?= $row->fech_cit ?></td>
        <td><?= $row->codi_med ?></td>
        <td><?= $row->codi_pac ?></td>
        <td><?= $row->nomb_pac ?></td>
        <td><?= $row->apel_pac ?></td>
    </tr>
<?php } ?>
</table>
<table id="last_estados" style="display: none;">
<?php foreach ($last_estados as $row) { ?>
    <tr>
        <td><?= $row['codi_cit'] ?></td>
        <td><?= $row['num_die'] ?></td>
        <td><?= $row['part_die'] ?></td>
        <td><?= $row['paciente'] ?></td>
        <td><?= $row['codi_edi'] ?></td>
        <td><?= $row['nomb_edi'] ?></td>
    </tr>
<?php } ?>
</table>