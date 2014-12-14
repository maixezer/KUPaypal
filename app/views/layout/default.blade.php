<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <title>KUPaypal</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
	</head>
	<body>
		@if(Session::has('success'))
		<div id="notice" class="notice notice-success">
	        {{ Session::get('success') }}
	    </div>
	  	@elseif(Session::has('fail'))
	    <div id="notice" class="notice notice-fail">
	        {{ Session::get('fail') }}
	    </div>
		@endif
		@yield('content')
	</body>
	<style type="text/css">
			.notice{
				position: fixed;
				top: 10%;
				left: 30%;
				width: 40%;
				line-height: 40px;
				text-align: center;
				overflow: auto;
				z-index: 4000;
				color:#fff;
				font-family: MyriadPro,Geneva,Arial,sans-serif;
				font-size:30px;
				padding:10px 10px 10px 10px;
				border-radius: 5px;
			}
			.notice-success{
				background-color: rgba(62,201,179,0.7);
			}
			.notice-fail{
				background-color: rgba(246,81,136,0.7);
			}
	</style>
	<script>
		if(document.getElementById("notice")!== null)
        	$('#notice').delay(1000).fadeOut(1000);
	</script>
</html>