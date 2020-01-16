<?php
include '../../../includes/database.php';
include '../../../function/fungsi-sql.php';
$output = array();
switch ($_GET['kategori']) {
	case 'manual':
		$query = "SELECT *
					FROM
					hadiah
					INNER JOIN list_pemenang ON list_pemenang.id_hadiah = hadiah.id_hadiah
					INNER JOIN peserta_".$_GET['project']." ON peserta_".$_GET['project'].".id_peserta = list_pemenang.id_peserta
					INNER JOIN project ON project.id_project = hadiah.id_project
					where hadiah.id_project = '".$_GET['project']."'";
		$data_pemenang = db_query2list($query);
		$output['data'] = $data_pemenang;
		$output['jumlah_pemenang'] = count($data_pemenang);

		$list_pemenang = '';
		$list_pemenang .= '<table align="center">';
		$data_field = db_query2list("select 'No' as no, `field1`, `field2`, `field3`, 'Hadiah' as hadiah, 'Periode' as periode from configure where id_project = '".$_GET['project']."'");
		$list_pemenang .=  '<thead>';
		foreach ($data_field as $key => $value) {
			$list_pemenang .=  '<tr>';
			$list_pemenang .=  '<td>'.$value->no.'</td>';
			$list_pemenang .=  '<td>'.$value->field1.'</td>';
			$list_pemenang .=  '<td>'.$value->field2.'</td>';
			$list_pemenang .=  '<td>'.$value->field3.'</td>';
			$list_pemenang .=  '<td>'.$value->hadiah.'</td>';
			$list_pemenang .=  '<td>'.$value->periode.'</td>';
			$list_pemenang .=  '</tr>';
		}
		$list_pemenang .=  '</thead>';
		$no = 1;
		foreach ($data_pemenang as $key => $value) {
			$list_pemenang .=  '<tr>';
			$list_pemenang .=  '<td>'.$no.'</td>';
			$list_pemenang .=  '<td>'.$value->fielda.'</td>';
			$list_pemenang .=  '<td>'.$value->fieldb.'</td>';
			$list_pemenang .=  '<td>'.$value->fieldc.'</td>';
			$list_pemenang .=  '<td>'.$value->name_hadiah.'</td>';
			$list_pemenang .=  '<td>'.$value->periode.'</td>';
			$list_pemenang .=  '</tr>';
			$no++;
		}
		$list_pemenang .= '</table>';
		$output['list_pemenang'] = $list_pemenang;
		break;
	
	case 'list-peserta':
		$query = "SELECT count(*) as jumlah FROM
					(SELECT *
					FROM
					peserta_".$_GET['project']."
					where status = '0'
					group by fielda) as tbl_all";
		$data_peserta = db_query($query);
		$output['jumlah'] = intval($data_peserta->jumlah);

		$q = "select * from peserta_".$_GET['project']." where `status` = '0'";
		$sql = mysql_query($q);
		$data = array();
		$no = 1;
		while ($row = mysql_fetch_assoc($sql)) {
			$data["a".$no] = $row;
			$no++;
		}
		$output['data']=$data;
		break;
	default:
		# code...
		break;
}
echo json_encode($output);
?>