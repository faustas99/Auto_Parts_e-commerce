<?php
   //start a session to see if there are any details being passed
    session_start();
   //check if there is session with admin details set
 if(!isset($_SESSION['admin_id']))
 {  //if not return the user to the home page
    header("location:/Auto_Parts/web/index.php");
     
 }
 //if admin is connected show the page.
?>

<html>
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
<h2><a href="index.php"> Welcome, <?php echo $_SESSION['admin_name']?> </a></h2>
<a type="submit" href="/Auto_Parts/web/logout.php" aria-label="Left Align"> Logout </a>
<div class="brands-w3l">
<p><a href="item_add.php"> Add new item </a></p>
<p><a href="tables_add.php"> New new Manufacturer, Model, Category </a></p>
</p>
<div>

</html>