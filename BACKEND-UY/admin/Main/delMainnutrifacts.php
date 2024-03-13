<html>
<head><title>Delete Nutrition Facts</title></head>
<body>

  <h2>Delete Mains</h2>
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

        $factsQuery = mysqli_query($conn, "SELECT * FROM mains ORDER BY mains_id");
        while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
            echo "<tr>";
            echo "<td>", $factsResult ["mains_id"], "</td>";
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
    Enter Mains ID: 
    <select name="id">
            <?php
              $idQuery = mysqli_query($conn, "SELECT * FROM mains");
              
              while ($row = mysqli_fetch_assoc($idQuery)) {
                  echo "<option value='" . $row['mains_id'] . "'>" . $row['name'] . " (" . $row['mains_id'] . ")</option>";
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
      $factsQuery = mysqli_query($conn, "SELECT * FROM mains WHERE mains_id='$id'");
      
      $getFacts = mysqli_fetch_array($factsQuery);
        echo "Mains ID: ".$getFacts["mains_id"]."<br />";
      
      $stocks_id = $getFacts['stocks_id'];
      $nutr_facts_id = $getFacts['nutr_facts_id'];

      mysqli_query($conn, "DELETE FROM mains WHERE sides_id='".$getFacts['mains_id']."'");
      mysqli_query($conn, "DELETE FROM item WHERE item_id='".$getFacts['mains_id']."'");
      mysqli_query($conn, "DELETE FROM stocks WHERE stocks_id='".$getFacts['stocks_id']."'");
      mysqli_query($conn, "DELETE FROM nutr_facts WHERE nutr_facts_id='".$getFacts['nutr_facts_id']."'");
        echo "<p>This record has been deleted from the database!</p>";
        
    }	 
  ?>
  
  <hr>
  <a href="mains-table.php">Back</a>

</body>
</html>
