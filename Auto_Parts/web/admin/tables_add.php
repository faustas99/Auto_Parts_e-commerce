<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
</head>

<!--------------------------------------------- PHP MAGIC -->

<?php
require_once("connectdb.php");

//SQL for manufucaturer list
$sqlmnf= "SELECT brand_name,id FROM manufacturer";
$result = mysqli_query($connect,$sqlmnf);

while ($row = mysqli_fetch_array($result)) {
	$manufacturer[] = $row;
	
}
//creating variables which will indictate wether there: 
//..models for the selected manufacturer 
$countmodel=0;
//..submodels for the selected model 
$countsub=0;
//..submodels for the selected model 
$countcat=0;
?>



<!-- /////////////////////////////////PHP MAGIC -->
<body>


<!------------------------------------------------ SEND SELECTED VALUES TO URL-->



<script>
//Function that is run when a radiobutton from manufacturer list is clicked
//it hold the values that are stored on the selected radio button. They are stored in the call function onclick=
function radioclick_manu(idbrand,namebrand) {
    brandid=idbrand;
    brandname=namebrand;

    //sending the values to the URL
    window.location.href="tables_add.php?brandname="+ brandname + "&brandid=" +brandid;
}



//Function that is run when a radiobutton from model list is clicked
function radioclick_model(idmodel,namemodel) {

    modelid=idmodel;
    modelname=namemodel;

    //looking at the url
    const queryString = window.location.search;
    //searching the url for the parameters
    const urlParams = new URLSearchParams(queryString);
    //selecting the parameters and give their values to the variables
    var brandname = urlParams.get('brandname')
    var brandid = urlParams.get('brandid')

    //sending the values to the URL
    window.location.href="tables_add.php?brandname="+ brandname + "&brandid=" +brandid + "&modelname=" + modelname + "&modelid=" +modelid;
}


//Function that is run when a radiobutton from submodel list is clicked
function radioclick_sub(idsub,namesub) {

subid=idsub;
subname=namesub;

const queryString = window.location.search;

const urlParams = new URLSearchParams(queryString);

var brandname = urlParams.get('brandname')
var brandid = urlParams.get('brandid')
var modelname = urlParams.get('modelname')
var modelid = urlParams.get('modelid')


//alert (brandname); $_GET["brandname"]
window.location.href="tables_add.php?brandname="+ brandname + "&brandid=" +brandid + "&modelname=" + modelname + "&modelid=" +modelid + "&subname=" + subname + "&subid=" +subid ;
}



//Function that is run when a radiobutton from category list is clicked
function radioclick_cat(idcat,namecat) {

catid=idcat;
catname=namecat;

const queryString = window.location.search;

const urlParams = new URLSearchParams(queryString);

var brandname = urlParams.get('brandname')
var brandid = urlParams.get('brandid')
var modelname = urlParams.get('modelname')
var modelid = urlParams.get('modelid')
var subname = urlParams.get('subname')
var subid = urlParams.get('subid')

//console.log(modelname);
//console.log(modelid);


//alert (brandname); $_GET["brandname"]
window.location.href="tables_add.php?brandname="+ brandname + "&brandid=" +brandid + "&modelname=" + modelname + "&modelid=" + modelid + "&subname=" + subname + "&subid=" +subid +"&modelid=" + modelid + "&catname=" + catname + "&catid=" +catid;
}

</script>


<!-- ////////////////////////////////////////////////// SEND SELECTED VALUES TO URL -->





<!---------------------------------------------------- MANUFACTURER -->

<div class="holdlist">
<div class="select1" tabindex="1" id="manuselect">
  <?php foreach ($manufacturer as $row): ?>
		<input class="selectopt" type="radio" onclick="radioclick_manu(<?=$row['id']?>,'<?=$row['brand_name']?>')" name="radiomanu" id="<?=$row['brand_name']?>" title="<?=$row['brand_name']?>">
        <label for="<?=$row['brand_name']?>" class="option"><?=$row['brand_name']?></label>
  <?php endforeach?>
</div>
<div class="holdnewinput">
    <form method="post" action="#" >
<input  class="newinput" type="text" name="newbrandname" placeholder="Enter New Manufacturer"></input>
<button type ="submit">Submit </button>
   </form>

</div>
</div>

<!-- Making sure that when the selection from the list is made and the when the page refreshes the selection stays -->
<?php
if(isset($_GET['brandname']))
{
    $selectedradio=$_GET["brandname"];
//calling a script, which takes the the GET value which holds selected button value and selects that radio button.
    echo '<script type="text/JavaScript">', 
    'document.getElementById("',
    $selectedradio,
    '").checked = true;',
     '</script>'
;
}
?>

<!-- //////////////////////////////////////////////////////////////////////MANUFACTURER -->





<!------------------------------------------------------------------------- MODEL -->


<?php
//check if the manufacturer is selected 
if(isset($_GET['brandid']))
{
    
    $manuid=$_GET['brandid'];
    //Selecting model names of the selected manufacturer
    $sqlmodel= "SELECT * FROM model WHERE manufacturer_id_fk = '$manuid'";
    $result = mysqli_query($connect,$sqlmodel);
    while ($row = mysqli_fetch_array($result)) {
        
        $model[] = $row;
        //Indication that there are models for this manufacturer so only then the the model list is displayed.
        $countmodel++;
        
    }   
}
?>


<div class="holdlist">
<div class="select1" tabindex="1">
    <?php
//Cheks if there are any models of the selected manufacturer
if ($countmodel == 0) {
    //if there aren't, exits the php and doesn't create the list of models'
    exit;  
}
else
foreach ($model as $row):
  ?>
        <!--Usefull discovery: Calling a javascript function with the selected model name and model id  -->
		<input class="selectopt" type="radio" onclick="radioclick_model(<?=$row['model_id']?>,'<?=$row['model_name']?>')" name="radio" id="<?=$row['model_name']?>" title="<?=$row['model_name']?>">
        <label for="<?=$row['model_name']?>" class="option"><?=$row['model_name']?></label>
  <?php endforeach?>
</div>
<div class="holdnewinput">
<input class="newinput" type="text"  placeholder="Enter New Model">
<button type ="submit">Submit </button>
</div>
</div>


<?php
//if there is a get atribute with the model name..
if(isset($_GET['modelname']))
{
    $selectedradio=$_GET["modelname"];

    //..call a script, which takes the the GET value checks a radio button with that value.
    //It's done so when the page refreshes the selections stay.
    echo '<script type="text/JavaScript">', 
    'document.getElementById("',
    $selectedradio,
    '").checked = true;',
     '</script>'
     
;

}
?>


<!-- /////////////////////////////////////////////////////////////////////////MODEL -->





<!---------------------------------------------------------------------------SUBMODEL -->



<?php
//Repeating
if(isset($_GET['modelid']))
{
    
    $modelid=$_GET['modelid'];
    //echo $modelid;
    //Selecting model names of the selected manufacturers
    $sqlsub= "SELECT * FROM sub_model WHERE model_id_fk = '$modelid'";
    $result = mysqli_query($connect,$sqlsub);
    //I select the model names for the manufacturer name that the GET holds
    while ($row = mysqli_fetch_array($result)) {
        
        $sub[] = $row;
        //and I indicate that there are model for this manufacturer so only then the the model list is displayed.
        $countsub++;
        
    }
       
}
?>





<div class="holdlist">
<div class="select" tabindex="1">
  <?php
  if ($countsub == 0) {
    exit;  
    }
  else
  foreach ($sub as $row): ?>
        <input class="selectopt" type="radio" onclick="radioclick_sub(<?=$row['sub_model_id']?>,'<?=$row['sub_model_name']?>')" name="radio" id="<?=$row['sub_model_name']?>" title="<?=$row['sub_model_name']?>">
        <label for="<?=$row['sub_model_name']?>" class="option"><?=$row['sub_model_name']?></label>
  <?php endforeach?>
  
</div>
<div class="holdnewinput">
<input  class="newinput" type="text"  placeholder="Enter New Sub_Model">
<button type ="submit">Submit </button>
</div>
</div>

<?php
//Repeating
if(isset($_GET['subname']))
{
    $selectedradio=$_GET["subname"];
    //echo $selectedradio;
//calling a script, which takes the the GET value which has the selected button value and checks that radio button.

    echo '<script type="text/JavaScript">', 
    'document.getElementById("',
    $selectedradio,
    '").checked = true;',
     '</script>'
     
;

}
?>



<!-- //////////////////////////////////////////////////////SUBMODEL -->




<!---------------------------------------------------------CATEGORY -->


<?php
//Repeating
if(isset($_GET['subid']))
{
    
    $sqlcat= "SELECT * FROM item_category";
    $result = mysqli_query($connect,$sqlcat);
    //I select the model names for the manufacturer name that the GET holds
    while ($row = mysqli_fetch_array($result)) {
        
        $cat[] = $row;
        //and I indicate that there are model for this manufacturer so only then the the model list is displayed.
        $countcat++; 
    }     
}
?>





<div class="holdlist">
<div class="select" tabindex="1">
  <?php
  if ($countcat == 0) {
    exit;  
    }
  else
  foreach ($cat as $row): ?>
        <input class="selectopt" type="radio" onclick="radioclick_cat(<?=$row['item_category_id']?>,'<?=$row['category_name']?>')" name="radio" id="<?=$row['category_name']?>" title="<?=$row['category_name']?>">
        <label for="<?=$row['category_name']?>" class="option"><?=$row['category_name']?></label>
  <?php endforeach?>
</div>
<div class="holdnewinput">
<input class="newinput" type="text" placeholder="Enter New Category">
<button type ="submit">Submit </button>
</div>
</div>





<?php
//Repeating
if(isset($_GET['catname']))
{
    $selectedradio=$_GET["catname"];
//calling a script, which takes the the GET value which has the selected button value and checks that radio button.
    echo '<script type="text/JavaScript">', 
    'document.getElementById("',
    $selectedradio,
    '").checked = true;',
     '</script>'   
;
}
?>


<!-- //////////////////////////////////////////////////////CATEGORY -->











<?php
/*
if(isset($_POST['newbrandname']))
{
    $brandname= $_POST['newbrandname'];

}



$modelname= $_GET['modelname'];
$subname= $_GET['subname'];
$catname= $_GET['catname'];


$error=false;

//preparing an sql stament
$sql= "SELECT * FROM model WHERE model_name='$modelname'";
//this is responsible for the prepared statements
$stmt=mysqli_stmt_init($connect);
//if this returns true it means there already is this model
if(!mysqli_stmt_prepare($stmt,$sql))
{
        ///fail message
    $error=true;

}
//setting what kind and how many parameters will i send to the prepared statemnt
mysqli_stmt_bind_param($stmt, "s", $brandname);
mysqli_stmt_execute($stmt);
//result from the sent query
$result=mysqli_stmt_get_result($stmt);

if(!($row = mysqli_fetch_assoc($result)))
{
  
  $error= false;
}
else
{
  $error=true;
  echo "already exsists";
}
mysqli_stmt_close($stmt);
*/
?>


</body>
</hmtl>