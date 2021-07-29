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
  <?php
  
  foreach($isocur  as $c)
{
	echo "<option value=".$c.">" . $c . "</option>";

	
}

  
  ?>
</select>


  POST <input type="radio" name="action" value="post">
  PUT <input type="radio" name="action" value="put">
  DELETE <input type="radio" name="action" value="del">
  <button type="submit">Submit</button>
  <body onload="setValue();">
	<form>
	</form>
</form>
</body>
</html>
<script type="text/javascript">
    function setValue() {
		 
        document.getElementById('selectedcur').value = "<?php echo $_GET['cur']; ?>";
		document.getElementById('form1').submit();
    }
</script>