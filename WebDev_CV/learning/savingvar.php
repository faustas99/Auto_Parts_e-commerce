<?php
$xmlts=simplexml_load_file('rates.xml') or die("Error: Cannot create object");
$ts = $xmlts->xpath("//rates/@ts");

foreach ($ts as $tsval) {
	$xmltime=$tsval;
}
echo $xmltime;

if ((time()-$xmltime)>7200)
{
	$oldtime=time();
	$update=1;
}
else
{
	$update=0;
}
echo $update;

?>