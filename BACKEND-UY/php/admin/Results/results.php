<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/admin.css" />
    <title>Results</title>
    
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
            RESULTS TABLE
        </div>

    <?php
    // Load verification XML file
    $verification_xml = simplexml_load_file('verification.xml');

    error_reporting(E_ERROR | E_PARSE);
    $conn = mysqli_connect("localhost", "root", "", "mydb") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");
        $date = $_GET['date'];
     echo "<h3>Date: '$date' </h3>";

     // Array to store verification results
    $verification_results = [];
    ?>
    <table>
        <!-- Dishes Sold -->
        <tr>
            <th>Dishes Sold</th>
        </tr>
        <tr>
        <?php
        $query_dishes_sold = "SELECT 
        (total_dish_alacarte.total_dishes_sold + total_dish_combo.total_dishes_sold) AS total_dishes_sold
        FROM
        (
            SELECT 
                SUM(ot.ordr_quan) AS total_dishes_sold
            FROM 
                or_ 
                JOIN cart c ON c.cart_id = or_.cart_id
                JOIN ala_carte ac ON ac.cart_id = c.cart_id
                JOIN order_table ot ON ac.ordr_id = ot.ordr_id
            WHERE 
                or_.date = '$date'
        ) AS total_dish_alacarte,
        (
            SELECT 
                SUM(ot_m.ordr_quan + ot_s.ordr_quan + ot_d.ordr_quan) AS total_dishes_sold
            FROM 
                or_ 
                JOIN cart ca ON ca.cart_id = or_.cart_id
                JOIN combo co ON co.cart_id = ca.cart_id
                JOIN cmb_main AS cmb_m ON cmb_m.c_main_id = co.c_main_id
                JOIN cmb_side AS cmb_s ON cmb_s.c_side_id = co.c_side_id
                JOIN cmb_drink AS cmb_d ON cmb_d.c_drink_id = co.c_drink_id
                JOIN order_table AS ot_m ON cmb_m.ordr_id = ot_m.ordr_id
                JOIN order_table AS ot_s ON cmb_s.ordr_id = ot_s.ordr_id
                JOIN order_table AS ot_d ON cmb_d.ordr_id = ot_d.ordr_id
            WHERE 
                or_.date = '$date'
        ) AS total_dish_combo;";
        $result_dishes_sold = mysqli_query($conn, $query_dishes_sold);

        if ($result_dishes_sold) {
        // Fetch the actual total dishes sold for the selected date
        $row = mysqli_fetch_assoc($result_dishes_sold);
        $actual_total_dishes_sold = (int) $row['total_dishes_sold'];

        // Load verification XML file
        $verification_xml = simplexml_load_file('verification.xml');

        // Find the expected total dishes sold for the selected date from the XML
        $expected_total_dishes_sold = null;
        foreach ($verification_xml->dishes_sold as $verification) {
        if ((string) $verification->date === $date) {
        $expected_total_dishes_sold = (int) $verification->total;
        break;
        }
        }

        // Compare actual and expected total dishes sold
        if ($actual_total_dishes_sold == $expected_total_dishes_sold) {
        echo "<tr><td>Verified: Total dishes sold is <b>$expected_total_dishes_sold </b></td></tr>";
        } else {
        echo "<tr><td>Mismatch: Total dishes sold Expected: <b>$expected_total_dishes_sold</b>, Actual: <b> $actual_total_dishes_sold </b></td></tr>";
        }
        } else {
        echo "<tr><td>Error: " . mysqli_error($conn) . "</td></tr>";
        }
        ?>

        </tr>

        <!-- Earnings -->
        <tr>
            <th>Earnings</th>
        </tr>
        <tr>
            <?php 
           // Fetch the selected date from the form
    $date = $_GET['date'];

    // Fetch total earnings for the selected date
    $sql = "
            SELECT (total_earned_from_combo + total_earned_from_alacarte) AS total_earnings
            FROM (
                SELECT 
                    SUM(mains.price + side.price + drink.price) AS total_earned_from_combo
                FROM 
                    or_ 
                    JOIN cart ca ON ca.cart_id = or_.cart_id
                    JOIN combo c ON ca.cart_id = c.cart_id
                    JOIN cmb_main AS cmb_m 
                        ON cmb_m.c_main_id = c.c_main_id
                    JOIN cmb_side AS cmb_s 
                        ON cmb_s.c_side_id = c.c_side_id
                    JOIN cmb_drink AS cmb_d 
                        ON cmb_d.c_drink_id = c.c_drink_id
                    JOIN order_table AS ot_m 
                        ON cmb_m.ordr_id = ot_m.ordr_id
                    JOIN order_table AS ot_s 
                        ON cmb_s.ordr_id = ot_s.ordr_id
                    JOIN order_table AS ot_d 
                        ON cmb_d.ordr_id = ot_d.ordr_id
                    JOIN item i_m 
                        ON i_m.item_id = ot_m.item_id
                    JOIN item i_s 
                        ON i_s.item_id = ot_s.item_id
                    JOIN item i_d 
                        ON i_d.item_id = ot_d.item_id
                    JOIN sides AS side
                        ON i_s.item_id = side.sides_id
                    JOIN mains AS mains 
                        ON i_m.item_id = mains.mains_id
                    JOIN drinks AS drink 
                        ON i_d.item_id = drink.drinks_id
                    WHERE 
                    or_.date = '$date'
            ) AS ComboTotal,
            
            -- Query for Ala_carteTotal
            (
                SELECT 
                    SUM(COALESCE(mains.price*ot.ordr_quan, 0) + COALESCE(side.price*ot.ordr_quan, 0) + COALESCE(drink.price*ot.ordr_quan, 0)) AS total_earned_from_alacarte
            FROM 
                    or_ 
                    JOIN cart c ON c.cart_id = or_.cart_id
                    JOIN ala_carte ac ON ac.cart_id = c.cart_id
                    JOIN order_table AS ot 
                        ON ac.ordr_id = ot.ordr_id
                    JOIN item i 
                        ON i.item_id = ot.item_id
                    LEFT JOIN sides AS side 
                        ON i.item_id = side.sides_id
                    LEFT JOIN mains AS mains 
                        ON i.item_id = mains.mains_id
                    LEFT JOIN drinks AS drink 
                        ON i.item_id = drink.drinks_id
                        WHERE 
                    or_.date = '$date'
            ) AS Ala_carteTotal;";
        
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            // Load verification XML file
            $verification_xml = simplexml_load_file('verification.xml');

            // Find the corresponding expected total earnings from the XML for the selected date
            $expected_total_earnings = null;
            foreach ($verification_xml->earnings as $verification) {
                if ((string) $verification->date === $date) {
                    $expected_total_earnings = (float) $verification->total;
                    break;
                }
            }

            // Check if expected total earnings for the selected date exist in the XML
            if ($expected_total_earnings !== null) {
                // Fetch actual total earnings for the selected date
                $row = mysqli_fetch_assoc($result);
                $actual_total_earnings = $row['total_earnings'];

                // Compare actual and expected total earnings for the selected date
                if ($actual_total_earnings == $expected_total_earnings) {
                    echo "<td>Verified: Total earnings is <b>₱$expected_total_earnings</b></td>";
                } else {
                    echo "<td>Mismatch: Total earnings Expected: <b>₱$expected_total_earnings</b>, Actual: <b>₱$actual_total_earnings</b></td>";
                }
            } else {
                echo "<td>No expected value found for $date in XML</td>";
            }
        } else {
            echo "<td>Error: " . mysqli_error($conn) . "</td>";
        }
        ?>
    </tr>


        <!-- Discounts Given -->
        <tr>
            <th>Discounts Given</th>
        </tr>
        <tr>
        <?php
        // Fetch the selected date from the form
        $date = $_GET['date'];

        // Fetch total discounts given for the selected date
        $sql = "SELECT COUNT(c.cmb_id) AS `total_discounts`
                FROM 
                    or_ or_ JOIN cart ca
                            ON ca.cart_id = or_.cart_id
                            JOIN combo c
                            ON  c.cart_id = ca.cart_id
                WHERE 
                    or_.date = '$date';";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Load verification XML file
            $verification_xml = simplexml_load_file('verification.xml');

            // Find the corresponding expected total discounts from the XML for the selected date
            $expected_total_discounts = null;
            foreach ($verification_xml->discounts_given as $verification) {
                if ((string) $verification->date === $date) {
                    $expected_total_discounts = (int) $verification->total;
                    break;
                }
            }

            // Check if expected total discounts for the selected date exist in the XML
            if ($expected_total_discounts !== null) {
                // Fetch actual total discounts given for the selected date
                $row = mysqli_fetch_assoc($result);
                $actual_total_discounts = $row['total_discounts'];

                // Compare actual and expected total discounts for the selected date
                if ($actual_total_discounts == $expected_total_discounts) {
                    echo "<td>Verified: Total discounts given is <b>$expected_total_discounts</b></td>";
                } else {
                    echo "<td>Mismatch: Total discounts given Expected: <b>$expected_total_discounts</b>, Actual: <b>$actual_total_discounts</b></td>";
                }
            } else {
                echo "<td>No expected value found for $date in XML</td>";
            }
        } else {
            echo "<td>Error: " . mysqli_error($conn) . "</td>";
        }
        ?>
        </tr>
    </table>
    <br>

    
    <!-- Dropdown with a Submit Button to Select Distinct Dates -->
    <form action="results.php" method="GET">
        Select Date:
    <select name="date">
        <?php
        error_reporting(E_ERROR | E_PARSE);
        $conn = mysqli_connect("localhost", "root", "", "mydb") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");
        
        $sql = "SELECT DISTINCT date FROM or_;";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            // Load the XML file and its DTD
            $xml = new DOMDocument();
            $xml->load('date.xml');
            $xml->validateOnParse = true; // Enable validation against DTD
            
            // Output each distinct date as an option in the dropdown
            while ($row = mysqli_fetch_assoc($result)) {
                $date = $row['date'];
                // Validate the date against the XML
                if (validateDate($date, $xml)) {
                    echo "<option value='" . $date . "'>" . $date . "</option>";
                } else {
                    echo "<option value='' disabled>" . $date . " (Invalid)</option>";
                }
            }
        } else {
            echo "<option value=''>No dates found</option>";
        }

        function validateDate($date, $xml) {
            // Get all date elements from the XML
            $dates = $xml->getElementsByTagName('date');
            foreach ($dates as $node) {
                $xmlDate = trim($node->nodeValue); // Trim whitespace
                echo "Database Date: '$date', XML Date: '$xmlDate'<br>"; // Debugging output
                if ($xmlDate == $date) {
                    return true; // Date found in XML
                }
            }
            return false; // Date not found in XML
        }
        
        
        // Close connection
        mysqli_close($conn);
        ?>
    </select>
    <button type="submit">Submit</button>
</form>
    <br>

    <?php
// Load and parse the XML file
$xml = simplexml_load_file('verification.xml');

// Initialize arrays to store data
$dates = [];
$dishes_sold = [];
$earnings = [];
$discounts_given = [];

// Extract data from the XML
foreach ($xml->dishes_sold as $item) {
    $date = (string) $item->date;
    $total_dishes_sold = (int) $item->total;
    $dishes_sold[$date] = $total_dishes_sold;
    $dates[$date] = true;
}

foreach ($xml->earnings as $item) {
    $date = (string) $item->date;
    $total_earnings = (int) $item->total;
    $earnings[$date] = $total_earnings;
    $dates[$date] = true;
}

foreach ($xml->discounts_given as $item) {
    $date = (string) $item->date;
    $total_discounts_given = (int) $item->total;
    $discounts_given[$date] = $total_discounts_given;
    $dates[$date] = true;
}

// Sort dates
ksort($dates);

// Display data in a tabular format
echo "<h1>Verification Results</h1>";
echo "<table border='1'>
        <tr>
            <th>Date</th>
            <th>Total Dishes Sold</th>
            <th>Total Earnings</th>
            <th>Total Discounts Given</th>
        </tr>";

foreach ($dates as $date => $value) {
    $total_dishes_sold = isset($dishes_sold[$date]) ? $dishes_sold[$date] : 0;
    $total_earnings = isset($earnings[$date]) ? $earnings[$date] : 0;
    $total_discounts_given = isset($discounts_given[$date]) ? $discounts_given[$date] : 0;

    echo "<tr>
            <td>$date</td>
            <td>$total_dishes_sold</td>
            <td>$total_earnings</td>
            <td>$total_discounts_given</td>
          </tr>";
}

echo "</table>";
?>

<div class="back-submit-container">
    <a href="../adminmenu.php" class="back-button" style="margin-right: 250px;">Back</a>
</div>

</body>
</html>