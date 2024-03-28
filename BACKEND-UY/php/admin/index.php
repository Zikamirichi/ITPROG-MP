<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <link rel="stylesheet" type="text/css" href="../../css/admin.css" />
   <title>Login</title>
   <style>
      td {
         padding: 10px;
         text-align: left;
      }
   </style>
</head>
<body>
   <div class="main-container">
      <div class="header">
         <img src="../../images/logo-only.png" alt="Logo">
         ADMIN LOGIN
      </div>
      <div class="content-box">
         <table>
         <tr>
            <form method="post" action="check.php">
               <td>Username:</td><td><input type="text" name="username" class="form-control" required/></td>
               <tr><td>Password:</td><td>
               <div class="input-group">
                  <input type="password" id="password" name="password" class="form-control" required>
                  <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></button>
                  </div>
               </div>
               </td></tr>
               <tr><td colspan="2" class="submit-button"><input type="submit" value="Login" name="loginBtn" class="btn btn-primary"/></td>
            </form>
         </tr>
         </table>
      </div>
   </div>

   <!-- JavaScript for password toggle -->
   <script>
      document.getElementById("togglePassword").addEventListener("click", function() {
          var passwordField = document.getElementById("password");
          if (passwordField.type === "password") {
              passwordField.type = "text";
              this.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
          } else {
              passwordField.type = "password";
              this.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
          }
      });
   </script>

   <?php
      if(isset($_GET["error"])) {
          $error=$_GET["error"];
  
        //this line will be called by the check.php if the login credentials are incorrect 
         if ($error==1) {
            echo "<p align='center'>Username and/or password invalid<br/></p>"; 
		   }
      }
   ?>
</body>
</html>
