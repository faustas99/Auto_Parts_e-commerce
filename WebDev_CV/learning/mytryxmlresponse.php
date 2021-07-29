<?php
$fromcode= $_GET['from'];
$tocode= $_GET['to'];
$amnt= $_GET['amnt'];
$fromrate= $xml->xpath("//rate/@code[.='$fromcode']/parent::*");
$torate= $xml->xpath("//rate/@code[.='$tocode']/parent::*");

$fromcountry="fromcountry";
$tocountry="tocountry";

$conversion= ($torate[0]["rate"] / $fromrate[0]["rate"])*$amnt;


echo $xmltime;
echo "<br>";
echo $_GET["from"];
echo "<br>";
echo $fromrate[0]["currency"];
echo "<br>";
echo $fromcountry;
echo "<br>";
echo $_GET["amnt"];
echo "<br>";
echo $_GET["to"];
echo "<br>";
echo $torate[0]["currency"];
echo "<br>";
echo $tocountry;
echo "<br>";
echo $conversion;
echo "<br>";
echo $_GET["format"];



////////////////


$resp['date_time']= date('d M Y H:i', $xmltime);


$fromcode= $_GET['from'];
$tocode= $_GET['to'];

$resp['from_code']= $_GET['from'];


$resp['from_amnt']= $_GET['amnt'];

$fromrate= $xml->xpath("//rate[@code='$fromcode']/@rate")[0]['rate'];
$torate= $xml->xpath("//rate[@code='$tocode']/@rate")[0]['rate'];


$resp['from_curr']= $xml->xpath("//rate[@code='$fromcode']/@currency")[0]['currency'];

$rate= $torate / $fromrate;
$conversion= $rate*$resp['from_amnt'];

$resp['rate'] = $rate;
$resp['from_loc']= (string) $xml->xpath("//cntry[../@code='$fromcode']")[0];
echo $resp['from_loc'];










?>