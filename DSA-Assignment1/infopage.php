<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    
  <title>Landing Page</title>
</head>
<body class="infopage">
    <div class="infocontent">        
            <h2 class="content-head"><?php echo $_POST["poinameinput"]; ?></h2>
            <div class="all">
                <div class="informationdiv">
                    <h2 class="content-subhead">Information</h2>
                    <div class="infobox">
                    
                    <?php 
                        $xml=simplexml_load_file("configUWE.xml") or die("Error: Cannot create object");
                    
                        // connecting to db
                        $connect= mysqli_connect($xml->data->host,$xml->data->username,$xml->data->password,$dbname = $xml->data->databasename);
                        if (!$connect)
                        {
                            die("Unable to connect to the database". mysqli_connect_error());
                        }
                        //Google API string
                        $string = "https://maps.googleapis.com/maps/api/js?key=".$xml->data->GoogleKEY."&callback=initMap";
                            
                        //SQL query
                        $sql= "SELECT poi_id, wiki_url, description, tags,lat, lng, city_id_fk, name FROM poi WHERE name ="."'".$_POST["poinameinput"]."'";
                        $result = mysqli_query($connect,$sql);
                
                        //passing the result into an array
                        while ($row = mysqli_fetch_array($result)) {
                            $poidata[] = $row;
                        }
                        
                        //Display POI data
                            echo "<p><span class ='bold'>Description: </span>".$poidata[0][2]."</p>";
                            echo "<a href='".$poidata[0][1]."'> Wiki Link </a>";
                            echo"<p><span class ='bold'>Tags: </span>".$poidata[0][3]."</p>";

                    ?>
                    
                    </div>
                </div> 
                    
                <div class="imagebox">
                    <h2 class="content-subhead">Image Gallery</h2>
            
                    <div class="imagetablediv">
                        <table class="imagetable">
    
                        <?php
                            //SQL selecting image files with the current poi ID
                            $query = "SELECT file,title FROM images Where poi_id_fk = "."'".$poidata[0][0]."'"." ORDER BY image_id DESC";
                        
                            //SQL result
                            $result = mysqli_query($connect, $query);  
                            while($row = mysqli_fetch_array($result))  
                            {  
                            
                                    echo "<td><img src='data:image/jpeg;base64,".base64_encode($row['file'] )."'". "class='img-thumnail' /></td>";
                                    //Display Images
                            
                               
                            }
                        
                        ?>
                        </table>
					</div>
                 </div>
                    <div class="upload_butt">
                        <h2 class="content-subhead">Image Uploader</h2>
                        
                        <!-- This section contains the image uploader, it takes the poi_id and poi name alongside the users image and saves it to the database.
                        it auto - increments adding ensuring a new primary key -->
                        
                        <form target="_blank" method="post" enctype="multipart/form-data">
                            <label class="custom-file-choose"> Choose image
                                <input type="file" name="file" id="filing">
                            </label>
                            <label class="custom-file-upload"> Upload
                                <input type="submit" name="submit" value="Upload" id="uploading">
                            </label>
                            <input type="hidden" name="posting" id="posting"> 
                            <input type="text" class= "descriptionin" name="poi_description" maxlength="20" placeholder="Enter description">
                            <input type="hidden" id="poinameinput" name="poinameinput" value="<?php echo ($_POST['poinameinput'])?>">
                        </form>
                        <form method="post" id="poinameplc">
                            <input type="hidden" id="poinameinput" name="poinameinput" value="<?php echo ($_POST['poinameinput'])?>">
                        </form>
                    </div>
                    <h2 class="content-subhead">Flickr Gallery</h2>
                    <div class="flicker">
                        <table class="imagetable">
			             <?php
                            include('Flickr-Widget.php');
                        ?>
                         </table>
                    </div>
            </div>
        <h2 class="content-subhead">Location</h2>
            <div class="mapthing">
                <div id="map" class="mapinfo"></div>
			</div>        
            <script>   
                function initMap(){
                    //Passes $poidata from the php array to a javascript array called poiarray
                    var poiarray = <?php echo json_encode($poidata)?>; 
                    var poiLat = parseFloat(poiarray[0][4]);
                    var poiLng = parseFloat(poiarray[0][5]);
                    var poiName = poiarray[0][7];
                    var poiUrl = poiarray[0][1];
            
                    // Map options
                    var options = {
                        zoom:15,
                        center:{lat:poiLat,lng:poiLng},
						gestureHandling: 'none',
                        zoomControl: false,
                        disableDefaultUI: true
                    };
  
                    // New map
                    var map = new google.maps.Map(document.getElementById('map'), options);
                        
                    //Creates new marker with using the previous variables
                    var marker = new google.maps.Marker({
                        position: {lat: poiLat,lng: poiLng},
                        map: map,
                        title: poiName, 
                    });
                }
            </script>  
    </div>

    <?php  

    if(isset($_POST["posting"]))  
    {
        //echo '<script>alert("this")</script>';
	    //making variables that hold POST'ed values of the poi that is oppened in the infopage.php
        $poicityfk= ($poidata[0][6]);
        $poiname= $_POST["poinameinput"];
        $poidesctiption= $_POST["poi_description"];
        $poiid= $poidata[0][0];
	    //gets content that inserted in the type="file" input field from the other page
        $file = addslashes(file_get_contents($_FILES["file"]["tmp_name"]));  
	    //makes a query to insert the column to the database with the sent values
        $query = "INSERT into images (city_id_fk, title, description, file, poi_id_fk) VALUES ('$poicityfk','$poiname','$poidesctiption','".$file."','$poiid')";  
            if(mysqli_query($connect, $query))  
        {  
			    // echo the javascript to show alert message
            echo "<script type='text/javascript'>";
            echo "document.getElementById('poinameplc').submit();";
            
		    echo "</script>";
		   
        }  
    }  
    ?> 

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
                else
                {
                    document.getElementById("posting").value = 1;
                    window.close();
                    
                }  
           }  
      });  
 });  
 </script> 

<script async defer src="<?php echo $string; ?>"></script>  
</body>
</html>