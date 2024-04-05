<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Reference: https://www.w3schools.com/php/php_looping_foreach.asp 
                    https://stackoverflow.com/questions/21349194/store-array-of-objects-in-php-session 
                    https://www.plus2net.com/php_tutorial/array-session.php 
                    https://www.w3schools.com/php/func_math_min.asp 
                    https://stackoverflow.com/questions/35618366/continuously-updating-php-page -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/navbar.css" />
    <link rel="stylesheet" type="text/css" href="../../css/dish.css" />
    <link rel="stylesheet" type="text/css" href="../../css/cart.css" />

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php
        // header("refresh: 5; URL=processOrders.php"); //Refresh page every 5 seconds to reflect combo changes
    ?> 
    
  </head>
    <title>Cart</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('../../images/menubg.png'); 
            background-size: cover;
            background-position: center;
            display: flex;
        }

        hr {
            border-color: black;
            width: 95%;
        }

        .empty-cart-message{
            color: #311712;
            font-family: "Luckiest Guy", cursive;
            font-weight: 400;
            font-style: normal;
            font-size: 25px;
            text-align: center;
            margin-top: 2%;
            margin-bottom: 2%;
            
        }

        .empty-cart-message img {
            margin: 0 auto; 
            max-height: 200px;'
        }
        
    </style>
</head>
<body>
    <?php
        session_start();        

        if(!$_SESSION['cart_refreshed']) {

            // Meta refresh code
            header("refresh:2;url=processOrders.php");
            
            $_SESSION['cart_refreshed'] = true; 
        }

        require_once("order.php"); //Adding the order class for OOP purposes

        //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

        $cartID = $_SESSION['cartID']; // Get the cart ID of the current user
        $totalBill = 0; // Initialize total bill as zero
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // This code won't run until the DOM is fully loaded
            var confirmCancelBtn = document.getElementById('confirmCancel');
            if (confirmCancelBtn) {
                confirmCancelBtn.addEventListener('click', function() {
                    window.location.href = 'cancelOrder.php';
                });
            }
        });
    </script>

    <!-- Cancel Order Confirmation Prompt -->
    <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLongTitle">Cancel Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel your order and go back? All unsaved changes will be lost.
            </div>
            <div class="modal-footer">
                <button type="button" class="home-keep" data-dismiss="modal">No, Keep My Order</button>
                <button type="button" class="home-delete" id="confirmCancel">Yes, Cancel Order</button>
            </div>
            </div>
        </div>
    </div>

    <div class="navigation-bar">
        <ul>
            <li><li><a href="#" data-toggle="modal" data-target="#cancelConfirmationModal">
                    <div class="navbar-icon">
                        <img src="../../images/white-home-button.png" alt="Homepage">
                    </div>
                </a></li>
            <li><a href="mains.php">
                <div class="navbar-icon">
                    <img src="../../images/white-main-button.png" alt="Main Dishes">
                </div>
            </a></li>

            <li><a href="sides.php">
                <div class="navbar-icon">
                    <img src="../../images/white-side-button.png" alt="Side Dishes">
                </div>
            </a></li>
            <li><a href="drinks.php">
                <div class="navbar-icon">
                    <img src="../../images/white-drink-button.png" alt="Drinks">
                </div>
            </a></li>
            <li><a href="cart.php" class="active">
                <div class="navbar-icon">
                    <img src="../../images/white-cart-button.png" alt="Cart">
                </div>
            </a></li>
        </ul>
    </div>

    <div class="right-container">
        <div class="select-text">CART</div>
            <div class="cart-main-box">

                <?php

                        // Check if the cart is empty
                            $cartIsEmpty = true;

                            // Initialize $conn and $cartID if they are not defined
                            if (!isset($conn)) {
                                $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
                                mysqli_select_db($conn, "mydb");
                            }

                            if (!isset($cartID)) {
                                $cartID = $_SESSION['cartID'];
                            }

                            // Loop through each ala carte item and combo item to check if cart is empty
                            $displayAlacarteResult = displayAlacarte($conn, $cartID);
                            if (mysqli_num_rows($displayAlacarteResult) > 0) {
                                $cartIsEmpty = false;
                            } else {
                                $displayComboQuery = "SELECT * FROM combo WHERE cart_id = '$cartID'";
                                $displayComboResult = mysqli_query($conn, $displayComboQuery);
                                if (mysqli_num_rows($displayComboResult) > 0) {
                                    $cartIsEmpty = false;
                                }
                            }

                            // If the cart is empty, display the message
                            if ($cartIsEmpty) {
                                echo "<div class='empty-cart-message'>";
                                echo "<img src='../../images/sadcart.png' alt='Sad Cart'>";
                                echo "<div class='empty-cart-message'>Your cart is empty. Order now!</div>";
                                echo "</div>";
                                exit; // Stop further execution
                            }

                            displayCombo($conn, $cartID);
                                            // Places Individual Ala Carte Items in Separate cart-item-boxes
                    $displayAlacarteResult = displayAlacarte($conn, $cartID); // Get Ala Carte Items from DB
                    while ($alaCarteRow = mysqli_fetch_assoc($displayAlacarteResult)) { // Loop through all resulting rows in ala_carte query

                        $mainName = $alaCarteRow['mainName'];       // Get Item Info from Queries
                        $mainPrice = $alaCarteRow['mainPrice'];     // Name and Price of Ala Carte Items
                        $sideName = $alaCarteRow['sideName'];
                        $sidePrice = $alaCarteRow['sidePrice'];
                        $drinkName = $alaCarteRow['drinkName'];
                        $drinkPrice = $alaCarteRow['drinkPrice'];
                        $quantity = $alaCarteRow['quantity'];

                        if ($mainName != NULL) { // If the order is a main

                            $totalMainPrice = $mainPrice * $quantity; // Calculate total price for main
                            echo "<div class='cart-item-box'>";
                                echo "<div class='ala-carte-item'>";
                                    echo "<table>";
                                        echo "<tr>";
                                            echo "<td>$mainName</td>";
                                            echo "<td>x $quantity</td>";
                                            echo "<td>PHP " . number_format($totalMainPrice,2) . " </td>";
                                        echo "</tr>";
                                    echo "</table>";
                                echo "</div>";
                            echo "</div>";
                        }

                        if ($sideName != NULL) { // If the order is a side   

                            $totalSidePrice = $sidePrice * $quantity; // Calculate total price for side
                            echo "<div class='cart-item-box'>";
                                echo "<div class='ala-carte-item'>";
                                    echo "<table>";
                                        echo "<tr>";
                                            echo "<td>$sideName</td>";
                                            echo "<td>x $quantity</td>";
                                            echo "<td>PHP " . number_format($totalSidePrice,2) . "</td>";
                                        echo "</tr>";
                                    echo "</table>";
                                echo "</div>";
                            echo "</div>";
                        }

                        if ($drinkName != NULL) { // If the order is a drink
                        
                            $totalDrinkPrice = $drinkPrice * $quantity; // Calculate total price for drink
                            echo "<div class='cart-item-box'>";
                                echo "<div class='ala-carte-item'>";
                                    echo "<table>";
                                        echo "<tr>";
                                            echo "<td>$drinkName</td>";
                                            echo "<td>x $quantity</td>";
                                            echo "<td>PHP " . number_format($totalDrinkPrice,2) . "</td>";
                                        echo "</tr>";
                                    echo "</table>";
                                echo "</div>";
                            echo "</div>";
                        }
                    }

                    $totalForAlacarte = displayTotalAlacarte($conn, $cartID);
                    $totalBill += $totalForAlacarte;
                ?>
                
                <hr>
                <div class="cart-item-box"> 
                    <div class="price-total">
                        <table>
                            <tr>
                                <td></td>
                                <td>TOTAL</td>
                                <td>PHP <?php echo number_format($totalBill,2); $_SESSION['totalBill'] = $totalBill;?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- ---------------- TO EDIT -------------------->

                <!-- Modal for confirmation prompt-->
                <div class="modal fade" id="confirmOrder" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">CONFIRM ORDER</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    Please select "YES" to confirm your order and proceed to payment
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="home-keep" data-dismiss="modal">No</button>
                        <button type="button" class="home-delete" id="confirmButton">Yes</button>
                    </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    // When "Proceed to Payment" is clicked, show the modal
                    $("#proceedToPayment").click(function(e) {
                        e.preventDefault(); // Prevent default link behavior
                        $("#confirmOrder").modal('show'); // Correctly use Bootstrap method to show the modal
                    });

                    // Close the modal on "NO" click or modal close button
                    // Bootstrap's data-dismiss="modal" automatically handles closing, so you might not need this unless you're doing additional actions

                    // Redirect to payOptions.php on "YES" click
                    $("#confirmButton").click(function() {
                        $("#confirmOrder").modal('hide');
                        $("#paymentOptionsModal").modal('show'); 
                    });
                });
            </script>

            <!-- Modal for payment options --> 
            <div class="modal fade" id="paymentOptionsModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true"> 
                <div class="modal-dialog modal-dialog-centered" role="document"> 
                    <div class="modal-content"> 
                        <div class="modal-header"> <h5 class="modal-title" id="exampleModalLongTitle">PAYMENT OPTIONS</h5> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                            <span aria-hidden="true">&times;</span> 
                        </button> 
                    </div> 
                    <div class="modal-body"> 
                        <div class="options"> 
                            <a href="#" onclick="openGcashModal()" >GCash</a><br>
                            <a href="#" onclick="openCreditCardModal()">Credit Card</a><br>
                            <a href="#" onclick="openCashModal()">Cash</a><br>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div>

              <!-- GCash Payment Modal --> 
              <div class="modal fade" id="gcashModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true"> 
                <div class="modal-dialog modal-dialog-centered" role="document"> 
                    <div class="modal-content"> 
                        <div class="modal-header"> 
                            <h2 class="modal-title">GCASH PAYMENT</h2> 
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                                <span aria-hidden="true">&times;</span> 
                            </button> 
                        </div> 
                        <div class="modal-body"> 
                            <div class="qr-code">  
                                <img src="GCASH_QR.jpg" alt="GCash QR Code" class="cash-image"> 
                            </div> 
                            <?php 
                            $totalBill = $_SESSION['totalBill']; 
                            echo "<h3 class='total-bill' style='font-family: \"Luckiest Guy\", cursive;'>Total Bill: Php $totalBill</h3>";
                            ?> 
                            <button id="submit-gcash" class="done-button">DONE</button> 
                        </div> 
                    </div> 
                </div>
            </div>

            <!-- Credit Card Payment Modal --> 
            <div class="modal fade" id="creditCardModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true"> 
                <div class="modal-dialog modal-dialog-centered" role="document"> 
                    <div class="modal-content"> 
                        <div class="modal-header"> 
                            <h2 class="modal-title">Credit Card</h2> 
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                                <span aria-hidden="true">&times;</span> 
                            </button> 
                        </div> 
                        <div class="modal-body"> 
                            <div class="card-details"> 
                                <h3 style="font-family: 'Luckiest Guy', cursive;">Tap Your Credit Card Here to Pay</h3> 
                                <img src="../../images/tap_icon.png" alt="Tap Icon" class="cash-image"> 
                            </div> 
                            <?php  
                            $totalBill = $_SESSION['totalBill']; 
                            echo "<h3 style='font-family: \"Luckiest Guy\", cursive;'>Total Bill: Php $totalBill</h3>";  
                            ?> 
                            <button id="submit-credit-card" class="done-button">DONE</button> 
                        </div> 
                    </div>  
                </div> 
            </div>

            <!-- Cash Payment Modal --> 
            <div class="modal fade" id="cashModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true"> 
                <div class="modal-dialog modal-dialog-centered" role="document"> 
                    <div class="modal-content"> 
                        <div class="modal-header"> 
                            <h2 class="modal-title">CASH PAYMENT</h2> 
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                                <span aria-hidden="true">&times;</span> 
                            </button> 
                        </div> 
                        <div class="modal-body"> 
                            <div class="cash-details" style="font-size: 17px; font-family: 'Luckiest Guy', cursive;"> 
                                <p>TOTAL BILL: Php <?php echo $totalBill; ?></p> 
                            </div>
                            <?php 
                            $totalBill = $_SESSION['totalBill']; 
                            $currentAmount = isset($_SESSION['currentAmount']) ? $_SESSION['currentAmount'] : 0; 
                            // Current amount received 
                            $change = isset($_SESSION['change']) ? $_SESSION['change'] : 0; 
                            // Change to be dispensed echo 
                            "<h1>Total Bill: Php $totalBill</h1>"; 
                            // Check if form is submitted 
                            if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                                // Get the input value 
                                $inputAmount = isset($_POST['amount']) ? $_POST['amount'] : 0; 
                                $inputAmount = floatval($inputAmount); 
                                // Update the current amount received 
                                $currentAmount += $inputAmount; $_SESSION['currentAmount'] = $currentAmount; 
                                // Check if payment is successful 
                                if ($currentAmount == $totalBill) { 
                                    echo "<h3 style='font-family: \"Luckiest Guy\", cursive;'>Payment was successful!</h3>"; 
                                    // Reset current amount 
                                    } 
                                elseif ($currentAmount < $totalBill) { 
                                    $amountNeeded = $totalBill - $currentAmount; 
                                    echo "<h3 style='font-family: \"Luckiest Guy\", cursive;'>You have paid $currentAmount. You need to pay " . $amountNeeded . " more.</h3>"; 
                                    } 
                                else { 
                                    // Calculate change 
                                    $change = $currentAmount - $totalBill; 
                                    echo "<h3 style='font-family: \"Luckiest Guy\", cursive;'>Payment successful. Change dispensed: $change</h3>"; 
                                    // Reset current amount 
                                    $_SESSION['change'] = $change;
                                }                                                                                //if these logics are for the pay successful modal pa ayos nalang
                            } 
                                ?> 
                            <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>"> 
                                <label for="amount" style="font-size: 17px; font-family: 'Luckiest Guy', cursive;">AMOUNT WE RECEIVED :</label> 
                                <input type="number" style="font-family: 'Luckiest Guy', cursive;" id="amount" name="amount"> 
                                <input type="submit" id="submit-cash" value="Done" class="done-button"> 
                            </form> 
                        </div> 
                    </div> 
                </div> 
            </div>

            <!-- Successful payment -->
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true"> 
                <div class="modal-dialog modal-dialog-centered" role="document"> 
                    <div class="modal-content"> 
                        <div class="modal-header"> 
                            <h2 class="modal-title">Payment Successful!</h2> 
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                            </button> 
                        </div> 
                        <div class="modal-body"> 
                            <div class="card-details"> 
                                <h3 style="font-family: 'Luckiest Guy', cursive;"></h3>  
                            </div> 
                            <?php
                                // $cartID = $_SESSION['cartID'];

                                // // session stuff
                                $totalBill = $_SESSION['totalBill'];

                                $currentAmount = isset($_SESSION['currentAmount']) ? $_SESSION['currentAmount'] : $totalBill; // Current amount received
                                $change = isset($_SESSION['change']) ? $_SESSION['change'] : 0; // Change to be dispensed

                                //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
                                $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
                                mysqli_select_db($conn, "mydb");

                                echo "We recieved a total payment of";
                                echo "<h1 style=\"font-family: 'Luckiest Guy', cursive;\">PHP " . number_format($currentAmount,2) . "</h1>";

                                echo "Please get your change of";
                                echo "<h1 style=\"font-family: 'Luckiest Guy', cursive;\">PHP " . number_format($change,2) . "</h1>";

                                // Generate OR NUM
                                $maxORQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(OR_num, 3) AS UNSIGNED)) AS maxOR_ FROM or_");
                                $row = mysqli_fetch_array($maxORQuery);
                                $maxOR = $row['maxOR_'];

                                $newOR = 'or' . ($maxOR + 1); // New OR Number
                                $newDate = date("Y-m-d");

                                // Insert to DB
                                $insertORQuery = "INSERT INTO or_ (OR_num, cart_id, date) VALUES ('$newOR', '$cartID', '$newDate')";
                                mysqli_query($conn, $insertORQuery);

                                echo "OR Number: ". $newOR. "<br>";
                                echo "Date: ". $newDate;

                                unset($_SESSION['currentAmount']);
                                unset($_SESSION['change']);
                            ?>
                            <br>
                            <br>
                            <a class="done-button" id="end" href="index.php">Done</a> 
                        </div> 
                    </div>  
                </div> 
            </div>

              <script> 
              
              function openGcashModal() { 
                $('#gcashModal').modal('show'); 
                $('#paymentOptionsModal').modal('hide'); 
            } 
            
            document.addEventListener('DOMContentLoaded', function() { 
                document.getElementById('submit-gcash').addEventListener('click', function() { 
                    $('#successModal').modal('show'); 
                    $("#gcashModal").modal('hide');
                    
                }); //Change this nalang for the payment successful modal
                    $('#gcashModal').on('hidden.bs.modal', function (e) { 
                        $("#gcashModal").modal('hide');
                        $("#paymentOptionsModal").modal('show'); 
                        
                        }); 
                    }); 
                </script>

                <script>
                function openCreditCardModal() { 
                    $('#creditCardModal').modal('show'); 
                    $('#paymentOptionsModal').modal('hide'); 
                }
                 document.addEventListener('DOMContentLoaded', function() { 
                    document.getElementById('submit-credit-card').addEventListener('click', function() { 
                        $("#creditCardModal").modal('hide'); 
                        $('#successModal').modal('show');  //Change this nalang for the payment successful modal
                    }); 
                    $('#creditCardModal').on('hidden.bs.modal', function(e) { 
                        $("#creditCardModal").modal('hide'); 
                        $("#paymentOptionsModal").modal('show'); 
                    }); 
                }); 
                </script>

                <script>
                 function openCashModal() { 
                    $('#cashModal').modal('show'); 
                    $('#paymentOptionsModal').modal('hide'); 
                } 
                document.addEventListener('DOMContentLoaded', function() { 
                    document.getElementById('submit-cash').addEventListener('click', function() { 
                        $("#cashModal").modal('hide'); 
                        $('#successModal').modal('show');  //Change this nalang for the payment successful modal
                    }); 
                    $('#cashModal').on('hidden.bs.modal', function(e) { 
                        $("#cashModal").modal('hide'); 
                        $("#paymentOptionsModal").modal('show'); 
                    }); 
                });
                </script>


            <div class="buttons-box">
                <a class="edit-cart" href="editOrder.php">Edit Order</a>
                <!-- Correctly identified "Proceed to Payment" link for script to target -->
                <a class="proceed" href="#" id="proceedToPayment">Proceed to Payment</a>
            </div>
            
        </div>
    </div>
    <script> // Reference: https://stackoverflow.com/questions/17642872/refresh-page-and-keep-scroll-position
        window.onload = function() {
            // Save scroll position
            var scrollPos = sessionStorage.getItem('scrollPos');
            if (scrollPos) {
                window.scrollTo(0, scrollPos);
                sessionStorage.removeItem('scrollPos');
            }

            // Save scroll position before refresh
            window.onbeforeunload = function() {
                sessionStorage.setItem('scrollPos', window.scrollY);
            };
        };
    </script>

    <?php
        function displayCombo($conn, $cartID) {

            // FOR COMBOS
            // Query to get mains, sides, & drinks name and price. 
            $displayComboQuery = "SELECT c.*, main.`name` AS mainName, main.price AS mainPrice, side.`name` AS sideName, side.price AS sidePrice,
                                    drink.names AS drinkName, drink.price AS drinkPrice
                                    FROM combo c
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
                                    JOIN mains AS main 
                                        ON i_m.item_id = main.mains_id
                                    JOIN drinks AS drink 
                                        ON i_d.item_id = drink.drinks_id
                                        WHERE c.cart_id = '$cartID';";

            $displayComboResult = mysqli_query($conn, $displayComboQuery);

            while ($comboRow = mysqli_fetch_assoc($displayComboResult)) { // Loop through each row in combo table created

                $mainName = $comboRow['mainName'];      // Get the item data from the query
                $mainPrice = $comboRow['mainPrice'];    // Name and price of items in combos
                $sideName = $comboRow['sideName'];
                $sidePrice = $comboRow['sidePrice'];
                $drinkName = $comboRow['drinkName'];
                $drinkPrice = $comboRow['drinkPrice'];

                $totalForCombo = $mainPrice + $sidePrice + $drinkPrice;
                $discountForCombo = $totalForCombo * 0.15;
                $totalAfterDiscount = $totalForCombo - $discountForCombo;

                // ------------------ COMBO MEALS UI ------------------ 
                
                echo "<div class='cart-item-box'>";
                    echo "<div class='combo-meal-box'>COMBO MEAL";
                        echo "<div class='order-item'>";
                            echo "<table>";
                                echo "<tr>";
                                    echo "<td>$mainName</td>";
                                    echo "<td>x1</td>";
                                    echo "<td>PHP " . number_format($mainPrice, 2) ."</td>";
                                echo "</tr>";

                                echo "<tr>";
                                    echo "<td>$sideName</td>";
                                    echo "<td>x1</td>";
                                    echo "<td>PHP " . number_format($sidePrice, 2) ."</td>";
                                echo "</tr>";

                                echo "<tr>";
                                    echo "<td>$drinkName</td>";
                                    echo "<td>x1</td>";
                                    echo "<td>PHP " . number_format($drinkPrice, 2) ."</td>";
                                echo "</tr>";
                            echo "</table>";
                            echo "<hr>";
                            echo "<div class='orig-price'>";
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<td></td>";
                                        echo "<td></td>";
                                        echo "<td>PHP " . number_format($totalForCombo,2) ." </td>";
                                    echo "</tr>";
                                echo "</table>";
                            echo "</div>";

                            echo "<div class='price'>";
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<td></td>";
                                        echo "<td>-15%</td>";
                                        echo "<td>PHP " . number_format($totalAfterDiscount,2) ." </td>";
                                    echo "</tr>";
                                echo "</table>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                global $totalBill;
                $totalBill += $totalAfterDiscount; // Store subtotal in session variable. Gets added to after each loop iteration if more than 1 combo exists.
            }

            return $comboRow = mysqli_fetch_assoc($displayComboResult);
        }

        function displayAlacarte($conn, $cartID) {

            // FOR ALA CARTE ITEMS
            // Query to get all ala_carte items across the different cmb tables; where the cartID matches
            $alaCarteQuery = "SELECT ac.*, ot.ordr_quan AS quantity,  
                                mains.`name` AS mainName, mains.price AS mainPrice,
                                side.`name` AS sideName, side.price AS sidePrice,
                                drink.names AS drinkName, drink.price AS drinkPrice
                                FROM ala_carte ac
                                JOIN order_table ot ON ac.ordr_id = ot.ordr_id 
                                JOIN item i ON ot.item_id = i.item_id
                                LEFT JOIN sides side ON i.item_id = side.sides_id  
                                LEFT JOIN mains mains ON i.item_id = mains.mains_id
                                LEFT JOIN drinks drink ON i.item_id = drink.drinks_id
                                WHERE ac.cart_id = '$cartID'";
            
            return $displayAlacarteResult = mysqli_query($conn, $alaCarteQuery);
        }

        function displayTotalAlacarte($conn, $cartID) {

            // Query to get total for ala carte items relative to cart ID
            $alaCarteTotalQuery = "SELECT 
            SUM(COALESCE(mains.price*ot.ordr_quan, 0) + COALESCE(side.price*ot.ordr_quan, 0) + COALESCE(drink.price*ot.ordr_quan, 0)) AS total_earned_from_alacarte
            FROM 
                ala_carte ac
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
                WHERE cart_id = '$cartID';";
            
            $alaCarteTotalResult = mysqli_query($conn, $alaCarteTotalQuery); 
            $alaCarteTotalRow = mysqli_fetch_assoc($alaCarteTotalResult); // Fetch the total calculated

            return $totalForAlacarte = $alaCarteTotalRow['total_earned_from_alacarte'];
        }
    ?>

</body>
</html>
