<?php
/*
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
	echo "notset";
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
# validate parameter values
# load the rates file as a simple xml object
$xml=simplexml_load_file('rates.xml');
# xpath the codes of the rates which are live
$rates = $xml->xpath("//rate[@live='1']/@code");
# create a php array of these codes
foreach ($rates as $key=>$val) {$codes[] =(string) $val;}
# $to and $from are not recognized currencies
if (!in_array($_GET['to'], $codes) || !in_array($_GET['from'], $codes)) {
    echo generate_error(1200, $_GET['format']);
	exit;
}
# $amnt is not a two digit decimal value (can be integer)
if (!preg_match('/^\d+(\.\d{1,2})?$/', $_GET['amnt'])) {
	echo generate_error(1300, $_GET['format']);
	exit;
}
# set a constant array holding format vals
define('FRMTS', array('xml', 'json'));
# check for allowed format values
if (!in_array( $_GET['format'], FRMTS)) {
	echo generate_error(1400);
	exit;
}
# function to return xml or json errors
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
*/




////>>>   %%%%%%%%%%%% XPATH
$namespaste= array();
$xmliso=simplexml_load_file('http://www.currency-iso.org/dam/downloads/lists/list_one.xml') or die("Error: Cannot create object");
$codesiso = $xmliso->xpath("//CcyNtry/Ccy");
//$codesiso is an array containing Codes. #codes[0]="AFN" #codes["1"]="EUR"... 



//var_dump($codes);

$ccodesiso = [];
//$strnodes=[];
# make array with unique currency codes
foreach ($codesiso as $codeiso) {
	if (!in_array($codeiso, $ccodesiso)) {
		#ccodes has all the codes of currencies (USD,EUR..)
		$ccodesiso[] = (string) $codeiso;
		$namespaste["$codeiso"]= "ha";
		 
		
		//echo "<br>";
		//if($namespaste["EUR"]==ha)
		//{
			//echo $namespaste["$codeiso"];
		//}
	}
}



	foreach ($ccodesiso as $ccodeiso) {
	//$plus=$plus+1;
	$nodes = $xmliso->xpath("//Ccy[.='$ccodeiso']/parent::*");
	//$nodes is now an object containing containing all the <Ccy>s, whos value is "$ccode"("EUR"), parents(<CcyNtry>) elements (<CtryNm>, <CcyNm>...) and their values
	 
	//??????????? Why 0?
	$cname =  $nodes[0]->CcyNm;
	$namespaste["$ccodeiso"]= "$cname";
	//var_dump($nodes);
	//??????what array is this?
	//echo $cname;
	//echo "<br>";
	//$namespaste= array();
	//$namespaste[$cname]=$ccodeiso;
	
	
}

if (file_exists('rates.xml')) {
	$xml = simplexml_load_file('rates.xml');
	
	$ts = $xml->xpath("//rates/@ts");

foreach ($ts as $tsval) {
	$xmltime=$tsval;
}
echo "<br>";
echo time()-$xmltime;
echo "<br>";

if ((time()-$xmltime)>7200)
{
	
	$update=1;
}
else
{
	
	$update=0;
}
}



///////NOW



////<<<   %%%%%%%%%%%% XPATH

	
if (file_exists('rates.xml')) {
	#copies the contents from rates.xml to new rates file "rates(time).xml
	if($update==1){
    copy('rates.xml', 'rates'.'_'.time().'.xml');
	#puts xml file contents into an object
   
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
if((!isset($xml))||($update==1)) {
$json_rates = file_get_contents('http://data.fixer.io/api/latest?access_key=5c5e29f06551f8149b884807ed8b63eb')
			  or die("Error: Cannot load JSON file from fixer");
#decode the json to a php object
#makes the json code into objects and arrays
$rates = json_decode($json_rates);
# calculate the GBP ratio
#go into object "$rates", then go into the element "rates" to find "GBP" and assign its value to $rates via ->...->.
$gbp_rate = 1/$rates->rates->GBP;
$timenow = $rates->timestamp;



# start and initialize the writer
$writer = new XMLWriter();
#
$writer->openURI('rates.xml');
#start xml document with: version=  encoding=
$writer->startDocument("1.0", "UTF-8");

$writer->startElement("rates");
#create attribute.       key    value
$writer->writeAttribute('base', 'GBP');
$writer->writeAttribute('ts', time());
$writer->writeAttribute('at',(date("Y-m-d h:i",time())));
#object $rates is made into array with keys and values of whats inside <rates>
foreach ($rates->rates as $code=>$rate) {
	$writer->startElement("rate");
    $writer->writeAttribute('code', $code);
	
	////testing
	$nodes = $xmliso->xpath("//Ccy[.='$code']/parent::*");
	
	////testing
	
	
	if (array_key_exists($code, $namespaste)) {
	$writer->writeAttribute('currency', "$namespaste[$code]");
	//echo $namespaste[$code];
    }
	if (!array_key_exists($code, $namespaste)) {
	$writer->writeAttribute('currency', "no");
    }
	
	
	
	
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
	///testing
	
	$writer->startElement("cntry");
		
			$last = count($nodes) - 1;
			
			# group countries together using the same code
			# & lowercase first letter in name
			foreach ($nodes as $index=>$node) {
				$writer->text(mb_convert_case($node->CtryNm, MB_CASE_TITLE, "UTF-8"));
				if ($index!=$last) {$writer->text(', ');}
			}
		$writer->endElement();
	
	///testing
	
	
    $writer->endElement();
}
$writer->endElement();
$writer->endDocument();
$writer->flush();
echo "All done ....!";
}
exit;
?>