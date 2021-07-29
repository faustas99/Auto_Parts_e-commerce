<?php

//Recieve Posted poiname
$poiname = $_POST["poinameinput"];
//DELETE THIS                                               ---------------------------------.>>>
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- refrencing the externaljavascript --> 
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  

    
  <title>Landing Page</title>
</head>
<body class="infopage">
    <div class="infocontent">        
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
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
                        
                        $string = "https://maps.googleapis.com/maps/api/js?key=".$Map_API_key = $xml->data->GoogleKEY."&callback=initMap";
                            
                        //SQL
                        //$sql= "SELECT poi_id, wiki_url, description, tags,lat, lng,name FROM poi WHERE name = '$poiname'";
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
                        
                        //Displays images in table
                        $result = mysqli_query($connect, $query);  
                        while($row = mysqli_fetch_array($result))  
                        {  
                            
                                echo "<td><img src='data:image/jpeg;base64,".base64_encode($row['file'] )."'". "class='img-thumnail' /></td>";
                                //echo $row['file'];
                            
                               
                        }
                        
                    ?>
                    </table>
					</div>
                     
            </div>
<h2 class="content-subhead">Image Uploader</h2>
                    <div class="upload_butt">
            <form action="uploader.php" target="_blank" method="post" enctype="multipart/form-data">
            <label class="custom-file-choose"> Choose image
                    <input type="file" name="file" id="filing">
            </label>
            <label class="custom-file-upload"> Upload
                    <input type="submit" name="submit" id="uploading"value="Upload">
                    </label>
                    <input type="hidden" name="poi_id_input" value="<?php echo ($_POST['poinameinput'])?>">
                    <input type="hidden" name="poi_id" value="<?php echo ($poidata[0][0])?>">

                    <input type="hidden" name="poi_city_fk_id" value="<?php echo ($poidata[0][6])?>">
                    <input type="text" class= "descriptionin" name="poi_description" maxlength="20" placeholder="Enter description">
            </form>
                    </div>
            <h2 class="content-subhead">Flickr Gallery</h2>
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




    
<script async defer src="<?php echo $string; ?>"></script>  

</body>
</html>