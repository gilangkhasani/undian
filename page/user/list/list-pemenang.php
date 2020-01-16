<div id="content_isi">
<?php
$data_check = db_query("select * from project where id_project = '".$path[2]."' AND user_created = '".$_SESSION['undian_login']->id_user."'");
$check_project = "SELECT * 
				FROM hadiah 
				INNER JOIN list_pemenang ON list_pemenang.id_hadiah = hadiah.id_hadiah 
				INNER JOIN peserta_".$path[2]." ON peserta_".$path[2].".id_peserta = list_pemenang.id_peserta 
				INNER JOIN project ON project.id_project = hadiah.id_project 
				where hadiah.id_project = '".$path[2]."'
				ORDER BY hadiah.id_hadiah";
$arr = get_defined_vars();
$var_get = $arr['_GET'];
$last_values_get = base_last_values_get($var_get, FALSE, TRUE);
$data = base_data_plus_paging($check_project, '10', $var_get, TRUE);
$no = $data['offset'] + 1;	
if(empty($data_check)){
	echo status('Data tidak ditemukan');
	echo redirect('home');
}else{
	if(isset($_POST['delete-all'])){
		if(mysql_query("DELETE FROM list_pemenang where id_project = '".$path[2]."'")){
			
			mysql_query("UPDATE peserta_".$path[2]." SET status = '0'");
			echo status('Data telah dihapus');
			echo redirect('list/pemenang/'.$path[2]);
		}else{
			echo status('Terjadi kesalahan');
			echo redirect('list/pemenang/'.$path[2]);
		}
		return;
	}elseif(isset($_POST['delete-satu'])){
		if(mysql_query("DELETE FROM list_pemenang where id_list_pemenang = '".$_POST['id_list_pemenang']."'")){
			$row = db_query("SELECT * FROM peserta_".$path[2]." WHERE id_peserta = '".$_POST['id_peserta']."'");
			//$update = "UPDATE peserta_".$path[2]." SET status = '0' where id_peserta = '".$_POST['id_peserta']."'";
			$update = "UPDATE peserta_".$path[2]." SET status = '0' where fieldc = '".$row->fieldc."'";
			mysql_query($update);
			echo status('Data telah dihapus');
			echo redirect('list/pemenang/'.$path[2]);
		}else{
			echo status('Terjadi kesalahan');
			echo redirect('list/pemenang/'.$path[2]);
		}
		return;
	}
?>
<?php
	echo '<form method="post" style="float: left;width: 820px;margin-left: 90px;">';
	echo '<a href="'.url('undian/view/'.$path[2]).'" class="btn btn-danger" style="float:left"><i class="fa fa-arrow-left"></i> Kembali</a>';
	echo '<a href="'.url('export/pemenang/'.$path[2]).'" class="btn btn-info" target="_BLANK" style="margin-left: 5px;float: right;height: auto;padding: 6px;">Export</a>';
	echo '<input class="btn btn-info" type="submit" value="Hapus semua daftar pemenang" name="delete-all" style="float:right">';
	echo '</form>';
	echo '<legend style="margin:10px auto;text-align:right;width: 820px">List Pemenang '.$data_check->name_project.'</legend>';
	echo '<div id=content>';
	echo '<table class="table table-striped" style="margin:auto; background:#FFF; width: 820px">';
	$data_field = db_query("select 'No' as no, `field1`, `field2`, 'HADIAH' as hadiah, 'CLUSTER' as field3,'PERIODE', 'Delete' as `delete` from configure where id_project = '".$path[2]."'");
	echo '<thead>';
	echo  '<tr>';
	echo  '<td>'.$data_field->no.'</td>';
	if(!empty($data_field->field1)) echo  '<td>RS</td>';
	if(!empty($data_field->field2)) echo  '<td>OUTLET</td>';
	if(!empty($data_field->field3)) echo  '<td>TDC</td>';
	echo  '<td style="text-align:center">'.$data_field->hadiah.'</td>';
	echo  '<td style="text-align:center">'.$data_field->PERIODE.'</td>';
	echo  '<td style="text-align:center">'.$data_field->delete.'</td>';
	echo  '</tr>';
	echo '</thead>';
	echo '<tbody>';
	foreach ($data['data'] as $key => $value) {
		echo '<tr>';
		echo '<td style="text-align:center">'.$no.'</td>';
		if(!empty($data_field->field1)) echo '<td>'.$value->fielda.'</td>';
		if(!empty($data_field->field2)) echo '<td>'.$value->fieldb.'</td>';
		if(!empty($data_field->field3)) echo '<td>'.$value->fieldc.'</td>';
		echo '<td style="text-align:center">'.$value->name_hadiah.'</td>';
		echo '<td style="text-align:center">'.$value->periode.'</td>';
		echo '<td style="text-align:center"><form method="post" style="margin:0"><input class=btn type="submit" value="delete" name="delete-satu"><input type="hidden" value="'.$value->id_list_pemenang.'" name="id_list_pemenang"><input type="hidden" value="'.$value->id_peserta.'" name="id_peserta"></form></td>';
		echo '</tr>';
		$no++;
	}
	echo '</tbody>';
	echo '</table>';
	echo '</div>';
	echo $data['paging'];
}
?>
</div>
