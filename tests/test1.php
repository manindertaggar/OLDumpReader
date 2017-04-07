<?php
require __DIR__.'/../vendor/autoload.php';
use OLDumpReader\OlReader;

$dumpLocation =__DIR__.'/../../books/openlibrary/ol_dump_latest.txt.gz';
$reader = new OLReader($dumpLocation); 

$reader->seekToLastLocation();
var_dump($reader->getNextPacket());