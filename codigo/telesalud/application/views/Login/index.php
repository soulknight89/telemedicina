<form action="" method="post" class="form-signin">
	<h2 class="form-signin-heading" style="font-weight: bolder;">Telemedicina</h2>
	<div class="login-wrap">
		<div class="user-login-info">
            <?php if ($this->session->flashdata("success") != "") { ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">
                        ×
                    </button>
                    <a class="alert-link" href="#">
                        <?= $this->session->flashdata("success"); ?>
                    </a>
                </div>
            <?php } ?>
            <div id="div_warning" class="alert alert-warning alert-dismissable" style="display:none;">
                <button id="b_warning" aria-hidden="true" class="close" type="button">
                    ×
                </button>
                <a id="a_warning" class="alert-link" href="#">
                </a>
            </div>
            <?php if ($this->session->flashdata("warning") != "") { ?>
                <div class="alert alert-warning alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">
                        ×
                    </button>
                    <a class="alert-link" href="#">
                        <?= $this->session->flashdata("warning"); ?>
                    </a>
                </div>
            <?php } ?>
            <div id="div_danger" class="alert alert-warning alert-dismissable" style="display:none;">
                <button id="b_danger" aria-hidden="true" class="close" type="button">
                    ×
                </button>
                <a id="a_danger" class="alert-link" href="#">
                </a>
            </div>
            <?php if ($this->session->flashdata("danger") != "") { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">
                        ×
                    </button>
                    <a class="alert-link" href="#">
                        <?= $this->session->flashdata("danger"); ?>
                    </a>
                </div>
            <?php } ?>
            <div id="div_info" class="alert alert-warning alert-dismissable" style="display:none;">
                <button id="b_info" aria-hidden="true" class="close" type="button">
                    ×
                </button>
                <a id="a_info" class="alert-link" href="#">
                </a>
            </div>
            <?php if ($this->session->flashdata("info") != "") { ?>
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">
                        ×
                    </button>
                    <a class="alert-link" href="#">
                        <?= $this->session->flashdata("info"); ?>
                    </a>
                </div>
            <?php } ?>
			<input type="text" id="usuario" name="usuario" class="form-control" placeholder="Correo" autofocus>
			<input type="password" id="clave" name="clave" class="form-control" placeholder="Clave">
		</div>
		<button type="submit" class="btn btn-lg btn-login btn-block">Iniciar Sesion</button>
	</div>
</form>

