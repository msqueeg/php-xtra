<?php
/**
 *
 * useful utilities
 * @author Michael Miller <msqueeg@gmail.com>
 * @package Helper.php
 * @since 2016-08-29
 */



	/**
	 * returns a string for the integer values returned by PHP's error_reporting();
	 * use it like 'echo Helper->errorLevelToString(error_reporting(),','); '
	 * @author msqueeg <msqueeg@gmail.com>
	 * @version [version]
	 * @since    2016-08-29
	 * @param   int     $intval    integer value returned by error_reporting()
	 * @param   string     $sep    separater value, default is ',' (comma)
	 * @return  string             string representing error level
	 */
	function errorLevelToString($intval,$sep = ',')
	{
		$errorLevels = array(
			E_ALL => 'E_ALL',
			E_USER_DEPRECATED => 'E_USER_DEPRECATED',
			E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
			E_STRICT => 'E_STRICT',
			E_USER_NOTICE => 'E_USER_NOTICE',
			E_USER_WARNING => 'E_USER_WARNING',
			E_USER_ERROR => 'E_USER_ERROR',
			E_COMPILE_WARNING => 'E_COMPILE_WARNING',
			E_COMPILE_ERROR => 'E_COMPILE_ERROR',
			E_CORE_WARNING => 'E_CORE_WARNING',
			E_CORE_ERROR => 'E_CORE_ERROR',
			E_NOTICE => 'E_NOTICE',
			E_PARSE => 'E_PARSE',
			E_WARNING => 'E_WARNING',
			E_ERROR => 'E_ERROR' 
			);
		
		$result = '';

		foreach($errorlevels as $number => $name) {
			if (($intval & $number) == $number) {
				$result .=($result != '' ? $separator : '') . $name;
			}
		}
		
		return $result;

	}

	/************** 
	*@length - length of random string (must be a multiple of 2) 
	**************/  
	function readableRandomString($length = 6){  
	    $conso=array("b","c","d","f","g","h","j","k","l",  
	    "m","n","p","r","s","t","v","w","x","y","z");  
	    $vocal=array("a","e","i","o","u");  
	    $password="";  
	    srand ((double)microtime()*1000000);  
	    $max = $length/2;  
	    for($i=1; $i<=$max; $i++)  
	    {  
	    $password.=$conso[rand(0,19)];  
	    $password.=$vocal[rand(0,4)];  
	    }  
	    return $password;  
	}  
   //See more at: http://webdeveloperplus.com/php/21-really-useful-handy-php-code-snippets/#sthash.Uq75Neuz.dpuf

	/************* 
	*@l - length of random string 
	*/  
	function randomString($l){  
	  $c= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";  
	  srand((double)microtime()*1000000);  
	  for($i=0; $i<$l; $i++) {  
	      $rand.= $c[rand()%strlen($c)];  
	  }  
	  return $rand;  
	 }  

	function encodeEmail($email='info@domain.com', $linkText='Contact Us', $attrs ='class="emailencoder"' )  
	{  
	    // remplazar aroba y puntos  
	    $email = str_replace('@', '&#64;', $email);  
	    $email = str_replace('.', '&#46;', $email);  
	    $email = str_split($email, 5);  
	  
	    $linkText = str_replace('@', '&#64;', $linkText);  
	    $linkText = str_replace('.', '&#46;', $linkText);  
	    $linkText = str_split($linkText, 5);  
	      
	    $part1 = '<a href="ma';  
	    $part2 = 'ilto&#58;';  
	    $part3 = '" '. $attrs .' >';  
	    $part4 = '</a>';  
	  
	    $encoded = '<script type="text/javascript">';  
	    $encoded .= "document.write('$part1');";  
	    $encoded .= "document.write('$part2');";  
	    foreach($email as $e)  
	    {  
	            $encoded .= "document.write('$e');";  
	    }  
	    $encoded .= "document.write('$part3');";  
	    foreach($linkText as $l)  
	    {  
	            $encoded .= "document.write('$l');";  
	    }  
	    $encoded .= "document.write('$part4');";  
	    $encoded .= '</script>';  
	  
	    return $encoded;  
	}  

	function isValidEmail($email, $test_mx = false)  
	{  
	    if(eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))  
	        if($test_mx)  
	        {  
	            list($username, $domain) = split("@", $email);  
	            return getmxrr($domain, $mxrecords);  
	        }  
	        else  
	            return true;  
	    else  
	        return false;  
	}  

	function listFiles($dir)  
	{  
	    if(is_dir($dir))  
	    {  
	        if($handle = opendir($dir))  
	        {  
	            while(($file = readdir($handle)) !== false)  
	            {  
	                if($file != "." && $file != ".." && $file != "Thumbs.db")  
	                {  
	                    echo '<a target="_blank" href="'.$dir.$file.'">'.$file.'</a><br>'."\n";  
	                }  
	            }  
	            closedir($handle);  
	        }  
	    }  
	}  

	/***** 
	*@dir - Directory to destroy 
	*@virtual[optional]- whether a virtual directory 
	*/  
	function destroyDir($dir, $virtual = false)  
	{  
	    $ds = DIRECTORY_SEPARATOR;  
	    $dir = $virtual ? realpath($dir) : $dir;  
	    $dir = substr($dir, -1) == $ds ? substr($dir, 0, -1) : $dir;  
	    if (is_dir($dir) && $handle = opendir($dir))  
	    {  
	        while ($file = readdir($handle))  
	        {  
	            if ($file == '.' || $file == '..')  
	            {  
	                continue;  
	            }  
	            elseif (is_dir($dir.$ds.$file))  
	            {  
	                destroyDir($dir.$ds.$file);  
	            }  
	            else  
	            {  
	                unlink($dir.$ds.$file);  
	            }  
	        }  
	        closedir($handle);  
	        rmdir($dir);  
	        return true;  
	    }  
	    else  
	    {  
	        return false;  
	    }  
	}  

	function createSlug($string){  
	    $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);  
	    return $slug;  
	} 

	function getRealIpAddr()  
	{  
	    if (!emptyempty($_SERVER['HTTP_CLIENT_IP']))  
	    {  
	        $ip=$_SERVER['HTTP_CLIENT_IP'];  
	    }  
	    elseif (!emptyempty($_SERVER['HTTP_X_FORWARDED_FOR']))  
	    //to check ip is pass from proxy  
	    {  
	        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
	    }  
	    else  
	    {  
	        $ip=$_SERVER['REMOTE_ADDR'];  
	    }  
	    return $ip;  
	}  

	/******************** 
	*@file - path to file 
	*/  
	function forceDownload($file)  
	{  
	    if ((isset($file))&&(file_exists($file))) {  
	       header("Content-length: ".filesize($file));  
	       header('Content-Type: application/octet-stream');  
	       header('Content-Disposition: attachment; filename="' . $file . '"');  
	       readfile("$file");  
	    } else {  
	       echo "No file selected";  
	    }  
	}  

	/**
	 * create tag cloud
	 * Sample Usage: 
	 * $arr = Array('Actionscript' => 35, 'Adobe' => 22, 'Array' => 44, 'Background' => 43,   
	 *  'Blur' => 18, 'Canvas' => 33, 'Class' => 15, 'Color Palette' => 11, 'Crop' => 42,   
	 *  'Delimiter' => 13, 'Depth' => 34, 'Design' => 8, 'Encode' => 12, 'Encryption' => 30,   
	 *  'Extract' => 28, 'Filters' => 42);  
	 * 
	 *  echo getCloud($arr, 12, 36); 
	 *  
	 * @author msqueeg <msqueeg@gmail.com>
	 * @version [version]
	 * @since    2016-08-29
	 * @param   array      $data        [description]
	 * @param   integer    $minFontSize [description]
	 * @param   integer    $maxFontSize [description]
	 * @return  [type]                  [description]
	 */
	
	function getCloud( $data = array(), $minFontSize = 12, $maxFontSize = 30 )  
	{  
	    $minimumCount = min($data);  
	    $maximumCount = max($data);  
	    $spread       = $maximumCount - $minimumCount;  
	    $cloudHTML    = '';  
	    $cloudTags    = array();  
	  
	    $spread == 0 && $spread = 1;  
	  
	    foreach( $data as $tag => $count )  
	    {  
	        $size = $minFontSize + ( $count - $minimumCount )   
	            * ( $maxFontSize - $minFontSize ) / $spread;  
	        $cloudTags[] = '<a style="font-size: ' . floor( $size ) . 'px'   
	        . '" class="tag_cloud" href="#" title="\'' . $tag  .  
	        '\' returned a count of ' . $count . '">'   
	        . htmlspecialchars( stripslashes( $tag ) ) . '</a>';  
	    }  
	      
	    return join( "\n", $cloudTags ) . "\n";  
	}  

	/****************** 
	*@email - Email address to show gravatar for 
	*@size - size of gravatar 
	*@default - URL of default gravatar to use 
	*@rating - rating of Gravatar(G, PG, R, X) 
	*/  
	function showGravatar($email, $size, $default, $rating)  
	{  
	    echo '<img src="http://www.gravatar.com/avatar.php?gravatar_id='.md5($email).  
	        '&default='.$default.'&size='.$size.'&rating='.$rating.'" width="'.$size.'px"  
	        height="'.$size.'px" />';  
	}  

	/**
	 *  truncate text at word break
	 *  $short_string=myTruncate($long_string, 100, ' ');
	 */
	// Original PHP code by Chirp Internet: www.chirp.com.au   
	// Please acknowledge use of this code by including this header.   
	
	function getTruncate($string, $limit, $break=".", $pad="...") {   
	    // return with no change if string is shorter than $limit    
	    if(strlen($string) <= $limit)   
	        return $string;   
	      
	    // is $break present between $limit and the end of the string?    
	    if(false !== ($breakpoint = strpos($string, $break, $limit))) {  
	        if($breakpoint < strlen($string) - 1) {   
	            $string = substr($string, 0, $breakpoint) . $pad;   
	        }   
	    }  
	    return $string;   
	}  

	/**
	 * creates a compressed zip file
	 *
	 * example usage: 
	 * $files=array('file1.jpg', 'file2.jpg', 'file3.gif');  
	 * create_zip($files, 'myzipfile.zip', true);  
	 */
	function zipFile($files = array(),$destination = '',$overwrite = false) {  
	    //if the zip file already exists and overwrite is false, return false  
	    if(file_exists($destination) && !$overwrite) { return false; }  
	    //vars  
	    $valid_files = array();  
	    //if files were passed in...  
	    if(is_array($files)) {  
	        //cycle through each file  
	        foreach($files as $file) {  
	            //make sure the file exists  
	            if(file_exists($file)) {  
	                $valid_files[] = $file;  
	            }  
	        }  
	    }  
	    //if we have good files...  
	    if(count($valid_files)) {  
	        //create the archive  
	        $zip = new ZipArchive();  
	        if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {  
	            return false;  
	        }  
	        //add the files  
	        foreach($valid_files as $file) {  
	            $zip->addFile($file,$file);  
	        }  
	        //debug  
	        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;  
	          
	        //close the zip -- done!  
	        $zip->close();  
	          
	        //check to make sure the file exists  
	        return file_exists($destination);  
	    }  
	    else  
	    {  
	        return false;  
	    }  
	}  

	/********************** 
	*@file - path to zip file 
	*@destination - destination directory for unzipped files 
	*/  
	function unzipFile($file, $destination){  
	    // create object  
	    $zip = new ZipArchive() ;  
	    // open archive  
	    if ($zip->open($file) !== TRUE) {  
	        die (â€™Could not open archiveâ€™);  
	    }  
	    // extract contents to destination directory  
	    $zip->extractTo($destination);  
	    // close archive  
	    $zip->close();  
	    echo 'Archive extracted to directory';  
	} 

	function prependHttp()
	{
		if (!preg_match("/^(http|ftp):/", $_POST['url'])) {  
		   $_POST['url'] = 'http://'.$_POST['url'];  
		} 

	}

	function makeClickableLinks($text) {  
	 $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_+.~#?&//=]+)',  
	 '<a href="\1">\1</a>', $text);  
	 $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_+.~#?&//=]+)',  
	 '\1<a href="http://\2">\2</a>', $text);  
	 $text = eregi_replace('([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3})',  
	 '<a href="mailto:\1">\1</a>', $text);  
	  
	return $text;  
	}  

	function checkDateFormat($date)
	{
		//match the format of the date
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
		{
			//check weather the date is valid of not
			if(checkdate($parts[2],$parts[3],$parts[1]))
				return true;
			else
			return false;
		}
		else
			return false;
	}

	function notJunkEmail($Address) { /* email validation with stop for temporary email account services */
	    if(stristr($Address,"@yopmail.com")) return false;
	    if(stristr($Address,"@rmqkr.net")) return false;
	    if(stristr($Address,"@emailtemporanea.net")) return false;
	    if(stristr($Address,"@sharklasers.com")) return false;
	    if(stristr($Address,"@guerrillamail.com")) return false;
	    if(stristr($Address,"@guerrillamailblock.com")) return false;
	    if(stristr($Address,"@guerrillamail.net")) return false;
	    if(stristr($Address,"@guerrillamail.biz")) return false;
	    if(stristr($Address,"@guerrillamail.org")) return false;
	    if(stristr($Address,"@guerrillamail.de")) return false;
	    if(stristr($Address,"@fakeinbox.com")) return false;
	    if(stristr($Address,"@tempinbox.com")) return false;
	    if(stristr($Address,"@guerrillamail.de")) return false;
	    if(stristr($Address,"@guerrillamail.de")) return false;
	    if(stristr($Address,"@opayq.com")) return false;
	    if(stristr($Address,"@mailinator.com")) return false;
	    if(stristr($Address,"@notmailinator.com")) return false;
	    if(stristr($Address,"@getairmail.com")) return false;
	    if(stristr($Address,"@meltmail.com")) return false;
	    return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/i", $Address);
	} 

	/**
	 * check whether array is zero-index and sequential
	 *
	 * examples:
	 * var_dump(isAssoc(array('a', 'b', 'c'))); - false
	 * var_dump(isAssoc(array("0" => 'a', "1" => 'b', "2" => 'c'))); - false
	 * var_dump(isAssoc(array("1" => 'a', "0" => 'b', "2" => 'c'))); - true
	 * var_dump(isAssoc(array("a" => 'a', "b" => 'b', "c" => 'c'))); - true
	 *
	 * stack overflow answer : http://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential
	 * 
	 * @author msqueeg <msqueeg@gmail.com>
	 * @version [version]
	 * @date    2016-08-30
	 * @param   array     $arr   array to be tested
	 * @return  boolean         true - associative array, false - sequential array
	 */
	function isAssoc($arr = Array())
	{
		return array_keys($arr) !== range(0,count($arr) -1);
	}

}