<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/admin.css" />
    <title>Side Dish</title>
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
            <img src="../../../images/logo-only.png" alt="Logo">
            SIDE DISH TABLE
        </div>

        <?php
                error_reporting(E_ERROR | E_PARSE);
                //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
                $conn = mysqli_connect("localhost", "root", "", "mydb") or die ("Unable to connect!". mysqli_error($conn) );
                mysqli_select_db($conn, "mydb");
        ?>

        <div class="content-box">
            <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Nutrition Facts ID</th>
                <th>Stocks</th>
            </tr>

            <?php
                $factsQuery = mysqli_query($conn, "SELECT si.*, s.quantity 
                FROM sides si JOIN stocks s
                             ON   si.stocks_id = s.stocks_id
                 ORDER BY sides_id;");
                while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                    echo "<tr>";
                    echo "<td>", $factsResult ["sides_id"], "</td>";
                    echo "<td>", $factsResult ["name"], "</td>";
                    echo "<td>", $factsResult ["price"], "</td>";
                    echo "<td>", $factsResult ["nutr_facts_id"], "</td>";
                    echo "<td>", $factsResult ["quantity"], "</td>";
                    echo "</tr>";
                }
            ?>
            </table>

            <hr>
            <div class="buttons-box">
                <a href="add-sides.php" class="button-table">Add Sides</a> <br>
                <a href="delete-sides.php" class="button-table">Delete Sides</a> <br>
                <a href="edit-sides.php" class="button-table">Edit Sides</a> <br> <br>
                <div class="back-submit-container">
                    <a href="../adminmenu.php" class="back-button">Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>