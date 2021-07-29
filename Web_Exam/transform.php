<?php
 
$xml = new DOMDocument();
$xml->load('quotes.xml');
 
$xsl = new DOMDocument;
$xsl->load('xml_to_html.xsl');
 
$proc = new XSLTProcessor();
$proc->importStyleSheet($xsl);
 
echo $proc->transformToXML($xml);
?>