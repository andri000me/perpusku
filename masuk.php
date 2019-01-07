<?php
session_start();
/*
File: masuk.php
Fungsi: Form untuk login.
Auth: ShowCheap
*/
if(file_exists("upgrade/index.php")){
    header('location: upgrade/index.php');
    exit(0);
}
require 'sistem/config.php';
$pencet=$_POST['tmbl'];
sambung();
if(isset($_SESSION['level'])){
   $sesi=$_SESSION['level'];    
    if(($sesi=='Admin' || $sesi=='Pustakawan')){
        header('location: index.php');
    }
}
$nama=mysql_real_escape_string($_POST['nama']);
$kunci=md5($_POST['kunci']);

?>
<html>
<head>
<title>Login | Library</title>

<link href="./tampilan/bootstrap/css/login.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
<script src='./tampilan/jq.js' type='text/javascript'></script>
<script type='text/javascript'>
    $(document).ready(function(){
        $('#user').focus();
    })
</script>
<script type='text/javascript'>
    $(document).ready(function(){
       
            $.ajax({
                url:'run.php',
                success: function(data){
                    //$("#res").html(data);
                    
                }
            })
       
      });    
</script>
<style>
.login {
    width: 240px;
    margin: 10% auto;
    background-color: white;
    border: 1px solid #999;
    border: 1px solid rgba(0, 0, 0, 0.3);
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    border-radius: 6px;
    outline: 0;
    -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 3px 7px rgba(0,0,0,0.3);
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    -webkit-background-clip: padding-box;
    -moz-background-clip: padding-box;
    background-clip: padding-box;
}
</style>
</head>    
<body>
<?php
if ($pencet != '' && $nama != '' && $kunci != ''){
    $s=mysql_query("SELECT * FROM tbl_pustakawan WHERE user='".$nama."' AND kunci='".$kunci."'");
    $c=mysql_num_rows($s);
    if($c == '1'){
      $t= mysql_fetch_array($s);
      $log=$t['login'];
      $log=$log+1;
      mysql_query("UPDATE tbl_pustakawan SET login='$log' WHERE user='$nama'");
      $_SESSION['nama']=$t['nama'];
      $_SESSION['level']=$t['level'];
      $_SESSION['uid']=$t['id'];
      catat($_SESSION['nama'],"Berhasil Login");
      //header('location: index.php');
      echo "<script>window.location='index.php'</script>";
      exit();
    }else{
        catat($nama,"Gagal Login");
        $script= "<script type='text/javascript'>";
        $script.="$('document').ready(function(){";
        $script.="$('#result').html('<p class=\'alert alert-error\'>Username dan Password tidak cocok !</p>');";
        $script.="})";
        $script.="</script>";
        echo $script;
    }
};
?>
<div class="lg-container">
		<h1>Login - Library</h1>
		<form action="" id="lg-form" method="post">
			
			<div>
				<label for="username">Username:</label>
				<input type="text" name="nama" id="username" placeholder="username"/>
			</div>
			
			<div>
				<label for="password">Password:</label>
				<input type="password" name="kunci" id="password" placeholder="password" />
			</div>
			
			<div>				
                                 <input id="login" type='submit' value='LOGIN' name='tmbl'>
			</div>
			
		</form>
		<div id="message"></div>
	</div>   
</body>    
</html>
