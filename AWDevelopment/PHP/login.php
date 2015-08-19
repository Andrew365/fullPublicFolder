<?php require('header.html');
 session_start();
?>
<html>
    <head>
      <link href="../CSS/formcheck.css" rel="stylesheet" />
      <link href="../CSS/login.css" rel="stylesheet"/>
      <!-- Load jQuery and the validate plugin -->
      <script src="//code.jquery.com/jquery-1.9.1.js"></script>
      <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
      <!-- jQuery Form Validation code -->
      <script>
         // When the browser is ready...
         $(function() {

           // Setup form validation on the #register-form element
           $("#register-form").validate({
               errorClass: "my-error-class",
               validClass: "my-valid-class",
               // Specify the validation rules
               rules: {
                   fullname:{ required: true,
                               minlength: 5
                            },

                   email: {
                       required: true,
                       email: true
                   },
                   password: {
                       required: true,
                       minlength: 5
                   }

               },

               // Specify the validation error messages
               messages: {
                   fullname: {required: "Please enter your full name"
                             },

                   password: {
                       required: "Please provide a password"

                   },
                   email: "Please enter a valid email address",

               },

               submitHandler: function(form) {
                   form.submit();
               }
           });


         });

      </script>

    </head>
    <body>
      <div id="container">
         <h1>Login Here</h1>
         <!--  The form that will be parsed by jQuery before submit  -->
         <form action="loginverify.php" method="post" id="register-form" novalidate="novalidate">
            <div class="label">Email</div>
            <input type="text" id="email" name="email" /><br />
            <div class="label">Password</div>
            <input type="password" id="password" name="password" /><br />
            <div id="submit" style="display: block; margin: 0 auto; margin-top: 5px;"><input type="submit" name="submit" value="Submit" /></div>
         </form>
      </div>

        </form>
    </body>
</html>
<?php require('footer.html'); ?>
