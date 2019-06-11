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
                                 ข้อมูลหน่วยงาน
                            </li>
                        </ol> 
                </div>

                <div class="row">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                      เพิ่มหน่วยงาน
                    </button>
                </div>
        </div>
    </div>
<!--    Table  -->
        

            <?php 
                    $sql = "select risk_dept_name from risk_dept";
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
                          <th>หน่วยงาน</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>
                <?php   $i = 0 ;                  
                    while($result=mysql_fetch_array($query)){
                            $i = $i+1;
                            $name_dept = $result['risk_dept_name'] ;
                      ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $name_dept;?></td>
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
                        $risk_dept_name = $_POST['name_dept_risk'];
                        $sql_insert = "insert into risk_dept(risk_dept_name) values('$risk_dept_name');";
                         mysql_query($sql_insert); 
                         header('Location: ' . "regist_dept_risk.php");
                         echo "บันทึกข้อมูลเสร็จแล้ว";

                    }

                ?>
                


<!-- Modal  -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">เพิ่มข้อมูลหน่วยงาน</h4>
      </div>
      <div class="modal-body">
                <form class="form-horizontal"  role="form" action="regist_dept_risk.php" method="post">
                  <fieldset>
                    <div class="form-group">
                      <label for="input_dept_risk" class="col-lg-2 control-label">*ข้อมูล</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="name_dept_risk" id="input_dept_risk" placeholder="หน่วยงาน">
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