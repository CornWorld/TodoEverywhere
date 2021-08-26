<?php
	
	class sql
	{
		private const mysql_host="23.224.197.111";
		private const mysql_user="TodoEverywhere";
		private const mysql_passwd="TodoEverywhere";
		private const mysql_dbname="TodoEverywhere";
		private const mysql_port=3306;
		private const sql_set=array(
			// USR
			"USR_EXIST"=>"SELECT `id` FROM `usr` WHERE `name`='%s'",
			"USR_REG"=>"INSERT INTO `usr`(`name`,`passwd`) VALUE('%s','%s')",
			"USR_UPT_PWD"=>"UPDATE `usr` SET `passwd`='%s' WHERE `id`=%d",
			"USR_LOGIN"=>"SELECT `passwd` FROM `usr` WHERE `id`=%d",
			
			// TOKEN
			"TOKEN_CREATE"=>"INSERT INTO `token`(`token`,`user_id`) VALUE('%s',%d)",
			"TOKEN_INFO"=>"SELECT %s FROM `token` WHERE `token`='%s'",
			
			// NODE
			"NODE_INFO"=>"SELECT %s FROM `idx` WHERE `idx_id`='%s'",
			
			"NODE_ADD"=>"INSERT INTO `idx`(`idx_id`,`usr`,`father`,`obj`) VALUE('%s','%d','%s','%s')",
			"NODE_SON_ADD"=>"UPDATE `idx` SET `son`=CONCAT_WS(`son`,'%s,') WHERE `idx_id`='%s'",
			"NODE_SON_DELETE"=>"UPDATE `idx` SET `son`=REPLACE(`son`,'%s,','')",
			
			"NODE_FATHER_UPDATE"=>"UPDATE `idx` SET `father`='%s' WHERE `idx_id`='%s'",
			"NODE_OBJ_UPDATE"=>"UPDATE `idx` SET `obj`='%s' WHERE `idx_id`='%s'",
			
			"NODE_DELETE"=>"DELETE FROM `idx` WHERE `idx_id`='%s'",
			//OBJ
			"OBJ_ADD"=>"INSERT INTO `obj`(`obj_id`,`obj_info`,`obj_val`) VALUE('%s','%s','%s')",
			"OBJ_QUERY_ALL"=>"SELECT `obj_info`,`obj_val` FROM `obj` WHERE `obj_id`='%s'",
			"OBJ_QUERY_INFO"=>"SELECT `obj_info` FROM `obj` WHERE `obj_id`='%s'",
			"OBJ_QUERY_VAL"=>"SELECT `obj_val` FROM `obj` WHERE `obj_id`='%s'",
		);
		
		private static mysqli $c;
		
		static public function init()
		{
			self::$c=@mysqli_connect(
				self::mysql_host,
				self::mysql_user,
				self::mysql_passwd,
				self::mysql_dbname,
				self::mysql_port
			);
			if(!self::$c && self::$c->connect_errno) {
				die("Error Database Connection!".self::$c->connect_error);
			}
		}
		
		static public function getSQL($name) : string
		{
			$args=func_get_args();
			return sprintf(self::sql_set[$name], @$args[1], @$args[2], @$args[3], @$args[4], @$args[5], @$args[6], @$args[7]);
		}
		
		static public function query($sql)
		{
			return mysqli_query(self::$c, $sql);
		}
		
		static public function muQuery($sql) : bool
		{
			return mysqli_multi_query(self::$c, $sql);
		}
		
		static public function storeResult()
		{
			return self::$c->store_result();
		}
		
		static public function moreResults() : bool
		{
			return self::$c->more_results();
		}
	}