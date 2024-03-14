<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/admin.css" />
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
         <img src="/ITPROG-MP/BACKEND-UY/images/logo-only.png" alt="Logo">
         ADMIN LOGIN
      </div>
      <div class="content-box">
         <table>
         <tr>
            <form method="post" action="check.php">
               <td>Username:</td><td><input type="text" name="username" required/></td>
               <tr><td>Password:</td><td><input type="password" name="password" required/></td></tr>
               <tr><td colspan="2" class="submit-button"><input type="submit" value="Login" name="loginBtn"/></td>
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
</body>
</html>