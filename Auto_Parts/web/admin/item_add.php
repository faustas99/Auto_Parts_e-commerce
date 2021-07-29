<html>
<head>
<?php
require_once("connectdb.php");

$sqlmnf= "SELECT brand_name,id FROM manufacturer";
$result = mysqli_query($connect,$sqlmnf);

while ($row = mysqli_fetch_array($result)) {
	$manufacturer[] = $row;
	
}


$sqlsub= "SELECT sub_model_name FROM sub_model";
$result = mysqli_query($connect,$sqlsub);

while ($row = mysqli_fetch_array($result)) {
	$sub[] = $row;
	
}

?>

<style>

body {
  background:#2d2d2d;
  display:flex;
  justify-content: center;
  align-items:center;
  flex-wrap:wrap;
  padding:0;
  margin:0;
  height:100vh;
  width:100vw;
  font-family: sans-serif;
  color:#FFF;
}

.select {
  display:flex;
  flex-direction: column;
  position:relative;
  width:250px;
  height:40px;
}

.option {
  padding:0 30px 0 10px;
  min-height:40px;
  display:flex;
  align-items:center;
  background:#333;
  border-top:#222 solid 1px;
  position:absolute;
  top:0;
  width: 100%;
  pointer-events:none;
  order:2;
  z-index:1;
  transition:background .4s ease-in-out;
  box-sizing:border-box;
  overflow:hidden;
  white-space:nowrap;
  
}

.option:hover {
  background:#666;
}

.select:focus .option {
  position:relative;
  pointer-events:all;
}

input {
  opacity:0;
  position:absolute;
  left:-99999px;
}

input:checked + label {
  order: 1;
  z-index:2;
  background:#666;
  border-top:none;
  position:relative;
}

input:checked + label:after {
  content:'';
  width: 0; 
	height: 0; 
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-top: 5px solid white;
  position:absolute;
  right:10px;
  top:calc(50% - 2.5px);
  pointer-events:none;
  z-index:3;
}

input:checked + label:before {
  position:absolute;
  right:0;
  height: 40px;
  width: 40px;
  content: '';
  background:#666;
}

</style>
</head>

<body>

<!-- MANUFACTURER -->
<div class="select" tabindex="1" id="manuselect">
  <?php foreach ($manufacturer as $row): ?>
		<input class="selectopt" type="radio" onclick="radioclick(<?=$row['id']?>)" name="radiomanu" id="<?=$row['brand_name']?>" title="<?=$row['brand_name']?>">
        <label for="<?=$row['brand_name']?>" class="option"><?=$row['brand_name']?></label>
  <?php endforeach?>
</div>

<!-- //MANUFACTURER -->


<!-- MODEL -->

<script>

function radioclick(brand) {
    brandid=brand;
    //alert (brandname);
    window.location.href="item_add.php?brand="+ brandid;
    
}


</script>
<?php
$count=0;
if($_GET)
{
    $count=1;
    $manuid=$_GET['brand'];
    $sqlmodel= "SELECT model_name FROM model WHERE manufacturer_id_fk = '$manuid'";
    $result = mysqli_query($connect,$sqlmodel);
    while ($row = mysqli_fetch_array($result)) {
        $model[] = $row;
        
    }
    
    
}





?>


<div class="select" tabindex="1">
  <?php
if ($count == 0) {
    exit;  
}
else
foreach ($model as $row):
  ?>
		<input class="selectopt" type="radio" name="test" id="<?=$row['model_name']?>" title="<?=$row['model_name']?>">
        <label for="<?=$row['model_name']?>" class="option"><?=$row['model_name']?></label>
  <?php endforeach?>
</div>
<!-- //MODEL -->



<!-- SUBMODEL -->
<div class="select" tabindex="1">
  <?php foreach ($sub as $row): ?>
		<input class="selectopt" type="radio" name="test" id="<?=$row['sub_model_name']?>" title="<?=$row['sub_model_name']?>">
        <label for="<?=$row['sub_model_name']?>" class="option"><?=$row['sub_model_name']?></label>
  <?php endforeach?>
</div>
<!-- //SUBMODEL -->
</body>
</hmtl>