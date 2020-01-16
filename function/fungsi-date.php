<?php
function date_usia($tgl_lahir){
	$hitunghari['awal'] = $tgl_lahir;
	$hitunghari['akhir'] = date('Y-m-d');
	$lahir=$hitunghari['awal'];
	$selisih = time() - strtotime($lahir);
	$tahun = floor ($selisih / 31536000);
	$bulan = floor (($selisih % 31536000) / 2592000);
	foreach ($hitunghari as $key => $val)
	{
	$hitunghari[$key] = strtotime ($val);
	}
	$hitunghari['selisih'] = $hitunghari['akhir'] - $hitunghari['awal'];
	$hitunghari['selisih'] = number_format ($hitunghari['selisih'] / 86400, 0) . ' hr';
	return $tahun.' Th '.$bulan.' Bln';
}


function date_list_month(){
	$list_array = array('01' => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
	return $list_array;
}
?>