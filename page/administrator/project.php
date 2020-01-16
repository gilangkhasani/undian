<?php 
date_default_timezone_set("Asia/Bangkok");
$user = "";
$pesan = "";
if(!empty($_GET['id'])){
	$exec = mysql_query("Delete from project where id_project = '".$_GET['id']."'");
	if($exec){
		echo status("Data project Berhasil Dihapus!!");
		echo redirect("master/project");
	}else{
		echo status("Data project Masih Dipakai di table lain!!");
		echo redirect("master/project");
	}
}
if(!empty($_POST['submit'])){
	$cek = db_query("select * from project where name_project = '".$_POST['name_project']."' ");
	if(!empty($cek)){
		$pesan = "Data Untuk Project ini Sudah ada!!!";
		$user = $_POST['user'];
		$name_project = $_POST['name_project'];
		$description = $_POST['description'];
	}else{
		$query = mysql_query("Insert into project(name_project,description,user_created,date_created) values('".$_POST['name_project']."','".$_POST['description']."','".$_POST['user']."','".date('Y-m-d H:i:s')."') ");
		if($query){
			echo status("Data project Berhasil Ditambahkan!!!");
			echo redirect("master/project");
		}else{
			$pesan = "Maaf Data project Gagal ditambahkan!!!";
			$user = $_POST['user'];
			$name_project = $_POST['name_project'];
			$description = $_POST['description'];
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
			<u>PROJECT</u>
		</div>
		<a href="<?php echo url('master')?>" class="btn btn-danger" style="margin-left:100px"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="row">
			<?php if(!empty($pesan)) echo "<div class='alert alert-danger' align=center style='width:80%;margin:10 auto'>".$pesan."</div>"; ?>
			<table class="table" style="width:80%;margin: 10px auto;">				
				<form method="post">
					<thead style="background-color:#EC0000;color:#fff">
					<tr>
						<th>User</th>
						<th>Name Project</th>
						<th>Deskripsi</th>
						<th>Action</th>
					</tr>
					</thead>
					<tr>
						<td>
							<select name="user">
								<?php 
								$data = db_query2list("Select * from tbl_user order by id_user ");
								if(!empty($data)){
									foreach ($data as $value) {
										if($value->id_user==$user) $pilih = "selected"; else $pilih = "";
										echo "<option value='".$value->id_user."' ".$pilih.">".$value->username."</option>";
									}
								}
								?>
							</select>
						</td>
						<td><input type="text" name="name_project" value="<?php if(!empty($name_project)) echo $name_project ?>" placeholder="Nama Project"></td>
						<td><input type="text" name="description" value="<?php if(!empty($description)) echo $description ?>" placeholder="Deskripsi"></td>
						<td><input type="submit" name="submit" class="btn btn-primary btn-x"></td>
					</tr>
				</form>
			</table>
			<br>
			<?php
			$data_project = "Select username,id_project,name_project,description,c.date_created from project c inner join tbl_user p on p.id_user = c.user_created";		
			$arr = get_defined_vars();
			$var_get = $arr['_GET'];
			$last_values_get = base_last_values_get($var_get, FALSE, TRUE);
			$data = base_data_plus_paging($data_project, '20', $var_get, TRUE);
			$no = $data['offset'] + 1;	
			if(!empty($data)){
			?>
			<table class="table table-striped" style="width:80%;margin: -25px auto 25px;">		
				<thead style="background-color:#EC0000;color:#fff">
					<tr>
						<th>No</th>
						<th>Nama Project</th>
						<th>Deskripsi</th>
						<th>User</th>
						<th>Date Created</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($data['data'] as $key => $values) {
						echo "<tr>
								<td>".$no."</td>
								<td>".$values->name_project."</td>
								<td>".$values->description."</td>
								<td>".$values->username."</td>
								<td>".$values->date_created."</td>
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