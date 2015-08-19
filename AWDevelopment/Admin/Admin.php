<head>
</head>
<?php

require("dbinfo.php");
$conn = mysqli_connect($servername, $username, $password, $dbname);

function printUsers(){

      require("dbinfo.php");
      $conn = mysqli_connect($servername, $username, $password, $dbname);

$sql = "SELECT id, fullname, email, password, reg_date, user_level FROM {$tb1}";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
              echo "Id: " . $row["id"]. "<br/>" . "Name: " . $row["fullname"]. "<br/> Email:  " . $row["email"]. "<br>"
                ."Password: ".$row["password"];
              echo "<br/>". $row["reg_date"] . "<br />" ."User Level: ". $row["user_level"]. "<br/>" . "<br/>";
          }
      } else {
          echo "0 results";
      }

}

function sayNumber(){

  require("dbinfo.php");
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $sql="SELECT * FROM {$tb1}";

  if ($result=mysqli_query($conn,$sql)){

    // Return the number of rows in result set
    $rowcount=mysqli_num_rows($result);

    if($rowcount == 1){
      echo " {$rowcount} results" . "<br/>" . "<br/>";
    }

    else{
      echo " {$rowcount} results" . "<br/>" . "<br/>";
      // Free result set
      mysqli_free_result($result);
    }

  }
}
?>
<form action="" method="post">
  <button name="delu" id ="delu">Delete User</button>
</form>


  <?php

  if(isset($_POST["delu"])){

    echo '<form action="deleteuser.php" method="post">
    ID: <input type"text" name="delid" />
    <button>Delete User</button>
    </form>';
  }

sayNumber();
printUsers();



?>
