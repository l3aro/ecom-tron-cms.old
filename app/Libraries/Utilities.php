<?php
namespace App\Libraries;

class Utilities {
    public static function ShortDes($str, $leng = '250') {
		$str = strip_tags($str);
        if(strlen($str) > $leng){
			$str = substr($str, 0, $leng);
			$space = strripos($str, " ");
			$str = substr($str, 0, $space )." ... ";
		}
		return $str;
    }
    
    // This function reads the extension of the file.
	// It is used to determine if the file is an image by checking the extension.
	public function getExtension($str) {
	    $i = strrpos($str,".");
	    if (!$i) { return ""; }
	    $l = strlen($str) - $i;
	    $ext = substr($str,$i+1,$l);
	    return $ext;
	}
}

?>