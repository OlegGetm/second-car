<?php

class  	Add_Image
{

private 	$error = '0';																						
public 	$error_message =array();																	

private 	$temp_file;									// временный файл, создав. при загрузке			
private 	$original_type;																						
public 	$original_extension;  																				
private 	$allowed_extensions = array( 'gif', 'jpeg', 'jpg', 'png', 'swf', 'psd');  	
private 	$image_extensions 	  = array( 'gif', 'jpeg', 'jpg', 'png');  					
private 	$original_size = array(0, 0);	
public 	$original_W;																						
public 	$original_H;																						

private 	$new_W;
private 	$new_H;

public 	$new_file_name;							// имя созданного  файла
public  	$upload_directory 		= '../../_photos/letters2';
public 	$quality 						= '90';
public 	$convert_all_to_jpg 	= 'yes';    	//  или = 'no'  чтобы сохранить в родном формате
public 	$add_sharpen 			= 'no';   	//  или = 'yes'  чтобы добавить фильтр резкости 
public 	$crop_by_height 			= 'no';   	//  или = 'yes'  чтобы миниатрюры одной высоты
//public  $max_original_size;
public  	$max_W 						= '580';
public  	$max_H 						= '500';



////////////////////////////////////////////////////////////////////////
	public function __construct($file_up)      {     
	
		$this->temp_file	=  $file_up['tmp_name'];

		$this->original_type 	=  $file_up['type'];
		$this->get_extension($this->original_type);
		
		if(file_exists($this->temp_file))		{
		$this->original_size	 	=   getimagesize($this->temp_file);
		}	
		$this->original_W		=  $this->original_size[0];
		$this->original_H	 		=  $this->original_size[1];
	}
/////////////////////////////////////////////////////////////////////////

		
	private function get_extension($type)	{
	
			switch($type) 	{
			case 'image/gif':
			$this->original_extension ="gif";
			break;
						case 'image/jpeg':
						case 'image/pjpeg':
						$this->original_extension ='jpg';
						break;
			case 'image/png':
			$this->original_extension ='png';
			break;
						case 'application/x-shockwave-flash':
						$this->original_extension ='swf';
						break;
			case 'image/psd':
			$this->original_extension ='psd';
			break;
						case 'image/bmp':
						$this->original_extension ='bmp';
						break;
	}	}

///..................................................................................................................

	public function validate_type()		{
		
		if (in_array($this->original_extension, $this->allowed_extensions)) 	{
			return true;
		}	else	{
			$this->error = '1';
			$this->error_message[ ] = 'Неверный тип файла';
			return false;
		}
	}
	
///..................................................................................................................

	public function validate_image_type()		{
		
		if (in_array($this->original_extension, $this->image_extensions) && $this->original_W > 0 && $this->original_H > 0 ) 	{
				return true;
		}	else	  {
				$this->error = '1';
				$this->error_message[ ] = 'Неверный тип файла. Допустимы расширения .jpg, .png, .gif .';
				return false;
		}
	}
	
///..................................................................................................................	
	
	public function get_original_size()	{
	
			return	$this->original_size;
	}

		
///.................................................................................................................

	public function set_random_name($name_length=12) {
		
		$letters  = 'abcdefghijklmnopqrstuvwxyz';
		$allchar = 'abcdefghijklmnopqrstuvwxyz123456789';
		mt_srand (( double) microtime() * 1000000 );
		
		$str = substr( $letters, mt_rand (0,26), 1);
		
		for ( $i = 0; $i<$name_length-1 ; $i++ )
		$str .= substr( $allchar, mt_rand (0,34), 1);
		
				if($this->convert_all_to_jpg == 'yes')	{
				$str .= '.jpg';										
				}	else	 {
				$str .= '.' .$this->original_extension;		
				}

		$this->new_file_name = $str;
	}

///.................................................................................................................	


public function create_dir($subdir) 	{
		
		if (!is_dir($subdir))  {
				mkdir($subdir, 0777);
				umask(0);
				chmod($subdir, 0777);
		} 
	$this->upload_directory = $subdir;
	return true;  		
	}

///.................................................................................................................
public function get_newFileName()			{
		return $this->new_file_name;
	}

///.................................................................................................................


public function get_newFileSize()			{
		
		$ar_image_size = array($this->new_W, $this->new_H);  
		return $ar_image_size;
	}

///.................................................................................................................


public function save_image() 			{

		// определить new_W, new_heigh 
		
		$ratio_H = $this->original_H;
		$ratio_W = $this->original_W;
	
		if ($this->original_W < $this->max_W && $this->original_H < $this->max_H )
		{						// не уменьшать, если размеры картинки меньше допустимых
		
			$this->new_W = $this->original_W;
			$this->new_H 	= $this->original_H;
			
		} 	else		{		// уменьшать
				
			if($this->crop_by_height == 'yes')							{  // если  CROP до фикс высоты
					$this->new_W = $this->max_W;
					$this->new_H 	= $this->max_H;
					$ratio_H = ceil ($this->max_W / $this->original_W * $this->original_H);
			}
			else if( $this->original_W > $this->original_H)		{  // если больше в ширину
					$this->new_W = $this->max_W;
					$this->new_H 	= ceil ($this->max_W / $this->original_W * $this->original_H);
			}	else 																		{   // если больше в высоту
					$this->new_H 	= $this->max_H;
					$this->new_W = ceil ($this->max_H / $this->original_H * $this->original_W);	
		}	}			
		

		$new_image  = imagecreatetruecolor($this->new_W, $this->new_H);

			if($this->original_extension == "jpg") {
			$tmpFile = imagecreatefromjpeg($this->temp_file);
			
			} else if($this->original_extension == "gif") {
			$tmpFile = imagecreatefromgif ($this->temp_file);
			
			} else if($this->original_extension == "png") {
			$tmpFile = imagecreatefrompng ($this->temp_file);
			}
	

		imagecopyresampled($new_image, $tmpFile, 0, 0, 0, 0, 
											$this->new_W, $this->new_H, 
											$this->original_W, $this->original_H );
	

		
						//////////////////     если  добавить резкость
						if($this->add_sharpen 	== 'yes')	{
						$this->unsharpMask($new_image, 70, 1.3, 1);
						}
						/////////////////////////////////////////////////////////////////////////


		$target_file = $this->upload_directory .'/' .$this->new_file_name;
		
		if($this->original_extension == "jpg" || $this->convert_all_to_jpg == 'yes') 		{
		imagejpeg($new_image, $target_file, $this->quality);
		
		} else if($this->original_extension == "gif") 	{
		imagegif ($new_image, $target_file );
		
		} else if($this->original_extension == "png") 	{
		imagepng ($new_image, $target_file, 0);
		}
		
		chmod($target_file, 0644);
		
		
		imagedestroy($tmpFile);
		@imagedestroy($this->temp_file); 
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

private function unsharpMask($img, $amount, $radius, $threshold)    { 

       ////////////////////////////////////////////////////////////////////////////////////////////////  
       ////                  Unsharp Mask for PHP - version 2.1.1  
       ////    Unsharp mask algorithm by Torstein Hїnsi 2003-07.  
       ////             thoensi_at_netcom_dot_no.  
       ///////////////////////////////////////////////////////////////////////////////////////////////  
       // $img is an image that is already created within php using 
       // imgcreatetruecolor. No url! $img must be a truecolor image. 
   
       // Attempt to calibrate the parameters to Photoshop: 
       if ($amount > 500)    $amount = 500; 
       $amount = $amount * 0.016; 
       if ($radius > 50)    $radius = 50; 
       $radius = $radius * 2; 
       if ($threshold > 255)    $threshold = 255; 
        
       $radius = abs(round($radius));     // Only integers make sense. 
       if ($radius == 0) { 
           return $img; imagedestroy($img); break;        } 
       $w = imagesx($img); $h = imagesy($img); 
       $imgCanvas = imagecreatetruecolor($w, $h); 
       $imgBlur = imagecreatetruecolor($w, $h); 
   
       // Gaussian blur matrix: 
       //                         
       //    1    2    1         
       //    2    4    2         
       //    1    2    1         
       //                         
       ////////////////////////////////////////////////// 
   
       if (function_exists('imageconvolution')) { // PHP >= 5.1  
               $matrix = array(  
               array( 1, 2, 1 ),  
               array( 2, 4, 2 ),  
               array( 1, 2, 1 )  
           );  
           imagecopy ($imgBlur, $img, 0, 0, 0, 0, $w, $h); 
           imageconvolution($imgBlur, $matrix, 16, 0);  
       }  
       else {  
   
       // Move copies of the image around one pixel at the time and merge them with weight 
       // according to the matrix. The same matrix is simply repeated for higher radii. 
           for ($i = 0; $i < $radius; $i++)    { 
               imagecopy ($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h); // left 
               imagecopymerge ($imgBlur, $img, 1, 0, 0, 0, $w, $h, 50); // right 
               imagecopymerge ($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50); // center 
               imagecopy ($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h); 
   
               imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 33.33333 ); // up 
               imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 25); // down 
           } 
       } 
       
       if($threshold>0){ 
           // Calculate the difference between the blurred pixels and the original 
           // and set the pixels 
           for ($x = 0; $x < $w-1; $x++)    { // each row
               for ($y = 0; $y < $h; $y++)    { // each pixel 
                        
                   $rgbOrig = ImageColorAt($img, $x, $y); 
                   $rOrig = (($rgbOrig >> 16) & 0xFF); 
                   $gOrig = (($rgbOrig >> 8) & 0xFF); 
                   $bOrig = ($rgbOrig & 0xFF); 
                    
                   $rgbBlur = ImageColorAt($imgBlur, $x, $y); 
                    
                   $rBlur = (($rgbBlur >> 16) & 0xFF); 
                   $gBlur = (($rgbBlur >> 8) & 0xFF); 
                   $bBlur = ($rgbBlur & 0xFF); 
                    
                   // When the masked pixels differ less from the original 
                   // than the threshold specifies, they are set to their original value. 
                   $rNew = (abs($rOrig - $rBlur) >= $threshold)  
                       ? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))  
                       : $rOrig; 
                   $gNew = (abs($gOrig - $gBlur) >= $threshold)  
                       ? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))  
                       : $gOrig; 
                   $bNew = (abs($bOrig - $bBlur) >= $threshold)  
                       ? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))  
                       : $bOrig; 
                    
                   if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) { 
                           $pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew); 
                           ImageSetPixel($img, $x, $y, $pixCol); 
                       } 
               } 
           } 
       } 
       else{ 
           for ($x = 0; $x < $w; $x++)    { // each row 
               for ($y = 0; $y < $h; $y++)    { // each pixel 
                   $rgbOrig = ImageColorAt($img, $x, $y); 
                   $rOrig = (($rgbOrig >> 16) & 0xFF); 
                   $gOrig = (($rgbOrig >> 8) & 0xFF); 
                   $bOrig = ($rgbOrig & 0xFF); 
                    
                   $rgbBlur = ImageColorAt($imgBlur, $x, $y); 
                    
                   $rBlur = (($rgbBlur >> 16) & 0xFF); 
                   $gBlur = (($rgbBlur >> 8) & 0xFF); 
                   $bBlur = ($rgbBlur & 0xFF); 
                    
                   $rNew = ($amount * ($rOrig - $rBlur)) + $rOrig; 
                       if($rNew>255){$rNew=255;} 
                       elseif($rNew<0){$rNew=0;} 
                   $gNew = ($amount * ($gOrig - $gBlur)) + $gOrig; 
                       if($gNew>255){$gNew=255;} 
                       elseif($gNew<0){$gNew=0;} 
                   $bNew = ($amount * ($bOrig - $bBlur)) + $bOrig; 
                       if($bNew>255){$bNew=255;} 
                       elseif($bNew<0){$bNew=0;} 
                   $rgbNew = ($rNew << 16) + ($gNew <<8) + $bNew; 
                       ImageSetPixel($img, $x, $y, $rgbNew); 
               } 
           } 
       } 
       imagedestroy($imgCanvas); 
       imagedestroy($imgBlur); 
        
       return $img; 
   } 
 


///.................................................................................................................
}
?>