<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb" style="margin-top: 2%;">
            <li><a href="<?= base_url() ?>">Inicio</a></li>
            <li><a href="<?= base_url('odontograma2') ?>">Paciente</a></li>
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
                            <form id="frmCargarHistoria" action="<?= base_url() ?>odontograma2/odontograma_view" method="post">
                                <label>Historial de citas </label>
                                <select class="form-control form-control" id="codi_cit" name="codi_cit" style="width:240px">       

                                    <?php foreach ($citas as $row) { ?> <option value="<?= $row->codi_cit ?>"> <?= $row->codi_cit . ' - ' . $row->fech_cit ?> </option> <?php } ?> 

                                </select>
                                <input type="hidden" name="codi_pac" value="<?= $paciente->codi_pac ?>">
                                <button id="btnHistoriaPaciente" type="submit" class="btn btn-primary"> Cargar Historia</button>
                            </form>
                        </div>                   

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
                
                $background_1 = "none";
                $background_2 = "none";
                $background_3 = "none";
                $background_4 = "none";
                $background_5 = "none";
                $background_6 = "none";
                
                $sw_diente = false;
                $codi_edi = -1;
                foreach ($odontograma as $d) {
                    if ($d->num_die == $dientes[$i]) {
                        
                        $sw_diente = true;
                        
                        $diente = $d->num_die;
                        $estado = $d->codi_edi;
                        $partes = $d->part_die;
                        $codi_edi = $d->codi_edi;
                        
                        $parte1 = $partes[0];
                        $parte2 = $partes[1];
                        $parte3 = $partes[2];
                        $parte4 = $partes[3];
                        $parte5 = $partes[4];
                        
                        if ($parte1 == "M") {
                            $background_1 = "red";
                        } else {
                            $background_1 = "none";
                        }
                        if ($parte2 == "D") {
                            $background_2 = "red";
                        } else {
                            $background_2 = "none";
                        }
                        if ($parte3== "V") {
                            $background_3 = "red";
                        } else {
                            $background_3 = "none";
                        }
                        if ($parte4 == "P" || $parte4 == "L") {
                            $background_4 = "red";
                        } else {
                            $background_4 = "none";
                        }
                        if ($parte5 == "O" || $parte5 == "I") {
                            $background_5 = "red";
                        } else {
                            $background_5 = "none";
                        }
                    }
                }
                ?>

                <div class="btn-group" style="margin:1%">

                    <?php if ($i + 1 <= 16) { ?>

                        <div>
                            <a class="btn" style="padding:0%">    
                                <div>
                                    <?php               
                                        if ($sw_diente && getimagesize(base_url().'resources/images/odontograma/' . $diente . '/' . $diente . '_'.$codi_edi.'.jpg')) { ?>
                                            <img class="img-responsive" src="<?= base_url().'resources/images/odontograma/' . $diente . '/' . $diente . '_'.$codi_edi.'.jpg' ?>" alt="<?= $diente ?>">
                                      <?php  } else { ?>
                                            <img class="img-responsive" src="<?= base_url().'resources/images/odontograma/' . $diente . '/' . $diente .'.jpg' ?>" alt="<?= $diente ?>">
                                     <?php    }
                                    ?>
                                </div>
                            </a>           
                        </div><br>

                        <div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc;  background: <?= $background_3 ?>;"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                            </div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc; background: <?= $background_1 ?>;"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc;  background: <?= $background_5 ?>;"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc;  background: <?= $background_2 ?>;"></div>
                            </div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc;  background: <?= $background_4 ?>;"></div>
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
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc;  background: <?= $background_3 ?>;"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                            </div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc; background: <?= $background_1 ?>;"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc;  background: <?= $background_5 ?>;"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc;  background: <?= $background_2 ?>;"></div>
                            </div>
                            <div style="width:36px">
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #cccccc;  background: <?= $background_4 ?>;"></div>
                                <div style="float:left;width:12px;height:12px;border: 1px solid #ffffff"></div>
                            </div>                            
                        </div><br><br><br>

                        <div>
                            <a class="btn" style="padding:0%">    
                                <div>
                                    <?php               
                                        if ($sw_diente && getimagesize(base_url().'resources/images/odontograma/' . $diente . '/' . $diente . '_'.$codi_edi.'.jpg')) { ?>
                                            <img class="img-responsive" src="<?= base_url('resources/images/odontograma/' . $diente . '/' . $diente . '_'.$codi_edi.'.jpg') ?>" alt="<?= $diente ?>">
                                      <?php  } else { ?>
                                            <img class="img-responsive" src="<?= base_url('resources/images/odontograma/' . $diente . '/' . $diente .'.jpg') ?>" alt="<?= $diente ?>">
                                     <?php    }
                                    ?>
                                </div>
                            </a>
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
        <table id="table-historial_enfermedad" class="table table-bordered">
            <thead>
                <tr>
                    <th># Diente</th>
                    <th>Estado</th>
                    <th>Zonas</th>
                    <th>Enfermedad</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($estados as $row) { ?>

                    <tr>
                        <td style="text-align: center"><?= $row['num_die'] ?></td>
                        <td><?= $row['nomb_edi'] ?> </td>
                        <td><?= $row['part_die'] ?> </td>
                        <td><?= $row['enf_die'] ?> </td>
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
        <table id="table-historial_procedimiento" class="table table-bordered">
            <thead>
                <tr>
                    <th># Diente</th>
                    <th>Procedimiento</th>
                    <th>Categoria</th>
                    <th>Costo</th>
                    <th>Aseg.</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($proc_detalle as $row) { ?>

                    <tr>
                        <td style="text-align: center"><?= $row->num_die ?></td>
                        <td><?= $row->desc_pro ?> </td>
                        <td><?= $row->nomb_cat ?> </td>
                        <td><?= $row->cost_tar ?> </td>
                        <td><?= $row->aseg_dpr ?> </td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>
    </div>
    
    <a href="<?= base_url() ?>odontograma2/show_pdf/<?= $cita->codi_cit ?>" target="_blank"><button class="btn btn-primary btn-lg btn-block"><!--data-toggle="modal" data-target="#ModalReporteCita"-->Generar reporte</button></a>
</div>

<!--<div class="portfolio-modal modal fade" id="ModalReporteCita" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-content" style="height: 100%">
        <div class="container" style="height: 100%">
            <div class="row" style="height: 100%">
                <div class="col-lg-8 col-lg-offset-2" style="height: 100%; text-align: center;">
                    <div class="modal-body" style="height: 90%">
                        <h2>Reporte de cita médica</h2>
                        <hr class="star-primary">
                        <div id="iframe_comprobante" style="height: 85%">
                            <iframe src="<?= base_url() ?>odontograma2/show_pdf" style="display:block; width:100%; height: 100%; border:none;" frameborder="0" scrolling="no"></iframe>                           
                        </div>
                    </div>
                    <button id="cerrarComprobante" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>-->