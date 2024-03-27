<html>
<head>
    <title>Delete Nutrition Facts</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/admin.css" />
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"> 
    </script>

</head>
    <body>

        <h2>Delete Sides</h2>
        <table border="1" width="90%">
        <tr bgcolor="#FLE5EB">
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Nutrition Facts ID</th>
            <th>Stock ID</th>
        </tr>

        <?php
            $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
            mysqli_select_db($conn, "mydb");

            $factsQuery = mysqli_query($conn, "SELECT * FROM sides ORDER BY sides_id");
            while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                echo "<tr>";
                echo "<td>", $factsResult ["sides_id"], "</td>";
                echo "<td>", $factsResult ["name"], "</td>";
                echo "<td>", $factsResult ["price"], "</td>";
                echo "<td>", $factsResult ["nutr_facts_id"], "</td>";
                echo "<td>", $factsResult ["stocks_id"], "</td>";
                echo "</tr>";
            }
        ?>
        </table>
        <hr>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            Enter Sides ID: 
            <select name="id">
                    <?php
                    $idQuery = mysqli_query($conn, "SELECT * FROM sides");
                    
                    while ($row = mysqli_fetch_assoc($idQuery)) {
                        echo "<option value='" . $row['sides_id'] . "'>" . $row['name'] . " (" . $row['sides_id'] . ")</option>";
                    }
                    ?>
                </select> <br /><br />
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmationModal">
                Delete
                </button>
        </form>
        
        <?php
        ob_start(); // Start buffering output
        ?>

        <!-- Delete Confirmation Prompt -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this side?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- This button triggers the deletion -->
                        <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function() {
        $('#deleteButton').click(function(){
            $('form').submit();
        });

            if (window.location.search.indexOf('deleted=true') > -1) {
            $('#successMessageModal').modal('show');
                        
                // Use the History API to remove the 'deleted=true' query parameter
                if (window.history.replaceState) {
                    var newUrl = window.location.pathname;
                    window.history.replaceState({path:newUrl}, '', newUrl);
                    }
                }
            });
        </script>

        <!-- Success Message Prompt -->
        <div class="modal fade" id="successMessageModal" tabindex="-1" role="dialog" aria-labelledby="successMessageModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successMessageModalTitle">Success</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <div class="modal-body">
                        The record has been successfully deleted from the database.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            
            $deleteQuery = mysqli_query($conn, "DELETE FROM sides WHERE sides_id='$id'");
            $deleteQuery = mysqli_query($conn, "DELETE FROM item WHERE item_id='$id'");
            $deleteQuery = mysqli_query($conn, "DELETE FROM stocks WHERE stocks_id='$id'");
            $deleteQuery = mysqli_query($conn, "DELETE FROM nutr_facts WHERE nutr_facts_id='$id'");

            if ($deleteQuery) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=true");
                exit();
            } else {
                echo "<p>Error deleting record: " . mysqli_error($conn) . "</p>";
            }
        }
        ?>
    
        <hr>
        <a href="sides-table.php">Back</a>

        <?php
            ob_end_flush(); // Send output and turn off buffering
        ?>
    </body>
</html>
