<?php
if (isset($_POST["loginBtn"])) {
    $user = $_POST["username"];
    $pass = $_POST["password"];

    $conn = mysqli_connect("localhost", "root", "", "mydb") or die ("Unable to connect!". mysqli_error($conn));
    mysqli_select_db($conn, "mydb");

    $query = mysqli_query($conn, "SELECT username, `password`, `admin` FROM sys_ad WHERE username ='$user'");
    $fetch = mysqli_fetch_array($query);

    if ($fetch) {
        // Username exists in the database
        if ($pass == $fetch["password"]) {
            // Password matches
            session_start();
            $_SESSION['getLogin'] = $user;
            $_SESSION['isAdmin'] = $fetch['admin'];
            header("location:index.php?success=1"); // Add success parameter to URL
            exit(); // Terminate script execution after redirect
        } else {
            // Password is incorrect
            header("location:index.php?error=1");
            exit(); // Terminate script execution after redirect
        }
    } else {
        // Username does not exist in the database
        header("location:index.php?error=2");
        exit(); // Terminate script execution after redirect
    }
} 
?>
