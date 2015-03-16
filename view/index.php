<!DOCTYPE html>
<html>
<head>
	<title>Theme Check Service</title>
	<link rel="stylesheet" href="view/css/style.css">
</head>
<body>

	<header class="site-header">
		<div class="container">
			<h1><a href="/">Theme Check</a></h1>
		</div>
	</header>

	<section class="site-main">
		<form class="container" enctype="multipart/form-data" action="/validate/" method="post">
			<input type="file" name="theme" />
			<input type="submit" />

			<fieldset>
				<legend>Choose which checks to run.</legend>
				<div id="tests-list"></div>
				<div class="actions">
					<button class="check-none">Uncheck all</button>
					<button class="check-all">Check all</button>
				</div>
			</fieldset>
		</form>
	</section><!-- /.site-main -->

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.2/underscore-min.js"></script>
	<script type="text/javascript">
		window.API_URL = '<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>';
	</script>
	<script src="view/js/main.js"></script>
	<script type="text/html" id="tmpl-result">
		<li>
			<% if ( file ) { %>
			<code><%= file %><% if ( line ) { %>:<%= line %><% } %></code><br />
			<% } %>
			<span><%= error %></span>
		</li>
	</script>
	<script type="text/html" id="tmpl-score">
		<p><span><%= passes %></span>/<span><%= total %></span> tests passed.</p>
	</script>
</body>
</html>