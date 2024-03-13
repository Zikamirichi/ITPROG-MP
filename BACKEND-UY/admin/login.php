<html>
<head>
   <title>Login Page</title>

</head>
<body>
   <h2> User Login Page</h2>
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