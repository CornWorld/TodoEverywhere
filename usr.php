<?php
	class usr
	{
		const maxTokenTime=3600*6;
		static private function encode($username,$passwd) : string {
			$str=sha1(Crypt($passwd,"TodoEverywhere".$username));
			$iv=crypto::generateIV("aes-256-cbc");
			return crypto::encrypt("aes-256-cbc",$str,md5("TodoEverywhereAesKey.".$username),$iv).$iv;
		}
		static private function decode($username,$str_mix) : string {
			$str_mix_len=strlen($str_mix);
			$iv_len=crypto::lenIV("aes-256-cbc");
			$iv=substr($str_mix,$str_mix_len-$iv_len);
			$str=substr($str_mix,0,$str_mix_len-$iv_len);
			return crypto::decrypt("aes-256-cbc",$str,md5("TodoEverywhereAesKey.".$username),$iv);
		}
		
		static public function exist($username) : int {
			$r=sql::query(sql::getSQL("USR_EXIST",$username));
			return $r && $r->num_rows ? $r->fetch_array()["id"] : 0;
		}
		static public function login($username,$passwd) : int {
			if($uid=self::exist($username)) {
				$r=sql::query(sql::getSQL("USR_LOGIN",$uid));
				var_dump($r);
				if($r && $r->num_rows==1) {
					$db_pwd_mix=$r->fetch_array()["passwd"];
					$ori_str=self::decode($username,$db_pwd_mix);
					$curr_pwd=sha1(Crypt($passwd,"TodoEverywhere".$username));
					if($ori_str==$curr_pwd) {
						return $uid;
					}
				}
			}
			return 0;
		}
		static public function register($username,$passwd) : bool {
			if(!self::exist($username)) {
				$r=sql::query(sql::getSQL("USR_REG",$username,self::encode($username,$passwd)));
				return $r ? 1 : 0;
			}
			return 0;
		}
		static public function change_passwd($username,$old_passwd,$new_passwd) : bool {
			if(!($uid=self::login($username,self::decode($username,$new_passwd)))) {
				$r=sql::query(sql::getSQL("USR_UPT_PWD",self::encode($username,$new_passwd),$uid));
				return $r ? 1 : 0;
			}
			return 0;
		}
		
		static public function createToken($username,$passwd) : string {
			if($uid=self::login($username,$passwd)) {
				$r=sql::query(sql::getSQL("TOKEN_CREATE",$token=random::getStr(48),$uid));
				if($r) return $token;
			}
			return "";
		}
		static public function tokenTime($token,$mod=0) {
			$r=sql::query(sql::getSQL("TOKEN_TIME",$token));
			if($r && $r->num_rows==1) {
				$t=strtotime($r->fetch_array()["time"]);
				return $mod ? self::maxTokenTime<=(time()-$t) : $t;
			}
			return false;
		}
	}