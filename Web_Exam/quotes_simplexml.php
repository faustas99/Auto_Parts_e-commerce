<!DOCTYPE html>
<html>
<head>
    <title>Quotes XML to HTML using PHP SimpleXML class</title>
    <meta charset='utf-8' />
    <style>
        tr:nth-child(odd){
            background-color:#eeeeee;
        }
        table {
            width:80%;
            text-align:left;
            margin: auto;
        }
        td {
            vertical-align:top;
        }
    </style>
</head>
<body>
    <table>
        <tr style="background-color: #bbbbbb;">
            <th>category</th>
            <th>quote</th>
            <th>author</th>
            <th>dob-dod</th>
            <th>image</th>
        </tr>
<?php
$xml = simplexml_load_file("quotes.xml") or die("Error: Cannot create object");
foreach ($xml->quote as $quotes) {
    echo '<tr>';
echo '<td>' . $quotes->text['category'] . '</td>';
    echo '<td>' . $quotes->text . '</td>';
    echo '<td>' . $quotes->source . '</td>';
    echo '<td>' . $quotes->dobdod . '</td>';
    echo '<td><img src="' . $quotes->wpimg . '" width="80px" /></td>';
    echo '</tr>';
	
}

?>
    </table>
</body>
</html>