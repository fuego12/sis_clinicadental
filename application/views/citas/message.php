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
                
                <?php if(isset($m)) { ?>
                
                <div class="alert alert-danger">
                    Debe registrar por lo menos a un m&eacute;dico en el sistema, para registrar un m&eacute;dico haz click. <a href="<?= base_url('medico') ?>" class="alert-link">aqu&iacute;</a>.
                </div>
                
                <?php } else { ?>
                
                <div class="alert alert-danger">
                    Debe registrar por lo menos a un paciente en el sistema, para registrar un paciente haz click. <a href="<?= base_url('paciente') ?>" class="alert-link">aqu&iacute;</a>.
                </div>
                    
                <?php } ?>
                
            </div>
        </div>
    </div>
</div>