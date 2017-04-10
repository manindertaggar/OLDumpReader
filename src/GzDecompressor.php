<?php
namespace OLDumpReader;
class GzDecompressor {

	private $dumpFile;
	private $initialPosition = 0 ;
	private $handle = null;
	private	$totalCharacterCount;
	const LAST_SEEK_LOCATION_FILE = 'lastSeekLocation.dat';

	public function __construct( $dumpFilePath, $initialPosition = 0 ) {
		$this->dumpFile = $dumpFilePath;
		$this->initialPosition = $initialPosition;
	}

	public function __destruct() {
		$this->closeReader();
	}

	private function closeReader() {
		if ( is_resource( $this->handle ) ) {
			gzclose( $this->handle );
			$this->handle = null;
		}
	}

	private function initReader() {
		if ( $this->handle === null ) {
			$this->handle = @gzopen( $this->dumpFile, 'r' );

			if ( $this->handle === false ) {
				die( 'Could not open file: ' . $this->dumpFile );
			}

			$this->seekToPosition( $this->initialPosition );
		}
	}


	public function getNextPacket() {
		$this->initReader();

		if (gzeof( $this->handle )) {
			return false;
		}

		$startingLocation =  $this->getPosition();
		$line = "";

		while(true){
			$c = @gzgetc( $this->handle);
			$line .=$c;
			if($c === PHP_EOL)
				break;
		};
$line = str_replace("//",'/', $line);
		$line = str_replace("\\r\\n",'', $line);

		$endingLocation =  $this->getPosition();

		$line = "$endingLocation\t".$line;
		$line = "$startingLocation\t".$line;

		file_put_contents(__DIR__."/".self::LAST_SEEK_LOCATION_FILE, $endingLocation);

		return $line;
	}

	public function getPosition() {
		if ( PHP_INT_SIZE < 8 ) {
			die( 'Cannot reliably get the file position on 32bit PHP' );
		}

		$this->initReader();
		$position = @gztell( $this->handle );

		if ( !is_int( $position ) ) {
			die( 'Could not tell the position of the file handle' );
		}

		return $position;
	}

	public function seekToPosition( $position ) {
		$this->initReader();
		$seekResult = @gzseek( $this->handle, $position );

		if ( $seekResult !== 0 ) {
			die( 'Seeking to position failed' );
		}
	}



}
