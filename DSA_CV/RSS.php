<?php
//returns an updated rss feed file into the same folder 
$web_url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

$xml=simplexml_load_file("configUWE.xml") or die("Error: Cannot create object");

//string variable to hold all RSS feed data
$str = "<?xml version='1.0' ?>";
$str .= "<rss version='2.0'>";

//channel tag to separate all tables in db
    $str .="<city>";
        $str .="<title>city_id</title>";
        $str .="<name>names</name>";
        $str .="<county>county</county>";
        $str .="<description>decription</description>";
        $str .="<lat>lat</lat>";
        $str .="<lng>lng</lng>";
        $str .="<population>population</population>";
        $str .="<currency>currency</currency>";
        $str .="<tags>tags</tags>";
        $str .="<language>en-US</language>";
        $str .="<link>$web_url</link>";

        $conn= mysqli_connect($xml->data->host,$xml->data->username,$xml->data->password,$dbname = $xml->data->databasename);
        $result = mysqli_query($conn, "SELECT * FROM city ORDER BY city_id DESC");

        while ($row = mysqli_fetch_object($result))
        {
            $str .="<item>";
                $str .="<title>" . $row->city_id . "</title>";
                $str .="<name>" . $row->names . "</name>";
                $str .="<county>" . $row->county . "</county>";
                $str .="<description>" . $row->description . "</description>";
                $str .="<lat>" . $row->lat . "</lat>";
                $str .="<lng>" . $row->lng . "</lng>";
                $str .="<population>" . $row->population . "</population>";
                $str .="<currency>" . $row->currency . "</currency>";
                $str .="<tags>" . $row->tags . "</tags>";
            $str .="</item>";
        }

    $str .="</city>";

    $str .="<category>";
        $str .="<title>cat_id</title>";
        $str .="<name>name</name>";
        $str .="<language>en-US</language>";
        $str .="<link>$web_url</link>";

        
        
        //get data from city table
        $result = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_id DESC");

        //loop through all records in table
        while ($row = mysqli_fetch_object($result))
        {
            $str .="<item>";
                $str .="<title>" . $row->cat_id . "</title>";
                $str .="<name>" . $row->name . "</name>";
            $str .="</item>";
        }

    $str .="</category>";

    $str .="<category_poi>";
        $str .="<cat_id_fk>cat_id_fk</cat_id_fk>";
        $str .="<poi_id_fk>poi_id_fk</poi_id_fk>";
        $str .="<language>en-US</language>";
        $str .="<link>$web_url</link>";

        
        //get data from city table
        $result = mysqli_query($conn, "SELECT * FROM category_poi ORDER BY cat_id_fk DESC");

        //loop through all records in table
        while ($row = mysqli_fetch_object($result))
        {
            $str .="<item>";
                $str .="<cat_id_fk>" . $row->cat_id_fk . "</cat_id_fk>";
                $str .="<poi_id_fk>" . $row->poi_id_fk . "</poi_id_fk>";
            $str .="</item>";
        }

    $str .="</category_poi>";

    $str .="<images>";
        $str .="<city_id_fk>city_id_fk</city_id_fk>";
        $str .="<image_id>image_id</image_id>";
        $str .="<title>title</title>";
        //$str .="<description>description</description>";
        $str .="<file>file</file>";
        $str .="<poi_id_fk>poi_id_fk</poi_id_fk>";
        $str .="<language>en-US</language>";
        $str .="<link>$web_url</link>";

        
        //get data from city table
        $result = mysqli_query($conn, "SELECT * FROM images ORDER BY city_id_fk DESC");

        //loop through all records in table
        while ($row = mysqli_fetch_object($result))
        {
            $str .="<item>";
                $str .="<city_id_fk>" . $row->city_id_fk . "</city_id_fk>";
                $str .="<image_id>" . $row->image_id . "</image_id>";
                $str .="<title>" . $row->title . "</title>";
                //$str .="<description>" . $row->description . "</description>";
                $str .="<poi_id_fk>" . $row->poi_id_fk . "</poi_id_fk>";
            $str .="</item>";
        }

    $str .="</images>";

    $str .="<poi>";
        $str .="<city_id_fk>city_id_fk</city_id_fk>";
        $str .="<poi_id>poi_id</poi_id>";
        $str .="<name>name</name>";
        $str .="<lat>lat</lat>";
        $str .="<lng>lng</lng>";
        $str .="<description>description</description>";
        $str .="<tags>tags</tags>";
        $str .="<language>en-US</language>";
        $str .="<link>$web_url</link>";

        
        //get data from city table
        $result = mysqli_query($conn, "SELECT * FROM poi ORDER BY city_id_fk DESC");

        //loop through all records in table
        while ($row = mysqli_fetch_object($result))
        {
            $str .="<item>";
                $str .="<city_id_fk>" . $row->city_id_fk . "</city_id_fk>";
                $str .="<poi_id>" . $row->poi_id . "</poi_id>";
                $str .="<name>" . $row->name . "</name>";
                $str .="<lat>" . $row->lat . "</lat>";
                $str .="<lng>" . $row->lng . "</lng>";
                $str .="<description>" . $row->description . "</description>";
                $str .="<tags>" . $row->tags . "</tags>";
            $str .="</item>";
        }

    $str .="</poi>";

$str .="</rss>";

//create and saves rss feed into a file  
file_put_contents("rss.xml", $str);

?>

<a href="rss.xml" target="_blank">
    <img class="rssimg" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/Generic_Feed-icon.svg/1024px-Generic_Feed-icon.svg.png">
</a>
<p>CLICK ICON TO VIEW RSS FEED</p>