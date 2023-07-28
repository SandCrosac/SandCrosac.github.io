<?php
namespace Model;
use HY\Model;
!defined('HY_PATH') && exit('HY_PATH not defined.');
class Friend extends Model {

	//获取两者关系
	public function get_state($uid1,$uid2){
		
		$state = $this->find('*',[
			'AND'=>[
				'uid1'=>$uid1,
				'uid2'=>$uid2
				]
			]
		);
		
		return empty($state) ? false : $state['state'];
	}
	public function set_state($uid1,$uid2,$s){
		
		return $this->update(['state'=>$s],['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]]);
	}
	//添加关注关系
	public function add_friend($uid1,$uid2){
		
		if(!$this->has(['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]])){ //$uid1 未关注 $uid2
			
			if($this->has(['AND'=>['uid1'=>$uid2,'uid2'=>$uid1]])){ // $uid2 关注了 $uid1
				
				if($this->get_state($uid2,$uid1)!= 0){
					$this->set_state($uid2,$uid1,2);
					return $this->insert(['uid1'=>$uid1,'uid2'=>$uid2,'state'=>2]);
				}
				
				return $this->insert(['uid1'=>$uid1,'uid2'=>$uid2,'state'=>1]);
				
				
			}else{
				
				return $this->insert(['uid1'=>$uid1,'uid2'=>$uid2,'state'=>1]);
			}
		}else{
			
			$this->set_state($uid1,$uid2,1);
		}
		
		//已存在朋友关系
		return false;
	}
	//删除朋友关系
	public function rm_friend($uid1,$uid2){
		
		if($this->has(['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]])){ //$uid1 关注 $uid2
			
			if($this->has(['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]])){ // $uid2 关注了 $uid1
				
				if($this->get_state($uid2,$uid1)!= 0)
					$this->set_state($uid2,$uid1,1);
			}
			
			//$this->delete(['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]]);
			$this->set_state($uid1,$uid2,0);
		}
		
	}

	public function update_int($uid1,$uid2,$type="+",$size=1){
		
		if($this->has(['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]])){
			
			if($type==="+")
				$this->update(["c[{$type}]"=>$size,'update_time'=>NOW_TIME],['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]]);
			else
				$this->update(["c[{$type}]"=>$size],['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]]);
			$this->get_c($uid1,$uid2);
			 
		}
		
		$this->insert(['uid1'=>$uid1,'uid2'=>$uid2,'c'=>1,'atime'=>NOW_TIME,'update_time'=>NOW_TIME,'state'=>0]);
		
		//陌生人=1
	}
	public function get_c($uid1,$uid2){
		
		if(!$this->has(['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]]))
			return 0;
		
		$c= $this->find('c',['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]]);
		if($c<0)
			$this->clear_c($uid1,$uid2);
		
		return ($c < 0 )?0:$c;
	}
	public function clear_c($uid1,$uid2){
		$this->update(['c'=>0],['AND'=>['uid1'=>$uid1,'uid2'=>$uid2]]);
	}
	
}