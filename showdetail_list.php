	<?php
	   include("conn/conn.php");
	   include("libs/function.php");
	   $HN =$_GET['hn'];

	   $rows = $_GET['rows'];
	   	$id_ =  $_GET['id'];
		$moo_id =  $_GET['moo'];
	  	 $pt_name= $_GET['pt_name'];
	  ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

   <!-- <title>SB Admin - Bootstrap Admin Template</title>-->
		<title>โรงพยาบาลผาขาว</title>
	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">
    
    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->



</head>

<body>

  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close"   onclick="checkconfirmclosewindow()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			   <h4 class="modal-title" id="myModalLabel">
				 <?php  

							echo " ข้อมูลการแพ้ยาของ   ".$pt_name ;


				 ?>
					  
			   
			   
			   </h4> 
		  </div>
		  <div class="modal-body">	
						<?php 
						
							echo get_drugallergy_detail_list($HN); 
					
						?>
				
		  </div>
		  <div class="modal-footer">
					<button class="btn btn-success" onclick="checkconfirmclosewindow()">Close</button>
			</div>
		</div>
	  </div>





  
  
<script langauge="javascript">
	function checkconfirmclosewindow(){
		if(confirm('Confirm Close Window')==true){
			window.close();
		}
	}
</script>

  
    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

	</body>

</html>