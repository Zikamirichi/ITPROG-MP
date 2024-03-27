<html>
<head><title>Delete Nutrition Facts</title></head>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/admin.css" />
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"> 
    </script>
<body>

  <h2>Show Stocks Table</h2>
      <table border="1" width="90%">
      <tr bgcolor="#FLE5EB">
          <th>Stocks_ID</th>
          <th>Quantity</th>
      </tr>

      <?php
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

          $factsQuery = mysqli_query($conn, "SELECT * FROM stocks ORDER BY stocks_id");
          while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
              echo "<tr>";
              echo "<td>", $factsResult ["stocks_id"], "</td>";
              echo "<td>", $factsResult ["quantity"], "</td>";
              echo "</tr>";
          }
      ?>
      </table>
    <hr>

    <form id="deleteForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    Enter Stocks ID: 
    <select name="id">
            <?php
              $idQuery = mysqli_query($conn, "SELECT stocks_id FROM stocks");
              
              while ($row = mysqli_fetch_assoc($idQuery)) {
                  echo "<option value='" . $row['stocks_id'] . "'>" . $row['stocks_id'] . "</option>";
              }
            ?>
        </select> <br /><br />
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmationModal">
          Delete
        </button><br /><br />
  </form>

  <?php
            ob_start(); // Start buffering output
        ?>

        <!-- Deletion Prompt -->
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
                        Are you sure you want to delete this stock?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            $(document).ready(function() {
            $('#deleteButton').click(function(){
            $('#deleteForm').submit();
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
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $deleteQuery = mysqli_query($conn, "DELETE FROM stocks WHERE stocks_id='$id'");
            
                if ($deleteQuery) {
                    // Redirect with a success flag
                    header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=true");
                    exit();
                } else {
                    echo "<p>Error deleting record: " . mysqli_error($conn) . "</p>";
                }
            }
        ?>

        <hr>
        <a href="modstocks.php">Back</a>
            
        <?php
            if(isset($_GET['deleted']) && $_GET['deleted'] == 'true') {
                echo "<script>$(document).ready(function() { $('#successMessageModal').modal('show'); });</script>";
            }
        ?>

        <?php
            ob_end_flush(); // Send output and turn off buffering
        ?>

</body>
</html>
