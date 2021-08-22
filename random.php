<?php
	class random
	{
		const GEN_TMP_SIZE=128;
		const GEN_TMP_STR="abcdefghijklmnopqrstuvwxyz1234567890";
		const GEN_TMP_STR_SIZE=26+10;
		static private string $tmpStr="";
		static private int $tmpSize=0;
		static public function getStr($size): string
		{
			$ret="";
			$curr_size=0;
			while($curr_size<$size-1) {
				if(self::$tmpSize==0) {
					mt_srand(micro_time());
					for($i=1;$i<=self::GEN_TMP_SIZE;$i++)
						self::$tmpStr[self::$tmpSize++]=self::GEN_TMP_STR[mt_rand()%self::GEN_TMP_STR_SIZE];
				}
				
				$ret[$curr_size++]=self::$tmpStr[--self::$tmpSize];
			}
			return $ret;
		}
	}
	
	function micro_time(): int
	{
		list($use, $sec) = explode(" ", microtime());
		return (int)(((float)$use + (float)$sec)*1e13);
	}