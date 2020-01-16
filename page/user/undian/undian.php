<?php
$check_data = db_query("SELECT * FROM project where id_project = '".$path[2]."' AND user_created = '".$_SESSION['undian_login']->id_user."'");
if(empty($check_data)){
	echo status('Data tidak ditemukan!!!');
	echo redirect('home');
}else{
?>
	<div class="row">
		<div class="col-md-12">
			<div class="title-list-undian">
				<u><?php echo $check_data->name_project?></u>
			</div>
			<a href="<?php echo url('undian')?>" class="btn btn-danger" style="margin-left:100px"><i class="fa fa-arrow-left"></i> Kembali</a>
			<div class="row">
				<ul class="menu-undian">
					<li><a class="list" href="<?php echo url('undian/undi/'.$path[2])?>"><i class="fa fa-cubes"></i><br>Mulai Undi Manual</a></li>
					<li><a class="list" href="<?php echo url('undian/undi-auto/'.$path[2])?>"><i class="fa fa-cubes"></i><br>Mulai Undi Automatis</a></li>
					<li><a class="list" href="<?php echo url('list/pemenang/'.$path[2])?>"><i class="fa fa-trophy"></i><br>Lihat Pemenang</a></li>
					<li><a class="list" href="<?php echo url('list/peserta/'.$path[2])?>"><i class="fa fa-users"></i><br>Lihat Peserta</a></li>
				</ul>
			</div>
		</div>
	</div>
<?php
}
?>