<?php
// Include the database configuration file
include 'configtest.php';

$poititle="Shanghai SIPG F.C.";

// Get images from the database
$query = $db->query("SELECT * FROM images where title='$poititle'");


if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $imageURL = 'uploads/'.$row["file"];
        //echo $row['file'];
?>
    <img src="<?php echo $imageURL; ?>" alt="" />
<?php }
}else{ ?>
    <p>No image(s) found...</p>
<?php } ?>