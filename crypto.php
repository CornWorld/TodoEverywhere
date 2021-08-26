<?php
	
	class crypto
	{
		static public function generateIV($algo) : string
		{
			return openssl_random_pseudo_bytes(self::lenIV($algo));
		}
		
		static public function lenIV($algo) : int
		{
			return openssl_cipher_iv_length($algo);
		}
		
		static public function encrypt($algo, $str, $key, $iv) : string
		{
			return base64_encode(openssl_encrypt($str, $algo, $key, OPENSSL_RAW_DATA, $iv));
		}
		
		static public function decrypt($algo, $str, $key, $iv) : string
		{
			return openssl_decrypt(base64_decode($str), $algo, $key, OPENSSL_RAW_DATA, $iv);
		}
	}
