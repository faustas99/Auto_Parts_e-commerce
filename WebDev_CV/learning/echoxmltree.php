<?php
echo generate_error();
function generate_error() {
$xml =  '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<conv><error>';
$xml .= '<code>sas</code>';
$xml .= '<msg>czxc</msg>';
$xml .= '</error></conv>';
	
$out = header('Content-type: text/xml');
$out .= $xml;
	
return $out;

}
?>