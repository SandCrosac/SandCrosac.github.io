<?php
namespace Action;
use HY\Action;
!defined('HY_PATH') && exit('HY_PATH not defined.');
class My extends HYBBS {
    public $menu_action;
    public function __construct(){
		parent::__construct();
        
        $this->view = IS_MOBILE ? $this->conf['wapuserview'] : $this->conf['userview'];
        $this->menu_action = array(
            'index'=>'',
            'thread'=>'',
            'post'=>'',
            'mess'=>'',
            'op'=>'',
            'file'=>'',
            'log'=>'',
            
        );
        
//Hook ##START##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:64:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_my_init_1.hook";}##

//<?
$this->menu_action['collection']='';
$this->menu_action['visitor']='';
//Hook ##END##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:64:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_my_init_1.hook";}##


    }
    //用户中心
    public function _no(){
        
        $username   = isset($_GET['HY_URL'][1])?$_GET['HY_URL'][1]:'';
        $method     = isset($_GET['HY_URL'][2])?$_GET['HY_URL'][2]:'index';
        $username = urldecode ($username); //url解码
        if(empty($username))
            return $this->message("请输入一个用户名称");

        //$encode = mb_detect_encoding($username);
        //var_dump($username);

        //echo $encode;return;
        //if ($encode == "UTF-8"){
        //$username = iconv('GBK',"UTF-8",$username);
            //$username = iconv('GBK',"UTF-8",$username);
        //}
        
        //服务器引入 GBK编码 非zh系统
        $encode = mb_detect_encoding($username, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5')); 
        $username = mb_convert_encoding($username, 'UTF-8', $encode);

        
        $User = M("User"); //实例用户模型
        $uid = $User->user_to_uid($username); //用户名转ID



        if(!$uid)
            return $this->message("不存在该用户");

        if(empty($method))
            $method = 'index';

        
        $this->menu_action[$method] = 'active';
        $this->v('menu_action',$this->menu_action);
        $this->v('method',$method);
        $this->v('username',$username);

        if($method == 'index'){ //用户首页
            
            $thread_data = (array)M('Thread')->get_user_thread_list($uid,1,5);

            $post_data = S("Post")->select("*",array(
                'AND'=>array(
                    'uid'=>$uid,
                    'isthread'=>0,
                ),
                "ORDER"=> ['pid'=>'DESC'],
                'LIMIT'=>5
            ));

            
//Hook ##START##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:65:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_my_empty_5.hook";}##

//<?
foreach($thread_data as &$v){
    $v['user'] = $User->uid_to_user($v['uid']);
    $v['avatar'] = $this->avatar($v['user']);
}
// var_dump($thread_data);exit;
//Hook ##END##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:65:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_my_empty_5.hook";}##

            foreach ($post_data as &$v) {
                $v['content'] = mb_substr(strip_tags($v['content']), 0,50);
            }
            $this->v("thread_data",$thread_data);
            $this->v("post_data",$post_data);

            $data = $User->read($uid);
            $data['avatar'] = $this->avatar($uid);
            $data['friend_state'] = false;
            if(IS_LOGIN){
                if(NOW_UID != $uid){
                    $Friend = M("Friend");
                    $data['friend_state'] = $Friend->get_state(NOW_UID,$uid);
                }
                

            }

            $this->v("title",$data['user']);
            $this->v('data',$data);
            $this->display('user_index');
        }elseif($method == 'thread'){ //用户主题
            
            $data = $User->read($uid);
            $data['avatar'] = $this->avatar($uid);

            $Thread = M("Thread");
            $pageid=intval(isset($_GET['HY_URL'][3]) ? $_GET['HY_URL'][3] : 1) or $pageid=1;
            $thread_data = (array)$Thread->get_user_thread_list($uid,$pageid);

            foreach ($thread_data as &$v) {
                $v['atime'] =   $v['atime'];
                $v['avatar'] =$data['avatar'];
                $v['user']  = $data['user'];
                
            }
            
            //print_r($thread_data);

            $count = $data['threads'];
    		$count = (!$count)?1:$count;
    		$page_count = ($count % 10 != 0)?(intval($count/10)+1) : intval($count/10);
            
            $this->v("title",'我的主题');
            $this->v("pageid",$pageid);
    		$this->v("page_count",$page_count);
            $this->v('thread_data',$thread_data);
            $this->v('data',$data);
            $this->display('user_thread');
        }elseif($method == 'post'){ //用户帖子
            
            $data = $User->read($uid);
            $data['avatar'] = $this->avatar($uid);

            $Post = S("Post");

            $pageid=intval(isset($_GET['HY_URL'][3]) ? $_GET['HY_URL'][3] : 1) or $pageid=1;
            $post_data = $Post->select('*',[
                
                'AND'=>[
                    'uid'=>$uid,
                    'isthread'=>0,
                ],
                'LIMIT' =>[($pageid-1) * 10, 10],
                'ORDER' => ['pid'=>'DESC']
            ]);
            
            $Thread = M("Thread");
            $tmp_thread_data= array();
            foreach ($post_data as &$v) {
                if(!isset($tmp_thread_data[$v['tid']]))
                    $tmp_thread_data[$v['tid']] = $Thread->get_row($v['tid'],['uid','title']);
                //$v['atime']=$v['atime'];
                $v['content'] = mb_substr(strip_tags($v['content']), 0,50);
                $v['title'] = $tmp_thread_data[$v['tid']]['title'];
                $v['uid'] = $tmp_thread_data[$v['tid']]['uid'];
            }
            $User->auto_add_user($post_data);
            
            

            $count = $data['posts'];
    		$count = (!$count)?1:$count;
    		$page_count = ($count % 10 != 0)?(intval($count/10)+1) : intval($count/10);

            $this->v("title",'我的帖子');
            $this->v("pageid",$pageid);
    		$this->v("page_count",$page_count);
            $this->v('post_data',$post_data);
            $this->v('data',$data);
            $this->display('user_post');
        
        }elseif($method == 'op'){//用户配置
            
            if(!IS_LOGIN)
                return $this->message("未登录，无法查看该页面");
            if(NOW_UID != $uid)
                return $this->message("没有权限访问他人配置页");
            $data = $User->read($uid);
            $data['avatar'] = $this->avatar($uid);

            
            $this->v('data',$data);
            $this->v("title","个人资料");
            $this->display('user_op');

        }elseif($method == 'file'){ //文件列表
            
            if(!IS_LOGIN)
                return $this->message("未登录，无法查看你的消息");
            if(NOW_UID != $uid)
                return $this->message("你不能查看他人文件!");
            $data = $User->read($uid);
            $data['avatar'] = $this->avatar($uid);

            $File=S("File");
            $Filedata = $File->select('*',['uid'=>$uid,'ORDER'=>['id'=>'DESC']]);

            // $filearr = array();
            // if(is_dir(INDEX_PATH. "upload/userfile/".$uid."/")){
            //     if($dh = opendir(INDEX_PATH. "upload/userfile/".$uid."/")) {
            //         while (($file = readdir($dh)) !== false){
                        
            //             if($file!="." && $file!=".."){
            //                 $filearr[]=$file;
                            
            //             }
            //         }
            //     }
            // }
            
            //$this->v("filearr",$filearr);
            $this->v("Filelist",$Filedata);
            $this->v('data',$data);
            $this->v("title","我的文件");
            $this->display('user_file');
        }elseif($method == 'log'){
            if(!IS_LOGIN)
                return $this->message("未登录，无法查看该页面");
            if(NOW_UID != $uid)
                return $this->message("没有权限访问他人流水记录");

            $pageid=intval(isset($_GET['HY_URL'][3]) ? $_GET['HY_URL'][3] : 1) or $pageid=1;

            $data = $User->read($uid);
            $data['avatar'] = $this->avatar($uid);
            $this->v('data',$data);
            $this->v("title","积分日志");

            $Log = S('Log');
            $log_data = $Log->select('*',[
                'uid'=>NOW_UID,
                'ORDER'=>['id'=>'DESC'],
                'LIMIT' =>[($pageid-1) * 10, 10],
            ]);

            $count = $Log->count(['uid'=>NOW_UID]);
            $page_count = ($count % 10 != 0)?(intval($count/10)+1) : intval($count/10);

            $this->v("count",$count);
            $this->v("pageid",$pageid);
            $this->v("page_count",$page_count);
            $this->v('log_data',$log_data);
            $this->display('user_log');
        }elseif($method == 'message'){
            if(!IS_LOGIN)
                return $this->message("未登录，无法查看该页面");
            if(NOW_UID != $uid)
                return $this->message("没有权限访问消息页面");

            $data = $User->read($uid);
            $data['avatar'] = $this->avatar($uid);
            $this->v("title","我的消息");


            $message = X('get.message');
            $chat_uid = X('get.uid');
            if(empty($message))  $message = 'index';
            if(empty($chat_uid)) $chat_uid = 0;

            $Friend = S('Friend');
            $friend_data = $Friend->select('*',['OR'=>['uid1'=>NOW_UID,'uid2'=>NOW_UID],'ORDER'=>['update_time'=>'DESC']]);


            $chat_user_data =[];
            if($chat_uid == 0){
                $chat_user_data=[
                    'uid'=>0,
                    'user'=>'系统',
                    'avatar'=>[
                        'a'=>'View/hy_friend/bell.png',
                        'b'=>'View/hy_friend/bell.png',
                        'c'=>'View/hy_friend/bell.png'
                    ]
                ];
            }elseif($User->has(['uid'=>$chat_uid])){
                $chat_user_data = $User->read($chat_uid);
                $chat_user_data['avatar'] = $this->avatar($chat_uid);

            }
            $this->v('chat_user_data',$chat_user_data);
            $friend_list=[];
            if(!empty($friend_data)){

                switch ($message) {
                    case 'index':
                        foreach ($friend_data as $v) {
                            if($v['uid1']==NOW_UID)
                                $friend_list[]=$v;
                        }
                        foreach ($friend_data as $v) {
                            if($v['uid1'] != NOW_UID && $v['uid2'] == NOW_UID){
                                $b=false;
                                foreach ($friend_list as $vv) {
                                    if($vv['uid1'] == $v['uid2'] && $vv['uid2'] == $v['uid1']){
                                        $b=true;
                                        break;
                                    }
                                }
                                if(!$b){
                                    $v['uid2'] = $v['uid1'];
                                    $friend_list[]=$v;
                                }

                                $tmp = array();
                                unset($vv);
                                foreach ($friend_list as $vv) {
                                    $tmp[] = $vv['update_time'];
                                }
                                array_multisort($tmp,SORT_DESC,$friend_list);
                            }
                        }
                        break;
                    case 'follow':
                        // $friend_list = $Friend->select('*',['AND'=>['uid1'=>NOW_UID,'state'=>[1,2]],'ORDER'=>['atime'=>'DESC']]);

                        foreach ($friend_data as $v) {
                            if($v['uid1']==NOW_UID && ($v['state'] == 1 || $v['state'] == 2))
                                $friend_list[]=$v;
                        }
                        break;
                    case 'fans':
                        // $friend_list = $Friend->select('*',['AND'=>['uid2'=>NOW_UID,'state'=>[1,2]],'ORDER'=>['update_time'=>'DESC']]);
                        // foreach ($friend_list as $key => &$v) {
                        //     $v['uid2'] = $v['uid1'];
                        // }

                        foreach ($friend_data as $v) {
                            if($v['uid2']==NOW_UID && ($v['state'] == 1 || $v['state'] == 2)){
                                $v['uid2']=$v['uid1'];
                                $friend_list[]=$v;
                            }
                        }
                        break;
                    default:
                        break;
                }
                $User->auto_add_user($friend_list,'user','uid2');
            }

            

            

            

            $Online = S("Online");

            $administrator = [
                'uid2'=>0,
                'user'=>'系统',
                'ps'=>'系统消息',
                'avatar'=>[
                    'a'=>'View/hy_friend/bell.png',
                    'b'=>'View/hy_friend/bell.png',
                    'c'=>'View/hy_friend/bell.png',
                ],
                'ol'=>true,
                'c'=>0
            ];
            foreach ($friend_list as $key => &$v) {
                $v['ps'] = $User->get_row($v['uid2'],'ps');
//                if($v['uid2']==0)$v['ps']='系统消息';
                $v['avatar'] = $this->avatar($v['uid2']);
                $v['ol']=$Online->has(['AND'=>['uid'=>$v['uid2'],'atime[>]'=>NOW_TIME-BBSCONF('out_s')]]);

                if($v['uid2'] == 0){
                    $administrator['c']=$v['c'];
                    unset($friend_list[$key]);
                }
            }
            if($message == 'index')
                array_unshift($friend_list,$administrator);


            $this->v('friend_list',$friend_list);
            $this->v('data',$data);
            $this->display('user_message');
        }elseif($method == 'collections'){
            $pageid=intval(isset($_GET['HY_URL'][3]) ? $_GET['HY_URL'][3] : 1) or $pageid=1;

            $data = $User->read($uid);
            $data['avatar'] = $this->avatar($uid);
            $this->v('data',$data);
            $this->v("title","积分日志");

            $Thread_star = S('Thread_star');
            $tid_list = $Thread_star->select('tid',[
                'uid'=>$uid,
                'ORDER'=>['atime'=>'DESC'],
                'LIMIT' =>[($pageid-1) * 10, 10],
            ]);
            $thread_data=[];

            if(!empty($tid_list)){
                $thread_data = S('Thread')->select('*',['tid'=>$tid_list]);
            }



            $count = $Thread_star->count(['uid'=>$uid]);
            $page_count = ($count % 10 != 0)?(intval($count/10)+1) : intval($count/10);

            $this->v("count",$count);
            $this->v("pageid",$pageid);
            $this->v("page_count",$page_count);
            $this->v('thread_data',$thread_data);

            $this->display('user_collections');
        }
        
//Hook ##START##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:66:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_my_empty_18.hook";}##

//<?
//收藏
if($method == 'collection'){
    $pageid=intval(isset($_GET['HY_URL'][3]) ? $_GET['HY_URL'][3] : 1) or $pageid=1;

    $data = $User->read($uid);
    $data['avatar'] = $this->avatar($data['user']);
    $this->v('data',$data);
    $this->v("title","收藏");

    $collection = S('plugins_collection');
    $collection_data = $collection->select('*',[
        'uid'=>NOW_UID,
        'ORDER'=>['id'=>'DESC'],
        'LIMIT' =>[($pageid-1) * 10, 10],
    ]);
    
    foreach($collection_data as &$v){
        $thread = S('thread')->find('*',['tid'=>$v['tid']]);
        $v['title'] = $thread['title'];
        $v['summary'] = $thread['summary'];
        $v['views'] = $thread['views'];
        $v['posts'] = $thread['posts'];
        $v['fid'] = $thread['fid'];
        $v['jing'] = $thread['jing'];
        $v['goods'] = $thread['goods'];
        $v['shenhe'] = isset($thread['shenhe'])?$thread['shenhe']:'';
        $v['user'] = $User->uid_to_user($v['uid']);
        $v['avatar'] = $User->avatar($v['user']);
    }
    $count = $collection->count(['uid'=>NOW_UID]);
    $page_count = ($count % 10 != 0)?(intval($count/10)+1) : intval($count/10);

    $this->v("count",$count);
    $this->v("pageid",$pageid);
    $this->v("page_count",$page_count);
    $this->v('collection_data',$collection_data);
    $this->display('user_collection');
}elseif($method == 'visitor'){//访客

    $pageid=intval(isset($_GET['HY_URL'][3]) ? $_GET['HY_URL'][3] : 1) or $pageid=1;

    $data = $User->read($uid);
    $data['avatar'] = $this->avatar($data['user']);
    $this->v('data',$data);
    $this->v("title","访客");

    $Log = S('Log');
    $log_data = $Log->select('*',[
        'uid'=>NOW_UID,
        'ORDER'=>['id'=>'DESC'],
        'LIMIT' =>[($pageid-1) * 10, 10],
    ]);

    $count = $Log->count(['uid'=>NOW_UID]);
    $page_count = ($count % 10 != 0)?(intval($count/10)+1) : intval($count/10);

    $this->v("count",$count);
    $this->v("pageid",$pageid);
    $this->v("page_count",$page_count);
    $this->v('log_data',$log_data);
    $this->display('user_visitor');
}elseif($method == 'user_style'){

    if(!IS_LOGIN)
        return $this->message("未登录，无法查看该页面");
    if(NOW_UID != $uid)
        return $this->message("非法访问");
    $data = $User->read($uid);
    $data['avatar'] = $this->avatar($data['user']);

    $this->v('data',$data);
    $this->v("title","设置背景");
    if(IS_SHOUJI){
        $this->display('user_style');
    }
            
}elseif($method == 'my'){
    if(!IS_LOGIN){
        header('Location: '.WWW);exit;
    }

    $data = $User->read($uid);
    $data['avatar'] = $this->avatar($data['user']);
    $this->v('data',$data);
    if(IS_SHOUJI){
        $this->display('user_my');
    }    
}
//Hook ##END##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:66:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_my_empty_18.hook";}##

//Hook ##START##a:3:{s:11:"plugin_name";s:18:"DN_个人资料图";s:8:"dir_name";s:11:"nd_user_img";s:4:"path";s:62:"/www/wwwroot/mh.87sms.cn/Plugin/nd_user_img/a_my_empty_18.hook";}##

if($method == 'style'){

    if(!IS_LOGIN)
        return $this->message("未登录，无法查看该页面");
    if(NOW_UID != $uid)
        return $this->message("非法访问");
    $data = $User->read($uid);
    $data['avatar'] = $this->avatar($data['user']);

    $this->v('data',$data);
    $this->v("title","设置背景");
    if(IS_SHOUJI){
        $this->display('plugin.nd_user_img::user_style');
    }
            
}
//Hook ##END##a:3:{s:11:"plugin_name";s:18:"DN_个人资料图";s:8:"dir_name";s:11:"nd_user_img";s:4:"path";s:62:"/www/wwwroot/mh.87sms.cn/Plugin/nd_user_img/a_my_empty_18.hook";}##


        
    }
    
}














