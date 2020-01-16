<?php
	switch($_SESSION['undian_login']->name_roles){
		case 'anonim':
			$loader['konten'] = './page/main/home.php';
			$loader['title'] = 'Home';
		break;

		case 'user':
			$loader['konten'] = './page/user/home.php';
			$loader['title'] = 'Home';
		break;

		case 'administrator':
			$loader['konten'] = './page/administrator/home.php';
			$loader['title'] = 'Home';
		break;
		
		default:
			$loader['konten'] = './page/home.php';
			$loader['title'] = 'Home';
			break;
	}
	//--Cek Session--
    require_once './includes/database.php';
    require_once './includes/loader.php';
?>