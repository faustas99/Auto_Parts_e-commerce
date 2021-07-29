<?php

@date_default_timezone_set("GMT");
$xml = simplexml_load_file('rates.xml');
$xmliso = simplexml_load_file('ISOfiles.xml');


?>
<html>
<body>
<!-- js script for adding the options -->

<h2>Currencies</h2>
<pre lang="xml">
<?php
	
  ?>
 </pre>
<form action="/WebDev_CV/test.php" target="_blank" method="POST">

 <select name="cur" >
  <?php
  
  foreach($xml->rate as $c)
{
	echo "<option value=".$c['code'].">" . $c["code"] . "</option>";

	
}

  
  ?>
</select>


  POST <input type="radio" name="action" value="post">
  PUT <input type="radio" name="action" value="put">
  DELETE <input type="radio" name="action" value="del">
  <button type="submit">Submit</button>
  
  <button type="button">Insert option</button>
	<form>
	</form>
</form>
<!-- <p id="demo"></p> -->
<?php
$index=-1;
  foreach($xml->rate as $a)
{
	$index=$index+1;
	$code=$a['code'];
	$codearray["$code"]=$index;
	
}
?>






</body>
</html>