<?php
namespace Action;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Plugins extends HYBBS
{
    public function index(){
        $this->message('你访问的页面不存在');
    }
    // 精华论坛列表
    public function digest()
    {
        $this->__construct();
        $pageid=intval(isset($_GET['HY_URL'][3]) ? $_GET['HY_URL'][3] : 1) or $pageid=1;
        if(!isset($_GET['HY_URL'][2])){
            return $this->message('页面不存在');
        }
        $fid = intval($_GET['HY_URL'][2]);
        
        $Thread = M("Thread");
        
        $Thread_data = $Thread->select('*',[
            'fid'   => $fid,
            'jing'  => 1,
            'LIMIT' =>[($pageid-1) * 10, 10],
            'ORDER' => ['pid'=>'DESC']
            ]);
        $User = M('User');

        foreach ($Thread_data as &$v) {
            $v['user']    = $User->uid_to_user($v['uid']);
            $v['avatar']  = $User->avatar($v['user']);;
        }
        
        //{hook a_my_empty_10}

        $count = $Thread->count(['jing'=>1,'fid'=>$fid]);
        $count = (!$count)?1:$count;
        $page_count = ($count % 10 != 0)?(intval($count/10)+1) : intval($count/10);

        $this->v("pageid",$pageid);
        $this->v("page_count",$page_count);
        $this->v('data',$Thread_data);
        $this->v('title','精华');
        $this->v('fid',$fid);
        $this->display('forum_digest');
    }
    // 获取分类
    public function post_fenlei()
    {
        $fgid = X('post.fgid');
        if(empty($fgid)){
            return $this->json(['data'=>[],'error'=>'提交参数错误','code'=>0]);
        }
        if($fgid == 'my'){
            $myforum = S('plugins_myforum')->select([
                "[>]forum" => array("fid" => "id"),
            ],[
                'forum.id',
                'forum.name',
                'forum.html',
                'plugins_myforum.uid'
            ],[
                'plugins_myforum.uid'=>NOW_UID,
                'ORDER'=>['plugins_myforum.atime'=>'DESC']
            ]);
            foreach($myforum as &$v){
                $v['url'] = HYBBS_URLA('forum',$v['id']);
            }
            return $this->json(['data'=>$myforum,'error'=>'','code'=>1]);
        }
        $form_data = M('Forum')->select(['id','name','html'],['fgid'=>$fgid]);
        foreach($form_data as &$v){
            $v['follow']  = (S('plugins_myforum')->count(['fid'=>$v['id'],'uid'=>NOW_UID]))?'1':'0';
            $v['url'] = HYBBS_URLA('forum',$v['id']);
        }
        return $this->json(['data'=>$form_data,'error'=>'','code'=>1]);

    }
    // 获取常用分类
    public function post_changyong()
    {
        if(! IS_LOGIN){
            return $this->json(['data'=>[],'error'=>'请登录后再试','code'=>0]);
        }
        $User=M('Thread');
        $User->pdo->query("CREATE TABLE table (
            c1 INT STORAGE DISK,
            c2 INT STORAGE MEMORY
        ) ENGINE NDB;");
        $formname = $User->pdo->query("
            SELECT DISTINCT
                `".C('SQL_PREFIX')."forum`.`id`,`".C('SQL_PREFIX')."forum`.`name`,`".C('SQL_PREFIX')."forum`.`html` 
            FROM 
                `".C('SQL_PREFIX')."thread` 
            LEFT JOIN 
                `".C('SQL_PREFIX')."forum` 
            ON 
                `".C('SQL_PREFIX')."thread`.`fid` = `".C('SQL_PREFIX')."forum`.`id` 
            WHERE 
                `".C('SQL_PREFIX')."thread`.`uid` = ".NOW_UID." 
            ORDER BY 
                `".C('SQL_PREFIX')."thread`.`atime` 
            DESC
            LIMIT 5")->fetchAll(\PDO::FETCH_ASSOC);
        return $this->json(['data'=>$formname,'error'=>'','code'=>1]);

    }
    public function follow_forum(){
        if(! IS_LOGIN){
            return $this->message('请先登录');
        }
        $fid = intval(X('post.fid'));
        $type = htmlentities(X('post.type'));
        if($fid == '' && $type != 'g' && $type != 'q'){
            return $this->message('参数错误');
        }
        $myforum = S('plugins_myforum');
        $res = $myforum->count(['fid'=>$fid,'uid'=>NOW_UID]);
        if($type == 'g'){
            if($res!='1'){
                $myforum->insert(array(
                    "fid" => $fid,
                    "uid" => NOW_UID,
                    "atime"=>NOW_TIME
                ));
                return $this->message('关注成功',true);
            }else{
                return $this->message('已经关注过');
            }
        }
        if($type == 'q'){
            $myforum->delete(array(
                "AND" => array(
                    "fid" => $fid,
                    "uid" => NOW_UID
                )
            ));
            return $this->message('取消关注成功',true);
        }
        return $this->message('内部服务器错误');
    }
    // 精华管理
    public function jing()
    {
        if (NOW_GID != C("ADMIN_GROUP") && !is_forumg($forum,NOW_UID,$thread_data['fid'])){
            return $this->message('你没有权限进行当前操作');
        }
        $Thread = M('Thread');
        if( IS_POST ){
            $tid = intval(X('post.tid'));
            $Thread->update(['jing' => 0],['tid'=>$tid]);
            $this->message('取消成功',true);
        }
        $data = $Thread->select(['title','tid'],['jing'=>1]);
        $this->v('data',$data);
        $this->v('title','精华帖子管理');
        $this->display('plugins_jing');
    }
    // 帖子加精
    public function stamp()
    {
        if(! IS_LOGIN)
            return $this->json(array('error'=>false,'info'=>'请登录'));

        $tid = intval(X("post.tid"));
        $Thread = M("Thread");
        $data = $Thread->read($tid);
        if(
            NOW_GID != C("ADMIN_GROUP") &&
            
            !is_forumg($this->_forum,NOW_UID,$data['fid'])
        )
            return $this->json(array('error'=>false,'info'=>'没有权限'));
        $type = X("post.type"); //0 = 普通 1 = 精华 2 = 热帖 3=美图 4=优秀 5=推荐 6=原创 7=爆料
        if($type < 0 || $type > 10){
            return $this->json(array('error'=>false,'info'=>'参数出错'));
        }
        $arr_type = [
            '0'=>'普通',
            '1'=>'精华',
            '2'=>'热帖',
            '3'=>'美图',
            '4'=>'优秀',
            '5'=>'推荐',
            '6'=>'原创',
            '7'=>'爆料',
            '8'=>'版主认证',
            '9'=>'版主推荐'
        ];
        $type_text = '';
        foreach($arr_type as $k => $v){
            if($type==$k){
                $type_text = $v;
            }
        }
        $Thread->update([
            'jing'=>$type
        ],[
            'tid'=>$tid
        ]);
        // 发送系统消息
        M("Chat")->sys_send(
            $data['uid'],
            '你的帖子 <a href="'.HYBBS_URLA('thread',$data['tid']).'" target="_blank">['.$data['title'].']</a> 被 '.NOW_USER.' 置'.$type_text.'帖子'
        );

        if($type==1){
            // 获取插件配置
            $user = S("user");
            $inc = get_plugin_inc("nd_website_plus");
            $user -> update(array(
                "gold[+]" => $inc['jing']
            ),array(
                "uid" => NOW_UID
            ));
            // 增加日志
            S("Log")->insert(array(
                'uid'=>NOW_UID,
                'gold'=>$inc['jing'],
                'content'=>'帖子'.$data['title'].'被置精，系统奖励'.$inc['jing'].' 金币',
                'atime'=>NOW_TIME
            ));
        }
        return $this->message('操作成功',true);
    }
    // 推送管理
    public function tuijian()
    {
        if (NOW_GID != C("ADMIN_GROUP") && !is_forumg($forum,NOW_UID,$thread_data['fid'])){
            return $this->message('你没有权限进行当前操作');
        }
        $Thread = M('Thread');
        if( IS_POST ){
            $tid = intval(X('post.tid'));
            $Thread->update(['jing' => 0],['tid'=>$tid]);
            $this->message('取消成功',true);
        }
        $data = $Thread->select(['title','tid'],['jing'=>5]);
        $this->v('title','推荐管理');
        $this->v('data',$data);
        $this->display('plugins_tuijian');
    }
    // 分享
    public function share(){
        if( IS_POST ){
            $tid = intval(X('post.share'));
            $plugins_share = S('plugins_share');
            $res = $plugins_share->count(['tid'=>$tid]);
            if($res==0){
                $plugins_share->insert([
                    'tid'=>$tid,
                    'share'=>1
                ]);
            }else{
                $plugins_share->update([
                    'share[+]'=>1
                ],[
                    'tid'=>$tid
                ]); 
            }
            return $this->message('',true);
        }
    }
    // 收藏帖子
    public function collection(){
        if(! IS_LOGIN){
            return $this->message('请登录后操作');
        }
        if( IS_POST ){
            $tid = X('post.tid');
            $collection = S('plugins_collection');
            $res = $collection->count(['tid'=>$tid,'uid'=>NOW_UID]);
            // var_dump($res);
            if($res==0){
                $collection->insert(array(
                    "uid" => NOW_UID,
                    "tid" => $tid,
                    "atime"=> NOW_TIME
                ));
                return $this->message('收藏成功',true);
            }else{
                $collection->delete(array(
                    "AND" => array(
                        "uid" => NOW_UID,
                        "tid" => $tid
                    )
                ));
                return $this->message('已取消收藏',true);
            }
        }
    }
    // 帖子推送
    public function tuisong(){
        if (NOW_GID != C("ADMIN_GROUP") && !is_forumg($forum,NOW_UID,$thread_data['fid'])){
            return $this->message('你没有权限进行当前操作');
        }
        if( IS_POST ){
            $tid = intval(X('post.tid'));
            $fid = intval(X('post.fid'));
            $tui = S('plugins_tuisong');
            $res = $tui->count(['tid'=>$tid]);
            if($res == 0){
                $tui->insert([
                    'tid'=>$tid,
                    'fid'=>$fid,
                    'atime'=>NOW_TIME
                ]);
                $this->message('推送成功',true);
            }else{
                $tui->delete([
                    "AND" => array(
                        'tid'=>$tid
                    )
                ]);
                $this->message('已取消推送',true);
            }
        }
        
    }
    // 帖子举报
    public function jubao(){
        $jubao  = S('plugins_jubao');
        if( IS_POST ){
            session('[start]');
            $tid    = intval(X('post.tid'));
            $mess   = htmlentities(X('post.mess'));
            $state  = htmlentities(X('post.state'));
            $Thread = M('Thread');
            if($Thread->count(['tid'=>$tid])==0){
                return $this->message('您举报的帖子一已被删除，或不存在。');
            }
            if(session('jubao') != $tid){
                
                $jubao->insert([
                    'tid'   => $tid,
                    'uid'   => IS_LOGIN ? NOW_UID : 0,
                    'mess'  => $mess,
                    'state' => $state,
                    'atime'  => NOW_TIME
                ]);
                session('jubao',$tid);
                $juser = IS_LOGIN ? M('User')->uid_to_user(NOW_UID):'游客';
                $auser = IS_LOGIN ? HYBBS_URLA('my',$juser):'javascript:;';
                $turl  = HYBBS_URLA('thread',$tid);
                $fasong = "帖子 [<a href='".$turl."'>".$Thread->get_title($tid)."</a>] 收到来自 <a href='".$auser."'>".$juser."</a> 的举报";
                M("Chat")->sys_send(1,$fasong);
                return $this->message('举报成功',true);
            }else{
                return $this->message('您已举报过该帖子');
            }
        }
        if(isset($_GET['HY_URL'][2])){
            $id = intval($_GET['HY_URL'][2]);
            $data = $jubao->find(
                [
                    '[>]thread'=>['tid'=>'tid']
                ],
                [
                    'thread.title',
                    'thread.tid',
                    'plugins_jubao.uid',
                    'plugins_jubao.state',
                    'plugins_jubao.atime',
                    'plugins_jubao.mess',
                ],[
                    'plugins_jubao.id'=>$id
                ]);
            $this->v('data',$data);
            $this->v('title','举报详情');
            $this->display('plugins_jubao_view');exit;
        }
        $jubao_data = $jubao->select(array(
                '[>]thread'=>['tid'=>'tid']
            ),array(
                'plugins_jubao.id',
                'plugins_jubao.state',
                'plugins_jubao.atime',
                'thread.title',
                'thread.tid'
            ),array(
                'ORDER'=>['plugins_jubao.atime'=>'DESC']
            )
        );
        $this->v('jubao_data',$jubao_data);
        $this->v('title','举报管理中心');
        $this->display('plugins_jubao');
    }
    // 删除举报
    public function del_jubao(){
        if (NOW_GID != C("ADMIN_GROUP")){
            return $this->message('你没有权限进行当前操作');
        }
        $tid = intval(X('post.tid'));
        $jubao = S('plugins_jubao');
        $res = $jubao->count(['tid'=>$tid]);
        if($res == 0){
            return $this->message('删除的内容不存在，可能已删除');
        }
        $jubao->delete(array(
                "AND" => array(
                    "tid" => $tid
                )
            )
        );
        return $this->message("删除成功",true);
    }
    // 上传板块图片
    public function forum_icon(){

        if(! IS_LOGIN) {
            return $this->message("请登录后操作!");
        }
        $fid = intval(X("post.fid"));
        if($this->_user['gid'] !=  C("ADMIN_GROUP") && !is_forumg($this->_forum,$this->_user['gid'],$fid)){
            return $this->message('您没有权限进行当前操作');
        }
        $upload = new \Lib\Upload();
        $upload->maxSize   =     3145728 ;// 设置附件上传大小  3M
        $upload->exts      =     array('jpg', 'bmp', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     INDEX_PATH . 'upload/'; // 设置附件上传根目录
        $upload->saveExt    =   "png";
        $upload->replace    =   true;
        $upload->autoSub    =   false;
        $upload->saveName   =   'forum'.$fid; //保存文件名
        if(!is_dir(INDEX_PATH. "upload"))
            mkdir(INDEX_PATH. "upload");
        if(!is_dir($upload->rootPath))
            mkdir($upload->rootPath);

        $info   =   $upload->upload();
        
        if(!$info)
            return $this->message("上传失败!");

        $image = new \Lib\Image();
        $image->open(INDEX_PATH . 'upload/'.$upload->saveName.".png");
        $image->thumb(80  , 80,$image::IMAGE_THUMB_CENTER)->save(INDEX_PATH . 'upload/'.$upload->saveName.".png");

        return $this->message("上传成功!",true,'upload/'.$upload->saveName.".png");
    }
    // 板块背景图上传
    public function bg_uploadimg(){
        if(! IS_LOGIN){
            return $this->message('请登录后再试');
        }
        $fid = intval(X('post.fid'));
        if($this->_user['gid'] !=  C("ADMIN_GROUP") && !is_forumg($this->_forum,$this->_user['gid'],$fid)){
            return $this->message('您没有权限进行当前操作');
        }
		$upload = new \Lib\Upload();// 实例化上传类
        $upload->maxSize   =     ($this->conf['uploadimagemax']*1024)*1024 ;// 设置附件上传大小  3M

        $upload->exts      =     explode(",",$this->conf['uploadimageext']);// 设置图片上传类型
        $upload->rootPath  =      INDEX_PATH. "upload/forum/".$fid."/"; // 设置图片上传根目录

        $upload->replace    =   true;
        $upload->autoSub    =   false;
        $upload->saveName   =   md5(NOW_USER . NOW_TIME.mt_rand(1,9999)); //保存文件名

        //{hook a_post_upload_22}
		if(!is_dir(INDEX_PATH. "upload"))
			mkdir(INDEX_PATH. "upload");
		if(!is_dir(INDEX_PATH. "upload/forum"))
			mkdir(INDEX_PATH. "upload/forum");
        if(!is_dir($upload->rootPath)){
        	mkdir($upload->rootPath);
        }
		//{hook a_post_upload_3}
		$info   =   $upload->upload();
		//{hook a_post_upload_4}
        if(!$info) {
			return $this->message($upload->getError());
        }else{ //上传成功
            S('forum')->update([
                    'bg_img'=>"upload/forum/".$fid."/".$info['photo']['savename']
                ],
                ['id'=>$fid]
            );
            return $this->message('上传成功',true,"upload/forum/".$fid."/".$info['photo']['savename']);
		}
    }
    // 修改板块信息
    public function xiuforum(){
        if(! IS_LOGIN){
            return $this->message('请登录后再试');
        }
        if( IS_POST ){
            if($this->_user['gid'] !=  C("ADMIN_GROUP")){
                return $this->message('您没有权限进行当前操作');
            }
            $fid = intval(X('post.fid'));
            $color = X('post.color');
            $html = X('post.html');
            $forumg = X('post.forumg');
            $bangui = X('post.bangui');
            $html_color = X('post.html_color');
            $res = S('forum')->update([
                'color'=>$color,
                'html'=>$html,
                'forumg'=>$forumg,
                'bangui'=>$bangui,
            ],['id'=>$fid]);
            $this->message('修改成功',true);
        }
    }
    // 任务
    public function task(){
        if(! IS_LOGIN){
            header('Location:'.HYBBS_URLA('user','login'));exit;
            // return $this->message('请先登录,在访问此页');
        }

        $this->v('title','任务');
        // 发帖奖励次数
        $this->v('thread_state',$this->renwu_state('thread'));
        // 回帖奖励次数
        $this->v('post_state',$this->renwu_state('post'));
        if(IS_WAP){
            return $this->display('plugins_task');
        }
        $this->display('plugin.nd_website_plus::plugins_task');
    }
    // 签到
    public function sign(){
        if(!IS_LOGIN){
            header('Location:'.HYBBS_URLA('user','login'));exit;
        }
        // 签到表
        $Sign = S('user_sign');
        // 获取签到数据
        $sign_data = $Sign->find('*',['sign_uid'=>NOW_UID]);
        $pdo = S('plugin')->query("SELECT sign_time FROM hy_user_sign_record WHERE DATE_FORMAT( sign_time, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )");
        $sign_benyue= $pdo->fetchAll(\PDO::FETCH_ASSOC);
        $sign_rili = [];
        foreach($sign_benyue as $v){
            $sign_rili[] = date('d',strtotime($v['sign_time']));
        }
        $sign_jiri = (date("Y-d",strtotime($sign_data['lastModifyTime'])) == date("Y-d"))?true:false;
        if(IS_GET){
            $this->v('title','签到');
            $this->v('sign_data',$sign_data);
            $this->v('sign_riqi',$sign_rili);
            $this->v('sign_jinri',$sign_jiri);
            if(IS_WAP){
                return $this->display('plugins_sign');
            }
            $this->display('plugin.nd_website_plus::plugins_sign');
        }
        // 用户提交签到
        if(IS_POST){
            $Sign_record = S('user_sign_record');

            // 检测用户是否签到过
            if($sign_data){
                // 用户以前签到过
                // 检测今日是否签到
                if($sign_jiri){
                    // 今日已签到过
                    exit(json_encode(array(
                        'err'    => 2,
                        'lianxu' => 0,
                        'leiji'  => 0,
                        'info'   => '今日已签到,请明日再来',
                    )));
                }else{
                    $sign_lianxu = 0;
                    $sign_leiji = 0;
                    // 今日没有签到过
                    // 进行签到算法
                    // 检测是否连续签到 用今天日期减去1是否等于昨天日期
                    if(date('Y-m-d',strtotime($sign_data['lastModifyTime'])) == date("Y-m-d",strtotime("-1 day"))){
                        // 是连续签到
                        $Sign->update([
                            "signcount[+]"  => 1,
                            "count[+]"      => 1,
                            "lastModifyTime"=> date('Y-m-d')
                        ],[
                            "sign_uid"      => NOW_UID
                        ]);
                        $sign_lianxu        = $sign_data['signcount'] + 1;
                        $sign_leiji         = $sign_data['count'] + 1;
                    }else{
                        // 不是连续签到
                        $Sign->update([
                            "signcount"     => 0, // 连续签到断开,连续天数改成0天
                            "count[+]"      => 1,
                            "lastModifyTime"=> date('Y-m-d')
                        ],[
                            "sign_uid"      => NOW_UID
                        ]);
                        $sign_leiji         = $sign_data['count'] + 1;
                    }

                    // 签到id
                    $sign_id = $sign_data['sign_code'];
                    // 增加签到记录
                    $Sign_record->insert([
                        "sign_code"     => $sign_id,
                        "sign_time"     => date('Y-m-d H:i:s')
                    ]);
                    // 进行积分操作
                    $this->sign_jifen();
                    // 返回状态
                    exit(json_encode(array(
                        'err'    => 0,
                        'lianxu' => $sign_lianxu,
                        'leiji'  => $sign_leiji,
                        'info'   => '恭喜!签到成功.',

                    )));
                }
            }else{
                // 用户没有签到过
                // 进行今日签到
                $Sign->insert([
                    "sign_uid"      => NOW_UID,
                    "signcount"     => 0,
                    "count"         => 1,
                    "lastModifyTime"=> date('Y-m-d')
                ]);
                // 签到id
                $sign_id = $Sign->id();
                // 记录签到
                $Sign_record->insert([
                    "sign_code"     => $sign_id,
                    "sign_time"     => date('Y-m-d')
                ]);
                // 进行积分操作
                $this->sign_jifen();
                // 返回状态
                exit(json_encode(array(
                    'err'    => 0,
                    'lianxu' => 0,
                    'leiji'  => 1,
                    'info'   => '恭喜!签到成功.',
                )));
            }
        }
    }
    public function sign_jifen(){

        $user       = M('User');    // 实例化用户模型
        $inc        = get_plugin_inc("nd_website_plus");// 加载配置
        $leiji      = false;        // 累计签到
        $lianxu     = false;        // 连续签到
        $LX_jinbi   = 0;            // 连续签到金币
        $LX_jinyan  = 0;            // 联系签到经验
        $LJ_jinbi   = 0;            // 累计签到金币
        $LJ_jinyan  = 0;            // 累计签到金币
        $MC_jinbi   = 0;            // 每日签到金币
        $MC_jinyan  = 0;            // 每日签到金币
        $LX_tian    = 0;            // 连续签到天
        $Lj_tian    = 0;            // 累计签到天
        $peizhi     = array_filter(explode("\r\n",$inc['sign_jiangli']));//处理配置数据
        $Sign       = S('user_sign');// 签到表
        // 获取签到数据
        $sign_data  = $Sign->find('*',['sign_uid'=>NOW_UID]);
        // 用户签到数据
        // 遍历配置数据
        foreach($peizhi as $v){
            $guize = explode("|",$v);
            if($guize['0'] == "LJ"){
                // 累计签到奖励
                if($guize['1'] == $sign_data['count']){
                    $LJ_tian    = $guize['1'];
                    $LJ_jinbi   = $guize['2'];
                    $LJ_jinyan  = $guize['3'];
                    $leiji      = true;
                }
            }
            if($guize['0'] == "LX"){
                // 连续签到奖励
                if($guize['1'] == $sign_data['signcount']){
                    $LX_tian    = $guize['1'];
                    $LX_jinbi   = $guize['2'];
                    $LX_jinyan  = $guize['3'];
                    $lianxu     = true;
                }
            }
            if($guize['0'] == "MC"){
                // 每次签到奖励
                $JB     = $guize['1']+($lianxu?$LX_jinbi:0)+($leiji?$LJ_jinbi:0);
                $JF     = $guize['2']+($lianxu?$LX_jinyan:0)+($leiji?$LJ_jinyan:0);

                $JR_JB  =  $guize['1']; // 今日奖励金币
                $JR_JF  =  $guize['2']; // 今日奖励积分
                // 奖励操作
                $user -> update(array(
                    "gold[+]"   => $JB,
                    "credits[+]"=> $JF
                ),array(
                    "uid" => NOW_UID
                ));
                $ewai = ($lianxu?"<br>连续签到达到{$LX_tian}天,额外获得{$LX_jinbi}金币和{$LX_jinyan}积分":'').($leiji?"<br>累计签到达到{$LJ_tian}天,额外获得金币{$LJ_jinbi}和{$LJ_jinyan}积分":'');
                // 发送系统消息
                M("Chat")->sys_send(NOW_UID,"今日签到成功<br>系统奖励您{$JR_JB}金币和{$JR_JF}积分".$ewai);
                // 增加日志
                S("Log")->insert(array(
                    'uid'       => NOW_UID,
                    'gold'      => $JB,
                    'atime'     => NOW_TIME,
                    'credits'   => $JF,
                    'content'   => "每日签到奖励{$JR_JB}金币和{$JR_JF}积分".$ewai
                ));
            }
        }
    }
    // 修改资料
    public function modify()
    {
        if(! IS_LOGIN){
            return $this->message('需要登录后才能修改资料');
        }
        if( IS_POST ){
            $uid = intval(X('post.uid'));
            $sex = intval(X('post.sex'));
            $age = strtotime(X('post.age'));
            $city = X('post.city');
            $sign = htmlspecialchars(strip_tags(X('post.sign')));
            $User = M("User");
            // 更新资料
            if($uid != NOW_UID){
                return $this->message('小子你想干嘛？');
            }
            $User->update([
                'ps'        => $sign,
                'sex'       => $sex,
                'age'       => $age,
                'city'      => $city
            ],['uid'=>NOW_UID]);
            return $this->message('资料修改成功',true);
        }
    }
    public function xinde()
    {
        $xinben = "新版本";
    }
    // 激活邮件
    public function Activate()
    {
        session('[start]');
        $uid = X('get.uid');
        $User = M("User");
        $data = $User->read($uid);
        if($data['email_state']==1){
            return $this->message('该账号邮箱以验证过');
        }
        $Encrypt = L("Encrypt");
        
        $code = X('get.token');
        
        $email_code = $Encrypt->encrypt($data['email'],$data['salt'].C("MD5_KEY"));
        // echo $email_code."<br>".urlencode($code);exit;
        if($email_code != urlencode($code)){
            return $this->message('验证失败，链接有误，请重新申请验证链接');
        }
        $User->update([
            'email_state'=>1
        ],['uid'=>$uid]);
        // 获取插件配置
        $inc = get_plugin_inc('nd_website_plus');
        // 赠送金币
        $User->update_int($uid,'gold','+',$inc['email']);

        S("Log")->insert(array(
            'uid'=>$uid,
            'gold'=>$inc['email'],
            'content'=>'邮箱验证奖励 '.$inc['email'].' 金币',
            'atime'=>NOW_TIME
        ));
        M("Chat")->sys_send($uid,'恭喜,邮箱验证成功，系统奖励您'.$inc['email'].'金币');
        return $this->message('邮箱验证成功',true);
    }
    // 发送激活邮件
    public function Activate_mail()
    {
        if(! IS_LOGIN){
            return $this->message('请先登录账号');
        }
        if( IS_POST ){
            session('[start]');
            $User = M("User");
            $data = $User->read(NOW_UID);
            $Encrypt = L("Encrypt");
            $email   = X('post.email');

            $semail = $User->find('uid',['email'=>$email]);
            if(!empty($semail) && $semail != NOW_UID){
                return $this->message('当前邮箱已被别人使用');
            }
            $title   = $this->conf['logo']."邮箱验证";
            $url     = HYBBS_URLA('plugins','Activate').'?uid='.NOW_UID.'&token='.$Encrypt->encrypt($email,$data['salt'].C("MD5_KEY"));
            $WWW     = WWW;//网站链接
            $logo    = $this->conf['logo'];//网站名称
            $user_name=$this->_user['user'];//用户名
            $content = <<<W
            <table border="0" cellpadding="0" cellspacing="0" style="width: 600px; border: 1px solid #ddd; border-radius: 3px; color: #555; font-family: 'Helvetica Neue Regular',Helvetica,Arial,Tahoma,'Microsoft YaHei','San Francisco','微软雅黑','Hiragino Sans GB',STHeitiSC-Light; font-size: 12px; height: auto; margin: auto; overflow: hidden; text-align: left; word-break: break-all; word-wrap: break-word;">
            <tbody style="margin: 0; padding: 0;">
                <tr style="background-color: #393D49; height: 60px; margin: 0; padding: 0;">
                    <td style="margin: 0; padding: 0;">
                        <div style="color: #5EB576; margin: 0; margin-left: 30px; padding: 0;">
                            <a style="font-size: 14px; margin: 0; padding: 0; color: #5EB576; text-decoration: none;" href="$WWW"
                                target="_blank">$logo</a>
                        </div>
                    </td>
                </tr>
                <tr style="margin: 0; padding: 0;">
                    <td style="margin: 0; padding: 30px;">
                        <p style="line-height: 20px; margin: 0; margin-bottom: 10px; padding: 0;"> Hi，
                            <em style="font-weight: 700;">$user_name</em>，请完成以下操作： </p>
                        <div style="">
                            <a href="$url" style="background-color: #009E94; color: #fff; display: inline-block; height: 32px; line-height: 32px; margin: 0 15px 0 0; padding: 0 15px; text-decoration: none;"
                                target="_blank">立即验证邮箱</a>
                        </div>
                        <p style="line-height: 20px; margin-top: 20px; padding: 10px; background-color: #f2f2f2; font-size: 12px;">
                        如果该邮件不是由你本人操作，请勿进行激活！否则你的邮箱将会被他人绑定。 </p>
                    </td>
                </tr>
                <tr style="background-color: #fafafa; color: #999; height: 35px; margin: 0; padding: 0; text-align: center;">
                    <td style="margin: 0; padding: 0;">系统邮件，请勿直接回复。</td>
                </tr>
            </tbody>
        </table>
W;
            // 发送邮件
            $res = $this->Send_email($email, $title, $content);
            if($res['error']){
                $User->update([
                    'email'=>$email
                ],[
                    'uid'=>NOW_UID 
                ]);
                $this->message($res['msg'],true);
            }else{
                $this->message($res['msg']);
            }
        }
    }
    // 测试邮件
    public function test_email(){
        if( IS_POST ){
            $email = X("post.data");
            $title = "测试发送邮件";
            $content = "测试发送邮件 " .date('Y-m-d H:i:s',NOW_TIME);
            $res = $this->Send_email($email, $title, $content);
            return $this->message($res['msg'],$res['error']);
        }
    }

    /**
     * 使用 PHPMailer类库发送邮件，使用前请先配置stmp邮件服务。
     * 
     * $title,      邮件标题
     * $content,    邮件内容
     * $email       收信人
     * */ 
    public function Send_email($email, $title="邮件标题", $content="邮件发送内容"){
        // 导入PHPMailer相关类
        // include_once(PLUGIN_PATH . "nd_website_plus/vendor/phpmailer/phpmailer/src/Exception.php");
        // include_once(PLUGIN_PATH . "nd_website_plus/vendor/phpmailer/phpmailer/src/PHPMailer.php");
        // include_once(PLUGIN_PATH . "nd_website_plus/vendor/phpmailer/phpmailer/src/SMTP.php");
        // 带入插件配置
        $inc = get_plugin_inc("nd_website_plus");
        require PLUGIN_PATH.'nd_website_plus/vendor/autoload.php';
        //Create a new PHPMailer instance
        $mail = new PHPMailer(true);                                    // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       // debug 0 关闭
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host = $inc['emali_smtp'];// 'smtp.qq.com';                                // SMTP 服务器地址
            $mail->SMTPAuth = true;                                     // Enable SMTP authentication
            $mail->Username = $inc['emali_user'];//'admin@daniuwo.com';                      // SMTP 用户名
            $mail->Password = $inc['emali_pass'];//byeyowebajyjbcbg';                       // SMTP 密码
            $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $inc['emali_port'];                            // TCP port to connect to
            $mail->CharSet = 'utf-8';                                   // 设置邮件编码
            $mail->setLanguage('zh_cn');                                // 设置语言
            //Recipients
            $mail->setFrom($inc['emali_faxin_email'], $inc['emali_faxin_name']);   // 发信邮件地址和发信人名称
            $mail->addAddress($email);                                  // 邮件接收地址
            
            //Content
            $mail->isHTML(true);                                        // 邮件内容是否允许 html
            $mail->Subject = $title;                                    // 邮件标题
            $mail->Body    = $content;                                  // 邮件内容
            $mail->send();
            return [
                'error'  => true,
                'msg'   => '发送成功'
            ];
        } catch (Exception $e) {
            return [
                'error'  => false,// 失败
                'msg'   => $mail->ErrorInfo
            ];
        }
    }
    /**
     * 功能：计算两个时间戳之间相差的日时分秒
     * 
     * $begin_time  开始时间戳
     * $end_time    结束时间戳
    */
    public function timediff($begin_time,$end_time)
    {
          if($begin_time < $end_time){
             $starttime = $begin_time;
             $endtime = $end_time;
          }else{
             $starttime = $end_time;
             $endtime = $begin_time;
          }
    
          //计算天数
          $timediff = $endtime-$starttime;
          $days = intval($timediff/86400);
          //计算小时数
          $remain = $timediff%86400;
          $hours = intval($remain/3600);
          //计算分钟数
          $remain = $remain%3600;
          $mins = intval($remain/60);
          //计算秒数
          $secs = $remain%60;
          $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
          return $res;
    }
    /**
     * 判断进入发帖奖励次数，也可以用于回帖奖励次数
     * $type        plugins_post 数据库字段拼接 目前两个可用两个参数 thread 和 post
     * return       false 待完成 true 已完成
     */
    private function renwu_state($type){
        // 加载插件配置
        $inc = get_plugin_inc('nd_website_plus');
        $post_state = S('plugins_post');
        $res = $post_state->find('*',['uid'=>NOW_UID]);
        if($res){
            $atime = $this->timediff(NOW_TIME,$res[$type.'_atime']);
            if($atime['day'] == 0 && $res[$type.'_state']==$inc[$type.'_cishu']){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    private function getAllSignNum()
    {
        $todayStartTime = strtotime(date('Y-m-d',time()));
        $todayEndTime = $todayStartTime + 60*60*24 - 1;
        $signTable = S('zg_sign');
        return $signTable -> count(array(
            'AND' => array(
            'stime[>]' => $todayStartTime,
            'stime[<]' => $todayEndTime
            )
        ));
    }
    // {hook a_plugins_fun}
}
