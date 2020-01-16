<?php
$check_data = db_query("SELECT * FROM project where id_project = '".$path[2]."' AND user_created = '".$_SESSION['undian_login']->id_user."'");
if(empty($check_data)){
	echo status("Data tidak ditemukan");
	echo redirect('home');
}else{
	?>
	<style type="text/css">
		.form-input-undi{
			font-size: 20px;
			height: auto;
			background: #F00;
			border-radius: 10px 10px 0 0;
			color: #FFF;
			background: url(<?php echo url("themes/image/pattern.png")?>) #F00;
			border: none;
		}
		.info-undian-auto ul li{
			margin: 15px 5px;
		}
		.input-info{
			background: none;
			text-align: left !important;
			border: none;
		}

		.info-undian{
			margin: 0;
			padding: 0;
			text-align: center;
		}
		.info-undian li{
			list-style: none;
			display: inline-block;
			margin: 5px 10px;
			background: url(<?php echo url("themes/image/pattern.png")?>) #F00;
			padding: 3px;
			color: #FFF;
		}
		.info-undian li a{
			color: #FFF;
		}
		.info-undian li a input{
			display: inline-block;
		}
		.info-undian li a:hover{
			text-decoration: none;
			font-weight: bold;
		}
		#ambil{
			display: none;
		}
		.table-option tr td{
			padding: 0 5px;
		}
	</style>
	<input name="status-batal" type="hidden" value="0">
	<div class="row">
		<a href="<?php echo url('undian/view/'.$path[2])?>" class="btn btn-danger" style="margin-left: 100px;position: absolute;"><i class="fa fa-arrow-left"></i></a>
	</div>
	<div class="row">
		<link rel="stylesheet" type="text/css" href="<?php echo url('themes/css/button/css/style.css')?>">
		<audio id="lottery" src="<?php echo url('themes/sound/5-detik.mp3')?>" preload="auto"></audio>
		<audio id="applause" src="<?php echo url('themes/sound/applause.mp3')?>" preload="auto"></audio>
		<div class="cont-generate">
			<div id="generate"><?php if($_SESSION['undian_login']->id_roles=='2'){echo "XXXXXXXXXX";} else{ echo "XXXXXXXXXX" ;} ?></div>
			<div>
				<button id="ambil" class="tombol-tambahan-undian">Ambil Pemenang</button>
			</div>
		</div>
		<div class="info-undian-auto" style="margin-left: 140px;width: 450px;">
			<ul>
				<li>
					<label>Pilih Hadiah : </label><br />
					<select name="hadiah" class="form-control form-input-undi">
						<?php
						$data = db_query2list("select * From hadiah where id_project = '".$path[2]."'");
						foreach ($data as $key => $value) {
							echo '<option value="'.$value->id_hadiah.'">'.$value->name_hadiah.'</option>';
						}
						?>
					</select>
				</li>
				<li>
					<table class="table-option" style="width:100%;margin: -30px 0 0 0;">
						<tr>
							<td style="width:170px; text-align:center"><label>Periode</label></td>
							<td style="width:90px; text-align:center"><label>Jumlah Pemenang</label></td>
							<td style="text-align:center"><label>Waktu Acak (s)</label></td>
							<td rowspan="2">
								<button id="submit" class="btn btn-danger" style="height:90px; border-radius: 40px;background: #CCC;color: #000;font-weight: bold;width:75px">Submit</button>
								<button class="btn btn-danger load-image" style="display:none; height:90px; border-radius: 40px;background: #CCC;color: #000;font-weight: bold;width:75px">
									<img src="<?php echo url('themes/image/loading.gif')?>" class="">
								</button>
								<!-- <input id="kembali" class="btn btn-danger" type="button" value="Batal" style="display:none;height:90px; border-radius: 40px;background: #CCC;color: #000;font-weight: bold;width:75px"/> -->
								<a id="kembali" href="" class="btn btn-danger" style="display:none;padding: 34px 0; border-radius: 40px;background: #CCC;color: #000;font-weight: bold;width:75px">Batal</a>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="periode" class="form-control form-input-undi" style="width:160px" value="<?php echo date('Y-m-d') ?>">
							</td>
							<td style="text-align:center">
								<input type="text" name="peng_jml_pemenang" class="validate-numeric validate-min1 form-control form-input-undi" value="1" style="width:45px;margin: auto;text-align: center;">
							</td>
							<td style="text-align:center">
								<select name="select-durasi" style="width: 75px;display: inline-block;" class="form-control form-input-undi">
									<option value="5">5</option>
									<option value="10">10</option>
									<option value="15">15</option>
									<option value="20">20</option>
									<option value="25">25</option>
									<option value="30">30</option>
								</select>
								<input type="text" name="durasi" class="validate-numeric validate-min2" value="5" style="display:none">
							</td>
						</tr>
					</table>
				</li>
			</ul>
		</div>
		<div class="tombol-undian">
			<div class="switch demo4">
				<input type="checkbox" id="tombol" disabled="disabled">
				<label><i class='fa fa-power-off'></i></label>
			</div>
		</div>
		<input type="hidden" name="project" value="<?php echo $path[2]?>">
	</div>
	<div class="row">
		<div class="">
			<label>List Pemenang</label>
		</div>
		<div id="append-list-pemenang">
			
		</div>
	</div>
	<div class="row" style="border-top: 1px solid #EC0000;border-bottom: 1px solid #EC0000;">
		<?php
		$query = "SELECT *
					FROM
					hadiah
					INNER JOIN list_pemenang ON list_pemenang.id_hadiah = hadiah.id_hadiah
					INNER JOIN peserta_".$path[2]." ON peserta_".$path[2].".id_peserta = list_pemenang.id_peserta
					INNER JOIN project ON project.id_project = hadiah.id_project
					where hadiah.id_project = '".$path[2]."'";
		$data_pemenang = db_query2list($query);

		$q_peserta = mysql_query("SELECT 'semua' as title, count(*) as jumlah From peserta_".$path[2]."
						UNION 
						SELECT 'unik' as title, count(*) FROM (SELECT 'unik' as title, count(*) as jumlah From peserta_".$path[2]." GROUP BY fielda) as jml");
		$data_peserta = new stdClass();
		while ($row = mysql_fetch_object($q_peserta)) {
			$title = $row->title;
			$data_peserta->$title = $row->jumlah;
		}
		
		$data_field = db_query("select * from configure where id_project = '".$path[2]."'");
		?>
		<ul class="info-undian">
			<li>
				<a href="<?php echo url('list/pemenang/'.$path[2])?>" data-toggle="tooltip" data-placement="bottom" title="Klik untuk lihat list pemenang">
					Jumlah Pemenang : <input type="text" name="pemenang" readonly="readonly" value="<?php echo count($data_pemenang)?>" style="width:50px;text-align: right;" class="input-info">
				</a>
			</li>
			<li>
				<a href="<?php echo url('list/peserta/'.$path[2])?>" data-toggle="tooltip" data-placement="bottom" title="Klik untuk lihat list peserta">
					Jumlah Per<?php echo $data_field->field1?> / Semua Peserta : 
					<input type="text" name="peserta2" readonly="readonly" value="<?php if(isset($data_peserta->unik)) echo $data_peserta->unik; else echo "0";?>" style="width:50px;text-align: right;" class="input-info">/
					<input type="text" name="peserta2" readonly="readonly" value="<?php if(isset($data_peserta->semua)) echo $data_peserta->semua; else echo "0";?>" style="width:50px;text-align: right;" class="input-info">
				</a>
			</li>
		</ul>
	</div>
	<script src="<?php if($_SESSION['undian_login']->id_roles=='2') echo url('themes/js/undian-auto.js'); else echo url('themes/js/undian-auto-pin.js'); ?>"></script>
<?php
}
?>