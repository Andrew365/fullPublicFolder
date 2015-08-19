<?php
  require("dbinfo.php");
  $uid = $_POST["delid"];

  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $sql = "DELETE FROM {$tb1} WHERE `users`.`id` = {$uid}";
  $query = mysqli_query($conn, $sql);

  if($query){
   echo '<script>if(confirm("User Deleted")){
             window.location.href = "Admin.php";
           } </script>';
  }
  ?>