<?php


///
////////////////////////
//       ERROR
////////////////////////
///

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
if ((count(array_intersect(PARAMS, array_keys($_GET))) < 4)&&(!isset($_POST['giveup']))) {

    echo generate_error(1000, $_GET['format']);
    exit();
}
//display an error if the $_POST variables coming from /update are not set or they are empty
//there are 2 $_POST's sending the currency code, because $_POST['cur'] is sending it when button on the form is pressesed, the ['givecur'] when the the varibales are entered in the URL. Not convenient, but I
//lacked time to make a better way
if ((!isset($_POST['givecur'])||empty($_POST['givecur'])) && (!isset($_POST['cur'])||empty($_POST['cur']))&& (isset($_POST['giveup'])))
{
	echo generate_error(2100, $_GET['format']);
	
	exit;
}
//checks if the requested currency for upadte and the action are set
if ((isset($_POST['givecur'])&&!empty($_POST['givecur'])) || (isset($_POST['cur'])&&!empty($_POST['cur']))&& (isset($_POST['giveup'])))
{
//if they are set it checks if the cur is the base currency and the action is delete.
if (($_POST['cur']=='GBP'&& $_POST['action']=='del')||($_POST['givecur']=='GBP'&& $_POST['action']=='del'))
{
	echo generate_error(2400, $_GET['format']);
	
	exit;
}
}

# ensure no extra params
if (count($_GET) > 4) {
	echo generate_error(1100, $_GET['format']); 
	exit();
}


///
////////////////////////
//       MAKING ARRAY WITH CURRENCY NAMES
////////////////////////
///

//creating array to hold names of the currencies
$namespaste= array();
//loading xml from the link to an object
$xmliso=simplexml_load_file('http://www.currency-iso.org/dam/downloads/lists/list_one.xml') or die("Error: Cannot create object");
//object that contains all the currency names from the xml file
$codesiso = $xmliso->xpath("//CcyNtry/Ccy");
$ccodesiso = [];

foreach ($codesiso as $codeiso) {
	if (!in_array($codeiso, $ccodesiso)) {
		
		//array that contains all the currency names
		$ccodesiso[] = (string) $codeiso;
		//populating an array with tags that are currency codes, and any value that will later be overwriten
		$namespaste["$codeiso"]= "ha";
		 
		
	}
}



	foreach ($ccodesiso as $ccodeiso) {
	//$nodes is now an object containing containing all the <Ccy>s, whos value is "$ccode"("EUR"), parents(<CcyNtry>) elements (<CtryNm>, <CcyNm>...) and their values
	$nodes = $xmliso->xpath("//Ccy[.='$ccodeiso']/parent::*");
	//cname holds the currency name for the current currency code
	$cname =  $nodes[0]->CcyNm;
	//giving the array values of currency names for each tag that is that currencies code;
	$namespaste["$ccodeiso"]= "$cname";
	
	
}


///
////////////////////////
//       UPDATE
////////////////////////
///


if (file_exists('rates.xml')) {
	$xml = simplexml_load_file('rates.xml');
	//check if the currency for update is sent
if (isset($_POST['cur']))
{	//checks if the rate of the sent currency is not null
	if (!($xml->xpath("//rate[@code='". $_POST['cur'] . "']/@rate"))===null)
	{
		//gives array the value of the sent currency from the OLDER xml file
		$resp["old_rate"]= $xml->xpath("//rate[@code='". $_POST['cur'] . "']/@rate")[0]['rate'];
	}
	
}
if (isset($_POST['givecur']))
{
	if (!($xml->xpath("//rate[@code='". $_POST['givecur'] . "']/@rate"))===null)
	{
		$resp["old_rate"]= $xml->xpath("//rate[@code='". $_POST['givecur'] . "']/@rate")[0]['rate'];
	}
	
}
//takes timestamp of the older xml file
	$ts = $xml->xpath("//rates/@ts");
foreach ($ts as $tsval) {
	$xmltime=$tsval;
}
//checks if the difference between the olders xml timestamp and current time is 2 hours
if (((time()-$xmltime)>7200)||(isset($_POST['action'])))
{
	//if it is variable update is given value 1 to later signal if the rates.xml needs updating
	$update=1;
}

else
{
	
	$update=0;
}
}





///
////////////////////////
//       Makes a copy of rates.xml if such file already exsists. If there is no rates.xml it creates live array with specific codes that are set to be live
////////////////////////
///

	
if (file_exists('rates.xml')) {
	//create a variable that will signal if the rates live attribute needs to be set to 0
	$delete=0;
	#copies the contents from rates.xml to new rates file "rates(time).xml
	if($update==1){
    copy('rates.xml', 'rates'.'_'.time().'.xml');
   
	#value of the current element of object"$xml" is assigned to $r
    foreach($xml->rate as $r) {
	#r is an array that contains whats inside <rate>. It's: code,rate,live..
		
		if(isset($_POST['action']))
		{
			//checks if the update action is delete and that the currency that was requested an update is the current currency in the loop
			if(($_POST['action']=='del')&&($_POST['cur']==$r['code'] ||$_POST['givecur']==$r['code']))
			{
				// this delete will signalise that the current currency in the loop will need to be deleted. It's live set to 0
				$delete=1;
				
			}
			else
			{
				$delete=0;
			}
		//	if the update action is not delete, it then checks if the current currency in the loop has live set to 1 in the rates.xml file
        if (((string) $r['live'] == '1')&& ($delete==0))
		{
			//if it does array live will be added the name of the currency code and will later give the attribute live in the rates.xml file value 1 
            $live[] = (string) $r['code'];
		}
		}
		//if there is no update action it just does the same thing as above
		elseif ((string) $r['live'] == '1')
		{
			$live[] = (string) $r['code'];
		}
			
	}
	}
	}
//if rates.xml file doesnt exist live array is created to set the 24 currencies live
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

///
////////////////////////
//       Makes a new rates.xml file
////////////////////////
///


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

//takes the time from the fixer api
$timenow = $rates->timestamp;

//
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


	//create an object that holds all the elements in the iso file of the current currency in the loop
	$nodes = $xmliso->xpath("//Ccy[.='$code']/parent::*");
	
	
	//checks if array thats holding the names of the currencies has the the current code in the loop as a key,tag.
	if (array_key_exists($code, $namespaste)) {
	//if it does then it picks the element in the array with that tag and writes its value to the element 'currency'
	$writer->writeAttribute('currency', "$namespaste[$code]");
	
    }
	//if the current currency code doesn't have the name of the currency in the array...
	if (!array_key_exists($code, $namespaste)) {
	//writes that the currency name is not set
	$writer->writeAttribute('currency', "not_set");
    }
	
	
	
	//if current code is GPB set the attribute value to 1 because it is the base value
    if ($code=='GBP') {
        $writer->writeAttribute('rate', '1.00');
    }
    else {
        $writer->writeAttribute('rate', $rate * $gbp_rate);
    }
    #in array checks if the value of $code (USD) exists in array $live 
    
	
	
	if(isset($_POST['action']))
	{	// checks if the update action is put and that the one of the $_POST holds a currency code
		if ((($code==$_POST['cur']||$code==$_POST['givecur']))&&($_POST['action']=='put')) ////1
	{
			$writer->writeAttribute('live', '1');	
	}
	elseif (in_array($code, $live))
	{
		$writer->writeAttribute('live', '1');
	}
	else
	{
		$writer->writeAttribute('live', '0');
	}
		
    }
	elseif (in_array($code, $live)) 
		{
			$writer->writeAttribute('live', '1');
		}
    else
	{
		
        $writer->writeAttribute('live', '0');
    }
	
	
	$writer->startElement("cntry");
			//value which signalises when to stop adding "," to the element
			$last = count($nodes) - 1;
			
			# group countries together using the same code
			# & lowercase first letter in name
			foreach ($nodes as $index=>$node) {
				//takes the countries name of the current currency code in the loop from the object created earlier and converts it into writable format
				$writer->text(mb_convert_case($node->CtryNm, MB_CASE_TITLE, "UTF-8"));
				if ($index!=$last) {$writer->text(', ');}
			}
		$writer->endElement();
	
	
	
	
    $writer->endElement();
}
$writer->endElement();
$writer->endDocument();
$writer->flush();

}



///
////////////////////////
//       ERROR
////////////////////////
///


if((!isset($_POST['cur'])||(!isset($_POST['givecur'])))){
# validate parameter values
# load the rates file as a simple xml object
$xml=simplexml_load_file('rates.xml');
# xpath the codes of the rates which are live
$rates = $xml->xpath("//rate[@live='1']/@code");
# create a php array of these codes
foreach ($rates as $key=>$val) {$codes[] =(string) $val;}
# $to and $from are not recognized currencies
//checks if the values are in array that holds all the currency codes of rates.xml
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
}
//other checks are done if there is update request
else
{
$xml=simplexml_load_file('rates.xml');
# xpath the codes of the rates which are live
$rates = $xml->xpath("//rate/@code");
foreach ($rates as $key=>$val) {$codes[] =(string) $val;}
//checks if the values sent for update are in the array that holds all the currency codes from rates.xml
if ((!in_array($_POST['cur'], $codes))&&(!in_array($_POST['givecur'], $codes))) {
echo generate_error(2200, $_GET['format']);

exit;
}

if (isset($_POST['cur'])&&!empty($_POST['cur'])||isset($_POST['givecur'])&&!empty($_POST['givecur']))
{
	//checks if the $_POST['action'] is a valid. 
if ($_POST['action']!='post'&&$_POST['action']!='put'&&$_POST['action']!='del') {
echo generate_error(2000, $_GET['format']);

exit;
}

}

}



$xml=simplexml_load_file('rates.xml');


///
////////////////////////
//       Making array that contains all info about the rates for output to website and outputs it with a function
////////////////////////
///





	
$tsnew = $xml->xpath("//rates/@ts")[0]['ts'];
//sets the tsnew to be an integer so it can be used in function date();
settype($tsnew, "integer");
					//date takes the timestamp number and converts it into a date with day, month, year....
$resp['date_time']= date('d M Y H:i', $tsnew);


//checks if the update is done with the form
if ((!empty($_POST['cur']))&&(isset($_POST['cur'])))
{
//setting a varriable to be equal to the code that has been sent to update	
$fromcode= $_POST['cur'];
$fromrate= $xml->xpath("//rate[@code='$fromcode']/@rate")[0]['rate'];
//populating array $resp with the values from xml file of the currency that was sent to update.

$resp['rate'] = $rate;
$resp['from_code']= $fromcode;
$resp['new_rate']= $xml->xpath("//rate[@code='$fromcode']/@rate")[0]['rate'];
$resp['from_curr']= $xml->xpath("//rate[@code='$fromcode']/@currency")[0]['currency'];
$resp['from_loc']= (string) $xml->xpath("//cntry[../@code='$fromcode']")[0];
}
//checks if the update is done with the URL
if ((!empty($_POST['givecur']))&&(isset($_POST['givecur'])))
{
	
$fromcode= $_POST['givecur'];

$fromrate= $xml->xpath("//rate[@code='$fromcode']/@rate")[0]['rate'];

$resp['rate'] = $rate;

$resp['from_code']= $fromcode;
$resp['new_rate']= $xml->xpath("//rate[@code='$fromcode']/@rate")[0]['rate'];
$resp['from_curr']= $xml->xpath("//rate[@code='$fromcode']/@currency")[0]['currency'];
$resp['from_loc']= (string) $xml->xpath("//cntry[../@code='$fromcode']")[0];
}

//if update was not requested
if ((!isset($_POST['cur']))&&(!isset($_POST['givecur'])))
{
	

$fromcode= $_GET['from'];
$tocode= $_GET['to'];

$fromrate= $xml->xpath("//rate[@code='$fromcode']/@rate")[0]['rate'];
$torate= $xml->xpath("//rate[@code='$tocode']/@rate")[0]['rate'];

$rate= $torate / $fromrate;
$resp['rate'] = $rate;
$conversion= $rate*$_GET["amnt"];

$resp['from_code']= $_GET['from'];
$resp['from_amnt']= $_GET['amnt'];
$resp['from_curr']= $xml->xpath("//rate[@code='$fromcode']/@currency")[0]['currency'];
$resp['from_loc']= (string) $xml->xpath("//cntry[../@code='$fromcode']")[0];

$resp['to_code']= $_GET['to'];
$resp['to_amnt']= $conversion;
$resp['to_curr']= $xml->xpath("//rate[@code='$tocode']/@currency")[0]['currency'];
$resp['to_loc']= (string) $xml->xpath("//cntry[../@code='$tocode']")[0];
}

///
////////////////////////
//       Making array that contains all info about the rates for output to website and outputs it with a function
////////////////////////
///




//checks if there is an update action and depending on what action it is the $response variable is set a different function
if (isset($_POST['action']))
{
	
	if($_POST['action']=='post')
	{
		$response = response_xml_post($resp);
	}
	if($_POST['action']=='put')
	{
		$response = response_xml_put($resp);
	}
	if($_POST['action']=='del')
	{
		$response = response_xml_del($resp);
	}
}
//if there is no update action... 
else
{
	$response = response_xml($resp);
}

if ($_GET['format']=='xml') {
	//sets the header of th page to be compatible to display the xml tree 
	header('Content-Type: text/xml');
	$dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
	//outputs the $response which is holding aa specific xml output
	
    $dom->loadXML ('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $response);
    $dom->formatOutput = true;
	echo (string) $dom->saveXML();
}
else {
	//outputs the $response which is holding a specific json output
	$json = simplexml_load_string('<conv>'.$response.'</conv>');
	//sets the header of the page to be compatible to display the json tree 
	header('Content-Type: application/json');
	echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

exit;






///
////////////////////////
//       FUNCTIONS
////////////////////////
///


///Response function
function response_xml (&$resp) {
	//searches for spaces and replaces them
	$resp['from_loc'] = trim(preg_replace('/\s+/', ' ', $resp['from_loc'])); 
	$resp['to_loc'] = trim(preg_replace('/\s+/', ' ', $resp['to_loc'])); 
	
	$resp_xml = <<<__xml
     <conv>
       <at>{$resp['date_time']}</at>
       <rate>{$resp['rate']}</rate>
       <from>
          <code>{$resp['from_code']}</code>
          <curr>{$resp['from_curr']}</curr>
          <loc>{$resp['from_loc']}</loc>
          <amnt>{$resp['from_amnt']}</amnt>
       </from>
       <to>
          <code>{$resp['to_code']}</code>
          <curr>{$resp['to_curr']}</curr>
          <loc>{$resp['to_loc']}</loc>
          <amnt>{$resp['to_amnt']}</amnt>
       </to>
     </conv>
__xml;
return $resp_xml;
}


function response_xml_post (&$resp) {
	
	$resp['from_loc'] = trim(preg_replace('/\s+/', ' ', $resp['from_loc'])); 
	
	$resp_xml = <<<__xml
     <action type='post'>
       <at>{$resp['date_time']}</at>
       <rate>{$resp['new_rate']}</rate>
       <curr>
          <code>{$resp['from_code']}</code>
          <name>{$resp['from_curr']}</name>
          <loc>{$resp['from_loc']}</loc>
       </curr>
     </action>
__xml;
return $resp_xml;
}
function response_xml_put (&$resp) {
	
	$resp['from_loc'] = trim(preg_replace('/\s+/', ' ', $resp['from_loc'])); 
	
	$resp_xml = <<<__xml
      <action type='put'>
       <at>{$resp['date_time']}</at>
       <rate>{$resp['new_rate']}</rate>
       <curr>
          <code>{$resp['from_code']}</code>
          <name>{$resp['from_curr']}</name>
          <loc>{$resp['from_loc']}</loc>
       </curr>
     </action>
__xml;
return $resp_xml;
}

function response_xml_del (&$resp) {
	
	
	$resp_xml = <<<__xml
     <action type='del'>
       <at>{$resp['date_time']}</at>
       <code>{$resp['from_code']}</code>
    
     </action>
__xml;
return $resp_xml;
}

# function to return xml or json errors
function generate_error($eno, $format='xml') {
	$msg = ERROR_HASH["$eno"];
	
	if ($format=='json') {
									//code element gets value of $eno, msg element gets value of $msg
		$json = array('conv' => array("code" => "$eno", "msg" => "$msg"));
		
		$out = header('Content-Type: application/json');
		//encodes the object to a jason formated output
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



?>