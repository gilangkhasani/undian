<?php
if(!empty($_GET['q'])){
    switch(strtolower($_GET['q'])){
		//Global
    case b('home'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('user', 'administrator'), './page/main/home.php', 'Home');
		$id = $path[0];
		break;

	//Admin
	case b('master'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('administrator'), './page/administrator/master.php', 'Master');
		$id = $path[0];
		break;
	case b('master/configure'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('administrator'), './page/administrator/configure.php', 'configure');
		$id = $path[0];
		break;
	case b('master/project'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('administrator'), './page/administrator/project.php', 'project');
		$id = $path[0];
		break;
	case b('master/hadiah'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('administrator'), './page/administrator/hadiah.php', 'hadiah');
		$id = $path[0];
		break;
	case b('master/peserta'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('administrator'), './page/administrator/peserta.php', 'peserta');
		$id = $path[0];
		break;

	//User
    case b('undian'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('user', 'administrator'), './page/user/undian/list-undian.php', 'List Undian');
		$id = $path[0];
		break;
    case b('undian/view/*'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('user'), './page/user/undian/undian.php', 'Home');
		$id = $path[0];
		break;
    case b('undian/undi/*'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('user'), './page/user/undian/undian-undi.php', 'Undi Manual');
		$id = $path[0];
		break;
    case b('undian/undi-auto/*'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('user'), './page/user/undian/undian-undi-auto.php', 'Undi Automatis');
		$id = $path[0];
		break;
    case b('list/peserta/*'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('user'), './page/user/list/list-peserta.php', 'Peserta');
		$id = $path[0];
		break;
    case b('list/pemenang/*'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('user'), './page/user/list/list-pemenang.php', 'Pemenang');
		$id = $path[0];
		break;
    case b('export/pemenang/*'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('user'), './page/user/export/export-pemenang.php', 'Home');
		$id = $path[0];
		break;
    case b('logout'):
		$loader = loader($_SESSION['undian_login']->name_roles,array('user','administrator'), './page/main/logout.php', 'Home');
		$id = $path[0];
		break;

    default : 
		$loader = loader($_SESSION['undian_login']->name_roles,array('user', 'administrator'), './page/main/no-page.php', 'No Page');
		$id = $path[0];
        break;
    }
}
?>