<html>
<head>
   <title>Login</title>
   <style>
      @import url('https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap');
      @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

      body {
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center; 
         margin: 0;
         font-family: "Luckiest Guy", cursive;
         font-weight: 400;
         font-style: normal;
         width: 100%;
         min-height: 100vh;
         background-image: url('../images/menubg.png');
      }

      .main-container {
         display: flex;
         flex-direction: column;
         width: 100%;
         border: 2px solid black;
         width: 40%;
      }

      .header {
         display: flex;
         background-color: #D4471F;
         color: #311712;
         font-size: 20px;
         height: 60px;
         width: auto;
         align-items: center;
         border-bottom: 1px solid black;
         padding: 0 10px;
      }

      .header img {
         max-width: auto; 
         height: 100%;
         padding-right: 10px;
      }

      .credentials-box {
         display: flex;
         align-items: center;
         font-family: "Montserrat", sans-serif;
         font-optical-sizing: auto;
         font-weight: 800;
         font-style: normal;
         justify-content: center;
         padding-top: 5%;
         padding-bottom: 5%;
         padding-left: 10%;
         padding-right: 5%;
         background-color: #F0F3F4;
      }

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
      <img src="../images/logo-only.png" alt="Logo">
      ADMIN LOGIN
   </div>
   <div class="credentials-box">
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