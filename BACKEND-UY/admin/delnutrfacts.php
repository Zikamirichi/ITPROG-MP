<html>
<head><title>Delete Nutrition Facts</title></head>
<body>

  <h2>Show Nutrition Facts Table</h2>
      <table border="1" width="90%">
      <tr bgcolor="#FLE5EB">
          <th>ID</th>
          <th>Description</th>
          <th>Ingredients</th>
          <th>Fat</th>
          <th>Calories</th>
          <th>Protein</th>
          <th>Carbs</th>
      </tr>

      <?php
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

          $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts ORDER BY nutr_facts_id");
          while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
              echo "<tr>";
              echo "<td>", $factsResult ["nutr_facts_id"], "</td>";
              echo "<td>", $factsResult ["desc"], "</td>";
              echo "<td>", $factsResult ["Ingredients"], "</td>";
              echo "<td>", $factsResult ["Fat"], "</td>";
              echo "<td>", $factsResult ["Calories"], "</td>";
              echo "<td>", $factsResult ["Carbs"], "</td>";
              echo "<td>", $factsResult ["Protein"], "</td>";
              echo "</tr>";
          }
      ?>
      </table>
    <hr>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Enter Nutrition Facts ID: 
    <select name="id">
            <?php
              $idQuery = mysqli_query($conn, "SELECT nutr_facts_id FROM nutr_facts");
              
              while ($row = mysqli_fetch_assoc($idQuery)) {
                  echo "<option value='" . $row['nutr_facts_id'] . "'>" . $row['nutr_facts_id'] . "</option>";
              }
            ?>
        </select> <br /><br />
    <input type="submit" name="enter" value="Enter" /><br /><br />
  </form>

  <?php
    $conn = mysqli_connect("localhost", "root", "12345", "mydb", "3360") or die ("Unable to connect!". mysqli_error($conn) ); // May have to edit connection data on local machine
    mysqli_select_db($conn, "mydb");

    if(isset($_POST["enter"])){
      $id = $_POST["id"];
      $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id='$id'");
      $getFacts = mysqli_fetch_array($factsQuery);
        echo "Nutrition Facts ID: ".$getFacts["nutr_facts_id"]."<br />";
        echo "Description: ".$getFacts["desc"]."<br />";
        echo "Ingredients: ".$getFacts["Ingredients"]."<br />";
        echo "Fat: ".$getFacts["Fat"]."<br />";
        echo "Calories: ".$getFacts["Calories"]."<br />";
        echo "Carbs: ".$getFacts["Carbs"]."<br />";
        echo "Protein: ".$getFacts["Protein"]."<br />";
          
      mysqli_query($conn, "DELETE FROM nutr_facts WHERE nutr_facts_id='".$getFacts['nutr_facts_id']."'");
        echo "<p>This record has been deleted from the database!</p>";
        
    }	 
  ?>
  
  <hr>
  <a href="modnutrfacts.php">Back</a>

</body>
</html>
