<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title;?><?php echo $conf['title2'];?></title>
    <meta name="keywords" content="<?php echo $conf['keywords'];?>">
    <meta name="description" content="<?php echo $conf['description'];?>">
    <meta name="author" content="哄着自己玩">
    <!--使用webkit内核-->
    <meta name="renderer" content="webkit">
    <meta name="renderer" content="ie-stand">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="alternate icon" type="image/png" href="<?php echo WWW;?>favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="<?php echo WWW;?>favicon.ico">
    <!-- 引入样式 -->
    <link rel="stylesheet" href="<?php echo WWW;?>View/nd_mobile/css/ydui.css?var=<?php echo ND_MOBILE_V;?>">
    <link href="https://cdn.bootcss.com/Swiper/4.4.2/css/swiper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo WWW;?>View/nd_mobile/css/style.css?var=<?php echo ND_MOBILE_V;?>">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_617807_ce25xljp8w.css">
    <!-- 引入rem自适应类库 -->
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js"></script>
    <script type="text/javascript">
        var www = "<?php echo WWW;?><?php echo RE;?>";
        var WWW = "<?php echo WWW;?>";
        var exp = "<?php echo EXP;?>";
        var action_name = "<?php echo ACTION_NAME;?>";
        var method_name = "<?php echo METHOD_NAME;?>";
        <?php if (IS_LOGIN): ?>
        window.hy_user = "<?php echo NOW_USER;?>";
        window.hy_avatar = "<?php echo $user['avatar']['a'];?>";
        $(function(){tog_friend_box();})
        <?php else: ?>
        window.hy_user = '';
        window.hy_avatar = '';
        <?php endif ?>
        
    </script>
    
    <script type="text/javascript" src="<?php echo WWW;?>hyui/hy.js?var=<?php echo ND_MOBILE_V;?>"></script>
    <script type="text/javascript" src="<?php echo WWW;?>public/js/app.js?var=<?php echo ND_MOBILE_V;?>"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
    <!-- jq -->

    <!-- 编辑器 -->
    <link href="https://cdn.bootcss.com/simditor/2.3.21/styles/simditor.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo WWW;?>View/nd_mobile/src/simditor/module.js?var=<?php echo ND_MOBILE_V;?>"></script>
    <script type="text/javascript" src="<?php echo WWW;?>View/nd_mobile/src/simditor/hotkeys.js?var=<?php echo ND_MOBILE_V;?>"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/simditor/2.3.21/lib/simditor.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/Swiper/4.4.2/js/swiper.min.js"></script>
    <!-- pulltorefresh -->
    <!-- <script src="https://cdn.bootcss.com/pulltorefreshjs/0.1.14/pulltorefresh.min.js"></script> -->
    <!-- 分享 -->
    <script type="text/javascript" src="<?php echo WWW;?>View/nd_mobile/js/soshm.min.js?var=<?php echo ND_MOBILE_V;?>"></script>
</head>

<body>
<?php
//字符截取方法substr_cut(截取的字符串,字数)
function substr_cut($v, $length)
{
    if (mb_strlen($v) > $length) {
        echo mb_substr($v, 0, $length, "utf-8") . '...';
    } else {
        echo mb_substr($v, 0, $length, "utf-8");
    }
}
function is_vip($uid){
    $Uvip = S('uvip');
    $res = $Uvip->count(['uid'=>$uid]);
    if($res){
        return true;
    }else{
        return false;
    }
}
?>
<div class="loading-page" style="display: none;">
    <div class="reds">
        <div class="loader2"></div>
    </div>
</div>
<?php if (IS_LOGIN): ?>
    <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>

<div class="user_mess">
    <div id="actionSheet" class="m-actionsheet">
        <header class="m-navbar navbar-fixed">
            <a href="javascript:;" class="navbar-item" id="cancel">
                <i class="icon-cha"></i>
            </a>
            <div class="navbar-center">
                <span class="navbar-title">消息</span>
            </div>
        </header>
        <div class="g-view">
            <div class="m-tab" id="haoyou">
                <!-- 这里添加data-ydui-tab就可以啦 -->
                <ul class="tab-nav">
                    <li class="tab-nav-item tab-active">
                        <a href="javascript:;">消息</a>
                    </li>
                    <li class="tab-nav-item">
                        <a href="javascript:;">粉丝</a>
                    </li>
                    <li class="tab-nav-item">
                        <a href="javascript:;">陌生人</a>
                    </li>
                </ul>
                <div class="tab-panel">
                    <div id="friend-1" class="tab-panel-item tab-active">
                    </div>
                    <div id="friend-3" class="tab-panel-item"></div>
                    <div id="friend-0" class="tab-panel-item"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- 聊天 -->
    <div id="liaotian" class="m-actionsheet m-bg">
        <header class="m-navbar navbar-fixed">
            <a href="javascript:;" class="navbar-item" id="cancel_liaotian">
                <i class="back-ico"></i>
            </a>
            <div class="navbar-center">
                <span class="navbar-title navbar-title3">系统消息</span>
            </div>
        </header>
        <div class="g-view">
            <div class="m-tab" data-ydui-tab>
                <!-- 这里添加data-ydui-tab就可以啦 -->
                <div class="tab-panel">
                    <div id="lt" class="tab-panel-item tab-active">
                    </div>
                </div>
            </div>
        </div>
        <footer class="m-tabbar tabbar-fixed">
            <div class="footer-center">
                <input id="msg-text" type="text" class="input-text">
                <div class="footer-right">
                    <button onclick="send_lt(1,this)" class="btn btn-primary" type="button" style="height:36px">Send</button>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>
    $(function(){
        var $tab = $('#haoyou');
        $tab.tab({
            nav: '.tab-nav-item',
            panel: '.tab-panel-item',
            activeClass: 'tab-active'
        })
    })
</script>
    <div class="ajax_post">
    <style>
    .navbar-center .navbar-title1 {
        text-align: center;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        display: block;
        text-overflow: ellipsis;
        font-size: 20px;
        color: #fff;
    }
    </style>
    <!-- 发帖 -->
    <div id="ajax_post_page" class="m-actionsheet" style="height: 100%;">
        <header class="m-navbar navbar-fixed" style="background: #fff;">
            <a href="javascript:;" class="navbar-item" id="cancel-editor">
                <i class="icon-cha"></i>
            </a>
            <div class="navbar-center">
                <span class="navbar-title1">帖子发布</span>
            </div>
            <a href="javascript:;" class="navbar-item" id="post" onclick="post()">
                发布
            </a>
        </header>
        <div class='g-view' style="overflow-y: scroll;height: 100%;">
            <div class="user_thread" id="post_loading_post">
                <div class="no_thread">
                    <div class="loading">
                        <i class="icon-loading"></i>
                    </div>
                    <p>加载中...</p>
                </div>
            </div>
            <div id="ajax_post" >

            </div>
        </div>
    </div>
    <!-- 分类选着界面 -->
    <div class="m-actionsheet" id="fenleixuanxiang" style="height: 100%;z-index:10000">
        <header class="m-navbar navbar-fixed" style="background:#fff">
            <a href="javascript:;" class="navbar-item" id="cancel"><i class="icon-cha"></i></a>
            <div class="navbar-center">
                <span class="navbar-title"></span>
            </div>
            <a href="javascript:;" class="navbar-item" onclick="addfenlei()">
                选定
            </a>
        </header>
        <div class="g-view" style="height: 100%;overflow-y: scroll">
            <?php
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
                // 主分区
                $forum_group = M('Forum_group')->read_all_cache();
            ?>
            <div class="m-scrolltab" style="bottom:0">
                <div class="scrolltab-nav">
                    <a href="javascript:;" data-url="<?php echo HYBBS_URL('plugins','post_changyong');?>" data-fgid="" onclick="fenqu(this)" class="scrolltab-item crt">
                        <div class="scrolltab-icon"><i class="demo-icons-category1"></i></div>
                        <div class="scrolltab-title">最近使用</div>
                    </a>
                    <?php foreach ($forum_group as $k => $v): ?>
                        <a href="javascript:;" data-url="<?php echo HYBBS_URL('plugins','post_fenlei');?>" data-fgid="<?php echo $v['id'];?>" onclick="fenqu(this)" class="scrolltab-item">
                            <div class="scrolltab-icon"><i class="demo-icons-category1"></i></div>
                            <div class="scrolltab-title"><?php echo $v['name'];?></div>
                        </a>
                    <?php endforeach ?>
                </div>
                <div class="scrolltab-content">
                    <div class="scrolltab-content-item">
                        <div class="m-cell" id="post_fennei">
                            <?php foreach ($formname as $v): ?>
                            <label class="cell-item">
                                <span class="cell-left"><img src="<?php echo WWW;?>upload/forum<?php echo $v['id'];?>.png" class="post-xuand" onerror="this.src='<?php echo WWW;?>upload/de.png'"><?php echo $v['name'];?></span>
                                <label class="cell-right">
                                    <input type="radio" value="<?php echo $v['id'];?>" name="fenlei"/>
                                    <i class="cell-radio-icon"></i>
                                </label>
                            </label>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif ?>
<div id="pjax">

<?php if (false): ?>
    <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <span class="navbar-title"><?php echo $title;?></span>
    </div>
</header>
<div class="g-view">
    <div class="m-cell demo-small-pitch" style="margin-top: 10px;">
        <form id="user-login-form" method="post" onsubmit="return user_login()">
            <div class="cell-item">
                <div class="cell-right">
                    <input type="text" name="user" class="cell-input" placeholder="用户名" autocomplete="off">
                </div>
            </div>
            <div class="cell-item">
                <div class="cell-right">
                    <input type="password" name="pass" class="cell-input" placeholder="密码" autocomplete="off">
                </div>
            </div>
        </form>
        </div>
        <div style="margin:0 10px;"><button id="login" class="btn-block btn-primary">登录</button></div>
        <div class="cell-item">
            <div class="cell-left"><a href="<?php echo HYBBS_URL('user','repass');?>" data-pjax style="color: #2196F3">忘记了密码？</a></div>
            <div class="cell-right" style="font-size: 15px;"><a href="<?php echo HYBBS_URL('user','add');?>" data-pjax style="color: #2196F3">现在注册</a></div>
        </div>
        <style>
            .icondenglu{
                justify-content: center;
                align-items: center;
                display: flex;
                margin-top: 10px;
            }
            .icondenglu a {
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 100%;
                background: #03a9f4;
                color: #fff;
            }
            .icondenglu a i{
                font-size: 24px;
            }

        </style>
        <div  class="icondenglu">
            <?php if (get_plugin_install_state('hy_qq_login')): ?>
            <?php if (is_plugin_on('hy_qq_login')): ?>
            <a href="<?php echo HYBBS_URL('user','qqlogin');?>" class="btn btn-outline-info btn-icon rounded-circle mr-3">
                <i class="iconfont icon-qq"></i>
            </a>
            <?php endif ?>
            <?php endif ?>
            <?php if (get_plugin_install_state('hy_weixin_login')): ?>
                <?php if (is_plugin_on('hy_weixin_login')): ?>
                <a href="<?php echo HYBBS_URL('user','weixin_login');?>" class="btn btn-outline-success btn-icon rounded-circle mr-3" style="margin-left:10px;background:#35b94c;">
                      <div><i class="fa fa-weixin"></i></div>
                </a>
                <?php endif ?>
            <?php endif ?>
            <?php if (get_plugin_install_state('hy_weibo_login')): ?>
                <?php if (is_plugin_on('hy_weibo_login')): ?>
                <a href="<?php echo HYBBS_URL('user','weibologin');?>" class="btn btn-outline-danger btn-icon rounded-circle" style="margin-left:10px;background:#ef4f4f;">
                        <i class="iconfont icon-weibo"></i>
                </a>
                <?php endif ?>
            <?php endif ?>
        </div>
    <script>
        $('#login').on('click',function(){
            var dialog = YDUI.dialog;
            var postdata = $('#user-login-form').serialize();
            $("#login").attr('disabled','disabled').text('正在登录中...');
            
            $.ajax({
                url:"<?php HYBBS_URL('user','login') ?>",
                type:'post',
                data:postdata,
                dataType:'json',
                success:function(e){
                    
                    $("#login").removeAttr('disabled').text('登录');
                    if(e.error){
                        if(e.url !='')
                            window.location.href=e.url;
                        else
                            window.location.href="<?php echo WWW;?>";
                    }else{
                        // $.hy.warning(e.info);
                        dialog.toast(e.info, 'none', 1000);
                    }
                    
                },
                error:function(e){
                    
                    $("#login").removeAttr('disabled').text('登录');
                }
            });
            
            return false;
        })
    </script>
</div>
<?php else: ?>
    <div class="g-view" style="background:#fff;height:100vh">
    <header class="m-navbar navbar-fixed" style="background: #fff;padding: 0.75rem;">
        <a href="javascript:history.back(-1);" class="navbar-item" style="color:#6f17ff">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title"></span>
        </div>
    </header>
    <section>
        <style>
            .g-view:after{
                height:0px;
            }
        </style>
        <div style="text-align: center;">
            <img src="<?php echo WWW;?>View/nd_mobile/img/extreme.png" style="margin-top:1.8rem;width: 6rem;">
        </div>
        <form id="user-login-form" method="post" onsubmit="return user_login()">
            
            <div style="margin:1.8rem">
                <input class="login_input" type="text" name="user" placeholder="用户名">
            </div>
            
            <div style="margin:1.8rem">
                <input class="login_input" type="password" name="pass" placeholder="密码">
            </div>
            
            
            <div style="margin:1.8rem 1.8rem 0">
                <button class="login_button" id="login">登录</button>
            </div>
        </form>
        <div style="margin: 25px 1.8rem 10px;display: flex;justify-content: space-between;">
            <a href="<?php echo HYBBS_URL('user','repass');?>" class="login_zhaohui">忘记了密码？</a>
            <a href="<?php echo HYBBS_URL('user','add');?>" class="login_zhaohui">现在注册一个</a>

        </div>
        <div style="text-align: center;margin-top:2rem;width: 100%;">
            <div class="login_disanf">
                <span></span>
            </div>
            <div class="login_disanf_btn">
                <?php if (is_plugin_on('hy_qq_login')): ?>
                <a href="#" class="btn btn-icon login_icon login_icon_qq"><div><i class="icon-qq1"></i></div></a>
                <?php endif ?>
                <?php if (is_plugin_on('hy_weibo_login')): ?>
                <a href="#" class="btn btn-icon login_icon login_icon_wb"><div><i class="icon-weibo1"></i></div></a>
                <?php endif ?>
                <?php if (is_plugin_on('hy_weixin_login')): ?>
                <a href="#" class="btn btn-icon login_icon login_icon_wx"><div><i class="icon-weixin"></i></div></a>
                <?php endif ?>
                
                <a href="javascript:login_no();" class="btn btn-icon login_icon login_icon_github"><div><i class="icon-github"></i></div></a>
                <a href="javascript:login_no();" class="btn btn-icon login_icon login_icon_tb"><div><i class="icon-taobao"></i></div></a>
            </div>
        </div>
    </section>
    <script>
        $('#login').on('click',function(){
            var dialog = YDUI.dialog;
            var postdata = $('#user-login-form').serialize();
            $("#login").attr('disabled','disabled').text('登录中...');
            
            $.ajax({
                url:"<?php HYBBS_URL('user','login') ?>",
                type:'post',
                data:postdata,
                dataType:'json',
                success:function(e){
                    
                    $("#login").removeAttr('disabled').text('登录');
                    if(e.error){
                        dialog.toast("登录成功", 'success', 1000);
                        setInterval(function(){
                            if(e.url !=''){
                                window.location.href=e.url;
                            }else{
                                window.location.href="<?php echo WWW;?>";
                            }
                        },1500);
                    }else{
                        dialog.toast(e.info, 'none', 1000);
                    }
                    
                },
                error:function(e){
                    
                    $("#login").removeAttr('disabled').text('登录');
                }
            });
            
            return false;
        })
        function login_no(){
            dialog.toast("功能尚在开发中", 'none', 1000);
        }
    </script>
</div>
<?php endif ?>
    <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
    <audio id="play-msg">
        <source src="<?php echo WWW;?>View/nd_mobile/img/mess.mp3" type="audio/mp3">
    </audio>
    <div class="top" >
        <?php if (ACTION_NAME == 'Forum' || ACTION_NAME == 'Thread'): ?>
        <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?>javascript:;<?php endif ?>" <?php if (IS_LOGIN): ?>data-ydui-actionsheet="{target:'#ajax_post_page',closeElement:'#cancel-editor'}" onclick="ajax_post('<?php echo HYBBS_URL('post');?>','post')"<?php else: ?>data-pjax<?php endif ?> style="background:rgba(3, 169, 244, 0.8);"><i class="icon-jia2"></i></a>
        <?php endif ?>
        <a href="javascript:;" onclick="top_t()"><i class="icon-fanhuidingbu"></i></a>
    </div>
    </div>
    <!-- 引入组件库 -->
    
    <script src="<?php echo WWW;?>View/nd_mobile/js/ydui.js?var=<?php echo ND_MOBILE_V;?>"></script>
          <!-- 用户 -->
    <script src="<?php echo WWW;?>View/nd_mobile/js/hyphp.js?var=<?php echo ND_MOBILE_V;?>"></script>
    <script src="<?php echo WWW;?>View/nd_mobile/js/app.js?var=<?php echo ND_MOBILE_V;?>"></script>  
</body>
</html>