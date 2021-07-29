<?php

@date_default_timezone_set("GMT");
$xml = simplexml_load_file('C:/xampp/htdocs/WebDev_CV/cvtest/rates.xml');
$xmliso=simplexml_load_file('http://www.currency-iso.org/dam/downloads/lists/list_one.xml') or die("Error: Cannot create object");
$isocur = $xmliso->xpath("//Ccy");
?>
<html>
<body>


<h2>Currencies</h2>
<!-- Form that is using post method to send values to index.php -->
<form action="/WebDev_CV/cvtest/index.php" target="_blank" id="form1" method="POST">

 <select id="selectedcur" name="cur" >
 <option ></option> 
 <!-- php echos all the currency codes in the <select> tag creating a select box for each currecny -->
  <?php
  
  foreach($isocur  as $c)
{
	echo "<option value=".$c.">" . $c . "</option>";

	
}

  
  ?>
</select>
 <!--2 hidden input field to store information about a currency that was selected via get method and an update field signaling that the update form was submited -->
	<input type="hidden" id="doll" name="givecur" value="" >
	<input type="hidden" id="update" name="giveup" value="">
  POST <input type="radio" id = "r1" name="action" value="post">
  PUT <input type="radio" id = "r2" name="action" value="put">
  DELETE <input type="radio" id = "r3" name="action" value="del">
   <!-- button runs a script on click -->
  <button type="submit" onclick="setValue()" >Submit</button>
   <!-- another script is run when the page is loaded -->
  <body onload="setValueUrl();">
	<form>
	</form>
</form>
</body>
</html>
<script type="text/javascript">

		    function setValueUrl() {
		
		
		var action= "<?php if(isset($_GET['action'])){echo $_GET['action'];}else{echo 0;}?>";
		var currency= "<?php if(isset($_GET['cur'])){echo $_GET['cur'];}else{echo 0;}?>";
		var checkinput_cur ="<?php if(isset($_GET['cur'])){echo 1;}else{echo 0;}?>";
		var checkinput_act ="<?php if(isset($_GET['action'])){echo 1;}else{echo 0;}?>";


		if(checkinput_cur=="1"&&checkinput_act=="1")
		{
		document.getElementById('doll').value = currency;
		document.getElementById("r3").value = action;
		document.getElementById("r3").checked = true;
		document.getElementById('update').value = "update";
		document.getElementById('form1').submit();
		}
		
		}
		
		
			function setValue() {
		document.getElementById('update').value = "update";
		document.getElementById('form1').submit();
		window.location.reload();
		}
       

</script>