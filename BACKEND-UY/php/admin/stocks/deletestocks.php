<html>
<head><title>Delete Nutrition Facts</title></head>
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

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Enter Stocks ID: 
    <select name="id">
            <?php
              $idQuery = mysqli_query($conn, "SELECT stocks_id FROM stocks");
              
              while ($row = mysqli_fetch_assoc($idQuery)) {
                  echo "<option value='" . $row['stocks_id'] . "'>" . $row['stocks_id'] . "</option>";
              }
            ?>
        </select> <br /><br />
    <input type="submit" name="enter" value="Enter" /><br /><br />
  </form>

  <?php
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
    mysqli_select_db($conn, "mydb");

    if(isset($_POST["enter"])){
      $id = $_POST["id"];
      $factsQuery = mysqli_query($conn, "SELECT * FROM stocks WHERE stocks_id='$id'");
      $getFacts = mysqli_fetch_array($factsQuery);
        echo "Stocks ID: ".$getFacts["stocks_id"]."<br />";
        echo "Quantity: ".$getFacts["quantity"]."<br />";
          
      mysqli_query($conn, "DELETE FROM stocks WHERE stocks_id='".$getFacts['stocks_id']."'");
        echo "<p>This record has been deleted from the database!</p>";
        
    }	 
  ?>
  
  <hr>
  <a href="modstocks.php">Back</a>

</body>
</html>
