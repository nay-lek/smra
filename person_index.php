<?php
        
        session_start();
        include("conn/conn.php");
        include("libs/function.php");
        include("main.php");
?>


                <div id="page-wrapper">
                <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                       <ol class="breadcrumb">
                             <!--<li class="active"><a href="index.php">หน้าแรก</a></li>-->
                            <li class="active">แสดงข้อมูล PERSON </li>
                        </ol> 
                    </div>

                </div>

                <div class="row">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Person</div>
                                    <div class="panel-body">
                                        <div class="col-md-9"> 
                                            <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #FF00FF;" >
                                                 <div class="list-group">
                                                    <?=get_rows_person_Error_detail();?>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                            </div>
                    </div>
                    
                </div>

<?php include "footer.php"; ?>