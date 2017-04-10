<?php
require __DIR__.'/../vendor/autoload.php';
use OLDumpReader\OlReader;

$dumpLocation =__DIR__.'/../../books/openlibrary/ol_dump_latest.txt.gz';
$reader = new OLReader($dumpLocation); 

		

$base = "parsedData";
createFolder($base);
while($packet = $reader->getNextPacket()){
	$type = explode("/", $packet['type']['key']);	
	$path = $base."/".$type[2];
	createFolder($path);
	
	$key = explode("/", $packet['key']);
	$path .= "/".$key[1];
	createFolder($path);

	$path .= "/".$key[2].".json";

	file_put_contents($path, json_encode($packet));
	$path = str_replace($base,'', $path);
	echo $path."\n";
	die();
}

function createFolder($path){
	if(!file_exists($path)){
		mkdir($path,777,true);
	}
}

