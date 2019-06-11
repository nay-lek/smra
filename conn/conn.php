<?php

	
	define("HOSTNAME", "localhost");
	define("USDBNAME", "root");
	define("PSDBNAME", "4444");
	define("_db_", "hos");

	$Conn = mysql_connect(HOSTNAME,USDBNAME,PSDBNAME) or die(mysql_error());
				mysql_select_db(_db_,$Conn) or die("Can't connect table");
				mysql_query("SET NAMES UTF8");




?>