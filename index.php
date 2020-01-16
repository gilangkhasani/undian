<?php 
    // memulai session
    date_default_timezone_set("Asia/Jakarta");
    session_start();
    //empty($_SESSION['rushone-administrator']) ? : $_SESSION['rushone-administrator'] = 'anonim';
    if(empty($_SESSION['undian_login']->name_roles)){
		$user = new stdClass;
        $user->name_roles = 'anonim';
        $user->fullname = 'anonim';
        $user->username = 'anonim';
        $_SESSION['undian_login'] = $user;
    }
    require_once('function/fungsi-path.php');
    require_once('function/fungsi-sql.php');
    require_once('function/fungsi-base.php');
    require_once('function/fungsi-date.php');
    require_once('function/fungsi-laporan.php');
    //mengambil path ke array
    if(!empty($_GET['q'])){
        $path = explode("/",$_GET['q']);
    }else{
        $path[0] = 'home';
    }
    try {
        require_once './includes/session.php';
    }
    catch(Exception $error) {
        print $error->getMessage();
    }
    // unset($_SESSION['undian_login']);
    if($_SESSION['undian_login']->name_roles == 'administrator'){
        require_once('themes/tmp/template-user.php');
    }elseif($_SESSION['undian_login']->name_roles == 'user'){
        require_once('themes/tmp/template-user.php');
    }else{
        require_once('themes/tmp/template-anonim.php');
    }
?>
