<?php
include '../../../includes/database.php';
session_start();
if($_SESSION['undian_login']->name_roles == 'user'){
	$q = "select * from peserta_".$_GET['project']." where `status` = '0'";
	$sql = mysql_query($q);
	$data = array();
	$no = 1;
	while ($row = mysql_fetch_assoc($sql)) {
		$data["a".$no] = $row;
		$no++;
	}
	// print_r($data);
	echo json_encode($data);
}else{
	echo json_encode(array("status"=>"access Denied"));
}
?>