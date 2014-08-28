<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb" style="margin-top: 2%;">
            <li><a href="<?= base_url() ?>">Inicio</a>
            </li>
            <li class="active">Inicio de sesión</li>
        </ol>
    </div>
</div>

<div class="row" style="margin-top: 6%">
    <div class="col-md-5 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Inicio de sesión</h3>
            </div>
            <div class="panel-body">
                <?= form_open(base_url() . 'login', $form) ?>
                <fieldset>
                    <?php if ($this->session->userdata('error_login_1') && $this->session->userdata('error_login_1')!="") { ?>
                        <div class="alert alert-danger">
                            <?= $this->session->userdata('error_login_1') ?>
                        </div>
                    <?php 
                        $this->session->unset_userdata('error_login_1');
                    } ?>
                    <div class="form-group">
                        <?= form_input($usuario) ?>
                    </div>
                    <div class="form-group">
                        <?= form_password($contraseña) ?>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input name="remember" type="checkbox" value="Remember Me">Recordarme
                        </label>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <a href="#">Olvidé mi contraseña</a>
                    </div>
                    <?= form_submit($inicio_sesion) ?>
                </fieldset>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>