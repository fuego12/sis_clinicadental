<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title> .:: <?= $clinica['nomb_clin'] ?> ::. </title>

        <link rel="shortcut icon" href="<?= base_url('resources/images/ico.ico') ?>">
        <link href="<?= base_url() ?>resources/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>resources/css/modern-business.css" rel="stylesheet">
        <link href="<?= base_url() ?>resources/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url() ?>resources/css/jquery-ui.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url() ?>resources/css/datepicker.less" rel="stylesheet" type="text/css">
        <link href="<?= base_url() ?>resources/css/datepicker.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url() ?>resources/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url() ?>resources/css/odontologia.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="height:65px">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="container">
                <div><img src="<?= base_url('resources/images/clinica/logo.png') ?>" style="float:left;margin:5px 10px 0px 0px;width:60px"></div>
                <div class="navbar-header">
                    <a class="navbar-brand" style="margin-bottom:0px" href="<?= base_url('home') ?>"> <?= $clinica['nomb_clin'] . '<br>' ?> 
                        <label style="font-size:0.6em"> CLINICA DENTAL </label></a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right" style="margin-top:7px">
                        <?php
                        if ($this->session->userdata('estado_sesion') && $this->session->userdata('estado_sesion') == "A") {
                            echo show_menu($this->session->userdata('codi_rol'));
                        } else {
                            echo show_menu();
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <?php
        if (isset($carousel) && $carousel != "") {
            echo $carousel;
        }
        ?>
        <div id="contenido" class="container">

            <?= $container ?>
            <hr>
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright &copy; <a href="http://orange3s.com/" target="_blank">Orange3S</a> 2014</p>
                    </div>
                </div>
            </footer>
        </div>

        <script src="<?= base_url() ?>resources/js/config.js"></script>
        <script src="<?= base_url() ?>resources/js/jquery-1.11.0.js"></script>
        <script src="<?= base_url() ?>resources/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>resources/js/is-loading.js"></script>
        <script src="<?= base_url() ?>resources/js/bootstrap-datepicker.js"></script>
        <script src="<?= base_url() ?>resources/js/jquery.dataTables.js"></script>
        <script src="<?= base_url() ?>resources/js/dataTables.bootstrap.js"></script>
        <script src="<?= base_url() ?>resources/js/jquery-ui.js"></script>
        <script src="<?= base_url() ?>resources/js/paciente.js"></script>
        <script src="<?= base_url() ?>resources/js/procedimientos.js"></script>
        <script src="<?= base_url() ?>resources/js/medico.js"></script>
        <script src="<?= base_url() ?>resources/js/cita_medica.js"></script>
        <script src="<?= base_url() ?>resources/js/odontograma.js"></script>
        <script src="<?= base_url() ?>resources/js/cie.js"></script>
        <script src="<?= base_url() ?>resources/js/usuario.js"></script>
        <script>
            $('.carousel').carousel({
                interval: 5000
            });
        </script>

    </body>

</html>
