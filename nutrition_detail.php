<?php
        
        session_start();
        include("conn/conn.php");
        include("libs/function.php");
        include("main.php");
        $_SESSION['err'] = $_GET['err'];
        $vn4digit = $_SESSION['vn4digit'];
        //echo $_SESSION['err'] ;

?>


                <div id="page-wrapper">
                <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                       <ol class="breadcrumb">
                             <!--<li class="active"><a href="index.php">หน้าแรก</a></li>-->
                            <li class="active"><a href="nutrition_index.php?vn=<?=$vn4digit;?>">แสดงข้อมูล NUTRITION   <?php echo get_month_show($vn4digit); ?></a></li>
                            <li class="active">แสดงรายชื่อที่ Error -::- <?=$_SESSION['err'];?>  -::- <?=get_Error_Detail_Name($_SESSION['err']);?></li>
                            
                        </ol> 

                    </div>

                </div>

                <div class="row">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Error CODE -::- <?=$_SESSION['err'];?> -::- <?=get_Error_Detail_Name($_SESSION['err']);?>
                                        <a href="export_xls.php?err=<?=$_SESSION['err'];?>&vn=<?=$vn4digit;?>" class="btn btn-success btn-sm active" role="button"> <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Excel </a>
                                   | <span class="glyphicon glyphicon-play-circle" aria-hidden="true" data-toggle="modal" data-target=".bs-example-modal-lg"></span>
                                </div>
                                    <div class="panel-body">
                                        <div class="col-md-8"> 
                                            <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #FF00FF;" >
                                                 <div class="list-group">
                                                 <?=get_rows_Nutrition_Error_detail_list($_SESSION['err'],$vn4digit,"No");?>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                            </div>
                    </div>
                </div>
<?php include "inc_modal.php"; ?>
<?php include "footer.php"; ?>