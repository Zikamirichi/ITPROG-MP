<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/admin.css" />
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

    </style>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <img src="../../../images/logo-only.png" alt="Logo">
            DRINKS TABLE
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
                $factsQuery = mysqli_query($conn, "SELECT d.*, s.quantity 
                FROM drinks d JOIN stocks s
                             ON   d.stocks_id = s.stocks_id
                 ORDER BY drinks_id;");
                while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                    echo "<tr>";
                    echo "<td>", $factsResult ["drinks_id"], "</td>";
                    echo "<td>", $factsResult ["names"], "</td>";
                    echo "<td>", $factsResult ["price"], "</td>";
                    echo "<td>", $factsResult ["nutr_facts_id"], "</td>";
                    echo "<td>", $factsResult ["quantity"], "</td>";
                    echo "</tr>";
                }
            ?>
            </table>

            <hr>
            <div class="buttons-box">
                <a href="add-drinks.php" class="button-table">Add Drinks</a> <br>
                <a href="delete-drinks.php" class="button-table">Delete Drinks</a> <br>
                <a href="edit-drinks.php" class="button-table">Edit Drinks</a> <br>
                <div class="back-submit-container">
                    <a href="../adminmenu.php" class="back-button">Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>