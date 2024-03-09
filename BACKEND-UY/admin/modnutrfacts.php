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
        $conn = mysqli_connect("localhost", "root", "12345", "mydb", "3360") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");
?>

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
    <a href="addnutrfacts.php">Add Nutrition Facts</a> <br>
    <a href="delnutrfacts.php">Delete Nutrition Facts</a> <br>
    <a href="editnutrfacts.php">Edit Nutrition Facts</a> <br> <br>
    <a href="adminmenu.php">Back</a>
</body>
</html>