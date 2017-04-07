<?php
namespace OLDumpReader;

class PacketFormatter{
	
	public static function format($raw){
		$data = explode("\t",$raw);		
		$packet = json_decode($data[6], true);
		$packet["starting_location"] = $data[0];
		$packet["ending_location"] = $data[1];
		return $packet;
	}
}