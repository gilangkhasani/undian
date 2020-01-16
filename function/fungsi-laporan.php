<?php
function laporan_kkpp_rt($years_month, $session){
	$q_laporan = mysql_query("
							(SELECT 'penduduk-awal' as title, tbl_warga.rt , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE 
							tbl_warga.rw = '$session->id_rw' AND kwn.name_kwn = 'WNI' AND
							(
								(	
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-01' AND tbl_warga.tgl_datang = '0000-00-00') 
											OR 
											(tbl_warga.tgl_lahir < '".$years_month."-01' AND tbl_warga.tgl_datang  < '".$years_month."-01')
										)
										AND
										(
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah >= '".$years_month."-01' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati >= '".$years_month."-01')
											OR
											(tbl_warga.tgl_pindah >= '".$years_month."-01' AND tbl_warga.tgl_mati > '".$years_month."-01')
										)
									) 
									OR 
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-01' AND tbl_warga.tgl_datang = '0000-00-00')
										)
										AND
										(
											(tbl_warga.tgl_pindah >= '".$years_month."-01' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati >= '".$years_month."-01')
											OR
											(tbl_warga.tgl_pindah >= '".$years_month."-01' AND tbl_warga.tgl_mati >= '".$years_month."-01')
										)
									) 
								)
							)
							GROUP BY tbl_warga.rt, jk.id_jk
							ORDER BY rt)

							UNION

							(SELECT 'lahir' as title, tbl_warga.rt , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.rw = '$session->id_rw' AND kwn.name_kwn = 'WNI' AND
							(
								(tbl_warga.tgl_lahir BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
								OR 
								(tbl_warga.tgl_lahir BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND tbl_warga.tgl_datang > '".$years_month."-31') 
							)
							GROUP BY tbl_warga.rt, jk.id_jk
							ORDER BY rt)
							
							UNION
							
							(SELECT 'mati' as title, tbl_warga.rt , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.tgl_mati BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND 
							tbl_warga.rw = '$session->id_rw' AND  kwn.name_kwn = 'WNI'
							GROUP BY tbl_warga.rt, jk.id_jk
							ORDER BY rt)
							
							UNION

							(SELECT 'datang' as title, tbl_warga.rt , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.tgl_datang BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND 
							tbl_warga.rw = '$session->id_rw' AND  kwn.name_kwn = 'WNI'
							GROUP BY tbl_warga.rt, jk.id_jk
							ORDER BY rt)

							UNION

							(SELECT 'pindah' as title, tbl_warga.rt , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.tgl_pindah BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND 
							tbl_warga.rw = '$session->id_rw' AND  kwn.name_kwn = 'WNI'
							GROUP BY tbl_warga.rt, jk.id_jk
							ORDER BY rt)


							UNION

							(SELECT 'penduduk-akhir' as title, tbl_warga.rt , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.rw = '$session->id_rw' AND  kwn.name_kwn = 'WNI' AND
							(
								(	
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
											OR 
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang  < '".$years_month."-31')
										)
										AND
										(
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
										)
									) 
									OR 
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00')
										)
										AND
										(
											(tbl_warga.tgl_pindah > '".$years_month."-31' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati > '".$years_month."-31')
										)
									) 
								)
							)
							GROUP BY tbl_warga.rt, jk.id_jk
							ORDER BY rt)

		");
	$data_header_report = array("penduduk-awal", "lahir", "mati", "datang", "pindah", "penduduk-akhir");
	$data_rt = db_query2list("select * from rt where id_rw = '".$_SESSION['undian_login']->id_rw."'");
	$data_report = array();
	foreach ($data_rt as $key_rt => $value_rt) {
		foreach ($data_header_report as $key_header => $value_header) {
			$data_report[$value_rt->name_rt][$value_header]['L'] = 0;
			$data_report[$value_rt->name_rt][$value_header]['P'] = 0;
		}
	}

	while ($row = mysql_fetch_object($q_laporan)) {
		$data_report[$row->rt][$row->title][$row->jk] = $row->JML;
	}

	foreach ($data_report as $key => $value) {
		foreach ($value as $key1 => $value1) {
			$data_report[$key][$key1]['JML'] = $value1['L']+$value1['P'];
		}
	}
	return $data_report;
}

function laporan_kkpp_rw($years_month, $session){
	$q_laporan = mysql_query("
							(SELECT 'penduduk-awal' as title, tbl_warga.rw , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE 
							tbl_warga.rw = '$session->id_rw' AND kwn.name_kwn = 'WNI' AND
							(
								(	
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-01' AND tbl_warga.tgl_datang = '0000-00-00') 
											OR 
											(tbl_warga.tgl_lahir < '".$years_month."-01' AND tbl_warga.tgl_datang  < '".$years_month."-01')
										)
										AND
										(
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah >= '".$years_month."-01' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati >= '".$years_month."-01')
											OR
											(tbl_warga.tgl_pindah >= '".$years_month."-01' AND tbl_warga.tgl_mati > '".$years_month."-01')
										)
									) 
									OR 
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-01' AND tbl_warga.tgl_datang = '0000-00-00')
										)
										AND
										(
											(tbl_warga.tgl_pindah >= '".$years_month."-01' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati >= '".$years_month."-01')
											OR
											(tbl_warga.tgl_pindah >= '".$years_month."-01' AND tbl_warga.tgl_mati >= '".$years_month."-01')
										)
									) 
								)
							)
							GROUP BY tbl_warga.rw, jk.id_jk
							ORDER BY rw)

							UNION

							(SELECT 'lahir' as title, tbl_warga.rw , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.rw = '$session->id_rw' AND kwn.name_kwn = 'WNI' AND
							(
								(tbl_warga.tgl_lahir BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
								OR 
								(tbl_warga.tgl_lahir BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND tbl_warga.tgl_datang > '".$years_month."-31') 
							)
							GROUP BY tbl_warga.rw, jk.id_jk
							ORDER BY rw)
							
							UNION
							
							(SELECT 'mati' as title, tbl_warga.rw , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.tgl_mati BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND 
							tbl_warga.rw = '$session->id_rw' AND  kwn.name_kwn = 'WNI'
							GROUP BY tbl_warga.rw, jk.id_jk
							ORDER BY rw)
							
							UNION

							(SELECT 'datang' as title, tbl_warga.rw , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.tgl_datang BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND 
							tbl_warga.rw = '$session->id_rw' AND  kwn.name_kwn = 'WNI'
							GROUP BY tbl_warga.rw, jk.id_jk
							ORDER BY rw)

							UNION

							(SELECT 'pindah' as title, tbl_warga.rw , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.tgl_pindah BETWEEN '".$years_month."-01' AND '".$years_month."-31' AND 
							tbl_warga.rw = '$session->id_rw' AND  kwn.name_kwn = 'WNI'
							GROUP BY tbl_warga.rw, jk.id_jk
							ORDER BY rw)


							UNION

							(SELECT 'penduduk-akhir' as title, tbl_warga.rw , SUBSTR(jk.name_jk, 1, 1) as jk, count(jk.name_jk) as JML 
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE tbl_warga.rw = '$session->id_rw' AND  kwn.name_kwn = 'WNI' AND
							(
								(	
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
											OR 
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang  < '".$years_month."-31')
										)
										AND
										(
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
										)
									) 
									OR 
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00')
										)
										AND
										(
											(tbl_warga.tgl_pindah > '".$years_month."-31' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati > '".$years_month."-31')
										)
									) 
								)
							)
							GROUP BY tbl_warga.rw, jk.id_jk
							ORDER BY rw)

		");
	$data_header_report = array("penduduk-awal", "lahir", "mati", "datang", "pindah", "penduduk-akhir");
	$data_rw = db_query2list("select * from rw where id_rw = '".$_SESSION['undian_login']->id_rw."'");
	$data_report = array();
	foreach ($data_rw as $key_rw => $value_rw) {
		foreach ($data_header_report as $key_header => $value_header) {
			$data_report[$value_rw->name_rw][$value_header]['L'] = 0;
			$data_report[$value_rw->name_rw][$value_header]['P'] = 0;
		}
	}

	while ($row = mysql_fetch_object($q_laporan)) {
		$data_report[$row->rw][$row->title][$row->jk] = $row->JML;
	}

	foreach ($data_report as $key => $value) {
		foreach ($value as $key1 => $value1) {
			$data_report[$key][$key1]['JML'] = $value1['L']+$value1['P'];
		}
	}
	return $data_report;
}


function laporan_pp($years_month, $session){
	// $years_month = date("Y-m");
	$query = "(SELECT 'pekerjaan' as title, pekerjaan.id_pekerjaan as id_kat, pekerjaan.name_pekerjaan as name_kat, kwn.id_kwn, kwn.name_alias_kwn, jk.id_jk, SUBSTR(jk.name_jk, 1, 1) as jk, COUNT(tbl_warga.jk) as JML
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							INNER JOIN pekerjaan on tbl_warga.pekerjaan = pekerjaan.id_pekerjaan
							WHERE 
							tbl_warga.rw = '".$_SESSION['undian_login']->id_rw."' AND
							(
								(	
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
											OR 
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang  < '".$years_month."-31')
										)
										AND
										(
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
										)
									) 
									OR 
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00')
										)
										AND
										(
											(tbl_warga.tgl_pindah > '".$years_month."-31' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati > '".$years_month."-31')
										)
									) 
								)
							)
							GROUP BY tbl_warga.pekerjaan, tbl_warga.kewarganegaraan, tbl_warga.jk
							ORDER BY pekerjaan.name_pekerjaan)

							UNION

							(SELECT 'pendidikan' as title, pendidikan.id_pendidikan as id_kat, pendidikan.name_pendidikan as name_kat, kwn.id_kwn, kwn.name_alias_kwn, jk.id_jk, SUBSTR(jk.name_jk, 1, 1) as jk, COUNT(tbl_warga.jk) as JML
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							INNER JOIN pendidikan on tbl_warga.pendidikan = pendidikan.id_pendidikan
							WHERE 
							tbl_warga.rw = '".$_SESSION['undian_login']->id_rw."' AND
							(
								(	
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
											OR 
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang  < '".$years_month."-31')
										)
										AND
										(
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
										)
									) 
									OR 
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00')
										)
										AND
										(
											(tbl_warga.tgl_pindah > '".$years_month."-31' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati > '".$years_month."-31')
										)
									) 
								)
							)
							GROUP BY tbl_warga.pendidikan, tbl_warga.kewarganegaraan, tbl_warga.jk
							ORDER BY pendidikan.id_pendidikan)";
	$q_laporan = mysql_query($query);
	$data_report = array();
	$kat = array();
	$q_pekerjaan = mysql_query("select name_pekerjaan from pekerjaan");
	while ($r_pekerjaan = mysql_fetch_object($q_pekerjaan)) {
		$kat['pekerjaan'][$r_pekerjaan->name_pekerjaan] = array();
	}
	$q_pendidikan = mysql_query("select name_pendidikan from pendidikan");
	while ($r_pendidikan = mysql_fetch_object($q_pendidikan)) {
		$kat['pendidikan'][$r_pendidikan->name_pendidikan] = array();
	}
	$kwn = db_query2list("select name_alias_kwn from kwn");
	$jk = db_query2list("select SUBSTR(jk.name_jk, 1, 1) as jk from jk");

	foreach ($kat as $key_kat => $value_kat) {
		foreach ($value_kat as $key_kat1 => $value_kat1) {
			foreach ($kwn as $key_kwn => $value_kwn) {
				foreach ($jk as $key_jk => $value_jk) {
					$data_report[$key_kat][$key_kat1][$value_kwn->name_alias_kwn][$value_jk->jk] = 0;
				}
			}
		}
	}
	while ($row = mysql_fetch_object($q_laporan)) {
		$data_report[$row->title][$row->name_kat][$row->name_alias_kwn][$row->jk] = $row->JML;
	}
	$header = array();
	$index = 1;
	foreach ($data_report as $key => $value) {
		foreach ($value as $key_kat => $value_kat) {
			$data_report[$key][$key_kat]['JUMLAH']['L'] = 0;
			$data_report[$key][$key_kat]['JUMLAH']['P'] = 0;
			$data_report[$key][$key_kat]['JUMLAH']['JML'] = 0;
			foreach ($value_kat as $key_kwn => $value_kwn) {
				if($index <= 3) $header[] = $key_kwn;
				$index ++;
				$data_report[$key][$key_kat][$key_kwn]['JML'] = $data_report[$key][$key_kat][$key_kwn]['L'] + $data_report[$key][$key_kat][$key_kwn]['P'];
				$data_report[$key][$key_kat]['JUMLAH']['L'] += $data_report[$key][$key_kat][$key_kwn]['L'];
				$data_report[$key][$key_kat]['JUMLAH']['P'] += $data_report[$key][$key_kat][$key_kwn]['P'];
				$data_report[$key][$key_kat]['JUMLAH']['JML'] +=  $data_report[$key][$key_kat][$key_kwn]['L'];
				$data_report[$key][$key_kat]['JUMLAH']['JML'] +=  $data_report[$key][$key_kat][$key_kwn]['P'];
			}
		}
	}
	$output['data'] = $data_report;
	$output['header'] = $header;
	return $output;
}

function laporan_sum($years_month, $session){
	$currdate = $years_month."-28";
	$sql = "	SELECT 	IF(tbl.usia >=1 AND tbl.usia <=4, '01 - 04', 
						IF(tbl.usia >=5 AND tbl.usia <=9, '05 - 09', 
						IF(tbl.usia >=10 AND tbl.usia <=14, '10 - 14', 
						IF(tbl.usia >=15 AND tbl.usia <=17, '15 - 17', 
						IF(tbl.usia >=18 AND tbl.usia <=19, '18 - 19', 
						IF(tbl.usia >=20 AND tbl.usia <=24, '20 - 24', 
						IF(tbl.usia >=25 AND tbl.usia <=29, '25 - 29', 
						IF(tbl.usia >=30 AND tbl.usia <=34, '30 - 34', 
						IF(tbl.usia >=35 AND tbl.usia <=39, '35 - 39', 
						IF(tbl.usia >=40 AND tbl.usia <=44, '40 - 44', 
						IF(tbl.usia >=45 AND tbl.usia <=49, '45 - 49', 
						IF(tbl.usia >=50 AND tbl.usia <=54, '50 - 54', 
						IF(tbl.usia >=55 AND tbl.usia <=59, '55 - 59', 
						IF(tbl.usia >=60 AND tbl.usia <=64, '60 - 64', 
						IF(tbl.usia >=65, '65 Keatas', 'unknown'
						))))))))))))))) as umur,
				tbl.usia,
				tbl.id_kwn,
				tbl.name_kwn,
				tbl.id_jk,
				tbl.jk,
				1 as jumlah
				FROM
				(SELECT 
				TIMESTAMPDIFF(YEAR,tgl_lahir, '$currdate') AS usia, kwn.id_kwn, kwn.name_kwn, jk.id_jk, SUBSTR(jk.name_jk, 1, 1) as jk
				FROM 
				tbl_warga 
				INNER JOIN jk on tbl_warga.jk = jk.id_jk
				INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
				WHERE 
				tbl_warga.rw = '$session->id_rw' AND
				(
					(	
						(
							(
								(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
								OR 
								(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang  < '".$years_month."-31')
							)
							AND
							(
								(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
							)
						) 
						OR 
						(
							(
								(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00')
							)
							AND
							(
								(tbl_warga.tgl_pindah > '".$years_month."-31' AND tbl_warga.tgl_mati = '0000-00-00')
								OR
								(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati > '".$years_month."-31')
							)
						) 
					)
				)
				ORDER BY usia) as tbl
				WHERE tbl.usia >=1";
	$query = mysql_query($sql);
	$kat_report = array('01 - 04', '05 - 09', '10 - 14', '15 - 17', '18 - 19', '20 - 24', '25 - 29', '30 - 34', '35 - 39', '40 - 44', '45 - 49', '50 - 54', '55 - 59', '60 - 64', '65 Keatas');
	$kwn = db_query2list("select name_kwn from kwn GROUP BY name_kwn ORDER BY name_kwn DESC");
	$tambah_kwn = new stdClass();
	$tambah_kwn->name_kwn = 'JUMLAH';
	$kwn[] = $tambah_kwn;
	$jk = array("L", "P", "JML");
	$data_report = array();
	foreach ($kat_report as $key => $value) {
		foreach ($kwn as $key_kwn => $value_kwn) {
			foreach ($jk as $key_jk => $value_jk) {
				$data_report[$value][$value_kwn->name_kwn][$value_jk] = 0;
			}
		}
	}
	while ($row = mysql_fetch_object($query)) {
		$data_report[$row->umur][$row->name_kwn][$row->jk] += $row->jumlah;
	}
	foreach ($data_report as $key => $value) {
		foreach ($value as $key1 => $value1) {
			$data_report[$key][$key1]['JML'] = $data_report[$key][$key1]['L'] + $data_report[$key][$key1]['P'];
			if($key1 != 'JUMLAH'){
				$data_report[$key]['JUMLAH']['L'] += $data_report[$key][$key1]['L'];
				$data_report[$key]['JUMLAH']['P'] += $data_report[$key][$key1]['P'];
				$data_report[$key]['JUMLAH']['JML'] += $data_report[$key][$key1]['JML'];
			}
		}
	}
	$output['data'] = $data_report;
	$output['header'] = $kwn;
	return $output;
}


function laporan_ga($years_month, $session){
	$sql = "
				(SELECT 'JUMLAH UMPI' as title, kwn.name_alias_kwn as subtitle, COUNT(tbl_warga.jk) as JML
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							INNER JOIN kwn on tbl_warga.kewarganegaraan = kwn.id_kwn
							WHERE 
							tbl_warga.rw = '$session->id_rw' AND
							(
								(	
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
											OR 
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang  < '".$years_month."-31')
										)
										AND
										(
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
										)
									) 
									OR 
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00')
										)
										AND
										(
											(tbl_warga.tgl_pindah > '".$years_month."-31' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati > '".$years_month."-31')
										)
									) 
								)
							)
							GROUP BY tbl_warga.kewarganegaraan
							ORDER BY kwn.name_alias_kwn)
				UNION
				(SELECT 'JUMLAH PENDUDUK' as title,  SUBSTR(jk.name_jk, 1, 1) as jk, COUNT(tbl_warga.jk) as JML
							FROM 
							tbl_warga 
							INNER JOIN jk on tbl_warga.jk = jk.id_jk
							WHERE 
							tbl_warga.rw = '$session->id_rw' AND
							(
								(	
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
											OR 
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang  < '".$years_month."-31')
										)
										AND
										(
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
										)
									) 
									OR 
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00')
										)
										AND
										(
											(tbl_warga.tgl_pindah > '".$years_month."-31' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati > '".$years_month."-31')
										)
									) 
								)
							)
							GROUP BY tbl_warga.jk
							ORDER BY jk)
				UNION
				(SELECT 'JUMLAH MENURUT GOLONGAN AGAMA' as title,  agama.name_agama, COUNT(tbl_warga.jk) as JML
							FROM 
							tbl_warga 
							INNER JOIN agama on tbl_warga.agama = agama.id_agama
							WHERE 
							tbl_warga.rw = '1' AND 
							(
								(	
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00') 
											OR 
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang  < '".$years_month."-31')
										)
										AND
										(
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati = '0000-00-00')
										)
									) 
									OR 
									(
										(
											(tbl_warga.tgl_lahir < '".$years_month."-31' AND tbl_warga.tgl_datang = '0000-00-00')
										)
										AND
										(
											(tbl_warga.tgl_pindah > '".$years_month."-31' AND tbl_warga.tgl_mati = '0000-00-00')
											OR
											(tbl_warga.tgl_pindah = '0000-00-00' AND tbl_warga.tgl_mati > '".$years_month."-31')
										)
									) 
								)
							)
							GROUP BY tbl_warga.agama
							ORDER BY jk)
	";
	$query = mysql_query($sql);

	/*DEFINED*/
	$data_rt = db_query("select count(*) as jumlah FROM rt where id_rw = '$session->id_rw'");
	$data_rw = db_query("select count(*) as jumlah FROM rw where id_rw = '$session->id_rw'");
	$data_report['JUMLAH']['RT'] = $data_rt->jumlah;
	$data_report['JUMLAH']['RW'] = $data_rw->jumlah;
	$kwn = db_query2list("select name_alias_kwn from kwn ORDER BY name_alias_kwn DESC");
	foreach ($kwn as $key => $value) {
		$data_report['JUMLAH UMPI'][$value->name_alias_kwn] = 0;
	}
		$data_report['JUMLAH UMPI']['JUMLAH'] = 0;

	$jk = array("L", "P");
	foreach ($jk as $key => $value) {
		$data_report['JUMLAH PENDUDUK'][$value] = 0;
	}
	$data_report['JUMLAH PENDUDUK']['JUMLAH'] = 0;

	$kwn = db_query2list("select name_agama from agama");
	foreach ($kwn as $key => $value) {
		$data_report['JUMLAH MENURUT GOLONGAN AGAMA'][$value->name_agama] = 0;
	}
	$data_report['JUMLAH MENURUT GOLONGAN AGAMA']['JUMLAH'] = 0;

	while ($row = mysql_fetch_object($query)) {
		$data_report[$row->title][$row->subtitle] = $row->JML;
	}

	foreach ($data_report as $key => $value) {
		if($key != 'JUMLAH'){
			foreach ($value as $key1 => $value1) {
				$data_report[$key]['JUMLAH'] += $value1;
			}
		}
	}

	return $data_report;
}
?>