<?php
//Recieve Posted poiname
$poiname = "World Museum";
require_once('phpFlickr.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="cssstylesheet.css">
    
  <title>Landing Page</title>
  <style>
    #map{
      height:400px;
      width:100%;
    }
  </style>
</head>
<body>
    <div class="content">
        <div class="pure-g"> 
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                <h2 class="content-head"><?php echo $poiname; ?></h2>
                <h2 class="content-subhead">Information</h2>
                <div class="infobox">
                    
                    <?php 
                        $xml=simplexml_load_file("configHOME.xml") or die("Error: Cannot create object");
    
                        $host = $xml->data->host;
                        $user = $xml->data->username;
                        $password = $xml->data->password;
                        $dbname = $xml->data->databasename;
                        $Flickr_API_key = $xml->data->flikrKEY;
                        $Flickr_API_secret = $xml->data->flikrSecretKey;
                        $Map_API_key = $xml->data->GoogleKEY;
                        
                        //flickr Enable cache;
                        $flickr = new phpFlickr($Flickr_API_key,$Flickr_API_secret,FALSE);
                        $dbstring = 'mysql://'.$user.':'.$password.'@'.$host.'/'.$dbname;
                        $flickr->enableCache("db", $dbstring);
                    
                        // connecting to db
                        $connect= mysqli_connect($host,$user,$password,$dbname);
                        if (!$connect)
                        {
                            die("Unable to connect to the database". mysqli_connect_error());
                        }
                        
                        
                        $string = "https://maps.googleapis.com/maps/api/js?key=".$Map_API_key."&callback=initMap";
                            
                        //SQL
                        $sql= "SELECT poi_id, wiki_url, description, tags,lat, lng,name FROM poi WHERE name = '$poiname'";
                        $result = mysqli_query($connect,$sql);
                
                        //passing the result into an array
                        while ($row = mysqli_fetch_array($result)) {
                            $poidata[] = $row;
                        }
                        
                        //Fetching Each Element of th array and assigning to a variable
                        $poi_id = $poidata[0][0];
                        $wiki_url = $poidata[0][1];
                        $description = $poidata[0][2];
                        $tags = $poidata[0][3];
                
                        //Display POI data
                  
                            echo "<p><span class ='bold'>Description: </span>".$description."</p>";
                            echo "<a href='".$wiki_url."'> Wiki Link </a>";
                            echo"<p><span class ='bold'>Tags: </span>".$tags."</p>";
                    ?>
                    
                </div>  
            </div>
            <h2 class="content-subhead">Location</h2>
            <div id="map"></div>
            <script>   
                        function initMap(){
                            
                        //Passes $poidata from the php array to a javascript array called poiarray
                        var poiarray = <?php echo json_encode($poidata)?>; 
                        
                        
                        var poiLat = parseFloat(poiarray[0][4]);
                        var poiLng = parseFloat(poiarray[0][5]);
                        var poiName = poiarray[0][6];
                        var poiUrl = poiarray[0][1];
            
                        // Map options
                        var options = {
                        zoom:12,
                        center:{lat:poiLat,lng:poiLng}
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
            
            
            
        <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
            <h2 class="content-subhead">Image Gallery</h2> 
                    <table class="table table-bordered">
    
                    <?php
                        //SQL selecting image files with the current poi ID
                        $query = "SELECT file FROM images Where poi_id_fk = '$poi_id'";
                        
                        //Displays images in table
                        $result = mysqli_query($connect, $query);  
                        while($row = mysqli_fetch_array($result))  
                        {  
                            echo '  
                           
                                    <td>  
                                            <img src="data:image/jpeg;base64,'.base64_encode($row['file'] ).'" height="200" width="200" class="img-thumnail" />  
                                    </td>  
                           
                                ';  
                        }
                        
                        //Flickr stuff
                                $i = 0;
                                $tags = $poiname;
                                
                                $args = array("tags" => $poiname, "safe_search" => 1, "sort" => "interestingness-desc", "format" => "json");
                                $response = $flickr->photos_search($args);
                                
                            
                                foreach ($response['photo'] as $photo) {
                                    $url ='http://farm'.$photo['farm'].'.staticflickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'.jpg';
                                    echo '
                                    <td>
                                    <img src="'.$url.'"height="200" width="200">
                                    </td>';
                                    
                                    if ($i++ == 4) break;    
                                }
                    ?>
                        
                    </table> 
            </div>
        </div>
    </div>




    
<script async defer src="<?php echo $string; ?>"></script>  

</body>
</html>
