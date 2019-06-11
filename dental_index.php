<?php
        
        session_start();
        include("conn/conn.php");
        include("libs/function.php");
        include("main.php");
        if(empty($_GET['vn'])){

            $vn4digit = $_SESSION['vn4digit'];
        
        }else{

            $vn4digit = $_GET['vn'];

         }
?>


                <div id="page-wrapper">
                <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                       <ol class="breadcrumb">
                             <!--<li class="active"><a href="index.php">หน้าแรก</a></li>-->
                            <li class="active">แสดงข้อมูล Dental <?php echo get_month_show($vn4digit); ?></li>
                        </ol> 
                    </div>

                </div>

                <div class="row">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Dental</div>
                                    <div class="panel-body">
                                        <div class="col-md-8"> 
                                            <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #FF00FF;" >
                                                 <div class="list-group">
                                                    <?=get_rows_Dental_Error_detail($vn4digit);?>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                            </div>
                    </div>
                </div>

<?php include "footer.php"; ?>