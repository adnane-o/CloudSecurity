<?php

include "functions_crypt.php";

    function crypt_file($source)
    {
		$key = md5(uniqid(rand(),true));
		$key = substr($key, 0, 24);
		$destination = $source.".cr";
		Encrypt($source,$destination,$key);
		return $key;
    }

?>