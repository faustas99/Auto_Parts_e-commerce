<!DOCTYPE html>
<!-- Referencing script used for weather api-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous" ></script>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
<html lang="en">
<head>
  <title>My Google Map</title>
</head>

<!--Post method from that sends the name of the pois whom marker was clicked to ingopage.php -->
<body>
  <form method="POST" id="poinameplc" action="infopage.php" target="infopage.php">
      <input type="hidden" id="poinameinput" name="poinameinput">
  </form>


  <div id="map"></div> 
  <h2 class="nowweather">Right Now</h2>
  <div id="nowweather" class="currentweather"> </div>
  
  
<?php
$xml=simplexml_load_file("configUWE.xml") or die("Error: Cannot create object");
  
if(!isset($_POST['selectedcity']))
{
    header("Location:SelectCityPage.php");
        exit();
}

$city_id=$_POST['selectedcity'];


// connecting to db    
$connect= mysqli_connect($xml->data->host,$xml->data->username,$xml->data->password,$xml->data->databasename);
    
if (!$connect)
{
    die("Unable to connect to the database". mysqli_connect_error());
}


// 
$sql= "SELECT city_id, names,lat, lng, description, currency, county, population FROM city WHERE city_id = '$city_id'";    
$result = mysqli_query($connect,$sql);

//passing the result into an array
while ($row = mysqli_fetch_array($result)) {
    $citydata[] = $row;
	
	
}    


 

//Selecting the values from the row that has a matching city id with the one that was selected in the previous page
$sql= "SELECT poi_id, name, lat, lng, wiki_url, description FROM poi WHERE city_id_fk = '$city_id'";
$result = mysqli_query($connect,$sql);
//passing the result into an array
while ($row = mysqli_fetch_array($result)) {
    $poidata[] = $row;
	
}


// api  
//making a variable that holds a link to the google map api
$string = "https://maps.googleapis.com/maps/api/js?key=".$xml->data->GoogleKEY."&callback=initMap";

?>

<script>   
    function initMap(){
            
        // Map options
		
        var options = {
            zoom:12,
			//centers the map based on selected city's longitude and lattitude
            center:{lat:parseFloat(<?php echo $citydata[0]["lat"];?>),lng:parseFloat(<?php echo $citydata[0]["lng"];?>)},
			gestureHandling: 'none',
            zoomControl: false,
            disableDefaultUI: true
        }

        // New map
		
        var map = new google.maps.Map(document.getElementById('map'), options);
	  
	  //array that holds all points of interest places 
		var poiarray = <?php echo json_encode($poidata); ?>
		
		//console.log(poiarray);
		
		if (<?php echo $city_id ?>==1){
			//assigning icons to each of the places of interest
		var icon = [
		{
			
		url: "images/bund.png", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		},
		{
		url: "images/propoganda.jpg", // url
		scaledSize: new google.maps.Size(50, 40), // scaled size
		},
		{
		url: "images/qibao.jpg", // url
		scaledSize: new google.maps.Size(50, 40), // scaled size
		},
		{
		url: "images/yugarden.jpg", // url
		scaledSize: new google.maps.Size(50, 40), // scaled size
		},
		{
		url: "images/nanjing.png", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		},
		{
		url: "images/Shanghai_SIPG.png", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		}
		];
		}
		
		if (<?php echo $city_id ?>==2){
        
		var icon = [
		{
		url: "images/wm.png", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		},
		{
		url: "images/Liverpool_FC.png", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		},
		{
		url: "images/palm.png", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		},
		{
		url: "images/tra.png", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		},
		{
		url: "images/livecath.jpg", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		},
		{
		url: "images/Beatles_logo.png", // url
		scaledSize: new google.maps.Size(50, 40), // scaled size
		}
		];
		}
		
		//array or markers
		var markers = [];
		
		for(var i = 0;i < poiarray.length ;i++){
		//puts in new elements with their properites like coords, iconImage etc. into markers array
		markers.push({coords:{lat:parseFloat(poiarray[i][2]),lng:parseFloat(poiarray[i][3])},
          iconImage: icon[i],
		  content:poiarray[i][5],
		  //adding a link of the marker that will later be used when the marker is clicked
		  link:`http://localhost/DSA_CV/pages/${poiarray[i][0]}.php`,
          poiname: poiarray[i][1]
          }
          );
	}

		//adding the markers on the map
         for(var i = 0;i < markers.length;i++){
       
        addMarker(markers[i]);
      }

      // Add Marker Function
      function addMarker(props){
        var marker = new google.maps.Marker({
		//setting the markers[] property "coords" as a position of the marker
          position:props.coords,
          map:map,
          title:props.poiname,
          
		  
        });

        // Check if this property is set
        if(props.iconImage){
          // Set icon image
          marker.setIcon(props.iconImage);
        }
        

        // Check if this property is set
        if(props.content){
          var infoWindow = new google.maps.InfoWindow({
            content:props.content
          });
		  
			
			//adding a listener that runs a function when marker is clicked
			marker.addListener('click', function(){
            document.getElementById("poinameinput").value = this.title;
            document.getElementById("poinameplc").submit();
            
          });
		  //adding a listener that runs a function when marker is hover on with mouse
          marker.addListener('mouseover', function(){
            infoWindow.open(map, marker);
          });
		  //adding a listener that runs a function when the mouse is no longer hovering on the marker
		   marker.addListener('mouseout', function(){
            infoWindow.close(map, marker);
          });
        }
      } 
    }
</script>

<!-- running the script as soon as possible -->
  <script async
    src="<?php echo $string; ?>">
  </script>
                               
                    
                                <input type="hidden" id="citydiv" value="<?php echo $citydata[0]["names"]; ?>" />
								
                                    <script type="text/javascript">
    
                
                                        var city = $("#citydiv").val();
                                        var key  = "<?php echo $xml->data->OpenweathermapKEY ?>";
										//$.ajax is an inbuilt jquery method used to make ajax responses
										//this is sort of an object that contains all the necessary configurations Ajax needs to send the request
                                        $.ajax({
											//the url of api
                                            url:'http://api.openweathermap.org/data/2.5/weather',
                                            dataType:'json',
                                            type:'GET',
											//the parameters of this api that I want to set
                                            data:{q:city, appid: key, units: 'metric'},
										
                                            success: function(data){
                                                var weather = '';
												//for each element there is in data.weather run that function
												//why does it only work with the cycle??????
                                                $.each(data.weather, function(index, val){
                                                    
                                                    weather += '<p></b><img src="http://openweathermap.org/img/wn/'+ val.icon + '@2x.png"></p>'+ data.main.temp + '&deg;C ' + 
                                                        ' | ' + val.main + ", " + val.description// + "," + data.sys.country
                                                });
              
                                                $(".currentweather").html(weather);
                                            }
										
                                        })
										
                                    </script>
									
									
									
                                    <div class="fivedayforecast"></div>
                        
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
                                                wf += "<table id='weathertable'>"
                                                wf += "<tr>"
                                                const today = new Date()
                                                const date = new Date(today)
                                                date.setDate(date.getDate() + 1)
                                                var finaldate = date.toString().split(' ')[0];
                                                
                                                $.each(data.list, function(index, val) {
                                                    
                                                
                                                    wf += "<th class='dayweek'>" // Opening paragraph tag
                                                    wf +=  finaldate  // Day
                                                    wf += "</th>" // Closing paragraph tag
                                                    date.setDate(date.getDate() + 1)
                                                    finaldate = date.toString().split(' ')[0];
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
                                                    wf += "" + val.main.temp + "&degC" // Temperature
                                                    wf += "<span> " + val.weather[0].description + "</span></td>"; // Description

                                                });  
                                                wf += "</tr>"
                                                wf +="</table>"
                                                wf += "</div>"
                                                $(".fivedayforecast").html(wf);
                                            }
                                        });
                                    </script>
									
									<div class="rssfeed">
                
                <?php
                
                    include 'RSS.php';
                
                ?>
            </div>
            </div>
                                </div>
                                </div>
								
</body>
</html>
