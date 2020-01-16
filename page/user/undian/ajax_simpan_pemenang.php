<?php
include '../../../includes/database.php';
session_start();
if($_SESSION['undian_login']->name_roles == 'user'){
	$query = "INSERT INTO list_pemenang (id_peserta, id_hadiah, periode, id_project) values ('".$_GET['id_peserta']."', '".$_GET['id_hadiah']."', '".$_GET['periode']."', '".$_GET['id_project']."')";
	$row = mysql_fetch_object(mysql_query("SELECT * FROM peserta_".$_GET['id_project']." WHERE id_peserta = '".$_GET['id_peserta']."'"));
	//$query1 = mysql_query("UPDATE peserta_".$_GET['id_project']." set `status` = '1' WHERE fielda = '".$_GET['pemenang']."'");
	$query1 = mysql_query("UPDATE peserta_".$_GET['id_project']." set `status` = '1' WHERE fieldc = '".$row->fieldc."'");
	if(mysql_query($query)){
		$data['status'] = 'simpan';
	}else{
		$data['status'] = 'gagal';
	}
}else{
	$data['status'] = 'access-denied';
}
echo json_encode($data);
?>