<html>
<body>
<?php
require "vendor/autoload.php";            
// connecting to db
// Configuration
$conn = new MongoDB\Client();
$mydatabase= $conn->mydatabase;

////    selecting first row that
$result= $mydatabase->poi->findOne(
    ['name'=>'World Museum']
);

    //var_dump($result);
////


////    selecting all the rows that have the set cat_id_fk
$resultall= $mydatabase->category_poi->find(
    ['cat_id_fk'=>'1']
);


foreach($resultall as $oneresult)
{
    //var_dump ($oneresult);
}
////


////    selecting rows that have the matching value
$id['hi']=1;
$cities=$mydatabase->city->find(
    ['city_id'=>"${id['hi']}"],
    ['sort' => ['position' => 1]],
);
//var_dump($cities);
//all the elements of collection are split into rows
foreach($cities as $city)
{
    $citydata[]=$city;
}
//echo $citydata[0]['names'];
////






//// TESTING FOR DSA
$imagecollection=$mydatabase->images->find(
    ['poi_id_fk'=>"12"],
);
foreach($imagecollection as $onetable)
{
    $imagedb[]=$onetable;
}
echo $imagedb[1]['file'];
$poicollection=$mydatabase->category_poi->find(
);
//var_dump($cities);
foreach($poicollection as $onepoi)
{
    //echo $onepoi['cat_id_fk'];

    
}
//echo $poidata[0]['name'];

//echo $thing[0]['title'];
//$lenght= count($poidata);
//echo $lenght;
////
?>
<script>
//var poiarray = <?php //echo json_encode($poidata); ?>;
        //console.log(poiarray);
        //alert (poiarray[0]['lat']);
</script>

</body>
</html>
