<?php

class Cache_File {
  protected $filename;
  protected $temp_filename;
  protected $expiration;
  protected $fp;
  protected $expirationed = false;    //   просрочен ли кэш-файл


  public function __construct($filename, $expiration=false) {
    $this->filename = $filename;
    $this->expiration = $expiration;
	$this->temp_filename = $this->filename .'.' .getmypid();
	
		if($this->expiration) {
		 		$stat = @stat($this->filename);
			 
				if($stat[9]) {
						$modified = $stat[9];
						if(time() > $modified + $this->expiration)  {
							$this->expirationed = true;
							
						}
				}
		}	
  }
  
////////////////////////////////////////////////////////////
	

  public function get() {
		if($this->expirationed)  { 
				unlink($this->filename);
				return false;
		}
    return @file_get_contents($this->filename);
  }


 
	public function begin_cache() {
		if(($this->fp = fopen($this->temp_filename, "w"))== false)  {
		return false;	
		}
		ob_start();
	}


	public function end_cache() {
	$buffer = ob_get_contents();
	ob_end_flush(); 
	
		if(strlen($buffer))	{
			fwrite($this->fp, $buffer);
			fclose($this->fp);
			rename($this->temp_filename, $this->filename);
			@unlink($this->temp_filename);
			return true;
		}
		else	{
			fclose($this->fp);
			unlink($this->temp_filename);
			return false;
		}
	}



}
?>

