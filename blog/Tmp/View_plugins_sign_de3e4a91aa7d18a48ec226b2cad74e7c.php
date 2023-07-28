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

<style>
    .nd_sign .m-navbar{
        background: rgba(255, 255, 255, 0);
        padding: 10px;
    }
    .nd_sign .m-navbar .navbar-item{color: #03A9F4;}
    .sign{
        background-image: url(<?php echo WWW;?>View/nd_mobile/img/rect3059.png);
        background-position: 0% 0%;
        position: relative;
        text-align: center;
        padding: 30px 20px;
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
        background-repeat: no-repeat;
        background-size: cover;
        height: 174px;
    }
    .sign .scspan{
        margin-top: 40px;
    }
    .sign p{
        margin-top: 10px;
    }
    .sign .signin-days{
        color: #673AB7;

    }
    .m-grids-7{
        background: #fff;
        overflow: hidden;
    }
    .m-grids-7 .grids-item{
        width: 14.2857%;
    }
    .signs{
        margin: 15px;
        border-radius: 5px;
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
    }
    .signs .grids-item{
        position: relative;
        line-height: 42px;
        height: 42px;
        padding: 0;
        overflow: hidden;
    }
    .signs .grids-item i{
        font-size: 18px;
        position: absolute;
        width: 25px;
        border: 1px solid #03A9F4;
        height: 25px;
        border-radius: 50%;
        top: 49%;
        left: 50%;
        transform: translate(-50%, -52%);
    }

    .signs .grids-item .guoqu{
        color: #adadad;
    }
    .signs .grids-item .qiandao{
        position: absolute;
        background: #03A9F4;
        color: #fff;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 2px 16px -4px #03A9F4;
        width: 32px;
        height: 32px;
        border-radius: 19px;
    }
    .signs .grids-item .wancheng{
        background: rgba(3, 169, 244, 0.44);
    }
    .signs .grids-item .qiandao span{
        position: absolute;
        color: #fff;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -49%);
        font-size: 12px;
    }
    .signs .grids-item .jinri{
        background: #38c1ff;
        color: #fff;
    }
    .signs .grids-item .ok{
        color: #38c1ff;
    }
    .signs .grids-item .zhou{
        background: rgba(3, 169, 244, 0.2);
        color: #38c1ff;
    }
    .shuoming{
        margin: 15px;
        background: #fff;
        padding: 15px;
        font-size: 14px;
        border-radius: 5px;
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
    }
    .shuoming h5{
        color: #03A9F4;
    }
    .shuoming ol{
        color: #73c7ec;
        list-style: cjk-ideographic;
        padding: 2px 22px;
    }
    .g-view:after {
        display: block;
        height: 55px;
    }
    .btn-primary {
        box-shadow: 0 3px 19px -3px #03A9F4;
    }
</style>
<?php $inc = get_plugin_inc("nd_website_plus"); ?>
<div class="g-view nd_sign">
    <header class="m-navbar navbar-fixed">
        <a href="javascript:history.back(-1);" class="navbar-item">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
        </div>
    </header>
    <div style="margin-top: -50px;background: #fff;">
            <div class="sign">
                <div class="scspan">
                    <button class="btn btn-primary <?php if ($sign_jinri): ?>btn-disabled<?php endif ?>"<?php if ($isLogin): ?> onclick="sign()"<?php endif ?>><?php if ($sign_jinri): ?>今日已签到<?php else: ?>点击签到<?php endif ?></button>
                    <p><span class="signin-days">已连累计到<cite id="sign_leiji"><?php if ($sign_data['count']): ?><?php echo $sign_data['count'];?><?php else: ?>0<?php endif ?></cite>天</span> <span class="signin-days">已连续签到<cite id="sign_lianxu"><?php if ($sign_data['signcount']): ?><?php echo $sign_data['signcount'];?><?php else: ?>0<?php endif ?></cite>天</span></p>
                </div>
            </div>
    </div>
    <?php
        $riqi   = ['日','一','二','三','四','五','六'];
        $qishi  = 0; // 记录起始位置
        $rili   = 0; // 记录 日 用于1-31的天数记录
    ?>
    <div class="m-grids-7 signs">
        <?php foreach ($riqi as $v): ?>
        <a href="javascript:;" class="grids-item">
            <div class="grids-txt zhou">
                <?php echo $v;?>
            </div>
        </a>
        <?php endforeach ?>
        
        <?php for ($i=1;$i <= date('t')+date("w",strtotime(date('Y-m-')."1"));$i++): ?>
            <?php if ($qishi < date("w",strtotime(date('Y-m-')."1"))): ?>
                <!-- 这里用于占位 -->
                <a href="javascript:;" class="grids-item">
                    <div class="grids-txt jinri"></div>
                </a>
                <?php $qishi+=1 ?>
            <?php else: ?>
                <?php $rili += 1 ?>
                <?php if ($rili == date('d')): ?>
                    <?php if ($sign_jinri): ?>
                    <a href="javascript:;" class="grids-item" id='wanchengqiandao'>
                        <div class="grids-txt qiandao wancheng">
                            <span>完成</span>
                        </div>
                    </a>
                    <?php else: ?>
                    <a href="javascript:;" class="grids-item" id='wanchengqiandao'>
                        <div class="grids-txt qiandao" onclick="sign()">
                            <span>签到</span>
                        </div>
                    </a>
                    <?php endif ?>
                <?php else: ?>
                    <a href="javascript:;" class="grids-item">
                        <div class="grids-txt">
                            <?php if ($rili == in_array($rili, $sign_riqi)): ?> <i class=""></i> <span class="ok"><?php echo $rili;?></span><?php else: ?> <span class="<?php if ($rili < date('d')): ?>guoqu<?php endif ?>"><?php echo $rili;?></span> <?php endif ?>
                        </div>
                    </a>
                <?php endif ?>
            <?php endif ?>
        <?php endfor ?>
        
    </div>
    <div class="shuoming">
        <h5>签到规则</h5>
        <ol>
            <?php echo $inc['sign_mess'];?>
        </ol>
    </div>
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