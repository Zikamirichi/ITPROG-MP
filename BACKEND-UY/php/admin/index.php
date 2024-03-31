<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
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
    $error=$_GET["error"];
    if ($error == 1) {
        echo "<script>var showErrorModal = true;</script>";
    }
    if ($error == 2) {
        echo "<script>var showUnauthorizedModal= true;</script>";
    }
}
if(isset($_GET["success"])) {
    $success=$_GET["success"];
    if ($success == 1) {
        echo "<script>var showSuccessModal = true;</script>";
    }
}
?>
<!-- Bootstrap modal for displaying error -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Invalid Input</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                Username and/or password is invalid!
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap modal for displaying unauthorized user error -->
<div class="modal fade" id="unauthorizedUserModal" tabindex="-1" role="dialog" aria-labelledby="unauthorizedUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="unauthorizedUserModalLabel">Unauthorized User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                You are not authorized to access this page!
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap modal for displaying success message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Login Successful</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                You have successfully logged in!
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button id="closeAndRedirect" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

   <script>
        $(document).ready(function(){
        if (typeof showErrorModal !== 'undefined' && showErrorModal) {
            $('#errorModal').modal('show');
        }
    });
        $(document).ready(function(){
        if (typeof showUnauthorizedModal !== 'undefined' && showUnauthorizedModal) {
            $('#unauthorizedUserModal').modal('show');
        }
    });
    $(document).ready(function(){
        // Check if the success modal should be shown
        if (typeof showSuccessModal !== 'undefined' && showSuccessModal) {
            // Show the success modal
            $('#successModal').modal('show');
        }
    });

        // Add event listener for the "Close" button
        document.getElementById("closeAndRedirect").addEventListener("click", function() {
        // Redirect the user to adminmenu.php
        window.location.href = "adminmenu.php";
    });
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
