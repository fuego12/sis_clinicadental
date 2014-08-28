<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb" style="margin-top: 2%;">
            <li><a href="<?= base_url() ?>">Inicio</a></li>
            <li><a href="<?= base_url('odontograma') ?>">Paciente</a></li>
            <li class="active"> Odontograma </li>
        </ol>
    </div>
</div>

<div id="panel-paciente" class="login-panel panel panel-primary">

    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <div class="breadcrumb" style="margin-top: 2%;height:60px">
                    <div style="float:left">
                        <label>Paciente: &nbsp; <?= $paciente->apel_pac . ', ' . $paciente->nomb_pac ?> </label><br>
                        <label>Fecha de esta cita: &nbsp; <?= $cita->fech_cit ?> </label>
                    </div>                    
                    <div class="form-inline" style="width:60%;float:right;margin-top:0.5%">

                        <div style="float:left">
                            <form id="frmEstadoDiente" action="<?= base_url('historia_paciente') ?>" method="post">
                                <label>Historial de citas </label>
                                <select class="form-control form-control" id="codi_cit" name="codi_cit" style="width:160px">       

                                    <?php foreach ($citas as $row) { ?> <option value="<?= $row->codi_cit ?>"> <?= $row->codi_cit . ' - ' . $row->fech_cit ?> </option> <?php } ?> 

                                </select>
                                <input type="hidden" name="codi_pac" value="<?= $paciente->codi_pac ?>">
                                <button id="btnHistoriaPaciente" type="submit" class="btn btn-primary"> Cargar Historia</button>
                            </form>
                        </div>

                        <form action="<?= base_url('cerrar_cita') ?>" method="post">
                            <input type="hidden" name="codi_pac" value="<?= $paciente->codi_pac ?>">
                            <input type="hidden" id="codi_pac" name="codi_cit" value="<?= $codi_cit ?>">
                            <button id="btnHistoriaPaciente" type="submit" class="btn btn-success" style="float:right;margin-left:2%"> Cerrar Cita </button>
                        </form>

                        <form action="<?= base_url('abrir_cita') ?>" method="post">
                            <input type="hidden" name="codi_pac" value="<?= $paciente->codi_pac ?>">
                            <input type="hidden" id="codi_pac" name="codi_cit" value="<?= $codi_cit ?>">
                            <button id="btnHistoriaPaciente" type="submit" class="btn btn-warning" style="float:right"> Abrir Cita </button>
                        </form>                       

                    </div>
                </div>                
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <?php
            $limit = 32;
            for ($i = 0; $i < $limit; $i++) {
                $diente = $dientes[$i];
                $estado = 1;
                foreach ($odontograma as $d) {
                    if ($d->num_die == $dientes[$i]) {
                        $diente = $d->num_die;
                        $estado = $d->codi_edi;
                    }
                }
                ?>

                <div class="btn-group" style="margin:1%">

                    <?php if ($i + 1 <= 16) { ?>

                        <div>
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="padding:0%">    
                                <div>
                                    <img class="img-responsive" src="<?= base_url('resources/images/odontograma/' . $diente . '/' . $diente . '_' . $estado . '.jpg') ?>" alt="<?= $diente ?>">
                                </div>
                            </a>
                            <ul class="dropdown-menu">

                                <?php foreach ($estado_diente as $ed) { ?>

                                    <li><a href="#"> <?= $ed->titu_edi . ' = ' . $ed->nomb_edi ?> </a></li>

                                <?php } ?>

                            </ul>                    
                        </div><br>

                        <div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                <div id="<?= $diente ?>_p1" class="<?= $diente ?>" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                            </div>
                            <div style="width:36px">
                                <div id="p2" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                <div id="p3" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                <div id="p4" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                            </div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                <div id="p5" style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                            </div>
                            <div style="width:36px;text-align:center">
                                <span> <?= $diente ?> </span>
                            </div>
                        </div>

                    <?php } else { ?>

                        <div>
                            <div style="width:36px;text-align:center">
                                <span> <?= $diente ?> </span>
                            </div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                            </div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                            </div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                            </div>                               
                        </div><br><br><br>

                        <div>
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="padding:0%">    
                                <div>
                                    <img class="img-responsive" src="<?= base_url('resources/images/odontograma/' . $diente . '/' . $diente . '_' . $estado . '.jpg') ?>" alt="<?= $diente ?>">
                                </div>
                            </a>
                            <ul class="dropdown-menu">

                                <?php foreach ($estado_diente as $ed) { ?>

                                    <li><a href="#"> <?= $ed->titu_edi . ' = ' . $ed->nomb_edi ?> </a></li>

                                <?php } ?>

                            </ul>
                        </div>

                    <?php } ?>

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

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li class="active"> Diagnostico </li>
            </ol>
        </div>
    </div>

    <div class="panel-body">

        <form class="form-inline" id="frmEstadoDiente" action="<?= base_url('update_diente_estado') ?>" method="post">

            <div class="form-group">
                <label> # Diente &nbsp; </label><select style="width:7%" class="form-control form-control" id="num_die" name="num_die"> <?php for ($i = 0; $i < $limit; $i++) { ?> <option value="<?= $dientes[$i] ?>"> <?= $dientes[$i] ?> </option> <?php } ?> </select>
                <label> Estado &nbsp; </label><select style="width:17%" class="form-control form-control" id="codi_edi" name="codi_edi"> <?php foreach ($estado_diente as $row) { ?> <option value="<?= $row->codi_edi ?>"> <?= $row->titu_edi . ' = ' . $row->nomb_edi ?> </option> <?php } ?> </select>
                <div class="checkbox">
                    <label><input name="completo" type="checkbox"> Pieza completa </label>
                    <label><input id="mesial" name="mesial" type="checkbox"> Mesial </label>
                    <label><input name="distal" type="checkbox"> Distal </label>
                    <label><input name="oclusal" type="checkbox"> Oclusal </label>                    
                    <label><input name="palatino" type="checkbox"> Palatino </label>
                    <label><input name="lingual" type="checkbox"> Lingual </label>
                    <label><input name="vestibular" type="checkbox"> Vestibular </label>
                </div>
                <input type="hidden" id="codi_pac" name="codi_pac" value="<?= $paciente->codi_pac ?>">
                <input type="hidden" id="codi_pac" name="codi_cit" value="<?= $codi_cit ?>">
                <button id="btnEstadoDiente" type="submit" class="btn btn-primary"> Actualizar diente</button>
            </div>

        </form>
    </div>

    <div class="panel-body">
        <form class="form-inline" id="frmEnfermedadDiente" action="<?= base_url('update_diente_enfermedad') ?>" method="post">

            <div class="form-group">
                <label># Diente &nbsp; </label><select style="width:9%" class="form-control form-control" name="codi_die"> <?php foreach ($odontograma as $row) { ?> <option value="<?= $row->codi_die ?>"> <?= $row->num_die ?> </option> <?php } ?> </select>
                <label> Enfermedad &nbsp; </label><select style="width:45%" class="form-control form-control" name="codi_enf"> <?php foreach ($enfermedad as $row) { ?> <option value="<?= $row->codi_enf ?>"> <?= $row->titu_enf . ' - ' . $row->desc_enf ?> </option> <?php } ?> </select>
                <input type="hidden" id="codi_pac" name="codi_pac" value="<?= $paciente->codi_pac ?>">
                <input type="hidden" id="codi_pac" name="codi_cit" value="<?= $codi_cit ?>">
                <button id="btn_ud" type="submit" class="btn btn-primary"> Agregar enfermedad</button>
            </div>

        </form>
    </div>

    <div class="panel-body">
        <table id="table-citas-medicas" class="table table-bordered">
            <thead>
                <tr>
                    <th># Diente</th>
                    <th>Estado</th>
                    <th>Zonas</th>
                    <th>Enfermedad</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($estados as $row) { ?>

                    <tr>
                        <td style="text-align: center"><?= $row['num_die'] ?></td>
                        <td><?= $row['nomb_edi'] ?> </td>
                        <td><?= $row['part_die'] ?> </td>
                        <td><?= $row['enf_die'] ?> </td>
                        <td style="text-align: center;"><button type="button" class="btn btn-primary"> Actualizar estado</button></td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb" style="margin-top: 2%;">
                <li class="active"> Procedimientos </li>
            </ol>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-inline" id="frmProcedimientoDiente" action="<?= base_url('insert_procedimiento') ?>" method="post">

            <div class="form-group">
                <label> Diente / Enf &nbsp; </label><select style="width:20%" class="form-control form-control" name="codi_odo"> <?php foreach ($enf_detalle as $row) { ?> <option value="<?= $row->codi_odo ?>"> <?= $row->num_die . ' - ' . $row->desc_enf ?> </option> <?php } ?> </select>
                <label> Procedimiento &nbsp; </label><select style="width:15%" class="form-control form-control" name="codi_pro"> <?php foreach ($procedimiento as $row) { ?> <option value="<?= $row->codi_pro ?>"> <?= $row->desc_pro . ' - ' . $row->grup_pro ?> </option> <?php } ?> </select>
                <label> Categoria &nbsp; </label><select style="width:10%" class="form-control form-control" name="codi_cat"> <?php foreach ($categoria as $row) { ?> <option value="<?= $row->codi_cat ?>"> <?= $row->nomb_cat ?> </option> <?php } ?> </select>
                <input type="number" id="codi_pac" name="aseg_dpr" placeholder="Aseg." style="width:5%">
                <input type="hidden" id="codi_pac" name="codi_pac" value="<?= $paciente->codi_pac ?>">
                <input type="hidden" id="codi_pac" name="codi_cit" value="<?= $codi_cit ?>">
                <button id="btn_ud" type="submit" class="btn btn-primary"> Agregar procedimiento</button>
            </div>

        </form>
    </div>

    <div class="panel-body">
        <table id="table-citas-medicas" class="table table-bordered">
            <thead>
                <tr>
                    <th># Diente</th>
                    <th>Enfermedad</th>
                    <th>Procedimiento</th>
                    <th>Categoria</th>
                    <th>Costo</th>
                    <th>Aseg.</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($proc_detalle as $row) { ?>

                    <tr>
                        <td style="text-align: center"><?= $row->num_die ?></td>
                        <td><?= $row->desc_enf ?> </td>
                        <td><?= $row->desc_pro ?> </td>
                        <td><?= $row->nomb_cat ?> </td>
                        <td><?= $row->cost_tar ?> </td>
                        <td><?= $row->aseg_dpr ?> </td>
                        <td style="text-align: center;"><button type="button" class="btn btn-primary"> Actualizar estado</button></td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>
    </div>

</div>

