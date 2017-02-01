<?php
ob_start();
include_once('config.inc.php');
class uploadFile {

	private $max_upload_size;
	private $filesize; 
	private $filename; 
	private $filetype;
	private $tmp;
	private $dir;
	private $validformat;
	private $ext;

	public function __construct($filesize, $filename, $filetype, $dir, $tmp, $max_upload_size, $validformat){
		$this->filesize = $filesize;
		$this->filename = $filename;
		$this->filetype = $filetype;
		$this->dir = $dir;
		$this->tmp = $tmp;
		$this->max_upload_size = $max_upload_size;
		$this->validformat = $validformat;
		
		

	}

	private function maxFileSize(){
		if ($this->filesize > $this->max_upload_size)
		{
			return false;
		}
		return true;
	}

	
	private function fileExtension(){
		$this->ext = end(explode(".", $this->filename));
		return $this->ext;
	}

	private function validFileType(){
		if(in_array($this->fileExtension(), $this->validformat))
		{
			return true;
		}
		return false;
	}

	private function dirExist(){
		if (is_dir($this->dir))
		{
			return true;
		}
		return false;
	}



	public function confirmUpload() {
		if (!$this->validFileType())
		{
			$i = 0;
			echo "Invalide File Format. Only: ";
			for($i=0;$i<count($this->validformat);$i++)
			{
				echo $this->validformat[$i].", ";
			}
			echo " allowed.";
			return false;
		}else{
			if (!$this->maxFileSize())
			{
				echo "Files must be under ".($this->max_upload_size/1000)." KB in size.";		
				return false;
			}else{
				if (!$this->dirExist())
				{
					echo "Directory \"".$this->dir."\" doesn't exist.";
					return false;
				}
			}
		}
	
		move_uploaded_file($this->tmp,$this->dir.$this->filename);
		echo "<i>".$this->filename."</i><b> successfully</b> uploaded to<i> ".$this->dir."</i>";
		return true;

	}

}

class uploadImage {

	private $max_upload_size;
	private $filesize; 
	private $filename; 
	private $filetype;
	private $tmp;
	private $dir;
	private $validformat;
	private $ext;


	public function __construct($filesize, $filename, $filetype, $dir, $tmp, $max_upload_size, $validformat){
		$this->filesize = $filesize;
		$this->filename = $filename;
		$this->filetype = $filetype;
		$this->dir = $dir;
		$this->tmp = $tmp;
		$this->max_upload_size = $max_upload_size;
		$this->validformat = $validformat;
		
		

	}

	private function maxFileSize(){
		if ($this->filesize > $this->max_upload_size)
		{
			return false;
		}
		return true;
	}

	
	private function fileExtension(){
		$this->ext = end(explode(".", $this->filename));
		return $this->ext;
	}

	private function validFileExtension(){
		if(in_array($this->fileExtension(), $this->validformat))
		{
			return true;
		}
		return false;
	}

	private function validateImage(){
		if (@imagecreatefromjpeg($this->tmp) || @imagecreatefrompng($this->tmp) || @imagecreatefromgif($this->tmp))
		{
			return true;
		}
		return false;
	}

	private function dirExist(){
		if (is_dir($this->dir))
		{
			return true;
		}
		return false;
	}



	public function confirmUpload() {
		if (!$this->validFileExtension())
		{
			$i = 0;
			echo "Invalide File Format. Only: ";
			for($i=0;$i<count($this->validformat);$i++)
			{
				echo $this->validformat[$i].", ";
			}
			echo " allowed.";
			return false;
		}else{
			if (!$this->maxFileSize())
			{
				echo "Files must be under ".($this->max_upload_size/1000)." KB in size.";		
				return false;
			}else{
				if (!$this->dirExist())
				{
					echo "Directory \"".$this->dir."\" doesn't exist.";
					return false;
				}else{
					if (!$this->validateImage())
					{
						echo "Corrupt Image. Please select another image.";
						return false;
					}

				}
			}
		}
	
		move_uploaded_file($this->tmp,$this->dir.$this->filename);
		echo "<i>".$this->filename."</i><b> successfully</b> uploaded to<i> ".$this->dir."</i>";
		return true;

	}
}


class createDir {

	private $dir;
	private $perm;

	public function __construct($dir, $perm){
		$this->dir = $dir;
		$this->perm = $perm;
	}

	public function confirmDir(){
		if(mkdir($this->dir, $this->perm))
		{
			return true;
		}else{
			return false;
		}
	}
}


?>