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
<div class="user">
    <header class="m-navbar navbar-fixed">
        <a href="javascript:history.back(-1);" class="navbar-item">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title"><?php echo $title;?></span>
        </div>
        <?php if (IS_LOGIN): ?>
            <?php if (NOW_UID == $data['uid']): ?>
            <a href="<?php echo HYBBS_URL('my',$data['user'],'op');?>" data-pjax class="navbar-item">
                <i class="icon-yduigengduo"></i>
            </a>
            <?php else: ?>
            <a href="#" class="navbar-item" data-ydui-actionsheet="{target:'#actionsheet',closeElement:'#cancel'}">
                <i class="icon-yduigengduo"></i>
            </a>
            <?php endif ?>
        <?php endif ?>
    </header>
</div>
<?php if (NOW_UID != $data['uid']): ?>
<div class="m-actionsheet user-gengduo" id="actionsheet" >
    <a href="javascript:;" class="actionsheet-item" onclick="friend(<?php echo $data['uid'];?>,this)"><?php if (M("Friend")->get_state(NOW_UID,$data['uid'])): ?>取消关注<?php else: ?>加关注<?php endif ?></a>
    <a href="javascript:;" class="actionsheet-item" onclick="open_lt('<?php echo $data['user'];?>','<?php echo $data['uid'];?>','<?php echo WWW;?><?php echo $data['avatar']['a'];?>')" data-ydui-actionsheet="{target:'#liaotian',closeElement:'#cancel_liaotian'}">聊天</a>
    <a href="javascript:;" class="actionsheet-action" id="cancel">取消</a>
</div>
<?php endif ?>
<style>
    .user-gengduo a{
        justify-content: center;
    }
    .user > .m-navbar{
        background-color: rgba(255, 255, 255, 0);
        -webkit-transition: background-color .2s ease-in;
        transition: background-color .2s ease-in;
    }
    .m-bg {
        background:#fff !important;
    }
    .m-bg .navbar-item,
    .m-bg .navbar-item .back-ico:before, 
    .m-bg .navbar-item .next-ico:before,
    .m-bg .navbar-center .navbar-title{
        color: #5C5C5C;
    }
    .navbar-item,
    .navbar-item .back-ico:before, 
    .navbar-item .next-ico:before,
    .navbar-center .navbar-title{
        color: #fff;
    }
    .user > .m-navbar:after {
        border-bottom: none;
    }
    .user > .navbar-item>i,
    .user > .navbar-item,
    .user > .navbar-center .navbar-title,
    .user > .navbar-item,
    .user > .navbar-center .navbar-title,
    .user > .navbar-item .icon-fanhui::before,
    .user > .navbar-item .next-ico::before {
        color: #fff;
    }
    
</style>
<script>
    $(function() {
        $(window).scroll(function() {
            //$(document).scrollTop() 获取垂直滚动的距离
            //$(document).scrollLeft() 这是获取水平滚动条的距离
            if ($(document).scrollTop() >= 200) {
                $('header').addClass('m-bg');
            }else{
                $('header').removeClass('m-bg');
                $('.icon-fanhui::before').css('color','');
            }
        });
    });
</script>
<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="user_ipc">
        <?php $user_img = S('user_style')->find('*',['uid'=>$data['uid']]); ?>
        <?php $inc = get_plugin_inc('nd_user_img'); ?>
    <div style="background-image:url(<?php if ($user_img): ?><?php echo $user_img['img'];?>?r=<?php echo time();?><?php else: ?><?php echo $inc['user_d_img'];?><?php endif ?>);" class="forum_thread_header">
        <div class="user_info">

        </div>
    </div>
</div>


<div class="g-view">
    <!-- 菜单 -->
    <style type="text/css">

        .user_manun{
            position: relative;
            background: #fff;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            padding-top: 10px;
        }
        .user_manun .left{
            position: absolute;
            top: -30px;
            left: 15px;
        }
        .user_manun .right{
            margin-left: 106px;
        }
        .user_manun img{
            width: 80px;
            border-radius: 5px;
        }
        .user_manun h1{
            font-size: 18px;
            color: #444
        }
        .user_menu i{
            color:#fff;
        }
        .user_menu .grids-item{padding:10px;}
        .m-grids-5:before,
        .m-grids-5 .grids-item:not(:nth-child(5n)):before{
            border:none;
        }
        .user_tongji {
            top: 175px;
            background: #fff;
            padding: 5px 20px;
            width: 100%;
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
    .user_tongji_bg::after{
        content: '';
        display: block;
        clear: both;
    }
    </style>
    <div class="user_menu">
        <div class="user_manun">
            <div class="left">
                <img src="<?php echo WWW;?><?php echo $data['avatar']['a'];?>" alt="">
            </div>
            <div class="right">
                <h1>
                    <?php
                    $renzheng_inc = get_plugin_inc('nd_renzheng');
                    ?>
                        <?php
                        // 查询验证
                        $is_renzheng = S('user')->find('renzheng',['uid'=>$data['uid']]);
                        ?>
                    <span class="user_name" style="<?php if (is_vip($data['uid'])||$is_renzheng): ?>color:<?php echo $renzheng_inc['color'];?><?php endif ?>">
                        <?php echo $data['user'];?>
                        <?php if ($is_renzheng): ?>
                        <i style="color:<?php echo $renzheng_inc['yan_color'];?>" class="iconfont icon-renzheng"></i>
                        <?php endif ?>
                    </span>
                </h1>
                <div style="margin-left: -3px;margin-bottom: 5px;margin-top: 5px;">
                    <?php
                        $inc = get_plugin_inc('nd_website_plus');
                        $lv = array_filter(explode("\r\n",$inc['user_lv']));
                        $lv_limit = count($lv);
                        $credits = S('User')->find('credits',['uid'=>$data['uid']]);
                    ?>
                    <!-- 性别 -->
                    <?php $sex = S('user')->find('sex',['uid'=>$data['uid']]) ?>
                    <?php if ($sex == 0): ?>
                    <!-- 没设置 -->
                    <span class="lv no">
                        <i class="iconfont icon-xingbie"><?php $age =  date('Y')-date('Y',$data['age']) ?><?php if ($age!=0): ?><?php echo $age;?><?php endif ?></i>
                    </span>
                    <?php elseif ($sex == 1): ?>
                    <!-- 男 -->
                    <span class="lv nan">
                        <i class="iconfont icon-nan1"><?php $age =  date('Y')-date('Y',$data['age']) ?><?php if ($age!=0): ?><?php echo $age;?><?php endif ?></i>
                    </span>
                    <?php else: ?>
                    <!-- 女 -->
                    <span class="lv nv">
                        <i class="iconfont icon-nv1"><?php $age =  date('Y')-date('Y',$data['age']) ?><?php if ($age!=0): ?><?php echo $age;?><?php endif ?></i>
                    </span>
                    <?php endif ?>
                    <!-- 等级 -->
                    <?php foreach ($lv as $key => $lv): ?>
                    <?php $user_lv = explode("|",$lv); ?>
                        <?php if ($credits < $user_lv['0']): ?>
                        <span class="lv" style="color: <?php echo $user_lv['1'];?>;background: <?php echo $user_lv['2'];?>;box-shadow: 0 1px 10px -2px <?php echo $user_lv['2'];?>;">Lv.<?php echo $key+1;?></span>
                        <?php break; ?>
                        <?php endif ?>
                        <?php if ($key+1 == $lv_limit && $credits > $user_lv['0']): ?>
                        <span class="lv max">Lv.Max</span>
                        <?php break; ?>
                        <?php endif ?>
                    <?php endforeach ?>
                    <!-- 用户组 -->
                    <?php
                        $gid =  S('User')->find('gid',['uid'=>$data['uid']]);
                        $gname = M("Usergroup")->gid_to_name($gid);
                        $style = array_filter(explode("\r\n",$inc['style']));
                    ?>
                    <?php foreach ($style as $style): ?>
                    <?php $sty = explode("|",$style); ?>
                    <?php if ($sty['0'] == $gid): ?>
                    <span class="lv group" style="color:<?php echo $sty['1'];?>;background:<?php echo $sty['2'];?>;box-shadow: 0 1px 10px -2px <?php echo $sty['2'];?>;"><?php echo $gname;?></span>
                    <?php endif ?>
                    <?php endforeach ?>
                </div>
                <div>
                    <span style="font-size: 14px;"><?php echo $data['ps'];?></span>
                </div>
            </div>
        </div>
        <div class="user_tongji">
            <div class="user_tongji_bg">
                <li>
                        <a href="javascript:;"><?php echo $data['follow'];?> <span>关注</span></a>
                </li>
                <li>
                        <a href="javascript:;"><?php echo $data['fans'];?> <span>粉丝</span></a>
                </li>
                <li>
                        <a href="javascript:;" ><?php echo $data['gold'];?> <span>金币</span></a>
                </li>
            </div>
        </div>
    </div>
    <!-- 基本信息 -->
    <div class="user_zil">
    <div class="m-cell" style="margin: 10px 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
        <div class="cell-item">
            <div class="cell-left"><a href="<?php echo HYBBS_URL('my',$data['user'],'thread');?>">他的帖子</a></div>
            <div class="cell-right cell-arrow"><a href="<?php echo HYBBS_URL('my',$data['user'],'threads');?>"><?php echo $data['threads'];?></a></div>
        </div>
        <div class="cell-item">
            <?php
                $collection = S('plugins_collection')->count(['uid'=>$data['uid']]);
            ?>
            <div class="cell-left"><a href="<?php echo HYBBS_URL('my',$data['user'],'collection');?>">他的收藏</a></div>
            <div class="cell-right cell-arrow"><a href="<?php echo HYBBS_URL('my',$data['user'],'collection');?>"><?php echo $collection;?></a></div>
        </div>
        <div class="cell-item">
            <div class="cell-left"><a href="<?php echo HYBBS_URL('my',$data['user'],'post');?>">他的回帖</a></div>
            <div class="cell-right cell-arrow"><a href="<?php echo HYBBS_URL('my',$data['user'],'posts');?>"><?php echo $data['posts'];?></a></div>
        </div>
    </div>
    </div>
    <!-- 回复 -->
    <?php if ($post_data): ?>
        <div class="nd_crde" style="text-align:center"><h4>最近回复</h4></div>
        <section id="scrollView" class="yd-scrollview">
            <div class="yd-timeline demo-small-pitch" style="margin: 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
                <ul class="yd-timeline-content">
                    <?php foreach ($post_data as $v): ?>
                    <?php $title = S('Thread')->find('title',['tid'=>$v['tid']]); ?>
                    <li class="yd-timeline-item">
                        <!-- <em class="yd-timeline-icon"></em> -->
                        <img src="<?php echo WWW;?><?php echo $data['avatar']['a'];?>" style="<?php if (is_vip($data['uid'])): ?>border:2px solid #FF5722;<?php endif ?>width:35px;height:35px;"  class="thread_user_pic">
                        <p style="margin-top: 10px;"><?php echo humandate($v['atime']);?>在 <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" style="color: #0d6fbd;font-size: 14px;"><?php echo $title;?></a> 回复</p>
                        <p style="font-size: 12px;"></p>
                        <p style="margin-top: 10px;padding: 8px 5px;background: #f7f7f7;border-radius: 5px;"><?php echo $v['content'];?></p>
                        <div style="margin-top: 10px;font-size: 14px;text-align: right;">
                            <span style="margin-right: 10px;" onclick="tp('post1','<?php echo $v['pid'];?>',this)">
                                <i class="icon-yduihao"></i> <span><?php echo $v['goods'];?></span>
                            </span>
                            <span>
                                <i class="icon-huifu1"></i> <?php echo $v['posts'];?>
                            </span>
                        </div>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </section>
    <?php endif ?>
    <?php if ($post_data == '' && $post_data ==''): ?>
        <div class="no_thread">
            <i class="icon-meiyougengduo"></i>
            <p>TA还没有动态哦...</p>
        </div>
    <?php endif ?>
</div>

<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<footer class="m-tabbar tabbar-fixed">
    <a href="<?php echo WWW;?>" data-pjax class="tabbar-item <?php if (ACTION_NAME == 'Index' || ACTION_NAME == '_pjax=%23pjax'): ?>tabbar-active<?php endif ?>">
        <span class="tabbar-icon">
            <i class="icon-jia1"></i>
        </span>
        <span class="tabbar-txt">首页</span>
    </a>
    <a href="<?php echo HYBBS_URL('forum');?>" data-pjax class="tabbar-item <?php if (ACTION_NAME == 'Forum' || ACTION_NAME == 'Thread'): ?>tabbar-active<?php endif ?>">
        <span class="tabbar-icon">
            <i class="icon-shejiaoxinxi2"></i>
        </span>
        <span class="tabbar-txt">社区</span>
    </a>
    <a href="javascript:;" class="tabbar-item" data-ydui-actionsheet="{target:'#candan',closeElement:'.guanbi_caidan'}">
        <span class="tabbar-icon" style="padding: 10px;color: #fff;height: 40px;width: 45px;border-radius: 3px;background-image: linear-gradient(65deg, rgba(3, 169, 244, 0.75) 20%,rgba(3, 169, 244, 0.8) 80%);box-shadow: 0 5px 19px -7px #03A9F4;">
            <i class="icon-caozuoqipao"></i>
            <span id="mess_d"></span>
        </span>
        <!-- <span class="tabbar-txt">操作</span> -->
    </a>
    <a href="<?php echo HYBBS_URL('Coterie');?>" data-pjax class="tabbar-item <?php if (ACTION_NAME == 'Coterie'): ?>tabbar-active<?php endif ?>">
        <span class="tabbar-icon">
            <i class="icon-quanzi3"></i>
        </span>
        <span class="tabbar-txt">圈子</span>
    </a>
    <a href="<?php if (IS_LOGIN): ?><?php echo HYBBS_URL('my',$user['user'],'my');?><?php else: ?><?php echo HYBBS_URL('user','login');?><?php endif ?>" data-pjax class="tabbar-item <?php if (ACTION_NAME == 'My'): ?>tabbar-active<?php endif ?>">
        <span class="tabbar-icon">
            <i class="icon-shouye"></i>
        </span>
        <span class="tabbar-txt">个人中心</span>
    </a>
</footer>
<div class="nd_menu m-actionsheet" id="candan">
    <div class="nd_mend_content">
        <div class="nd_mened_user">
            <img src="<?php if (!IS_LOGIN): ?><?php echo WWW;?>View/nd_mobile/img/no_login.png<?php else: ?><?php echo WWW;?><?php echo $user['avatar']['b'];?><?php endif ?>" alt="">
            <div class="name"><?php if (IS_LOGIN): ?> 
                <?php
                $renzheng_inc = get_plugin_inc('nd_renzheng');
                ?>
                <span style="<?php if (is_vip($user['uid'])||$user['renzheng'] == 1): ?>color:<?php echo $renzheng_inc['color'];?><?php endif ?>"> 
                    <?php echo $user['user'];?>
                </span> 
                <i class="iconfont <?php if ($user['sex'] == 0): ?>icon-xingbie2 sex-no<?php elseif ($user['sex'] == 1): ?>icon-nan sex-nan<?php else: ?>icon-nv sex-nv<?php endif ?>"></i> <?php echo M("Usergroup")->gid_to_name($user['gid']) ?> <em><i class="icon-jinbi"><?php echo $user['gold'];?></i></em><?php else: ?><span style="font-size:14px;color: #b1b1b1;">以下操作需要登录后可用</span><?php endif ?> </div>
            <!-- <div class="right"><i class="icon-jinbi">105</i></div> -->
        </div>
        <div class="m-grids-4">
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?><?php echo HYBBS_URL('my',$user['user'],'collection');?><?php endif ?>" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-star-outline"></i>
                    <p>收藏</p>
                </div>
            </a>
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?><?php echo HYBBS_URL('my',$user['user'],'file');?><?php endif ?>" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-wj"></i>
                    <p>文件</p>
                </div>
            </a>
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?><?php echo HYBBS_URL('my',$user['user'],'thread');?><?php endif ?>" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                        <i class="icon-wenzhang"></i>
                    <p>帖子</p>
                </div>
            </a>
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?><?php echo HYBBS_URL('my',$user['user'],'post');?><?php endif ?>" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-huifu1"></i>
                    <p>回复</p>
                </div>
            </a>
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?><?php echo HYBBS_URL('my',$user['user'],'pay');?><?php endif ?>" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-chongzhi"></i>
                    <p>充值</p>
                </div>
            </a>
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?><?php echo HYBBS_URL('plugins','sign');?><?php endif ?>" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-qiandao3"></i>
                    <p>签到</p>
                </div>
            </a>
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?><?php echo HYBBS_URL('plugins','task');?><?php endif ?>" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                        <i class="icon-renwu"></i>
                    <p>任务</p>
                </div>
            </a>
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?><?php echo HYBBS_URL('my',$user['user'],'op');?><?php endif ?>" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                        <i class="icon-yduishezhi"></i>
                    <p>设置</p>
                </div>
            </a>
        </div>
        <div class="m-grids-3">
            <a href="javascript:history.back(-1);" class="grids-item guanbi_caidan">
                <div class="grids-txt" style="text-align: left;padding-left: 23%;">
                    <i class="icon-iconfontfanhui"></i>
                </div>
            </a>
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?>javascript:;<?php endif ?>" class="grids-item guanbi_caidan" <?php if (IS_LOGIN): ?>data-ydui-actionsheet="{target:'#ajax_post_page',closeElement:'#cancel-editor'}" onclick="ajax_post('<?php echo HYBBS_URL('post');?>','post')"<?php else: ?>data-pjax<?php endif ?>>
                <div class="grids-txt">
                        <i class="icon-plus"></i>
                </div>
            </a>
            <a href="<?php if (IS_LOGIN): ?>javascript:;<?php else: ?><?php echo HYBBS_URL('user','login');?><?php endif ?>" class="grids-item guanbi_caidan" <?php if (IS_LOGIN): ?>data-ydui-actionsheet="{target:'#actionSheet',closeElement:'#cancel'}" onclick="tog_friend_box()"<?php else: ?>data-pjax<?php endif ?>>
                <div class="grids-txt" style="text-align: right;padding-right: 23%;">
                        <i class="icon-xiaoxi3"></i>
                        <span id="message"></span> 
                </div>
            </a>
        </div>
    </div>
</div>


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