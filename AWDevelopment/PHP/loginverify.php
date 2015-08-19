<?php
  require('../Admin/dbinfo.php');


    if($_POST['submit']){

      $conn = mysqli_connect($servername, $username, $password, $dbname);


      $usname = $_POST['email'];
      $paswd = strip_tags(md5(sha1($_POST['password'])));

      $usname = mysqli_real_escape_string($conn, $usname);
      $paswd = mysqli_real_escape_string($conn, $paswd);


      $usname = strip_tags($_POST['email']);
      $paswd = strip_tags(md5(sha1($_POST['password'])));

      $usname = mysqli_real_escape_string($conn, $usname);
      $paswd = mysqli_real_escape_string($conn, $paswd);


      $sql = "SELECT id, email, password, user_level FROM {$tb1} WHERE email = '$usname' AND activated = '1' LIMIT 1";
      $query = mysqli_query($conn, $sql);
      $row = mysqli_fetch_row($query);

      $uid = $row[0];
      $dbUsname = $row[1];
      $dbPassword = $row[2];
      $user_level = $row[3];

      if($usname == $dbUsname && $paswd == $dbPassword && $user_level == 1){
        $_SESSION['username'];
        $_SESSION['id'];

        header("Location: ../Users/Hello.php");

      }

      elseif($usname == $dbUsname && $paswd == $dbPassword && $user_level == 2){

            header("Location: ../Admin/admin.php");
        }


      else{
        echo"error 2";
      }


    }


?>
