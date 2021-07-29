<?php
$xmlts=simplexml_load_file('rates.xml') or die("Error: Cannot create object");
$ts = $xmlts->xpath("//rates/@ts");

foreach ($ts as $tsval) {
	$xmltime=$tsval;
}
echo $xmltime;
echo "<br>";

if ((time()-$xmltime)>7200)
{
	
	echo time()-$xmltime;
	$update=1;
}
else
{
	$update=0;
}
echo "<br>";
echo $update;

?>