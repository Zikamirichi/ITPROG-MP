<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/admin.css" />
    <title>Drinks</title>
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

        .back-button {
            background-color: white;
            color: #311712;
            border: 1px solid #CED3D7;
        }

        .back-button:hover {
            background-color: #D4471F;
            color: white;
        }

    </style>
</head>
<body>
<div class="main-container">
        <div class="header">
            <img src="../../../images/logo-only.png" alt="Logo">
            DRINK TABLE            
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

    <div class="select-box">
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
    </div>
        <div class="submit-button">
            <a href="drinks-table.php" class="back-button">Back</a>
            <input type="submit" name="enter" value="Enter" title="Are you sure?"/><br /><br />
        </div>
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
  
</body>
</html>
