<html>
<head><title>Delete Nutrition Facts</title></head>
<body>

  <h2>Delete Drinks</h2>
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

        $factsQuery = mysqli_query($conn, "SELECT * FROM drinks ORDER BY drinks_id");
        while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
            echo "<tr>";
            echo "<td>", $factsResult ["drinks_id"], "</td>";
            echo "<td>", $factsResult ["names"], "</td>";
            echo "<td>", $factsResult ["price"], "</td>";
            echo "<td>", $factsResult ["nutr_facts_id"], "</td>";
            echo "<td>", $factsResult ["stocks_id"], "</td>";
            echo "</tr>";
        }
      ?>
      </table>
    <hr>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirm('Are you sure?');">
    Enter Drinks ID: 
    <select name="id">
            <?php
              $idQuery = mysqli_query($conn, "SELECT * FROM drinks");
              
              while ($row = mysqli_fetch_assoc($idQuery)) {
                  echo "<option value='" . $row['drinks_id'] . "'>" . $row['name'] . " (" . $row['drinks_id'] . ")</option>";
              }
            ?>
        </select> <br /><br />
    <input type="submit" name="enter" value="Enter" title="Are you sure?"/><br /><br />
  </form>

  <?php
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
    mysqli_select_db($conn, "mydb");

    if(isset($_POST["enter"])){
      $id = $_POST["id"];
      $factsQuery = mysqli_query($conn, "SELECT * FROM drinks WHERE drinks_id='$id'");
      
      $getFacts = mysqli_fetch_array($factsQuery);
        echo "Drinks ID: ".$getFacts["drinks_id"]."<br />";
      
      $stocks_id = $getFacts['stocks_id'];
      $nutr_facts_id = $getFacts['nutr_facts_id'];

      mysqli_query($conn, "DELETE FROM drinks WHERE drinks_id='".$getFacts['drinks_id']."'");
      mysqli_query($conn, "DELETE FROM item WHERE item_id='".$getFacts['drinks_id']."'");
      mysqli_query($conn, "DELETE FROM stocks WHERE stocks_id='".$getFacts['stocks_id']."'");
      mysqli_query($conn, "DELETE FROM nutr_facts WHERE nutr_facts_id='".$getFacts['nutr_facts_id']."'");
        echo "<p>This record has been deleted from the database!</p>";
        
    }	 
  ?>
  
  <hr>
  <a href="drinks-table.php">Back</a>

</body>
</html>
