<!DOCTYPE html>
<html>

<head>
<title>
XML to HTML
</title>
</head>


<body>
<table>
<tr>
<th>id</th>
<th>name(latin name)</th>
<th>light</th>
<th>price</th>
<th>image</th>
</tr>

<?php
$xml= simplexml_load_file('plants.xml') or die ('Error with the xml file');
foreach ($xml->plant as $plant)
{
	echo '<tr>';
	echo '<td>' . $plant['id'] . '</td>';
	echo '<td>' . $plant->common . '(' . $plant->botanical. ')</td>';
	echo '<td> <img src=" ' . $plant->img .' " width="40px" height="80px"></td>';
	echo '<td>' . $plant->price . '</td>';
	echo '</tr>';
}

?>
</table>
</body>



</html>