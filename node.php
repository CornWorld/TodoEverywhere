<?php
	
	class node
	{
		static public function add($node_id, $user_id, $father, $obj) : bool
		{
			if(!self::exist($node_id) && ($father==-1 || self::exist($father))) {
				$r=sql::query(sql::getSQL("NODE_ADD", $node_id, $user_id, $father, $obj));
				return $r && ($father==-1 ? 1 : self::addSon($father,$node_id)) ? 1 : 0;
			}
			return 0;
		}
		
		static public function exist($node_id)
		{
			return self::info($node_id, 'obj');
		}
		
		static public function info($node_id, $for="*")
		{
			if($for!='*') {
				$r=sql::query(sql::getSQL("NODE_INFO", "`{$for}`", $node_id));
				if($r->num_rows==1) {
					return $r->fetch_assoc()[$for];
				}
			}
			else {
				$r=sql::query(sql::getSQL("NODE_INFO", "*", $node_id));
				if($r->num_rows==1) {
					return $r->fetch_assoc();
				}
			}
			return false;
		}
		
		static public function fatherUpdate($node_id, $new_father) : bool
		{
			return self::exist($node_id)
				? sql::query(sql::getSQL("NODE_FATHER_UPDATE", $new_father, $node_id))
				: 0;
		}
		
		static public function objUpdate($node_id, $new_obj) : bool
		{
			return self::exist($node_id)
				? sql::query(sql::getSQL("NODE_OBJ_UPDATE", $new_obj, $node_id))
				: 0;
		}
		
		static public function subtreeDelete($node_id) : bool
		{
			$st=self::subtree($node_id);
			$mu_sql="";
			foreach($st as $item) {
				$mu_sql.=sql::getSQL("NODE_DELETE", $item).";";
			}
			return sql::muQuery($mu_sql);
		}
		
		public static function subtree($node_id,$mod=0) : array
		{
			$ret=array();
			if(self::exist($node_id)) {
				$queue=$ret=array($node_id);
				$queue_len=1;
				do {
					$top=$queue[--$queue_len];
					array_pop($queue);
					$r=self::sons($top);
					if(!empty($r) && is_array($r)) {
						$queue=array_merge($r, $queue);
						if(!$mod) $ret=array_merge($r, $ret);
						else $ret[$top]=$r;
						$queue_len+=count($r);
					}
				} while(!empty($queue));
			}
			return $ret;
		}
		
		static public function sons($node_id) : array
		{
			$r=self::info($node_id, 'son');
			if($r) {
				$ret=explode(",", $r);
				array_pop($ret);
				return $ret;
			}
			return array();
		}
		
		static public function addSon($node_id,$son) : bool
		{
			if(self::exist($node_id) && self::exist($son)) {
				$sons=self::info($node_id,"son")."{$son},";
				return sql::query(sql::getSQL("NODE_SON_ADD", $sons, $node_id));
			}
			return 0;

		}
		static public function deleteSon($node_id,$son)
		{
			return self::exist($node_id) && self::exist($son)
				? sql::query(sql::getSQL("NODE_SON_DELETE", $son, $node_id))
				: 0;
		}
		
	}