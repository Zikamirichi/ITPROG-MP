<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/admin.css" />
   <title>Login</title>
   <style>

      table {
         width: 100%;
      }

      td {
         padding: 10px;
         text-align: left;
      }

      input[type="text"],
      input[type="password"] {
         width: 100%;
         padding: 8px;
         margin: 5px 0 10px 0;
         display: inline-block;
         border: 1px solid #CED3D7;
         box-sizing: border-box;
         background-color: white;
         font-family: "Montserrat", sans-serif;
         font-optical-sizing: auto;
         font-weight: 800;
         font-style: normal;
      }

      input[type="submit"] {
         background-color: #311712;
         color: white;
         padding: 10px 15px;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         font-size: 16px;
         font-family: "Luckiest Guy", cursive;
         font-weight: 400;
         font-style: normal;
         box-shadow: 0 7px #999;
      }

      input[type="submit"]:hover {
         background-color: #45a049;
      }

      input[type="submit"]:active {
         background-color: #45a049;
         box-shadow: 0 5px #666;
         transform: translateY(4px);
      }

      .submit-button {
         text-align: right;
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