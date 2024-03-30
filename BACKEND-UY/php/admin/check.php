<?php
if (isset($_POST["loginBtn"]))
 {
    $user=$_POST["username"];
    $pass=$_POST["password"];
    
    $conn = mysqli_connect("localhost", "root", "", "mydb") or die ("Unable to connect!". mysqli_error($conn) );
    mysqli_select_db($conn, "mydb");
    
    $query = mysqli_query($conn, "SELECT username, `password`, `admin` FROM sys_ad
	                                   WHERE username ='$user'
	                                   AND `password` ='$pass'");
    $fetch = mysqli_fetch_array($query);

    if($user==$fetch["username"] && $pass==$fetch["password"]) 
    {
      session_start();  //to start the session
      $_SESSION['getLogin'] = $user;  //this will hold the session variable to identify the user of the system
      $_SESSION['isAdmin'] = $fetch['admin'];
      header("location: adminmenu.php");  //this sets the headers for the HTTP response given by the server 
    }
   else
    {
      header("location:index.php?error=1");
    }
}
