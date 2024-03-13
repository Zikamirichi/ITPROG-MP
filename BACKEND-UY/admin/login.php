<html>
<head>
   <title>Login</title>
   <style>
      body {
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh; 
         margin: 0;
      }

      .header {
         background-color: #D4471F;
         font-family: "Luckiest Guy", cursive;
         font-weight: 400;
         font-style: normal;
         display: inline;
      }
   </style>
</head>
<body>
   <div class="header">
      <img src="../images/logo-only.png" alt="Logo">
      HEALTHY FOOD
   </div>
   <table>
   <tr>
      <form method="post" action="check.php">
         <td>Username:</td><td><input type="text" name="username" required/></td>
         <tr><td>Password: </td><td><input type="password" name="password" required/></td></tr>
         <tr><td colspan="2"><input type="submit" value="Login" name="loginBtn"/></td>
       </form>
   </tr>
   </table>
   
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