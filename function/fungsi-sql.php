<?php
function db_query($query){
	$q = mysql_query($query);
	$r = mysql_fetch_object($q);
	return $r;
}
function db_query2list($query){
	$q = mysql_query($query);
	$data = array();
	while($r = mysql_fetch_object($q)){
		$data[] = $r;
	}
	return $data;
}
function db_query2list_fieldedit($query, $field, $type = NULL){
	$q = mysql_query($query);
	$data = array();
	if($type == 'array'){
		while($r = mysql_fetch_assoc($q)){
			$data[$r[$field]] = $r;
		}
	}elseif(is_null($type)){
		while($r = mysql_fetch_object($q)){
			$data[$r->$field] = $r;
		}
	}
	return $data;
}
function db_query2arrayindex($query){
	$q = mysql_query($query);
	$data = array();
	$no= 0;
	while($r = mysql_fetch_array($q)){
		$data[] = $r;
		unset($data[$no]['name_roles']);
		unset($data[$no]['id_subdept']);
		$no++;
	}
	return $data;
}
function db_num_rows($query){
	$q = mysql_query($query);
	$output = mysql_num_rows($q);
	return $output;
}
function get_counter_dinamis($type){
	$data = db_query2list("SELECT
							konten.id_konten,
							konten.title_konten,
							count(counter.id_konten) as jumlah
							FROM
							konten
							LEFT Join counter ON counter.id_konten = konten.id_konten
							where konten.type_konten = '$type'
							group by konten.id_konten
							order by jumlah desc
							limit 0,5
							");
	return $data;
}
function get_counter_umum($limit='limit 0,5'){
	$data = db_query2list("SELECT
							konten.id_konten,
							konten.type_konten,
							konten.title_konten,
							count(counter.id_konten) as jumlah
							FROM
							konten
							LEFT Join counter ON counter.id_konten = konten.id_konten
							where konten.type_konten <> 'story' and konten.type_konten <> 'news' and konten.type_konten <> 'expert' and konten.type_konten <> 'event'
							group by konten.id_konten
							order by jumlah desc
							$limit
							");
	return $data;
}
?>