<?php $ses = $this->session->userdata("ses"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		Telemedicina
	</title>
	<link href="<?= template_url("bs3/css/bootstrap.min.css") ?>" rel="stylesheet">
	<link href="<?= template_url("font-awesome/css/font-awesome.css") ?>" rel="stylesheet"/>
	<?= $this->layout->css; ?>
	<link href="<?= template_url("css/style.css") ?>" rel="stylesheet">
	<script>var base_url = "<?php echo base_url() ?>";</script>
	<!-- Mainly scripts -->
	<script src="<?= template_url("js/jquery.js") ?>"></script>
	<script src="<?= template_url("bs3/js/bootstrap.min.js") ?>"></script>
	<!-- Custom and plugin javascript -->
	<script src="<?= template_url("js/scripts.js") ?>"></script>
	<?= $this->layout->js; ?>
</head>
<body>
<?= $content_for_layout; ?>
</body>
</html>
