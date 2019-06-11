<?php

$Conn = mysql_connect(HOSTNAME,USDBNAME,PSDBNAME) or die(mysql_error());
				mysql_select_db(_db_,$Conn) or die("Can't connect Database");

mysql_query(" DROP TABLE IF EXISTS `pk_log_sys`",$Conn) or die(mysql_error());
mysql_query(" 
  CREATE TABLE `pk_log_sys` (
  `pk_logid` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `pk_loguser` varchar(255) DEFAULT NULL,
  `pk_log_time_begin` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `pk_log_time_out` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `pk_log_computer_from` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pk_logid`)
) ENGINE=InnoDB DEFAULT CHARSET=tis620"  ) or die(mysql_error());

?>