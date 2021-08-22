<?php
	
	class crypto
	{
		static public function encrypt($algo, $str, $key) : string
		{
			return base64_encode(openssl_encrypt($str, $algo, $key, OPENSSL_RAW_DATA, openssl_random_pseudo_bytes(openssl_cipher_iv_length($algo))));
		}
		
		static public function decrypt($algo, $str, $key) : string
		{
			return openssl_decrypt(base64_decode($str), $algo, $key, OPENSSL_RAW_DATA, openssl_random_pseudo_bytes(openssl_cipher_iv_length($algo)));
		}
	}