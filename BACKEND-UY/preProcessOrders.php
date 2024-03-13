<?php

    //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
    mysqli_select_db($conn, "mydb");
    
    session_start();
    $cartID = $_SESSION['cartID']; // Get the cart ID of the current user


    if (isset($_SESSION['mains'])) { // Check if mains were ordered by the customer
        $mains = $_SESSION['mains']; // Get the Mains currently ordered in the session
    }
    else {

        $mains = [];
    }

    if (isset($_SESSION['sides'])) { // Check if sides were ordered by the customer
        $sides = $_SESSION['sides']; // Get the Sides currently ordered in the session
    }
    else {

        $sides = [];
    }

    if (isset($_SESSION['drinks'])) { // Check if drinks were ordered by the customer
        $drinks = $_SESSION['drinks']; // Get the Drinks currently ordered in the session
    }
    else {

        $drinks = [];
    }

    // Join with order_table to get item ids
    $alacarteOrdersQuery = "SELECT a.ordr_id, o.item_id  
              FROM ala_carte AS a
              JOIN order_table AS o ON a.ordr_id = o.ordr_id
              WHERE a.cart_id = '$cartID'";

    $result = mysqli_query($conn, $alacarteOrdersQuery);

    // Check if we have 1 main, side, and drink
    $mainId = null; // Initially set values as null
    $sideId = null;
    $drinkId = null;

    while($row = mysqli_fetch_assoc($result)) { // Test each row
      $itemId = $row['item_id'];
      
      if(substr($itemId, 0, 2) == 'i1') { // If id matches that of mains, assign the order id associated with it to $mainID
        
        $mainId = $row['ordr_id']; 
      } 
      
      else if(substr($itemId, 0, 2) == 'i2') {

        $sideId = $row['ordr_id'];
      } 
      
      else if(substr($itemId, 0, 2) == 'i3') { 
        
        $drinkId = $row['ordr_id'];
      }
    }

    if($mainId && $sideId && $drinkId) { // If there is a combo made, push mainId, sideiId, drinkId to session arrays
      // Can make combo
      array_push($mains, $mainId);
      array_push($sides, $sideId);
      array_push($drinks, $drinkId);
    }

    header("Location: processOrders.php"); // Redirect to processOrders.php
