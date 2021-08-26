<?php
	
	class api
	{
		static public function parse($LIST) : string
		{
			if(!isset($LIST,$LIST["action"])) return "Empty";
			switch($LIST["action"]) {
				default:
					return "Error";
				case "usr-login":
					if(isset($LIST["username"], $LIST["password"])) {
						$usr=$LIST["username"];
						$pwd=$LIST["password"];
						if(!empty($usr) && !empty($pwd)
							&& !empty($token=usr::createToken($usr, $pwd))
						) {
							return $token;
						}
					}
					return "Error";
				case "usr-change-password":
					if(isset($LIST["username"], $LIST["password"], $LIST["new_password"])) {
						$usr=$LIST["username"];
						$pwd=$LIST["password"];
						$new_pwd=$LIST["new_password"];
						if(!empty($usr) && !empty($pwd) && !empty($new_pwd)) {
							return usr::change_passwd($usr, $pwd, $new_pwd) ? "Done" : "Error";
						}
					}
					return "Error";
				
				case "node-add":
					if(isset($LIST["token"], $LIST["father"], $LIST["obj"])) {
						$token=$LIST["token"];
						$father=$LIST["father"];
						$obj=$LIST["obj"];
						if(!empty($father) && !empty($obj) && $uid=usr::tokenTime($token, 1)) {
							$node_id=random::getStr(16);
							if(node::add(
								$node_id,
								$uid,
								$father, $obj
							)) {
								return $node_id;
							}
						}
					}
					return "Error";
				case "node-info":
					if(isset($LIST["token"], $LIST["node_id"])) {
						$token=$LIST["token"];
						$node_id=$LIST["node_id"];
						if($uid=usr::tokenTime($token, 1)) {
							$info=node::info($node_id);
							if($info["usr"]==$uid) {
								return json_encode($info);
							}
						}
					}
					return "Error";
				case "node-father-update":
					if(isset($LIST["token"], $LIST["node_id"], $LIST["new_father"])) {
						$token=$LIST["token"];
						$node_id=$LIST["node_id"];
						$new_fa=$LIST["new_father"];
						if($uid=usr::tokenTime($token, 1)) {
							$info=node::info($node_id);
							if($info["usr"]==$uid && $info["father"]!=$new_fa) {
								return node::fatherUpdate($node_id, $new_fa) ? "Done" : "Error";
							}
						}
					}
					return "Error";
				case "node-obj-update":
					if(isset($LIST["token"], $LIST["node_id"], $LIST["new_obj"])) {
						$token=$LIST["token"];
						$node_id=$LIST["node_id"];
						$new_obj=$LIST["new_obj"];
						if($uid=usr::tokenTime($token, 1)) {
							$info=node::info($node_id);
							if($info["usr"]==$uid && $info["obj"]!=$new_obj) {
								return node::objUpdate($node_id, $new_obj) ? "Done" : "Error";
							}
						}
					}
					return "Error";
				case "node-subtree":
					if(isset($LIST["token"], $LIST["node_id"])) {
						$token=$LIST["token"];
						$node_id=$LIST["node_id"];
						if($uid=usr::tokenTime($token, 1)) {
							$info=node::info($node_id);
							if($info["usr"]==$uid) {
								return json_encode(node::subtree($node_id, 1));
							}
						}
					}
					return "Error";
			}
		}
		
	}