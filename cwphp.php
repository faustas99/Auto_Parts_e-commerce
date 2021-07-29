<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Scarica gratis GARAGE Template html/css - Web Domus Italia - Web Agency </title>
	<meta name="description" content="Scarica gratis il nostro Template HTML/CSS GARAGE. Se avete bisogno di un design per il vostro sito web GARAGE può fare per voi. Web Domus Italia">
	<meta name="author" content="Web Domus Italia">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="source/bootstrap-3.3.6-dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="source/font-awesome-4.5.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="style/slider.css">
	<link rel="stylesheet" type="text/css" href="style/mystyle.css">
</head>
<body>
    
    
    
<div class="allcontain">
	<div id="carousel-up" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner " role="listbox">
			<div class="item active">
				<img src="image/oldcar.jpg" alt="oldcar">
				<div class="carousel-caption">
				</div>
			</div>
		</div>
        

    
		<nav class="navbar navbar-default midle-nav">
			
			
			<div class="collapse navbar-collapse" id="navbarmidle">
			
				<div class="searchtxt">
                    
                    <?php

// Input your own MySQL username and password!

$host="mysql5";
$user="fet18025718";
$password="birzelio25";
$dbname = "fet18025718";                  
$name=$_POST[name];
$year=$_POST[year];
    
 
$conn = mysqli_connect($host, $user, $password, $dbname);
 
    
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sqlsend1 = "SELECT manufacturer.Manufacturer_Name, engine.engine_volume, engine.BHP, car.body_style, review.Overall_Rating, review.Review FROM car
INNER JOIN engine ON car.car_id = engine.engine_id and car.Car_Assembly_Year = '$year' and car.car_name ='$name'
INNER JOIN review ON car.car_id = review.review_id
INNER JOIN manufacturer ON car.car_id = manufacturer.manufacturer_id";
                   
$result = mysqli_query($conn, $sqlsend1);
    

if (mysqli_num_rows($result) > 0) 
{
        $row = mysqli_fetch_assoc($result);
} 
else 
{
        echo "There is no such car in our database";
}

mysqli_close($conn);
?>
					<h1>Name:&emsp;&emsp;&emsp;&emsp;&emsp; <?php echo $name;?></h1>
                    <h1>Body Style:&emsp; &emsp;&nbsp;&nbsp; <?php echo $row['body_style'];?></h1>
                    <h1>Engine Volume:&nbsp;&nbsp;&nbsp; <?php echo $row['engine_volume']. "L";?></h1>
                    <h1>BHB:&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp; <?php echo $row['BHP'];?></h1>
                    <h1>Engine:&emsp; &emsp;&emsp;&emsp;&nbsp; <?php echo $row['Manufacturer_Name'];?></h1>
                    <h1>Rating:&emsp; &emsp;&emsp;&emsp;&nbsp; <?php echo $row['Overall_Rating']. "/10";?></h1>
                    <h1>Review:</h1><label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['Review'];?></label>
                    
				</div>
			</div>
		</nav>
	</div>
</div>
<!-- ____________________Featured Section ______________________________--> 
<div class="allcontain">
	<div class="feturedsection">
		<h1 class="text-center">_________________________________________________________</h1>
	</div>
	</div>
	<!-- ______________________________________________________Bottom Menu ______________________________-->
	<div class="bottommenu">
		 
			<div class="footer">
				<div class="copyright">
				  &copy; Copy right 2016 | <a href="L:\unix\public_html\README-en">Privacy </a>| <a href="#">Policy</a>
				</div>
				<div class="atisda">
					 Designed by <a href="http://www.webdomus.net/">Web Domus Italia - Web Agency </a> 
				</div>
			</div>
	</div>


<script type="text/javascript" src="source/bootstrap-3.3.6-dist/js/jquery.js"></script>
<script type="text/javascript" src="source/js/isotope.js"></script>
<script type="text/javascript" src="source/js/myscript.js"></script> 
<script type="text/javascript" src="source/bootstrap-3.3.6-dist/js/jquery.1.11.js"></script>
<script type="text/javascript" src="source/bootstrap-3.3.6-dist/js/bootstrap.js"></script>
</body>
</html>