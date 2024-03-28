<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            <form id="loginForm" method="post" action="check.php">
               <td>Username:</td><td><input type="text" name="username" required/></td>
               <tr><td>Password:</td><td><input type="password" name="password" id="password" required/><input type="image" src="eye.png" alt="Eye" onclick="togglePasswordVisibility(event)" style="width: 20px; height: 20px;"></td></tr>
               <tr><td colspan="2" class="submit-button"><input type="submit" value="Login" name="loginBtn" class="btn btn-primary"/></td>
            </form>
         </tr>
         </table>
      </div>
   </div>
   
   <?php
      if(isset($_GET["error"])) {
          $error=$_GET["error"];
  
        //this line will be called by the check.php if the login credentials are incorrect 
         if ($error==1) {
            echo "<p align='center'>Username and/or password invalid<br/></p>"; 
		   }
      }
 
   ?>
   <script>
      function togglePasswordVisibility(event) {
         event.preventDefault();
         var passwordField = document.getElementById("password");

         if (passwordField.type === "password") {
            passwordField.type = "text";
         } else {
            passwordField.type = "password";
         }
      }
   </script>
</body>
</html>
