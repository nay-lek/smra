<?php
session_start();
include("libs/function.php");

set_data_time_out();

unset($_SESSION['name']);
unset($_SESSION['logid']);
unset($_SESSION['computer']);

header("location:http://".$_SERVER["SERVER_NAME"]."/pktool58/");
?>