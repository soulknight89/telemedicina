<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="ThemeBucket">
	<link rel="shortcut icon" href="images/favicon.html">
	<title>Sistema de Pedidos</title>
	<!--Core CSS -->
	<link href="<?= template_url("bs3/css/bootstrap.min.css") ?>" rel="stylesheet">
	<link href="<?= template_url("css/bootstrap-reset.css") ?>" rel="stylesheet">
	<link href="<?= template_url("font-awesome/css/font-awesome.css") ?>" rel="stylesheet"/>
	<link href="<?= template_url("css/style.css") ?>" rel="stylesheet">
	<link href="<?= template_url("css/style-responsive.css") ?>" rel="stylesheet">
	<!-- Just for debugging purposes. Don't actually copy this line! -->
</head>
<body class="login-body">
<div class="container">
	<?= $content_for_layout; ?>
</div>
<!--Core js-->
<script src="<?= template_url("js/jquery.js") ?>"></script>
<script src="<?= template_url("bs3/js/bootstrap.min.js") ?>"></script>
</body>
</html>
