<?php 
		session_start();
		include("conn/conn.php");
		include("libs/function.php");
		$pcu_code = $_GET['pcu_code'];


			$sql = "select count(distinct(opd.hn)) as Total  ,
count(distinct(case when pt.chwpart in('42') and pt.amppart in('12') and pt.tmbpart in('03') then  opd.hn else 0 end)) -1  as '11039'  ,
count(distinct(case when pt.chwpart in('42') and pt.amppart in('12') and pt.tmbpart in('01') then  opd.hn else 0 end))-1  as '04770'  ,
count(distinct(case when pt.chwpart in('42') and pt.amppart in('12') and pt.tmbpart in('05') then  opd.hn else 0 end))-1 as '04775' ,
count(distinct(case when pt.chwpart in('42') and pt.amppart in('12') and pt.tmbpart in('02') and  pt.moopart in(6,7,8,10,14)   then  opd.hn else 0 end))-1  as '04772' ,
count(distinct(case when pt.chwpart in('42') and pt.amppart in('12') and pt.tmbpart in('02') and  pt.moopart not in(6,7,8,10,14)   then  opd.hn else 0 end))-1  as '04771' ,
count(distinct(case when pt.chwpart in('42') and pt.amppart in('12') and pt.tmbpart in('04') and  pt.moopart in(2,3,11)   then  opd.hn else 0 end))-1  as '04774'  ,
count(distinct(case when pt.chwpart in('42') and pt.amppart in('12') and pt.tmbpart in('04') and  pt.moopart not in(2,3,11)   then  opd.hn else 0 end))-1  as '04773'  ,
count(distinct(case when pt.chwpart in('42') and pt.amppart  in('12') and pt.tmbpart not in('01','02','03','04','05') then  opd.hn else 0 end))-1 +
 count(distinct(case when pt.chwpart in('42') and pt.amppart not in('12') then  opd.hn else 0 end))-1 +
    count(distinct(case when pt.chwpart not in('42')  then  opd.hn else 0 end))-1 +
        count(distinct(case when pt.chwpart is null then  opd.hn else 0 end))-1  as 'Other'
from opd_allergy opd
left join patient pt on opd.hn  = pt.hn
where " ;
			//echo $sql;			
			$query = mysql_query($sql);
			$rows  = mysql_num_rows($query);
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
		<div id="page-wrapper">

                <div class="row">
                        <h1 class="page-header">&nbsp;&nbsp;&nbsp;&nbsp; ทะเบียนผู้แพ้ยา โรงพยาบาลผาขาว อ. ผาขาว จ. เลย</h1>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
							
							<table class="table table-bordered table-hover">
                                <thead>
									<tr>
										<th>ทั้งหมด</th>
                                        <th>PCU รพ.ผาขาว</th>
                                        <th>รพ.สต สมศักดิ์พัฒนา</th>
										<th>รพ.สต นาตาด</th>
                                        <th>รพ.สต พวยเด้ง</th>
                                        <th>รพ.สต โนนป่าซาง</th>
										<th>รพ.สต ห้วยยาง</th>
										<th>รพ.สต เพิ่มสุข</th>
										<th>นอกเขต</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php  while($result=mysql_fetch_array($query)){ 
									$total  = $result['Total'];
									$_11039 =  $result['11039'];
									$_04770 =  $result['04770'];
									$_04771  =  $result['04771'];
									$_04772 = $result['04772'];
									$_04773  = $result['04773'];
									$_04774  = $result['04774'];
									$_04775  = $result['04775'];
									$_other  = $result['Other'];
                                   echo  "<tr>
											<td>$total</td>
											<td>$_11039</td>
											<td>$_04770</td>
											<td>$_04771</td>
											<td>$_04772</td>
											<td>$_04773</td> 
											<td>$_04774</td> 
											<td>$_04775</td> 
											<td>$_other</td> 
                                         </tr>";
						         } ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

		</div>
		<!-- /wrapper -->












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
