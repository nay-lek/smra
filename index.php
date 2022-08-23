<?php
        
        session_start();
        include("conn/conn.php");
        include("libs/function.php");
        include("main.php");
       $selmonth = "";
        if(empty($_POST['selmonth'])){
                $selmonth = date('m');

        } else{
                $selmonth = $_POST['selmonth'];
        } 

        $selyear = "";
        if(empty($_POST['selyear'])){
                $selyear = date('Y');

        } else{
                $selyear = $_POST['selyear'];
        }

        $_SESSION['selyear']  = $selyear ;
        $_SESSION['selmonth']  = $selmonth ;
        $_SESSION['vn4digit'] = get_vn_4digit($selyear,$selmonth);



?>

<script type="text/javascript">

         function myJsFunc() {        
            var x = document.getElementById("btn_acd");
            alert(x);
        }

</script>

                <div id="page-wrapper">
                <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                               โปรแกรมตรวจสอบความสมบูรณ์ของการบันทึกเวชระเบียน <?php echo HOSPITAL_NAME; ?>
                        </h1>
                      <!--  <ol class="breadcrumb">
                            <li class="active">
                                 ข้อมูลความเสี่ยง
                            </li>
                        </ol> -->
                    </div>
                </div>


                <div class="row">
                            <div class="panel panel-primary">
                                <div class="panel-heading">   แฟ้มบริการ   <span class="badge" > ERROR</span> <?php echo get_month_show($_SESSION['vn4digit']); ?></div>
                                 
                                  <form method="POST" action="index.php" class="navbar-form navbar-center" role="form">
                                    <div class="form-group">
                                    <label for="selmonth">เดือน</label>
                                     <select name="selmonth" id="selmonth"  class="form-control" >                                        
                                            <?php 
                                            if($selmonth!=""){ echo "<option value='$selmonth' selected>$selmonth</option>"; }
                                            for($i=1;$i<13;$i++){ echo "<option value='$i'>$i</option>";}  

                                            ?>                                           
                                      </select>
                                      <label for="selyear">ปี</label>
                                      <select name="selyear" id="selyear" class="form-control"> 
                                           <?php
                                              $sql = "select max(year(vstdate)) as YY from ovst ";
                                              $query = mysql_query($sql);
                                              $yy = 0;
                                              while($result=mysql_fetch_array($query)){
                                                $yy  = $result['YY'];           

                                              }
                                            if($selyear!=""){ echo "<option value='$selyear' selected>$selyear</option>"; }
                                            for($i=$yy;$i>2010;$i--){ echo "<option value='$i'>$i</option>";}

                                           ?>
                                      </select>
                                    </div>
                                    <button type="submit" name ="submit" class="btn btn-success">เลือก</button>
                                    </form> 
                            

                                
                                    <div class="panel-body">
                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="accident_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>"  target="_blank"   id="btn_acd" 
                                                          <?php if(get_row_Accident_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    ACCIDENT   : 
                                                                <span class="badge" > <?=get_row_Accident_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div>

                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="diag-opd_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>"  target="_blank"
                                                          <?php if(get_row_Diag_opd_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    DIAG-OPD   : 
                                                                <span class="badge" > <?=get_row_Diag_opd_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div>


                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="dental_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>"  target="_blank"
                                                                <?php if(get_row_Dental_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    DENTAL  : 
                                                                <span class="badge" > <?=get_row_Dental_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div>

                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="drug-opd_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>"  target="_blank"
                                                                <?php if(get_row_Drug_opd_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    DRUG-OPD  : 
                                                                <span class="badge" > <?=get_row_Drug_opd_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div>

                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="admission_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>"  target="_blank"
                                                                <?php if(get_row_Admission_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    ADMISSION  : 
                                                                <span class="badge" > <?=get_row_Admission_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div>

                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="labour_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>"  target="_blank"
                                                                <?php if(get_row_Labour_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    LABOUR (คลอด)  : 
                                                                <span class="badge" > <?=get_row_Labour_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div>


                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="charge-opd_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>"  target="_blank"
                                                                <?php if(get_row_Charge_opd_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    CHARG-OPD  : 
                                                                <span class="badge" > <?=get_row_Charge_opd_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div>


                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="procedure-opd_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>"  target="_blank"
                                                                <?php if(get_row_Procedure_opd_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    PROCEDURE-OPD  : 
                                                                <span class="badge" > <?=get_row_Procedure_opd_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div>



                                        <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="specialpp_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_rows_Special_pp_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              SPECAIL_PP   : 
                                                          <span class="badge" > <?=get_rows_Special_pp_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                        </div> 


                                        <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="functional_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_rows_Functional_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              FUNCTIONAL   : 
                                                          <span class="badge" > <?=get_rows_Functional_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                        </div> 



                                        <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="charge-ipd_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_rows_Charge_ipd_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              CHARGE-IPD   : 
                                                          <span class="badge" > <?=get_rows_Charge_ipd_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                        </div> 



                                        <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="service_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_rows_Service_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              SERVICE   : 
                                                          <span class="badge" > <?=get_rows_Service_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                        </div>


                                    </div>
                            </div>
                    </div>

                <div class="row">
                            <div class="panel panel-primary">
                                <div class="panel-heading">แฟ้มสะสม   <span class="badge" > ERROR</span></div>
                                    <div class="panel-body">
                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="person_index.php"  target="_blank" 
                                                          <?php if(get_row_person_Error_all()==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    PERSON   : 
                                                                <span class="badge" > <?=get_row_person_Error_all();?> </span>
                                                        </a>
                                                 </div> 
                                        </div>

                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="patient_index.php"  target="_blank"
                                                          <?php if(get_row_patient_Error_all()==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                                    PATIENT   : 
                                                                <span class="badge" > <?=get_row_patient_Error_all();?> </span>
                                                        </a>
                                                 </div> 
                                        </div>        


                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="home_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                         <?php if(get_row_Home_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                         
                                                                    HOME   : 
                                                                <span class="badge" > <?=get_row_Home_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div> 

                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="disability_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                         <?php if(get_row_Disability_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                         
                                                                    DISABILITY   : 
                                                                <span class="badge" > <?=get_row_Disability_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div> 



                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="chronic_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                         <?php if(get_rows_Chronic_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                         
                                                                    CHRONIC   : 
                                                                <span class="badge" > <?=get_rows_Chronic_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div> 





                                        <div class="col-md-3"> 
                                                <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                        <a href="address_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                         <?php if(get_rows_Address_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                         
                                                                    ADDRESS   : 
                                                                <span class="badge" > <?=get_rows_Address_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                        </a>
                                                 </div> 
                                        </div> 



                                  </div>

                            </div>
                    </div>
                </div>


                <div class="row">
                      <div class="panel panel-primary">
                        
                          <div class="panel-heading">   แฟ้มบริการกึ่งสะสม  <span class="badge" > ERROR</span></div>
                     
                              <div class="panel-body">
                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="anc_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>"  target="_blank"
                                                   <?php if(get_row_Anc_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                              ANC   : 
                                                          <span class="badge" > <?=get_row_Anc_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div>
   

                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" > 
                                                  <a href="epi_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_row_Epi_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              EPI(วัคซีน)   : 
                                                          <span class="badge" > <?=get_row_Epi_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div>



                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="fp_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_row_Fp_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              FP   : 
                                                          <span class="badge" > <?=get_row_Fp_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div>

                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" > 
                                                  <a href="newborn_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_row_Newborn_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              NEWBRONE(เด็กเกิด)   : 
                                                          <span class="badge" > <?=get_row_Newborn_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div>

                                   <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="newborn_care_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_row_NewbornCare_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              NEWBRONE-CARE   : 
                                                          <span class="badge" > <?=get_row_NewbornCare_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div> 


                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="postnatal_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_row_Postnatal_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              POSTNATAL   : 
                                                          <span class="badge" > <?=get_row_Postnatal_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div>  


                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="prenatal_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_rows_Prenatal_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              PRENATAL   : 
                                                          <span class="badge" > <?=get_rows_Prenatal_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div>  


                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="ncdscreen_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_row_Ncd_screen_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              NCDSCREEN   : 
                                                          <span class="badge" > <?=get_row_Ncd_screen_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div>  



                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="community-service_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_row_Community_Service_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              COMMUNITY-SERVICE   : 
                                                          <span class="badge" > <?=get_row_Community_Service_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div> 



                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="nutrition_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_row_Nutrition_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              NUTRITION   : 
                                                          <span class="badge" > <?=get_row_Nutrition_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div> 




                                  <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="rehab_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_rows_Rehab_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              REHABILITATION   : 
                                                          <span class="badge" > <?=get_rows_Rehab_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div> 



                                 <div class="col-md-3"> 
                                          <div class="bs-callout bs-callout-defult" style="border-bottom: dashed 1px #333;" >
                                                  <a href="death_index.php?vn=<?=get_vn_4digit($selyear,$selmonth);?>" target="_blank"
                                                   <?php if(get_rows_Death_Error_all(get_vn_4digit($selyear,$selmonth))==0){;?>  class="btn btn-success btn-md "<?php }else{ ?> class="btn btn-warning btn-md " <?php } ?>   role="button">
                                                   
                                                              DEATH   : 
                                                          <span class="badge" > <?=get_rows_Death_Error_all(get_vn_4digit($selyear,$selmonth));?> </span>
                                                  </a>
                                           </div> 
                                  </div> 





                              </div>


                        </div>
                    </div>




                </div>

<?php include "footer.php"; ?>