<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="ThemeBucket">
	<link rel="shortcut icon" href="images/favicon.html">
	<title>Dr. a un click</title>
	<!--Core CSS -->
	<link rel="stylesheet" href="<?= template_url("assets/vendor/fonts/fontawesome.css") ?>">
	<link rel="stylesheet" href="<?= template_url("assets/vendor/fonts/ionicons.css") ?>">
	<link rel="stylesheet" href="<?= template_url("assets/vendor/fonts/linearicons.css") ?>">
	<link rel="stylesheet" href="<?= template_url("assets/vendor/fonts/open-iconic.css") ?>">
	<link rel="stylesheet" href="<?= template_url("assets/vendor/fonts/pe-icon-7-stroke.css") ?>">
	<!-- Core stylesheets -->
	<link rel="stylesheet" href="<?= template_url("assets/vendor/css/rtl/bootstrap.css") ?>" class="theme-settings-bootstrap-css">
	<link rel="stylesheet" href="<?= template_url("assets/vendor/css/rtl/appwork.css") ?>" class="theme-settings-appwork-css">
	<link rel="stylesheet" href="<?= template_url("assets/vendor/css/rtl/theme-corporate.css") ?>" class="theme-settings-theme-css">
	<link rel="stylesheet" href="<?= template_url("assets/vendor/css/rtl/colors.css") ?>" class="theme-settings-colors-css">
	<link rel="stylesheet" href="<?= template_url("assets/vendor/css/rtl/uikit.css") ?>">
	<link rel="stylesheet" href="<?= template_url("assets/css/demo.css") ?>">
	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!-- Load polyfills -->
	<script src="<?= template_url("assets/vendor/js/polyfills.js")?>"></script>
	<script>document['documentMode']===10&&document.write('<script src="https://polyfill.io/v3/polyfill.min.js?features=Intl.~locale.en"><\/script>')</script>

	<script src="<?= template_url("assets/vendor/js/material-ripple.js")?>"></script>
	<script src="<?= template_url("assets/vendor/js/layout-helpers.js")?>"></script>

	<!-- Theme settings -->
	<!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->
	<script src="<?= template_url("assets/vendor/js/theme-settings.js")?>"></script>
	<script>
		window.themeSettings = new ThemeSettings({
			cssPath: '<?= template_url("assets/vendor/css/rtl/")?>',
			themesPath: '<?= template_url("assets/vendor/css/rtl/")?>'
		});
	</script>

	<!-- Core scripts -->
	<script src="<?= template_url("assets/vendor/js/pace.js")?>"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Libs -->
	<link rel="stylesheet" href="<?= template_url("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css")?>">
	<!-- Page -->
	<link rel="stylesheet" href="<?= template_url("assets/vendor/css/pages/authentication.css")?>">
</head>
<body>
<div class="page-loader">
	<div class="bg-primary"></div>
</div>
<div class="authentication-wrapper authentication-4 px-4">
	<div class="authentication-inner py-5">
		<!-- Logo -->
		<div class="d-flex justify-content-center align-items-center mb-5">
			<div class="ui-w-60">
				<img src="<?= template_url("assets/img/drclick.png")?>" width="150px" alt="logo" title="logo"/>
			</div>
		</div>
		<!-- / Logo -->
		<?= $content_for_layout; ?>
	</div>
</div>
<!-- Core scripts -->
<script src="<?= template_url("assets/vendor/libs/popper/popper.js") ?>"></script>
<script src="<?= template_url("assets/vendor/js/bootstrap.js") ?>"></script>
<script src="<?= template_url("assets/vendor/js/sidenav.js") ?>"></script>

<!-- Libs -->
<script src="<?= template_url("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js") ?>"></script>

<!-- Demo -->
<script src="<?= template_url("assets/js/demo.js") ?>"></script>
</body>
</html>
