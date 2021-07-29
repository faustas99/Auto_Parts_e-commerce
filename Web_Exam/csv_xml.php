<?php
# always include this line
@date_default_timezone_set("GMT"); 
$csv = file("quotes.csv");
$count = 1;
$xml = '<quotes>';
foreach($csv as $line) {
    $data = explode("|", $line);
    if ($count > 1) {
        $xml .= '<quote cat="'.trim($data[5]).'">';
        $xml .= '<text>'.$data[0].'</text>';
        $xml .= '<author>';
        $xml .= '<name>'.$data[1].'</name>';
        
        # split dob-dod
        list($dob, $dod) = explode('-', $data[2]);
        $xml .= '<dob>'.trim($dob).'</dob>';
        $xml .= '<dod>'.trim($dod).'</dod>';
        
        $xml .= '<wplink>'.$data[3].'</wplink>';
        $xml .= '<wpimg>'.$data[4].'</wpimg>';
        $xml .= '</author>';
        $xml .= '</quote>';
    }
    $count++; 
}
$xml .= '</quotes>';
header ("Content-Type:text/xml");
echo $xml;
?>