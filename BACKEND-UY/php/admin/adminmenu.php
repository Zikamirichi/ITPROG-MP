<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- New edit stuff -->
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="../../css/admin.css" />
    <title>Main Menu</title>

    <style>
        .white-text {
            color: white;
        }

        .back-button {
            background-color: white;
            color: #311712;
            border: 1px solid #CED3D7;
        }

        .back-button:hover {
            color: #311712;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <img src="../../images/logo-only.png" alt="Logo">
            MAIN MENU
        </div>
        <div class="content-box">
            <div class="instructions"> Please select a table:</div>
            <div class="buttons-box">
                <a href="Main/mains-table.php" class="button-table">Mains Table</a>
                <br> 
                <a href="sides-table/sides-table.php" class="button-table">Sides Table</a>
                <br>
                <a href="Drinks/drinks-table.php" class="button-table">Drinks Table</a>
                <br>
                <a href="Results/results.php" class="button-table">Results</a>
                <br> 
                <a class="btn btn-secondary" id="logoutBtn">Logout</a>
            </div>
        </div>
    </div>


    <!-- Bootstrap modal for displaying logout for sure -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Log out?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    Do you wanna log out yes or no?
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="back-button" data-dismiss="modal">No</button>
                    <a href="logout.php" class="btn btn-secondary">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#logoutBtn").click(function(){
                $("#logoutModal").modal('show');
            });
        });
    </script>
</body>

</html>