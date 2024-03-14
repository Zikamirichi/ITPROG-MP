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

    <h2>Show Stocks Table</h2>
    <table border="1" width="90%">
    <tr bgcolor="#FLE5EB">
        <th>Stocks_ID</th>
        <th>Quantity</th>
    </tr>

    <?php
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
    <a href="addstocks.php">Add Stocks</a> <br>
    <a href="deletestocks.php">Delete Stocks</a> <br>
    <a href="editstocks.php">Edit Stocks</a> <br> <br>
    <a href="adminmenu.php">Back</a>
</body>
</html>