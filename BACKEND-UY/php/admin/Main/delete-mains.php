<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/admin.css" />
    <title>Main Dish</title>
    <style>
        table {
            border: 1px solid black;
        }

        td, th {
            border: 1px solid black;
            text-align: center;
            background-color: white;
        }

        tr th {
            background-color: #311712; 
            color: white;
        }

        hr {
            margin: 5%;
        }

    </style>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <img src="/ITPROG-MP/BACKEND-UY/images/logo-only.png" alt="Logo">
            MAIN DISH TABLE            
        </div>

        <div class="content-box">
            <table>
            <tr>
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
