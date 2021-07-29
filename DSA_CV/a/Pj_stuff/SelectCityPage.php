

<!DOCTYPE html> 
<html lang="en">
    
<head>  
    <link rel="stylesheet" type="text/css" href="cssstylesheet.css">      
</head>
<body id="yui_3_18_1_1_1580250990777_11">


<div class="splash-container" id="yui_3_18_1_1_1580250990777_13">
    <div class="splash" id="yui_3_18_1_1_1580250990777_12">
        <h1 class="splash-head">Twin Cities Project</h1>
        
        <p class="splash-subhead" id="yui_3_18_1_1_1580250990777_10">
            By Paul Holt
        </p>
        
    </div>
</div>

<div class="content-wrapper">
    <div class="content">
        

        <div class="pure-g">
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                <h2 class="content-subhead">Select a city</h2>

                    
                    <?php
                        $xml=simplexml_load_file("configHOME.xml") or die("Error: Cannot create object");
    
                        $host = $xml->data->host;
                        $user = $xml->data->username;
                        $password = $xml->data->password;
                        $dbname = $xml->data->databasename;
                        
                        // connecting to db
                        
                        $connect= mysqli_connect($host,$user,$password,$dbname);
                        if (!$connect)
                        {
                        die("Unable to connect to the database". mysqli_connect_error());
                        }
    
                        //SQL
                        $sql= "SELECT city_id, names FROM city";
                        $result = mysqli_query($connect,$sql);

                        while ($row = mysqli_fetch_array($result)) {
                        $data[] = $row;
                        }
                    ?> 
    
                    <form method="post" action="myMap.php" >
                        <select name="selectedcity" class="select-selected">
                            
                            <?php foreach ($data as $row): ?>
                                <option class = "custom-select" value="<?= $row['city_id'] ?>"><?=$row["names"]?></option>
                            <?php endforeach ?>
                            
                        </select>
                    <input type="submit" value="Submit" class="pure-button pure-button-primary"> 
                    </form> 
            </div>
            
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                <h2 class="content-subhead">Image Gallery</h2>
                
                    <table class="table table-bordered">
    
                        <?php
                            $min = 1;   
                            $max = 40;
                            $rand1 = mt_rand($min, $max);    
                            $rand2 = mt_rand($min, $max);
                            $rand3 = mt_rand($min, $max);    
                
                            $query = "SELECT file FROM images Where image_id = '$rand1' OR image_id = '$rand2' OR image_id = '$rand3' ";
    
                            $result = mysqli_query($connect, $query);  
                            while($row = mysqli_fetch_array($result))  
                            {  
                            echo '  
                           
                                <td>  
                                        <img src="data:image/jpeg;base64,'.base64_encode($row['file'] ).'" height="200" width="200" class="img-thumnail" />  
                                </td>  
                           
                                ';  
                            }
                
                 
                        ?>
                </table> 
                
            </div>
        </div>
    </div>
</div>


</body>

    
<table class="table table-bordered">
    
    <?php
        $min = 1;   
        $max = 40;
        $rand1 = mt_rand($min, $max);    
        $rand2 = mt_rand($min, $max);
        $rand3 = mt_rand($min, $max);    
                
        $query = "SELECT file FROM images Where image_id = '$rand1' OR image_id = '$rand2' OR image_id = '$rand3' ";
    
                $result = mysqli_query($connect, $query);  
                while($row = mysqli_fetch_array($result))  
                {  
                     echo '  
                           
                               <td>  
                                    <img src="data:image/jpeg;base64,'.base64_encode($row['file'] ).'" height="200" width="200" class="img-thumnail" />  
                               </td>  
                           
                     ';  
                }
                
                 
    ?>
</table>
    
</html>
    
