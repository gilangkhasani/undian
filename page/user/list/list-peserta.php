<div id="content_isi">
<?php
$data_check = db_query("select * from project where id_project = '".$path[2]."' AND user_created = '".$_SESSION['undian_login']->id_user."'");
$check_project = "SELECT * 
					FROM
					peserta_".$path[2]." ORDER BY id_peserta";
$arr = get_defined_vars();
$var_get = $arr['_GET'];
$last_values_get = base_last_values_get($var_get, FALSE, TRUE);
$data = base_data_plus_paging($check_project, '20', $var_get, TRUE);
$no = $data['offset'] + 1;	
if(empty($data['data'])){
	echo status('Data tidak ditemukan');
	echo redirect('home');
}else{
	echo '<div style="float: left;width: 820px;margin-left: 90px;">';
	echo '<a href="'.url('undian/view/'.$path[2]).'" class="btn btn-danger" style="float:left"><i class="fa fa-arrow-left"></i> Kembali</a>';
	echo '</div>';
	echo '<legend style="margin:10px auto;text-align:right;width: 820px">List Peserta '.$data_check->name_project.'</legend>';
	echo '<div id=content>';
	echo '<table class="table table-striped" style="margin:auto; background:#FFF; width: 820px">';
	$data_field = db_query("select 'No' as no, `field1`, `field2`, `field3`, 'Hadiah' as hadiah, 'Periode' as periode from configure where id_project = '".$path[2]."'");
	echo '<thead>';
	echo  '<tr>';
	echo  '<td>'.$data_field->no.'</td>';
	if(!empty($data_field->field1)) echo  '<td>'.$data_field->field1.'</td>';
	if(!empty($data_field->field2)) echo  '<td>'.$data_field->field2.'</td>';
	if(!empty($data_field->field3)) echo  '<td>'.$data_field->field3.'</td>';
	echo  '</tr>';
	echo '<thead>';
	echo '<tbody>';
	foreach ($data['data'] as $key => $value) {
		echo '<tr>';
		echo '<td>'.$no.'</td>';
		if(!empty($data_field->field1))echo '<td>'.$value->fielda.'</td>';
		if(!empty($data_field->field2))echo '<td>'.$value->fieldb.'</td>';
		if(!empty($data_field->field3))echo '<td>'.$value->fieldc.'</td>';
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