<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    require_once('phpFlickr.php');
    
    $xml=simplexml_load_file("configHOME.xml") or die("Error: Cannot create object");
    $host = $xml->data->host;
    $user = $xml->data->username;
    $password = $xml->data->password;
    $dbname = $xml->data->databasename;
    $Map_API_key = $xml->data->GoogleKEY;
    $Weather_API_key = $xml->data->OpenweathermapKEY;
    $Flickr_API_key = $xml->data->flikrKEY;
    $Flickr_API_secret = $xml->data->flikrSecretKey;
    
    //flickr Enable cache;
    $flickr = new phpFlickr($Flickr_API_key,$Flickr_API_secret,FALSE);
    $dbstring = 'mysql://'.$user.':'.$password.'@'.$host.'/'.$dbname;
    $flickr->enableCache("db", $dbstring);
    
    $city_id = $_POST['selectedcity'];

     // connecting to db
    
     $connect= mysqli_connect($host,$user,$password,$dbname);
     if (!$connect)
     {
       die("Unable to connect to the database". mysqli_connect_error());
     }

     //Building select query for city    
     $sql= "SELECT city_id, names,lat, longdit, description, currency, county, population FROM city WHERE city_id = '$city_id'";    
     $result = mysqli_query($connect,$sql);
     //passing the result into an array
     while ($row = mysqli_fetch_array($result)) {
        $citydata[] = $row;
     }    
     
         
     $cityname = $citydata[0][1];
     $description = $citydata[0][4];
     $currency = $citydata[0][5];
     $county = $citydata[0][6];
     $population =$citydata[0][7];
    
    
     //Building select query for poi
     $sql= "SELECT poi_id, name, lat, lng, wiki_url, description FROM poi WHERE city_id_fk = '$city_id'";
     $result = mysqli_query($connect,$sql);
     //passing the result into an array
     while ($row = mysqli_fetch_array($result)) {
        $poidata[] = $row;
     }

    // api  string
    $string = "https://maps.googleapis.com/maps/api/js?key=".$Map_API_key."&callback=initMap";
  ?>
    
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="cssstylesheet.css">
    
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous" ></script>
    
  <title>My Google Map</title>
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
                    <h2 class="content-head"><?php echo $cityname; ?>: Point of Interest Explorer</h2>
                    
                    <h2 class="content-subhead">Information</h2>
                
                        <div class="infobox">
                            <p><span class ="bold">Description: </span><?php echo $description; ?></p>
                            <p><span class ="bold">Currency: </span><?php echo $currency; ?></p>
                            <p><span class ="bold">County: </span><?php echo $county; ?></p>
                            <p><span class ="bold">Population: </span><?php echo $population; ?></p>
                        </div> 
                        
                        
                     
                    <h2 class="content-subhead">Local Map - <span class='info'>Click Icon's For More Information</span></h2>
                    <div id="map"></div>
                    
                    <form id="myForm" action="landingPage.php" method="POST">
                        <input type="hidden" name = "poiname" id="poiname" value="nothing">
                    </form>

    
                    <script>   
                        function initMap(){
                            
                            //Passes $poidata from the php array to a javascript array called poiarray
                            var poiarray = <?php echo json_encode($poidata)?>; 
                        
                            //Passes $citydata from the php array to a javascript array called cityarray
                            var cityarray = <?php echo json_encode($citydata)?>; 
            
                            // Map options
                            var options = {
                                zoom:12,
                                center:{lat:parseFloat(cityarray[0][2]),lng:parseFloat(cityarray[0][3])}
                            }

                            // New map
                            var map = new google.maps.Map(document.getElementById('map'), options);
                
                            //loops to the array length and creates new markers
                            for (i = 0; i < poiarray.length; i++) {
            
                                //Assigns each element of the array to a variable
                                var poiName = poiarray[i][1];
                                var poiLat = parseFloat(poiarray[i][2]);
                                var poiLng = parseFloat(poiarray[i][3]);
                                var poiUrl = poiarray[i][4];
                                var poidesc = poiarray[i][5];
                        
                                //Creates new marker with using the previous variables
                                var marker = new google.maps.Marker({
                                position: {lat: poiLat,lng: poiLng},
                                map: map,
                                title: poiName, 
                                });
                    
                                //Set the content of the marker
                                var content = poiName.bold() +  " - " + "<p>" + poidesc + "</p>" + " Click  The Icon For More Information".bold().italics();  
                        
                                //Create a new infowindow
                                var infowindow = new google.maps.InfoWindow();
                        
                                //Adding marker "listener" to listen for mouseover Displays content
                                google.maps.event.addListener(marker,'mouseover',   (function(marker,content,infowindow){ 
                                    return function(){
                                        infowindow.setContent(content);
                                        infowindow.open(map,this);
                                    };
                                })(marker,content,infowindow));
            
                                //Adding marker "listener" to listen for click goes to poi page by submitting form with the "poi_id"
                                google.maps.event.addListener(marker, 'click', function() {
                                    document.getElementById("poiname").value = this.title;
                                    document.getElementById("myForm").submit();
                                });
            
            
                            }
                        }
                </script>
            </div>
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                    <h2 class="content-subhead">Weather</h2>
                    <table id ="weathermaintable" >
                        <tr>
                            <td>
                                <div id="weatherbox" class="weatherbox">
                                <h2 class="weathertitle">Right Now</h2>
                    
                                <input type="hidden" id="city" value="<?php echo htmlentities($cityname); ?>" />
                                <div class='forecastbox'>
                                <div class="currentweather"></div>
                                    <script type="text/javascript">
    
                
                                        var city = $("#city").val();
                                        var key  = "<?php echo $Weather_API_key ?>";
            
                                        $.ajax({
                                            url:'http://api.openweathermap.org/data/2.5/weather',
                                            dataType:'json',
                                            type:'GET',
                                            data:{q:city, appid: key, units: 'metric'},

                                            success: function(data){
                                                var weather = '';
                                                $.each(data.weather, function(index, val){
                                                    
                                                    weather += '<p><b>' + data.name + "</b><img src="+ val.icon + ".png></p>"+ data.main.temp + '&deg;C ' + 
														' | ' + val.main + ", " + val.description 

													});
              
                                                $(".currentweather").html(weather);
                                            }

                                        })
                                    </script>
                                </div>
                                </div>
                            </td>
                            <td>
                                <div id="weatherbox" class="weatherbox">
                                    <h2 class="weathertitle">7 Day Forecast</h2>
                                    <div class="5dayforecast"></div>
                        
                                    <script type="text/javascript">
                                        var url = "https://api.openweathermap.org/data/2.5/forecast";
                                        $.ajax({
                                            url: url, //API Call
                                            dataType: "json",
                                            type: "GET",
                                            data: {
                                                q: city,
                                                appid: key,
                                                units: "metric",
                                                cnt: "7"
                                            },
                                            success: function(data) {
                                                console.log('Received data:', data) // For testing
                                                var wf = "";
                                                wf += "<div class='forecastbox'>"
                                                wf += "<table id='forecasttable'>"
                                                wf += "<tr>"
                                                const today = new Date()
                                                const date = new Date(today)
                                                date.setDate(date.getDate() + 1)
                                                var finaldate = date.toDateString();
                                                
                                                $.each(data.list, function(index, val) {
                                                    
                                                
                                                    wf += "<th>" // Opening paragraph tag
                                                    wf += "<b>" + finaldate + "</b>" // Day
                                                    wf += "</th>" // Closing paragraph tag
                                                    date.setDate(date.getDate() + 1)
                                                    finaldate = date.toDateString();
                                                });
                                                wf += "</tr>"
                                                wf += "<tr>"
                                                $.each(data.list, function(index, val) {
                                                    
                                                
                                                    wf += "<th>" // Opening paragraph tag
                                                    wf += "<img src='https://openweathermap.org/img/w/" + val.weather[0].icon +     ".png'>" // Icon
                                                    wf += "</th>" // Closing paragraph tag
        
                                                });
                                                wf += "</tr>"
                                                wf += "<tr>"
                                                $.each(data.list, function(index, val) {
      
                                                    wf += "<td>" // Opening paragraph tag
                                                    wf += val.main.temp + "&degC" // Temperature
                                                    wf += "<span> | " + val.weather[0].description + "</span></td>"; // Description

                                                });  
                                                wf += "</tr>"
                                                wf +="</table>"
                                                wf += "</div>"
                                                $(".5dayforecast").html(wf);
                                            }
                                        });
                                    </script>
                                </div>
                            </td>
                        </tr>
                </table>
            </div>
												<h2 class="weathertitle">7 Day Forecast</h2>
                                    <div class="5dayforecast"></div>
                        
                                    <script type="text/javascript">
                                        var url = "https://api.openweathermap.org/data/2.5/forecast";
                                        $.ajax({
                                            url: url, //API Call
                                            dataType: "json",
                                            type: "GET",
                                            data: {
                                                q: city,
                                                appid: key,
                                                units: "metric",
                                                cnt: "7"
                                            },
                                            success: function(data) {
                                                console.log('Received data:', data) // For testing
                                                var wf = "";
                                                wf += "<div class='forecastbox'>"
                                                wf += "<table id='forecasttable'>"
                                                wf += "<tr>"
                                                const today = new Date()
                                                const date = new Date(today)
                                                date.setDate(date.getDate() + 1)
                                                var finaldate = date.toDateString();
                                                
                                                $.each(data.list, function(index, val) {
                                                    
                                                
                                                    wf += "<th>" // Opening paragraph tag
                                                    wf += "<b>" + finaldate + "</b>" // Day
                                                    wf += "</th>" // Closing paragraph tag
                                                    date.setDate(date.getDate() + 1)
                                                    finaldate = date.toDateString();
                                                });
                                                wf += "</tr>"
                                                wf += "<tr>"
                                                $.each(data.list, function(index, val) {
                                                    
                                                
                                                    wf += "<th>" // Opening paragraph tag
                                                    wf += "<img src='https://openweathermap.org/img/w/" + val.weather[0].icon +     ".png'>" // Icon
                                                    wf += "</th>" // Closing paragraph tag
        
                                                });
                                                wf += "</tr>"
                                                wf += "<tr>"
                                                $.each(data.list, function(index, val) {
      
                                                    wf += "<td>" // Opening paragraph tag
                                                    wf += val.main.temp + "&degC" // Temperature
                                                    wf += "<span> | " + val.weather[0].description + "</span></td>"; // Description

                                                });  
                                                wf += "</tr>"
                                                wf +="</table>"
                                                wf += "</div>"
                                                $(".5dayforecast").html(wf);
                                            }
                                        });
                                    </script>
									
            <div>
                <h2 class="content-subhead">RSS FEED</h2>
                <?php
                    include 'RSS.php';
                ?>
            </div>
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                <h2 class="content-subhead">Image Gallery</h2>
                    
                    <table class="table table-bordered">
    
                        <?php
                            
                            $count = 0;
                            //Select image files with the city_id
                            $query = "SELECT file FROM images Where city_id_fk = '$city_id'";
                            
                            //Display the first 5
                            $result = mysqli_query($connect, $query);  
                            while(($count < 3) && ($row = mysqli_fetch_array($result)))  
                            {  
                                echo '  
                           
                                    <td>  
                                            <img src="data:image/jpeg;base64,'.base64_encode($row['file'] ).'" height="200" width="200" class="img-thumnail" />  
                                    </td>  
                           
                                ';
                                $count++;
                            }
                        
                            //Flickr stuff
                                $i = 0;
                                $tags = $cityname;
                                
                                $args = array("tags" => $cityname, "safe_search" => 1, "sort" => "interestingness-desc", "format" => "json");
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
