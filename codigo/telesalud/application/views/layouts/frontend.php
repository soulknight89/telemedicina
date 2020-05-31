<?php
$titulo      = "Sistema de Pedidos";
$this->ci    = &get_instance();
$ses         = $this->session->userdata("ses");
$per_noc     = $ses['usu_nombres'] . ' ' . $ses['usu_apellidos'];
$id_perfil   = $ses['usu_perfil'];
$controlador = $this->ci->uri->segment(1);
$uri         = base_url(uri_string());
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="tgestiona">
	<link rel="icon" type="image/png" href="<?= template_url('img/logo.png') ?>">
	<title><?= $titulo ?></title>
	<!--Core CSS -->
	<link href="<?= template_url("bs3/css/bootstrap.min.css") ?>" rel="stylesheet">
	<link href="<?= template_url("css/bootstrap-reset.css") ?>" rel="stylesheet">
	<link href="<?= template_url("font-awesome/css/font-awesome.css") ?>" rel="stylesheet"/>
	<link href="<?= template_url("css/style.css") ?>" rel="stylesheet">
	<link href="<?= template_url("css/style-responsive.css") ?>" rel="stylesheet">
	<link href="<?= template_url("js/datatables/datatables.min.css") ?>" rel="stylesheet"/>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
	<link href="<?= template_url("css/select2-bootstrap.min.css") ?>" rel="stylesheet">
	<link href="<?= template_url("js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") ?>"
		  rel="stylesheet">
	<?= $this->layout->css; ?>
	<script src="<?= template_url("js/jquery.js") ?>"></script>
</head>
<body>
<section id="container">
	<!--header start-->
	<header class="header fixed-top clearfix">
		<!--logo start-->
		<div class="brand">
			<a href="#" class="logo" style="margin-left: 35% !important;">
				<img style="width: 28% !important;" src="<?= template_url("img/logo.png") ?>" alt="V&V">
			</a>
			<div class="sidebar-toggle-box">
				<div class="fa fa-bars"></div>
			</div>
		</div>
		<!--logo end-->
		<div class="nav notify-row" id="top_menu">
			<!--  notification start -->
			<ul class="nav top-menu">
				<!-- settings start -->
			</ul>
			<!--  notification end -->
		</div>
		<div class="top-nav clearfix">
			<!--search & user info start-->
			<ul class="nav pull-right top-menu">
				<li class="dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle icon-user" href="#">
						<i class="fa fa-user"></i>
						<span class="username"><?= $per_noc; ?></span>
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu extended logout">
						<li><a href="<?= base_url('Usuario/claveNueva') ?>"><i class="fa fa-key"></i> Cambiar Clave</a>
						</li>
						<li><a href="<?= base_url('Login/logout') ?>"><i class="fa fa-key"></i> Cerrar Sesion</a></li>
					</ul>
				</li>
			</ul>
			<!--search & user info end-->
		</div>
	</header>
	<!--header end-->
	<aside>
		<div id="sidebar" class="nav-collapse">
			<!-- sidebar menu start-->
			<div class="leftside-navigation">
				<ul class="sidebar-menu" id="nav-accordion">
					<?php
					/*Codigo para buscar el contenido del menu*/
					$this->db->select("BOT.*");
					$this->db->from('menu_boton MENU');
					$this->db->join("boton BOT", "MENU.idBoton=BOT.idBoton", "LEFT");
					$this->db->where('idPerfil', $id_perfil);
					$this->db->where('botonPadre', null);
					$padres = $this->db->get()->result();
					foreach ($padres as $padre) {
						$activo = " class='active'";
						if ($padre->ruta) {
							?>
							<li>
								<a href="<?= base_url($padre->ruta); ?>" <?= ($uri == base_url(
										$padre->ruta
									)) ? $activo : ''; ?>>
									<i class="<?= $padre->icono; ?>"></i>
									<span><?= $padre->titulo; ?></span>
								</a>
							</li>
							<?php
						} else {
							?>
							<li class="sub-menu">
								<a href="javascript:;" <?= ($controlador == $padre->controlador) ? $activo : ''; ?>>
									<i class="<?= $padre->icono; ?>"></i>
									<span><?= $padre->titulo; ?></span>
								</a>
								<ul class="sub">
									<?php
									$this->db->select("BOT.*");
									$this->db->from('menu_boton MENU');
									$this->db->join("boton BOT", "MENU.idBoton=BOT.idBoton", "LEFT");
									$this->db->where('idPerfil', $id_perfil);
									$this->db->where('botonPadre', $padre->idBoton);
									$hijos = $this->db->get()->result();
									foreach ($hijos as $hijo) {
										$activo2 = " class='active'";
										?>
										<li>
											<a href="<?= base_url($hijo->ruta); ?>" <?= ($uri == base_url(
													$hijo->ruta
												)) ? $activo2 : ''; ?>>
												<i class="<?= $hijo->icono; ?>"></i>
												<span><?= $hijo->titulo; ?></span>
											</a>
										</li>
										<?php
									}
									?>
								</ul>
							</li>
							<?php
						}
					}
					?>
				</ul>
			</div>
			<!-- sidebar menu end-->
		</div>
	</aside>
	<!--sidebar end-->
	<!--main content start-->
	<section id="main-content">
		<section class="wrapper">
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
			<?= $content_for_layout; ?>
		</section>
	</section>
	<!--main content end-->
</section>
<script>var base_url = "<?php echo base_url() ?>";</script>
<!--Core js-->
<script src="<?= template_url("bs3/js/bootstrap.min.js") ?>"></script>
<script src="<?= template_url("js/jquery.dcjqaccordion.2.7.js") ?>" class="include" type="text/javascript"></script>
<script src="<?= template_url("js/jquery.scrollTo.min.js") ?>"></script>
<script src="<?= template_url("js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js") ?>"></script>
<script src="<?= template_url("js/jquery.nicescroll.js") ?>"></script>
<script src="<?= template_url("js/easypiechart/jquery.easypiechart.js") ?>"></script>
<script src="<?= template_url("js/sparkline/jquery.sparkline.js") ?>"></script>
<script src="<?= template_url("js/datatables/datatables.min.js") ?>" type="text/javascript"></script>
<script src="<?= template_url("js/moment/moment.min.js") ?>"></script>
<script src="<?= template_url("js/moment/locales.min.js") ?>"></script>
<script src="<?= template_url("js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
<script>
    $.fn.dataTable.moment = function (format, locale) {
        var types = $.fn.dataTable.ext.type;

        // Add type detection
        types.detect.unshift(function (d) {
            return moment(d, format, locale, true).isValid() ?
                'moment-' + format :
                null;
        });

        // Add sorting method - use an integer for the sorting
        types.order['moment-' + format + '-pre'] = function (d) {
            return moment(d, format, locale, true).unix();
        };
    };
</script>
<script src="<?= template_url("js/validaciones.js") ?>"></script>
<?= $this->layout->js; ?>
<!--common script init for all pages-->
<script src="<?= template_url("js/scripts.js") ?>"></script>
</body>
</html>
