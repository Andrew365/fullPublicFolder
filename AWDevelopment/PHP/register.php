<?php
   require('../Admin/dbinfo.php');

   $name = $_POST['fullname'];
   $email = $_POST['email'];
   $pass = $_POST['password'];
   $pass2 = $_POST['password2'];



   if(!empty($name) && !empty($email) && !empty($pass) && !empty($_POST['password2'])){

       // Create connection
       $conn = mysqli_connect($servername, $username, $password, $dbname);

       // Check connection
       if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
       }



       ///////Check if email is in use////////

        $sql = "SELECT email FROM {$tb1} WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0){
          echo '<script>if(confirm("That email is already in use!")){
           window.location.href = "signup.php";
          }</script>';
         }

////////////////////////////////////////////////////////////////

     else{
       $paz = md5(sha1($_POST['password']));

         $sql = "INSERT INTO Users (fullname, email, password, activated)
         VALUES ('$name', '$email', '$paz', '1')";

           if (mysqli_query($conn, $sql)) {

           } else {
               echo "Error: " . $sql . "<br>" . mysqli_error($conn);
           }

           mysqli_close($conn);
           header("Location: signup.php");

     }

   }


   ?>
