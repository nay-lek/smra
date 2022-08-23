<?php ob_start() ?> 

<?php
include("conn/conn.php");
include("libs/config.php");
include("libs/function.php"); 
$error_code = $_GET['err'];



    switch (substr($error_code,0,2)) {

          case 'CH':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script']." ";
          }
          break;


        case 'FP':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script']." and vn like'$vn4digit%' ";
          }
          break;
        
        case 'AD':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script']." and vn like'$vn4digit%' ";
          }
          break;

        case 'AM':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script']."  like'$vn4digit%' ";
          }
          break;


          case 'DX':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {

             if($error_code=='DX9903' ||$error_code=='DX9910' || $error_code=='DX9911' ){
                $sql1 = $result['sql_script']."  like'$vn4digit%' group by vn ";
             }else{
                $sql1 = $result['sql_script']."  like'$vn4digit%' ";
             }
             
          }
          break;

        case 'AN':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {

              if($error_code=='AN9903'){
                  $sql1 = $result['sql_script']."  like'$vn4digit%' GROUP BY person_anc.person_id ";
                }else{
                $sql1 = $result['sql_script']."  like'$vn4digit%' ";
              }             
          }
  
          break;

          case 'DT':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'] . " and vn like'$vn4digit%'";
          }
          break;



          case 'EP':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'] ;
          }
          break;



          case 'AR':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'] ;
          }
          break;


          case 'DE':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'];
          }
          break;


          case 'DS':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'];
          }
          break;



          case 'DO':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
                $sql1 = $result['sql_script'];
                  if($error_code =='DO9901'){
                    $sql1." and er_regist_oper.vn like'$vn4digit%'";

                  }else{  
                    if($error_code =='DO9902'){
                      $sql1." and er_regist_oper.vn like'$vn4digit%'";
                    
                    }else{

                      if($error_code =='DO9903'){
                        $sql1." and er_regist_oper.vn like'$vn4digit%' group by er_regist_oper.vn";
                      
                      }else{
                          if($error_code =='DO9904'){
                              $sql1." and er_regist_oper.vn like'$vn4digit%'   group by er_regist_oper.vn";
                          
                          }else{

                            $sql1." and opitemrece.vn like'$vn4digit%'";
                          }

                      }
                    
                    }       
                  }
          }
          break;

          case 'CR':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {


              if($error_code=='CR9902'){

                $sql1=  $result['sql_script']." like'$vn4digit%' group by vn";
              }else{
                $sql1 = $result['sql_script'] . " and vn like'$vn4digit%'";
              }
             
          }
          break;

          case 'LB':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {

                  if($error_code=="LB1108"){
                     $sql1 = $result['sql_script']." and person_anc_service.vn like'$vn4digit%'  group by person_anc.person_id   ";
                  }else{
                    if($error_code=="LB9903"){
                        $sql1 = $result['sql_script']." and person_anc_service.vn like'$vn4digit%'  group by person_anc.person_id   ";
                    }else{

                      if($error_code=="LB1107"){
                            $sql1 = $result['sql_script'].'$vn4digit%' ;
                        }else{
                            $sql1 = $result['sql_script']."  and ipt.vn like'$vn4digit%' ";                         
                        }

                      }
                      }
                     }
                 
             
          
          break;


          case 'PX':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script']."   and er_regist_oper.vn like'$vn4digit%' ";
          }
          break;


          case 'NB':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
                  if($error_code=="NB9901"){
                      $sql1 =  $result['sql_script'].get_month_stagement($vn4digit)." group by person_wbc.person_id";


                  }else{ 

                    if( $error_code=="NB9299"){
                          $sql1 = $result['sql_script'] ; 
                    }else{
                         $sql1 = $result['sql_script']."   like'$vn4digit%' ";
                    }                     
                     
                  }  
          }
          break;

          case 'NU':
          $vn4digit = $_GET['vn'];
              $Y_str = '25'.substr($vn4digit,0,2) ;
              $first_day = ($Y_str-543).'-'.substr($vn4digit,2,2).'-'.'01';
              $last_day= get_last_day_of_month($first_day);

                 //-------start 9 month  --------------
                $dst = date_create($first_day);
                date_add($dst, date_interval_create_from_date_string('-9 month'));
                $dst =  date_format($dst, 'Y-m-d');

                $det = date_create($dst);
                date_add($det, date_interval_create_from_date_string('-29 days'));
                $det =  date_format($det, 'Y-m-d');  

                $dst2 = date_create($last_day);
                date_add($dst2, date_interval_create_from_date_string('-9 month'));
                $dst2 =  date_format($dst2, 'Y-m-d'); 

                $det2 = date_create($dst2);
                date_add($det2, date_interval_create_from_date_string('-29 days'));
                $det2 =  date_format($det2, 'Y-m-d');  
                //-------- END 9 Month




                //-------start 18 month  --------------
                $dst18 = date_create($first_day);
                date_add($dst18, date_interval_create_from_date_string('-18 month'));
                $dst18 =  date_format($dst18, 'Y-m-d');

                $det18 = date_create($dst18);
                date_add($det18, date_interval_create_from_date_string('-29 days'));
                $det18 =  date_format($det18, 'Y-m-d');  

                $dst218 = date_create($last_day);
                date_add($dst218, date_interval_create_from_date_string('-18 month'));
                $dst218 =  date_format($dst218, 'Y-m-d'); 

                $det218 = date_create($dst218);
                date_add($det218, date_interval_create_from_date_string('-29 days'));
                $det218 =  date_format($det218, 'Y-m-d');  
                //-------- END 18 Month

                  //-------start 30 month  --------------
                  $dst30 = date_create($first_day);
                  date_add($dst30, date_interval_create_from_date_string('-30 month'));
                  $dst30 =  date_format($dst30, 'Y-m-d');

                  $det30 = date_create($dst30);
                  date_add($det30, date_interval_create_from_date_string('-29 days'));
                  $det30 =  date_format($det30, 'Y-m-d');  

                  $dst230 = date_create($last_day);
                  date_add($dst230, date_interval_create_from_date_string('-30 month'));
                  $dst230 =  date_format($dst230, 'Y-m-d'); 

                  $det230 = date_create($dst230);
                  date_add($det230, date_interval_create_from_date_string('-29 days'));
                  $det230 =  date_format($det230, 'Y-m-d');  
                  //-------- END 30 Month

                  //-------start 42 month  --------------
                  $dst42 = date_create($first_day);
                  date_add($dst42, date_interval_create_from_date_string('-42 month'));
                  $dst42 =  date_format($dst42, 'Y-m-d');

                  $det42 = date_create($dst42);
                  date_add($det42, date_interval_create_from_date_string('-29 days'));
                  $det42 =  date_format($det42, 'Y-m-d');  

                  $dst242 = date_create($last_day);
                  date_add($dst242, date_interval_create_from_date_string('-42 month'));
                  $dst242 =  date_format($dst242, 'Y-m-d'); 

                  $det242 = date_create($dst242);
                  date_add($det242, date_interval_create_from_date_string('-29 days'));
                  $det242 =  date_format($det242, 'Y-m-d');  
                  //-------- END 42 Month

                  //-------start 60 month  --------------
                  $dst60 = date_create($first_day);
                  date_add($dst60, date_interval_create_from_date_string('-60 month'));
                  $dst60 =  date_format($dst60, 'Y-m-d');

                  $det60 = date_create($dst60);
                  date_add($det60, date_interval_create_from_date_string('-29 days'));
                  $det60 =  date_format($det60, 'Y-m-d');  

                  $dst260 = date_create($last_day);
                  date_add($dst260, date_interval_create_from_date_string('-60 month'));
                  $dst260 =  date_format($dst260, 'Y-m-d'); 

                  $det260 = date_create($dst260);
                  date_add($det260, date_interval_create_from_date_string('-29 days'));
                  $det260 =  date_format($det260, 'Y-m-d');  
                  //-------- END 60 Month


           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
                switch ($error_code) {
                  case 'NU9901':
                      $sql1 =  $result['sql_script']." and  birthdate between '$dst' and '$dst2' GROUP BY person.person_id ";
                  break;

                   case 'NU9902':
                     $sql1 =  $result['sql_script']." and  birthdate between '$dst18' and '$dst218' GROUP BY person.person_id ";
                  break;  
                   
                  case 'NU9903':
                     $sql1 =  $result['sql_script']." and  birthdate between '$dst30' and '$dst230' GROUP BY person.person_id ";
                  break;  

                  case 'NU9904':
                     $sql1 =  $result['sql_script']." and  birthdate between '$dst42' and '$dst242' GROUP BY person.person_id ";
                  break; 

                   case 'NU9906':
                     $sql1 =  $result['sql_script']." and  birthdate between '$dst60' and '$dst260' GROUP BY person.person_id ";
                  break;                  

                  case 'NU9299':
                       $sql1 = $sql1 ;
                      break;

                  case 'NU9298':
                       $sql1 = $sql1 ;
                      break;

                  default:
                      $sql1 = $result['sql_script']."   like'$vn4digit%' ";
                  break; 

                  } 
          }

          echo $sql1;
          break;


         case 'NE':
          $vn4digit = $_GET['vn'];
          $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
            if($error_code=="NE9299"){
                $sql1 = $result['sql_script']."   like'$vn4digit%' GROUP BY concat(person_wbc_id,care_number) HAVING  ifnull(count(person.person_id),0) > 1 ";
              }else{
                if($error_code=="NE9290"){
                    $sql1 =  $result['sql_script'].get_month_stagement($vn4digit);
                }else{
                    if($error_code=="NE9901"){
                        $sql1 =  $result['sql_script'].get_month_stagement($vn4digit);
                    }else{   
                        if($error_code=="NE9902"){
                            $sql1 =  $result['sql_script'].get_month_stagement($vn4digit);
                        }else{    

                            if($error_code=="NE9903"){
                                $sql1 =  $result['sql_script'].get_month_stagement($vn4digit);
                            }else{                      
                                $sql1 = $result['sql_script']."   like'$vn4digit%' ";
                            }                      

                        }                   
                      
                    }

                }
               
             }
          }
          break;


          case 'PO':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
            if($error_code=="PO9299"){
                $sql1 = $result['sql_script']."   like'$vn4digit%' GROUP BY concat(person_wbc_id,care_number) HAVING  ifnull(count(person.person_id),0) > 1 ";
              }else{
                if($error_code=="PO9290"){
                    $sql1 =  $result['sql_script'].get_month_stagement($vn4digit);
                }else{
                      if($error_code=="PO9901"){
                          $sql1 =  $result['sql_script'].get_month_stagement($vn4digit);
                        }else{
                          if($error_code=="PO9902"){
                              $sql1 =  $result['sql_script'].get_month_stagement($vn4digit);
                            }else{
                              if($error_code=="PO9903"){
                                $sql1 =  $result['sql_script'].get_month_stagement($vn4digit);
                              }else{
                                if($error_code=="PO9904"){
                                    $sql1 =  $result['sql_script'].get_month_stagement($vn4digit);
                                  }else{
                                    $sql1 = $result['sql_script']."   like'$vn4digit%' ";  
                                }
                              }
                            }                       
                        }
                }
               
             }
          }
          break;



          case 'PE':
          //$vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'];
          }
          break;

          case 'PA':
          //$vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'];
          }
          break;


          case 'NC':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
                      if($error_code=='NC9299'){
                          $sql1 =  $result['sql_script']." like'$vn4digit%'"; 
                      }
                        else{
                          $sql1 =  $result['sql_script'].get_month_stagement($vn4digit); 
                        }
                     
          }
          break;


          case 'HO':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
                      $sql1 =  $result['sql_script']; 
          }
          break;

         case 'CS':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script']."  like'$vn4digit%' ";
          }
          break;


         case 'SP':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {

              if($error_code=='SP9298' ){
                    $sql1 = "select  ovst.vn,ovst.hn,cid,concat(pname,' ',fname,' ',lname) as ptname ,ovst.vstdate as vstdate , ovst.vsttime , pp_special_chk.pp_special_code
                        from ovst
                        left join patient on ovst.hn = patient.hn  
                        INNER JOIN (
                        select  ovst.hn,ovst.vstdate,group_concat(distinct(pp_special.vn)) as vn_chk , count(distinct(pp_special.vn)) as CC ,pp_special_type.pp_special_code 
                        from pp_special
                        LEFT JOIN pp_special_type on pp_special.pp_special_type_id = pp_special_type.pp_special_type_id
                        inner join ovst on  pp_special.vn = ovst.vn
                        where pp_special.vn like'$vn4digit%'
                        group by ovst.hn,ovst.vstdate
                        having  count(*)  <> count(distinct(pp_special.pp_special_type_id))  and count(distinct(pp_special.vn)) > 1 ) pp_special_chk on ovst.hn = pp_special_chk.hn 
                        where  pp_special_chk.vstdate = ovst.vstdate  and ovst.vn like'$vn4digit%'";
              }else{
                   $sql1 = $result['sql_script']."  like'$vn4digit%' ";                
              }

          }
          break;


          case 'FN':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'] . " like'$vn4digit%'";
          }
          break;



          case 'RT':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'] . " like'$vn4digit%'   GROUP BY ovst.vn";
          }
          break;


          case 'CI':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {

                $sql1 = $result['sql_script'] . "  like'$vn4digit%'";

             
          }
          break;



          case 'SE':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'] . " like'$vn4digit%' ";
          }
          break;



          case 'PR':
          $vn4digit = $_GET['vn'];
           $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
          $query1 =  mysql_query($sql);      
          while ($result=mysql_fetch_array($query1)) {
             $sql1 = $result['sql_script'] . " between ".get_month_stagement($vn4digit);
          }
          break;


        default:
              $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
              $query1 =  mysql_query($sql);      
              while ($result=mysql_fetch_array($query1)) {
              $sql1 = $result['sql_script'];
              }
          break;
      }



$query = mysql_query($sql1) or die(mysql_error());
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".HOSPITAL_NAME.'_'.$error_code.".xls");#ชื่อไฟล์

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"

xmlns:x="urn:schemas-microsoft-com:office:excel"

xmlns="http://www.w3.org/TR/REC-html40">

<HTML>

<HEAD>

<meta http-equiv="Content-type" content="text/html;charset=utf-8" />

</HEAD><BODY>

<TABLE  x:str BORDER="1">



                 <?php         //echo $sql1 . '////'.$error_code;                     

                              switch (substr($error_code,0,2)) {
                                  case 'AD':
                                      echo get_rows_Accident_Error_detail_list($error_code,$vn4digit,"export");  
                                    break;
                                  case 'AM':
                                      echo get_rows_Admission_Error_detail_list($error_code,$vn4digit,"export");  
                                    break;
                                  case 'DX':
                                      echo get_rows_Diag_opd_Error_detail_list($error_code,$vn4digit,"export"); 
                                    break;

                                  case 'DS':
                                      echo get_rows_Disability_Error_detail_list($error_code,$vn4digit,"export"); 
                                    break;

                                  case 'FP':
                                      echo get_rows_Fp_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'AN':
                                      echo get_rows_Anc_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'DT':
                                      echo get_rows_Dental_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'NU':
                                      echo get_rows_Nutrition_Error_detail_list($error_code,$vn4digit,"export");
                                    break;


                                  case 'PX':
                                      echo get_rows_Procedure_opd_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'CR':
                                      echo get_rows_Charge_opd_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'PE':
                                      echo get_rows_person_Error_detail_list($error_code,"export");
                                    break;

                                  case 'PA':
                                      echo get_rows_patient_Error_detail_list($error_code,"export");
                                    break;

                                  case 'LB':
                                      echo get_rows_Labour_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'NB':
                                      echo get_rows_Newborn_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'NU':
                                      echo get_rows_Nutrition_Error_detail_list($error_code,$vn4digit,"export");
                                    break;


                                  case 'NC':
                                      echo get_rows_Ncd_screen_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'CS':
                                      echo get_rows_Community_Service_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'HO':
                                      echo get_rows_Home_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'NE':
                                      echo get_rows_NewbornCare_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'PO':
                                      echo get_rows_Postnatal_Error_detail_list($error_code,$vn4digit,"export");
                                    break;
                                    
                                   case 'DE':
                                      echo get_rows_Death_Error_detail_list($error_code,$vn4digit,"export"); 
                                    break;


                                  case 'EP':
                                      echo get_rows_Epi_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'DO':
                                      echo get_rows_Drug_opd_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'CH':
                                      echo get_rows_Chronic_Error_detail_list($error_code,"export");
                                    break;

                                  case 'AR':
                                      echo get_rows_Address_Error_detail_list($error_code,"export");
                                    break;


                                  case 'SP':
                                      echo get_rows_Special_pp_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'FN':
                                      echo get_rows_Functional_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'CI':
                                      echo get_rows_Charge_ipd_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'RT':
                                      echo get_rows_Rehab_Error_detail_list($error_code,$vn4digit,"export");
                                    break;

                                  case 'SE':
                                      echo get_rows_Service_Error_detail_list($error_code,$vn4digit,"export");
                                    break;


                                  case 'PR':
                                      echo get_rows_Prenatal_Error_detail_list($error_code,$vn4digit,"export");
                                    break;


                                    default: ?>                                      

                                       <tr>
                                          <th>#</th>
                                          <th>PID</th>
                                          <th> ชื่อ - สกุล </th>
                                          <th> CID</th>

                                      </tr>
                                       <?php  
                                        $i = 0 ;
                                        while($result = mysql_fetch_array($query)){
                                          $person_id = $result['person_id'];
                                          $pname  = $result['pname'];
                                          $fname = $result['fname'];
                                          $lname = $result['lname'];
                                          $cid  = $result['cid'];
                                          $ptname = $pname ." ".$fname." ".$lname ;
                                          $i = $i+1;
                                     ?>
                                     <tr>
                                          <td ><?php echo $i; ?></span></td>
                                          <td><?php echo $person_id; ?></span></td>
                                          <td><?php echo $ptname ; ?></td>
                                          <td><?php echo $cid; ?></td>
                                      </tr>
                                    <?php   } 
                                    break;
                                }

                                ?>
  
	</TABLE>
</BODY>

</HTML>
 <?php ob_end_flush() ?> 