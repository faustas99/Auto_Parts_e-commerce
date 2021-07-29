<?php  

$xml=simplexml_load_file("configUWE.xml") or die("Error: Cannot create object");
$connect= mysqli_connect($xml->data->host,$xml->data->username,$xml->data->password,$xml->data->databasename);

 if(isset($_POST["poi_id"]))  
 {
     //echo '<script>alert("this")</script>';
	 //making variables that hold POST'ed values of the poi that is oppened in the infopage.php
     $poicityfk= $_POST["poi_city_fk_id"];
     $poiname= $_POST["poi_id_input"];
     $poidesctiption= $_POST["poi_description"];
     $poiid= $_POST["poi_id"];

     echo $poicityfk;
     echo "<br>";
     echo $poiname;
     echo "<br>";
     echo $poidesctiption;
     echo "<br>";
     echo $poiid;
     echo "<br>";
	 //gets content that inserted in the type="file" input field from the other page
      $file = addslashes(file_get_contents($_FILES["file"]["tmp_name"]));  
	  //makes a query to insert the column to the database with the sent values
      $query = "INSERT into images (city_id_fk, title, description, file, poi_id_fk) VALUES ('$poicityfk','$poiname','$poidesctiption','".$file."','$poiid')";  
      if(mysqli_query($connect, $query))  
      {  
			// echo the javascript to show alert message
           echo '<script type="text/javascript">';
		   echo 'alert("Image was uploaded successfully. Restart the page to see see it")';
		   echo '</script>';
		   
      }  
 }  
 ?>  

 <!DOCTYPE html>  
 <html>  
      <head>  
	  <!-- refrencing the externaljavascript --> 
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
      </head>  
 </html>  
 <script>  
 $(document).ready(function(){  
 //runs the function when the buton 'insert' is pressed
      $('#uploading').click(function(){
		  
           var image_name = $('#filing').val();
//checks if the input field that hold the file is empty		   
           if(image_name == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#filing').val().split('.').pop().toLowerCase();
					//checks if the file exstension is valid
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#filing').val('');  
                     return false;  
                }  
           }  
      });  
 });  
 </script>  