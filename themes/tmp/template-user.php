<?php
if ($path[0] == 'export') {
	if(!empty($loader['konten']))require_once $loader['konten'];
}else{
?>
<html>
<head>
<title>Telkomsel :: Undian</title>
<link href="<?php echo url('themes/css/bootstrap/css/bootstrap.css')?>" rel="stylesheet" type="text/css">
<link href="<?php echo url('themes/css/font-awesome-4.2.0/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css">
<link href="<?php echo url('themes/css/styles.css')?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo url('themes/js/jquery.js')?>"></script>
<script type="text/javascript" src="<?php echo url('themes/css/bootstrap/js/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?php echo url('themes/js/main.js')?>"></script>
</head>
<body>
	<div id="header">
		
	</div>
	<div id="nav">
		<div class="child-nav">
			<ul>
				<li>
					<a href="<?php echo url('home')?>" data-toggle="tooltip" data-placement="bottom" title="Home"><i class="fa fa-home"></i></a>
				</li>
				<?php 
				if($_SESSION['undian_login']->id_roles==1){?>
					<li>
						<a href="<?php echo url('master')?>" data-toggle="tooltip" data-placement="bottom" title="Master"><i class="fa fa-folder-open"></i></a>
					</li>
				<?php
				}else{
				?>
					<li>
						<a href="<?php echo url('undian')?>" data-toggle="tooltip" data-placement="bottom" title="Undian"><i class="fa fa-cube"></i></a>
					</li>
				<?php 
				}
				?>
				<li>
					<a href="<?php echo url('logout')?>" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="fa fa-sign-out"></i></a>
				</li>
			</ul>
			<div class="nav-title">
				<?php
				if(!empty($loader['title'])) echo $loader['title']; else echo "No Page";
				?>
			</div>
		</div>
	</div>
	<div id="body">
		<div class="container-fluid">
			<?php
			if(!empty($loader['konten']))require_once $loader['konten'];
			?>
		</div>
	</div>
	<div id="footer">
		<div class="child-footer">
			<div class="c-left-footer">
				<div class="down-footer-left">&copy; 2014 .:IT Operation Jabar:.</div>
			</div>
			<div class="c-right-footer">
				<div class="down-footer"></div>
				<div class="down-footer-image">
					<img src="<?php echo url('themes/image/simpati.png')?>" class="img-footer">
					<img src="<?php echo url('themes/image/kartu-halo.png')?>" class="img-footer">
					<img src="<?php echo url('themes/image/kartu-as.png')?>" class="img-footer">
					<img src="<?php echo url('themes/image/loop.png')?>" class="img-footer">
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
}
?>