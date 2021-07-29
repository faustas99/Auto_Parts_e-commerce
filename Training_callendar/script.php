<?php
$holdjson=json_decode( file_get_contents("jsontext.json"));
var_dump($holdjson);
echo "<br>";
$i=0;
$wholenumbers1= $holdjson->Person_1;
$wholenumbers2= $holdjson->Person_2;


foreach($wholenumbers1 as $key=> $wholenumber1)
{
    $hours1[$key]= (int)$wholenumber1;
    $minutes1[$key]= ((float)$wholenumber1-$hours1[$key])*100;
    
}
foreach($wholenumbers2 as $key=> $wholenumber2)
{
    $hours2[$key]= (int)$wholenumber2;
    $minutes2[$key]= ((float)$wholenumber2-$hours2[$key])*100;
}

echo $minutes1[0];


/*
echo $hours;
echo "<br>";
echo $minutes;
*/
?>
