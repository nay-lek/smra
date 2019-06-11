<?php @session_start(); ?>
<?php include "main.php"; ?>
<?php include "libs/function.php";?>
<?php include "conn/conn.php";?>
<?php

         isset($_POST['btn_chk']) ? $btn_chk = $_POST['btn_chk'] : $btn_chk = ''; // แก้ไข การรับข้อมูลที่ Error ตอนแรก
         
?>
                

    <div id="page-wrapper">
        <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">

                        <ol class="breadcrumb">
                            <li class="active">
                                 ข้อมูลประเภทความเสี่ยง
                            </li>
                        </ol> 
                </div>

                <div class="row">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                      เพิ่มข้อมูลความเสี่ยง
                    </button>
                </div>
        </div>
    </div>
<!--    Table  -->
        

            <?php 
                    $sql = "select risk_type_name from risk_type";
                    $query = mysql_query($sql);
                    $rows  = mysql_num_rows($query);
                    //echo $rows; 

            ?>
             <div id="page-wrapper">
                <div class="container-fluid">
                <div class ="row"> 
                    <table class="table table-striped table-hover ">
                      <thead>
                        <tr class="info">                          
                          <th>ลำดับ</th>
                          <th>ประเภทคามเสี่ยง</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>
                <?php   $i = 0 ;                  
                    while($result=mysql_fetch_array($query)){
                            $i = $i+1;
                            $name_type = $result['risk_type_name'] ;
                      ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $name_type;?></td>
                          <td>Column content</td>
                        </tr>
                     
                <?php   } ?>
                    <tr class="warning">
                          <td colspan="3"></td>

                        </tr>
                      </tbody>
                    </table> 
                </div>


<!-- chk_btn   -->
                <?php
                    
                    if($btn_chk=="chk"){
                        //echo $btn_chk;
                        $risk_type_name = $_POST['name_type_risk'];
                        $sql_insert = "insert into risk_type(risk_type_name) values('$risk_type_name');";
                         mysql_query($sql_insert); 
                         header('Location: ' . "regist_type_risk.php");
                         echo "บันทึกข้อมูลเสร็จแล้ว";

                    }

                ?>
                


<!-- Modal  -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">บันทึกประเภทความเสี่ยง</h4>
      </div>
      <div class="modal-body">
                <form class="form-horizontal"  role="form" action="regist_type_risk.php" method="post">
                  <fieldset>
                    <div class="form-group">
                      <label for="input_type_risk" class="col-lg-2 control-label">*ข้อมูล</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="name_type_risk" id="input_type_risk" placeholder="ประเภทความเสี่ยง">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="col-lg-10 col-lg-offset-2">
                            <button type="reset" class="btn btn-default">ล้าง</button>
                           <button type="submit" class="btn btn-primary" name="btn_chk" id="btn_chk" value="chk">บันทึก</button>
                      </div>
                    </div>
                  </fieldset>
      </div>
          <div class="modal-footer">
          </div>
      </form>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>