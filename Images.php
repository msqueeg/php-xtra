<?php
/**
* Images is a basic image manipulation class
*/
//require_once(Helper.php);
class Images
{
	
	/********************** 
	*@filename - path to the image 
	*@tmpname - temporary path to thumbnail 
	*@xmax - max width 
	*@ymax - max height 
	*/  
	public function resizeImage($filename, $tmpname, $xmax, $ymax)  
	{  
	    $ext = explode(".", $filename);  
	    $ext = $ext[count($ext)-1];  
	  
	    if($ext == "jpg" || $ext == "jpeg")  
	        $im = imagecreatefromjpeg($tmpname);  
	    elseif($ext == "png")  
	        $im = imagecreatefrompng($tmpname);  
	    elseif($ext == "gif")  
	        $im = imagecreatefromgif($tmpname);  
	      
	    $x = imagesx($im);  
	    $y = imagesy($im);  
	      
	    if($x <= $xmax && $y <= $ymax)  
	        return $im;  
	  
	    if($x >= $y) {  
	        $newx = $xmax;  
	        $newy = $newx * $y / $x;  
	    }  
	    else {  
	        $newy = $ymax;  
	        $newx = $x / $y * $newy;  
	    }  
	      
	    $im2 = imagecreatetruecolor($newx, $newy);  
	    imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);  
	    return $im2;   
	}  

	public function getImage($url, $timeout = 0)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch CURLOPT_BINARYTRANSFER, 1);

		$image = curl_exec($ch);
		curl_close($ch);
		return $image;

	}

	/**
	 * retrieve webfont from url and store on local server.
	 *
	 * needs tested, expanded upon
	 * 
	 * @author msqueeg <msqueeg@gmail.com>
	 * @version [version]
	 * @date    2016-08-30
	 * @param   [type]     $url [description]
	 * @return  [type]          [description]
	 */
	public function getFont($url) {
		$font = file_get_contents($url);
		file_put_contents("font.ttf", $font);
	}


	public function createImage($text, $font='font.ttf')
	{
		if(!file_exists($font))
			$fontPath = getFont('http://themes.googleusercontent.com/static/fonts/anonymouspro/v3/Zhfjj_gat3waL4JSju74E-V_5zh5b-_HiooIRUBwn1A.ttf');
		else
			$fontPath = $font;
		$fontSize = 18;
		$height = 32;
		$width = 250;

		$imageHandle = imagecreate($width, $height) or die ("Cannot create image!");

		$backColor = imagecolorallocate($imageHandle, 255, 255, 255);
		$txtColor = imagecolorallocate($imageHandle, 20, 92, 137);
		$textbox = imagettfbbox($fontSize, 0, $fontPath, $text) or die ("error in imagettfbbox function");
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($imageHandle, $fontSize, 0 $x, $y, $txtColor, $fontPath, $text) or die("error in imagettftext function");
		header('Content-type: image/jpeg');
		imagejpeg($imageHandle, NULL, 100);
		imagedestroy($imageHanlde);
	}

	public function displayImg($url)
	{
		$url = str_replace("http:/", "http://", $url);

		$allowed = array('jpg', 'gif', 'png');
		$pos = strpos($url, ".");
		$str = substr($url,($pos + 1));

		$binImg = $this->getImage($url);

		$img = imagecreatefromstring($binImg);

		$width = imagesx($img);

		if(!$width) {
			$img = createImage("Image Not Found!");
		} else {
			if($str == 'jpg' || $str == 'jpeg')
				header('Content-type: image/jpeg');
			if($str == 'gif')
				header('Content-type: image/gif');
			if($str == 'png')
				header('Content-type: image/png');
			
			//set thumb width & height
			$height = imagesy($img);
			$thumbWidth = ($width <= 200? $tw : 200);
			$thumbHeight = $height * ($thumWidth / $width);
			$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);

			if($str == 'gif') {
		     	$colorTransparent = imagecolortransparent($img);
        		imagefill($thumbImg, 0, 0, $colorTransparent);
        		imagecolortransparent($thumbImg, $colorTransparent); 
			}
			if($str == 'png') {
				imagealphablending($thumbImg, false);
        		imagesavealpha($thumbImg,true);
        		$transparent = imagecolorallocatealpha($thumbImg, 255, 255, 255, 127);
        		imagefilledrectangle($thumbImg, 0, 0, $thumbWidth, $thumbHeight, $transparent); 
			}

			imagecopyresampled($thumbImg, $img, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height); 

			if($str == 'jpg' || $str == 'jpeg') {
				imagejpeg($thumbImg, NULL, 100);
			}

			if($str == 'gif') {
				imagegif($thumbImg); 
			}

			if($str == 'png') {
				imagealphablending($thumbImg,TRUE);
        		imagepng($thumbImg, NULL, 9, PNG_ALL_FILTERS); 
			}

			imagedestroy($thumbImg);

		}



	}
}