<?php

//Hook ##START##a:3:{s:11:"plugin_name";s:16:"SMTP邮件发送";s:8:"dir_name";s:8:"smtpmail";s:4:"path";s:56:"/www/wwwroot/mh.87sms.cn/Plugin/smtpmail/re/a_User_b.php";}##

//<?php
namespace Action;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Hook ##END##a:3:{s:11:"plugin_name";s:16:"SMTP邮件发送";s:8:"dir_name";s:8:"smtpmail";s:4:"path";s:56:"/www/wwwroot/mh.87sms.cn/Plugin/smtpmail/re/a_User_b.php";}##

use HY\Action;
!defined('HY_PATH') && exit('HY_PATH not defined.');
class User extends HYBBS {
    public $menu_action;
    public function __construct(){
		parent::__construct();
        
        $this->view = IS_MOBILE ? $this->conf['wapuserview2'] : $this->conf['userview2'];
    }
    public function _no(){
        header("location: ".WWW);
        exit;
    }
    //消息跳转 设置已读 
    public function mess(){
        
        if(!IS_LOGIN)
            return $this->message('请登录');
        
        $id = intval(X("get.id") );
        if(empty($id))
            return $this->message('ID参数不完整');
        
        $Mess = M("Mess");
        $data = $Mess->read($id);
        if(empty($data))
            return $this->message('不存在该消息');
        if($data['uid'] != NOW_UID)
            return $this->message('这条消息不属于你');
        
        //设置已读
        if(!$data['view']) //如果是未读状态
        {
            $Mess->set_state($id);
            //未读消息 -1
            M("User")->update_int($data['uid'],'mess',"-");
        }
        

        header("location: ". HYBBS_URLA('thread',$data['tid']) );
        exit;
    }
    public function Edit(){
        
        if(!IS_LOGIN)
            return $this->message('请登录');

        $gn = X('post.gn');
        if($gn == 'ps'){
            $ps = htmlspecialchars(strip_tags(X("post.ps")));
            $char = "。、！？：；﹑•＂…‘’“”〝〞∕¦‖—　〈〉﹞﹝「」‹›〖〗】【»«』『〕〔》《﹐¸﹕︰﹔！¡？¿﹖﹌﹏﹋＇´ˊˋ―﹫︳︴¯＿￣﹢﹦﹤‐­˜﹟﹩﹠﹪﹡﹨﹍﹉﹎﹊ˇ︵︶︷︸︹︿﹀︺︽︾ˉ﹁﹂﹃﹄︻︼（）";
            $pattern = array(
                "/[[:punct:]]/i", //英文标点符号
                '/['.$char.']/u', //中文标点符号
                '/[ ]{2,}/'
            );
            $ps = preg_replace($pattern, ' ', $ps);
            
            if(!empty($ps)){
                S("User")->update(array(
                    'ps'=>$ps
                ),[
                    'uid'=>NOW_UID
                ]);
                return $this->message('保存成功',true);
            }
        }elseif($gn == 'pass'){
            $pass0 = X("post.pass0");
            $pass1 = X("post.pass1");
            $pass2 = X("post.pass2");
            
            if($pass1 != $pass2)
                return $this->message("两次密码不一致");
            $UserLib = L("User");
            if(!$UserLib->check_pass($pass1))
                return $this->message('密码不符合规则');
            
            if($UserLib->md5_md5($pass0,$this->_user['salt']) != $this->_user['pass'])
                return $this->message('原密码不正确');
            $newpass = $UserLib->md5_md5($pass1,$this->_user['salt']);
            $this->_user['pass'] = $newpass;
            S("User")->update(array(
                'pass'=>$this->_user['pass']
            ),[
                'uid'=>NOW_UID
            ]);
            
            cookie('HYBBS_HEX',$UserLib->set_cookie($this->_user));
            return $this->message("修改成功",true);
        }elseif ($gn == 'edit_username'){
            if(!$this->conf['on_edit_user'])
                return $this->message('管理员已关闭修改用户名功能!');
            $username = trim(X('post.username'));
            if (empty($username)){
                return $this->message('用户名不能为空!');
            }
            $userModel = M("User");
            if($userModel->is_user($username)){
                return $this->message('该用户名以存在!');
            }
            $UserLib = L("User");
            $msg = $UserLib->check_user($username);
            //检查用户名格式是否正确
            if(!empty($msg))
                return $this->message($msg);

            

            $userModel->update(array(
                'user'=>$username
            ),[
                'uid'=>NOW_UID
            ]);
            $this->_user['user'] = $username;
            cookie('HYBBS_HEX',$UserLib->set_cookie($this->_user));
            $encode = mb_detect_encoding($username, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
            $username = mb_convert_encoding($username, 'UTF-8', $encode);
            return header("Location: " . HYBBS_URLA('my',$username,'op'));
        }

        
        return $this->message("提交出错");
        

    }


    //找回密码
    public function repass(){
        
        $this->v("title","找回密码");
        // if(IS_LOGIN)
        //     return $this->message("你已经登录,请注销后找回密码?");
        
        if(IS_GET){
            
            $this->display('user_repass');
        }elseif(IS_POST){
            $gn = X('post.gn');
            if($gn == 'has'){//判断账号是否存在
                $user = X('post.user');

                $User = M("User");
                if(!$User->is_user($user))
                    $this->json(['error'=>false,'info'=>'您提交的账号，尚未注册！']);

                $this->json(['error'=>true,'info'=>'true']);
            }elseif($gn == 'get_safe_info'){ //获取账号安全信息
                $type = X('post.type');
                $user = X('post.user');

                $User = M("User");
                $user_data = $User->user_read($user);
                if(empty($user_data))
                    $this->json(['error'=>false,'info'=>'您提交的账号，尚未注册！']);

                if($type == 'email'){
                    if(empty($user_data['email']))
                        $this->json(['error'=>false,'info'=>'安全邮箱为空，不能使用邮箱进行找回密码！']);
                    $this->json(['error'=>true,'info'=>hideStar($user_data['email'])]);
                }
                $this->json(['error'=>false,'info'=>'没有找到相关找回方式！']);

            }elseif($gn == 'send_code'){ //发送验证码
                $type = X('post.type');
                $user = X('post.user');

                $User = M("User");
                $user_data = $User->user_read($user);
                if(empty($user_data))
                    $this->json(['error'=>false,'info'=>'您提交的账号，尚未注册！']);

                if($type == 'email'){
                    if(empty($user_data['email']))
                        $this->json(['error'=>false,'info'=>'安全邮箱为空，不能使用邮箱进行找回密码！']);
                    //开始发送验证码
                    $emailhost = $this->conf['emailhost'];
                    $emailport = $this->conf['emailport'];
                    $emailuser = $this->conf['emailuser'];
                    $emailpass = $this->conf['emailpass'];

                    if(empty($emailhost) || empty($emailport))
                        $this->json(['error'=>false,'info'=>'网站没开启邮箱功能,请联系网站管理员']);
               
                    $cache = cache('email_verify_code_' . $user_data['uid']);
                    if(empty($cache)){
                        $cache=[
                            'code'  => '',  //验证码
                            'expire'=> 0,   //下次允许发送时间
                            'try_i' => 10   //允许尝试验证码次数
                        ];
                    }

                    if($cache['expire'] > NOW_TIME)
                        $this->json(['error'=>false,'info'=>($cache['expire'] - NOW_TIME). '秒后才能发送验证码.']);

                    $cache['code'] = rand_code(6);
                    $Email = L("Email");
                    $Encrypt = L("Encrypt");
                    $Email->init($emailhost,$emailport,true,$emailuser,$emailpass);

                    if(!$Email->sendmail($user_data['email'],$emailuser,$this->conf['emailtitle'],sprintf($this->conf['emailcontent'],$user_data['user'],$cache['code']),'HTML'))
                        $this->json(['error'=>false,'info'=>'发送失败,具体原因:'.$Email->error_mess]);

                    $cache['expire'] = NOW_TIME + BBSCONF('send_email_s');

                    cache('email_verify_code_' . $user_data['uid'], $cache, 300);

                    cookie('HY_EMAIL',$Encrypt->encrypt($user_data['uid'],$user_data['salt'].C("MD5_KEY")),300);

                    $this->json(['error'=>true,'info'=>'验证码已发送至：'.hideStar($user_data['email']),'next_s'=>BBSCONF('send_email_s')]);
                }

                $this->json(['error'=>false,'info'=>'发送失败，找回方式参数不存在！']);

            }elseif($gn == 'verify_code'){
                $type = X('post.type');
                $user = X('post.user');

                $User = M("User");
                $user_data = $User->user_read($user);
                if(empty($user_data))
                    $this->json(['error'=>false,'info'=>'您提交的账号，尚未注册！']);

                if($type == 'email'){
                    $cookie = cookie("HY_EMAIL");
                    if(empty($cookie))
                        $this->json(['error'=>false,'info'=>'验证码已经过期,请获取新验证码！']);

                    $Encrypt = L("Encrypt");
                    $uid = $Encrypt->decrypt($cookie,$user_data['salt'].C("MD5_KEY"));
                    if($uid != $user_data['uid']){
                        $this->json(['error'=>false,'info'=>'参数被篡改，请刷新页面重试！']);
                    }

                    $cache = cache('email_verify_code_' . $uid);
                    if(empty($cache)){
                        $this->json(['error'=>false,'info'=>'验证码已经过期,请获取新验证码！']);
                    }

                    $code = X('post.code');
                    if($cache['try_i'] <= 0){
                        cache('email_verify_code_' . $uid,null);
                        cookie('HY_EMAIL',null);
                        $this->json(['error'=>false,'info'=>'多次提交错误验证码，请重新获取验证码！']);
                    }

                    

                    if($code != $cache['code']){
                        $cache['try_i']-=1;
                        cache('email_verify_code_' . $uid, $cache, 300);
                        $this->json(['error'=>false,'info'=>'验证码错误！'.$cache['try_i']]);
                    }

                    $this->json(['error'=>true,'info'=>'验证码正确']);
                }

                $this->json(['error'=>false,'info'=>'验证失败，验证参数不存在！']);

            }elseif($gn == 'change'){
                $type = X('post.type');
                $user = X('post.user');

                $User = M("User");
                $user_data = $User->user_read($user);
                if(empty($user_data))
                    $this->json(['error'=>false,'info'=>'您提交的账号，尚未注册！']);

                $adopt = false;
                if($type == 'email'){
                    $cookie = cookie("HY_EMAIL");
                    if(empty($cookie))
                        $this->json(['error'=>false,'info'=>'验证码已经过期,请获取新验证码！']);

                    $Encrypt = L("Encrypt");
                    $uid = $Encrypt->decrypt($cookie,$user_data['salt'].C("MD5_KEY"));
                    if($uid != $user_data['uid']){
                        $this->json(['error'=>false,'info'=>'参数被篡改，请刷新页面重试！']);
                    }

                    $cache = cache('email_verify_code_' . $uid);
                    if(empty($cache)){
                        $this->json(['error'=>false,'info'=>'验证码已经过期,请获取新验证码！']);
                    }

                    $code = X('post.code');
                    if($cache['try_i'] <= 0){
                        cache('email_verify_code_' . $uid,null);
                        cookie('HY_EMAIL',null);
                        $this->json(['error'=>false,'info'=>'多次提交错误验证码，请重新获取验证码！']);
                    }

                    if($code != $cache['code']){
                        $cache['try_i']-=1;
                        cache('email_verify_code_' . $uid, $cache, 300);
                        $this->json(['error'=>false,'info'=>'验证码错误！'.$cache['try_i']]);
                    }
                    $adopt = true;
                    cache('email_verify_code_' . $uid,null);
                    cookie('HY_EMAIL',null);
                }

                if(!$adopt) //验证通过
                    $this->json(['error'=>false,'info'=>'验证不通过']);

                $pass1=X("post.pass1");
                $pass2=X("post.pass2");
                if(empty($pass1)||empty($pass2))
                    $this->json(['error'=>false,'info'=>'参数不完整,请填写好表单!']);
                if($pass1 != $pass2)
                    $this->json(['error'=>false,'info'=>'确认新密码不一致！']);

                $UserLib = L("User");
                if(!$UserLib->check_pass($pass1))
                    $this->json(['error'=>false,'info'=>'新密码不符合规则,必须大于等于5位']);


                $User->update([
                    'pass'=>L("User")->md5_md5($pass1,$user_data['salt'])
                ],[
                    'uid'=>$user_data['uid']
                ]);
                $this->json(array('error'=>true,'info'=>'修改成功.'));
                

            }
            $this->json(['error'=>false,'info'=>'参数错误！']);
        }
    }
    //提交更改密码
    public function recode2(){
        
        $email = X("post.email");
        $code = strtoupper(X("post.code"));
        $pass1=X("post.pass1");
        $pass2=X("post.pass2");
        
        if(empty($email)||empty($code)||empty($pass1)||empty($pass2))
            $this->json(array('error'=>false,'info'=>'参数不完整,请填写好表单!'));
        if($pass1 != $pass2)
            $this->json(array('error'=>false,'info'=>'确认密码不一致'));
        
        $UserLib = L("User");
        if(!$UserLib->check_pass($pass1))
            $this->json(array('error'=>false,'info'=>'新密码不符合规则,必须大于等于5位'));
        
        $User = M("User");

        if(!$User->is_email($email))
            $this->json(array('error'=>false,'info'=>'邮箱不存在!'));
        $data = $User->email_read($email);
        if(empty($data))
            $this->json(array('error'=>false,'info'=>'邮箱不存在.'));
        
        if(strlen($code) != 6)
            $this->json(array('error'=>false,'info'=>'验证码是6位的.'));
        
        $cookie = cookie("HY_EMAIL");
        if(empty($cookie))
            $this->json(array('error'=>false,'info'=>'验证码已经过期,请获取新验证码,紧急请联系管理员.'));

        
        $Encrypt = L("Encrypt");
        $cr = $Encrypt->decrypt($cookie,$data['salt'].C("MD5_KEY"));
        if($cr != $code)
            $this->json(array('error'=>false,'info'=>'验证码错误.'));
        
        $User->update(array('pass'=>L("User")->md5_md5($pass1,$data['salt'])),array('uid'=>$data['uid']));
        cookie('HY_EMAIL',null);
        $this->json(array('error'=>true,'info'=>'修改成功.'));


    }
    //发送验证码
    public function recode(){
        
        $email = X("post.email");
        

        $emailhost = $this->conf['emailhost'];
        $emailport = $this->conf['emailport'];
        $emailuser = $this->conf['emailuser'];
        $emailpass = $this->conf['emailpass'];
        

        if(empty($emailhost) || empty($emailport))
            $this->json(array('error'=>false,'info'=>'网站没开启邮箱功能,请联系网站管理员'));
        
        $User = M("User");
        if(!$User->is_email($email))
            $this->json(array('error'=>false,'info'=>'该邮箱不存在!'));
        
        $data = $User->email_read($email);
        if(empty($data))
            $this->json(array('error'=>false,'info'=>'该邮箱不存在.'));
        
        if($data['etime'] > NOW_TIME)
            $this->json(array('error'=>false,'info'=>($data['etime'] - NOW_TIME). '秒后才能发送验证码.'));

        
        $code = rand_code(6);

        $Email = L("Email");

        $Encrypt = L("Encrypt");

        
        $Email->init($emailhost,$emailport,true,$emailuser,$emailpass);


//Hook ##START##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:63:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/re/a_User_2.php";}##
//<?php
		$userdata = sprintf($this->conf['emailcontent'],$data['user'],$code);
        $hosttitle = $this->conf['title'];//网站标题 
        $hosturl = WWW;//网站url
        $emailneir = <<<dsds
<div id="mailContentContainer" style="padding: 0px;height: auto;min-height: auto;font-family: Hiragino Sans GB,Microsoft YaHei,Helvetica Neue;">
    <div style="background:#ececec;padding:35px;">
        <table cellpadding="0" align="center" width="600" style="background:#fff;width:600px;margin:0 auto;text-align:left;position:relative;border-radius:5px;font-size:14px;line-height:1.5;box-shadow:0 0 5px #999999;border-collapse:collapse;">
            <tbody>
                <tr>
                    <th valign="middle" style="height:25px;color:#fff; font-size:14px;line-height:25px; font-weight:bold;text-align:left;padding:15px 35px; border-bottom:1px solid #467ec3;background:#518bcb;border-radius:5px 5px 0 0;">
                        <span style="float:left; width: 120px;font-size: 28px;color: #fff;">
                            $hosttitle
                        </span>
                        <span style="font-size: 12px;margin-left: -30px;background-color: #55BAF1;padding: 0 5px;border-radius: 5px;border-top-width: -5;color: #fff;">
                            <a href="$hosturl" style="color:#FFF;text-decoration: none;">$hosturl</a>
                        </span>
                    </th>
                </tr>
                <tr>
                    <td>
                        <div style="padding:35px 35px 40px;"><h2 style="font-weight:normal; font-size:14px;margin:5px 0;"><div><strong>尊敬的用户：</strong></div><p style="color:#313131;line-height:28px;font-size:14px;margin:20px 0 0 0;">您好！收到这封邮件，是由于在 $hosttitle 进行了用户密码找回。如果不是您操作的，请忽略这封邮件。您不需要退订或进行其他进一步的操作。</p><br><div style="padding: 3px;background: #3CBAAE;text-align: center;font-size: 16px;"><font style="color: #fff;">以下是您的用户信息</font></div><div style="text-align: center;width: 488px;font-size: 12px;padding: 10px 20px;border-left: 1px solid #E9E9E9;border-bottom: 1px solid #E9E9E9;border-right: 1px solid #E9E9E9;"><h1 style="word-wrap: break-word;word-break:normal;color: #00BCD4;">$userdata</h1></div><div></div><p style="color:#999; margin:26px 0 0 0; font-size:12px;">感谢您的访问，祝您使用愉快！<span style="background:#ddd;height:1px;width:100%;overflow:hidden;display:block;margin:8px 0;"></span>Powered by $hosttitle 管理团队.<br></p></h2></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
dsds;
        // $flag = $this->sendMail($email,$this->conf['emailtitle'],$emailneir);
        $flag = A('Plugins')->Send_email($email, $this->conf['emailtitle'], $emailneir);

        if(!$flag['error']){
            $this->json(['error'=>$flag['error'],"info"=>$flag['msg']]);
    	}
//Hook ##END##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:63:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/re/a_User_2.php";}##

        cookie('HY_EMAIL',$Encrypt->encrypt($code,$data['salt'].C("MD5_KEY")),300); //有效期5分钟
        $User->update(['etime'=>NOW_TIME+BBSCONF('send_email_s')],['uid'=>$data['uid']]);
        $this->json(['error'=>true,'info'=>'发送成功!']);
        

    }

    //登录账号
    public function Login(){
        
        $this->v("title","登录页面");
        if(IS_LOGIN)
            return $this->message("您已登录，请勿多次提交！");

        if(IS_GET){
            
            $re_url = X("server.HTTP_REFERER");
            if($re_url=='')
                $re_url=WWW;
            if(strpos($re_url,WWW)!= -1 && strpos($re_url,'user')===false)
                cookie('re_url',$re_url);
            
            $this->display('user_login');
        }
        elseif(IS_POST){            
            $user = X("post.user");
            $pass = X("post.pass");

            $UserLib = L("User");
            

            //$msg = $UserLib->check_user($user);
            //检查用户名格式是否正确
            //if(!empty($msg))
                //return $this->message($msg);

            if(!$UserLib->check_pass($pass))
                return $this->message('密码不符合规则');
            
            $User = M("User");
            if(!$User->is_user($user))
                return $this->message("账号不存在!");

            $data = $User->user_read($user);
            
            if(!empty($data)){
                
                //密码正确
                if($data['pass'] == $UserLib->md5_md5($pass,$data['salt'])){//登录成功
                    if($data['ban_login']){
                        return $this->message("账号已经被管理员锁定，禁止登陆!");
                    }
                    $Friend = S("Friend");
                    $sum = $Friend->sum("c",array('uid1'=>$data['uid']));
                    M("Chat_count")->update(array('c'=>$sum),array('uid'=>$data['uid']));

                    
                    //更新用户所有缓存 一个星期更新缓存
                    if($data['ctime']+(86400*7) < NOW_TIME){

                        $count1 = $Friend->count(array('AND'=>array('uid1'=>$data['uid'],'OR'=>array('state'=>array(1,2)))));
                        $count2 = $Friend->count(array('AND'=>array('uid2'=>$data['uid'],'OR'=>array('state'=>array(1,2)))));

                        $User->update([
                            'ctime'=>NOW_TIME,
                            'threads'=>S("Thread")->count(['uid'=>$data['uid']]),
                            'posts'=>S("Post")->count(['uid'=>$data['uid']]),
                            'post_ps'=>S("Post_post")->count(['uid'=>$data['uid']]),
                            'follow'=>$count1,
                            'fans'=>$count2,
                        
                        ],[
                            'uid'=>$data['uid']
                        ]);
                    }
                   
                    
                    //在线用户结束
                    cookie('HYBBS_HEX',$UserLib->set_cookie($data));
                    $this->init_user();
                    
                    $re_url = cookie('re_url');
                    if($re_url=='')
                        $re_url='';
                    cookie('re_url',null);
                    return $this->message("登录成功 !",true,$re_url);
                }else{
                    
                    return $this->message("密码错误!");
                }
            }else{
                return $this->message('账号数据不存在!');
            }
        }
        
    }
    //注册账号
    public function Add(){
        

        $this->v("title","注册用户");
        if(IS_LOGIN)
            return $this->message("您已登录，如需注册新账号，请退出本当前账号再次访问！");
        if(IS_GET){
            
            $re_url = X("server.HTTP_REFERER");
            if($re_url=='')
                $re_url=WWW;
            if(strpos($re_url,WWW)!= -1 && strpos($re_url,'user')===false)
                cookie('re_url',$re_url);
            $this->display('user_add');
        }
        elseif(IS_POST){
            $user = X("post.user");
            $pass1 = X("post.pass1");
            $pass2 = X("post.pass2");
            $email = X("post.email");
            
            if($pass1 != $pass2)
                return $this->message("两次密码不一致");

            $UserLib = L("User");
            $msg = $UserLib->check_user($user);
            //检查用户名格式是否正确
            if(!empty($msg))
                return $this->message($msg);

            if(!$UserLib->check_pass($pass1))
                return $this->message('密码不符合规则');

            

            $msg = $UserLib->check_email($email);

            if(!empty($msg))
                return $this->message($msg);

            
            $User = M("User");
            if($User->is_user($user))
                return $this->message("账号已经存在!");

            if($User->is_email($email))
                return $this->message("邮箱已经存在!");


            
            $uid = $User->add_user($user,$pass1,$email);

            cookie('HYBBS_HEX',$UserLib->set_cookie($User->read($uid)));
            
//Hook ##START##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:65:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_user_add_v.hook";}##
    //<?php 注册送金币功能
    $inc = get_plugin_inc('nd_website_plus');
    $content = $inc['content'];
    M("Chat")->sys_send($uid,$content);
    $User = M("User");
    if($inc['gold']!= 0){
        $User->update_int($uid,'gold','+',$inc['gold']);
        $User->update_int($uid,'credits','+',$inc['credits_post']);

        S("Log")->insert(array(
            'uid'=>$uid,
            'gold'=>$inc['gold'],
            'credits'=>$inc['credits_post'],
            'content'=>'新注册赠送系统'.$inc['gold'].'金币和'.$inc['credits_post'].'积分',
            'atime'=>NOW_TIME
        ));
    }

//Hook ##END##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:65:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_user_add_v.hook";}##

            $this->_count['user']++;
            $this->_count['day_user']++;
            $this->CacheObj->bbs_count = $this->_count;
            $re_url = cookie('re_url');
            if($re_url=='')
                $re_url='';
            cookie('re_url',null);

            return $this->message("账号注册成功",true,$re_url);
        }
        
    }
    //上传头像
    public function ava(){
        
        $this->v("title","更改头像");
        if(!IS_LOGIN) 
            return $this->message("请登录后操作!");

        

        L("Upload");
        
        $upload = new \Lib\Upload();
        $upload->maxSize   =     3145728 ;// 设置附件上传大小  3M
        $upload->exts      =     array('jpg', 'bmp', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     INDEX_PATH . 'upload/avatar/'; // 设置附件上传根目录
        $upload->saveExt    =   "jpg";
        $upload->replace    =   true;
        $upload->autoSub    =   false;
        $upload->saveName   =   md5(NOW_UID);
        if(!is_dir($upload->rootPath))
            create_dir($upload->rootPath);
        
        $info   =   $upload->upload();
        
        if(!$info)
            return $this->message("上传失败!");

        
        $image = new \Lib\Image();
        $image->open(INDEX_PATH . 'upload/avatar/'.$upload->saveName.".jpg");
        // 生成一个缩放后填充大小150*150的缩略图并保存为thumb.jpg
        $image->thumb(250, 250,$image::IMAGE_THUMB_CENTER)->save(INDEX_PATH . 'upload/avatar/'.$upload->saveName."-a.jpg");
        $image->thumb(150, 150,$image::IMAGE_THUMB_CENTER)->save(INDEX_PATH . 'upload/avatar/'.$upload->saveName."-b.jpg");
        $image->thumb(50  , 50,$image::IMAGE_THUMB_CENTER)->save(INDEX_PATH . 'upload/avatar/'.$upload->saveName."-c.jpg");
        //$image->thumb(150, 150,\Think\Image::IMAGE_THUMB_CENTER)
        
//Hook ##START##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:65:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_user_ava_v.hook";}##
        //<?

        if($this->_user['avatar_state'] == 0){
            $inc = get_plugin_inc('nd_website_plus');
            // 赠送金币
            M('User')->update_int(NOW_UID,'gold','+',$inc['touxiang']);
            // 修改头像状态
            M('User')->update_int(NOW_UID,'avatar_state','+',1);
    
            S("Log")->insert(array(
                'uid'=>NOW_UID,
                'gold'=>$inc['touxiang'],
                'content'=>'首次上传头像奖励 '.$inc['touxiang'].' 金币',
                'atime'=>NOW_TIME
            ));
            M("Chat")->sys_send(NOW_UID,'恭喜,首次上传头像成功，系统奖励您'.$inc['touxiang'].'金币');
        }

//Hook ##END##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:65:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_user_ava_v.hook";}##

        return $this->message("上传成功!",true);

    }
    public function out(){
        
        if(!IS_LOGIN)
            $this->message('退出成功',true);
        
        $this->v("title","注销用户");
        cookie('HYBBS_HEX',null);
        
        $this->init_user();
        $re_url = X("server.HTTP_REFERER");
        if(strpos($re_url,WWW)!= -1 && strpos($re_url,'/user')===false)
            return header("location: ".$re_url);
        
        $this->message('退出成功',true);


    }
    public function isuser(){
        
        $user = X("post.user");
        $bool = M("User")->is_user($user);
        return $this->json(array('error'=>$bool));
    }
    public function isemail(){
        
        $email = X("post.email");
        $bool = M("User")->is_email($email);
        return $this->json(array('error'=>$bool));
    }

    
//Hook ##START##a:3:{s:11:"plugin_name";s:16:"SMTP邮件发送";s:8:"dir_name";s:8:"smtpmail";s:4:"path";s:56:"/www/wwwroot/mh.87sms.cn/Plugin/smtpmail/a_user_fun.hook";}##

    //<?发送邮件功能封装
    public function sendMail($to,$title,$content){

        require PLUGIN_PATH . 'smtpmail/vendor/autoload.php';


        //实例化PHPMailer核心类
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
            //$mail->SMTPDebug = 0;

            //语言设置
            $mail->setLanguage('zh_cn');
            //使用smtp鉴权方式发送邮件
            $mail->isSMTP();

            //smtp需要鉴权 这个必须是true
            $mail->SMTPAuth=true;

            //链接qq域名邮箱的服务器地址
            $mail->Host = $this->conf['emailhost'];

            //设置使用ssl加密方式登录鉴权
            $mail->SMTPSecure = 'ssl';

            //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
            $mail->Port = $this->conf['emailport'];

            //设置smtp的helo消息头 这个可有可无 内容任意
            // $mail->Helo = 'Hello smtp.qq.com Server';

            //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
            $mail->Hostname = WWW;

            //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
            $mail->CharSet = 'UTF-8';

            //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
            $mail->FromName = $this->conf['title'];

            //smtp登录的账号 这里填入字符串格式的qq号即可
            $mail->Username =$this->conf['emailuser'];

            //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
            $mail->Password = $this->conf['emailpass'];

            //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
            $mail->From = $this->conf['emailuser'];

            //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
            $mail->isHTML(true);

            //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
            $mail->addAddress($to,$this->conf['title']);

            //添加多个收件人 则多次调用方法即可
            // $mail->addAddress('xxx@163.com','lsgo在线通知');

            //添加该邮件的主题
            $mail->Subject = $title;

            //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
            $mail->Body = $content;

            //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
            // $mail->addAttachment('./d.jpg','mm.jpg');
            //同样该方法可以多次调用 上传多个附件
            // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

            $status = $mail->send();

            //简单的判断与提示信息
            return ['error'=>true,'msg'=>'发送成功'];
        } catch (Exception $e) {
            return ['error'=>false,'msg'=>$mail->ErrorInfo];
        }
    }

//Hook ##END##a:3:{s:11:"plugin_name";s:16:"SMTP邮件发送";s:8:"dir_name";s:8:"smtpmail";s:4:"path";s:56:"/www/wwwroot/mh.87sms.cn/Plugin/smtpmail/a_user_fun.hook";}##

//Hook ##START##a:3:{s:11:"plugin_name";s:18:"DN_个人资料图";s:8:"dir_name";s:11:"nd_user_img";s:4:"path";s:59:"/www/wwwroot/mh.87sms.cn/Plugin/nd_user_img/a_user_fun.hook";}##
        
public function style(){
    //<?php
        $this->v("title","切换背景图");
        if(!IS_LOGIN) 
            return $this->message("请登录后操作!");

        
        $inc = get_plugin_inc('nd_user_img');
        $user_g =  array_filter(explode(",",$inc['up_groud']));
        foreach($user_g as $v){
            if($v == NOW_GID){
                $this->message("当前用户组不允许上传背景图");exit;
            }
        }
        L("Upload");
        
        $upload = new \Lib\Upload();
        $upload->maxSize   =     3145728 ;// 设置附件上传大小  3M
        $upload->exts      =     array('jpg', 'bmp', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     INDEX_PATH . 'upload/userfile/'.NOW_UID."/"; // 设置附件上传根目录
        $upload->saveExt    =   "jpg";
        $upload->replace    =   true;
        $upload->autoSub    =   false;
        $upload->saveName   =   md5(NOW_USER);
        if(!is_dir(INDEX_PATH. "upload"))
            mkdir(INDEX_PATH. "upload");
        if(!is_dir(INDEX_PATH. "userfile"))
            mkdir(INDEX_PATH. "userfile");
        if(!is_dir($upload->rootPath))
            mkdir($upload->rootPath);
        
        $info   =   $upload->upload();
        // var_dump($info);exit;
        if(!$info)
            return $this->message("上传失败!");

        //上传成功
        $url = WWW .'upload/userfile/'.NOW_UID.'/'.$info['photo']['savename'];
        $user_style = S('user_style');
        $res = $user_style->count(['uid'=>NOW_UID]);
        if($res){
            $user_style->update([
                'uid'=>NOW_UID,
                'img'=>$url
            ]);
        }else{
            $user_style->insert([
                'uid'=>NOW_UID,
                'img'=>$url
            ],['uid'=>NOW_UID]);
        }

        //$image->thumb(150, 150,\Think\Image::IMAGE_THUMB_CENTER)
        
//Hook ##START##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:65:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_user_ava_v.hook";}##
        //<?

        if($this->_user['avatar_state'] == 0){
            $inc = get_plugin_inc('nd_website_plus');
            // 赠送金币
            M('User')->update_int(NOW_UID,'gold','+',$inc['touxiang']);
            // 修改头像状态
            M('User')->update_int(NOW_UID,'avatar_state','+',1);
    
            S("Log")->insert(array(
                'uid'=>NOW_UID,
                'gold'=>$inc['touxiang'],
                'content'=>'首次上传头像奖励 '.$inc['touxiang'].' 金币',
                'atime'=>NOW_TIME
            ));
            M("Chat")->sys_send(NOW_UID,'恭喜,首次上传头像成功，系统奖励您'.$inc['touxiang'].'金币');
        }

//Hook ##END##a:3:{s:11:"plugin_name";s:27:"ND_网站功能增强插件";s:8:"dir_name";s:15:"nd_website_plus";s:4:"path";s:65:"/www/wwwroot/mh.87sms.cn/Plugin/nd_website_plus/a_user_ava_v.hook";}##

        return $this->message("上传成功!",true);
}
public function user_img(){
    if(IS_POST){
        $inc = get_plugin_inc('nd_user_img');
        $user_g =  array_filter(explode(",",$inc['cp_groud']));
        $url = htmlspecialchars(X('post.url'));
        foreach($user_g as $v){
            if($v == NOW_GID){
                $this->message("当前用户组不允许切换背景图");
            }
        }
        $user_style = S('user_style');
        $res = $user_style->count(['uid'=>NOW_UID]);
        if($res){
            $user_style->update([
                'uid'=>NOW_UID,
                'img'=>$url
            ]);
        }else{
            $user_style->insert([
                'uid'=>NOW_UID,
                'img'=>$url
            ],['uid'=>NOW_UID]);
        }
        $this->message("修改成功!",true);
    }
}
//Hook ##END##a:3:{s:11:"plugin_name";s:18:"DN_个人资料图";s:8:"dir_name";s:11:"nd_user_img";s:4:"path";s:59:"/www/wwwroot/mh.87sms.cn/Plugin/nd_user_img/a_user_fun.hook";}##

}
