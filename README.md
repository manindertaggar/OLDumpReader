# OLDumpReader
PHP Library that reads OpenLibrary books dump as Packets from the compressed .gz format

OpenLibrary Dumps are available at
[Download Dump link](https://openlibrary.org/developers/dumps)

# Requirements:
-Composer<br>
-PHP
  
# How to use OLDumpReader:
  add folowining code inside your composer.json
```json  
  "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/manindersingh030/OLDumpReader.git"
        }
    ],
    "require": {
        ...
        "taggar/ol-dump-reader": "dev-master"
    }
````
and run $composer update

#inside php file
```php
<?php
require __DIR__.'/../vendor/autoload.php';
use OLDumpReader\OlReader;

$dumpLocation ='<dump_full_path>';
$reader = new OLReader($dumpLocation); 
$reader->seekToLastLocation();
var_dump($reader->getNextPacket());
```

# Documentation
## Available Methods
##### getNextPacket()
    returns next packet as array 
##### getNextRawPacket()
    returns next packet as raw string 
##### seekToLastLocation()
    moves currunt pointer to last known packet location.
    note: this doesnot goes at the end of the file but gives location of last packet that was parsed.
##### seekToPosition($seekLocation);
    moves pointer to $seekLocation
##### Our output format as Raw Packet
<packet_starting_inside_compressed_file> <packet_ending_inside_compressed_file> <type> <key> <revision> <last_modified> <json>