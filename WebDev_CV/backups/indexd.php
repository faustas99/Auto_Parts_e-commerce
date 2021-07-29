<?php
@date_default_timezone_set("GMT");

# params array
define('PARAMS', array('to', 'from', 'amnt', 'format'));
# error_hash to hold error numbers and messages
define ('ERROR_HASH', array(
	1000 => 'Required parameter is missing',
	1100 => 'Parameter not recognized',
	1200 => 'Currency type not recognized',
	1300 => 'Currency amount must be a decimal number',
	1400 => 'Format must be xml or json',
	1500 => 'Error in Service',
	2000 => 'Action not recognized or is missing',
	2100 => 'Currency code in wrong format or is missing',
	2200 => 'Currency code not found for update',
	2300 => 'No rate listed for currency',
	2400 => 'Cannot update base currency',
	2500 => 'Error in service'
));
if (!isset($_GET['format']) || empty($_GET['format'])) {
	$_GET['format'] = 'xml';
}
# ensure PARAM values match the keys in $GET
if (count(array_intersect(PARAMS, array_keys($_GET))) < 4) {
    echo generate_error(1000, $_GET['format']); 
    exit();
}
# ensure no extra params
if (count($_GET) > 4) {
	echo generate_error(1100, $_GET['format']); 
	exit();
}
echo "Valdation passed so far ....";
function generate_error($eno, $format='xml') {
	$msg = ERROR_HASH["$eno"];
	
	if ($format=='json') {
		$json = array('conv' => array("code" => "$eno", "msg" => "$msg"));
		
		$out = header('Content-Type: application/json');
		$out .= json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	}
	else {
		$xml =  '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<conv><error>';
		$xml .= '<code>' . $eno . '</code>';
		$xml .= '<msg>' . $msg . '</msg>';
		$xml .= '</error></conv>';
	
		$out = header('Content-type: text/xml');
		$out .= $xml;
	}
	return $out;
}



$currencyname = array (
    'AUD' => 'Australian dollar',
    'BRL' => 'Brazilian real',
    'CAD' => 'Canadian dollar',
    'CHF' => 'Swiss franc',
	'CNY' => 'Chinese yuan', 
	'DKK' => 'Danish krone', 
	'EUR' => 'Euro',
	'GBP' => 'British pound',
    'HKD' => 'Hong Kong dollar', 
	'HUF' => 'Hungarian forint', 
	'INR' => 'Indian rupee',
	'JPY' => 'Japanese yen',
    'MXN' => 'Mexican peso', 
	'MYR' => 'Malaysian ringgit', 
	'NOK' => 'Norwegian krone',
	'NZD' => 'New Zealand dollar',
    'PHP' => 'Philippine peso', 
	'RUB' => 'Russian ruble', 
	'SEK' => 'Swedish krona',
	'SGD' => 'Singapore dollar',
    'THB' => 'Thai baht', 
	'TRY' => 'Turkish lira', 
	'USD' => 'United States dollar',
	'ZAR' => 'South African rand' 
	);

if (file_exists('rates.xml')) {
	#copies the contents from rates.xml to new rates file "rates(time).xml
    copy('rates.xml', 'rates'.'_'.time().'.xml');
	#puts xml file contents into an object
    $xml = simplexml_load_file('rates.xml');
				  #value of the current element of object"$xml" is assigned to $r
    foreach($xml->rate as $r) {
					#r is an array that contains whats inside <rate>. It's: code,rate,live..
	#it then looks for "live" key in its array and checks if its value is 1			
        if ((string) $r['live'] == '1') {
	#????????????????????????????????????????????????????????????????????????????		
            $live[] = (string) $r['code'];
        }
    }
}
else {
# currency code array
    $live = array(
        'AUD', 'BRL', 'CAD','CHF',
        'CNY', 'DKK', 'EUR','GBP',
        'HKD', 'HUF', 'INR','JPY',
        'MXN', 'MYR', 'NOK','NZD',
        'PHP', 'RUB', 'SEK','SGD',
        'THB', 'TRY', 'USD','ZAR'
    );
}
# pull the rates json file (USE YOUR OWN API KEY)
$json_rates = file_get_contents('http://data.fixer.io/api/latest?access_key=5c5e29f06551f8149b884807ed8b63eb')
			  or die("Error: Cannot load JSON file from fixer");
#decode the json to a php object
#makes the json code into objects and arrays
$rates = json_decode($json_rates);
# calculate the GBP ratio
#go into object "$rates", then go into the element "rates" to find "GBP" and assign its value to $rates via ->...->.
$gbp_rate = 1/$rates->rates->GBP;
$timenow = $rates->timestamp;
echo date("Y-m-d h:i:sa",$timenow); 


# start and initialize the writer
$writer = new XMLWriter();
#
$writer->openURI('rates.xml');
#start xml document with: version=  encoding=
$writer->startDocument("1.0", "UTF-8");

$writer->startElement("rates");
#create attribute.       key    value
$writer->writeAttribute('base', 'GBP');
$writer->writeAttribute('ts', date("Y-m-d h:i:sa",$timenow));
#object $rates is made into array with keys and values of whats inside <rates>
foreach ($rates->rates as $code=>$rate) {
	$writer->startElement("rate");
    $writer->writeAttribute('code', $code);
	$writer->writeAttribute('currency', "currencyname[]");
    
    if ($code=='GBP') {
        $writer->writeAttribute('rate', '1.00');
    }
    else {
        $writer->writeAttribute('rate', $rate * $gbp_rate);
    }
    #in array checks if the value of $code (USD) exists in array $live 
    if (in_array($code, $live)) {
        $writer->writeAttribute('live', '1');
    }
    else {
        $writer->writeAttribute('live', '0');
    }
    $writer->endElement();
}
$writer->endElement();
$writer->endDocument();
$writer->flush();
echo "All done ....!";
exit;
?>