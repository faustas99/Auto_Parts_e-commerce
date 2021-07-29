    function initMap(){
        
       
            
        // Map options
		
        var options = {
            zoom:10,
			//centers the map based on selected city's longitude and lattitude
            center:{lat:parseFloat(<?php echo $citydata[0]["lat"];?>),lng:parseFloat(<?php echo $citydata[0]["longdit"];?>)}
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
			
		url: "https://upload.wikimedia.org/wikipedia/en/thumb/0/0c/Liverpool_FC.svg/70px-Liverpool_FC.svg.png", // url
		scaledSize: new google.maps.Size(50, 50), // scaled size
		},
		{
		url: "https://upload.wikimedia.org/wikipedia/commons/b/b0/Beatles_logo.svg", // url
		scaledSize: new google.maps.Size(90, 50), // scaled size
		},
		{
		url: "https://upload.wikimedia.org/wikipedia/en/thumb/0/0c/Liverpool_FC.svg/70px-Liverpool_FC.svg.png", // url
		scaledSize: new google.maps.Size(50, 50), // scaled size
		},
		{
		url: "https://upload.wikimedia.org/wikipedia/commons/b/b0/Beatles_logo.svg", // url
		scaledSize: new google.maps.Size(90, 50), // scaled size
		},
		{
		url: "https://upload.wikimedia.org/wikipedia/en/thumb/0/0c/Liverpool_FC.svg/70px-Liverpool_FC.svg.png", // url
		scaledSize: new google.maps.Size(50, 50), // scaled size
		},
		{
		url: "https://upload.wikimedia.org/wikipedia/commons/b/b0/Beatles_logo.svg", // url
		scaledSize: new google.maps.Size(90, 50), // scaled size
		}
		];
		}
		
		if (<?php echo $city_id ?>==2){
		var icon = [
		{
		url: "https://www.liverpoolmuseums.org.uk/redesign/images/logo-nml-white.png", // url
		scaledSize: new google.maps.Size(50, 50), // scaled size
		},
		{
		url: "https://upload.wikimedia.org/wikipedia/en/thumb/0/0c/Liverpool_FC.svg/70px-Liverpool_FC.svg.png", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		},
		{
		url: "https://i.pinimg.com/474x/48/3c/8b/483c8b7800bab919ad2f1e3b9599f16a--logotype-palms.jpg", // url
		scaledSize: new google.maps.Size(40, 40), // scaled size
		},
		{
		url: "https://upload.wikimedia.org/wikipedia/commons/9/95/Albert_Docks_Liverpool.jpg", // url
		scaledSize: new google.maps.Size(90, 50), // scaled size
		},
		{
		url: "https://pbs.twimg.com/profile_images/733719102485897218/MZ_IFv3n_400x400.jpg", // url
		scaledSize: new google.maps.Size(50, 50), // scaled size
		},
		{
		url: "https://upload.wikimedia.org/wikipedia/commons/b/b0/Beatles_logo.svg", // url
		scaledSize: new google.maps.Size(70, 40), // scaled size
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
		  link:`http://localhost/DSA_CV/pages/${poiarray[i][0]}.php`}
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
            window.open(props.link);
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
