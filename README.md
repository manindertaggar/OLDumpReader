# OLDumpReader
PHP Library that reads OpenLibrary books dump as Packets from the compressed .gz format

OpenLibrary Dumps are available at
[Download Dump link](https://openlibrary.org/developers/dumps)

# Requirements:
- Composer
- PHP
  
# How to use OLDumpReader:
  add folowining code inside your composer.json
```json  
  "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/manindersingh030/OLDumpReader.git"
        }
        ...
    ],
    "require": {
        "taggar/ol-dump-reader": "dev-master",
        ...
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
    note: includes starting_location and ending_location key which represents locations inside compressed file of starting and ending of packet respectively

##### getNextRawPacket()
    returns next packet as raw string 

##### output format as Raw Packet
each of following is seprated by a tab '\t'
````
<packet_starting_inside_compressed_file> <packet_ending_inside_compressed_file> <type> <key> <revision> <last_modified> <json>
````

##### seekToLastLocation()
    moves currunt pointer to last known packet location.
    note: this doesnot goes at the end of the file but seeks to location of last packet that was parsed.

##### seekToPosition($seekLocation);
    moves pointer to $seekLocation
