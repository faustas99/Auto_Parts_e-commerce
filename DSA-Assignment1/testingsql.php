<?php
$xml=simplexml_load_file("configUWE.xml") or die("Error: Cannot create object");
$connect= mysqli_connect($xml->data->host,$xml->data->username,$xml->data->password,$xml->data->databasename);
    
    if (!$connect)
    {
        die("Unable to connect to the database". mysqli_connect_error());
    }

    // Building SQL Query for the 
    for($i = 0;$i <=9 ;$i++){
        // Building SQL Query for the 
        $sql= "SELECT cat_id_fk FROM category_poi WHERE poi_id_fk='$i'";
    $result = mysqli_query($connect,$sql);
    $row = mysqli_fetch_array($result); 
        
    $iconnumber[] = $row;
    }
    //echo $iconnumber[6][0];    
?>
<script type="text/javascript">
var array = <?php echo json_encode($iconnumber);?>;
alert(array[6][0]);

var icon = {
		  url: "images/wm.png", // url
		  scaledSize: "a", // scaled size
		};
</script>