<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Bienvenido a <?= $clinica['nomb_clin'] ?>
        </h1>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-fw fa-check"></i> Citas Médicas</h4>
            </div>
            <div class="panel-body">
<!--                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?</p>-->
                <a href="<?= base_url('citas') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url().'resources/images/calendar.png' ?>" alt="Ir"></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-fw fa-compass"></i> Control de Pacientes</h4>
            </div>
            <div class="panel-body">
                <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?</p>-->
                <a href="<?= base_url('paciente') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url().'resources/images/patient.png' ?>" alt="Ir"></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-fw fa-compass"></i> Registro de Medicos</h4>
            </div>
            <div class="panel-body">
                <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?</p>-->
                <a href="<?= base_url('medico') ?>" class="btn btn-default" style="width: 100%"><img src="<?= base_url().'resources/images/doctor.png' ?>" alt="Ir"></a>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="well">
    <div class="row">
        <div class="col-md-8">
            <p>Sistema de gestión y control odontológico online.</p>
        </div>
        <div class="col-md-4">
            <a class="btn btn-lg btn-default btn-block" href="<?= base_url('login') ?>">Iniciar Sesión</a>
        </div>
    </div>
</div>