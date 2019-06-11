<?php



        $sql  = "select hospitalname,hospitalcode,hospcode.hospital_level_id from opdconfig
INNER JOIN hospcode on opdconfig.hospitalcode = hospcode.hospcode" ;
        $query = mysql_query($sql);

            while ($result = mysql_fetch_array($query)) {
                $hospitalname = $result['hospitalname'];
                $hospitalcode = $result['hospitalcode'];
                $hospital_level = $result['hospital_level_id'];
            }
            $hospital_name = "[".$hospitalcode."]".$hospitalname;
      define("HOSPITAL_NAME", $hospital_name);
      define("HOSPITAL_CODE", $hospitalcode);
      define("HOSPITAL_LEVEL", $hospital_level);

          $sql_ver  = " SHOW VARIABLES LIKE 'version'" ;
          $query_ver = mysql_query($sql_ver);

            while ($result_ver = mysql_fetch_array($query_ver)) {
                $values_ver  = $result_ver['Value'];
                //$hospitalcode = $result['hospitalcode'];
            }
            $db_versin  = explode( "-",$values_ver);
                $db_versin_show = $db_versin[0];





          $sql  = " SHOW VARIABLES LIKE 'version_comment'" ;
          $query = mysql_query($sql);

            while ($result = mysql_fetch_array($query)) {
                $values  = $result['Value'];
                //$hospitalcode = $result['hospitalcode'];
            }

            $db_versin_commet  = explode(" ",$values);
                $db_versin_show_commet = $db_versin_commet[0];


            //$hospital_name = $db_versin;
        define("DB_VERSION", "[ ". $db_versin_show_commet.":".$db_versin_show .' ]');



?>