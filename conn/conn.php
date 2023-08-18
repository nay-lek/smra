<?php

	// config for his  
	define("HOSTNAME", "192.168.1.200"); 
	define("USDBNAME", "smra"); 
	define("PSDBNAME", "smra11029");
	define("_db_", "hos");

	$Conn = mysql_connect(HOSTNAME,USDBNAME,PSDBNAME) or die(mysql_error());
				mysql_select_db(_db_,$Conn) or die("Can't connect table");
				mysql_query("SET NAMES UTF8");




?>