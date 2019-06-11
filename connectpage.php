<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

   <!-- <title>SB Admin - Bootstrap Admin Template</title>-->
    <title>::<?php echo "Connect DB"; ?>::</title>
    
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">
    
    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="js/bootstrap.min.js"></script>



</head>

<body>
<?php 
 include_once("modal.php");
 ?>
  <div id="wrapper">
  	<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#"> Version:= 58.10;  ระบบตรวจสอบการเชื่อมต่อฐานข้อมูล!  </a>
		    </div>
	</nav>




	<!--
        <a  href="#" class="btn" role="button" data-toggle="modal" data-target="#connectmodal" >
                     กรุณาเชื่อต่อฐานข้อมูล :|: <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
        </a>  
	-->

 <?php
        @session_start();
        session_destroy();
       if(empty($_GET['id'])){
           $id = "";  
       }else{

           $id = $_GET['id'];  
       }


       if($id=='empty'){
              
                  echo "<div class='row'>                    
                <div class='row' align='center'>
                <div class='alert alert-danger alert-dismissible fade in' role='alert'  >
                   <h4>ระบบของท่านยังไม่มีตาราง <code>(pk_err_code_chk)</code> กรุณา ติดต่อผู้ดูแลระบบของท่าน !</h4> หรือ   <a href='index.php'>พยายามใหม่อีกครั้ง</a>
                    </button>
                </div>
                </div> ";

        }else{


            if($id=='log'){
                     echo "<div class='row'>                    
                            <div class='row' align='center'>
                            <div class='alert alert-danger alert-dismissible fade in' role='alert'  >
                               <h4>ระบบของท่านยังไม่มีตาราง <code>(pklog_sys)</code> กรุณา ติดต่อผู้ดูแลระบบของท่าน !</h4> หรือ   <a href='index.php'>พยายามใหม่อีกครั้ง</a>
                                </button>
                            </div>
                            </div> ";

            }else{

            echo "<div class='row'>                    
                    <div class='row' align='center'>
                    <div class='alert alert-danger alert-dismissible fade in' role='alert'  >
                       <h4>ไม่สามารถเชื่อมต่อฐานข้อมูลได้ กรุณา ติดต่อผู้ดูแลระบบของท่าน !</h4> หรือ   <a href='index.php'>พยายามใหม่อีกครั้ง</a>
                        </button>
                    </div>
                    </div> ";
            }
        }



 include_once("footer.php");

?>