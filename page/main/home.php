<?php
if($_SESSION['undian_login']->name_roles == 'administrator'){
	include 'page/administrator/home.php';
}elseif($_SESSION['undian_login']->name_roles == 'user'){
	include 'page/user/home.php';
}else{
	include 'page/main/home.php';
}

?>