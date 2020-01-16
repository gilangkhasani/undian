<?php
$check_data = db_query("SELECT * FROM project where id_project = '".$path[2]."'");

if(empty($check_data)){
	exit();
}else{
	require './classes/phpexcel/PHPExcel.php';



	$data_field = db_query("select 'No' as no, `field1`, `field2`, `field3`, 'Hadiah' as hadiah, 'Periode' as periode from configure where id_project = '".$path[2]."'");
	$output[] = array();
	$output[0][] = 'List Pemenang "'.$check_data->name_project.'"';
	$output[1][] = $data_field->no;
	if(!empty($data_field->field1)) $output[1][] = $data_field->field1;
	if(!empty($data_field->field2)) $output[1][] = $data_field->field2;
	if(!empty($data_field->field3)) $output[1][] = $data_field->field3;
	$output[1][] = $data_field->hadiah;
	$output[1][] = $data_field->periode;

	echo "SELECT * 
					FROM hadiah 
					INNER JOIN list_pemenang ON list_pemenang.id_hadiah = hadiah.id_hadiah 
					INNER JOIN peserta_".$path[2]." ON peserta_".$path[2].".id_peserta = list_pemenang.id_peserta 
					INNER JOIN project ON project.id_project = hadiah.id_project 
					where hadiah.id_project = '".$path[2]."'";
	$check_project = db_query2list("SELECT * 
					FROM hadiah 
					INNER JOIN list_pemenang ON list_pemenang.id_hadiah = hadiah.id_hadiah 
					INNER JOIN peserta_".$path[2]." ON peserta_".$path[2].".id_peserta = list_pemenang.id_peserta 
					INNER JOIN project ON project.id_project = hadiah.id_project 
					where hadiah.id_project = '".$path[2]."'");
	$no = 2;
	foreach ($check_project as $key => $value) {
		$output[$no][] = $no-1;
		if(!empty($data_field->field1)) $output[$no][] = $value->fielda;
		if(!empty($data_field->field2)) $output[$no][] = $value->fieldb;
		if(!empty($data_field->field3)) $output[$no][] = $value->fieldc;
		$output[$no][] = $value->name_hadiah;
		$output[$no][] = $value->periode;
		$no++;
	}

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("IT Operation Support JABAR")
								 ->setLastModifiedBy("IT Operation Support JABAR")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");
	$objPHPExcel->getActiveSheet()->fromArray($output, null, 'A1');

	$date = date("Y-m-d His");
	$outputFileType = 'Excel5';
	$outputFileName = 'file/download/Undian-'.$date.'.xls';
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $outputFileType);
	$objWriter->save($outputFileName);
	header('Location: ' . url($outputFileName));
	exit();
}
	?>