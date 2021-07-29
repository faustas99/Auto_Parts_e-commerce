<?php

@date_default_timezone_set("GMT");
$xml = simplexml_load_file('rates.xml');
$xmliso = simplexml_load_file('ISOfiles.xml');





function generate_error() {
$xmls =  '<?xml version="1.0" encoding="UTF-8"?>';
$xmls .= '<conv><error>\n';
$xmls .= '<code>sas</code>';
$xmls .= '<msg>czxc</msg>';
$xmls .= '</error></conv>';
	
//$out = header('Content-type: text/xml');
//$out .= $xmls;
echo $xmls;

}

//var_dump ($xmls);
?>
<html>
<body>
<!-- js script for adding the options -->

<h2>Currencies</h2>
<pre lang="xml">
<?php
	
  ?>
 </pre>
<form action="" target="_blank" method="get">

 <select name="cur" >
  <?php
  
  foreach($xml->rate as $c)
{
	echo "<option value=".$c['code'].">" . $c["code"] . "</option>";
	//$codes[]=$c;
	
}
  
  
  ?>
</select>
<?php

?>

  POST <input type="radio" name="action" value="post">
  PUT <input type="radio" name="action" value="put">
  DELETE <input type="radio" name="action" value="del">
  <button type="submit">Submit</button>
  
  <button type="button" onclick="addOptions()">Insert option</button>
	<form>
		<xmp>
		<?php 
		generate_error();
		?>
		</xmp>
	</form>
</form>
<?php

		if (isset($_GET['cur']))
		{
		$cur=$_GET['cur'];
		$node=$xmliso->xpath("//Ccy[.='$cur']/parent::*");
		
	foreach ($node as $index=>$nodeval) 
	{
	
		echo $nodeval->CtryNm;
		echo "<br>";
		echo $nodeval->CcyNm;
	}
		}	
?>
</body>
</html>