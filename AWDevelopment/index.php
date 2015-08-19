<!DOCTYPE html>

<html>
  <head>
    <link rel = "stylesheet" type = "text/css" href = "CSS/index.scss"/>
    <meta charset="utf-8">
  <title>AWDevelopment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../Images/favicon.ico">

  </head>
  <body>
      <div id = "welc">
        <div id = "linkbar">
            <span class="loginlink">
              <form action="PHP/login.php">
                  <input type="submit" value="Login">
              </form>
            </span>
            <span class="signuplink">
              <form action="PHP/signup.php">
                  <input type="submit" value="Signup">
              </form>
            </span>
          </div>
      </div>
  </body>
</html>
<?php require('PHP/footer.html'); ?>
