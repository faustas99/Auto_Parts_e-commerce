<?php 
# quotes to csv - v1 
# prakash.chatterjee@uwe.ac.uk 
# sep 2014 
$row = 1; 
$fields = 6; 
$xml = ''; 
$xml = "<quotes>\n"; 
if (($handle = fopen("quotes_list_new.txt", "r")) !== FALSE) { 
    while (($data = fgetcsv($handle, 2000, "|")) !== FALSE) { 
							//(#.....,#maximumlength,seperator)
        if ($row>1) {$xml .= '<quote>';} 
        for ($c=0; $c < $fields; $c++) { 
            if ($row==1) { 
                $header[$c] = $data[$c]; 
            } 
            else { 
                if ($header[$c] == 'quote') { 
                    $xml .= '<text'.' category="'.$data[$fields-1].'">'.$data[0].'</text>'."\n";  
                } 
                elseif ($c<($fields-1)) { 
                    $xml .= '<'.$header[$c].'>'.$data[$c].'</'.$header[$c].'>'."\n"; 
                } 
            }     
        } 
        if ($row>1) $xml .= '</quote>'; 
        $row++; 
    } 
    fclose($handle); 
} 
else { 
    $xml = simplexml_load_string($xml);
} 
$json = json_encode($xml);
header ("Content-Type: application/json");
echo $json;
?>