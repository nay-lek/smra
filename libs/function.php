<?php
include_once("conn/conn.php");
include("libs/config.php");

function get_date_sql($date_th_format) {

    $date_insert = substr($date_th_format, 6, 4) - 543;
    $date_insert = $date_insert . "/" . substr($date_th_format, 3, 2);
    $date_insert = $date_insert . "/" . (substr($date_th_format, 0, 2));
    return $date_insert;
}

function get_date_show($date_f) {
    $date_show = substr($date_f, 8, 2);
    $date_show = $date_show . "-" . substr($date_f, 5, 2);
    $date_show = $date_show . "-" . (substr($date_f, 0, 4) + 543);
    return $date_show;
}



function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

function curPageURL() {
 $pageURL = 'http';
 //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function get_login($uname,$pass) {
    

            $md5_pass = md5($pass);
            $sql = "select loginname,name,passweb from opduser where loginname = '$uname' and passweb = '$md5_pass'";
                $query = mysql_query($sql);
                $rows = mysql_num_rows($query);
                $name = "";
                while ($result = mysql_fetch_array($query)) {
                            $name = $result['name'];
                }
                
                if($rows==1){
                    $_SESSION['name'] = $name;
                    $_SESSION['logid']  = get_logid();
                    $_SESSION['computer'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                    $log_id  = get_logid();
                    $get_timestamp_thai = get_timestamp_thai();
                    $get_computer = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                    $sql = "insert into pklog_sys(pklog_id,pklog_user,pklog_begin,pklog_computer) 
                            values('$log_id','$name','$get_timestamp_thai','$get_computer');
                            ";
                    mysql_query($sql) or die(mysql_error());
                    //echo $sql;

                }else{

                    unset($_SESSION['name']);
                    unset($_SESSION['logid']);
                    unset($_SESSION['computer']);


                }
            return   $rows;




}

function chk_session($name){

    if(empty($name)){
         $server_host  = explode("/", $_SERVER["PHP_SELF"]);
        header("location:http://".$_SERVER["SERVER_NAME"]."/".$server_host[1]."/f_login.php");
    }
        # code...
    
}





function get_logid(){
        date_default_timezone_set('Asia/Bangkok');
        $logid = substr((date("Y")+543),2,2).date("m").date("d").date("His") ;
        return  $logid;

}

function get_timestamp_thai(){
        date_default_timezone_set('Asia/Bangkok');
        $date_format = date("Y-m-d H:i:s");
        return $date_format;

}



function  set_data_time_out(){
         date_default_timezone_set('Asia/Bangkok');
         $get_timestamp_thai = get_timestamp_thai();

         $user = $_SESSION['name'];
         $log_id = $_SESSION['logid'];
         $computer = $_SESSION['computer'] ;

         $sql = "update pklog_sys set pklog_timeout = '$get_timestamp_thai'  where pklog_id = '$log_id' and pklog_user = '$user' and pklog_computer ='$computer'";
         mysql_query($sql);
}


function get_month_show($vn4digit) {
    $year_ = ('25' . substr($vn4digit, 0, 2));
    $month_ = substr($vn4digit, -2);
    $m_th = "";

    switch ($month_) {
        case '01' : $m_th = "มกราคม";
            break;
        case '02' : $m_th = "กุมภาพันธ์";
            break;
        case '03' : $m_th = "มีนาคม";
            break;
        case '04' : $m_th = "เมษายน";
            break;
        case '05' : $m_th = "พฤษภาคม";
            break;
        case '06' : $m_th = "มิถุนายน";
            break;
        case '07' : $m_th = "กรกฎาคม";
            break;
        case '08' : $m_th = "สิงหาคม";
            break;
        case '09' : $m_th = "กันยายน";
            break;
        case '10' : $m_th = "ตุลาคม";
            break;
        case '11' : $m_th = "พฤศจิกายน";
            break;
        case '12' : $m_th = "ธันวาคม";
            break;
    }
    $data = " ประจำเดือน  " . $m_th . "  พ.ศ. " . $year_;
    return $data;
}

function get_month_stagement($vn4digit) {

    $year_ = ('25' . substr($vn4digit, 0, 2));
    $month_ = substr($vn4digit, -2);
    if ($month_ > 9) {
        $year_start = (($year_) - 543);
        $year_end = (($year_) - 543) + 1;
    } else {

        $year_start = (($year_) - 543) - 1;
        $year_end = (($year_) - 543);
    }

    $date_statnent = " '$year_start/10/01' and '$year_end/09/30'";
    return $date_statnent;
}

function get_vn_4digit($y, $m) {

    $y1 = substr(($y + 543), 2, 2);
    if (strlen($m) == 1) {
        $m1 = "0" . $m;
    } else {
        $m1 = $m;
    };
    return $y1 . $m1;
}

function get_date_end($m) {
    switch ($m) {
        case 1 : $d = "31";
        case 2 : $d = "28";
        case 3 : $d = "31";
        case 4 : $d = "30";
        case 5 : $d = "31";
        case 6 : $d = "30";
        case 7 : $d = "31";
        case 8 : $d = "31";
        case 9 : $d = "30";
        case 10 : $d = "31";
        case 11 : $d = "30";
        case 12 : $d = "31";
    }

    return $d;
}

function get_Error_Detail_Name($err_code) {
    $sql = "select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = '$err_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
    }
    return $ERROR_DETAIL;
}

function get_row_person_Error_all() {

    $hospcode = HOSPITAL_CODE;

    $sql = "select 'PE9216' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9216'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person 
				where nationality <> 99 and (person_labor_type_id not in(select person_labor_type_id from person_labor_type) or person_labor_type_id is null)

				UNION

				select 'PE1115' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1115'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0)  as CC 
				from person 
				where (education not in(select education from education)  or education is null)

				UNION

				select 'PE1140' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1140'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person 
				where (house_regist_type_id not in(select house_regist_type_id from house_regist_type) or house_regist_type_id is null)


				UNION

				select 'PE1141' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1141'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person 
				where (person_discharge_id not in(select person_discharge_id from person_discharge) or person_discharge_id is null)

				UNION

				select 'PE9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9901'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person
				where person_discharge_id <> 1 and person_id in(select person_id from person_death)

				UNION

				select 'PE1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1107'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person
				where (sex not in(1,2) or sex is null)

				UNION

				select 'PE1116' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1116'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0)  as CC 
				from person
				where (person_house_position_id not in(1,2) or person_house_position_id  is null)

				UNION
				select 'PE9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9902'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0)  as CC 
				from person
				where house_regist_type_id = 1 and person_discharge_id = 2 

				UNION

				select 'PE9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9903'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person 
				where (sex = 2 and pname not in(select name from pname where sex = 2)) or ((sex = 1 and pname not in(select name from pname where sex = 1)))


				union

				select 'PE1117' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1117'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person 
				where left(cid,6) = (select concat('0',hospitalcode) from opdconfig) and nationality = '99'  and citizenship = '99'

				union
				
				select 'PE9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9904'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person where (person.patient_link <>'Y' or person.patient_link is null)   and cid in(select cid from patient)	
				
				union
				
				select 'PE9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9905'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where type_area in(1,3) and concat(chwpart,amppart,tmbpart) in(SELECT concat(chwpart,amppart,tmbpart) as cw from hospcode where hospcode =(select hospitalcode from opdconfig)) and cid not in(SELECT cid from person)

				
				union
				select 'PE9906' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9906'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person,patient where person.cid = patient.cid and person.patient_hn <> patient.hn  and person.death <>'Y'


                UNION

                select 'PE9907' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9907'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
                from person where (pname   like'%พระ%'  or pname  like'%สามเณร%' ) and marrystatus <> '6' and person.death <>'Y'

                UNION

                select 'PE9908' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9908'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
                from person where (pname  not like'%พระ%'  and pname not like'%สามเณร%' ) and marrystatus = '6' and person.death <>'Y'

                UNION

                select 'PE9909' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9909'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(person.person_id)),0) as CC 
                from person where   (person.pname   like'%แม่ชี%' ) and person.marrystatus not in(1,3,4,5) and person.death <>'Y'

                UNION

                 select 'PE9910' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9910'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(person.person_id)),0) as CC 
                    FROM person where (cid = father_cid)


                UNION

                 select 'PE9911' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9911'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(person.person_id)),0) as CC 
                    FROM person where (cid = mother_cid)



				 ";


    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + $result['CC'];
    }
    return $CC;
}

function get_rows_person_Error_detail() {

    $hospcode = HOSPITAL_CODE;
    $sql = "select 'PE9216' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9216'  ) as 'ERROR_DETAIL' ,count(person.person_id) as CC 
				from person 
				where nationality <> 99 and (person_labor_type_id not in(select person_labor_type_id from person_labor_type) or person_labor_type_id is null)

				UNION

				select 'PE1115' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1115'  ) as 'ERROR_DETAIL' ,count(person.person_id) as CC 
				from person 
				where (education not in(select education from education)  or education is null)

				UNION

				select 'PE1140' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1140'  ) as 'ERROR_DETAIL' ,count(person.person_id) as CC 
				from person 
				where (house_regist_type_id not in(select house_regist_type_id from house_regist_type) or house_regist_type_id is null)


				UNION

				select 'PE1141' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1141'  ) as 'ERROR_DETAIL' ,count(person.person_id) as CC 
				from person 
				where (person_discharge_id not in(select person_discharge_id from person_discharge) or person_discharge_id is null)

				UNION

				select 'PE9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9901'  ) as 'ERROR_DETAIL' ,count(person.person_id) as CC 
				from person
				where person_discharge_id <> 1 and person_id in(select person_id from person_death)

				UNION

				select 'PE1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1107'  ) as 'ERROR_DETAIL' ,count(person.person_id) as CC 
				from person
				where (sex not in(1,2) or sex is null)

				UNION

				select 'PE1116' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1116'  ) as 'ERROR_DETAIL' ,count(person.person_id) as CC 
				from person
				where (person_house_position_id not in(1,2) or person_house_position_id  is null)

				UNION
				select 'PE9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9902'  ) as 'ERROR_DETAIL' ,count(person.person_id) as CC 
				from person
				where house_regist_type_id = 1 and person_discharge_id = 2 

				UNION
				select 'PE9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9903'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person 
				where (sex = 2 and pname not in(select name from pname where sex = 2)) or ((sex = 1 and pname not in(select name from pname where sex = 1)))


				union
				select 'PE1117' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE1117'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person 
				where left(cid,6) = (select concat('0',hospitalcode) from opdconfig) and nationality = '99'  and citizenship = '99'
				
				union
				
				select 'PE9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9904'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person where (person.patient_link <>'Y' or person.patient_link is null)   and cid in(select cid from patient)	
				
				
				union
				
				select 'PE9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9905'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where type_area in(1,3) and concat(chwpart,amppart,tmbpart) in(SELECT concat(chwpart,amppart,tmbpart) as cw from hospcode where hospcode =(select hospitalcode from opdconfig))  and cid not in(SELECT cid from person)

				union
				select 'PE9906' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9906'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
				from person,patient where person.cid = patient.cid and person.patient_hn <> patient.hn and person.death <>'Y'


                UNION

                select 'PE9907' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9907'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
                from person where (pname   like'%พระ%'  or pname  like'%สามเณร%' ) and marrystatus <> '6' and person.death <>'Y'

                UNION

                select 'PE9908' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9908'  ) as 'ERROR_DETAIL' ,ifnull(count(person.person_id),0) as CC 
                from person where (pname  not like'%พระ%'  and pname not like'%สามเณร%' ) and marrystatus = '6' and person.death <>'Y'


                UNION

                select 'PE9909' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9909'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(person.person_id)),0) as CC 
                from person where   (person.pname   like'%แม่ชี%' ) and person.marrystatus not in(1,3,4,5) and person.death <>'Y'


                UNION

                 select 'PE9910' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9910'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(person.person_id)),0) as CC 
                    FROM person where (cid = father_cid)


                UNION

                 select 'PE9911' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PE9911'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(person.person_id)),0) as CC 
                    FROM person where (cid = mother_cid)


				order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = $result['CC'];
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='person_detail.php?err=$ERROR_CODE' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_person_Error_detail_list($error_code, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>PID</th>
                                      <th> ชื่อ - สกุล </th>
                                      <th> CID</th>
                                      <th> อายุ</th>
                                      <th> ที่อยู่</th>
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $age_y = $result['age_y'];
        $person_id = $result['person_id'];
        $cid = $result['cid'];
        $hous_addr = $result['hous_addr'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$age_y</td>
                                      <td>$hous_addr</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_patient_Error_all() {

    $sql = "select 'PA1140' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA1140'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (type_area not in(select house_regist_type_id from house_regist_type) or type_area is null)

				UNION

				select 'PA9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9901'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (death <> 'Y' and hn in(select hn from death) ) or (death is null  and hn in(select hn from death)) 

				UNION

				select 'PA1115' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA1115'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (educate is null) or  educate not in(select education FROM education )

				UNION

				select 'PA9212' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9212'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (nationality is null) or  nationality not in(select nationality FROM nationality )

				UNION

				select 'PA9216' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9216'  ) as 'ERROR_DETAIL' ,count(patient.hn) as CC 
				from patient 
				where nationality <> 99 and labor_type not in(select person_labor_type_id from person_labor_type)
				
				UNION
				select 'PA9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9903'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (sex = 2 and pname not in(select name from pname where sex = 2)) or ((sex = 1 and pname not in(select name from pname where sex = 1)))

                UNION

                select 'PA9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9904'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
                FROM patient 
                left join person on patient.cid = person.cid
                where type_area = '1' and concat(chwpart,amppart,tmbpart) not in('421203')
                and person.patient_link is null 

                UNION

                select 'PA9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9905'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
                from patient 
                where (pname  like'%พระ%'  or pname like'%สามเณร%' ) and marrystatus <> '6' 


                UNION

                select 'PA9906' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9906'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
                from patient 
                where pname not like'%พระ%' and  pname not like'%สามเณร%'   and   marrystatus = '6'

                UNION

                select 'PA9907' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9907'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC
                from patient where   (patient.pname   like'%แม่ชี%' ) and patient.marrystatus not in(1,3,4,5) 


				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + $result['CC'];
    }
    return $CC;
}

function get_rows_patient_Error_detail() {

    $sql = "select 'PA1140' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA1140'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (type_area not in(select house_regist_type_id from house_regist_type) or type_area is null)

				UNION

				select 'PA9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9901'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (death <> 'Y' and hn in(select hn from death) ) or (death is null  and hn in(select hn from death)) 

				UNION

				select 'PA1115' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA1115'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (educate is null) or  educate not in(select education FROM education )

				UNION

				select 'PA9212' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9212'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (nationality is null) or  nationality not in(select nationality FROM nationality )

				UNION

				select 'PA9216' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9216'  ) as 'ERROR_DETAIL' ,count(patient.hn) as CC 
				from patient 
				where nationality <> 99 and labor_type not in(select person_labor_type_id from person_labor_type)

				UNION
				select 'PA9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9903'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
				from patient 
				where (sex = 2 and pname not in(select name from pname where sex = 2)) or ((sex = 1 and pname not in(select name from pname where sex = 1)))


                UNION

                select 'PA9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9904'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
                FROM patient 
                left join person on patient.cid = person.cid
                where type_area = '1' and concat(chwpart,amppart,tmbpart) not in('421203')
                and person.patient_link is null


                UNION

                select 'PA9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9905'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
                from patient 
                where (pname  like'%พระ%'  or pname like'%สามเณร%' ) and marrystatus <> '6' 


                UNION

                select 'PA9906' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9906'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC 
                from patient 
                where pname not like'%พระ%' and  pname not like'%สามเณร%'   and   marrystatus = '6'


                UNION

                select 'PA9907' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PA9907'  ) as 'ERROR_DETAIL' ,ifnull(count(patient.hn),0) as CC
                from patient where   (patient.pname   like'%แม่ชี%' ) and patient.marrystatus not in(1,3,4,5) 


				order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = $result['CC'];
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='patient_detail.php?err=$ERROR_CODE' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_patient_Error_detail_list($error_code, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql) or die(mysql_error());

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>HN</th>
                                      <th> ชื่อ - สกุล </th>
                                      <th> CID</th>
                                      <th> อายุ</th>
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $age_y = $result['age_y'];
        $person_id = $result['hn'];
        $cid = $result['cid'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$age_y</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Accident_Error_all($vn4digit) {

    $sql = "select 'AD1110' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1110'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (accident_airway_type_id is null or accident_airway_type_id not in('1','2','3'))

				UNION

				select 'AD1111' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1111'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (accident_bleed_type_id is null or accident_bleed_type_id not in('1','2','3'))

				UNION

				select 'AD1112' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1112'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (accident_splint_type_id is null or accident_splint_type_id not in('1','2','3'))


				UNION

				select 'AD1113' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1113'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (accident_fluid_type_id is null or accident_fluid_type_id not in('1','2','3'))




				UNION

				select 'AD1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1107'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (visit_type not in(select visit_type from er_nursing_visit_type) or visit_type is null ) 


				union

				select 'AD2120' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD2120'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				 from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%' 
				and (gcs_e is null or gcs_e not BETWEEN '1' and '4')

				union

				select 'AD2121' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD2121'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				 from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%' 
				and (gcs_v is null or gcs_v not BETWEEN '1' and '5')


				union

				select 'AD2122' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD2122'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				 from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%' 
				and (gcs_m is null or gcs_m not BETWEEN '1' and '6')


				UNION 

				select 'AD1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1106'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				left join patient on  (select hn from vn_stat where vn = er_nursing_detail.vn ) = patient.hn  
				where  ( visit_type not in(select visit_type from er_nursing_visit_type) or visit_type is null )  and  er_accident_type_id is not null   and  
				 ( accident_place_type_id  is null  or 
				     accident_place_type_id not in(SELECT accident_place_type_id from accident_place_type ) ) and vn like'$vn4digit%' 

				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + $result['CC'];
    }
    return $CC;
}

function get_rows_Accident_Error_detail($vn4digit) {

    $sql = "select 'AD1110' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1110'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (accident_airway_type_id is null or accident_airway_type_id not in('1','2','3'))

				UNION

				select 'AD1111' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1111'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (accident_bleed_type_id is null or accident_bleed_type_id not in('1','2','3'))

				UNION

				select 'AD1112' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1112'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (accident_splint_type_id is null or accident_splint_type_id not in('1','2','3'))


				UNION

				select 'AD1113' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1113'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (accident_fluid_type_id is null or accident_fluid_type_id not in('1','2','3'))




				UNION

				select 'AD1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1107'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%'
				and (visit_type not in(select visit_type from er_nursing_visit_type) or visit_type is null )



				union

				select 'AD2120' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD2120'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				 from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%' 
				and (gcs_e is null or gcs_e not BETWEEN '1' and '4')

				union

				select 'AD2121' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD2121'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				 from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%' 
				and (gcs_v is null or gcs_v not BETWEEN '1' and '5')

				
				union

				select 'AD2122' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD2122'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				 from er_nursing_detail 
				where er_accident_type_id is not null and vn like'$vn4digit%' 
				and (gcs_m is null or gcs_m not BETWEEN '1' and '6')

				UNION 

				select 'AD1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AD1106'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from er_nursing_detail 
				left join patient on  (select hn from vn_stat where vn = er_nursing_detail.vn ) = patient.hn  
				where  ( visit_type not in(select visit_type from er_nursing_visit_type) or visit_type is null )  and  er_accident_type_id is not null   and  
				 ( accident_place_type_id  is null  or 
				     accident_place_type_id not in(SELECT accident_place_type_id from accident_place_type ) ) and vn like'$vn4digit%' 



				order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = $result['CC'];
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='accident_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Accident_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }

    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>HN</th>
                                      <th> ชื่อ - สกุล </th>
                                      <th> CID</th>
                                      <th> DATEServ</th>
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1 . " and vn like'$vn4digit%'");
    $rows = mysql_num_rows($query2);
    //echo $sql1." and vn like'$vn4digit%'";
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $person_id = $result['hn'];
        $cid = $result['cid'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$DATEServ</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Diag_opd_Error_all($vn4digit) {

    $sql = "select 'DX1130' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX1130'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from vn_stat 
				where (pdx is null or pdx = '') and vn like'$vn4digit%'
				union
				select 'DX1131' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX1131'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from ovstdiag 
				where (diagtype not in(select diagtype from diagtype) or diagtype is null or diagtype = '') and vn like'$vn4digit%' 

                UNION
                select 'DX9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9901'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
                    FROM ovstdiag 
                    inner JOIN (SELECT code as 'icd10' from icd101 WHERE sex ='2' and active_status = 'Y') icd10 on ovstdiag.icd10 = icd10.icd10
                    INNER JOIN patient on ovstdiag.hn = patient.hn
                    where patient.sex = 1 and vn like'$vn4digit%'

                UNION
                select 'DX9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9902'  ) as 'ERROR_DETAIL' ,ifnull(count(ovstdiag.vn),0) as CC
                FROM ovstdiag 
                INNER JOIN (SELECT `code` FROM icd101 where code BETWEEN 'V01%' and 'Y98%') ext_diag on ovstdiag.icd10 = ext_diag.`code`
                where ovstdiag.diagtype <> 5 and ovstdiag.vn like'$vn4digit%'

                UNION

                select 'DX9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9903'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                from ovstdiag 
                where (icd10 like'S%' or icd10 like'T%') and  (SELECT DISTINCT(vdx1.vn) from ovstdiag  vdx1 where (vdx1.icd10 like'V%' or vdx1.icd10 like'W%' or vdx1.icd10 like'X%' or vdx1.icd10 like'Y%') and vdx1.vn = ovstdiag.vn) is null
                and vn like'$vn4digit%'

                UNION

                select 'DX9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9904'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                from ovstdiag 
                inner join (
                select vn from ovstdiag   where  left(icd10,1) not in ('V','W','X','Y') and diagtype = 5
                union
                select vn from ovstdiag   where  left(icd10,1)  in ('V','W','X','Y') and diagtype != 5
                ) diag_error on ovstdiag.vn = diag_error.vn                 
                where ovstdiag.vn like'$vn4digit%'	

                UNION

                select 'DX9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9905'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                from ovstdiag 
                INNER JOIN (SELECT `code` FROM icd101 where code BETWEEN 'T310' and 'T319') ext_diag on ovstdiag.icd10 = ext_diag.`code`
                left join patient on   ovstdiag.hn = patient.hn
                where ovstdiag.vn like'$vn4digit%'  			

                UNION

                select 'DX9906' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9906'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                FROM    ovstdiag
                LEFT JOIN patient ON ovstdiag.hn = patient.hn
                WHERE(icd10 BETWEEN 'Z480' AND 'Z489' or icd10 BETWEEN 'Z470' AND 'Z479'    )
                 AND (SELECT DISTINCT   (vdx1.vn)   FROM    ovstdiag vdx1   WHERE ( vdx1.icd10 BETWEEN 'S%' AND 'T%')   AND vdx1.vn = ovstdiag.vn
                ) IS NOT  NULL 
                and  vn like'$vn4digit%'  

                UNION

                 select 'DX9204' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9204'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                FROM    ovstdiag
                LEFT JOIN patient ON ovstdiag.hn = patient.hn
                left join  icd10_nhso on ovstdiag.icd10 = icd10_nhso.code
                where (ASCII(ovstdiag.icd10) between 65 and  90)
                        and ovstdiag.icd10 <>'R5100' and  icd10_nhso.code is null and ovstdiag.vn  like'$vn4digit%' 

				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + $result['CC'];
    }
    return $CC;
}

function get_rows_Diag_opd_Error_detail($vn4digit) {

    $sql = "select 'DX1130' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX1130'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from vn_stat 
				where (pdx is null or pdx = '') and vn like'$vn4digit%'
				union
				select 'DX1131' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX1131'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from ovstdiag 
				where (diagtype not in(select diagtype from diagtype) or diagtype is null or diagtype = '') and vn like'$vn4digit%'

                UNION
                select 'DX9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9901'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
                    FROM ovstdiag 
                    inner JOIN (SELECT code as 'icd10' from icd101 WHERE sex ='2' and active_status = 'Y') icd10 on ovstdiag.icd10 = icd10.icd10
                    INNER JOIN patient on ovstdiag.hn = patient.hn
                    where patient.sex = 1 and vn like'$vn4digit%'


                UNION
                select 'DX9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9902'  ) as 'ERROR_DETAIL' ,ifnull(count(ovstdiag.vn),0) as CC
                FROM ovstdiag 
                INNER JOIN (SELECT `code` FROM icd101 where code BETWEEN 'V01%' and 'Y98%') ext_diag on ovstdiag.icd10 = ext_diag.`code`
                where ovstdiag.diagtype <> 5 and ovstdiag.vn like'$vn4digit%'


                UNION

                select 'DX9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9903'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                from ovstdiag 
                where (icd10 like'S%' or icd10 like'T%') and  (SELECT DISTINCT(vdx1.vn) from ovstdiag  vdx1 where (vdx1.icd10 like'V%' or vdx1.icd10 like'W%' or vdx1.icd10 like'X%' or vdx1.icd10 like'Y%') and vdx1.vn = ovstdiag.vn) is null
                and vn like'$vn4digit%'

                UNION

                select 'DX9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9904'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                from ovstdiag 
                inner join (
                select vn from ovstdiag   where  left(icd10,1) not in ('V','W','X','Y') and diagtype = 5
                union
                select vn from ovstdiag   where  left(icd10,1)  in ('V','W','X','Y') and diagtype != 5
                ) diag_error on ovstdiag.vn = diag_error.vn                 
                where ovstdiag.vn like'$vn4digit%'     

                UNION

                select 'DX9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9905'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                from ovstdiag 
                INNER JOIN (SELECT `code` FROM icd101 where code BETWEEN 'T310' and 'T319') ext_diag on ovstdiag.icd10 = ext_diag.`code`
                left join patient on   ovstdiag.hn = patient.hn
                where ovstdiag.vn like'$vn4digit%'   

                UNION

                select 'DX9906' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9906'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                FROM    ovstdiag
                LEFT JOIN patient ON ovstdiag.hn = patient.hn
                WHERE(icd10 BETWEEN 'Z480' AND 'Z489' or icd10 BETWEEN 'Z470' AND 'Z479'    )
                 AND (SELECT DISTINCT   (vdx1.vn)   FROM    ovstdiag vdx1   WHERE ( vdx1.icd10 BETWEEN 'S%' AND 'T%')   AND vdx1.vn = ovstdiag.vn
                ) IS NOT  NULL 
                and  vn like'$vn4digit%'   



                UNION

                 select 'DX9204' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DX9204'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovstdiag.vn)),0) as CC
                FROM    ovstdiag
                LEFT JOIN patient ON ovstdiag.hn = patient.hn
                        left join  icd10_nhso on ovstdiag.icd10 = icd10_nhso.code
                        where (ASCII(ovstdiag.icd10) between 65 and  90)
                        and ovstdiag.icd10 <>'R5100' and  icd10_nhso.code is null and ovstdiag.vn  like'$vn4digit%'               
                    
				order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = $result['CC'];
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='diag-opd_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Diag_opd_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>HN</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>DATEServ</th>
                                      <th>DATETime</th>
                                      <th>Dxtype</th>
                                 </tr>

                                      ";
    $i = 0;

    if($error_code=='DX9903'){
            $query2 = mysql_query($sql1 . "  like'$vn4digit%' group by vn"); 

    }else{

           $query2 = mysql_query($sql1 . "  like'$vn4digit%'"); 
    }


    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $person_id = $result['hn'];
        $cid = $result['cid'];
        $vsttime = $result['vsttime'];
        $dxtype = $result['dxtype'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td >$i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$DATEServ</td>
                                      <td>$vsttime</td>
                                      <td>$dxtype</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Anc_Error_all($vn4digit) {

    $sql = "select 'AN1141' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN1141'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_anc_service ps_service
				where   ps_service.anc_service_type_id = 1 and (ps_service.pa_week is null or ps_service.pa_week ='')
				and ps_service.vn like'$vn4digit%'
				UNION

				select 'AN9241' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9241'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_anc_service ps_service
				where   ps_service.anc_service_type_id = 1 and (ps_service.pa_week < 4 or ps_service.pa_week > 45)
				and ps_service.vn like'$vn4digit%'

				UNION
				select 'AN9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9901'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_anc_service ps_service
				left JOIN person_anc ps_anc on ps_service.person_anc_id = ps_anc.person_anc_id
				where   ps_service.anc_service_type_id = 1 and ps_anc.preg_no > 20
				 and ps_service.vn like'$vn4digit%'

				UNION
				  select 'AN9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9299'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC   
				  from ovst 
				   INNER JOIN (	SELECT person_anc_id,anc_service_date , vn   
					from person_anc_service
				  GROUP BY concat(person_anc_id,anc_service_date) 
				  HAVING count(concat(person_anc_id,anc_service_date)) >1 ) ps_anc on ovst.vn = ps_anc.vn 
				  where ovst.vn like'$vn4digit%' 

				  UNION

				select 'AN9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9902'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_anc_service ps_service
				left JOIN person_anc ps_anc on ps_service.person_anc_id = ps_anc.person_anc_id
				where   ps_service.anc_service_type_id = 1 and ps_anc.preg_no is null
				 and ps_service.vn like'$vn4digit%'

                  
                  UNION
                select 'AN9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9903'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                from person_anc
                INNER JOIN (SELECT person_id,preg_no
                from person_anc 
                GROUP BY  person_id ,preg_no
                HAVING count(person_id) > 1 ) anc_lasthan1 on person_anc.person_id = anc_lasthan1.person_id
                where out_region = 'N'  
                and concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m') ) like'$vn4digit%'


                    UNION

               select 'AN9990' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9990'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(person_anc.person_anc_id)),0) as CC  
                from person_anc_service ps_service
                left join person_anc on ps_service.person_anc_id = person_anc.person_anc_id
                where   ps_service.anc_service_type_id = 1 
                    and (
                         person_anc.anc_register_date < (case when MONTH(ps_service.anc_service_date) <= 9 THEN
                                                 (concat((year(ps_service.anc_service_date)-1),'-10-01'))
                                                        else (concat(year(ps_service.anc_service_date),'-10-01')) end )  
                        or
                            person_anc.anc_register_date > (case when MONTH(ps_service.anc_service_date) <= 9 THEN
                                                 (concat(year(ps_service.anc_service_date),'-09-30' ))
                                                        else (concat((year(ps_service.anc_service_date)+1) ,'-09-30' )) end )  
                    )  
                            and ps_service.vn like'$vn4digit%'



                    UNION

                    SELECT  'AN9971' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9971'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                    from person_anc
                    INNER JOIN (SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as wpa_now,
                    (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service1_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) 
                        THEN 
                                (
                                SELECT if(count(person_anc_id)>0,'Yes',             
                                        (
                                            SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                            from person_anc_other_precare
                                            inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                            where precare_no = 1 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) , 'Y','N') = 'Y'
                                             and person_anc1.person_anc_id = person_anc.person_anc_id
                                        )
                            )
                                FROM person_anc_service 
                                where anc_service_number = 1 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                )
                      ELSE
                                if(person_anc.pre_labor_service1_date is null,'NULL','Yes')
                        END
                    )  as week_anc
                    from person_anc
                    where discharge <>'Y' and out_region<>'Y' 
                    and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 1))
                    HAVING week_anc = 'NO' or person_anc.pre_labor_service1_date is null
                    ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                     where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m')) like'$vn4digit'


                    UNION

                    SELECT  'AN9972' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9972'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                      from person_anc
                        INNER JOIN (SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as chk, 
                      (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service2_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) 
                        THEN 
                            (SELECT if(count(person_anc_id)>0,'Yes',                
                                        (
                                            SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                            from person_anc_other_precare
                                            inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                            where precare_no = 2 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) , 'Y','N') = 'Y'
                                             and person_anc1.person_anc_id = person_anc.person_anc_id
                                        )
                            )
                                FROM person_anc_service 
                                where anc_service_number = 2 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 2 )  , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                )
                      ELSE
                                if(person_anc.pre_labor_service2_date is null,'NULL','Yes')
                        END
                    ) as week_anc
                    from person_anc
                    where discharge <>'Y' and out_region<>'Y' 
                    and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 2))
                    HAVING week_anc = 'NO' or person_anc.pre_labor_service2_date is null
                        ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                        left join patient on (select cid from person where person_id = person_anc.person_id) = patient.cid
                      where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m'))  like'$vn4digit'


                    UNION

                    SELECT  'AN9973' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9973'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC    
                     from person_anc
                        INNER JOIN (
                        SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as wpa_now,
                        (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service3_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 3 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 3 ) 
                            THEN 
                                (SELECT if(count(person_anc_id)>0,'Yes',                
                                        (
                                            SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                            from person_anc_other_precare
                                            inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                            where precare_no = 3 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 3 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 3 )  , 'Y','N') = 'Y'
                                             and person_anc1.person_anc_id = person_anc.person_anc_id
                                        )

                            )
                                FROM person_anc_service 
                                where anc_service_number = 3 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 3 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 3 ) , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                )
                            ELSE
                                if(person_anc.pre_labor_service3_date is null,'NULL','Yes')
                            END
                        )  as week_anc
                        from person_anc
                        where discharge <>'Y' and out_region<>'Y' 
                        and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 3))
                        HAVING week_anc = 'NO' or person_anc.pre_labor_service3_date is null
                        ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                        left join patient on (select cid from person where person_id = person_anc.person_id) = patient.cid
                      where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m')) like '$vn4digit'


                        UNION

                        SELECT  'AN9974' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9974'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC    
                         from person_anc
                            INNER JOIN (SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as wpa_now,
                        (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service4_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 4 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 4 ) 
                            THEN 
                                    (SELECT if(count(person_anc_id)>0,'Yes',
                                        (
                                                SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                                from person_anc_other_precare
                                                inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                                where precare_no = 4 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 4 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 4 ) , 'Y','N') = 'Y'
                                                 and person_anc1.person_anc_id = person_anc.person_anc_id
                                            )
                                )
                                    FROM person_anc_service 
                                    where anc_service_number = 4 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 4 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 4 )  , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                    )
                          ELSE
                                    if(person_anc.pre_labor_service4_date is null,'NULL','Yes')
                          END
                        ) as week_anc
                        from person_anc
                        where discharge <>'Y' and out_region<>'Y' 
                        and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 4))
                        HAVING week_anc = 'NO' or person_anc.pre_labor_service4_date is null
                            ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                            left join patient on (select cid from person where person_id = person_anc.person_id) = patient.cid
                          where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m'))  like'$vn4digit'



                        UNION

                        SELECT  'AN9975' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9975'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC    
                        from person_anc
                            INNER JOIN (SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as wpa_now,
                        (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service5_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 5 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 5 )  
                            THEN 
                                    (SELECT if(count(person_anc_id)>0,'Yes',                
                                            (
                                                SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                                from person_anc_other_precare
                                                inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                                where precare_no = 5 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 5 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 5 )  , 'Y','N') = 'Y'
                                                 and person_anc1.person_anc_id = person_anc.person_anc_id
                                            )
                                )
                                    FROM person_anc_service 
                                    where anc_service_number = 5 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 5 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 5 )  , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                    )
                          ELSE
                                if(person_anc.pre_labor_service5_date is null,'NULL','Yes')
                            END
                        )  as week_anc
                        from person_anc
                        where discharge <>'Y' and out_region<>'Y' 
                        and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 5))
                        HAVING week_anc = 'NO' or person_anc.pre_labor_service5_date is null
                            ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                            left join patient on (select cid from person where person_id = person_anc.person_id) = patient.cid
                          where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m'))  like'$vn4digit'


                        UNION

                        select 'AN9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9904'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                        from person_anc
                        INNER JOIN (SELECT person_anc.person_id,person_anc.preg_no from person_anc 
                                            left join (SELECT person.person_id from dental_care
                                            LEFT JOIN ovst on dental_care.vn = ovst.vn
                                            left JOIN person on ovst.hn = person.patient_hn) person_dental on person_anc.person_id= person_dental.person_id
                                            WHERE person_dental.person_id is null and person_anc.discharge <>'Y') anc_dental on person_anc.person_id = anc_dental.person_id
                        where out_region = 'N'  
                        and concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m') ) like'$vn4digit'


                        UNION

                         select 'AN9981' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9981'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC
                         FROM person_anc  
                         LEFT JOIN person on person_anc.person_id = person.person_id
                         where labor_date is not null and labor_status_id not in(1,4) 
                         and (SELECT concat(vstdate ,'::',icd10) from ovstdiag where vstdate > person_anc.labor_date  and ovstdiag.icd10 in('Z348','Z340','Z350','Z356','Z358','Z357')
                              and DATEDIFF(vstdate,person_anc.labor_date) < 30 and hn = person.patient_hn  limit 1) is not null 
                         and concat(RIGHT((DATE_FORMAT(person_anc.labor_date ,'%Y') +543),2),DATE_FORMAT(person_anc.labor_date ,'%m') ) like'$vn4digit'


                         UNION

                         select 'AN9982' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9982'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                        from person_anc ps_anc
                        left join patient on (select cid from person where person_id = ps_anc.person_id) = patient.cid
                        where   TIMESTAMPDIFF(week,ps_anc.lmp,CURDATE()) >42 and ps_anc.out_region ='N' and ps_anc.labor_status_id = '1' and ps_anc.discharge <> 'Y'  




				   "

    ;
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + $result['CC'];
    }
    return $CC;
}

function get_rows_Anc_Error_detail($vn4digit) {

    $sql = "select 'AN1141' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN1141'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_anc_service ps_service
				where   ps_service.anc_service_type_id = 1 and (ps_service.pa_week is null or ps_service.pa_week ='')
				and ps_service.vn like'$vn4digit%'
				UNION

				select 'AN9241' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9241'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_anc_service ps_service
				where   ps_service.anc_service_type_id = 1 and (ps_service.pa_week < 4 or ps_service.pa_week > 45)
				and ps_service.vn like'$vn4digit%'

				UNION
				select 'AN9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9901'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_anc_service ps_service
				left JOIN person_anc ps_anc on ps_service.person_anc_id = ps_anc.person_anc_id
				where   ps_service.anc_service_type_id = 1 and ps_anc.preg_no > 20
				 and ps_service.vn like'$vn4digit%'

				UNION
				  select 'AN9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9299'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC   
				  from ovst 
				   INNER JOIN (	SELECT person_anc_id,anc_service_date , vn   
					from person_anc_service
				  GROUP BY concat(person_anc_id,anc_service_date) 
				  HAVING count(concat(person_anc_id,anc_service_date)) >1 ) ps_anc on ovst.vn = ps_anc.vn 
				  where ovst.vn like'$vn4digit%' 

				  UNION

				select 'AN9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9902'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_anc_service ps_service
				left JOIN person_anc ps_anc on ps_service.person_anc_id = ps_anc.person_anc_id
				where   ps_service.anc_service_type_id = 1 and ps_anc.preg_no is null
				 and ps_service.vn like'$vn4digit%'


                UNION
                select 'AN9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9903'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                from person_anc
                INNER JOIN (SELECT person_id,preg_no
                from person_anc 
                GROUP BY  person_id ,preg_no
                HAVING count(person_id) > 1 ) anc_lasthan1 on person_anc.person_id = anc_lasthan1.person_id
                where out_region = 'N'  
                and concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m') ) like'$vn4digit%'


                UNION

               select 'AN9990' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9990'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(person_anc.person_anc_id)),0) as CC  
                from person_anc_service ps_service
                left join person_anc on ps_service.person_anc_id = person_anc.person_anc_id
                where   ps_service.anc_service_type_id = 1 
                    and (
                         person_anc.anc_register_date < (case when MONTH(ps_service.anc_service_date) <= 9 THEN
                                                 (concat((year(ps_service.anc_service_date)-1),'-10-01'))
                                                        else (concat(year(ps_service.anc_service_date),'-10-01')) end )  
                        or
                            person_anc.anc_register_date > (case when MONTH(ps_service.anc_service_date) <= 9 THEN
                                                 (concat(year(ps_service.anc_service_date),'-09-30' ))
                                                        else (concat((year(ps_service.anc_service_date)+1) ,'-09-30' )) end )  
                    )  
                    and ps_service.vn like'$vn4digit%'


                    UNION

                    SELECT  'AN9971' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9971'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                    from person_anc
                    INNER JOIN (SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as wpa_now,
                    (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service1_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) 
                        THEN 
                                (
                                SELECT if(count(person_anc_id)>0,'Yes',             
                                        (
                                            SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                            from person_anc_other_precare
                                            inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                            where precare_no = 1 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) , 'Y','N') = 'Y'
                                             and person_anc1.person_anc_id = person_anc.person_anc_id
                                        )
                            )
                                FROM person_anc_service 
                                where anc_service_number = 1 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 1 ) , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                )
                      ELSE
                                if(person_anc.pre_labor_service1_date is null,'NULL','Yes')
                        END
                    )  as week_anc
                    from person_anc
                    where discharge <>'Y' and out_region<>'Y' 
                    and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 1))
                    HAVING week_anc = 'NO' or person_anc.pre_labor_service1_date is null
                    ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                    where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m')) like'$vn4digit'



                    UNION

                    SELECT  'AN9972' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9972'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                      from person_anc
                        INNER JOIN (SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as chk, 
                      (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service2_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) 
                        THEN 
                            (SELECT if(count(person_anc_id)>0,'Yes',                
                                        (
                                            SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                            from person_anc_other_precare
                                            inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                            where precare_no = 2 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) , 'Y','N') = 'Y'
                                             and person_anc1.person_anc_id = person_anc.person_anc_id
                                        )
                            )
                                FROM person_anc_service 
                                where anc_service_number = 2 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 2 ) , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                )
                      ELSE
                                if(person_anc.pre_labor_service2_date is null,'NULL','Yes')
                        END
                    ) as week_anc
                    from person_anc
                    where discharge <>'Y' and out_region<>'Y' 
                    and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 2))
                    HAVING week_anc = 'NO' or person_anc.pre_labor_service2_date is null
                        ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                        left join patient on (select cid from person where person_id = person_anc.person_id) = patient.cid
                      where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m'))  like'$vn4digit'


                    UNION

                    SELECT  'AN9973' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9973'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC    
                     from person_anc
                        INNER JOIN (
                        SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as wpa_now,
                        (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service3_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 3 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 3 ) 
                            THEN 
                                (SELECT if(count(person_anc_id)>0,'Yes',                
                                        (
                                            SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                            from person_anc_other_precare
                                            inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                            where precare_no = 3 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 3 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 3 )  , 'Y','N') = 'Y'
                                             and person_anc1.person_anc_id = person_anc.person_anc_id
                                        )

                            )
                                FROM person_anc_service 
                                where anc_service_number = 3 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 3 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 3 )  , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                )
                            ELSE
                                if(person_anc.pre_labor_service3_date is null,'NULL','Yes')
                            END
                        )  as week_anc
                        from person_anc
                        where discharge <>'Y' and out_region<>'Y' 
                        and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 3))
                        HAVING week_anc = 'NO' or person_anc.pre_labor_service3_date is null
                        ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                        left join patient on (select cid from person where person_id = person_anc.person_id) = patient.cid
                      where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m')) like '$vn4digit'


                        UNION

                        SELECT  'AN9974' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9974'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC    
                         from person_anc
                            INNER JOIN (SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as wpa_now,
                        (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service4_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 4 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 4 ) 
                            THEN 
                                    (SELECT if(count(person_anc_id)>0,'Yes',
                                        (
                                                SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                                from person_anc_other_precare
                                                inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                                where precare_no = 4 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 4 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 4 )  , 'Y','N') = 'Y'
                                                 and person_anc1.person_anc_id = person_anc.person_anc_id
                                            )
                                )
                                    FROM person_anc_service 
                                    where anc_service_number = 4 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 4 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 4 )  , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                    )
                          ELSE
                                    if(person_anc.pre_labor_service4_date is null,'NULL','Yes')
                          END
                        ) as week_anc
                        from person_anc
                        where discharge <>'Y' and out_region<>'Y' 
                        and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 4))
                        HAVING week_anc = 'NO' or person_anc.pre_labor_service4_date is null
                            ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                            left join patient on (select cid from person where person_id = person_anc.person_id) = patient.cid
                          where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m'))  like'$vn4digit'


                        UNION

                        SELECT  'AN9975' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9975'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC    
                        from person_anc
                            INNER JOIN (SELECT * ,TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) as wpa_now,
                        (case when TIMESTAMPDIFF(week,person_anc.lmp,person_anc.pre_labor_service5_date) not BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 5 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 5 ) 
                            THEN 
                                    (SELECT if(count(person_anc_id)>0,'Yes',                
                                            (
                                                SELECT if(count(person_anc1.person_anc_id)>0,'Yes','NO')
                                                from person_anc_other_precare
                                                inner JOIN person_anc person_anc1 on person_anc_other_precare.person_anc_id = person_anc1.person_anc_id
                                                where precare_no = 5 and if(TIMESTAMPDIFF(week,person_anc1.lmp,person_anc_other_precare.precare_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 5 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 5 )  , 'Y','N') = 'Y'
                                                 and person_anc1.person_anc_id = person_anc.person_anc_id
                                            )
                                )
                                    FROM person_anc_service 
                                    where anc_service_number = 5 and if(TIMESTAMPDIFF(week,person_anc.lmp,person_anc_service.anc_service_date)  BETWEEN (SELECT week_min_quality from person_anc_preg_week where person_anc_preg_week_id = 5 ) and (SELECT week_max_quality from person_anc_preg_week where person_anc_preg_week_id = 5 )  , 'Y','N') = 'Y' and person_anc_id = person_anc.person_anc_id
                                    )
                          ELSE
                                if(person_anc.pre_labor_service5_date is null,'NULL','Yes')
                            END
                        )  as week_anc
                        from person_anc
                        where discharge <>'Y' and out_region<>'Y' 
                        and (TIMESTAMPDIFF(week,person_anc.lmp,CURDATE()) > (SELECT week_max from person_anc_preg_week where person_anc_preg_week_id = 5))
                        HAVING week_anc = 'NO' or person_anc.pre_labor_service5_date is null
                            ) anc_chk on person_anc.person_anc_id = anc_chk.person_anc_id
                            left join patient on (select cid from person where person_id = person_anc.person_id) = patient.cid
                          where concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m'))  like'$vn4digit'

                        UNION

                        select 'AN9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9904'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                        from person_anc
                        INNER JOIN (SELECT person_anc.person_id,person_anc.preg_no from person_anc 
                                            left join (SELECT person.person_id from dental_care
                                            LEFT JOIN ovst on dental_care.vn = ovst.vn
                                            left JOIN person on ovst.hn = person.patient_hn) person_dental on person_anc.person_id= person_dental.person_id
                                            WHERE person_dental.person_id is null and person_anc.discharge <>'Y') anc_dental on person_anc.person_id = anc_dental.person_id
                        where out_region = 'N'  
                        and concat(RIGHT((DATE_FORMAT(person_anc.anc_register_date ,'%Y') +543),2),DATE_FORMAT(person_anc.anc_register_date ,'%m') ) like'$vn4digit'


                        UNION

                         select 'AN9981' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9981'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC
                         FROM person_anc  
                         LEFT JOIN person on person_anc.person_id = person.person_id
                         where labor_date is not null and labor_status_id not in(1,4) 
                         and (SELECT concat(vstdate ,'::',icd10) from ovstdiag where vstdate > person_anc.labor_date  and ovstdiag.icd10 in('Z348','Z340','Z350','Z356','Z358','Z357')
                              and DATEDIFF(vstdate,person_anc.labor_date) < 30 and hn = person.patient_hn  limit 1) is not null 
                         and concat(RIGHT((DATE_FORMAT(person_anc.labor_date ,'%Y') +543),2),DATE_FORMAT(person_anc.labor_date ,'%m') ) like'$vn4digit'



                         UNION

                         select 'AN9982' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AN9982'  ) as 'ERROR_DETAIL' ,ifnull(count(*),0) as CC  
                        from person_anc ps_anc
                        left join patient on (select cid from person where person_id = ps_anc.person_id) = patient.cid
                        where   TIMESTAMPDIFF(week,ps_anc.lmp,CURDATE()) >42 and ps_anc.out_region ='N' and ps_anc.labor_status_id = '1' and ps_anc.discharge <> 'Y'  
                         

				 order by CC desc , ERROR_CODE ,ERROR_CODE";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = $result['CC'];
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='anc_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Anc_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>HN</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>DATEServ</th>
                                      <th>ครรภ์ที่</th>
                                      <th>อายุครรภ์(week)</th>
                                 </tr>

                                      ";
    $i = 0;

    if($error_code=='AN9903'){
        $query2 = mysql_query($sql1 . " like'$vn4digit%'  GROUP BY person_anc.person_id");
    }else{

        if($error_code=='AN9982'){
            $query2 = mysql_query($sql1);
        }else{

            $query2 = mysql_query($sql1 . " like'$vn4digit%'");
        }
    }

    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $person_id = $result['hn'];
        $cid = $result['cid'];
        $ancNo = $result['preg_no'];
        $anc_week = $result['pa_week'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$DATEServ</td>
                                      <td>$ancNo</td>
                                      <td align='center'>$anc_week</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}




function get_row_Fp_Error_all($vn4digit) {

    $sql = "select 'FP9241' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FP9241'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_women_service 
				left JOIN person_women  on person_women_service.person_women_id = person_women.person_women_id
				where person_women_service.women_service_id = 1 and  person_women.women_birth_control_id not in(select women_birth_control_id from women_birth_control)
				and  vn like'$vn4digit%'

				UNION
				select 'FP9242' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FP9242'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_women_service 
				left JOIN person_women  on person_women_service.person_women_id = person_women.person_women_id
				where person_women_service.women_service_id = 1 and  (person_women.women_birth_control_id is null or person_women.women_birth_control_id = '')
				and  vn like'$vn4digit%'

                UNION

                select 'FP9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FP9299'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
               from person_women 
                INNER  JOIN  (select person_women_id ,service_date,vn, count(vn) as CC_vn
                            from person_women_service
                            where women_service_id = 1
                            group by vn having count(vn)  > 1 ) person_women_chk on person_women.person_women_id = person_women_chk.person_women_id
                and  vn like'$vn4digit%'

				";



    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + $result['CC'];
    }
    return $CC;
}

function get_rows_Fp_Error_detail($vn4digit) {

    $sql = "select 'FP9241' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FP9241'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_women_service 
				left JOIN person_women  on person_women_service.person_women_id = person_women.person_women_id
				where person_women_service.women_service_id = 1 and  person_women.women_birth_control_id not in(select women_birth_control_id from women_birth_control)
				and  vn like'$vn4digit%'

				UNION
				select 'FP9242' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FP9242'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
				from person_women_service 
				left JOIN person_women  on person_women_service.person_women_id = person_women.person_women_id
				where person_women_service.women_service_id = 1 and  (person_women.women_birth_control_id is null or person_women.women_birth_control_id = '')
				and  vn like'$vn4digit%'

                UNION

                select 'FP9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FP9299'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC  
               from person_women 
                INNER  JOIN  (select person_women_id ,service_date,vn, count(vn) as CC_vn
                            from person_women_service
                            where women_service_id = 1
                            group by vn having count(vn)  > 1 ) person_women_chk on person_women.person_women_id = person_women_chk.person_women_id
                and  vn like'$vn4digit%'


				 order by CC desc , ERROR_CODE , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = $result['CC'];
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='fp_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Fp_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>HN</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>DATEServ</th>
                                      <th>เลขที่รับยริการ</th>
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1 . " and vn like'$vn4digit%'");
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $person_id = $result['hn'];
        $cid = $result['cid'];
        $service_id = $result['person_women_service_id'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$DATEServ</td>
                                      <td>$service_id</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Dental_Error_all($vn4digit) {

    $sql = "select 'DT1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DT1106'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from dental_care
				where  (dental_care_type_id not in(SELECT dental_care_type_id from dental_care_type) or dental_care_type_id is NULL or dental_care_type_id = '')
				 and vn like'$vn4digit%' 

				UNION
				select 'DT1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DT1107'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
				from dental_care
				where  (dental_care_service_place_type_id not in(SELECT dental_care_service_place_type_id from dental_care_service_place_type) or dental_care_service_place_type_id is NULL or dental_care_service_place_type_id = '')
				 and vn like'$vn4digit%' 
				  ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + $result['CC'];
    }
    return $CC;
}

function get_rows_Dental_Error_detail($vn4digit) {

    $sql = "select 'DT1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DT1106'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
					from dental_care
					where  (dental_care_type_id not in(SELECT dental_care_type_id from dental_care_type) or dental_care_type_id is NULL or dental_care_type_id = '')
					 and vn like'$vn4digit%' 

					UNION
					select 'DT1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DT1107'  ) as 'ERROR_DETAIL' ,ifnull(count(vn),0) as CC
					from dental_care
					where  (dental_care_service_place_type_id not in(SELECT dental_care_service_place_type_id from dental_care_service_place_type) or dental_care_service_place_type_id is NULL or dental_care_service_place_type_id = '')
					 and vn like'$vn4digit%'  
				 order by CC desc , ERROR_CODE , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = $result['CC'];
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='dental_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Dental_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>HN</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>DATEServ</th>
                                      
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1 . " and vn like'$vn4digit%'");
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $person_id = $result['hn'];
        $cid = $result['cid'];
        //$service_id = $result['person_women_service_id'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$DATEServ</td>
                                      
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Drug_opd_Error_all($vn4digit) {

    $sql = "select 'DO1101' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO1101'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(vn)),0) as CC
				from opitemrece 
				INNER  join drugitems on opitemrece.icode = drugitems.icode
				where opitemrece.vn like'$vn4digit%'  and drugitems.did is NULL 

				union

				select 'DO9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO9901'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(er_regist_oper.vn)),0) as CC
				  from er_regist_oper
				  left join ovst_vaccine on er_regist_oper.vn = ovst_vaccine.vn and ovst_vaccine.person_vaccine_id in('36','37','38','39','40') 
					left join ovst on er_regist_oper.vn = ovst.vn
				  left join opdscreen on er_regist_oper.vn = opdscreen.vn
				  left join opitemrece on er_regist_oper.vn = opitemrece.vn and opitemrece.icode = '1900423'
				   where er_oper_code ='178' and opitemrece.vn is null and er_regist_oper.vn like'$vn4digit%' 


				  union

				select 'DO9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO9902'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(er_regist_oper.vn)),0) as CC
				  from er_regist_oper 
				  left join ovst_vaccine on er_regist_oper.vn = ovst_vaccine.vn and ovst_vaccine.person_vaccine_id in('31','32','33','34','35')  
					left join ovst on er_regist_oper.vn = ovst.vn 
					left join patient on ovst.hn = patient.hn 
				  left join opdscreen on er_regist_oper.vn = opdscreen.vn 
				  left join opitemrece on er_regist_oper.vn = opitemrece.vn and opitemrece.icode = '1900485' 
				  left join drugitems on opitemrece.icode = drugitems.icode 
				   where er_oper_code ='176' and opitemrece.vn is null and er_regist_oper.vn like'$vn4digit%' 

				   union


					select 'DO9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO9903'  ) as 'ERROR_DETAIL' ,ifnull(count(distinct(er_regist_oper.vn)),0) as CC
					  from er_regist_oper 
						left join ovst on er_regist_oper.vn = ovst.vn 
						left join patient on ovst.hn = patient.hn 
					  left join opdscreen on er_regist_oper.vn = opdscreen.vn 
					   where er_oper_code ='22' and (select vn from opitemrece where vn = er_regist_oper.vn and opitemrece.icode in('1900435','1540004','1550009','1000010') limit 1 ) is null
							and ovst.an is null and er_regist_oper.vn like'$vn4digit%'


					UNION

				   select 'DO9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO9904'  ) as 'ERROR_DETAIL' ,ifnull(count(distinct(er_regist_oper.vn)),0) as CC	
				   FROM er_regist_oper 
				   left join opitemrece on er_regist_oper.vn = opitemrece.vn  and opitemrece.icode in(select icode from drugitems where dosageform like '%INJ%')
				   left join ovst on er_regist_oper.vn = ovst.vn  
				   left join patient on ovst.hn = patient.hn 
				   where  er_regist_oper.er_oper_code in(select er_oper_code from er_oper_code where NAME like'%ฉีด%') and ovst.an is null and opitemrece.vn is null 
				   and er_regist_oper.vn not in(SELECT vn from opdscreen where ((cc like'%stre%' or cc like'%ste%' or cc like'%hype%' or cc like'%levo%' or cc like'%มาเอง%') 
						or (hpi like'%stre%' or hpi like'%ste%' or hpi like'%hype%' or hpi like'%levo%'))  and opdscreen.vn = er_regist_oper.vn )  
					and er_regist_oper.vn  like'$vn4digit%'

				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + $result['CC'];
    }
    return $CC;
}

function get_rows_Drug_opd_Error_detail($vn4digit) {

    $sql = "select 'DO1101' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO1101'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(vn)),0) as CC
				from opitemrece 
				INNER  join drugitems on opitemrece.icode = drugitems.icode
				where opitemrece.vn like'$vn4digit%'  and drugitems.did is NULL 

				union

				select 'DO9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO9901'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(er_regist_oper.vn)),0) as CC
				  from er_regist_oper
				  left join ovst_vaccine on er_regist_oper.vn = ovst_vaccine.vn and ovst_vaccine.person_vaccine_id in('36','37','38','39','40') 
					left join ovst on er_regist_oper.vn = ovst.vn
				  left join opdscreen on er_regist_oper.vn = opdscreen.vn
				  left join opitemrece on er_regist_oper.vn = opitemrece.vn and opitemrece.icode = '1900423'
				   where er_oper_code ='178' and opitemrece.vn is null and er_regist_oper.vn like'$vn4digit%' 

				union
				  
				select 'DO9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO9902'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(er_regist_oper.vn)),0) as CC
				  from er_regist_oper 
				  left join ovst_vaccine on er_regist_oper.vn = ovst_vaccine.vn and ovst_vaccine.person_vaccine_id in('31','32','33','34','35')  
					left join ovst on er_regist_oper.vn = ovst.vn 
					left join patient on ovst.hn = patient.hn 
				  left join opdscreen on er_regist_oper.vn = opdscreen.vn 
				  left join opitemrece on er_regist_oper.vn = opitemrece.vn and opitemrece.icode = '1900485' 
				  left join drugitems on opitemrece.icode = drugitems.icode 
				   where er_oper_code ='176' and opitemrece.vn is null and er_regist_oper.vn like'$vn4digit%' 
				 

				   union


					select 'DO9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO9903'  ) as 'ERROR_DETAIL' ,ifnull(count(distinct(er_regist_oper.vn)),0) as CC
					  from er_regist_oper 
						left join ovst on er_regist_oper.vn = ovst.vn 
						left join patient on ovst.hn = patient.hn 
					  left join opdscreen on er_regist_oper.vn = opdscreen.vn 
					   where er_oper_code ='22' and (select vn from opitemrece where vn = er_regist_oper.vn and opitemrece.icode in('1900435','1540004','1550009') limit 1 ) is null
							and ovst.an is null and er_regist_oper.vn like'$vn4digit%' 


					UNION

				   select 'DO9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DO9904'  ) as 'ERROR_DETAIL' ,ifnull(count(distinct(er_regist_oper.vn)),0) as CC	
				   FROM er_regist_oper 
				   left join opitemrece on er_regist_oper.vn = opitemrece.vn  and opitemrece.icode in(select icode from drugitems where dosageform like '%INJ%')
				   left join ovst on er_regist_oper.vn = ovst.vn  
				   left join patient on ovst.hn = patient.hn 
				   where  er_regist_oper.er_oper_code in(select er_oper_code from er_oper_code where NAME like'%ฉีด%') and ovst.an is null and opitemrece.vn is null 
				   and er_regist_oper.vn not in(SELECT vn from opdscreen where ((cc like'%stre%' or cc like'%ste%' or cc like'%hype%' or cc like'%levo%' or cc like'%มาเอง%') 
						or (hpi like'%stre%' or hpi like'%ste%' or hpi like'%hype%' or hpi like'%levo%'))  and opdscreen.vn = er_regist_oper.vn )  
					and er_regist_oper.vn  like'$vn4digit%'

				 order by CC desc , ERROR_CODE , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = $result['CC'];
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='drug-opd_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Drug_opd_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>HN</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>วันที่รับบริการ</th>
                                      <th>เวลารับบริการ</th>
                                      <th>GenericName</th>
                                      <th>ICODE</th>
                                      
                                 </tr>

                                      ";
    $i = 0;

    if ($error_code == 'DO9901') {
        $query2 = mysql_query($sql1 . " and er_regist_oper.vn like'$vn4digit%'");
    } else {
        if ($error_code == 'DO9902') {
            $query2 = mysql_query($sql1 . " and er_regist_oper.vn like'$vn4digit%'");
        } else {

            if ($error_code == 'DO9903') {
                $query2 = mysql_query($sql1 . " and er_regist_oper.vn like'$vn4digit%'  group by er_regist_oper.vn");
            } else {

                if ($error_code == 'DO9904') {
                    $query2 = mysql_query($sql1 . " and er_regist_oper.vn like'$vn4digit%'  group by er_regist_oper.vn");
                } else {

                    $query2 = mysql_query($sql1 . " and opitemrece.vn like'$vn4digit%'");
                }
            }
        }
    }

    //echo $sql1;

    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $TimeServ = $result['vsttime'];
        $person_id = $result['hn'];
        $cid = $result['cid'];
        $genericName = $result['generic_name'];
        $icode = $result['icode'];
        //$service_id = $result['person_women_service_id'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$DATEServ</td>
                                      <td>$TimeServ</td>
                                      <td>$genericName</td>
                                      <td>$icode</td>
                                      
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Admission_Error_all($vn4digit) {

    $sql = "select 'AM9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM9299'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ovst.an)),0) as CC
				from ovst
				INNER JOIN (SELECT an from ovst 
				where (an is NOT NULL or an <>'') 
				GROUP BY an 
				HAVING count(an) > 1 ) sel_an on ovst.an = sel_an.an
				where ovst.vn LIKE'$vn4digit%'

				union


				select 'AM1101' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM1101'  ) as 'ERROR_DETAIL' ,  ifnull(count(an),0) as CC 
				from ipt 
				where  regdate >= dchdate and regtime >= dchtime and vn like'$vn4digit%'

				union

				select 'AM9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ovst.an)),0) as CC
				from ovst
				INNER JOIN (SELECT an from ovst where (an is  NULL or an ='')  ) sel_an on ovst.an = sel_an.an
				where ovst.vn LIKE'$vn4digit%'

				union

				select 'AM9101' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM9101'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC	
				from ipt 
				inner join an_stat on ipt.an = an_stat.an
				where  an_stat.pdx  = '' and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0')  )like'$vn4digit%'   

				UNION

				select 'AM2115' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM2115'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC	
				from ipt 
				inner join an_stat on ipt.an = an_stat.an
				where  (ipt.dchstts is null or ipt.dchstts = '' or ipt.dchstts not in(SELECT dchstts from dchstts)) and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%'   


				UNION

				select 'AM2114' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM2114'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC	
				from ipt 
			  		inner join an_stat on ipt.an = an_stat.an
				where  (ipt.dchtype is null or ipt.dchtype = '' or ipt.dchtype not in(SELECT dchtype from dchtype)) and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%'   


                  UNION 

                select 'AM1200' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM1200'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC
                from ipt  
                left join patient on  ipt.hn = patient.hn 
                where  (bw = '' or bw is null) and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%' 

                UNION 

                select 'AM1201' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM1201'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC
                from ipt  
                left join patient on  ipt.hn = patient.hn 
                where (body_height = '' or body_height is null) and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%'  

                UNION

                select 'AM2113' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM2113'  ) as 'ERROR_DETAIL' ,  ifnull(count((ipt.an)),0) as CC
                from ipt  
                left join patient on  ipt.hn = patient.hn 
                INNER JOIN referout on ipt.an = referout.vn 
                where (rfrolct <> '' or rfrolct is not null) and dchtype <> '04' and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%'   

               
                UNION

                select 'AM2112' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM2112'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC
                from ipt  
                left join patient on  ipt.hn = patient.hn 
                left JOIN referout on ipt.an = referout.vn
                where (ipt.dchtype in('04','04')) and referout.refer_number is null and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%' 


    


				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_Admission_Error_detail($vn4digit) {

    $sql = "select 'AM9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM9299'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ovst.an)),0) as CC
				from ovst
				INNER JOIN (SELECT an from ovst 
				where an is NOT NULL 
				GROUP BY an 
				HAVING count(an) > 1 ) sel_an on ovst.an = sel_an.an
				where ovst.vn LIKE'$vn4digit%'
				
				union
				select 'AM1101' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM1101'  ) as 'ERROR_DETAIL' ,  ifnull(count(an),0) as CC 
				from ipt 
				where  regdate >= dchdate and regtime >= dchtime and vn like'$vn4digit%'


				union
                
				select 'AM9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ovst.an)),0) as CC
				from ovst
				INNER  JOIN (SELECT an from ovst where (an is  NULL or an ='')  ) sel_an on ovst.an = sel_an.an
				where ovst.vn LIKE'$vn4digit%'

				union

				select 'AM9101' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM9101'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC	
				from ipt 
				inner join an_stat on ipt.an = an_stat.an
				where  an_stat.pdx  = '' and  concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0')) like'$vn4digit%'   


				UNION

				select 'AM2115' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM2115'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC	
				from ipt 
				inner join an_stat on ipt.an = an_stat.an
				where  (ipt.dchstts is null or ipt.dchstts = '' or ipt.dchstts not in(SELECT dchstts from dchstts)) and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%'   


				UNION

				select 'AM2114' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM2114'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC	
				from ipt 
			  		inner join an_stat on ipt.an = an_stat.an
				where  (ipt.dchtype is null or ipt.dchtype = '' or ipt.dchtype not in(SELECT dchtype from dchtype)) and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%'   

                  UNION 

                select 'AM1200' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM1200'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC
                from ipt  
                left join patient on  ipt.hn = patient.hn 
                where  (bw = '' or bw is null) and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%' 

                UNION 

                select 'AM1201' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM1201'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC
                from ipt  
                left join patient on  ipt.hn = patient.hn 
                where (body_height = '' or body_height is null) and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%'  

                UNION

                select 'AM2113' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM2113'  ) as 'ERROR_DETAIL' ,  ifnull(count((ipt.an)),0) as CC
                from ipt  
                left join patient on  ipt.hn = patient.hn 
                INNER JOIN referout on ipt.an = referout.vn 
                where (rfrolct <> '' or rfrolct is not null) and dchtype <> '04' and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%'   

               
                UNION

                select 'AM2112' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AM2112'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ipt.an)),0) as CC
                from ipt  
                left join patient on  ipt.hn = patient.hn 
                left JOIN referout on ipt.an = referout.vn
                where (ipt.dchtype in('04','04')) and referout.refer_number is null and concat(mid((year(ipt.dchdate)+543),3,2),LPAD(month(ipt.dchdate),2,'0'))like'$vn4digit%'   




				 order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='admission_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Admission_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>AN</th>                                      
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>HN</th>
                                      <th>DATEServ</th>
                                      <th>TIMEServ</th>
                                      
                                      
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1 . " like'$vn4digit%'");
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $person_id = $result['hn'];
        $cid = $result['cid'];
        $an = $result['an'];
        $TIMEServ = $result['vsttime'];
        //$service_id = $result['person_women_service_id'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$an</td>                                       
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$person_id</td>
                                      <td>$DATEServ</td>
                                      <td>$TIMEServ</td>                                   
                                      
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Labour_Error_all($vn4digit) {

    $sql = "select 'LB1105' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB1105'  ) as 'ERROR_DETAIL' ,  ifnull(count(ipt.an),0) as CC
				from ipt_labour
				left join ipt on ipt_labour.an = ipt.an 
				where ipt.vn like'$vn4digit%' and (ipt_labour.lmp is null or ipt_labour.lmp = '') and ipt.an in (select an from labor )  and ipt.ipt_type = 4 

				union

				select 'LB9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(ipt_newborn.an),0) as CC
				 from ipt_newborn  
				 left join ipt on ipt_newborn.an = ipt.an  
				 left join patient on  ipt.hn = patient.hn 
				where (ipt_newborn.mother_an is null or ipt_newborn.mother_an = '') and ipt.vn like'$vn4digit%'

				union
				 select 'LB9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(ipt.an),0) as CC
				 from ipt_newborn  
				 left join ipt on ipt_newborn.an = ipt.an  
				 left join patient on  ipt.hn = patient.hn  
				 where (ipt_newborn.born_date is null or ipt_newborn.born_date = '') and ipt.vn like'$vn4digit%'

				 union

				 select 'LB1108' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB1108'  ) as 'ERROR_DETAIL' ,  ifnull(count( DISTINCT person_anc.person_id),0) as CC
				FROM person_anc
				left join person_anc_service on person_anc.person_anc_id = person_anc_service.person_anc_id
				where ( person_anc.labor_place_id is null  or person_anc.labor_place_id ='' or person_anc.labor_place_id not in(select person_labour_place.person_labor_place_id from person_labour_place))  
				and person_anc.labor_status_id = 2 and person_anc.out_region = 'N'  and person_anc_service.vn like'$vn4digit%'

				UNION

				select 'LB9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB9903'  ) as 'ERROR_DETAIL' ,  ifnull(count( DISTINCT person_anc.person_id),0) as CC
				   FROM person_anc
					left join person_anc_service on person_anc.person_anc_id = person_anc_service.person_anc_id
				  left join person on person_anc.person_id = person.person_id
					where person_anc.labor_date is not null and person_anc.labor_status_id = 1   and person_anc.out_region = 'N'  and person_anc_service.vn like'$vn4digit%'

                UNION

                select 'LB9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB9904'  ) as 'ERROR_DETAIL' ,  ifnull(count( DISTINCT ipt_pregnancy.an),0) as CC
                    from ipt_pregnancy 
                    left JOIN (SELECT mother_an as an,count(an) as CC , an as child_an 
                    from ipt_newborn
                    GROUP BY mother_an) chilcount on ipt_pregnancy.an = chilcount.an
                    left join ipt on ipt_pregnancy.an = ipt.an
                    where ipt_pregnancy.child_count <> chilcount.CC and ipt.vn like'$vn4digit%' 


              UNION

                select 'LB1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB1107'  ) as 'ERROR_DETAIL' ,  count(*) as CC
                    from person_anc 
                    left join person on person_anc.person_id = person.person_id 
                   where person_anc.labor_icd10 is null  and person_anc.labor_status_id = 2 
                   and CONCAT(SUBSTR(((year(person_anc.labor_date))+543),3,2),if(LENGTH(MONTH( person_anc.labor_date))=1,concat('0',MONTH( person_anc.labor_date)),MONTH( person_anc.labor_date)))  like'$vn4digit%' 

				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_Labour_Error_detail($vn4digit) {

    $sql = "select 'LB1105' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB1105'  ) as 'ERROR_DETAIL' ,  ifnull(count(ipt.an),0) as CC
				from ipt_labour
				left join ipt on ipt_labour.an = ipt.an 
				where ipt.vn like'$vn4digit%' and (ipt_labour.lmp is null or ipt_labour.lmp = '') and ipt.an in (select an from labor )  and ipt.ipt_type = 4 

				union

				select 'LB9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(ipt.an),0) as CC
				 from ipt_newborn  
				 left join ipt on ipt_newborn.an = ipt.an  
				 left join patient on  ipt.hn = patient.hn  
				 where (ipt_newborn.mother_an is null or ipt_newborn.mother_an = '') and ipt.vn like'$vn4digit%'

				 union
				 select 'LB9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(ipt.an),0) as CC
				 from ipt_newborn  
				 left join ipt on ipt_newborn.an = ipt.an  
				 left join patient on  ipt.hn = patient.hn  
				 where (ipt_newborn.born_date is null or ipt_newborn.born_date = '') and ipt.vn like'$vn4digit%'

				 union

				 select 'LB1108' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB1108'  ) as 'ERROR_DETAIL' ,  ifnull(count( DISTINCT person_anc.person_id),0) as CC
				FROM person_anc
				left join person_anc_service on person_anc.person_anc_id = person_anc_service.person_anc_id
				where ( person_anc.labor_place_id is null  or person_anc.labor_place_id ='' or person_anc.labor_place_id not in(select person_labour_place.person_labor_place_id from person_labour_place))  
				and person_anc.labor_status_id = 2 and person_anc.out_region = 'N'  and person_anc_service.vn like'$vn4digit%'

				
				UNION

				select 'LB9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB9903'  ) as 'ERROR_DETAIL' ,  ifnull(count( DISTINCT person_anc.person_id),0) as CC
				   FROM person_anc
					left join person_anc_service on person_anc.person_anc_id = person_anc_service.person_anc_id
				  left join person on person_anc.person_id = person.person_id
					where person_anc.labor_date is not null and person_anc.labor_status_id = 1   and person_anc.out_region = 'N'  and person_anc_service.vn like'$vn4digit%'


                UNION

                select 'LB9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB9904'  ) as 'ERROR_DETAIL' ,  ifnull(count( DISTINCT ipt_pregnancy.an),0) as CC
                    from ipt_pregnancy 
                    left JOIN (SELECT mother_an as an,count(an) as CC , an as child_an 
                    from ipt_newborn
                    GROUP BY mother_an) chilcount on ipt_pregnancy.an = chilcount.an
                    left join ipt on ipt_pregnancy.an = ipt.an
                    where ipt_pregnancy.child_count <> chilcount.CC and ipt.vn like'$vn4digit%' 



              UNION

                select 'LB1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LB1107'  ) as 'ERROR_DETAIL' ,  count(*) as CC
                    from person_anc 
                    left join person on person_anc.person_id = person.person_id 
                   where person_anc.labor_icd10 is null  and person_anc.labor_status_id = 2 
                   and CONCAT(SUBSTR(((year(person_anc.labor_date))+543),3,2),if(LENGTH(MONTH( person_anc.labor_date))=1,concat('0',MONTH( person_anc.labor_date)),MONTH( person_anc.labor_date)))  like'$vn4digit%' 



				 order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='labour_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Labour_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>AN</th> 
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>HN</th>
                                      <th>Admit/Labor Date</th>
                                      <th>AdmitTime</th>
                                      <th>ครรภ์ที่</th>
                                      
                                 </tr>

                                      ";
    $i = 0;

    if ($error_code == "LB1108") {
        $query2 = mysql_query($sql1 . " and person_anc_service.vn like'$vn4digit%'  group by person_anc.person_id   ");
    } else {

        if ($error_code == "LB9903") {
            $query2 = mysql_query($sql1 . " and person_anc_service.vn like'$vn4digit%'  group by person_anc.person_id   ");
        } else {

            if($error_code == "LB1107"){
                $query2 = mysql_query($sql1 . " '$vn4digit%'");
            }else{
                    $query2 = mysql_query($sql1 . " and ipt.vn like'$vn4digit%'");
            }
        }
    }
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $hn = $result['hn'];
        $cid = $result['cid'];
        $an = $result['an'];
        $TIMEServ = $result['vsttime'];
        $preg_no = $result['preg_no'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$an</td>                                       
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$hn</td>
                                      <td>$DATEServ</td>
                                      <td>$TIMEServ</td>   
                                      <td>$preg_no</td>                                  
                                      
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Newborn_Error_all($vn4digit) {

    $date_stage_ment = get_month_stagement($vn4digit);

    $sql = "select 'NB1104' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1104'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_wbc
				left JOIN person on person_wbc.person_id = person.person_id
				LEFT JOIN person_labour on person.person_id = person_labour.person_id
				where (person.mother_person_id is null or person.mother_person_id = '') and 
				CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date))) 
				  like'$vn4digit%' 

				 UNION


				select 'NB1116' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1116'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.has_vitk is null or person_labour.has_vitk = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))   like'$vn4digit%' 

				 UNION

				 select 'NB1117' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1117'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.thyroid_result is null or person_labour.thyroid_result = '' or person_labour.thyroid_result not in(1,2,9) ) and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%' 

				 UNION

				 select 'NB1102' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1102'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.person_labour_doctor_type_id is null or person_labour.person_labour_doctor_type_id = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'

				 UNION

				 select 'NB1105' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1105'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.person_labour_type_id is null or person_labour.person_labour_type_id = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))   like'$vn4digit%'

				 UNION

				 select 'NB1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1106'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.person_labour_place_id is null or person_labour.person_labour_place_id = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'


				 UNION

				 select 'NB1108' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1108'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.person_labour_birth_no_id is null or person_labour.person_labour_birth_no_id = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'

				 UNION

				select 'NB9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB9901'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
				from person_wbc 
				left join person on person_wbc.person_id = person.person_id 
				LEFT JOIN person_labour on person.person_id = person_labour.person_id
				left join person_anc on person.mother_person_id  = person_anc.person_id
				where  person_wbc.force_complete_date is null and person_anc.out_region ='N'    and person.birthdate BETWEEN $date_stage_ment  

				UNION

                select 'NB9990' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB9990'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
                from person_wbc
                left JOIN person on person_wbc.person_id = person.person_id
                LEFT JOIN person_labour on person.person_id = person_labour.person_id
                where   
                CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'
                and (
                             person.birthdate < (case when MONTH(force_complete_date) <= 9 THEN
                                                     (concat((year(force_complete_date)-1),'-10-01'))
                                                            else (concat(year(force_complete_date),'-10-01')) end )  
                            or
                                person.birthdate > (case when MONTH(force_complete_date) <= 9 THEN
                                                     (concat(year(force_complete_date),'-09-30' ))
                                                            else (concat((year(force_complete_date)+1) ,'-09-30' )) end )  
                        )

                UNION

				select 'NB1109' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1109'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.gravida is null or person_labour.gravida = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'



				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_Newborn_Error_detail($vn4digit) {
    $date_stage_ment = get_month_stagement($vn4digit);
    $sql = "select 'NB1104' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1104'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_wbc
				left JOIN person on person_wbc.person_id = person.person_id
				LEFT JOIN person_labour on person.person_id = person_labour.person_id
				where (person.mother_person_id is null or person.mother_person_id = '') and 
				CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%' 

				 UNION


				select 'NB1116' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1116'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.has_vitk is null or person_labour.has_vitk = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%' 
				
				 UNION
				 
				 select 'NB1117' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1117'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.thyroid_result is null or person_labour.thyroid_result = '' or person_labour.thyroid_result not in(1,2,9) ) and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%' 


				 UNION

				 select 'NB1102' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1102'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.person_labour_doctor_type_id is null or person_labour.person_labour_doctor_type_id = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'
	
				 UNION

				 select 'NB1105' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1105'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.person_labour_type_id is null or person_labour.person_labour_type_id = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))   like'$vn4digit%'


				 UNION

				 select 'NB1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1106'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.person_labour_place_id is null or person_labour.person_labour_place_id = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'


				 UNION

				 select 'NB1108' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1108'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.person_labour_birth_no_id is null or person_labour.person_labour_birth_no_id = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'


				 UNION

				select 'NB9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
				from person_wbc 
				left join person on person_wbc.person_id = person.person_id 
				LEFT JOIN person_labour on person.person_id = person_labour.person_id
				left join person_anc on person.mother_person_id  = person_anc.person_id
				where  person_wbc.force_complete_date is null and person_anc.out_region ='N'    and person.birthdate BETWEEN $date_stage_ment  

                 UNION

                select 'NB9990' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB9990'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
                from person_wbc
                left JOIN person on person_wbc.person_id = person.person_id
                LEFT JOIN person_labour on person.person_id = person_labour.person_id
                where   
                CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'
                and (
                             person.birthdate < (case when MONTH(force_complete_date) <= 9 THEN
                                                     (concat((year(force_complete_date)-1),'-10-01'))
                                                            else (concat(year(force_complete_date),'-10-01')) end )  
                            or
                                person.birthdate > (case when MONTH(force_complete_date) <= 9 THEN
                                                     (concat(year(force_complete_date),'-09-30' ))
                                                            else (concat((year(force_complete_date)+1) ,'-09-30' )) end )  
                        )

				

                UNION
				
				select 'NB1109' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NB1109'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
				 from person_wbc
				 left JOIN person on person_wbc.person_id = person.person_id
				 LEFT JOIN person_labour on person.person_id = person_labour.person_id
				 where (person_labour.gravida is null or person_labour.gravida = '') and 
				 CONCAT(SUBSTR(((year(force_complete_date))+543),3,2),if(LENGTH(MONTH(force_complete_date))=1,concat('0',MONTH(force_complete_date)),MONTH(force_complete_date)))  like'$vn4digit%'




				 order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='newborn_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Newborn_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th> 
                                      <th>PID</th>                                     
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>                                      
                                      <th>BirthDate</th>
                                      <th>BirthTime</th>
                                      
                                      
                                 </tr>

                                      ";
    $i = 0;


    if ($error_code == "NB9901") {
        $query2 = mysql_query($sql1 . get_month_stagement($vn4digit) . "   group by person_wbc.person_id") or die(mysql_error());
    } else {

        if($error_code == "NB9299"){

         $query2 = mysql_query($sql1) or die(mysql_error()); 

        }else{

         $query2 = mysql_query($sql1 . "  like'$vn4digit%'") or die(mysql_error());           
        }


    }



    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $birthdate = get_date_show($result['birthdate']);
        $PID = $result['person_id'];
        $cid = $result['cid'];
        //$an  = $result['an'];
        $birthtime = $result['birthtime'];
        //$service_id = $result['person_women_service_id'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td >$i</td>
                                      <td>$PID</td>                                                 
                                      <td>$ptname </td>
                                      <td>$cid</td>                                      
                                      <td>$birthdate</td>
                                      <td>$birthtime</td>                                   
                                      
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_NewbornCare_Error_all($vn4digit) {

    $date_stage_ment = get_month_stagement($vn4digit);
    $sql = "select 'NE1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE1106'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where (person_wbc_post_care.person_wbc_post_care_result_type_id is null or person_wbc_post_care.person_wbc_post_care_result_type_id = '' or 
				       person_wbc_post_care.person_wbc_post_care_result_type_id not in(select person_wbc_post_care_result_type_id from person_wbc_post_care_result_type))
				and  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'

				UNION

				select 'NE1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE1107'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where (person_wbc_post_care.person_nutrition_food_type_id is null or person_wbc_post_care.person_nutrition_food_type_id = '' or 
				       person_wbc_post_care.person_nutrition_food_type_id not in(select person_nutrition_food_type_id from person_nutrition_food_type))
				and  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'

				UNION

				select 'NE1102' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE1102'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where (person_wbc_post_care.care_number is null or person_wbc_post_care.care_number = '' )
				and  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'


				UNION

				select 'NE1105' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE1105'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where (person_wbc_post_care.care_date is null or person_wbc_post_care.care_date = '' )
				and  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'

				UNION

				select 'NE9290' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9290'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				 from person_wbc_post_care
						left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
						where  (person.house_id <> 1 or person.house_regist_type_id in(1,3))  and person.birthdate BETWEEN  $date_stage_ment
				    and (case when (person_wbc_post_care.care_number = 1 and DATEDIFF(person_wbc_post_care.care_date,person.birthdate)  between 0 and 7) then 'OK' 
							when (person_wbc_post_care.care_number = 2 and DATEDIFF(person_wbc_post_care.care_date,person.birthdate)  between 8 and 15) then 'OK'  
							when (person_wbc_post_care.care_number = 3 and DATEDIFF(person_wbc_post_care.care_date,person.birthdate)  between 16 and 42) then 'OK' ELSE 
				'NG' END ) = 'NG'


				UNION

				select 'NE9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc 
				left join person on person_wbc.person_id = person.person_id
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person.birthdate) > 0 and baby_service1_date is null
				and DATEDIFF(person_wbc.person_wbc_regdate,person.birthdate) < 8  
				and  person.birthdate BETWEEN  $date_stage_ment

				UNION

				select 'NE9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc 
				left join person on person_wbc.person_id = person.person_id
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person.birthdate) > 7 and baby_service2_date is null
				and DATEDIFF(person_wbc.person_wbc_regdate,person.birthdate) < 16   
				and  person.birthdate  BETWEEN $date_stage_ment

				UNION
				
				select 'NE9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc 
				left join person on person_wbc.person_id = person.person_id
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person.birthdate) > 15 and baby_service3_date is null
				and DATEDIFF(person_wbc.person_wbc_regdate,person.birthdate) < 43  
				and  person.birthdate  BETWEEN $date_stage_ment

				UNION
				
				select 'NE9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9299'  ) as 'ERROR_DETAIL' ,   ifnull((count(person.person_id) / 2),0) as CC 			 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'
				GROUP BY concat(person_wbc_id,care_number) HAVING  ifnull(count(person.person_id),0) > 1


				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_NewbornCare_Error_detail($vn4digit) {

    $date_stage_ment = get_month_stagement($vn4digit);
    //echo $date_stage_ment;
    $sql = "select 'NE1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE1106'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where (person_wbc_post_care.person_wbc_post_care_result_type_id is null or person_wbc_post_care.person_wbc_post_care_result_type_id = '' or 
				       person_wbc_post_care.person_wbc_post_care_result_type_id not in(select person_wbc_post_care_result_type_id from person_wbc_post_care_result_type))
				and  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'

				UNION

				select 'NE1107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE1107'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where (person_wbc_post_care.person_nutrition_food_type_id is null or person_wbc_post_care.person_nutrition_food_type_id = '' or 
				       person_wbc_post_care.person_nutrition_food_type_id not in(select person_nutrition_food_type_id from person_nutrition_food_type))
				and  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'

				UNION

				select 'NE1102' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE1102'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where (person_wbc_post_care.care_number is null or person_wbc_post_care.care_number = '' )
				and  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'


				UNION

				select 'NE1105' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE1105'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where (person_wbc_post_care.care_date is null or person_wbc_post_care.care_date = '' )
				and  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'

				UNION

				select 'NE9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc 
				left join person on person_wbc.person_id = person.person_id
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person.birthdate) > 0 and baby_service1_date is null
				and DATEDIFF(person_wbc.person_wbc_regdate,person.birthdate) < 8 
				and  person.birthdate BETWEEN  $date_stage_ment

				UNION

				select 'NE9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc 
				left join person on person_wbc.person_id = person.person_id
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person.birthdate) > 7 and baby_service2_date is null
				and DATEDIFF(person_wbc.person_wbc_regdate,person.birthdate) < 16 
				and  person.birthdate  BETWEEN $date_stage_ment


				UNION

				select 'NE9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				from person_wbc 
				left join person on person_wbc.person_id = person.person_id
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person.birthdate) > 15 and baby_service3_date is null
				and DATEDIFF(person_wbc.person_wbc_regdate,person.birthdate) < 43  
				and  person.birthdate  BETWEEN $date_stage_ment

				UNION

				select 'NE9290' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9290'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 				 
				 from person_wbc_post_care
						left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
						where  (person.house_id <> 1 or person.house_regist_type_id in(1,3))  and person.birthdate BETWEEN  $date_stage_ment
				    and (case when (person_wbc_post_care.care_number = 1 and DATEDIFF(person_wbc_post_care.care_date,person.birthdate)  between 0 and 7) then 'OK' 
							when (person_wbc_post_care.care_number = 2 and DATEDIFF(person_wbc_post_care.care_date,person.birthdate)  between 8 and 15) then 'OK'  
							when (person_wbc_post_care.care_number = 3 and DATEDIFF(person_wbc_post_care.care_date,person.birthdate)  between 16 and 42) then 'OK' ELSE 
				'NG' END ) = 'NG'

				UNION

				select 'NE9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NE9299'  ) as 'ERROR_DETAIL' ,   ifnull((count(person.person_id)  / 2),0) as CC 				 
				from person_wbc_post_care
				left join person on (select person_id from person_wbc where  person_wbc.person_wbc_id = person_wbc_post_care.person_wbc_id limit 1) = person.person_id
				where  CONCAT(SUBSTR(((year(care_date))+543),3,2),if(LENGTH(MONTH(care_date))=1,concat('0',MONTH(care_date)),MONTH(care_date))) like'$vn4digit%'
				GROUP BY concat(person_wbc_id,care_number) HAVING  ifnull(count(person.person_id),0) > 1


				 order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='newborn_care_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_NewbornCare_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th> 
                                      <th>PID</th>                                     
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>                                      
                                      <th>วันที่คลอด</th>
                                      <th>เวลาคลอด</th>
                                      <th>ครั้งที่เยี่ยม</th>                                      
                                      <th>วันที่เยียม</th>
                                      <th>นับวันเยี่ยม</th>
                                      <th>อายุ(วัน)</th>
                                      <th>ช่วงที่ควรบันทึก</th>
                                      
                                 </tr>

                                      ";
    $i = 0;

    if ($error_code == "NE9299") {
        $query2 = mysql_query($sql1 . "  like'$vn4digit%'  GROUP BY concat(person_wbc_id,care_number) HAVING  ifnull(count(person.person_id),0) > 1");
    } else {

        if ($error_code == "NE9290") {

            $query2 = mysql_query($sql1 . get_month_stagement($vn4digit));
        } else {

            if ($error_code == "NE9901") {
                $query2 = mysql_query($sql1 . get_month_stagement($vn4digit));
            } else {

                if ($error_code == "NE9902") {
                    $query2 = mysql_query($sql1 . get_month_stagement($vn4digit));
                } else {

                    if ($error_code == "NE9903") {
                        $query2 = mysql_query($sql1 . get_month_stagement($vn4digit));
                    } else {

                        $query2 = mysql_query($sql1 . "  like'$vn4digit%'");
                    }
                }
            }
        }
    }

    //echo $query2;
    $rows = mysql_num_rows($query2) or die(mysql_error());
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $birthdate = get_date_show($result['birthdate']);
        $PID = $result['person_id'];
        $cid = $result['cid'];
        $vstdate = get_date_show($result['vstdate']);
        $care_number = $result['care_number'];
        $birthtime = $result['birthtime'];
        $date_CC = $result['day_cc'];
        $date_labor = $result['day_labor'];
        $start_date =  get_date_show($result['@start_date']);
        $end_date =  get_date_show($result['@end_date']);
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td >$i</td>
                                      <td>$PID</td>                                                 
                                      <td>$ptname </td>
                                      <td>$cid</td>                                      
                                      <td>$birthdate</td>
                                      <td>$birthtime</td>  
                                      <td>$care_number</td>                                        
                                      <td>$vstdate</td>  
                                      <td>$date_CC</td>   
                                      <td>$date_labor</td>                               
                                      <td>[$start_date ถึง $end_date]</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Postnatal_Error_all($vn4digit) {

    $date_stage_ment = get_month_stagement($vn4digit);
    $sql = "select 'PO1105' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO1105'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc_preg_care
				left join person_anc on person_anc_preg_care.person_anc_id = person_anc.person_anc_id
				LEFT JOIN person on person_anc.person_id = person.person_id
				 where (person_anc.labor_date is null or person_anc.labor_date = '') and vn like'$vn4digit%' 

				UNION

				select 'PO1104' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO1104'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc_preg_care
				left join person_anc on person_anc_preg_care.person_anc_id = person_anc.person_anc_id
				LEFT JOIN person on person_anc.person_id = person.person_id
				 where (person_anc.preg_no is null or person_anc.preg_no = '') and vn like'$vn4digit%' 


				 UNION

				 select 'PO9290' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9290'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_anc_preg_care
				left join person_anc on person_anc_preg_care.person_anc_id = person_anc.person_anc_id
				LEFT JOIN person on person_anc.person_id = person.person_id
				where (case when (person_anc_preg_care.preg_care_number = 1 and DATEDIFF(person_anc_preg_care.care_date,person_anc.labor_date)  between 0 and 7) then 'OK' 
							when (person_anc_preg_care.preg_care_number = 2 and DATEDIFF(person_anc_preg_care.care_date,person_anc.labor_date)  between 8 and 15) then 'OK'  
							when (person_anc_preg_care.preg_care_number = 3 and DATEDIFF(person_anc_preg_care.care_date,person_anc.labor_date)  between 16 and 42) then 'OK' ELSE 
				'NG' END ) = 'NG' and person_anc.labor_date BETWEEN $date_stage_ment

				UNION

				select 'PO9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc 
				left join person on person_anc.person_id = person.person_id		
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person_anc.labor_date)> 0 and person_anc.post_labor_service1_date is null
				and DATEDIFF(person_anc.anc_register_date,person_anc.labor_date) <  8  and person_anc.labor_status_id = 2
				and person_anc.labor_date  BETWEEN  $date_stage_ment

				UNION

				select 'PO9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc 
				left join person on person_anc.person_id = person.person_id		
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person_anc.labor_date) > 7 and person_anc.post_labor_service2_date is null
				and DATEDIFF(person_anc.anc_register_date,person_anc.labor_date) <  16 and person_anc.labor_status_id = 2
				and person_anc.labor_date  BETWEEN  $date_stage_ment



				UNION
				
				select 'PO9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc 
				left join person on person_anc.person_id = person.person_id		
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person_anc.labor_date)> 15 and person_anc.post_labor_service3_date is null
				and DATEDIFF(person_anc.anc_register_date,person_anc.labor_date) <  43 and person_anc.labor_status_id = 2
				and person_anc.labor_date  BETWEEN  $date_stage_ment

                UNION
                
                select 'PO9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9904'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                from person_anc 
                left join person on person_anc.person_id = person.person_id             
                where person_anc.labor_icd10 not BETWEEN 'O80%' and 'O84%' and person_anc.labor_status_id = 2
                and  person_anc.labor_date  BETWEEN  $date_stage_ment



				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_Postnatal_Error_detail($vn4digit) {

    $date_stage_ment = get_month_stagement($vn4digit);
    $sql = "select 'PO1105' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO1105'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc_preg_care
				left join person_anc on person_anc_preg_care.person_anc_id = person_anc.person_anc_id
				LEFT JOIN person on person_anc.person_id = person.person_id
				 where (person_anc.labor_date is null or person_anc.labor_date = '') and vn like'$vn4digit%' 

				UNION

				select 'PO1104' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO1104'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc_preg_care
				left join person_anc on person_anc_preg_care.person_anc_id = person_anc.person_anc_id
				LEFT JOIN person on person_anc.person_id = person.person_id
				 where (person_anc.preg_no is null or person_anc.preg_no = '') and vn like'$vn4digit%' 


				 UNION
				 select 'PO9290' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9290'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				 from person_anc_preg_care
				left join person_anc on person_anc_preg_care.person_anc_id = person_anc.person_anc_id
				LEFT JOIN person on person_anc.person_id = person.person_id
				where (case when (person_anc_preg_care.preg_care_number = 1 and DATEDIFF(person_anc_preg_care.care_date,person_anc.labor_date)  between 0 and 7) then 'OK' 
							when (person_anc_preg_care.preg_care_number = 2 and DATEDIFF(person_anc_preg_care.care_date,person_anc.labor_date)  between 8 and 15) then 'OK'  
							when (person_anc_preg_care.preg_care_number = 3 and DATEDIFF(person_anc_preg_care.care_date,person_anc.labor_date)  between 16 and 42) then 'OK' ELSE 
				'NG' END ) = 'NG' and person_anc.labor_date BETWEEN $date_stage_ment

				UNION

				select 'PO9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc 
				left join person on person_anc.person_id = person.person_id		
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person_anc.labor_date)> 0 and person_anc.post_labor_service1_date is null
				and DATEDIFF(person_anc.anc_register_date,person_anc.labor_date) <  8 and person_anc.labor_status_id = 2
				and person_anc.labor_date  BETWEEN  $date_stage_ment

				UNION

				select 'PO9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc 
				left join person on person_anc.person_id = person.person_id		
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person_anc.labor_date) > 7 and person_anc.post_labor_service2_date is null
				and DATEDIFF(person_anc.anc_register_date,person_anc.labor_date) <  16 and person_anc.labor_status_id = 2 
				and person_anc.labor_date  BETWEEN  $date_stage_ment



				UNION
				
				select 'PO9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
				from person_anc 
				left join person on person_anc.person_id = person.person_id		
				where person.house_regist_type_id in(1,3) and DATEDIFF(CURDATE(),person_anc.labor_date)> 15 and person_anc.post_labor_service3_date is null
				and DATEDIFF(person_anc.anc_register_date,person_anc.labor_date) <  43  and person_anc.labor_status_id = 2 
				and person_anc.labor_date  BETWEEN  $date_stage_ment



                UNION
                
                select 'PO9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PO9904'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                from person_anc 
                left join person on person_anc.person_id = person.person_id             
                where person_anc.labor_icd10 not BETWEEN 'O80%' and 'O84%' and person_anc.labor_status_id = 2 
                and  person_anc.labor_date  BETWEEN  $date_stage_ment

				 order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='postnatal_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Postnatal_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " <thead>	<tr>
                                      <th>#</th> 
                                      <th>PID</th>                                     
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>                                      
                                      <th>วันคลอด</th>
                                      <th>ครรภ์ที่</th>
                                      <th>ผลการวินิจฉัย</th>
                                      <th>ครั้งที่เยี่ยม</th>                                      
                                      <th>วันที่เยียม</th>
                                      <th>กี่วันที่ไปเยี่ยม</th>
                                      <th>คลอดมาแล้วกี่วัน</th>
                                      
                                      
                                 </tr></thead>

                                      ";
    $i = 0;

    if ($error_code == "PO9299") {
        //$query2 =  mysql_query($sql1."  like'$vn4digit%'  GROUP BY concat(person_wbc_id,care_number) HAVING  ifnull(count(person.person_id),0) > 1");
    } else {

        if ($error_code == "PO9290") {

            $query2 = mysql_query($sql1 . get_month_stagement($vn4digit));
        } else {

            if ($error_code == "PO9901") {

                $query2 = mysql_query($sql1 . get_month_stagement($vn4digit));
            } else {

                if ($error_code == "PO9902") {

                    $query2 = mysql_query($sql1 . get_month_stagement($vn4digit));
                } else {

                    if ($error_code == "PO9903") {

                        $query2 = mysql_query($sql1 . get_month_stagement($vn4digit));
                    } else {

                         if ($error_code == "PO9904") {
                            $query2 = mysql_query($sql1 . get_month_stagement($vn4digit));
                            } else { 

                            $query2 = mysql_query($sql1 . "  like'$vn4digit%'");
                        }
                    }
                }
            }
        }
    }


    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $labor_date = get_date_show($result['labor_date']);
        $PID = $result['person_id'];
        $cid = $result['cid'];
        $vstdate = get_date_show($result['vstdate']);
        $care_number = $result['care_number'];
        $preg_no = $result['preg_no'];
        $date_CC = $result['day_cc'];
        $date_labor = $result['date_labor'];
        $labor_icd10 = $result['labor_icd10'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "       <tbody>    <tr>
                                      <td>$i</td>
                                      <td>$PID</td>                                                 
                                      <td>$ptname </td>
                                      <td>$cid</td>                                      
                                      <td>$labor_date</td> 
                                      <td>$preg_no</td> 
                                      <td>$labor_icd10</td>
                                      <td>$care_number</td>                                        
                                      <td>$vstdate</td>  
                                      <td>$date_CC</td>     
                                      <td>$date_labor</td>                            
                                      
                                  </tr>  </tbody>

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Charge_opd_Error_all($vn4digit) {

    $sql = "select 'CR9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CR9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(vn),0) as CC
				 from vn_stat
				 left join  patient on vn_stat.hn = patient.hn
				 where income > 20000 and  vn like'$vn4digit%' 



				 union

				select 'CR9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CR9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(vn),0) as CC
				from vn_stat 
				where  paid_money > 0 and paid_money <> rcpt_money 
				and (if((paid_money - rcpt_money)>0 , 
				             if(((paid_money - rcpt_money) - ifnull((select sum(rcpt_arrear.amount) from rcpt_arrear where vn = vn_stat.vn and paid = 'N' group by vn),0)) > 0  ,
											(((paid_money - rcpt_money) - ifnull((select sum(rcpt_arrear.amount) from rcpt_arrear where vn = vn_stat.vn and paid = 'N' group by vn),0)) - ifnull((select sum(rcpt_arrear.amount) from rcpt_arrear where vn = vn_stat.vn group by vn ),0)),0)
						,0 )) <> 0  and vn like'$vn4digit%' 

            union

            select 'CR9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CR9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC
            from rcpt_arrear
            where paid = 'Y' and LENGTH(rcpt_arrear.vn) > 9 
            and DATEDIFF(concat(rcpt_arrear.receive_money_date,' ',rcpt_arrear.receive_money_time), ((SELECT concat(vstdate,' ',vsttime) from ovst where vn = (SELECT max(vn) from ovst where hn=rcpt_arrear.hn and vstdate <= rcpt_arrear.receive_money_date  and vsttime < rcpt_arrear.receive_money_time))) ) <> 0
            and concat(RIGHT(year(rcpt_arrear.receive_money_date)+543,2),LPAD(month(rcpt_arrear.receive_money_date),2,'0')) like'$vn4digit%' 				


            union

            select 'CR9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CR9904'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC
            from
            rcpt_arrear
            left join rcpt_print on  rcpt_arrear.finance_number = rcpt_print.finance_number
            where paid = 'Y'  and (receive_money_staff <> rcpt_print.user)
            and  concat(RIGHT(year(rcpt_print.bill_date_time)+543,2),LPAD(month(rcpt_print.bill_date_time),2,'0')) like'$vn4digit%'

				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_Charge_opd_Error_detail($vn4digit) {

    $sql = "select 'CR9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CR9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(vn),0) as CC
				 from vn_stat
				 left join  patient on vn_stat.hn = patient.hn
				 where income > 20000 and  vn like'$vn4digit%' 

				 union

                select 'CR9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CR9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(vn),0) as CC
                from vn_stat 
                where  paid_money > 0 and paid_money <> rcpt_money 
                and (if((paid_money - rcpt_money)>0 , 
                             if(((paid_money - rcpt_money) - ifnull((select sum(rcpt_arrear.amount) from rcpt_arrear where vn = vn_stat.vn and paid = 'N' group by vn),0)) > 0  ,
                                            (((paid_money - rcpt_money) - ifnull((select sum(rcpt_arrear.amount) from rcpt_arrear where vn = vn_stat.vn and paid = 'N' group by vn),0)) - ifnull((select sum(rcpt_arrear.amount) from rcpt_arrear where vn = vn_stat.vn group by vn ),0)),0)
                        ,0 )) <> 0  and vn like'$vn4digit%' 

                union

                    select 'CR9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CR9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC
                    from rcpt_arrear
                    where paid = 'Y' and LENGTH(rcpt_arrear.vn) > 9 
                    and DATEDIFF(concat(rcpt_arrear.receive_money_date,' ',rcpt_arrear.receive_money_time), ((SELECT concat(vstdate,' ',vsttime) from ovst where vn = (SELECT max(vn) from ovst where hn=rcpt_arrear.hn and vstdate <= rcpt_arrear.receive_money_date  and vsttime < rcpt_arrear.receive_money_time))) ) <> 0
                    and concat(RIGHT(year(rcpt_arrear.receive_money_date)+543,2),LPAD(month(rcpt_arrear.receive_money_date),2,'0')) like'$vn4digit%'                

                union

                select 'CR9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CR9904'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC
                from
                rcpt_arrear
                left join rcpt_print on  rcpt_arrear.finance_number = rcpt_print.finance_number
                where paid = 'Y'  and (receive_money_staff <> rcpt_print.user)
                and  concat(RIGHT(year(rcpt_print.bill_date_time)+543,2),LPAD(month(rcpt_print.bill_date_time),2,'0')) like'$vn4digit%'


            
				 order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql) or die(mysql_error());
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='charge-opd_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Charge_opd_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>HN</th>
                                      <th>วันที่รับบริการ</th> 
                                      <th>เวลารับบริการ</th>                                  
                                      <th>ยอดค่ารักษา(ส่วนต่าง)</th>   
                                 </tr>

                                      ";
    $i = 0;

    if($error_code == 'CR9902') {

        $query2 = mysql_query($sql1 . " like'$vn4digit%' group by vn") or die(mysql_error());
      }else {
            if ($error_code == 'CR9903') {

                $query2 = mysql_query($sql1 . " like'$vn4digit%' ") or die(mysql_error());

            }else{               
                    $query2 = mysql_query($sql1 . " and vn_stat.vn like'$vn4digit%'") or die(mysql_error());
                }
        }

    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $hn = $result['hn'];
        $cid = $result['cid'];
        $income = $result['income'];
        $TIMEServ = $result['vsttime'];
        //$service_id = $result['person_women_service_id'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>                                     
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$hn</td>
                                      <td>$DATEServ</td>    
                                      <td>$TIMEServ</td>                               
                                      <td>$income</td> 
                                  </tr> 

                                  ";
    }

    
    return $tb . $tb_footer;
}

function get_row_Procedure_opd_Error_all($vn4digit) {

    $sql = "select 'PX9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PX9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(er_regist_oper.vn),0) as CC  
				  from er_regist_oper
					left join ovst on er_regist_oper.vn = ovst.vn 
					left join patient on ovst.hn = patient.hn
				  left join ovst_vaccine on er_regist_oper.vn = ovst_vaccine.vn 
				   where er_regist_oper.er_regist_oper_id in(select er_regist_oper_id from er_regist_oper where er_oper_code in('178','176') and vn = er_regist_oper.vn)  
				   and (ovst_vaccine.person_vaccine_id not in('31','32','33','34','35','36','37','38','39','40','50','51','52','53','54') or ovst_vaccine.person_vaccine_id is null)
				   and er_regist_oper.vn like'$vn4digit%' 



				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_Procedure_opd_Error_detail($vn4digit) {

    $sql = "select 'PX9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'PX9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(er_regist_oper.vn),0) as CC  
				  from er_regist_oper
				left join ovst on er_regist_oper.vn = ovst.vn 
				left join patient on ovst.hn = patient.hn
			  left join ovst_vaccine on er_regist_oper.vn = ovst_vaccine.vn 
			   where er_regist_oper.er_regist_oper_id in(select er_regist_oper_id from er_regist_oper where er_oper_code in('178','176') and vn = er_regist_oper.vn)  
			   and (ovst_vaccine.person_vaccine_id not in('31','32','33','34','35','36','37','38','39','40','50','51','52','53','54') or ovst_vaccine.person_vaccine_id is null)
			   and er_regist_oper.vn like'$vn4digit%' 



				 order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='procedure-opd_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Procedure_opd_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>HN</th>
                                      <th>วันที่รับบริการ</th>
                                      <th>เวลารับบริการ</th>                                     
                                      <th>หัตถการ</th>  
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1 . " and er_regist_oper.vn like'$vn4digit%'");
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $hn = $result['hn'];
        $cid = $result['cid'];
        $oper_name = $result['oper_name'];
        $TIMEServ = $result['vsttime'];
        //$service_id = $result['person_women_service_id'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>                                     
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$hn</td>
                                      <td>$DATEServ</td>
                                      <td>$TIMEServ</td>                                   
                                      <td>$oper_name</td>  
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Ncd_screen_Error_all($vn4digit) {

    $date_stage_ment = get_month_stagement($vn4digit);

    $sql = /*"select 'NC9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				from  person_ht_risk_bp_screen
				left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				left join person_dmht_screen_summary on 
					p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				left join person on person_dmht_screen_summary.person_id= person.person_id
				where screen_no = 1 and  person_dmht_screen_summary.status_active = 'Y' 
				and   (SELECT p_scr_bp_2.person_ht_risk_bp_screen_id 
							from  person_ht_risk_bp_screen p_scr_bp_2
							where p_scr_bp_2.screen_no =2 and  
										p_scr_bp_2.person_dmht_risk_screen_head_id = person_ht_risk_bp_screen.person_dmht_risk_screen_head_id) is null
				and p_scr_head.screen_date BETWEEN  $date_stage_ment

				union
            */


			"select 'NC9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC
               from  person_ht_risk_bp_screen
               left join person_dmht_risk_screen_head p_scr_head on
                 person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
               left join person_dmht_screen_summary on 
                   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
               left join person on person_dmht_screen_summary.person_id= person.person_id
               where screen_no = 1 and  person_dmht_screen_summary.status_active = 'Y' and 
               (person_ht_risk_bp_screen.bpd = 0 or person_ht_risk_bp_screen.bpd is null or person_ht_risk_bp_screen.bps = 0 or person_ht_risk_bp_screen.bps = null) and p_scr_head.screen_date BETWEEN  $date_stage_ment


                union 

            	select 'NC1149' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1149'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				   from  person_ht_risk_bp_screen
				   left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				   left join person_dmht_screen_summary on 
					   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				   left join person on person_dmht_screen_summary.person_id= person.person_id
				   where screen_no = 1 and  person_dmht_screen_summary.status_active = 'Y' and   
							person_ht_risk_bp_screen.bpd is null
				    and p_scr_head.screen_date BETWEEN  $date_stage_ment


				union

				select 'NC1148' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1148'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				   from  person_ht_risk_bp_screen
				   left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				   left join person_dmht_screen_summary on 
					   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				   left join person on person_dmht_screen_summary.person_id= person.person_id
				   where screen_no = 1 and  person_dmht_screen_summary.status_active = 'Y' and   
							person_ht_risk_bp_screen.bps is null
				    and p_scr_head.screen_date BETWEEN  $date_stage_ment




				 union

				select 'NC1145' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1145'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
					from person_dmht_risk_screen_head
					left join person_dmht_screen_summary on 
						person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
					 left join person on person_dmht_screen_summary.person_id= person.person_id
					where  person_dmht_screen_summary.status_active = 'Y' and person_dmht_risk_screen_head.body_weight is null
					 and person_dmht_risk_screen_head.screen_date between   $date_stage_ment

				union

					select 'NC1146' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1146'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
					from person_dmht_risk_screen_head
					left join person_dmht_screen_summary on 
						person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
					 left join person on person_dmht_screen_summary.person_id= person.person_id
					where  person_dmht_screen_summary.status_active = 'Y' and person_dmht_risk_screen_head.body_height is null
					 and person_dmht_risk_screen_head.screen_date between   $date_stage_ment

				union

					select 'NC1147' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1147'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
					from person_dmht_risk_screen_head
					left join person_dmht_screen_summary on 
						person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
					 left join person on person_dmht_screen_summary.person_id= person.person_id
					where  person_dmht_screen_summary.status_active = 'Y' and person_dmht_risk_screen_head.waist is null
					 and person_dmht_risk_screen_head.screen_date between   $date_stage_ment


				union

				select 'NC1151' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1151'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				   from  person_ht_risk_bp_screen
				   left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				   left join person_dmht_screen_summary on 
					   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				   left join person on person_dmht_screen_summary.person_id= person.person_id
				   where  person_dmht_screen_summary.status_active = 'Y' and  screen_no = 2 and  
							person_ht_risk_bp_screen.bpd is null
				    and p_scr_head.screen_date BETWEEN  $date_stage_ment



				 union

				select 'NC1150' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1150'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				   from  person_ht_risk_bp_screen
				   left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				   left join person_dmht_screen_summary on 
					   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				   left join person on person_dmht_screen_summary.person_id= person.person_id
				   where person_dmht_screen_summary.status_active = 'Y' and   screen_no = 2 and 
							person_ht_risk_bp_screen.bps is null
				    and p_scr_head.screen_date BETWEEN  $date_stage_ment



				    UNION

				   select 'NC9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9299'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
					from person_dmht_risk_screen_head
					INNER JOIN (SELECT  person_dmht_screen_summary.person_dmht_screen_summary_id,  person_dmht_screen_summary.person_id,person_dmht_risk_screen_head.screen_date
					 from person_dmht_screen_summary 
					left JOIN person_dmht_risk_screen_head on person_dmht_screen_summary.person_dmht_screen_summary_id = person_dmht_risk_screen_head.person_dmht_screen_summary_id
					GROUP BY person_dmht_screen_summary.person_dmht_screen_summary_id
					HAVING count(person_dmht_screen_summary.person_dmht_screen_summary_id) > 1 )  ps_risk_detail on person_dmht_risk_screen_head.person_dmht_screen_summary_id = ps_risk_detail.person_dmht_screen_summary_id
					left join person on ps_risk_detail.person_id = person.person_id 
					where concat(mid((year(ps_risk_detail.screen_date)+543),3,2),LPAD(month(ps_risk_detail.screen_date),2,'0')) like'$vn4digit%'


                    UNION

                    select 'NC9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                      from person_dmht_risk_screen_head
                      left join person_dmht_screen_summary on 
                         person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
                      left join person on person_dmht_screen_summary.person_id= person.person_id
                      where  person_dmht_screen_summary.status_active = 'Y' and person_dmht_risk_screen_head.body_weight > 250
                        and person_dmht_risk_screen_head.screen_date between  $date_stage_ment


                UNION


                    select 'NC9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9904'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                    from person
                    INNER JOIN (SELECT person_dmht_screen_summary.person_id 
                    from person_dmht_risk_screen_head
                    LEFT JOIN person_dmht_screen_summary on person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
                    where last_fgc < 70 and screen_date between  $date_stage_ment ) person_dnht_chk on person.person_id = person_dnht_chk.person_id

                UNION

                select 'NC9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9905'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 

                   from person
                    INNER JOIN (SELECT person_dmht_screen_summary.person_id,screen_date ,person_dmht_risk_screen_head.person_dmht_screen_summary_id
                    from person_dmht_risk_screen_head
                    LEFT JOIN person_dmht_screen_summary on person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
                    where  screen_date between  $date_stage_ment ) person_dnht_chk on person.person_id = person_dnht_chk.person_id
                    and (person.death_date is not null or person.death = 'Y') and person.death_date <= screen_date  

				";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_Ncd_screen_Error_detail($vn4digit) {

    $date_stage_ment = get_month_stagement($vn4digit);

    $sql = /*"select 'NC9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				from  person_ht_risk_bp_screen
				left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				left join person_dmht_screen_summary on 
					p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				left join person on person_dmht_screen_summary.person_id= person.person_id
				where screen_no = 1 and  person_dmht_screen_summary.status_active = 'Y' 
				and   (SELECT p_scr_bp_2.person_ht_risk_bp_screen_id 
							from  person_ht_risk_bp_screen p_scr_bp_2
							where p_scr_bp_2.screen_no =2 and  
										p_scr_bp_2.person_dmht_risk_screen_head_id = person_ht_risk_bp_screen.person_dmht_risk_screen_head_id) is null
				and p_scr_head.screen_date BETWEEN  $date_stage_ment


				union

            */

            "select 'NC9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC
               from  person_ht_risk_bp_screen
               left join person_dmht_risk_screen_head p_scr_head on
                 person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
               left join person_dmht_screen_summary on 
                   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
               left join person on person_dmht_screen_summary.person_id= person.person_id
               where screen_no = 1 and  person_dmht_screen_summary.status_active = 'Y'  and p_scr_head.screen_date BETWEEN  $date_stage_ment and (person_ht_risk_bp_screen.bpd = 0 or person_ht_risk_bp_screen.bpd is null or person_ht_risk_bp_screen.bps = 0 or person_ht_risk_bp_screen.bps = null)


                union 


                	select 'NC1149' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1149'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				   from  person_ht_risk_bp_screen
				   left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				   left join person_dmht_screen_summary on 
					   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				   left join person on person_dmht_screen_summary.person_id= person.person_id
				   where screen_no = 1 and  person_dmht_screen_summary.status_active = 'Y' and   
							person_ht_risk_bp_screen.bpd is null
				    and p_scr_head.screen_date BETWEEN  $date_stage_ment

				union

				select 'NC1148' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1148'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				   from  person_ht_risk_bp_screen
				   left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				   left join person_dmht_screen_summary on 
					   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				   left join person on person_dmht_screen_summary.person_id= person.person_id
				   where screen_no = 1 and  person_dmht_screen_summary.status_active = 'Y' and   
							person_ht_risk_bp_screen.bps is null
				    and p_scr_head.screen_date BETWEEN  $date_stage_ment


				
				 union

					select 'NC1145' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1145'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
					from person_dmht_risk_screen_head
					left join person_dmht_screen_summary on 
						person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
					 left join person on person_dmht_screen_summary.person_id= person.person_id
					where  person_dmht_screen_summary.status_active = 'Y' and person_dmht_risk_screen_head.body_weight is null
					 and person_dmht_risk_screen_head.screen_date between   $date_stage_ment
		
				
				 union

					select 'NC1146' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1146'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
					from person_dmht_risk_screen_head
					left join person_dmht_screen_summary on 
						person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
					 left join person on person_dmht_screen_summary.person_id= person.person_id
					where  person_dmht_screen_summary.status_active = 'Y' and person_dmht_risk_screen_head.body_height is null
					 and person_dmht_risk_screen_head.screen_date between   $date_stage_ment

				 
				union

					select 'NC1147' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1147'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
					from person_dmht_risk_screen_head
					left join person_dmht_screen_summary on 
						person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
					 left join person on person_dmht_screen_summary.person_id= person.person_id
					where  person_dmht_screen_summary.status_active = 'Y' and person_dmht_risk_screen_head.waist is null
					 and person_dmht_risk_screen_head.screen_date between   $date_stage_ment

				union

				select 'NC1151' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1151'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				   from  person_ht_risk_bp_screen
				   left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				   left join person_dmht_screen_summary on 
					   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				   left join person on person_dmht_screen_summary.person_id= person.person_id
				   where   person_dmht_screen_summary.status_active = 'Y' and  screen_no = 2 and   
							person_ht_risk_bp_screen.bpd is null
				    and p_scr_head.screen_date BETWEEN  $date_stage_ment


				 union

				select 'NC1150' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC1150'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
				   from  person_ht_risk_bp_screen
				   left join person_dmht_risk_screen_head p_scr_head on
				     person_ht_risk_bp_screen.person_dmht_risk_screen_head_id  = p_scr_head.person_dmht_risk_screen_head_id
				   left join person_dmht_screen_summary on 
					   p_scr_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
				   left join person on person_dmht_screen_summary.person_id= person.person_id
				   where  person_dmht_screen_summary.status_active = 'Y' and  screen_no = 2 and  
							person_ht_risk_bp_screen.bps is null
				    and p_scr_head.screen_date BETWEEN  $date_stage_ment




				    UNION

				   select 'NC9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9299'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC  
					from person_dmht_risk_screen_head
					INNER JOIN (SELECT  person_dmht_screen_summary.person_dmht_screen_summary_id,  person_dmht_screen_summary.person_id,person_dmht_risk_screen_head.screen_date
					 from person_dmht_screen_summary 
					left JOIN person_dmht_risk_screen_head on person_dmht_screen_summary.person_dmht_screen_summary_id = person_dmht_risk_screen_head.person_dmht_screen_summary_id
					GROUP BY person_dmht_screen_summary.person_dmht_screen_summary_id
					HAVING count(person_dmht_screen_summary.person_dmht_screen_summary_id) > 1 )  ps_risk_detail on person_dmht_risk_screen_head.person_dmht_screen_summary_id = ps_risk_detail.person_dmht_screen_summary_id
					left join person on ps_risk_detail.person_id = person.person_id 
					where concat(mid((year(ps_risk_detail.screen_date)+543),3,2),LPAD(month(ps_risk_detail.screen_date),2,'0')) like'$vn4digit%'
                    

                    UNION

                    select 'NC9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                      from person_dmht_risk_screen_head
                      left join person_dmht_screen_summary on 
                         person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
                      left join person on person_dmht_screen_summary.person_id= person.person_id
                      where  person_dmht_screen_summary.status_active = 'Y' and person_dmht_risk_screen_head.body_weight > 250
                        and person_dmht_risk_screen_head.screen_date between  $date_stage_ment


                    UNION

                
                    select 'NC9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9904'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                    from person
                    INNER JOIN (SELECT person_dmht_screen_summary.person_id 
                    from person_dmht_risk_screen_head
                    LEFT JOIN person_dmht_screen_summary on person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
                    where last_fgc < 70 and screen_date between  $date_stage_ment ) person_dnht_chk on person.person_id = person_dnht_chk.person_id


                UNION

                select 'NC9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NC9905'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 

                   from person
                    INNER JOIN (SELECT person_dmht_screen_summary.person_id,screen_date ,person_dmht_risk_screen_head.person_dmht_screen_summary_id
                    from person_dmht_risk_screen_head
                    LEFT JOIN person_dmht_screen_summary on person_dmht_risk_screen_head.person_dmht_screen_summary_id = person_dmht_screen_summary.person_dmht_screen_summary_id
                    where  screen_date between  $date_stage_ment ) person_dnht_chk on person.person_id = person_dnht_chk.person_id
                    and (person.death_date is not null or person.death = 'Y') and person.death_date <= screen_date  

				 order by CC desc , ERROR_CODE ";
    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='ncdscreen_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Ncd_screen_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>person_id</th>
                                      <th>วันที่คัดกรอง</th>
                                      <th>เวลารับบริการ</th>                                     
                                      <th>ครั้งที่</th>
                                 </tr>

                                      ";
    $i = 0;


    if ($error_code == 'NC9299') {
        $query2 = mysql_query($sql1 . "like'$vn4digit%'") or die(mysql_error());
    } else {
        $query2 = mysql_query($sql1 . get_month_stagement($vn4digit)) or die(mysql_error());
    }

    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $screendate = get_date_show($result['screen_date']);
        $person_id = $result['person_id'];
        $cid = $result['cid'];
        $bps = $result['bps'];
        $bpd = $result['bpd'];
        $screentime = $result['screen_time'];
        $screen_no = $result['screen_no'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>                                     
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$person_id</td>
                                      <td>$screendate</td>
                                      <td>$screentime</td>                                   
                                      <td>$screen_no</td> 
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}

function get_row_Home_Error_all($vn4digit) {

    $sql = "   select 'HO9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'HO9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(house.house_id),0) as CC  
 					from house 
  					LEFT JOIN (SELECT house_id from village_organization_member_service group by house_id) vms on house.house_id = vms.house_id
  					where vms.house_id is null and house.village_id <> 1
			 
				 UNION

		         select 'HO2104' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'HO2104'  ) as 'ERROR_DETAIL' ,  ifnull(count(house_id),0) as CC  
				  from house
				  where (house_subtype_id not in(SELECT house_subtype_id from house_subtype) or house_subtype_id is null)


				  UNION

				  select 'HO9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'HO9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(house.house_id),0) as CC  
				  from house
				  left join village on (house.village_id) = village.village_id
				  left join (SELECT house_id,person_id from person where person_house_position_id = 1) ps_house_id on house.house_id=ps_house_id.house_id
				  where   house.village_id <> 1 and ps_house_id.person_id is null


				  UNION

				   select 'HO9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'HO9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(house.house_id),0) as CC  
				  	 from house
					INNER JOIN (SELECT vms.house_id 
						from village_organization_member_service vms                                
			      left outer join village v on v.village_id=vms.village_id                    
			      left outer join house h on h.house_id=vms.house_id                          
			      where vms.village_id <> 1                             
			      group by vms.house_id                                                       
			      having count(vms.village_id) > 1 order by vms.village_id) hous_chk on house.house_id = hous_chk.house_id
					 
				  ";



    //echo $sql;	
    $CC_sum = 0;
    $CC= 0;
    $query = mysql_query($sql) or die(mysql_error());
    //$rows = mysql_num_rows($query) ;
    while ($result = mysql_fetch_array($query)) {
        
        //echo  $result['ERROR_CODE'].'='.$result['CC'].';';
        $CC  = $result['CC'];
        $CC_sum = ($CC_sum *1) + ($CC*1);
        
    }
    return $CC_sum;
}

function get_rows_Home_Error_detail($vn4digit) {


    $sql = "select 'HO2104' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'HO2104'  ) as 'ERROR_DETAIL' ,  ifnull(count(house_id),0) as CC  
				  from house
				  where (house_subtype_id not in(SELECT house_subtype_id from house_subtype) or house_subtype_id is null) 

				  UNION

				  select 'HO9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'HO9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(house.house_id),0) as CC  
				  from house
				  left join village on (house.village_id) = village.village_id
				  left join (SELECT house_id,person_id from person where person_house_position_id = 1) ps_house_id on house.house_id=ps_house_id.house_id
				  where   house.village_id <> 1 and ps_house_id.person_id is null
				  
				  UNION
				  
				   select 'HO9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'HO9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(house.house_id),0) as CC  
				  	 from house
						INNER JOIN (SELECT vms.house_id 
						from village_organization_member_service vms                                
                                                left outer join village v on v.village_id=vms.village_id                    
                                                left outer join house h on h.house_id=vms.house_id                          
                                                where vms.village_id <> 1                             
                                                group by vms.house_id                                                       
                                                having count(*) > 1 order by vms.village_id) hous_chk on house.house_id = hous_chk.house_id


					UNION

					 select 'HO9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'HO9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(house.house_id),0) as CC  
 					from house 
  					LEFT JOIN (SELECT house_id from village_organization_member_service group by house_id) vms on house.house_id = vms.house_id
  					where vms.house_id is null and house.village_id <> 1

				  order by CC desc , ERROR_CODE ";


    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='home_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Home_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }


        // ตรวจสอบ
        if($error_code=="HO9902"){

        $tb = $tb_title . "     <tr>
                                          <th>#</th>
                                          <th>บ้านเลขที่ </th>
                                          <th>หมู่</th>
                                          <th>บ้าน</th>
                                          <th>เลขทะเบียนบ้าน</th>
                                          <th>ชื่อ อสม.</th>
                                          <th>รหัสบ้าน</th>
                                    </tr> ";
        }else{
        $tb = $tb_title . " 	<tr>
                                          <th>#</th>
                                          <th>บ้านเลขที่ </th>
                                          <th>หมู่</th>
                                          <th>บ้าน</th>
                                          <th>เลขทะเบียนบ้าน</th>
                                    </tr> ";


        }


    $i = 0;


    $query2 = mysql_query($sql1) or die(mysql_error());


    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $address = $result['address'];
        $village_moo = $result['village_moo'];
        $village_name = $result['village_name'];
        $census_id = $result['census_id'];
        $house_id  = $result['house_id'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        
        if($error_code=="HO9902"){
                $vrms_mid = $result['vrms_mid'];
                $ps_name = get_rows_Home_Error_detail_village_organization_member_person($vrms_mid);

                       $tb = $tb . "<tr>
                                      <td >$i</td>                                     
                                      <td>$address </td>
                                      <td>$village_moo</td>
                                      <td>$village_name</td>
                                      <td>$census_id</td>
                                      <td>$ps_name </td>
                                      <td>$house_id</td>
                                  </tr> "; 
        }else{
        $tb = $tb . "           <tr>
                                      <td >$i</td>                                     
                                      <td>$address </td>
                                      <td>$village_moo</td>
                                      <td>$village_name</td>
                                      <td>$census_id</td>
                                  </tr> ";
        }
    }
    return $tb . $tb_footer;
}




function get_rows_Home_Error_detail_village_organization_member_person($vrm_mid){

 $sql = "select GROUP_CONCAT(village_organization_member.person_id) person_id, GROUP_CONCAT(concat(person.pname,person.fname,' ',person.lname)) ps_name
            from village_organization_member 
            left JOIN person on village_organization_member.person_id = person.person_id
            where village_organization_mid in($vrm_mid)";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $ps_name = $result['ps_name'];
    }

        return   $ps_name;

}





function get_row_Community_service_Error_all($vn4digit) {

    $sql = "select 'CS9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CS9299'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.vn),0) as CC 
				FROM ovst
				inner join (SELECT ovst_community_service.vn, ovst_community_service.ovst_community_service_type_id 
				from  ovst_community_service
				left join ovst on ovst_community_service.vn = ovst.vn
				GROUP BY concat(ovst_community_service.vn,ovst_community_service.ovst_community_service_type_id)
				HAVING count(concat(ovst_community_service.vn,ovst_community_service.ovst_community_service_type_id)) >1 )  community
				on ovst.vn = community.vn
				where ovst.vn like'$vn4digit%' ";




    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_Community_service_Error_detail($vn4digit) {


    $sql = "select 'CS9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CS9299'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.vn),0) as CC 
				FROM ovst
				inner join (SELECT ovst_community_service.vn, ovst_community_service.ovst_community_service_type_id 
				from  ovst_community_service
				left join ovst on ovst_community_service.vn = ovst.vn
				GROUP BY concat(ovst_community_service.vn,ovst_community_service.ovst_community_service_type_id)
				HAVING count(concat(ovst_community_service.vn,ovst_community_service.ovst_community_service_type_id)) >1 )  community
				on ovst.vn = community.vn
				where ovst.vn like'$vn4digit%' 
				  order by CC desc , ERROR_CODE ";


    //echo $sql;	
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='community-service_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}

function get_rows_Community_Service_Error_detail_list($error_code, $vn4digit, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'] . "  like'$vn4digit%'";
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . " 	<tr>
                                      <th>#</th>
                                      <th>HN </th>
                                      <th>ชื่อ-สกุล</th>
                                      <th>วันที่รับบริการ</th>
                                      <th>เวลา</th>
                                      <th>รายการคัดกรอง</th>
                                </tr>

                                      ";
    $i = 0;


    $query2 = mysql_query($sql1) or die(mysql_error());


    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $vstdate = get_date_show($result['vstdate']);
        $vsttime = $result['vsttime'];
        $HN = $result['hn'];
        $ovst_community_service_type_name = $result['ovst_community_service_type_name'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td>$i</td>                                     
                                      <td>$HN </td>
                                      <td>$ptname</td>
                                      <td>$vstdate</td>
                                      <td>$vsttime</td>
									  <td>$ovst_community_service_type_name</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}




function get_rows_Death_Error_all($vn4digit) {

    $sql = "select 'DE9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DE9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC 
                FROM ipt 
                    LEFT JOIN patient ON ipt.hn = patient.hn 
                    LEFT JOIN death ON patient.hn = death.hn 
                    WHERE
                        (
                            ipt.dchstts IN ('08', '09')
                            OR ipt.dchtype IN ('08', '09')
                        ) and death.death_id is null 
            UNION 
            select 'DE9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DE9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC 
                  FROM ipt 
                    LEFT JOIN patient ON ipt.hn = patient.hn 
                    LEFT JOIN death ON patient.hn = death.hn 
                    WHERE
                        (
                            ipt.dchstts IN ('08', '09')
                            OR ipt.dchtype IN ('08', '09')
                        ) and death.death_id is not null  and death.an in('',null) 


             UNION

            select 'DE9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DE9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC 
            from death
            where  death_place = 1  and  (death_hospcode = '' or  death_hospcode is null)
            and concat(RIGHT((DATE_FORMAT(last_update ,'%Y') +543),2),DATE_FORMAT(last_update ,'%m')) like'$vn4digit' 





            ";




    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}



function get_rows_Death_Error_detail($vn4digit) {


    $sql = " select 'DE9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DE9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC 
            from death
            where  death_place = 1  and  (death_hospcode = '' or  death_hospcode is null)
            and concat(RIGHT((DATE_FORMAT(last_update ,'%Y') +543),2),DATE_FORMAT(last_update ,'%m')) like'$vn4digit' 

                    UNION
                   

              select 'DE9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DE9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC 
                FROM ipt 
                    LEFT JOIN patient ON ipt.hn = patient.hn 
                    LEFT JOIN death ON patient.hn = death.hn 
                    WHERE
                        (
                            ipt.dchstts IN ('08', '09')
                            OR ipt.dchtype IN ('08', '09')
                        ) and death.death_id is null 
            
            UNION 
            select 'DE9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'DE9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC 
                  FROM ipt 
                    LEFT JOIN patient ON ipt.hn = patient.hn 
                    LEFT JOIN death ON patient.hn = death.hn 
                    WHERE
                        (
                            ipt.dchstts IN ('08', '09')
                            OR ipt.dchtype IN ('08', '09')
                        ) and death.death_id is not null  and death.an in('',null) 
                  order by CC desc , ERROR_CODE 



                      







                  ";




    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='death_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}


function get_rows_Death_Error_detail_list($error_code, $vn4digit, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }

  //แยกระเภทการดึงรายงานตามมงเือนไขที่กำหนด
  switch ($error_code) {
        case 'DE9903':
            $sql1 = $sql1. "like $vn4digit ";
            break;
        
        default:
            $sql1 = $sql1;
            break;
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th>HN </th>
                                      <th>ชื่อ-สกุล</th>
                                      <th>วันที่รับบริการ</th>
                                      <th>เวลา</th> 
                                      <th>AN</th>                                      
                                </tr>

                                      ";
    $i = 0;


    $query2 = mysql_query($sql1) or die(mysql_error());




    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $vstdate = get_date_show($result['vstdate']);
        $vsttime = $result['vsttime'];
        $HN = $result['hn'];
        $AN = $result['an'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td>$i</td>                                     
                                      <td>$HN </td>
                                      <td>$ptname</td>
                                      <td>$vstdate</td>
                                      <td>$vsttime</td>     
                                      <td>$AN</td>                                  
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}





function get_row_Labfu_Error_all($vn4digit) {

    $sql = "select 'LA9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LA9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC 
                from lab_order 
            left JOIN lab_head on lab_order.lab_order_number = lab_head.lab_order_number
            where lab_items_code in(
            select lab_items_code from lab_items where lab_items_name = (select sys_value from sys_var where sys_name like '%lab_link_cr%')) 
            and  lab_head.department = 'OPD' 
            and  (lab_order.lab_order_result<>(SELECT creatinine from ovst_gfr where vn = lab_head.vn) 
             or   lab_order.lab_order_result<> (SELECT opdscreen.creatinine from opdscreen where vn = lab_head.vn))
            and lab_head.vn like'$vn4digit%'

            ";



    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}




function get_rows_Labfu_Error_detail($vn4digit) {


    $sql = "select 'LA9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'LA9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC 
                from lab_order 
            left JOIN lab_head on lab_order.lab_order_number = lab_head.lab_order_number
            where lab_items_code in(
            select lab_items_code from lab_items where lab_items_name = (select sys_value from sys_var where sys_name like '%lab_link_cr%')) 
            and  lab_head.department = 'OPD' 
            and  (lab_order.lab_order_result<>(SELECT creatinine from ovst_gfr where vn = lab_head.vn) 
             or   lab_order.lab_order_result<> (SELECT opdscreen.creatinine from opdscreen where vn = lab_head.vn))
            and lab_head.vn like'$vn4digit%'
                  
            order by CC desc , ERROR_CODE ";


    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='labfu_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}








function get_row_Disability_Error_all($vn4digit) {

    $sql = "select 'DS9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'DS9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC
             from person_deformed_detail  
             where ASCII(icd10) not BETWEEN '65' and '90'

            ";



    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}





function get_rows_Disability_Error_detail($vn4digit) {


    $sql = "select 'DS9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'DS9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC
             from person_deformed_detail  
             where ASCII(icd10) not BETWEEN '65' and '90'                  
            order by CC desc , ERROR_CODE ";


    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='disability_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}






function get_rows_Disability_Error_detail_list($error_code, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th>PID</th>
                                      <th> ชื่อ - สกุล </th>
                                      <th> CID</th>
                                      <th> อายุ</th>
                                      <th> ที่อยู่</th>
                                      <th> วันที่เลงทะเบียน</th>
                                      <th> วันที่แก้ไข</th>
                                      <th> ICD10</th>
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $age_y = $result['age_y'];
        $person_id = $result['person_id'];
        $cid = $result['cid'];
        $hous_addr = $result['hous_addr'];
        $register_date = get_date_show($result['register_date']);
        $entry_date = get_date_show($result['entry_date']);
        $deformed_ICD = $result['icd10'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$age_y</td>
                                      <td>$hous_addr</td>
                                      <td>$register_date</td>
                                      <td>$entry_date</td>
                                      <td>$deformed_ICD</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}








function get_row_Epi_Error_all($vn4digit) {

    $sql = "  select 'EP9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'EP9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC
                from person 
                INNER JOIN (
                SELECT person_wbc.person_id as pid , person_wbc_service.service_date as date_service ,wbc_vaccine.wbc_vaccine_code as vcc_code
                from person_wbc 
                LEFT JOIN person_wbc_service on person_wbc.person_wbc_id = person_wbc_service.person_wbc_id
                left join person on person_wbc.person_id = person.person_id 
                left JOIN person_wbc_vaccine_detail on person_wbc_service.person_wbc_service_id = person_wbc_vaccine_detail.person_wbc_service_id
                LEFT JOIN wbc_vaccine on person_wbc_vaccine_detail.wbc_vaccine_id = wbc_vaccine.wbc_vaccine_id
                where person.birthdate >  person_wbc_service.service_date
                UNION
                SELECT person_epi.person_id  as pid ,person_epi_vaccine.vaccine_date as date_service, epi_vaccine.vaccine_code as vcc_code
                from person_epi 
                LEFT JOIN person_epi_vaccine on person_epi.person_epi_id = person_epi_vaccine.person_epi_id
                left join person on person_epi.person_id = person.person_id 
                LEFT JOIN person_epi_vaccine_list on person_epi_vaccine.person_epi_vaccine_id = person_epi_vaccine_list.person_epi_vaccine_id
                LEFT JOIN epi_vaccine on person_epi_vaccine_list.epi_vaccine_id = epi_vaccine.epi_vaccine_id
                where person.birthdate >  person_epi_vaccine.vaccine_date


                UNION

                SELECT person_vaccine_elsewhere.person_id  as pid ,person_vaccine_elsewhere.vaccine_date as date_service , person_vaccine.vaccine_code as vcc_code
                from person_vaccine_elsewhere
                left JOIN person on person_vaccine_elsewhere.person_id = person.person_id
                left JOIN person_vaccine on person_vaccine_elsewhere.person_vaccine_id = person_vaccine.person_vaccine_id
                where person.birthdate > person_vaccine_elsewhere.vaccine_date
                GROUP BY pid,vcc_code ) vcc_error on person.person_id = vcc_error.pid

                UNION

                select 'EP2001' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'EP2001'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC

                from ovst 
                INNER JOIN (select person_wbc_service.vn,wbc_vaccine.wbc_vaccine_name, person_wbc_vaccine_detail.wbc_vaccine_id ,
                   (case when wbc_vaccine.export_vaccine_code in('010') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z232')
                    else
                       (case when wbc_vaccine.export_vaccine_code in('041','042','043') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z246')
                       else
                          (case when wbc_vaccine.export_vaccine_code in('031','032','033') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z271') 
                                    ELSE
                                        (case when wbc_vaccine.export_vaccine_code in('081','082','083','401') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z240') 
                                        ELSE
                                            (case when wbc_vaccine.export_vaccine_code in('061') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z274') 
                                                ELSE
                                                    (case when wbc_vaccine.export_vaccine_code in('R11','R12','R21','R22','R23') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z258') 
                                                        ELSE
                                                            (case when wbc_vaccine.export_vaccine_code in('091','092','093') then  (select GROUP_CONCAT(icd10) from ovstdiag where vn = person_wbc_service.vn and icd10 in('Z271','Z246') GROUP BY vn) END) 
                                                            end) 
                                            
                                                end)    
                                        end) 
                                    
                                    end )          
                                end )
                    end ) 'chk'
                from person_wbc_vaccine_detail
                inner join person_wbc_service on  person_wbc_vaccine_detail.person_wbc_service_id = person_wbc_service.person_wbc_service_id
                left join  wbc_vaccine on person_wbc_vaccine_detail.wbc_vaccine_id  = wbc_vaccine.wbc_vaccine_id
                where  person_wbc_service.vn <> ''
                HAVING chk is null) wbc_chk  on ovst.vn = wbc_chk.vn
                where ovst.vn like '$vn4digit%'

                UNION

                select 'EP2002' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'EP2002'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC
                from ovst 
                INNER JOIN (SELECT person_epi_vaccine.vn,epi_vaccine.epi_vaccine_name,
                (case when epi_vaccine.export_vaccine_code in('034','035') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z271') 
                ELSE
                    (case when epi_vaccine.export_vaccine_code in('084','085') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z240') 
                        ELSE
                         (case when epi_vaccine.export_vaccine_code in('051','052','053') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z241') 
                            ELSE
                                (case when epi_vaccine.export_vaccine_code in('J11','J12') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z241') 
                                ELSE
                                    (case when epi_vaccine.export_vaccine_code in('073') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z274') END) 
                                END)
                            END) 
                        END )
                END ) chk
                from person_epi_vaccine_list
                left join epi_vaccine on person_epi_vaccine_list.epi_vaccine_id = epi_vaccine.epi_vaccine_id 
                left join person_epi_vaccine on person_epi_vaccine_list.person_epi_vaccine_id = person_epi_vaccine.person_epi_vaccine_id
                where person_epi_vaccine.vn <>'' 
                HAVING chk is null )epi_chk on ovst.vn = epi_chk.vn
                where ovst.vn like '$vn4digit%'


                UNION

                select 'EP2003' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'EP2003'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC
                from ovst 
                INNER JOIN (SELECT village_student_vaccine.vn,student_vaccine.student_vaccine_name,village_student.person_id ,
                (case when student_vaccine.export_vaccine_code in('021','022','023','024') then  (select GROUP_CONCAT(icd10) from ovstdiag where vn = village_student_vaccine.vn and icd10 in('Z235','Z236')) 
                ELSE
                    (case when student_vaccine.export_vaccine_code in('011') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z232') 
                    ELSE 
                            (case when student_vaccine.export_vaccine_code in('072','073') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z274') 
                                ELSE
                                    (case when student_vaccine.export_vaccine_code in('086','087','088','402') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z240') 
                                        ELSE
                                            (case when student_vaccine.export_vaccine_code in('075') then (select GROUP_CONCAT(icd10) from ovstdiag where vn = village_student_vaccine.vn and icd10 in('Z244','Z245')) 
                                                ELSE
                                                    (case when student_vaccine.export_vaccine_code in('310','320','311') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z258') 
                                                        ELSE
                                                            (case when student_vaccine.export_vaccine_code in('044','045','046') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z246') 
                                                                ELSE
                                                                    (case when student_vaccine.export_vaccine_code in('054','055') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z241') END)
                                                                END)
                                                        END)
                                                END)
                                        END)                
                                END ) 
                        END)
                END) chk
                from village_student_vaccine_list
                left JOIN village_student_vaccine  on village_student_vaccine_list.village_student_vaccine_id = village_student_vaccine.village_student_vaccine_id
                LEFT JOIN student_vaccine on village_student_vaccine_list.student_vaccine_id = student_vaccine.student_vaccine_id
                LEFT JOIN village_student on village_student_vaccine.village_student_id = village_student.village_student_id 
                where village_student_vaccine.vn <> ''
                HAVING chk is null)student_chk on ovst.vn = student_chk.vn
                LEFT JOIN patient on ovst.hn = patient.hn 
                where ovst.vn like '$vn4digit%'



                UNION

                select 'EP9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'EP9902'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC
                    from ovst
                    inner join (
                    select village_student_vaccine.vn ,  ovst_vaccine.vn as vn_chk 
                    from village_student_vaccine
                    left join village_student on village_student_vaccine.village_student_id =  village_student.village_student_id
                    left join village_student_vaccine_list on village_student_vaccine.village_student_vaccine_id = village_student_vaccine_list.village_student_vaccine_id
                    left join ovst_vaccine on village_student_vaccine.vn  = ovst_vaccine.vn
                    HAVING vn_chk is not null
                    ) student_vaccine on student_vaccine.vn =  ovst.vn
                    where ovst.vn like '$vn4digit%'




            ";



    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}





function get_rows_Epi_Error_detail($vn4digit) {


    $sql = " select 'EP9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'EP9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(*),0) as CC
            from person 
            INNER JOIN (
            SELECT person_wbc.person_id as pid , person_wbc_service.service_date as date_service ,wbc_vaccine.wbc_vaccine_code as vcc_code
            from person_wbc 
            LEFT JOIN person_wbc_service on person_wbc.person_wbc_id = person_wbc_service.person_wbc_id
            left join person on person_wbc.person_id = person.person_id 
            left JOIN person_wbc_vaccine_detail on person_wbc_service.person_wbc_service_id = person_wbc_vaccine_detail.person_wbc_service_id
            LEFT JOIN wbc_vaccine on person_wbc_vaccine_detail.wbc_vaccine_id = wbc_vaccine.wbc_vaccine_id
            where person.birthdate >  person_wbc_service.service_date
            UNION
            SELECT person_epi.person_id  as pid ,person_epi_vaccine.vaccine_date as date_service, epi_vaccine.vaccine_code as vcc_code
            from person_epi 
            LEFT JOIN person_epi_vaccine on person_epi.person_epi_id = person_epi_vaccine.person_epi_id
            left join person on person_epi.person_id = person.person_id 
            LEFT JOIN person_epi_vaccine_list on person_epi_vaccine.person_epi_vaccine_id = person_epi_vaccine_list.person_epi_vaccine_id
            LEFT JOIN epi_vaccine on person_epi_vaccine_list.epi_vaccine_id = epi_vaccine.epi_vaccine_id
            where person.birthdate >  person_epi_vaccine.vaccine_date

             UNION

            SELECT person_vaccine_elsewhere.person_id  as pid ,person_vaccine_elsewhere.vaccine_date as date_service , person_vaccine.vaccine_code as vcc_code
            from person_vaccine_elsewhere
            left JOIN person on person_vaccine_elsewhere.person_id = person.person_id
            left JOIN person_vaccine on person_vaccine_elsewhere.person_vaccine_id = person_vaccine.person_vaccine_id
            where person.birthdate > person_vaccine_elsewhere.vaccine_date
            GROUP BY pid,vcc_code ) vcc_error on person.person_id = vcc_error.pid


            UNION

                select 'EP2001' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'EP2001'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC

                 from ovst 
                INNER JOIN (select person_wbc_service.vn,wbc_vaccine.wbc_vaccine_name, person_wbc_vaccine_detail.wbc_vaccine_id ,
                   (case when wbc_vaccine.export_vaccine_code in('010') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z232')
                    else
                       (case when wbc_vaccine.export_vaccine_code in('041','042','043') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z246')
                       else
                          (case when wbc_vaccine.export_vaccine_code in('031','032','033') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z271') 
                                    ELSE
                                        (case when wbc_vaccine.export_vaccine_code in('081','082','083','401') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z240') 
                                        ELSE
                                            (case when wbc_vaccine.export_vaccine_code in('061') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z274') 
                                                ELSE
                                                    (case when wbc_vaccine.export_vaccine_code in('R11','R12','R21','R22','R23') then  (select icd10 from ovstdiag where vn = person_wbc_service.vn and icd10 = 'Z258') 
                                                        ELSE
                                                            (case when wbc_vaccine.export_vaccine_code in('091','092','093') then  (select GROUP_CONCAT(icd10) from ovstdiag where vn = person_wbc_service.vn and icd10 in('Z271','Z246') GROUP BY vn) END) 
                                                            end) 
                                            
                                                end)    
                                        end) 
                                    
                                    end )          
                                end )
                    end ) 'chk'
                from person_wbc_vaccine_detail
                inner join person_wbc_service on  person_wbc_vaccine_detail.person_wbc_service_id = person_wbc_service.person_wbc_service_id
                left join  wbc_vaccine on person_wbc_vaccine_detail.wbc_vaccine_id  = wbc_vaccine.wbc_vaccine_id
                where  person_wbc_service.vn <> ''
                HAVING chk is null) wbc_chk  on ovst.vn = wbc_chk.vn
                where ovst.vn like '$vn4digit%'

                UNION

                select 'EP2002' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'EP2002'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC
                from ovst 
                INNER JOIN (SELECT person_epi_vaccine.vn,epi_vaccine.epi_vaccine_name,
                (case when epi_vaccine.export_vaccine_code in('034','035') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z271') 
                ELSE
                    (case when epi_vaccine.export_vaccine_code in('084','085') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z240') 
                        ELSE
                         (case when epi_vaccine.export_vaccine_code in('051','052','053') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z241') 
                            ELSE
                                (case when epi_vaccine.export_vaccine_code in('J11','J12') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z241') 
                                ELSE
                                    (case when epi_vaccine.export_vaccine_code in('073') then  (select icd10 from ovstdiag where vn = person_epi_vaccine.vn and icd10 = 'Z274') END) 
                                END)
                            END) 
                        END )
                END ) chk
                from person_epi_vaccine_list
                left join epi_vaccine on person_epi_vaccine_list.epi_vaccine_id = epi_vaccine.epi_vaccine_id 
                left join person_epi_vaccine on person_epi_vaccine_list.person_epi_vaccine_id = person_epi_vaccine.person_epi_vaccine_id
                where person_epi_vaccine.vn <>'' 
                HAVING chk is null )epi_chk on ovst.vn = epi_chk.vn
                where ovst.vn like '$vn4digit%'


                UNION

                select 'EP2003' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'EP2003'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC
                from ovst 
                INNER JOIN (SELECT village_student_vaccine.vn,student_vaccine.student_vaccine_name,village_student.person_id ,
                (case when student_vaccine.export_vaccine_code in('021','022','023','024') then  (select GROUP_CONCAT(icd10) from ovstdiag where vn = village_student_vaccine.vn and icd10 in('Z235','Z236')) 
                ELSE
                    (case when student_vaccine.export_vaccine_code in('011') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z232') 
                    ELSE 
                            (case when student_vaccine.export_vaccine_code in('072','073') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z274') 
                                ELSE
                                    (case when student_vaccine.export_vaccine_code in('086','087','088','402') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z240') 
                                        ELSE
                                            (case when student_vaccine.export_vaccine_code in('075') then (select GROUP_CONCAT(icd10) from ovstdiag where vn = village_student_vaccine.vn and icd10 in('Z244','Z245')) 
                                                ELSE
                                                    (case when student_vaccine.export_vaccine_code in('310','320','311') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z258') 
                                                        ELSE
                                                            (case when student_vaccine.export_vaccine_code in('044','045','046') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z246') 
                                                                ELSE
                                                                    (case when student_vaccine.export_vaccine_code in('054','055') then  (select icd10 from ovstdiag where vn = village_student_vaccine.vn and icd10 = 'Z241') END)
                                                                END)
                                                        END)
                                                END)
                                        END)                
                                END ) 
                        END)
                END) chk
                from village_student_vaccine_list
                left JOIN village_student_vaccine  on village_student_vaccine_list.village_student_vaccine_id = village_student_vaccine.village_student_vaccine_id
                LEFT JOIN student_vaccine on village_student_vaccine_list.student_vaccine_id = student_vaccine.student_vaccine_id
                LEFT JOIN village_student on village_student_vaccine.village_student_id = village_student.village_student_id 
                where village_student_vaccine.vn <> ''
                HAVING chk is null)student_chk on ovst.vn = student_chk.vn
                LEFT JOIN patient on ovst.hn = patient.hn 
                where ovst.vn like '$vn4digit%'




                UNION

                select 'EP9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'EP9902'  ) as 'ERROR_DETAIL' ,ifnull(count(DISTINCT(ovst.vn)),0) as CC
                    from ovst
                    inner join (
                    select village_student_vaccine.vn ,  ovst_vaccine.vn as vn_chk 
                    from village_student_vaccine
                    left join village_student on village_student_vaccine.village_student_id =  village_student.village_student_id
                    left join village_student_vaccine_list on village_student_vaccine.village_student_vaccine_id = village_student_vaccine_list.village_student_vaccine_id
                    left join ovst_vaccine on village_student_vaccine.vn  = ovst_vaccine.vn
                    HAVING vn_chk is not null
                    ) student_vaccine on student_vaccine.vn =  ovst.vn
                    where ovst.vn like '$vn4digit%'


                 order by CC desc , ERROR_CODE ";


    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='epi_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}





function get_rows_Epi_Error_detail_list($error_code,$vn4digit, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {

        
        if($error_code=='EP9901'){
            $sql1 = $result['sql_script'];
        }else{
            $sql1 = $result['sql_script']." like '$vn4digit%'";

        }

        
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th>PID</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>วันเกิด</th>
                                      <th>วันที่รับวัคซีน</th>
                                      <th>ชื่อวัคซีน</th>
                                      <th>การลงรับวัคซีน</th>
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        //$age_y = $result['Items'];
        $person_id = $result['pid'];
        $cid = $result['cid'];
        
        $birthdate = get_date_show($result['birthdate']);
        $date_service = get_date_show($result['date_service']);
        $vcc_code = $result['vcc_code'];
        $Items = $result['Items'];
        
        if($error_code=='EP9901'){
            if($result['Items']=='WBC'){
                   $Items = "บัญชี 3";
                }else{
                 if($result['Items']=='EPI'){
                        $Items = "บัญชี 4-5";
                    }else{
                            $Items = "จากที่อื่น";
                        }
                }
        }else{

                if($result['Items']=='WBC'){
                   $Items = "บัญชี 3";
                }else{
                 if($result['Items']=='EPI'){
                        $Items = "บัญชี 4 ";
                    }else{
                            $Items = "บัญชี 5";
                        }
                }
        }



    
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$birthdate</td>
                                      <td>$date_service</td>
                                      <td>$vcc_code</td>
                                      <td>$Items</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}






function get_last_day_of_month($date_sel) {
    $sql = "select LAST_DAY('$date_sel') as last_date";
    //echo $sql;
    $query = mysql_query($sql);
    while ($result = mysql_fetch_array($query)) {
        $last_date = $result['last_date'];
    }
    return $last_date;
}


function get_row_Nutrition_Error_all($vn4digit) {

       
    $Y_str = '25'.substr($vn4digit,0,2) ;
    $first_day= ($Y_str-543).'-'.substr($vn4digit,2,2).'-'.'01';
    $last_day= get_last_day_of_month($first_day);
    //$dst =  date_add('$first_day',date_interval_create_from_date_string("-270 days"));
    //echo $dst;

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

    //echo ' -det30 =  '.$det30 . '-/- dst230 ='.$dst230 ;



        
   // $det =  DATE_ADD(@ds1, INTERVAL -299 DAY) ;
   // $dst2 =  DATE_ADD(@ds2, INTERVAL -270 DAY) ;
   // $det2 =  DATE_ADD(@ds2, INTERVAL -299 DAY) ;
    $sql = " select 'NU9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            FROM person 
            LEFT JOIN (SELECT nutrition_date ,person_wbc.person_id
            from person_wbc_nutrition
            LEFT JOIN person_wbc on person_wbc_nutrition.person_wbc_id = person_wbc.person_wbc_id
            ) person_chk on person.person_id = person_chk.person_id 
             and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 9 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 9 month)), INTERVAL 29 day)
            where birthdate between '$det' and '$dst2' and person.house_regist_type_id in(1,3) and person_chk.nutrition_date is null

            UNION


            select 'NU9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            FROM person 
            LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
            from person_epi_nutrition
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
            ) person_chk on person.person_id = person_chk.person_id 
            and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 18 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 18 month)), INTERVAL 29 day)
            where birthdate between '$det18' and '$dst218' and person.house_regist_type_id in(1,3) and person_chk.nutrition_date is null


            UNION


            select 'NU9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            FROM person 
            LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
            from person_epi_nutrition
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
            ) person_chk on person.person_id = person_chk.person_id 
            and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 30 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 30 month)), INTERVAL 29 day)
            where birthdate between '$det30' and '$dst230' and person.house_regist_type_id in(1,3) and person_chk.nutrition_date is null



            UNION


            select 'NU9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9904'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            FROM person 
             LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
            from person_epi_nutrition
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
            ) person_chk on person.person_id = person_chk.person_id 
            and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 42 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 42 month)), INTERVAL 29 day)
            where birthdate between '$det42' and '$dst242' and person.house_regist_type_id in(1,3) and person_chk.nutrition_date is null



            UNION

            select 'NU1190' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU1190'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            from person
            INNER JOIN (SELECT person_epi.person_id ,person_epi_nutrition.body_weight ,person_epi_nutrition.nutrition_date ,person_epi_nutrition.vn 
                 , person_epi_nutrition.age_y , person_epi_nutrition.age_m
            from person_epi_nutrition 
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id 
            where body_weight > 30
            UNION
            SELECT person_wbc.person_id ,person_wbc_nutrition.body_weight,person_wbc_nutrition.nutrition_date ,person_wbc_nutrition.vn 
                    , person_wbc_nutrition.age_y, person_wbc_nutrition.age_m
            from person_wbc_nutrition
            LEFT JOIN person_wbc on person_wbc_nutrition.person_wbc_id = person_wbc.person_wbc_id 
            where body_weight > 15 ) person_chk on person.person_id = person_chk.person_id
            where person_chk.vn like '$vn4digit%'

            UNION

            select 'NU1141' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU1141'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            from person
            INNER JOIN (SELECT person_epi.person_id ,person_epi_nutrition.body_weight ,person_epi_nutrition.nutrition_date ,person_epi_nutrition.vn 
                 , person_epi_nutrition.age_y , person_epi_nutrition.age_m
            from person_epi_nutrition 
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id 
            where body_weight = '' or  body_weight is null
            UNION
            SELECT person_wbc.person_id ,person_wbc_nutrition.body_weight,person_wbc_nutrition.nutrition_date ,person_wbc_nutrition.vn 
                    , person_wbc_nutrition.age_y, person_wbc_nutrition.age_m
            from person_wbc_nutrition
            LEFT JOIN person_wbc on person_wbc_nutrition.person_wbc_id = person_wbc.person_wbc_id 
            where body_weight = '' or  body_weight is null ) person_chk on person.person_id = person_chk.person_id
            where person_chk.vn  like '$vn4digit%'






                UNION

                select 'NU9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NU9299'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
                from person_wbc
                inner JOIN (SELECT person_id 
                from person_wbc 
                GROUP BY person_id HAVING  count(person_wbc_id) > 1) person_wbc_chk on person_wbc.person_id = person_wbc_chk.person_id

            
                UNION


                select 'NU9298' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NU9298'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_epi.person_id)),0) as CC 
                from person_epi
                inner JOIN (SELECT person_id 
                from person_epi 
                GROUP BY person_id HAVING  count(person_epi_id) > 1) person_wbc_chk on person_epi.person_id = person_wbc_chk.person_id



                UNION

                 select 'NU9401' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NU9401'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_epi.person_id)),0) as CC 
                     from person_epi
                     left JOIN person on person_epi.person_id = person.person_id
                     inner JOIN (select person_id,person_epi_vaccine.vn
                    from  person_epi_vaccine
                    left join  person_epi on person_epi_vaccine.person_epi_id = person_epi.person_epi_id
                        where wbc_development_assess_id = 2) person_epi_chk on person_epi.person_id = person_epi_chk.person_id 
                    where  person_epi_chk.vn like '$vn4digit%'



                 UNION

                 select 'NU9301' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NU9301'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
                    from person_wbc
                     left JOIN person on person_wbc.person_id = person.person_id
                     inner JOIN (select person_id,person_wbc_service.vn
                    from  person_wbc_service
                    left join  person_wbc on person_wbc_service.person_wbc_id = person_wbc.person_wbc_id
                    where wbc_development_assess_id = 2) person_wbc_chk on person_wbc.person_id = person_wbc_chk.person_id  
                    where person_wbc_chk.vn like '$vn4digit%'




                UNION

                select 'NU9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9905'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
                    from person 
                    INNER JOIN (
                    SELECT ovst.vn as ov_vn ,pp_special.vn as pp_vn, person_chk.*
                    from ovst
                    RIGHT   join (
                    SELECT '9' as items,person.*, person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_wbc.person_id
                                from person_wbc_nutrition
                                LEFT JOIN person_wbc on person_wbc_nutrition.person_wbc_id = person_wbc.person_wbc_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                 and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 9 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 9 month)), INTERVAL 29 day)
                                where birthdate between '$det' and '$dst2' and person.house_regist_type_id in(1,3) 

                    UNION
                    SELECT '18' as items,person.* ,person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
                                from person_epi_nutrition
                                LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 18 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 18 month)), INTERVAL 29 day)
                                where birthdate between '$det18' and '$dst218'  and person.house_regist_type_id in(1,3) 
                    UNION

                    SELECT '30' as items,person.* ,person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
                                from person_epi_nutrition
                                LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 30 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 30 month)), INTERVAL 29 day)
                                where birthdate between '$det30' and '$dst230'  and person.house_regist_type_id in(1,3) 
                    UNION

                    SELECT '42' as items,person.* ,person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
                                from person_epi_nutrition
                                LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 42 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 42 month)), INTERVAL 29 day)
                                where birthdate between '$det42' and '$dst242'  and person.house_regist_type_id in(1,3) 
                    ) person_chk on ovst.vstdate = person_chk.nutrition_date and ovst.hn = person_chk.patient_hn
                    LEFT JOIN pp_special on ovst.vn = pp_special.vn
                    where pp_special.vn is null 
                    ) person_pp_chk on person.person_id = person_pp_chk.person_id

                     where concat(mid((year(person_pp_chk.nutrition_date)+543),3,2),LPAD(month(person_pp_chk.nutrition_date),2,'0')) like'$vn4digit%'

           ";

   // echo $sql;    
           $CC = 0;
            $query = mysql_query($sql);
            $rows = mysql_num_rows($query) or die(mysql_error());
            while ($result = mysql_fetch_array($query)) {
                $CC = $CC + number_format($result['CC']);
            }

    
    return $CC;
}




function get_rows_Nutrition_Error_detail($vn4digit) {

    $Y_str = '25'.substr($vn4digit,0,2) ;
    $first_day= ($Y_str-543).'-'.substr($vn4digit,2,2).'-'.'01';
    $last_day= get_last_day_of_month($first_day);
    //$dst =  date_add('$first_day',date_interval_create_from_date_string("-270 days"));
    //echo $dst;
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



    $sql = " select 'NU9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            FROM person 
            LEFT JOIN (SELECT nutrition_date ,person_wbc.person_id
            from person_wbc_nutrition
            LEFT JOIN person_wbc on person_wbc_nutrition.person_wbc_id = person_wbc.person_wbc_id
            ) person_chk on person.person_id = person_chk.person_id 
             and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 9 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 9 month)), INTERVAL 29 day)
            where birthdate between '$det' and '$dst2' and person.house_regist_type_id in(1,3) and person_chk.nutrition_date is null

            UNION


            select 'NU9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            FROM person 
            LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
            from person_epi_nutrition
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
            ) person_chk on person.person_id = person_chk.person_id 
            and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 18 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 18 month)), INTERVAL 29 day)
            where birthdate between '$det18' and '$dst218' and person.house_regist_type_id in(1,3) and person_chk.nutrition_date is null


            UNION


            select 'NU9903' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9903'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            FROM person 
            LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
            from person_epi_nutrition
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
            ) person_chk on person.person_id = person_chk.person_id 
            and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 30 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 30 month)), INTERVAL 29 day)
            where birthdate between '$det30' and '$dst230' and person.house_regist_type_id in(1,3) and person_chk.nutrition_date is null



            UNION


            select 'NU9904' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9904'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            FROM person 
             LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
            from person_epi_nutrition
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
            ) person_chk on person.person_id = person_chk.person_id 
            and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 42 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 42 month)), INTERVAL 29 day)
            where birthdate between '$det42' and '$dst242' and person.house_regist_type_id in(1,3) and person_chk.nutrition_date is null



            UNION

            select 'NU1190' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU1190'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            from person
            INNER JOIN (SELECT person_epi.person_id ,person_epi_nutrition.body_weight ,person_epi_nutrition.nutrition_date ,person_epi_nutrition.vn 
                 , person_epi_nutrition.age_y , person_epi_nutrition.age_m
            from person_epi_nutrition 
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id 
            where body_weight > 30
            UNION
            SELECT person_wbc.person_id ,person_wbc_nutrition.body_weight,person_wbc_nutrition.nutrition_date ,person_wbc_nutrition.vn 
                    , person_wbc_nutrition.age_y, person_wbc_nutrition.age_m
            from person_wbc_nutrition
            LEFT JOIN person_wbc on person_wbc_nutrition.person_wbc_id = person_wbc.person_wbc_id 
            where body_weight > 15 ) person_chk on person.person_id = person_chk.person_id
            where person_chk.vn like '$vn4digit%'



            UNION

            select 'NU1141' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU1141'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
            from person
            INNER JOIN (SELECT person_epi.person_id ,person_epi_nutrition.body_weight ,person_epi_nutrition.nutrition_date ,person_epi_nutrition.vn 
                 , person_epi_nutrition.age_y , person_epi_nutrition.age_m
            from person_epi_nutrition 
            LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id 
            where body_weight = '' or  body_weight is null
            UNION
            SELECT person_wbc.person_id ,person_wbc_nutrition.body_weight,person_wbc_nutrition.nutrition_date ,person_wbc_nutrition.vn 
                    , person_wbc_nutrition.age_y, person_wbc_nutrition.age_m
            from person_wbc_nutrition
            LEFT JOIN person_wbc on person_wbc_nutrition.person_wbc_id = person_wbc.person_wbc_id 
            where body_weight = '' or  body_weight is null ) person_chk on person.person_id = person_chk.person_id
            where person_chk.vn  like '$vn4digit%'


                UNION

                select 'NU9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NU9299'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
                from person_wbc
                inner JOIN (SELECT person_id 
                from person_wbc 
                GROUP BY person_id HAVING  count(person_wbc_id) > 1) person_wbc_chk on person_wbc.person_id = person_wbc_chk.person_id

            
                UNION


                select 'NU9298' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NU9298'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_epi.person_id)),0) as CC 
                from person_epi
                inner JOIN (SELECT person_id 
                from person_epi 
                GROUP BY person_id HAVING  count(person_epi_id) > 1) person_wbc_chk on person_epi.person_id = person_wbc_chk.person_id


                UNION

                 select 'NU9401' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NU9401'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_epi.person_id)),0) as CC 
                     from person_epi
                     left JOIN person on person_epi.person_id = person.person_id
                     inner JOIN (select person_id,person_epi_vaccine.vn
                    from  person_epi_vaccine
                    left join  person_epi on person_epi_vaccine.person_epi_id = person_epi.person_epi_id
                    where wbc_development_assess_id = 2) person_epi_chk on person_epi.person_id = person_epi_chk.person_id  

                    where  person_epi_chk.vn like '$vn4digit%'


                 UNION

                 select 'NU9301' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'NU9301'  ) as 'ERROR_DETAIL' , ifnull(count(DISTINCT(person_wbc.person_id)),0) as CC 
                    from person_wbc
                     left JOIN person on person_wbc.person_id = person.person_id
                     inner JOIN (select person_id,person_wbc_service.vn
                    from  person_wbc_service
                    left join  person_wbc on person_wbc_service.person_wbc_id = person_wbc.person_wbc_id
                    where wbc_development_assess_id = 2) person_wbc_chk on person_wbc.person_id = person_wbc_chk.person_id  
                    where person_wbc_chk.vn like '$vn4digit%'


                UNION

                select 'NU9905' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where     ERROR_CODE = 'NU9905'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(person.person_id)),0) as CC
                    from person 
                    INNER JOIN (
                    SELECT ovst.vn as ov_vn ,pp_special.vn as pp_vn, person_chk.*
                    from ovst
                    RIGHT   join (
                    SELECT '9' as items,person.*, person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_wbc.person_id
                                from person_wbc_nutrition
                                LEFT JOIN person_wbc on person_wbc_nutrition.person_wbc_id = person_wbc.person_wbc_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                 and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 9 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 9 month)), INTERVAL 29 day)
                                where birthdate between '$det' and '$dst2' and person.house_regist_type_id in(1,3) 

                    UNION
                    SELECT '18' as items,person.* ,person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
                                from person_epi_nutrition
                                LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 18 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 18 month)), INTERVAL 29 day)
                                where birthdate between '$det18' and '$dst218'  and person.house_regist_type_id in(1,3) 
                    UNION

                    SELECT '30' as items,person.* ,person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
                                from person_epi_nutrition
                                LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 30 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 30 month)), INTERVAL 29 day)
                                where birthdate between '$det30' and '$dst230'  and person.house_regist_type_id in(1,3) 
                    UNION

                    SELECT '42' as items,person.* ,person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
                                from person_epi_nutrition
                                LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 42 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 42 month)), INTERVAL 29 day)
                                where birthdate between '$det42' and '$dst242'  and person.house_regist_type_id in(1,3) 
                    ) person_chk on ovst.vstdate = person_chk.nutrition_date and ovst.hn = person_chk.patient_hn
                    LEFT JOIN pp_special on ovst.vn = pp_special.vn
                    where pp_special.vn is null 
                    ) person_pp_chk on person.person_id = person_pp_chk.person_id

                    where concat(mid((year(person_pp_chk.nutrition_date)+543),3,2),LPAD(month(person_pp_chk.nutrition_date),2,'0')) like'$vn4digit%'


            order by CC desc , ERROR_CODE ";


    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='nutrition_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}





function get_rows_Nutrition_Error_detail_list($error_code,$vn4digit, $xls) {
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




    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);
   
    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    switch ($error_code) {
        case 'NU9901':
             $sql1 = $sql1." and  birthdate between '$det' and '$dst2' GROUP BY person.person_id ";
            break;

        case 'NU9902':
             $sql1 = $sql1." and  birthdate between '$det18' and '$dst218' GROUP BY person.person_id ";
            break;

        case 'NU9903':
             $sql1 = $sql1." and  birthdate between '$det30' and '$dst230' GROUP BY person.person_id ";
            break;

        case 'NU9904':
             $sql1 = $sql1." and  birthdate between '$det42' and '$dst242' GROUP BY person.person_id ";
            break;

        case 'NU9905':
             $sql1 = " select concat(person.pname ,'',person.fname,' ',person.lname) as ptname,person.cid,person.person_id  as pid ,person.birthdate  , person_pp_chk.nutrition_date  as '@start_date' , 
                       person_pp_chk.nutrition_date as '@end_date' 
                    from person 
                    INNER JOIN (
                    SELECT ovst.vn as ov_vn ,pp_special.vn as pp_vn, person_chk.*
                    from ovst
                    RIGHT   join (
                    SELECT '9' as items,person.*, person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_wbc.person_id
                                from person_wbc_nutrition
                                LEFT JOIN person_wbc on person_wbc_nutrition.person_wbc_id = person_wbc.person_wbc_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                 and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 9 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 9 month)), INTERVAL 29 day)
                                where birthdate between '$det' and '$dst2' and person.house_regist_type_id in(1,3) 

                    UNION
                    SELECT '18' as items,person.* ,person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
                                from person_epi_nutrition
                                LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 18 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 18 month)), INTERVAL 29 day)
                                where birthdate between '$det18' and '$dst218'  and person.house_regist_type_id in(1,3) 
                    UNION

                    SELECT '30' as items,person.* ,person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
                                from person_epi_nutrition
                                LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 30 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 30 month)), INTERVAL 29 day)
                                where birthdate between '$det30' and '$dst230'  and person.house_regist_type_id in(1,3) 
                    UNION

                    SELECT '42' as items,person.* ,person_chk.nutrition_date
                    FROM person 
                                LEFT JOIN (SELECT nutrition_date ,person_epi.person_id
                                from person_epi_nutrition
                                LEFT JOIN person_epi on person_epi_nutrition.person_epi_id = person_epi.person_epi_id
                                ) person_chk on person.person_id = person_chk.person_id 
                                and person_chk.nutrition_date BETWEEN DATE_ADD(person.birthdate, INTERVAL 42 month) and DATE_ADD((DATE_ADD(person.birthdate, INTERVAL 42 month)), INTERVAL 29 day)
                                where birthdate between '$det42' and '$dst242'  and person.house_regist_type_id in(1,3) 
                    ) person_chk on ovst.vstdate = person_chk.nutrition_date and ovst.hn = person_chk.patient_hn
                    LEFT JOIN pp_special on ovst.vn = pp_special.vn
                    where pp_special.vn is null 
                    ) person_pp_chk on person.person_id = person_pp_chk.person_id
                    
                     where concat(mid((year(person_pp_chk.nutrition_date)+543),3,2),LPAD(month(person_pp_chk.nutrition_date),2,'0')) like'$vn4digit%'
";
            break;

        case 'NU9299':
             $sql1 = $sql1 ;
            break;


        case 'NU9298':
             $sql1 = $sql1 ;
            break;

        default:
             $sql1 = $sql1." like '$vn4digit%' ";
            break;
    }

      
        

    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th>PID</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>วันเกิด</th>
                                      <th>ช่วงที่ควรบันทึก</th>
                                      
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);


    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];        
        $person_id = $result['pid'];
        $cid = $result['cid'];        
        $birthdate = get_date_show($result['birthdate']);
        $start_date = get_date_show($result['@start_date']);
        $end_date = get_date_show($result['@end_date']);

        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td> $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$birthdate</td>
                                      <td>[$start_date ถึง  $end_date]</td>
  
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}















function get_rows_Special_pp_Error_all($vn4digit) {

    $sql = "select 'SP9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SP9299'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.vn),0) as CC 
                   from ovst
                    INNER JOIN (SELECT vn
                    from pp_special 
                    GROUP BY vn
                    HAVING  count(DISTINCT(pp_special_type_id)) <> COUNT(pp_special_type_id)) pp_special_chk on ovst.vn = pp_special_chk.vn
              where ovst.vn like'$vn4digit%' 

              UNION


              select 'SP9298' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SP9298'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT ovst.hn),0) as CC 
                from ovst
                INNER JOIN (
                select  ovst.hn,ovst.vstdate,group_concat(distinct(pp_special.vn)) as vn_chk , count(distinct(pp_special.vn)) as CC
                from pp_special
                inner join ovst on  pp_special.vn = ovst.vn
                where pp_special.vn like'$vn4digit%' 
                group by ovst.hn,ovst.vstdate
                having  count(*)  <> count(distinct(pp_special_type_id))  and count(distinct(pp_special.vn)) > 1 ) sp_chk on ovst.hn = sp_chk.hn 
                where  sp_chk.vstdate = ovst.vstdate and ovst.vn like'$vn4digit%'  


                UNION

                select 'SP9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SP9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT ovst_seq.vn),0) as CC 
                from pp_special 
                left JOIN pp_special_type on pp_special.pp_special_type_id = pp_special_type.pp_special_type_id
                left JOIN ovst_seq on pp_special.vn = ovst_seq.vn
                left JOIN person on ovst_seq.pcu_person_id = person.person_id
                where pp_special_type.pp_special_code in('1B0030','1B0031','1B0032','1B0033','1B0034','1B0035','1B0036','1B0037','1B0039')
                and person.sex = 1  and ovst_seq.vn like'$vn4digit%'  
              ";




    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}







function get_rows_Special_pp_Error_detail($vn4digit) {
    $date_stage_ment = get_month_stagement($vn4digit);
    $sql = "select 'SP9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SP9299'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.vn),0) as CC 
                   from ovst
                    INNER JOIN (SELECT vn
                    from pp_special 
                    GROUP BY vn
                    HAVING  count(DISTINCT(pp_special_type_id)) <> COUNT(pp_special_type_id)) pp_special_chk on ovst.vn = pp_special_chk.vn
              where ovst.vn like'$vn4digit%'


              UNION


              select 'SP9298' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SP9298'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT ovst.hn),0) as CC 
                from ovst
                INNER JOIN (
                select  ovst.hn,ovst.vstdate,group_concat(distinct(pp_special.vn)) as vn_chk , count(distinct(pp_special.vn)) as CC
                from pp_special
                inner join ovst on  pp_special.vn = ovst.vn
                where pp_special.vn like'$vn4digit%' 
                group by ovst.hn,ovst.vstdate
                having  count(*)  <> count(distinct(pp_special_type_id))  and count(distinct(pp_special.vn)) > 1 ) sp_chk on ovst.hn = sp_chk.hn 
                where  sp_chk.vstdate = ovst.vstdate and ovst.vn like'$vn4digit%'  

                UNION

                select 'SP9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SP9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT ovst_seq.vn),0) as CC 
                from pp_special 
                left JOIN pp_special_type on pp_special.pp_special_type_id = pp_special_type.pp_special_type_id
                left JOIN ovst_seq on pp_special.vn = ovst_seq.vn
                left JOIN person on ovst_seq.pcu_person_id = person.person_id
                where pp_special_type.pp_special_code in('1B0030','1B0031','1B0032','1B0033','1B0034','1B0035','1B0036','1B0037','1B0039')
                and person.sex = 1  and ovst_seq.vn like'$vn4digit%'  




                 order by CC desc , ERROR_CODE ";
    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='specialpp_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}




function get_rows_Special_pp_Error_detail_list($error_code, $vn4digit, $xls) {


    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>HN</th>
                                      <th>วันที่รับบริการ</th>
                                      <th>เวลารับบริการ</th>
                                                                            
                                 </tr>

                                      ";
    $i = 0;

    switch ($error_code) {
        case 'SP9298':
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
                        where  pp_special_chk.vstdate = ovst.vstdate  and ovst.vn like'$vn4digit%' ";
            break;
        
        default:
             $sql1 = $sql1. "  like'$vn4digit%'";
            break;
    }

    

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $hn = $result['hn'];
        $cid = $result['cid'];
        $TIMEServ = $result['vsttime'];
        $pp_special_code = $result['pp_special_code'];
        //$service_id = $result['person_women_service_id'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>                                     
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$hn</td>
                                      <td>$DATEServ</td>
                                      <td>$TIMEServ</td>
                                   
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}









function get_rows_Chronic_Error_all($vn4digit) {

    $sql = "select 'CH9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CH9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                from person_chronic 
                left join person on person_chronic.person_id = person.person_id
                LEFT JOIN patient on person.cid = patient.cid
                left join clinicmember on patient.hn = clinicmember.hn
                LEFT JOIN village on person.village_id = village.village_id
                left join house on person.house_id = house.house_id
                where clinicmember.hn is null and person.person_discharge_id <>'1'
                and person_chronic.clinic in('002','001')

                UNION

                select 'CH9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CH9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(clinicmember.hn),0) as CC 
                from clinicmember 
                left JOIN patient on clinicmember.hn = patient.hn
                left JOIN person on patient.cid = person.cid
                LEFT JOIN person_chronic on person.person_id = person_chronic.person_id
                LEFT JOIN village on person.village_id = village.village_id
                left join house on person.house_id = house.house_id
                where clinicmember.clinic in('001','002') and person.village_id <> 1 and person.person_discharge_id <> 1 
                and clinicmember.clinic_member_status_id <> 3
                and person_chronic.person_id is null


              ";

    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}




function get_rows_Chronic_Error_detail($vn4digit) {
    $date_stage_ment = get_month_stagement($vn4digit);
    $sql = "select 'CH9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CH9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                from person_chronic 
                left join person on person_chronic.person_id = person.person_id
                LEFT JOIN patient on person.cid = patient.cid
                left join clinicmember on patient.hn = clinicmember.hn
                LEFT JOIN village on person.village_id = village.village_id
                left join house on person.house_id = house.house_id
                where clinicmember.hn is null and person.person_discharge_id <>'1'
                and person_chronic.clinic in('002','001') 

                
                UNION

                select 'CH9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CH9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(clinicmember.hn),0) as CC 
                from clinicmember 
                left JOIN patient on clinicmember.hn = patient.hn
                left JOIN person on patient.cid = person.cid
                LEFT JOIN person_chronic on person.person_id = person_chronic.person_id
                LEFT JOIN village on person.village_id = village.village_id
                left join house on person.house_id = house.house_id
                where clinicmember.clinic in('001','002') and person.village_id <> 1 and person.person_discharge_id <> 1 
                and clinicmember.clinic_member_status_id <> 3
                and person_chronic.person_id is null

                 order by CC desc , ERROR_CODE ";
    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='chronic_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}





function get_rows_Chronic_Error_detail_list($error_code, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th> PID</th>
                                      <th> ชื่อ - สกุล </th>
                                      <th> CID</th>
                                      <th> อายุ</th>
                                      <th> ที่อยู่</th>
                                      <th> วันที่เลงทะเบียน</th>
                                      <th> ปีที่เริ่มเป็น</th>
                                      <th> คลีนิก</th>
                                 </tr>

                                      ";
    $i = 0;

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['pt_name'];
        $age_y = $result['age_y'];
        $person_id = $result['person_id'];
        $cid = $result['cid'];
        $hous_addr = $result['hous_addr'];
        $register_date = get_date_show($result['regdate']);
        $begin_year = $result['begin_year'];
        $clinic = $result['clinic'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "            <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$age_y</td>
                                      <td>$hous_addr</td>
                                      <td>$register_date</td>
                                      <td>$begin_year</td>
                                      <td>$clinic</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}




function get_rows_Address_Error_all($vn4digit) {

    $sql = "select 'AR9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AR9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                    from person
                    inner JOIN (SELECT person.person_id from patient 
                    INNER JOIN person on patient.cid = person.cid 
                    LEFT JOIN person_address on person.person_id = person_address.person_id
                    where person.house_regist_type_id in('4') and concat(patient.chwpart ,patient.amppart, patient.tmbpart) = (SELECT concat(chwpart,amppart,tmbpart) from hospcode where hospcode = (SELECT  hospitalcode FROM opdconfig))
                    and person_address.person_id is NULL and year(person.last_update) <= year(CURDATE()) 
                    UNION
                    SELECT person.person_id from person 
                    LEFT JOIN person_address on person.person_id = person_address.person_id
                    where person.house_regist_type_id in('3') and person_address.person_id is null 
                    UNION
                    SELECT person.person_id from person 
                        LEFT JOIN person_address on person.person_id = person_address.person_id
                            where person.house_regist_type_id in('1') and person_address.chwpart = '42'
                                and person_address.amppart = '12' and person_address.tmbpart = '03') person_chk on person.person_id = person_chk.person_id
  

                ";

    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}

function get_rows_Address_Error_detail($vn4digit) {
    $date_stage_ment = get_month_stagement($vn4digit);
    $sql = " select 'AR9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'AR9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(person.person_id),0) as CC 
                    from person
                    inner JOIN (SELECT person.person_id from patient 
                    INNER JOIN person on patient.cid = person.cid 
                    LEFT JOIN person_address on person.person_id = person_address.person_id
                    where person.house_regist_type_id in('4') and concat(patient.chwpart ,patient.amppart, patient.tmbpart) = (SELECT concat(chwpart,amppart,tmbpart) from hospcode where hospcode = (SELECT  hospitalcode FROM opdconfig))
                    and person_address.person_id is NULL and year(person.last_update) <= year(CURDATE()) 
                    UNION
                    SELECT person.person_id from person 
                    LEFT JOIN person_address on person.person_id = person_address.person_id
                    where person.house_regist_type_id in('3') and person_address.person_id is null 
                    UNION
                    SELECT person.person_id from person 
                        LEFT JOIN person_address on person.person_id = person_address.person_id
                            where person.house_regist_type_id in('1') and person_address.chwpart = '42'
                                and person_address.amppart = '12' and person_address.tmbpart = '03') person_chk on person.person_id = person_chk.person_id

                 order by CC desc , ERROR_CODE ";
    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='address_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}



function get_rows_Address_Error_detail_list($error_code, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th> PID</th>
                                      <th> ชื่อ - สกุล </th>
                                      <th> CID</th>
                                      <th> อายุ</th>
                                      <th> ที่อยู่-ปัจจุบัน</th>
                                      <th> ที่อยู่-เดิม</th>
                                      <th> ที่อยู่-ใหม่</th>
                                 </tr>






                                      ";
    $i = 0;

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['pt_name'];
        $age_y = $result['age_y'];
        $person_id = $result['person_id'];
        $cid = $result['cid'];
        $hous_addr = $result['hous_addr'];
        $hous_old = $result['house_old'];
        $hous_new = $result['house_new'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>
                                      <td>$person_id</td>
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$age_y</td>
                                      <td>$hous_addr</td>
                                      <td>$hous_old</td>
                                      <td>$hous_new</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}





function get_rows_Functional_Error_all($vn4digit) {

    $sql = "select 'FN2107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN2107'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
            FROM ovst_functional 
            where (ovst_functional_dependent_type_id is null or ovst_functional_dependent_type_id = '')) function_chk on ovst.vn = function_chk.vn
            where ovst.vn  like'$vn4digit%' 


            UNION


            select 'FN9202' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN9202'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
            FROM ovst_functional 
            where (ovst_functional_type_id is null or ovst_functional_type_id = '')) function_chk on ovst.vn = function_chk.vn
            left join patient on ovst.hn = patient.hn
            where ovst.vn like'$vn4digit%' 

            UNION

            select 'FN1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN1106'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
            FROM ovst_functional 
            where (ovst_functional_score is null )) function_chk on ovst.vn = function_chk.vn
            left join patient on ovst.hn = patient.hn
            where ovst.vn like'$vn4digit%' 

            UNION

            select 'FN2108' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN2108'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
                                FROM ovst_functional 
                                where (ovst_functional_score is not null) and ovst_functional_score BETWEEN 0 and 4 and ovst_functional_dependent_type_id <> 3
                                UNION
                                SELECT vn 
                                FROM ovst_functional 
                                where (ovst_functional_score is not null) and ovst_functional_score BETWEEN 5 and 11 and ovst_functional_dependent_type_id <> 2
                                UNION
                                SELECT vn 
                                FROM ovst_functional 
                                where (ovst_functional_score is not null) and ovst_functional_score BETWEEN  12 and 20 and ovst_functional_dependent_type_id <> 1

                                    ) function_chk on ovst.vn = function_chk.vn
            left join patient on ovst.hn = patient.hn
            where ovst.vn like'$vn4digit%' 

            UNION

            
            select 'FN2109' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN2109'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
                                    FROM ovst_functional 
                                    where ovst_functional_dependent_type_id = 3 
                                        and (SELECT vn from ovstdiag where icd10 ='Z508' and vn = ovst_functional.vn) is null

                                    UNION
                                    SELECT vn 
                                    FROM ovst_functional 
                                    where ovst_functional_dependent_type_id = 2 
                                         and (SELECT vn from ovstdiag where icd10 ='Z749' and vn = ovst_functional.vn) is null

                                    UNION
                                    SELECT vn 
                                    FROM ovst_functional 
                                    where ovst_functional_dependent_type_id = 1 
                                         and (SELECT vn from ovstdiag where icd10 ='Z718' and vn = ovst_functional.vn) is null
            ) function_chk on ovst.vn = function_chk.vn
            left join patient on ovst.hn = patient.hn
            where ovst.vn like'$vn4digit%'


                ";

    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}





function get_rows_Functional_Error_detail($vn4digit) {
    //$date_stage_ment = get_month_stagement($vn4digit);
    $sql = " select 'FN2107' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN2107'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
            FROM ovst_functional 
            where (ovst_functional_dependent_type_id is null or ovst_functional_dependent_type_id = '')) function_chk on ovst.vn = function_chk.vn
            where ovst.vn  like'$vn4digit%' 


            UNION


            select 'FN9202' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN9202'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
            FROM ovst_functional 
            where (ovst_functional_type_id is null or ovst_functional_type_id = '')) function_chk on ovst.vn = function_chk.vn
            left join patient on ovst.hn = patient.hn
            where ovst.vn like'$vn4digit%' 

            UNION

            select 'FN1106' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN1106'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
            FROM ovst_functional 
            where (ovst_functional_score is null )) function_chk on ovst.vn = function_chk.vn
            left join patient on ovst.hn = patient.hn
            where ovst.vn like'$vn4digit%' 


            UNION
            
            select 'FN2108' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN2108'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
                                FROM ovst_functional 
                                where (ovst_functional_score is not null) and ovst_functional_score BETWEEN 0 and 4 and ovst_functional_dependent_type_id <> 3
                                UNION
                                SELECT vn 
                                FROM ovst_functional 
                                where (ovst_functional_score is not null) and ovst_functional_score BETWEEN 5 and 11 and ovst_functional_dependent_type_id <> 2
                                UNION
                                SELECT vn 
                                FROM ovst_functional 
                                where (ovst_functional_score is not null) and ovst_functional_score BETWEEN  12 and 20 and ovst_functional_dependent_type_id <> 1

                                    ) function_chk on ovst.vn = function_chk.vn
            left join patient on ovst.hn = patient.hn
            where ovst.vn like'$vn4digit%' 



            UNION

            
            select 'FN2109' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'FN2109'  ) as 'ERROR_DETAIL' ,  ifnull(count(ovst.hn),0) as CC
            from ovst
            INNER JOIN (SELECT vn 
                                    FROM ovst_functional 
                                    where ovst_functional_dependent_type_id = 3 
                                        and (SELECT vn from ovstdiag where icd10 ='Z508' and vn = ovst_functional.vn) is null

                                    UNION
                                    SELECT vn 
                                    FROM ovst_functional 
                                    where ovst_functional_dependent_type_id = 2 
                                         and (SELECT vn from ovstdiag where icd10 ='Z749' and vn = ovst_functional.vn) is null

                                    UNION
                                    SELECT vn 
                                    FROM ovst_functional 
                                    where ovst_functional_dependent_type_id = 1 
                                         and (SELECT vn from ovstdiag where icd10 ='Z718' and vn = ovst_functional.vn) is null
            ) function_chk on ovst.vn = function_chk.vn
            left join patient on ovst.hn = patient.hn
            where ovst.vn like'$vn4digit%'



                 order by CC desc , ERROR_CODE ";
    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='functional_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}


function get_rows_Functional_Error_detail_list($error_code, $vn4digit, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>HN</th>
                                      <th>วันที่รับบริการ</th>
                                      <th>เวลารับบริการ</th>
                                                                            
                                 </tr>

                                      ";
    $i = 0;

    $sql1 = $sql1. "  like'$vn4digit%'";

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $hn = $result['hn'];
        $cid = $result['cid'];
        $TIMEServ = $result['vsttime'];

        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>                                     
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$hn</td>
                                      <td>$DATEServ</td>
                                      <td>$TIMEServ</td>
                                   
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}





function get_rows_Charge_ipd_Error_all($vn4digit) {

    $sql = "select 'CI9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CI9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(an),0) as CC
            from ipt
            where ipt.dchdate is null and  (select  sum(sum_price) from opitemrece where vn = ipt.vn and  qty > 0 group by vn) > 0
            and concat(RIGHT(year(ipt.regdate)+543,2),LPAD(month(ipt.regdate),2,'0'))  like'$vn4digit%' 


            UNION

                select 'CI9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CI9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ovst.an)),0) as CC
                from ovst 
                INNER JOIN (select ovv.vn,ovv.vstdate ovtts, (SELECT  min(vstdate) vtts
                FROM opitemrece 
                where an = ovv.an
                GROUP BY an ) vtts
                from ovst ovv
                where  ovv.an is not null  
                HAVING vtts < ovtts ) sel_chk on ovst.vn = sel_chk.vn
                LEFT JOIN patient on ovst.hn = patient.hn
                where ovst.vn like'$vn4digit%' 

                ";
    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}






function get_rows_Charge_ipd_Error_detail($vn4digit) {

    $sql = "select 'CI9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CI9901'  ) as 'ERROR_DETAIL' ,  ifnull(count(an),0) as CC
            from ipt
            where ipt.dchdate is null and  (select  sum(sum_price) from opitemrece where vn = ipt.vn and  qty > 0 group by vn) > 0
            and concat(RIGHT(year(ipt.regdate)+543,2),LPAD(month(ipt.regdate),2,'0'))  like'$vn4digit%' 


            UNION

                select 'CI9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'CI9902'  ) as 'ERROR_DETAIL' ,  ifnull(count(DISTINCT(ovst.an)),0) as CC
                from ovst 
                INNER JOIN (select ovv.vn,ovv.vstdate ovtts, (SELECT  min(vstdate) vtts
                FROM opitemrece 
                where an = ovv.an
                GROUP BY an ) vtts
                from ovst ovv
                where  ovv.an is not null  
                HAVING vtts < ovtts ) sel_chk on ovst.vn = sel_chk.vn
                LEFT JOIN patient on ovst.hn = patient.hn
                where ovst.vn like'$vn4digit%' 
            
                 order by CC desc , ERROR_CODE ";
    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql) or die(mysql_error());
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='charge-ipd_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}






function get_rows_Charge_ipd_Error_detail_list($error_code, $vn4digit, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th>AN</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>HN</th>
                                      <th>วันที่รับบริการ</th>
                                      <th>เวลารับบริการ</th>
                                      <th>จำนวนเงิน</th>
                                      <th>หมวดค่ารักษา</th>
                                                                            
                                 </tr>

                                      ";
    $i = 0;

    $sql1 = $sql1. "  like'$vn4digit%'";

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $an = $result['an'];
        $hn = $result['hn'];
        $cid = $result['cid'];
        $TIMEServ = $result['vsttime'];
        $income = $result['income'];
        $price = $result['price'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td > $i</td>  
                                      <td>$an </td>                                   
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$hn</td>
                                      <td>$DATEServ</td>
                                      <td>$TIMEServ</td>
                                      <td>$price</td>
                                      <td>$income</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}















function get_rows_Rehab_Error_all($vn4digit) {

    $sql = "select 'RT9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'RT9299'  ) as 'ERROR_DETAIL' ,  ifnull(count( distinct ovst.vn),0) as CC
            from ovst
            INNER JOIN (SELECT vn,hn,opitemrece.icode,COUNT(opitemrece.icode) as cc
            FROM opitemrece
            INNER JOIN nondrugitems on opitemrece.icode = nondrugitems.icode and nondrugitems.income = '13'
            GROUP BY vn ,opitemrece.icode
            HAVING cc > 1 ) vn_check on ovst.vn = vn_check.vn

            where ovst.vn like'$vn4digit%' 
        


                ";
   //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}






function get_rows_Rehab_Error_detail($vn4digit) {

    $sql = "select 'RT9299' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'RT9299'  ) as 'ERROR_DETAIL' ,  ifnull(count( distinct ovst.vn),0) as CC
            from ovst
            INNER JOIN (SELECT vn,hn,opitemrece.icode,COUNT(opitemrece.icode) as cc
            FROM opitemrece
            INNER JOIN nondrugitems on opitemrece.icode = nondrugitems.icode and nondrugitems.income = '13'
            GROUP BY vn ,opitemrece.icode
            HAVING cc > 1 ) vn_check on ovst.vn = vn_check.vn

            where ovst.vn like'$vn4digit%' 


            
                 order by CC desc , ERROR_CODE ";
    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql) or die(mysql_error());
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='rehab_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}





function get_rows_Rehab_Error_detail_list($error_code, $vn4digit, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th>HN</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>วันที่รับบริการ</th>
                                      <th>เวลารับบริการ</th>
                                      <th>ชื่อรายการ</th>
                                      <th>จำนวนรายการ</th>
                                                                            
                                 </tr>

                                      ";
    $i = 0;

    $sql1 = $sql1. "  like'$vn4digit%' GROUP BY ovst.vn";

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $hn = $result['hn'];
        $cid = $result['cid'];
        $TIMEServ = $result['vsttime'];
        $income = $result['name'];
        $amount = $result['cc'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td >$i</td>  
                                      <td>$hn </td>                                   
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$DATEServ</td>
                                      <td>$TIMEServ</td>
                                      <td>$income</td>
                                      <td>$amount</td>
                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}







function get_rows_Service_Error_all($vn4digit) {

    $sql = "select 'SE9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SE9901'  ) as 'ERROR_DETAIL' ,  ifnull(count( distinct ovst.vn),0) as CC
           from ovst,referout  
          where ovst.vn = referout.vn and ovst.ovstost  <> 54  and ovst.vn like'$vn4digit%' 
        
          UNION
          select 'SE9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SE9902'  ) as 'ERROR_DETAIL' ,  ifnull(count( distinct ovst.vn),0) as CC
            from ovst
            left join spclty on spclty.spclty = ovst.spclty
                  where spclty.spclty is null  and ovst.vn like'$vn4digit%' 

                ";
   //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql);
    $rows = mysql_num_rows($query) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
        $CC = $CC + number_format($result['CC']);
    }
    return $CC;
}





function get_rows_Service_Error_detail($vn4digit) {

    $sql = "select 'SE9901' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SE9901'  ) as 'ERROR_DETAIL' ,  ifnull(count( distinct ovst.vn),0) as CC
           from ovst,referout  
          where ovst.vn = referout.vn and ovst.ovstost  <> 54  and ovst.vn like'$vn4digit%'  

        
          UNION
          select 'SE9902' as 'ERROR_CODE',(select ERROR_DETAIL from pk_err_code_chk where ERROR_CODE = 'SE9902'  ) as 'ERROR_DETAIL' ,  ifnull(count( distinct ovst.vn),0) as CC
            from ovst
            left join spclty on spclty.spclty = ovst.spclty
                  where spclty.spclty is null  and ovst.vn like'$vn4digit%' 
            
                 order by CC desc , ERROR_CODE ";
    //echo $sql;    
    $CC = 0;
    $query = mysql_query($sql) or die(mysql_error());
    $aherf = "";
    //$rows = mysql_num_rows($query);
    while ($result = mysql_fetch_array($query)) {
        $ERROR_CODE = $result['ERROR_CODE'];
        $ERROR_DETAIL = $result['ERROR_DETAIL'];
        $SHOW_ERROR = "< " . $ERROR_CODE . " > " . $ERROR_DETAIL;
        $CC = number_format($result['CC']);
        if ($CC == 0) {
            $aherf = $aherf . "<span class='list-group-item list-group-item-success'> $SHOW_ERROR  <span class='badge'>$CC</span></span>";
        } else {
            $aherf = $aherf . "<a href='service_detail.php?err=$ERROR_CODE&vn=$vn4digit' class='list-group-item list-group-item-danger'> $SHOW_ERROR  <span class='badge'>$CC</span></a>";
        }
    }
    return $aherf;
}






function get_rows_Service_Error_detail_list($error_code, $vn4digit, $xls) {

    $sql = "select sql_script from pk_err_code_chk where ERROR_CODE = '$error_code'";
    $query = mysql_query($sql);

    while ($result = mysql_fetch_array($query)) {
        $sql1 = $result['sql_script'];
    }
    //echo $sql1;
    if ($xls == "export") {
        $tb_title = "";
        $tb_footer = "";
    } else {
        $tb_title = "<TABLE class='table'>";
        $tb_footer = "</TABLE>";
    }

    $tb = $tb_title . "     <tr>
                                      <th>#</th>
                                      <th>HN</th>
                                      <th>ชื่อ - สกุล </th>
                                      <th>CID</th>
                                      <th>วันที่รับบริการ</th>
                                      <th>เวลารับบริการ</th>
                                      <th>เลขที่ส่งต่อ</th>                                      
                                 </tr>

                                      ";
    $i = 0;

    $sql1 = $sql1. "  like'$vn4digit%' ";

    $query2 = mysql_query($sql1);
    $rows = mysql_num_rows($query2);
    while ($result = mysql_fetch_array($query2)) {
        $ptname = $result['ptname'];
        $DATEServ = get_date_show($result['vstdate']);
        $hn = $result['hn'];
        $cid = $result['cid'];
        $TIMEServ = $result['vsttime'];
        $refer_number = $result['refer_number'];
        $i = $i + 1;
        //$data   = $data. $i  . " | " . $person_id ." | ".$ptname." | ". $cid  . " | ".get_date_show($DATEServ).'<br>';
        $tb = $tb . "           <tr>
                                      <td >$i</td>  
                                      <td>$hn </td>                                   
                                      <td>$ptname </td>
                                      <td>$cid</td>
                                      <td>$DATEServ</td>
                                      <td>$TIMEServ</td>
                                      <td>$refer_number</td>

                                  </tr> 

                                  ";
    }
    return $tb . $tb_footer;
}








?>