<html>
<head><title>Using the Edit Statement</title></head>
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

    <?php
        $conn = mysqli_connect("localhost", "root", "") or die("Unable to connect! " . mysqli_error($conn));
        mysqli_select_db($conn, "mydb");

        if (isset($_POST["enter"])) {
            $id = mysqli_real_escape_string($conn, $_POST["stocks_id"]);
            $factsQuery = mysqli_prepare($conn, "SELECT * FROM stocks WHERE stocks_id=?");
            mysqli_stmt_bind_param($factsQuery, "s", $id);
            mysqli_stmt_execute($factsQuery);
            $result = mysqli_stmt_get_result($factsQuery);
            $getFacts = mysqli_fetch_array($result);
            
            echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
            echo "<input type='hidden' name='newID' value='".$getFacts["stocks_id"]."'>".$getFacts["stocks_id"]."<br />";
            echo "Quantity: <input type='text' name='newQuantity' value='".$getFacts["quantity"]."' size='150'> <br />";
            echo "<input type='submit' name='save' value='Save'><br />";
            echo "</form>";
        }

        if(isset($_POST["save"])){
            $newID = $_POST["newID"];
            $newQuantity = $_POST["newQuantity"];
            mysqli_query($conn, "UPDATE stocks set `quantity`='$newQuantity' WHERE stocks_id='$newID'");
            echo "Record has been updated!";
            }
    ?>

    <hr>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
    Select Nutrition Facts ID: 
    <select name="stocks_id">
        <?php
        $idQuery = mysqli_query($conn, "SELECT stocks_id FROM stocks");

        // Loop through the results and populate dropdown options
        while ($row = mysqli_fetch_assoc($idQuery)) {
            echo "<option value='" . $row['stocks_id'] . "'>" . $row['stocks_id'] . "</option>";
        }
        ?>
    </select>

    <input type="submit" name="enter" value="Enter" /><br /><br />
    </form>

    <a href="modstocks.php">Back</a>

</body>
</html>