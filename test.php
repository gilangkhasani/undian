<html>
<head>
	<title></title>
	<style type="text/css">
	html{
		background: #1A1C20;
	}
	body{
		background: #272930;
		border: 1px solid #131519;
		box-shadow: 0 1px 0 #2A2C31 inset;
		margin: 10px;
	}
	#container{
		width: 1024px;
		margin: 50px auto 0 auto;
		padding: 50px;
		border: 1px solid #131519;
		box-shadow: 0 1px 0 #2A2C31 inset;
		background: #FFF;
		-moz-border-bottom-colors: none;
		-moz-border-left-colors: none;
		-moz-border-right-colors: none;
		-moz-border-top-colors: none;
		background-color: #f8f8f8;
		background-image: -moz-linear-gradient(center top, #ffffff 50%, #f8f8f8 100%);
		background-image: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#f8f8f8));
		background-image: -webkit-linear-gradient(top, #ffffff, #f8f8f8);
		background-image: -o-linear-gradient(top, #ffffff, #f8f8f8);
		background-image: linear-gradient(to bottom, #ffffff 50%, #f8f8f8 100%);
		border-color: #DEDFE0 #C8C8C8 #C8C8C8;
		border-image: none;
		border-right: 1px solid #C8C8C8;
		border-style: solid;
		border-width: 1px;
		box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.08);
		color: #333333;
		transition: border-color 0.21s ease-out 0s;
	}
	</style>
	<style type="text/css" href="themes/css/bootstrap.min.css"></style>
</head>
<body>
	<div id="container">
		<div class=""></div>
		<input type="number" id="input" />
		<input id="stop" type="button" value="stop"/>
		<input id="start" type="button" value="start"/>
	</div>

	<script src="themes/js/jquery.js"></script>
	<script type="text/javascript">
		var timer = null, 
		    interval = 1000,
		    value = 0;

		$("#start").click(function() {
		  if (timer !== null) return;
		  timer = setInterval(function () {
		      value = value+1;
		      $("#input").val(value);
		  }, interval); 
		});

		$("#stop").click(function() {
		  clearInterval(timer);
		  timer = null
		});
	</script>
</body>
</html>