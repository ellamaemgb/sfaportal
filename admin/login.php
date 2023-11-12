<?php
require_once("../include/initialize.php");

 ?>
  <?php
 if (isset($_SESSION['ACCOUNT_ID'])){
      redirect(web_root."admin/index.php");
     } 
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>SFA</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="<?php echo web_root; ?>css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>css/jquery.dataTables.css"> 
<link href="<?php echo web_root; ?>css/bootstrap.css" rel="stylesheet" media="screen">

<link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet" media="screen">
<!-- Plugins -->
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.dataTables.js"></script>
<!-- <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/fixnmix.js"></script> / -->


<style>
@CHARSET "UTF-8";
/*
over-ride "Weak" message, show font in dark grey
*/

.progress-bar {
    color: #333;
} 

/*
Reference:
http://www.bootstrapzen.com/item/135/simple-login-form-logo/
*/

* {
    -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  outline: none;
}

    .form-control {
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    @include box-sizing(border-box);

    &:focus {
      z-index: 2;
    }
  }

body {
    background: url(../img/sfas.jpg);
    position: relative;
    background-size: cover;
    background-position: top center;
    height: 100vh;
}

.login-form {
  margin-top: 70px;
 
}

form[role=login] {
  color: #5d5d5d;
  background: white;
  opacity: 90%;
  padding: 26px;
  margin-top: 80px;
  margin-left: -47px;
  height: 468px;
    margin-right: -50px;
  border-radius: 10px;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
}
  form[role=login] img {
    display: block;
    margin: 0 auto;
     margin-bottom: 15px;
   margin-top: -10px;
    
    height: 130px;
  }
  form[role=login] input{
    font-size: 18px;
    margin: 16px 0;
    
  }

  form[role=login] button {
    font-size: 18px;
    margin: 16px 0;
    opacity: 100%;
    margin-top: 40px;
    width: 150px;
   margin-left: 115px;
   background-color: #098744;
  }
  form[role=login] button:hover{
    background-color: white;
    color: black;
  }
  
  form[role=login] > div {
    text-align: center;
  }
  
.form-links {
  text-align: center;
  margin-top: 1em;
  margin-bottom: 50px;
}
  .form-links a {
    color: #fff;
  }
 
</style>
 
<body  >


<div class="container">
  
  <div class="row" id="pwd-container">
    <div class="col-md-4"></div>
    
    <div class="col-md-4">

      <section class="login-form"> <? echo check_message(); ?>;
        <form method="post" action="" role="login">
        
        
           <img src="../assets/img/sfalogo.png" height="25px" class="img-responsive" alt="" />
         
           <h1 style="font-size: 19px;"> Username</h1>
          <input type="input" name="user_email" placeholder="Username" required class="form-control input-lg" value="" />
          <h1 style="font-size: 19px;"> Password</h1>
          <input type="password" name="user_pass" class="form-control input-lg" id="password" placeholder="Password" required  />
          
          
          <div class="pwstrength_viewport_progress"></div>
          
          
          <button type="submit" name="btnLogin" class="btn btn-lg btn-primary btn-block">Sign in</button>
          <!-- <div>
            <a href="#">Create account</a> or <a href="#">reset password</a>
          </div>
           -->
        </form>
        
        <div class="form-links">
          <!-- <a href="#">www.website.com</a> -->
        </div>
      </section>  
      </div>
      
      <div class="col-md-4"></div>
      

  </div>
  
     
  
  
</div>
   
</body>

 <?php 

if(isset($_POST['btnLogin'])){
  $email = trim($_POST['user_email']);
  $upass  = trim($_POST['user_pass']);
  $h_upass = sha1($upass);
  
   if ($email == '' OR $upass == '') {

      message("Invalid Username and Password!", "error");
      redirect("login.php");
         
    } else {  
  //it creates a new objects of member
    $user = new User();
    //make use of the static function, and we passed to parameters
    $res = $user::userAuthentication($email, $h_upass);
    if ($res==true) { 
       message("You logon as ".$_SESSION['ACCOUNT_TYPE'].".","success");
       
       $sql="INSERT INTO `tbllogs` (`USERID`, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
          VALUES (".$_SESSION['ACCOUNT_ID'].",'".date('Y-m-d H:i:s')."','".$_SESSION['ACCOUNT_TYPE']."','Logged in')";
          $mydb->setQuery($sql);
          $mydb->executeQuery();

      if ($_SESSION['ACCOUNT_TYPE']=='Administrator'){ 
         redirect(web_root."admin/index.php");
      }elseif($_SESSION['ACCOUNT_TYPE']=='Registrar'){
          redirect(web_root."admin/index.php");

      }else{
           redirect(web_root."admin/login.php");
      }
    }else{
      message("Account does not exist! Please contact Administrator.", "error");
       redirect(web_root."admin/login.php"); 
    }
 }
 } 
 ?> 
</head>
</html>