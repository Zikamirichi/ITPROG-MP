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

        <?php
                error_reporting(E_ERROR | E_PARSE);
                //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
                $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
                mysqli_select_db($conn, "mydb");
        ?>

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
            <div class="buttons-box">
                <a href="add-mains.php" class="button-table">Add Mains</a> <br>
                <a href="delMainnutrifacts.php" class="button-table">Delete Mains</a> <br>
                <a href="editMainnutrifacts.php" class="button-table">Edit Mains</a> <br>
                <div class="back-submit-container">
                    <a href="../adminmenu.php" class="back-button">Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>