<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>Super Market an Ecommerce Online Shopping Category Flat Bootstrap Responsive Website Template | Groceries :: w3layouts</title>
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





<!-- phpmagic -->

<?php

if(isset($_GET['submodel']))
{
$selected_submodel = $_GET['submodel'];
//echo $selected_submodel;
$count=0;
$xml=simplexml_load_file("config.xml") or die("Error: Cannot create object");

// connecting to db    
$connect= mysqli_connect($xml->data->host,$xml->data->username,$xml->data->password,$xml->data->databasename);

if (!$connect)
{
	die("Unable to connect to the database". mysqli_connect_error());
}


// Building SQL Query for the 
$sqlsubmodel= "SELECT sub_model_id FROM sub_model WHERE sub_model_name='$selected_submodel'";    
$result2 = mysqli_query($connect,$sqlsubmodel);

//Passing the result into an array
while ($row = mysqli_fetch_array($result2)) {
	$submodel[] = $row;

}
$submodelid= $submodel[0][0];
//echo $submodelid;

// Building SQL Query for the 
$sqlcategory= "SELECT category_name FROM item_category";    
$result = mysqli_query($connect,$sqlcategory);

//Passing the result into an array
while ($row = mysqli_fetch_array($result)) {
	$category[] = $row;
	$count++;
}
}
   
?>

<!-- phpmagic -->


	
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
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Groceries</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->


<!--- categories --->
	<div class="products">
		<div class="container">
			<div class="col-md-4 products-left">
				<div class="categories">
					<h2>Categories</h2>
					<ul class="cate">


					<form action = "/Auto_Parts/web/items.php" method = "GET" id="sub_model_id">
					<input type ="hidden" name="submodel" value="<?=$submodelid?>"></input>
					<?php foreach ($category as $row):?>
						<input type ="submit" name="category" value="<?=$row['category_name']?>" onclick = "submit_submodel()"></input>
						
						<a></a>
					<?php endforeach ?>
					</form>


					</ul>
				</div>																																												
			</div>

<script>
function submit_submodel() {
	document.getElementById("sub_model_id").submit();
}
</script>

		</div>
	</div>
<!--- categories --->



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