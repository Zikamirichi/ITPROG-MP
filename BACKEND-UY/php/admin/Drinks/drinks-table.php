<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu System</title>
</head>
<body>
<?php
        error_reporting(E_ERROR | E_PARSE);
        //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");
?>

    <h2>Show Nutrition Facts Table</h2>
    <table border="1" width="90%">
    <tr bgcolor="#FLE5EB">
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Nutrition Facts ID</th>
        <th>Stock ID</th>
    </tr>

    <?php
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
    <a href="add-drinks.php">Add Drinks</a> <br>
    <a href="delnutrifacts.php">Delete Drinks</a> <br>
    <a href="editnutrifacts.php">Edit Drinks</a> <br> <br>
    <a href="../adminmenu.php">Back</a>
</body>
</html>