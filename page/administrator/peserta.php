<?php 
if(isset($_POST['submit'])){
	$tanggal = date('Y-m-d');
	$waktu = strtotime(date('H:i:s'));
	$file = $_FILES['file']['name'];

	$eror		= false;
	$folder		= 'file/import/';
	//type file yang bisa diupload
	$file_type	= array('csv');
	//tukuran maximum file yang dapat diupload
	$max_size	= 500000000; // 5MB
	if($file!=''){
		//Mulai memorises data
		$file_size	= $_FILES['file']['size'];
		//cari extensi file dengan menggunakan fungsi explode
		$explode	= explode('.',$_FILES['file']['name']);
		$extensi	= $explode[count($explode)-1];
		
		//ubah nama file
		$file_name	= "import -".$tanggal."-".$waktu.".".$extensi;
        $file_loc = $folder.$file_name;

		//check apakah type file sudah sesuai
		$pesan='';
		if(!in_array($extensi,$file_type)){
			$eror   = true;
			$pesan .= '- Type file yang anda upload tidak sesuai<br />';
		}
		if($file_size > $max_size){
			$eror   = true;
			$pesan .= '- Ukuran file melebihi batas maximum<br />';
		}
		//check ukuran file apakah sudah sesuai

		if($eror == true){
			echo '<div class="alert alert-error">'.$pesan.'</div>';
		}
		else{
			//mulai memproses upload file
			if(move_uploaded_file($_FILES['file']['tmp_name'],$folder.$file_name)){
			    $hasil = import_csv(',',$file_name,$_POST['project']);
			    //print_r($hasil);
				echo status("Data Peserta Berhasil Diimport!!");
				echo redirect("master/peserta");
			}
		}
	}else{
        $pesan = "<div class='alert alert-danger'>Data gagal Ditambahkan !!</div>";
    }
}else{
    $file = '';
    $judul = '';
    $tahun= '';
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
			<u>PESERTA</u>
		</div>
		<a href="<?php echo url('master')?>" class="btn btn-danger" style="margin-left:100px"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="row">
			<?php if(!empty($pesan)) echo "<div class='alert alert-danger' align=center style='width:80%;margin:10 auto'>".$pesan."</div>"; ?>
			<table class="table" style="width:80%;margin: 10px auto;">				
				<form method="post" enctype="multipart/form-data">
					<tr>
						<td>
							<select name="project">
								<?php 
								$data = db_query2list("Select * from project order by id_project ");
								if(!empty($data)){
									foreach ($data as $value) {
										echo "<option value='".$value->id_project."'>".$value->name_project."</option>";
									}
								}
								?>
							</select>
						</td>
						<td>Pilih File: </td>
						<td><input type="file" name="file" value="<?php if(!empty($file)) echo $file ?>"></td>
						<td><input type="submit" name="submit" class="btn btn-primary btn-x" value="Import"></td>
					</tr>
				</form>
			</table>
		</div>
	</div>
</div>