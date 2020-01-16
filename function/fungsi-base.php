<?php
function base_date_format($date, $seperator){
	$explode = explode($seperator, $date);
	return $explode[2].'-'.$explode[1].'-'.$explode[0];
}

function base_date_format_strtotime($date, $format){
	if($date == '0000-00-00'){
		return '';
	}else{
		return date($format, strtotime($date));
	}
}

function base_last_values_get($var_get, $page = TRUE, $q = TRUE, $change_q=NULL){
	if(!empty($change_q)){
		if(isset($var_get['q'])){
			$var_get[$change_q]=$var_get['q'];
			unset($var_get['q']);
		}
	}
	if($q){
		if(isset($var_get['q'])) unset($var_get['q']);
	}
	if($page)
		if(isset($var_get['page'])) unset($var_get['page']);
	$last_values_get = '';
	$urut = 1;
	foreach($var_get as $index_var_get => $values_var_get){
		if($urut == 1){
			$last_values_get .= $index_var_get."=".$values_var_get;
		}else{
			$last_values_get .= "&".$index_var_get."=".$values_var_get;
		}
		$urut++;
	}
	return $last_values_get;
}

function base_data_plus_paging($querydata, $dataPerPage, $var_get, $jum_paging=FALSE){
	isset($var_get['page'])?$noPage = $var_get['page'] : $noPage = 1;
	$offset = ($noPage - 1) * $dataPerPage;

	if(isset($var_get['q'])) unset($var_get['q']);
	if(isset($var_get['page'])) unset($var_get['page']);

	$data = db_query2list($querydata." limit $offset,$dataPerPage");
	$jumlah_data = mysql_num_rows(mysql_query($querydata));
	$akhir_hal = ceil($jumlah_data/$dataPerPage);

	
	$last_values_get = base_last_values_get($var_get);

	$paging = '';
	$paging .= '<form action="" method="get" style="text-align:center;color:#000">';
	foreach ($var_get as $key => $value) {
		$paging .= '<input type="hidden" value="'.$value.'" name="'.$key.'">';
	}
	if ($noPage > 1) {
		if ($jum_paging == TRUE) {
			$paging .=  "<a href='?".$last_values_get."&page=1' class='jp-previous jp-np' style='padding: 2px 5px;font-weight: bold;'><i class='fa fa-backward'></i></a>";
		}
		$paging .=  "<a href='?".$last_values_get."&page=".($noPage-1)."' class='jp-previous jp-np' style='padding: 2px 5px;font-weight: bold;'><i class='fa fa-chevron-left'></i></a>";
	}
	$paging .= '<input type="text" name="page" value="'.$noPage.'" class="input-type form-control" style="width: 50px;text-align: center;display: inline;">';
	$paging .= '<font style="color:#000">  of  '.$akhir_hal.'</font>';
	if ($noPage < $akhir_hal) {
		$paging .= "<a href='?".$last_values_get."&page=".($noPage+1)."' class='jp-next jp-np' style='padding: 2px 5px;font-weight: bold;'><i class='fa fa-chevron-right'></i></a>";
		if ($jum_paging == TRUE) {
			$paging .=  "<a href='?".$last_values_get."&page=".$akhir_hal."' class='jp-previous jp-np' style='padding: 2px 5px;font-weight: bold;'><i class='fa fa-forward'></i></a>";
		}
	}
	$paging .= '</form>';
	$output['data'] = $data;
	$output['paging'] = $paging;
	$output['offset'] = $offset;
	return $output;
}

function base_col_excel(){
	$strtono = array(
			'1'=>'A',
			'2'=>'B',
			'3'=>'C',
			'4'=>'D',
			'5'=>'E',
			'6'=>'F',
			'7'=>'G',
			'8'=>'H',
			'9'=>'I',
			'10'=>'J',
			'11'=>'K',
			'12'=>'L',
			'13'=>'M',
			'14'=>'N',
			'15'=>'O',
			'16'=>'P',
			'17'=>'Q',
			'18'=>'R',
			'19'=>'S',
			'20'=>'T',
			'21'=>'U',
			'22'=>'V',
			'23'=>'W',
			'24'=>'X',
			'25'=>'Y',
			'26'=>'Z'
			);
	return $strtono;
}

function base_romawitonumber($integer, $upcase = true) 
{ 
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
    $return = ''; 
    while($integer > 0) 
    { 
        foreach($table as $rom=>$arb) 
        { 
            if($integer >= $arb) 
            { 
                $integer -= $arb; 
                $return .= $rom; 
                break; 
            } 
        } 
    } 

    return $return; 
}

function import_csv($seperator, $new_name_file,$project){
	ini_set('max_execution_time', 150000); // 1500 seconds
	$file = fopen('./file/import/'.$new_name_file,"r");
	$data_import = array();
	$data_hasil = array();
	$data_hasil['berhasil'] = NULL;
	$data_hasil['gagal'] = NULL;
	$dept = NULL;
	while(! feof($file))
	  {
	  $data_import[] = fgetcsv($file,1000,$seperator);
	  }
	if(!empty($data_import)){
		unset($data_import[0]);
	}
	mysql_query("DROP TABLE IF EXISTS peserta_".$project."");
	mysql_query("
		CREATE TABLE peserta_".$project." (
			id_peserta INT PRIMARY KEY AUTO_INCREMENT,
			fielda VARCHAR(255),
			fieldb VARCHAR(255),
			fieldc VARCHAR(255),
			status INT
		)
	");
	
	foreach($data_import as $index_import => $value_import){
		
		if($value_import[0]!=''){
			//print_r($value_import);
			for($i = 0; $i < $value_import[5]; $i++){
				$fielda = $value_import[2];
				$fieldb = $value_import[3];
				$fieldc = $value_import[1];
				$insert = "insert into peserta_".$project."(fielda,fieldb,fieldc, status) values ('".$fielda."','".$fieldb."','".$fieldc."','0') ";
				
				if(mysql_query($insert)){
					$data_hasil['berhasil'][] = $value_import;
				}else{
					$data_hasil['gagal'][] = mysql_error();
				}
			}
			
		}
	}
	fclose($file);
	
	unlink('./file/import/'.$new_name_file);
	return $data_hasil;
}

/* function import_csv($seperator, $new_name_file,$project){
	$file = fopen('./file/import/'.$new_name_file,"r");
	$data_import = array();
	$data_hasil = array();
	$data_hasil['berhasil'] = NULL;
	$data_hasil['gagal'] = NULL;
	$dept = NULL;
	while(! feof($file))
	  {
	  $data_import[] = fgetcsv($file,1000,$seperator);
	  }
	if(!empty($data_import)){
		unset($data_import[0]);
	}
	foreach($data_import as $index_import => $value_import){
		if($value_import[0]!=''){
			if(mysql_query("insert into peserta_".$project."(id_peserta,fielda,fieldb,fieldc,status) values ('".$value_import[0]."','".$value_import[1]."','".$value_import[2]."','".$value_import[3]."','0') ")){
				$data_hasil['berhasil'][] = $value_import;
			}else{
				$data_hasil['gagal'][] = $value_import.mysql_error();
			}
		}
	}
	fclose($file);
	
	unlink('./file/import/'.$new_name_file);
	return $data_hasil;
} */
?>
