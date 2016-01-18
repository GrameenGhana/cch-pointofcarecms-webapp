<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>Point of Care CMS</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
    <title>Point of Care CMS</title>

		{{ HTML::style('assets/stylesheets/styles.css'); }}

		{{ HTML::style('assets/scripts/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css'); }}
		{{ HTML::style('assets/scripts/bower_components/datatables-responsive/css/dataTables.responsive.css'); }}

	<!--<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />-->
</head>
<body>
	@yield('body')
	{{ HTML::script('assets/scripts/frontend.js'); }}
	
	<!--<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>-->
	
</body>
</html>