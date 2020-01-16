<?php 
$project = "";
if(!empty($_GET['id'])){
	$exec = mysql_query("Delete from configure where id_project = '".$_GET['id']."'");
	if($exec){
		echo status("Data Configure Berhasil Dihapus!!");
		echo redirect("master/configure");
	}else{
		echo status("Data Configure Masih Dipakai di table lain!!");
		echo redirect("master/configure");
	}
}
if(!empty($_POST['submit'])){
	$cek = db_query("select * from configure where id_project = '".$_POST['project']."' ");
	if(!empty($cek)){
		$pesan = "Configure Untuk Project ini Sudah ada!!!";
		$project = $_POST['project'];
		$field_a = $_POST['field_a'];
		$field_b = $_POST['field_b'];
		$field_c = $_POST['field_c'];
	}else{
		$query = mysql_query("Insert into configure(id_project,field1,field2,field3) values('".$_POST['project']."','".$_POST['field_a']."','".$_POST['field_b']."','".$_POST['field_c']."') ");
		if($query){
			echo status("Data Configur Berhasil Ditambahkan!!!");
			echo redirect("master/configure");
		}else{
			$pesan = "Maaf Data Configure Gagal ditambahkan!!!";
			$project = $_POST['project'];
			$field_a = $_POST['field_a'];
			$field_b = $_POST['field_b'];
			$field_c = $_POST['field_c'];
		}
	}
}
?>
<style type="text/css">
input,select{
	border-radius: 5px ;
	padding: 3px;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="title-list-undian">
			<u>CONFIGURE</u>
		</div>
		<a href="<?php echo url('master')?>" class="btn btn-danger" style="margin-left:100px"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="row">
			<?php if(!empty($pesan)) echo "<div class='alert alert-danger' align=center style='width:80%;margin:10 auto'>".$pesan."</div>"; ?>
			<table class="table" style="width:80%;margin: 10px auto;">				
				<form method="post">
					<thead style="background-color:#EC0000;color:#fff">
					<tr>
						<th>Project</th>
						<th>Field 1</th>
						<th>Field 2</th>
						<th>Field 3</th>
						<th>Action</th>
					</tr>
					</thead>
					<tr>
						<td>
							<select name="project">
								<?php 
								$data = db_query2list("Select * from project order by id_project ");
								if(!empty($data)){
									foreach ($data as $value) {
										if($value->id_project==$project) $pilih = "selected"; else $pilih = "";
										echo "<option value='".$value->id_project."' ".$pilih.">".$value->name_project."</option>";
									}
								}
								?>
							</select>
						</td>
						<td><input type="text" name="field_a" value="<?php if(!empty($field_a)) echo $field_a ?>" placeholder="Field 1"></td>
						<td><input type="text" name="field_b" value="<?php if(!empty($field_b)) echo $field_b ?>" placeholder="Field 2"></td>
						<td><input type="text" name="field_c" value="<?php if(!empty($field_c)) echo $field_c ?>" placeholder="Field 3"></td>
						<td><input type="submit" name="submit" class="btn btn-primary btn-x"></td>
					</tr>
				</form>
			</table>
			<br>
			<?php
			$no=0;
			$data_project = "Select c.id_project,field1,field2,field3,name_project from configure c inner join project p on p.id_project = c.id_project";		
			$arr = get_defined_vars();
			$var_get = $arr['_GET'];
			$last_values_get = base_last_values_get($var_get, FALSE, TRUE);
			$data = base_data_plus_paging($data_project, '20', $var_get, TRUE);
			$no = $data['offset'] + 1;	
			if(!empty($data)){
			?>
			<table class="table table-striped" style="width:80%;margin: -25px auto;">		
				<thead style="background-color:#EC0000;color:#fff">
					<tr>
						<th>No</th>
						<th>Project</th>
						<th>Field 1</th>
						<th>Field 2</th>
						<th>Field 3</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($data['data'] as $key => $values) {
						echo "<tr>
								<td>".$no."</td>
								<td>".$values->name_project."</td>
								<td>".$values->field1."</td>
								<td>".$values->field2."</td>
								<td>".$values->field3."</td>
								<td><a href='?id=".$values->id_project."' ><i class='fa fa-trash'></i></td>
							</tr>";
						$no++;
					}

					echo "<tr><td colspan=6>".$data['paging']."</td></tr>";
					?>
				</tbody>
			</table>
			<?php
			}else{
				echo "<div class='alert alert-info' align=center style='width:80%;margin:10 auto'>".$pesan."</div>";
			}
			?>
		</div>
	</div>
</div>