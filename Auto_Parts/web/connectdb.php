<?php

$xml=simplexml_load_file("config.xml") or die("Error: Cannot create object");

$connect= mysqli_connect($xml->data->host,$xml->data->username,$xml->data->password,$xml->data->databasename);

if (!$connect)
{
	die("Unable to connect to the database". mysqli_connect_error());
}