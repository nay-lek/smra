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
                                 ข้อมูลระดับความเสี่ยง
                            </li>
                        </ol> 
                </div>

                <div class="row">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                      เพิ่มระดับความเสี่ยง
                    </button>
                </div>
        </div>
    </div>
<!--    Table  -->
        

            <?php 
                    $sql = "select * from risk_level";
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
                          <th>ระดับความรุนแรง</th>
                          <th>ลักษณะการเกิดอุบัติเหตุ</th>
                          <th>ผลกระทบ</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>
                <?php   $i = 0 ;                  
                    while($result=mysql_fetch_array($query)){
                            $i = $i+1;
                            $name_level = $result['risk_level_name'] ;
                            $detail_level = $result['risk_level_detail'] ;
                            $risk_level_type = $result['risk_level_type'] ;
                      ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $name_level;?></td>
                          <td><?php echo $detail_level;?></td>
                          <td><?php echo $risk_level_type;?></td>
                          <td>Column content</td>
                        </tr>
                     
                <?php   } ?>
                    <tr class="warning">
                          <td colspan="5"></td>

                        </tr>
                      </tbody>
                    </table> 
                </div>


<!-- chk_btn   -->
                <?php
                    
                    if($btn_chk=="chk"){
                        //echo $btn_chk;
                        $risk_level_name = $_POST['name_level_risk'];
                        $textarea_level_detail = $_POST['textarea_level_detail'];
                        $name_level_risk_type = $_POST['name_level_risk_type'];
                        $sql_insert = "insert into risk_level(risk_level_name,risk_level_detail, risk_level_type)
                                       values('$risk_level_name','$textarea_level_detail','$name_level_risk_type');";
                         mysql_query($sql_insert); 
                         header('Location: ' . "regist_level_risk.php");
                        // echo "บันทึกข้อมูลเสร็จแล้ว";
                        echo $sql_insert;

                    }

                ?>
                


<!-- Modal  -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">เพิ่มข้อมูลระดับความเสี่ยง</h4>
      </div>
      <div class="modal-body">
                <form class="form-horizontal"  role="form" action="regist_level_risk.php" method="post">
                  <fieldset>
                    <div class="form-group">
                      <label for="input_level_risk" class="col-lg-2 control-label">*ข้อมูล</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="name_level_risk" id="input_level_risk" placeholder="ระดับ">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="input_level_risk_type" class="col-lg-2 control-label">*ข้อมูล</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="name_level_risk_type" id="input_level_risk_type" placeholder="ลักษณธการเกิดอุบัตืเหตุ">
                      </div>
                    </div>
                    <div class="form-group">
                    <label for="textArea" class="col-lg-2 control-label">ผลกระทบ</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" rows="4" id="textArea" name="textarea_level_detail"></textarea>
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