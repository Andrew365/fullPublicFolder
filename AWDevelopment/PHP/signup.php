<?php
  require("header.html");
  ?>
<html>
   <head>
      <link href="../CSS/formcheck.css" rel="stylesheet" />
      <link href="../CSS/signup.css" rel="stylesheet"/>
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
                   },
                       password2: {
                           required: true,
                           equalTo: "#password"
                       }
               },

               // Specify the validation error messages
               messages: {
                   fullname: {required: "Please enter your full name",
                             minlength: "Your name isn't that short",
                             },
                   lastname: "Please enter your last name",
                   password: {
                       required: "Please provide a password",
                       minlength: "Your password must be at least 5 characters long"
                   },
                   email: "Please enter a valid email address",
                   password2: {
                       required: "Please confirm your password",
                       minlength: "Your password must be at least 5 characters long",
                       equalTo: "Your passwords do not match"

                   }
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
         <h1>Register here</h1>
         <!--  The form that will be parsed by jQuery before submit  -->
         <form action="register.php" method="post" id="register-form" novalidate="novalidate">
            <div class="label">Full Name</div>
            <input type="text" id="fullname" name="fullname" /><br />
            <div class="label">Email</div>
            <input type="text" id="email" name="email" /><br />
            <div class="label">Password</div>
            <input type="password" id="password" name="password" /><br />
            <div class="label">Confirm Password</div>
            <input type="password" id="password2" name="password2" /><br />
            <div id="submit" style="display: block; margin: 0 auto; margin-top: 5px;"><input type="submit" name="submit" value="Submit" /></div>
         </form>
      </div>
   </body>
</html>
<?php
  require("footer.html");
  ?>
