<?php

@date_default_timezone_set("GMT");
$xml = simplexml_load_file('C:/xampp/htdocs/WebDev_CV/rates.xml');
$xmliso = simplexml_load_file('C:/xampp/htdocs/WebDev_CV/ISOfiles.xml');
$isocur = $xmliso->xpath("//Ccy");
?>
<html>
<body>
<!-- js script for adding the options -->

<h2>Currencies</h2>
<form action="/WebDev_CV/index.php" target="_blank" id="form1" method="POST">

 <select id="selectedcur" name="cur" >
 <option ></option> 
  <?php
  
  foreach($isocur  as $c)
{
	echo "<option value=".$c.">" . $c . "</option>";

	
}

  
  ?>
</select>
	<input type="hidden" id="doll" name="givecur" value="" >
	<input type="hidden" id="update" name="giveup" value="">
  POST <input type="radio" id = "r1" name="action" value="post">
  PUT <input type="radio" id = "r2" name="action" value="put">
  DELETE <input type="radio" id = "r3" name="action" value="del">
  <button type="submit" onclick="setValue()" >Submit</button>
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