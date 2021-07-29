<?php
   if( $_GET["item_post"] || $_GET["age"] ) {
      echo "Welcome ". $_GET['item_post']. "<br />";
      echo "You are ". $_GET['age']. " years old.";
      
      exit();
   }
?>