<?php
namespace OLDumpReader;

use OLDumpReader\PacketFormatter;
use OLDumpReader\GzDecompressor;

class OLReader{
	const LAST_SEEK_LOCATION_FILE = 'lastSeekLocation.dat';

	private	$dumpLocation;
	private $gzDecompressor;

	public function __construct($dumpLocation){
		$this->dumpLocation = $dumpLocation;
		$this->gzDecompressor = new gzDecompressor($dumpLocation);
	}

	public function seekToLastLocation(){
		$lastSeekLocation = $this->getLastSeekLocation();
		$this->seekToPosition($lastSeekLocation);
	}

	private function getLastSeekLocation(){
		if(!file_exists(self::LAST_SEEK_LOCATION_FILE))
			return 0;
		$lastSeekLocation = file_get_contents(__DIR__."/".self::LAST_SEEK_LOCATION_FILE);
		return $lastSeekLocation;
	}

	public function seekToPosition($seekLocation){
		$this->gzDecompressor->seekToPosition($seekLocation);
	}

	public function getNextPacket(){
		$rawPacket = $this->getNextPacket();
		return PacketFormatter::format($rawPacket);
	}

	public function getNextRawPacket(){
		$rawPacket = $this->gzDecompressor->getNextPacket();		
		return $rawPacket;
	}
}
