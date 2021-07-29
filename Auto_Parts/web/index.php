<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<meta name="verify-paysera" content="fad7d357fb298d08f0b21f871cd6b2a4">
<title>Super Market an Ecommerce Online Shopping Category Flat Bootstrap Responsive Website Template | Home :: w3layouts</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Super Market Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- js -->
<script src="js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<link href='//fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});

	
</script>

<!-- start-smoth-scrolling -->
</head>




<!-- phpdatabase -->


<?php
	session_start();

    $xml=simplexml_load_file("config.xml") or die("Error: Cannot create object");

    // connecting to db    
    $connect= mysqli_connect($xml->data->host,$xml->data->username,$xml->data->password,$xml->data->databasename);
    
    if (!$connect)
    {
        die("Unable to connect to the database". mysqli_connect_error());
    }


    // Building SQL Query for the 
    $sql= "SELECT id, brand_name FROM manufacturer ORDER BY brand_name ASC";    
    $result = mysqli_query($connect,$sql);

    //Passing the result into an array
    while ($row = mysqli_fetch_array($result)) {
        $brands[] = $row;
	
	}    
	?>



<!-- //phpdatabase -->




<body>
<!-- header -->

	<div class="logo_products">
		<div class="container">
		<div class="w3ls_logo_products_left1">
				<ul class="phone_email">
					<li></li>
					
				</ul>
			</div>
			<div class="w3ls_logo_products_left">
				<h1><a href="index.php">AUTO PARTS</a></h1>
				<?php
				if(isset($_SESSION['userid']))
				{
					//showing certain html (in this case a text and person's, who's logged in, name) if $_SESSION was started and it holds a user id
					echo '<h2><a href="index.php"> Welcome, ';
					echo $_SESSION['username'];
					echo '</a></h2>';
					echo '<a type="submit" href="/Auto_Parts/web/logout.php" aria-label="Left Align"> Logout </a>';
				}
				?>
			</div>
		<div class="w3l_search">
			
			<form action="#" method="post">
				<input type="search" name="Search" placeholder="Search for a Product..." required="">
				<button type="submit" class="btn btn-default search" aria-label="Left Align">
					<i class="fa fa-search" aria-hidden="true"> </i>
				</button>
				<div class="clearfix"></div>
			</form>
		</div>
			
			<div class="clearfix"> </div>
			
		</div>
	</div>
<!-- //header -->
<!-- navigation -->
<!-- //navigation -->
	<!-- main-slider -->
	<!-- //main-slider -->
	<!-- //top-header and slider -->












	<!--brands-->
	<div class="brands">
		<div class="container">
		<h3>Markė</h3>
			<div class="brands-agile">
			<form action = "/Auto_Parts/web/model.php" method = "GET">
				<?php foreach ($brands as $row): ?>
				<div class="col-md-2 w3layouts-brand">
					<div class="brands-w3l">

						<input id = "brand_submit" name="manufacturer" type= "submit" value = "<?=$row['brand_name']?>"></input>
						</div>
				</div>
    			<?php endforeach ?>
				</form>
			</div>
		</div>
	</div>	
<!--//brands-->









	<!-- top-brands -->
	
	<!-- //top-brands -->
 <!-- Carousel
    ================================================== -->
<!-- /.carousel -->	
<!--banner-bottom-->
<!--banner-bottom-->

<!-- new -->
<!-- //new -->
<!-- //footer -->
<div class="footer">		
		<div class="footer-copy">
			
			<div class="container">
				<p>© 2017 Super Market. All rights reserved | Design by <a href="http://w3layouts.com/">W3layouts</a></p>
			</div>
		</div>
		
	</div>	
<!-- //footer -->	
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- top-header and slider -->
<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
								
			$().UItoTop({ easingType: 'easeOutQuart' });
								
			});
	</script>
<!-- //here ends scrolling icon -->
<script src="js/minicart.min.js"></script>
<script>
	// Mini Cart
	paypal.minicart.render({
		action: '#'
	});

	if (~window.location.search.indexOf('reset=true')) {
		paypal.minicart.reset();
	}
</script>
<!-- main slider-banner -->
<script src="js/skdslider.min.js"></script>
<link href="css/skdslider.css" rel="stylesheet">
<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});
						
			jQuery('#responsive').change(function(){
			  $('#responsive_wrapper').width(jQuery(this).val());
			});
			
		});
</script>	
<!-- //main slider-banner --> 
</body>
</html>