<?php
if($path[0] == 'export' || $path[0] == 'print'){
	if(!empty($loader['konten']))require_once $loader['konten'];
}else{
?>
	<!DOCTYPE html>
	<!-- saved from url=(0052)http://microprism.html.themeforest.designsentry.com/ -->
	<html lang="en"><!--<![endif]-->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	    <title>Template</title>
	    <link rel="stylesheet" href="<?php echo url('themes/css/bootstrap.min.css')?>">
	    <link rel="stylesheet" href="<?php echo url('themes/css/normalize.css')?>">
	    <link rel="stylesheet" href="<?php echo url('themes/css/base.css')?>">
	    <link rel="stylesheet" href="<?php echo url('themes/css/hr.css')?>">

	    <script src="<?php echo url('themes/js/jquery-1.11.0.min.js')?>"></script>
	    <script src="<?php echo url('themes/js/bootstrap.min.js')?>"></script>
	    <script src="<?php echo url('themes/js/main/main.js')?>"></script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="border-radius:0; background-color:#2b579a;border-bottom: solid 3px #FFA500; min-height:85px">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header hr-navbar-header" style="background:#ffa500;border-radius: 0 0 0 10px;">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href=""><img src="<?php echo url('themes/img/garuda.png')?>" style="width:75px"></a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse hr-navbar" style="height: 40px !important;background: #2b579a;padding: 5px 0 !important;">
					<!-- <ul class="nav navbar-nav">
						<li><span class="glyphicon glyphicon-th-large" style="color:#CCCCCC"></span><span class="glyphicon glyphicon-play" style="color:#CCCCCC;font-size:12px"></span></li>
						<li><a href=""><span class="glyphicon glyphicon-book" style="color:#FFFFFF;font-size:15px"></span></a></li>
						<li><a href=""><span class="glyphicon glyphicon-file" style="color:#FFFFFF;font-size:15px"></span></a></li>
						<li><a href=""><span class="glyphicon glyphicon-user" style="color:#FFFFFF;font-size:15px"></span></a></li>
					</ul> -->
					<font style="font-size: 15px;color: #FFF;right: 17px;position: absolute;top: 17px;">Aplikasi pengolahan data warga RW 01 Kel. Cisaranten Endah Kec. Arcamanik</font>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="margin-left:50px;background:#ffa500; border-radius: 0 10px 0 0; border-top: 1px solid #E7E7E7;">
					<ul class="nav navbar-nav">
						<li><a href="<?php echo url('home')?>">Home</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">User <b class="caret"></b></a>
							<ul class="dropdown-menu" style="background:#FFA500;">
								<li><a href="<?php echo url('admin/user')?>">Lihat User</a></li>
								<li class="divider"></li>
								<li><a href="<?php echo url('admin/add-user')?>">Tambah User</a></li>
							</ul>
						</li>
						</ul>
						<ul class="nav navbar-nav navbar-right" style="margin-right:0;">
							<li class="dropdown" style="padding:8px">
								<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
									Settings</span> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" style="background:#2B579A;">
									<li><a href="<?php echo url('profile')?>" style="color:#FFFFFF">Profile</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo url('change-password')?>" style="color:#FFFFFF">Ganti Password</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo url('logout')?>" style="color:#FFFFFF">Log Out</a></li>
								</ul>
							</li>
						</ul>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		<div class="container-fluid" style="margin-top:86px;border: 5px #2B579A solid;">
			<div class="row" style="margin-top: 5px; margin-bottom:10px">
				<div class="col-md-offset-7 col-md-5">
					<div class="hr-title-page"><?php echo $loader['title']?></div>
					<div class="hr-title-user">
						<span class="glyphicon glyphicon-user"></span>
						<span><?php echo $_SESSION['undian_login']->fullname?></span>
						<span class="glyphicon glyphicon-flag"></span>
						<span><?php echo strtoupper($_SESSION['undian_login']->name_roles)?></span>
					</div>
				</div>
				<!-- <div class="col-md-offset-2 col-md-5">asd</div> -->
			</div>
			<div class="row">
				<?php
				if(!empty($loader['konten']))require_once $loader['konten'];
				?>
			</div>
		</div>
	</body>
	</html>
<?php
}
?>