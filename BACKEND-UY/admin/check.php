<?php
if (isset($_POST["loginBtn"]))
 {
    $user=$_POST["username"];
    $pass=$_POST["password"];
    
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
    mysqli_select_db($conn, "mydb");
    
    $query = mysqli_query($conn, "SELECT username, `password` FROM sys_ad
	                                   WHERE username ='$user'
	                                   AND `password` ='$pass'");
    $fetch = mysqli_fetch_array($query);

    if($user==$fetch["username"] && $pass==$fetch["password"]) 
    {
      session_start();  //to start the session
      $_SESSION['getLogin'] = $user;  //this will hold the session variable to identify the user of the system
      header("location: http://localhost/IT-PROG/ITPROG-MP/BACKEND-UY/admin/adminmenu.php");  //this sets the headers for the HTTP response given by the server 
    }
   else
    {
      header("location:login.php?error=1");
    }
}
?>