<?php
if ($path[0] != 'export') {

?>
<!DOCTYPE html>
<!-- saved from url=(0052)http://microprism.html.themeforest.designsentry.com/ -->
<html lang="en"><!--<![endif]-->
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Template</title>
    <link rel="stylesheet" href="<?php echo url('themes/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo url('themes/css/normalize.css')?>">
    <link rel="stylesheet" href="<?php echo url('themes/css/base.css')?>">
    <link rel="stylesheet" href="<?php echo url('themes/css/hr.css')?>">
    <style type="text/css">
      html,body{
        background: #DBDBDB;
      }
      .layout-top {
      padding: 10px 0;
      margin-top: 150px;
    }
      .layout-bottom {
      padding: 10px 0;
    }
    .title{
      margin: 0 auto;
      font-size: 20px;
      color: #000;
      text-align: center;
    }
    .layout {
      background: #DA251C;
      padding: 0 0 10px 0;
      width: 500px;
      margin: auto;
      border-radius: 15px;
      -webkit-box-shadow: 0 0 200px rgba(255, 255, 255, 0.5), 0 1px 2px rgba(0, 0, 0, 0.3);
      box-shadow: 0 0 200px rgba(255, 255, 255, 0.5), 0 1px 2px rgba(0, 0, 0, 0.3);
    }
    .login-container {
      margin: 0 auto 0 auto;
      width: 500px;
      height: 180px;
    }
    .container-fluid{
      padding: 0;
    }
    .login-logo {
      float: left;
      width: 200px;
      height: 180px;
    }
    .login-form {
      float: left;
      width: 300px;
      height: 180px;
    }
    .title-form{
      font-size: 15px;
      color: #FFF;
    }
    .form-control{
      padding: 0 10px;
      height: 35px;
      background-color: #FFF;
      color: #000;
      width: 250px;
    }
    .btn-primary{
      background-color: #FFF;
      color: #000;
    }
    </style>
</head>
<body>
  <?php
  empty($_POST['username']) ? $username = '' : $username = $_POST['username'];
  empty($_POST['password']) ? $password = '' : $password = $_POST['password'];
  $message = NULL;
  if(isset($_POST['login'])){
    if(empty($username) || empty($password)){
      $message = "Wajib diisi semuanya!";
    }else{
      $pass = md5($password);
      $q_check = mysql_query("select * from tbl_user u inner join tbl_roles r on u.id_roles = r.id_roles where username = '$username' and password = '$pass' and block = '0'");
      $check = mysql_fetch_object($q_check);
      if(empty($check)){
        $message = "Username atau Password salah!".mysql_error();
      }else{
        unset($_SESSION['undian_login']);
        $_SESSION['undian_login'] = $check;
        $message = 'Berhasil!';
        echo redirect('home');
      }
    }
  }
  ?>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="layout-top">
          <div class="layout">
               <div class="title" style="background: #B5B5B5;border-radius: 10px; padding:10px 0">
                    <img src="<?php echo url('themes/image/login-header.png')?>">
              </div>
              <div class="login-container">
                  <div class="login-logo"><img src="<?php echo url('themes/image/telkomsel.png')?>" style="margin-top:35px;"></div>
                  <div class="login-form">
                      <form method="post">
                          <table style="border:none; margin-left:10px">
                              <tbody>
                              <tr>
                                  <td style="text-align:center; color:#FFF; font-size:15px;font-weight:bold"><?php echo $message?></td>
                              </tr>
                              <tr>
                                  <td style="text-align:center; color:#FFF; font-size:15px;font-weight:bold"></td>
                              </tr>
                              <tr>
                                  <td class="align-right title-form">Username</td>
                              </tr>
                              <tr>
                                  <td><input type="text" name="username" value="<?php echo $username?>" class="form-control"></td>
                              </tr>
                              <tr>
                                  <td class="align-right title-form">Password</td>
                              </tr>
                              <tr>
                                  <td><input type="password" name="password" value="" class="form-control"></td>
                              </tr>
                              <tr>
                                  <td style="height:20px"></td>
                              </tr>
                              <tr>
                                  <td class="align-right"><input type="submit" name="login" value="Login" class="btn btn-primary"></td>
                              </tr>
                          </tbody></table>
                      </form>
                  </div>
              </div>
          </div>
        <div class="layout-bottom">
          <div class="title" style="font-size:15px">
                @Copyright IT Support Jabar
              </div>
          </div>
      </div>
    </div>
  </div>
</body>
</html>
<?php
}
?>