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

      .password-container {
         position: relative;
      }

      .password-toggle {
         position: absolute;
         right: 5px;
         top: 50%;
         transform: translateY(-50%);
         cursor: pointer;
         padding: 5%;
         max-width: 100%;
         max-height: 60px;
      }

      .password-toggle.clicked {
         filter: invert(100%) sepia(0%) saturate(10000%) hue-rotate(180deg);
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
               <tr><td>Password:</td><td class="password-container">
                  <input type="password" name="password" id="password" required/>
                  <img src="../../images/eye.png" alt="Eye" class="password-toggle" onclick="togglePasswordVisibility(event)">
               </td></tr>
               <tr><td colspan="2" class="submit-button"><input type="submit" value="Login" name="loginBtn"/></td>
            </form>
         </tr>
         </table>
      </div>
   </div>
   
   <?php
    if(isset($_GET["error"])) {
        $error = $_GET["error"];
        
        // Check if error is due to invalid credentials
        if ($error == 1) {
            echo "<script>
                    $(document).ready(function(){
                        $('#errorModal').modal('show');
                    });
                  </script>"; 
        }
    }
?>
<!-- Bootstrap Modal for Error -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="errorModalLabel">Error</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p align='center'>Username and/or password invalid</p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

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