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
<div class="user">
    <header class="m-navbar navbar-fixed">
        <a href="javascript:history.back(-1);" class="navbar-item">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title"></span>
        </div>
        <a href="<?php echo HYBBS_URL('my',$data['user'],'user_style');?>" data-pjax class="navbar-item">
            <i class="icon-zhuti"></i>
        </a>
    </header>
</div>
<style>
    .user-gengduo a {
        justify-content: center;
    }

    .user>.m-navbar {
        background-color: rgba(255, 255, 255, 0);
        -webkit-transition: background-color .2s ease-in;
        transition: background-color .2s ease-in;
    }

    .m-bg {
        background: #fff;
    }
    .m-bg .navbar-item, 
    .m-bg .navbar-item .back-ico:before, 
    .m-bg .navbar-item .next-ico:before, 
    .m-bg .navbar-center .navbar-title,
    .m-bg .navbar-item .back-ico:before, 
    .m-bg .navbar-item .next-ico:before
     {
        color: #5C5C5C;
    }
    .user>.m-navbar:after {
        border-bottom: none;
    }

    .user>.navbar-item>i,
    .user>.navbar-item .icon-fanhui::before,
    .user>.navbar-item .next-ico::before {
        color: #fff;
    }
    .user_tongji{
        position: absolute;
        top: 175px;
        background: #fff;
        border-radius: 5px;
        padding: 10px 20px;
        margin: 0 10px;
        width: calc(100% - 20px);
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
    }
    .user_tongji li {
        text-align: center;
        list-style: none;
        width: 33.333333%;
        float: left;
        position: relative;
        z-index: 0;
        padding: 10px 0;
        font-size: 18px;
        color:#4CAF50;
        font-weight: bold;
    }
    .user_tongji li span{
        font-size: 12px;
        color: #444;
        font-weight:200
    }
    .navbar-item,
    .navbar-item .back-ico:before, 
    .navbar-item .next-ico:before{
        color: #fff;
    }
</style>
<?php
    $collection = S('plugins_collection')->count(['uid'=>NOW_UID])
?>
<div class="user_ipc">
    <?php $user_img = S('user_style')->find('*',['uid'=>$data['uid']]); ?>
    <?php $inc = get_plugin_inc('nd_user_img'); ?>
    <div style="background-image:url(<?php if ($user_img): ?><?php echo $user_img['img'];?>?r=<?php echo time();?><?php else: ?><?php echo $inc['user_d_img'];?><?php endif ?>);" class="forum_thread_header">
        <div class="user_info">
            <img src="<?php echo WWW;?><?php echo $data['avatar']['a'];?>" alt="<?php echo $data['user'];?>">
            <div class="title">
                <div>
                    <h3 style="text-transform:capitalize;">
                        <?php
                        $renzheng_inc = get_plugin_inc('nd_renzheng');
                        ?>
                            <?php
                            // 查询验证
                            $is_renzheng = S('user')->find('renzheng',['uid'=>$user['uid']]);
                            ?>
                        <span class="user_name" style="<?php if (is_vip($user['uid'])||$is_renzheng): ?>color:<?php echo $renzheng_inc['color'];?><?php endif ?>">
                            <?php echo $user['user'];?>
                            <?php if ($is_renzheng): ?>
                            <i style="color:<?php echo $renzheng_inc['yan_color'];?>" class="iconfont icon-renzheng"></i>
                            <?php endif ?>
                        </span>
                    </h3>
                    <P><?php if ($data['ps']): ?><?php echo $data['ps'];?><?php else: ?>这家伙很懒没有留下签名<?php endif ?></P>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="user_tongji">
    <div class="user_tongji_bg">
        <li>
                <a href="<?php echo HYBBS_URL('coterie','follow');?>"><?php echo $user['follow'];?> <span>关注</span></a>
        </li>
        <li>
                <a href="" data-ydui-actionsheet="{target:'#actionSheet',closeElement:'#cancel'}"><?php echo $user['fans'];?> <span>粉丝</span></a>
        </li>
        <li>
                <a href="" ><?php echo $user['gold'];?> <span>金币</span></a>
        </li>
    </div>
</div>
<div class="g-view">
    <div style="margin-top:50px;"></div>
    <div class="user_zil">
        <div class="m-cell" style="margin: 10px 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
                
            <div class="cell-item">
                <div class="cell-left"><a href="<?php echo HYBBS_URL('my',$user['user']);?>">个人主页</a></div>
                <a class="cell-right cell-arrow" href="<?php echo HYBBS_URL('my',$user['user']);?>"></a>
            </div>
        
            <div class="cell-item">
                <div class="cell-left"><a href="<?php echo HYBBS_URL('my',$user['user'],'thread');?>">我的帖子</a></div>
                <a class="cell-right cell-arrow" href="<?php echo HYBBS_URL('my',$user['user'],'thread');?>"><?php echo $user['threads'];?></a>
            </div>
            <div class="cell-item">
                <div class="cell-left"><a href="<?php echo HYBBS_URL('my',$user['user'],'collection');?>">我的收藏</a></div>
                <a class="cell-right cell-arrow" href="<?php echo HYBBS_URL('my',$user['user'],'collection');?>"><?php echo $collection;?></a>
            </div>
            <div class="cell-item">
                <div class="cell-left"><a href="<?php echo HYBBS_URL('my',$user['user'],'post');?>">我的回帖</a></div>
                <a class="cell-right cell-arrow" href="<?php echo HYBBS_URL('my',$user['user'],'post');?>"><?php echo $user['posts'];?></a>
            </div>
        </div>
        <div class="m-cell" style="margin: 10px 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
            
            <div class="cell-item">
                <div class="cell-left"><a href="<?php echo HYBBS_URL('my',$user['user'],'op');?>">账号设置</a></div>
                <a class="cell-right cell-arrow" href="<?php echo HYBBS_URL('my',$user['user'],'op');?>"></a>
            </div>
            <div class="cell-item">
                <a href="<?php echo HYBBS_URL('user','out');?>" class="btn-block btn-danger" style="margin: 10px 10px 10px 0;height: 40px;line-height: 40px;">退出登录</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $(window).scroll(function () {
            if ($(document).scrollTop() >= 200) {
                $('header').addClass('m-bg');
                $('.icon-fanhui').css('color', '#fff');
            } else {
                $('header').removeClass('m-bg');
                $('.icon-fanhui::before').css('color', '');
            }
        });
        $('[data-ydui-actionsheet]').click(function(){
            if(!$('.tab-nav-item:eq(1)').hasClass('tab-active')){
                $(".tab-nav-item:eq(1)").trigger("click");
            }
            $('#actionSheet').addClass('m-bg');
        })
    });
</script>
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