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
                    <h2 class="content-subhead">Weather</h2>
                    <table id ="weathermaintable" >
                        <tr>
                            <td>
                                <div >
                                <h2></h2>
                    
                                <input type="hidden" id="citydiv" value="<?php echo htmlentities($cityname); ?>" />
                                <div>
                                <div class="currentweather"></div>
                                    <script type="text/javascript">
    
                
                                        var city = $("#citydiv").val();
                                        var key  = "<?php echo $Weather_API_key ?>";
            
                                        $.ajax({
                                            url:'http://api.openweathermap.org/data/2.5/weather',
                                            dataType:'json',
                                            type:'GET',
                                            data:{q:city, appid: key, units: 'metric'},

                                            success: function(data){
                                                var weather = '';
                                                $.each(data.weather, function(index, val){
                                                    
                                                    weather += '<p></b><img src="http://openweathermap.org/img/wn/'+ val.icon + '@2x.png"></p>'+ data.main.temp + '&deg;C ' + 
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
                            </td>
                        </tr>
                </table>
            </div>
          
            
        </div>
    </div>
    
    
<script async defer src="<?php echo $string; ?>"></script>
         
</body>
</html>
