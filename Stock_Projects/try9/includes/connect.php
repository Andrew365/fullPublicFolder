<?php

$env = "dev";






if($env == "dev"){
$connect = mysqli_connect('localhost', 'Andrew', 'baseball365', 'stock7');
if(!$connect){die('connection failed');}
if($connect){}else{echo"connection failed" .mysqli_connect_error();}
}




elseif ($env =="prod") {
  $connect = mysqli_connect('acw.one.mysql', 'acw_one', 'AW34209085', 'acw_one');
  if(!$connect){die('connection failed');}
  if($connect){}else{echo"connection failed" .mysqli_connect_error();}
}
?>