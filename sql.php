<?php
	class sql {
		private const mysql_host="23.224.197.111";
		private const mysql_user="TodoEverywhere";
		private const mysql_passwd="TodoEverywhere";
		private const mysql_dbname="TodoEverywhere";
		private const mysql_port=3306;
		private const sql_set=array(
			// USR
			"USR_EXIST"=>"SELECT `id` FROM `usr` WHERE `name`='%s' ",
			"USR_REG"=>"INSERT INTO `usr`(`name`,`passwd`) VALUE('%s','%s')",
			"USR_UPT_PWD_CHECK"=>"SELECT `passwd` FROM `usr` WHERE `id`=%d",
			"USR_UPT_PWD"=>"UPDATE `usr` SET `passwd` WHERE `id`=%d",
			"USR_LOGIN"=>"SELECT `passwd` FROM `usr` WHERE `id`=%d",
			
			// TD
			"TD_NODE_EXIST"=>"SELECT `obj` FROM `idx` WHERE `index_id`='%d'",
			"TD_NODE_ADD"=>"INSERT INTO `idx`(`index_id`,`usr`,`father`,`obj`) VALUE('%s','%d','%s','%s')",
			
			"TD_NODE_FATHER_QUERY"=>"SELECT `father` FROM `idx` WHERE `index_id`='%d'",
			"TD_NODE_FATHER_UPDATE"=>"UPDATE `idx` SET `father`='%s' WHERE `index_id`='%s'",
			
			"TD_NODE_OBJ_QUERY"=>"SELECT `obj` FROM `idx` WHERE `index_id`='%d'",
			"TD_NODE_OBJ_UPDATE"=>"UPDATE `idx` SET `obj`='%s' WHERE `index_id`='%s'",
			
			"TD_NODE_SON_QUERY_ALL"=>"SELECT `son` FROM `idx` WHERE `index_id`='%d'",
			"TD_NODE_SON_QUERY"=>"SELECT `son` FROM `idx` WHERE `index_id`='%d'
								  and `son`='%s'",
			"TD_NODE_SON_ADD"=>"INSERT INTO `idx`(`index_id`,`usr`,`father`,`son`,`obj`) VALUE('%s','%d','%s','%s','%s')",
			"TD_NODE_SON_UPDATE"=>"SELECT `son` FROM `idx` WHERE `index_id`='%d' and `son`='%s'",
			
			"OBJ_ADD"=>"INSERT INTO `obj`(`obj_id`,`obj_info`,`obj_val`) VALUE('%s','%s','%s')",
			"OBJ_QUERY_ALL"=>"SELECT `obj_info`,`obj_val` FROM `obj` WHERE `obj_id`='%s'",
			"OBJ_QUERY_INFO"=>"SELECT `obj_info` FROM `obj` WHERE `obj_id`='%s'",
			"OBJ_QUERY_VAL"=>"SELECT `obj_val` FROM `obj` WHERE `obj_id`='%s'",
		);
		
		static public mysqli $c;
		static public function init() {
			self::$c=@new mysqli(mysql_host,mysql_user,mysql_passwd,mysql_dbname,mysql_port);
			if(!self::$c && self::$c->connect_errno) {
				die("Error Database Connection!".self::$c->connect_error);
			}
		}
		
		static public function getSQL($name) : string
		{
			$args=func_get_args();
			var_dump($args);
			return sprintf(self::sql_set[$name],@$args[1],@$args[2],@$args[3],@$args[4],@$args[5],@$args[6],@$args[7]);
		}
		
	}
	