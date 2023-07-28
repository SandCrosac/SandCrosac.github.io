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
    .index .navbar-item,
    .index .navbar-center .navbar-title,
    .index .navbar-item .icon-fanhui:before, .navbar-item .next-ico:before{
        color: #fff;
    }
</style>
    <header class="m-navbar navbar-fixed index" style="background:rgba(0, 0, 0, 0.0);padding: 10px 5px;">
        <a href="#" class="navbar-item" data-ydui-actionsheet="{target:'#yd-popup',closeElement:'#cancel'}">
            <i class="icon-fenlei4"></i>
        </a>
        <div class="navbar-center">
            <a href="javascript:;" class="navbar-title" style="background: rgba(255, 255, 255, 0.3);padding: 6px;line-height: 26px;height: 35px;border-radius: 4px;font-size: 18px;" data-ydui-actionsheet="{target:'#yd-search',closeElement:'#cancel'}">搜索</a>
        </div>
        <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?>javascript:;<?php endif ?>" <?php if (IS_LOGIN): ?>data-ydui-actionsheet="{target:'#ajax_post_page',closeElement:'#cancel-editor'}" onclick="ajax_post('<?php echo HYBBS_URL('post');?>','post')"<?php else: ?>data-pjax<?php endif ?> class="navbar-item search">
            <i class="icon--jia"></i>
        </a>
    </header>
    <header class="m-navbar navbar-fixed index-navbar" style="display:none">
        <a href="#" class="navbar-item" data-ydui-actionsheet="{target:'#yd-popup',closeElement:'#cancel'}">
            <i class="icon-fenlei4"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title"><?php echo BBSCONF('logo');?></span>
        </div>
        <a href="javascript:;" class="navbar-item search" data-ydui-actionsheet="{target:'#yd-search',closeElement:'#cancel'}">
            <i class="icon-sousuo"></i>
        </a>
    </header>
    <div class="g-view">
        <div class="lding"></div>
        <div class="m-actionsheet yd-popup-left" style="width: 60%;height: 100%;background: #fff;overflow-y: scroll;" id="yd-popup">
            <!--侧栏-->
            <div class="yd-popup-content">
                    <?php if (IS_LOGIN): ?>
                        <?php $user_img = S('user_style')->find('*',['uid'=>$user['uid']]); ?>
                    <?php endif ?>
                    <?php $inc = get_plugin_inc('nd_user_img'); ?>
                <div class="sidbg" style="background-image:url(<?php if (IS_LOGIN): ?><?php if ($user_img): ?><?php echo $user_img['img'];?>?r=<?php echo time();?><?php else: ?><?php echo $inc['user_d_img'];?><?php endif ?><?php else: ?><?php echo $inc['user_d_img'];?><?php endif ?>);">
                    <?php if (IS_LOGIN): ?>
                    <a class="zhuti" href="<?php echo HYBBS_URL('my',$user['user'],'user_style');?>" data-pjax><i class="icon-zhuti"></i></a>
                    <?php endif ?>
                    <div class="userinfo" style="">
                        <h3><?php if (IS_LOGIN): ?><?php echo $user['user'];?><?php else: ?>游客<?php endif ?></h3>
                        <p><?php if (IS_LOGIN): ?><?php if ($user['user']): ?><?php echo $user['ps'];?><?php else: ?>欢迎访问<?php echo BBSCONF('title');?>!<?php endif ?><?php else: ?>欢迎访问<?php echo BBSCONF('title');?>!<?php endif ?></p>
                    </div>
                </div>
                <div class="sidbr" style="margin-top: 15px;">
                    <li><a data-pjax href="<?php echo HYBBS_URL('forum');?>"><i class="iconfont icon-shejiaoxinxi2" style="color: #00BCD4;"></i> 社区论坛</a></li>
                    <li><a data-pjax href="<?php echo HYBBS_URL('Coterie');?>"><i class="iconfont icon-quanzi3" style="color: #8BC34A;"></i> 我的圈子</a></li>
                    <li><a data-pjax href="<?php echo HYBBS_URL('plugins','sign');?>"><i class="iconfont icon-qiandao" style="color: #673AB7;"></i> 每日签到</a></li>
                    <li><a data-pjax href="<?php echo HYBBS_URL('plugins','task');?>"><i class="iconfont icon-qiandao1" style="color: #4CAF50;"></i> 每日任务</a></li>
                    <li><a data-pjax href="<?php if (IS_LOGIN): ?><?php echo HYBBS_URL('my',$user['user']);?><?php else: ?><?php echo HYBBS_URL('user','login');?><?php endif ?>"><i class="iconfont icon-shouye" style="color: #E91E63;"></i> 个人中心</a></li>
                    
                    <?php if (NOW_GID == C("ADMIN_GROUP")): ?>
                    <li style="border-top: 1px solid #ddd;"><a data-pjax href="<?php echo HYBBS_URL('plugins','tuijian');?>"><i class="iconfont icon-tj"></i> 推荐管理</a></li>
                    <li><a data-pjax href="<?php echo HYBBS_URL('plugins','jing');?>"><i class="iconfont icon-tuijian1"></i> 精华管理</a></li>
                    <li><a data-pjax href="<?php echo HYBBS_URL('plugins','jubao');?>"><i class="iconfont icon-jubao"></i> 举报管理</a></li>
                    
                    <li><a href="<?php echo HYBBS_URL('admin');?>"><i class="iconfont icon-Administratorconfig"></i> 后台管理</a></li>
                    <?php endif ?>
                    <?php if (IS_LOGIN): ?>
                    <li style="border-top: 1px solid #ddd;"><a href="<?php echo HYBBS_URL('user','out');?>" style="color:red"><i class="iconfont icon-qiehuanzuhu"></i> 退出登录</a></li>
                    <?php endif ?>
                </div>
            </div>
            <!---->
        </div>
        <div class="m-actionsheet" id="yd-search" style="height: 100%;">
            <header class="m-navbar navbar-fixed">
                <a href="javascript:;" class="navbar-item" id="cancel">
                    <i class="icon-fanhui"></i>
                </a>
                <div class="navbar-center">
                    <span class="navbar-title">搜索</span>
                </div>
            </header>
            <div class="g-view" style="height:100%">
                <div class="sh">
                    <form id="form" action="<?php echo HYBBS_URL('search');?>">
                        <input id="sou" type="text" name="key" placeholder="输入关键词">
                        <button class="shbtn" type="submit" style="display: none">搜索</button>
                    </form>
                </div>
                <div class="resou" style="margin-top:10px;text-align: left;">
                    <div>热门搜索</div>
                    <?php $inc = get_plugin_inc('nd_website_plus');$sou = array_filter(explode(",",$inc['sou_key'])) ?>
                    <?php foreach ($sou as $k => $v): ?>
                        <a data-pjax href="<?php echo HYBBS_URL('search');?>?key=<?php echo $v;?>" style="<?php if ($k==0): ?>color: #ff5900;border: 1px solid #ff5900;<?php elseif ($k == 1): ?>color: #03a9f4;border: 1px solid #03a9f4;<?php elseif ($k==2): ?>color: #4cd864;border: 1px solid #4cd864;<?php endif ?>"><?php echo $v;?></a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <!-- banner -->
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="m-slider" style="height: 220px;margin-top:-50px;" id="J_Slider">
   
        <!-- 参数在这里 -->
    <div class="slider-wrapper">
    <?php $tmp = array_filter(explode("\r\n",view_form('nd_mobile','huandeng'))) ?>

    <?php foreach ($tmp as $sky=>$v): ?>
    <?php $tmp1 = explode(",",$v) ?>
        <div class="slider-item">
            <a href="<?php echo $tmp1['0'];?>">
                <img src="<?php echo $tmp1[2];?>" style="height: 100%;">
            </a>
            <div class="title"><?php echo $tmp1[1];?></div>
        </div>
    <?php endforeach ?>
    </div>
    <!-- 分页标识 -->
</div>
<div style="position: relative;">
    <div class="imui_water cube">
        <div class="imui_water_1"></div>
        <div class="imui_water_2"></div>
    </div>
</div>
<script>
    $(function(){
        $('#J_Slider').slider({
            speed: 200,
            autoplay: 2000,
            lazyLoad: true
        });
    })
</script>
        <div class="index_menu m-grids-3">
            <a data-pjax href="<?php echo HYBBS_URL('plugins','sign');?>" class="grids-item">
                <div class="grids-txt">
                    <div  class="sign">
                        <h1><i class="icon-qiandao4"></i></h1>
                        <span>签到有奖</span>
                    </div>
                </div>
            </a>
            <a data-pjax href="<?php echo HYBBS_URL('plugins','task');?>" class="grids-item">
                <div class="grids-txt">
                    <div class="task">
                        <h1><i class="icon-renwu"></i></h1>
                        <span>每日任务</span>
                    </div>
                </div>
            </a>
            <a href="<?php if (!IS_LOGIN): ?><?php echo HYBBS_URL('user','login');?><?php else: ?>javascript:;<?php endif ?>" <?php if (IS_LOGIN): ?>data-ydui-actionsheet="{target:'#ajax_post_page',closeElement:'#cancel-editor'}" onclick="ajax_post('<?php echo HYBBS_URL('post');?>','post')"<?php else: ?>data-pjax<?php endif ?> class="grids-item">
                <div class="grids-txt">
                    <div class="posts">
                        <h1><i class="icon-shequfatie"></i></h1>
                        <span>发布话题</span>
                    </div>
                </div>
            </a>
        </div>
        <!-- 功能推荐 -->
        <?php if (view_form('nd_mobile','bankuai_no') == 1): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<style>
    .forum_list{
        margin: 10px;
        border-radius: 5px;
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
    }
</style>
<style>
    .dis .swiper-container {
      width: 100%;
      height: auto;
      margin-left: auto;
      margin-right: auto;
    }
    .dis .swiper-slide {
      text-align: center;
      font-size: 16px;
      height: 85px;
      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
    }
    .dis>.swiper-pagination-bullets{
        bottom: 10px;
    }
  </style>
  <!-- Swiper -->
  <div style="margin: 10px;padding: 10px 0px 20px;background: #fff;overflow: hidden;border-radius: 5px;box-shadow:0 3px 17px -7px rgba(96, 125, 139, 0.31);position: relative;">

      <div class="dis">
        <div class="swiper-wrapper">
            <?php $forums = S('forum')->select('*',['id'=>explode(",",view_form('nd_mobile','bankuai'))]); ?>
            <?php foreach ($forums as $key => $v): ?>
            <div class="swiper-slide">
                <a href="<?php echo HYBBS_URL('forum',$v['id']);?>" data-pjax>
                    <div>
                        <img src="<?php echo WWW;?>upload/forum<?php echo $v['id'];?>.png" style="width: 45px;height: 45px;border-radius: 50%;" onerror="this.src='<?php echo WWW;?>upload/de.png'" alt="<?php echo $v['name'];?>">
                        <p style="width: 100%;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;color: #444;font-size: 14px;"><?php echo $v['name'];?></p>
                    </div>
                </a>
            </div>
            <?php endforeach ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
      </div>
  </div>
  <!-- Initialize Swiper -->

  <script>
    var swiper = new Swiper('.dis', {
      slidesPerView: 4,
      slidesPerColumn: 2,
      spaceBetween: 0,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  </script>
        <?php endif ?>
        <?php if (view_form('nd_mobile','zidingyi_html_no') == 1): ?>
        <?php echo view_form('nd_mobile','zidingyi_html') ?>
        <?php endif ?>

        <!-- 社区新帖 -->
        <?php if (view_form('nd_mobile','xintie_no') == 1): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<style>
.xintie li{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-size: 14px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    margin-bottom: 5px
}
.xintie li .user_img{
    display: flex;
    align-items: center;
}
.xintie li .user_img img{
    width: 25px;
    height: 25px;
    border-radius: 50%;
    margin-right: 5px;
}
.xintie li em{
    color: #9a9a9a;
}
.xintie li a{
    width: 100%;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    color: #444;
}
.xintie span{
    color: #8c8c8c;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
<div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4>社区新帖</h4>
    </div>
        <article class="m-list list-theme1" style="background: #fff;border-radius: 5px;margin: 10px;padding: 10px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
            <?php
                // 查询最新推送的4条数据
                $tuidata = M('Thread')->select('*',[
                    'ORDER'=>['atime'=>'DESC'],
                    'LIMIT'=>view_form('nd_mobile','xintie')  //返回4条
                ]);
                $User = M('User');
            ?>
            <ul class="xintie">
                <?php foreach ($tuidata as $k=>$v): ?>
                <?php $avatar = $User->avatar($User->uid_to_user($v['uid'])); ?>
                <li><div class="user_img"><img src="<?php echo $avatar['c'];?>" alt=""></div><a data-pjax href="<?php echo HYBBS_URL('thread',$v['tid']);?>"><?php echo $v['title'];?> <em><?php echo humandate($v['atime']) ?></em></a></li>
                <?php endforeach ?>
            </ul>
        </article>
    </div>
        <?php endif ?>
        <!-- 推荐阅读 -->
        <?php if (view_form('nd_mobile','tuijian_thread_no') == 1): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4>推荐阅读</h4>
    </div>
    <article class="m-list list-theme1" style="padding: 0 5px;">
        <?php
            // 查询最新推送的4条数据
            $tuidata = M('Thread')->select('*',[
                'jing'=>5,
                'ORDER'=>['atime'=>'DESC'],
                'LIMIT'=>view_form('nd_mobile','tuijian')  //返回4条
            ]);
            $User = M('User');
        ?>
        <?php foreach ($tuidata as $v): ?>
        <div style="box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
            <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" data-pjax class="list-item" style="padding:0 5px;margin-bottom: 10px;">
                <div class="list-img" style="padding:0;height:130px;position: relative;box-shadow: none;border-radius: 5px 5px 0 0">
                    <span style="position: absolute;background: #70d3ff;color: #fff;padding: 0px 2px;border-radius: 4px 0;"><?php echo $forum[$v['fid']]['name'] ?></span>
                    <?php if ($v['img']): ?>
                    <?php $img = explode(',',$v['img']) ?>
                    <?php endif ?>
                    <img class="lazyload" src="<?php echo WWW;?>View/nd_mobile/img/load_q.svg" data-original="<?php if ($v['img']): ?><?php echo $img['0'];?><?php else: ?><?php echo WWW;?>View/nd_mobile/img/nopic.png<?php endif ?>">
                    <span style="position: absolute;right: 10px;bottom: 10px;padding: 2px 6px;border-radius: 2px;color: #fff;align-items: center;display: flex;font-size: 12px;text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);"><i class="iconfont icon-yduizuji" style="font-size:12px;"></i>&nbsp;<?php echo $v['views'];?></span>
                </div>
                <div class="list-mes" style="background:#fff;padding:8px 10px;border-radius:0 0 5px 5px;box-shadow: 0 3px 14px -7px rgba(96, 125, 139, 0.31)">
                    <h3 class="list-title" style="font-size:14px"><?php echo $v['title'];?></h3>
                </div>
            </a>
        </div>
        <?php endforeach ?>
    </article>
</div>
        <?php endif ?>
        <!-- 专题推荐 -->
        <?php if (view_form('nd_mobile','huodong_thread_no') == 1): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde">

    <?php $tmp = array_filter(explode("\r\n",view_form('nd_mobile','huodong_banner'))) ?>
    <div style="position: relative;">
        <h4><?php echo view_form('nd_mobile','huodong_name') ?></h4>
    </div>
    <article class="m-list list-theme1 yuedu" style="padding:0">
    <!-- Swiper -->
    <style>
    .yuedu .swiper-container-horizontal>.swiper-pagination-bullets{
        bottom: 25px;
    }
    .zhuanti .img_row{
        height: 130px;width:100%
    }
    .zhuanti .img_row img{
        width: 100%;height:100%;border-radius: 5px;box-shadow: 0 3px 17px -7px #607D8B;
    }
    </style>
    <div class="zhuanti">
        <div class="swiper-wrapper">
            <?php foreach ($tmp as $v): ?>
            <?php $lianjie = explode("|",$v) ?>
            <div class="swiper-slide" style="padding: 10px;">
                <div class="img_row">
                    <a href="<?php echo $lianjie['0'];?>">
                        <img class="swiper-lazy" src="<?php echo WWW;?>View/nd_mobile/img/load_q.svg" data-src="<?php echo $lianjie['1'];?>">
                    </a>
                </div>
            </div>
            <?php endforeach ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <script>
        var swiper = new Swiper('.zhuanti',{
            lazy: {
                lazyLoading: true
            },
            pagination: {
                el: '.swiper-pagination',
                dynamicBullets: true,
            },
        });
    </script>
    </article>
</div>
        <?php endif ?>
        <!-- 精彩贴图 -->
        <?php if (view_form('nd_mobile','tupian_no') == 1): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde" style="margin-top:0">
    <div style="position: relative;text-align:center">
        <h4>精彩贴图</h4>
    </div>
    <article class="m-list list-theme1 meitu" style="padding: 0 5px;">
        <?php
            // 查询最新推送的4条数据
            $tuidata = M('Thread')->select('*',[
                // 'jing'=>3,
                'img[!]'=>'',
                'ORDER'=>['atime'=>'DESC'],
                'LIMIT'=>view_form('nd_mobile','tupian')  //返回4条
            ]);
            $User = M('User');
        ?>
        <?php foreach ($tuidata as $v): ?>
        <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" data-pjax class="list-item">
            <div class="list-img" style="padding:0;height:150px;position: relative;">
            <span style="position: absolute;right: 10px;top: 10px;color: #fff;text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);display: flex;align-items: center;"><i class="icon-zansel"></i> &nbsp;<?php echo $v['goods'];?></span>
                <?php if ($v['img']): ?>
                <?php $img = explode(',',$v['img']) ?>
                <?php endif ?>
                <img class="lazyload" src="<?php echo WWW;?>View/nd_mobile/img/load_q.svg" data-original="<?php if ($v['img']): ?><?php echo $img['0'];?><?php else: ?><?php echo WWW;?>View/nd_mobile/img/nopic.png<?php endif ?>">
                <div class="list-mes" style="background: rgba(0, 0, 0, 0.22);height: 28px;">
                    <h3 class="list-title"><?php echo $v['title'];?></h3>
                </div>
            </div>
        </a>
        <?php endforeach ?>
        
    </article>
</div>
        <?php endif ?>
        <!-- 广告位 1 -->
        <?php if (view_form('nd_mobile','guanggao_index_1_no') == 1): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<?php $gg = array_filter(explode(",",view_form('nd_mobile','guanggao_index_1'))) ?>
<div class="tuijianz" style="margin-left: 10px;margin-right: 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
    <a href="<?php echo $gg['0'];?>">
        <span>广告</span>
        <img src="<?php echo $gg['2'];?>" alt="<?php echo $gg['1'];?>">
    </a>
</div>
        <?php endif ?>
        <!-- 自定义板块推荐 -->
        <?php if (view_form('nd_mobile','zidingyibankuai_no') == 1): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4><?php echo view_form('nd_mobile','title') ?></h4>
    </div>
        <article class="m-list list-theme1">
            <?php
                // 查询最新推送的4条数据
                $tuidata = M('Thread')->select('*',[
                    // 'jing'=>5,
                    'fid'=>view_form('nd_mobile','fid'),
                    'ORDER'=>['atime'=>'DESC'],
                    'LIMIT'=>view_form('nd_mobile','tiaoshu')  //返回4条
                ]);
                $User = M('User');
            ?>
            <style>
            </style>
            <div class="swiper-container swiper-2">
                <div class="swiper-wrapper">
                    <?php foreach ($tuidata as $v): ?>
                    <div class="swiper-slide" style="padding:0 10px;">
                    <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" data-pjax class="list-item" style="width:100%;padding:0">
                        <div class="list-img" style="padding:0;height:160px;position: relative;box-shadow:none;border-radius:5px 5px 0 0;">
                            <span style="position: absolute;right: 10px;top: 10px;padding: 2px 6px;border-radius: 2px;color: #fff;align-items: center;display: flex;font-size: 14px;text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);"><i class="iconfont icon-yduizuji" style="font-size: 14px;"></i>&nbsp;<?php echo $v['views'];?>&nbsp;&nbsp;<i class="iconfont icon-huifu1" style="font-size: 14px;"></i>&nbsp;<?php echo $v['views'];?></span>
                            <?php if ($v['img']): ?>
                            <?php $img = explode(',',$v['img']) ?>
                            <?php endif ?>
                            <img class="lazyload swiper-lazy" src="<?php echo WWW;?>View/nd_mobile/img/load_q.svg" data-src="<?php if ($v['img']): ?><?php echo $img['0'];?><?php else: ?><?php echo WWW;?>View/nd_mobile/img/nopic.png<?php endif ?>">
                        </div>
                        <div class="list-mes" style="background: #fdfdfd;box-shadow: 0 3px 17px -10px #607D8B;margin-bottom: 10px;border-radius: 0 0 5px 5px;padding: 10px;">
                            <h3 class="list-title" style="font-size: 16px;"><?php echo $v['title'];?></h3>
                            <div class="list-mes-item" style="font-size: 14px;text-transform: capitalize;">
                                <div>
                                    <span class="list-price" style="color:rgba(3, 169, 244, 0.92)">
                                        <?php echo $forum[$v['fid']]['name'] ?></span>
                                    <span><?php echo humandate($v['atime']); ?></span>
                                </div>
                                <div><?php echo $User->uid_to_user($v['uid']) ?></div>
                            </div>
                        </div>
                    </a>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </article>
    </div>
        <?php endif ?>
        <!-- 推荐关注 -->
        <?php if (view_form('nd_mobile','guanzhu_no') == 1): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4>推荐关注</h4>
    </div>
        <article class="m-list list-theme1">
            <?php
                $num = view_form('nd_mobile','guanzhu');
                $pdo = S('Plugin')->query("select * from hy_user order by rand() limit $num");
                $data = $pdo->fetchAll(\PDO::FETCH_ASSOC);
                // 查询最新推送的4条数据
                $User = M('User');
            ?>
            <div class="swiper-container guanzhu">
                <div class="swiper-wrapper" style="margin: 10px 0;">
                    <?php foreach ($data as $v): ?>
                    <div class="swiper-slide tuijian_guanzhu_1" style="padding:0 10px;">
                        <div style="text-align: center;background: #fff;padding: 15px 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
                            <a href="<?php echo HYBBS_URL('my',$v['user']);?>">
                                <div style="position: relative;">
                                    <span style="position: relative;">
                                    <?php if (is_vip($v['uid'])): ?><i style="position: absolute;left: -7px;font-size: 2.5rem;top: -64px;color: #FF5722;transform: rotate(274deg);" class="iconfont icon-huangguan2"></i><?php endif ?>
                                    <img class="swiper-lazy" src="<?php echo WWW;?>View/nd_mobile/img/load_q_2.svg" data-src="<?php echo WWW;?><?php echo $User->avatar($v['user'])['b'] ?>" style="border-radius: 50%; width: 65px;<?php if (is_vip($v['uid'])): ?>border:3px solid #FF5722;<?php endif ?>">
                                
                                    </span>
                                </div>
                                <?php

                                ?>
                                <div class="name">
                                <?php
                                    $renzheng_inc = get_plugin_inc('nd_renzheng');
                                ?>
                                <span class="user_name" style="<?php if (is_vip($v['uid'])): ?>color:<?php echo $renzheng_inc['color'];?><?php endif ?>">
                                    <?php echo $v['user'];?>
                                    <?php
                                    // 查询验证
                                    $is_renzheng = S('user')->find('renzheng',['uid'=>$v['uid']]);
                                    ?>
                                    <?php if ($is_renzheng): ?>
                                    <i style="color:<?php echo $renzheng_inc['yan_color'];?>" class="iconfont icon-renzheng"></i>
                                    <?php endif ?>
                                </span>
                                </div>
                                <div class="thread">帖子 <?php echo $v['threads'];?></div>
                                <div class="sign"><?php if ($v['ps']): ?><?php echo $v['ps'];?><?php else: ?>还没有留下签名！<?php endif ?></div>
                            </a>
                            <div>
                                <button class="<?php if ($v['sex'] == 0): ?>weizhi<?php elseif ($v['sex'] == 1): ?>nan_1<?php else: ?>nv_1<?php endif ?>" onclick="friend(<?php echo $v['uid'];?>,this)"><?php if (M("Friend")->get_state(NOW_UID,$v['uid'])): ?>取消关注<?php else: ?><i class="icon-plus"></i>关注<?php endif ?></button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
                <script>
                    var swiper1 = new Swiper('.guanzhu', {
                        slidesPerView: 2,
                        spaceBetween : -13,
                        freeMode: true,
                        lazy: {
                            lazyLoading: true
                        },
                    });
                </script>
            </div>
        </article>
    </div>
        <?php endif ?>
        <!-- 广告位 2 -->
        <?php if (view_form('nd_mobile','guanggao_index_2_no') == 1): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<?php $gg = array_filter(explode(",",view_form('nd_mobile','guanggao_index_2'))) ?>
<div class="tuijianz" style="margin-left: 10px;margin-right: 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
    <a href="<?php echo $gg['0'];?>">
        <span>广告</span>
        <img src="<?php echo $gg['2'];?>" alt="<?php echo $gg['1'];?>">
    </a>
</div>
        <?php endif ?>
        
        <!-- 精华文章 -->
        <?php if (view_form('nd_mobile','jinghua_no') == 1): ?>
        <div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4>精华文章</h4>
    </div>
    <article class="m-list list-theme1">
        <?php
            // 查询最新推送的4条数据
            $tuidata = M('Thread')->select('*',[
                'jing'=>1,
                // 'img[!]'=>'',
                'ORDER'=>['atime'=>'DESC'],
                'LIMIT'=>view_form('nd_mobile','jinghua')  //返回4条
            ]);
        ?>
        <div class="swiper-2">
            <div class="swiper-wrapper">
                <?php foreach ($tuidata as $v): ?>
                <div class="swiper-slide" style="padding:0 10px;">
                <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" data-pjax class="list-item" style="width:100%;padding:0;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);margin-bottom: 10px;">
                    <div class="list-img" style="padding:0;height:160px;border-radius: 5px 5px 0 0;box-shadow: none;position: relative;">
                        <span style="position: absolute;background: #70d3ff;color: #fff;padding: 2px 6px;border-radius: 5px 0;"><?php echo $forum[$v['fid']]['name'] ?></span>
                        <?php if ($v['img']): ?>
                        <?php $img = explode(',',$v['img']) ?>
                        <?php endif ?>
                        <img class="lazyload swiper-lazy" src="<?php echo WWW;?>View/nd_mobile/img/load_q.svg" data-src="<?php if ($v['img']): ?><?php echo $img['0'];?><?php else: ?><?php echo WWW;?>View/nd_mobile/img/nopic.png<?php endif ?>">
                        
                        <span style="position: absolute;right: 10px;bottom: 10px;padding: 2px 6px;border-radius: 2px;color: #fff;align-items: center;display: flex;font-size: 14px;text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);"><i class="iconfont icon-yduizuji" style="font-size: 14px;"></i>&nbsp;<?php echo $v['views'];?></span>
                    </div>
                    <div class="list-mes" style="background:#fff;padding:8px 10px;border-radius:0 0 5px 5px;">
                        <h3 class="list-title" style="font-size:14px"><?php echo $v['title'];?></h3>
                    </div>
                </a>
                </div>
                <?php endforeach ?>
            </div>
        </div>

        <!-- Initialize Swiper -->
        <script>
            var swiper1 = new Swiper('.swiper-2', {
            slidesPerView: 1,
            lazy: {
                lazyLoading: true,
            },
            spaceBetween : -13,
            });
        </script>
    </article>
</div>
        <?php endif ?>
        <!-- 新帖热帖 无限下拉 -->
        <style>
        .index_xin {text-align:center;margin-bottom: 15px;}
        .index_xin a{font-size: 16px;margin: 5px;font-weight: bold;padding-bottom: 5px;color:#444}
        .jiazai {text-align: center;margin: 20px;}
        .jiazai a{background: #37bbf7;padding:8px 12px;color: #fff;border-radius: 33px;box-shadow: 0 4px 20px -4px rgba(0, 188, 212, 0.54);}
        </style>
        <div class="index_xin">
            <a href="javascript:;">热门推荐</a>
        </div>
        <div id="index-list">
            <!--ajax start-->
        <?php foreach ($thread_list as $v): ?>
        <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>

<div class="nd_list_1">
        <div class="list_header">
            <?php $sex = S('user')->find('sex',['uid'=>$v['uid']]) ?>
            <a href="<?php echo HYBBS_URL('my',$v['user']);?>" style="position: relative;" data-pjax>
                <?php if (is_vip($v['uid'])): ?><i style="position: absolute;left: -4px;font-size: 30px;top: -8px;color: #FF5722;transform: rotate(278deg);" class="iconfont icon-huangguan2"></i><?php endif ?>
                <img style="<?php if (is_vip($v['uid'])): ?>border:2px solid #FF5722;<?php endif ?>width:45px;height:45px;" src="<?php echo WWW;?><?php echo $v['avatar']['b'];?>" alt="<?php echo $v['user'];?>">
            </a>
                <div class="title">
                    <div>
                        <div class="jcenter">
                            <a href="<?php echo HYBBS_URL('my',$v['user']);?>" data-pjax> 
                                <?php
                                    $renzheng_inc = get_plugin_inc('nd_renzheng');
                                ?>
                                <?php
                                // 查询验证
                                $is_renzheng = S('user')->find('renzheng',['uid'=>$v['uid']]);
                                ?>
                                <span class="user_name" style="<?php if (is_vip($v['uid']) || $is_renzheng): ?>color:<?php echo $renzheng_inc['color'];?><?php endif ?>">
                                    <?php echo $v['user'];?>
                                    <?php if ($is_renzheng): ?>
                                    <i style="color:<?php echo $renzheng_inc['yan_color'];?>" class="iconfont icon-renzheng"></i>
                                    <?php endif ?>
                                </span>
                            </a>
                            
                        </div>                        
                        <p style="margin-left:-3px;">
                            <?php
                                $inc = get_plugin_inc('nd_website_plus');
                                $lv = array_filter(explode("\r\n",$inc['user_lv']));
                                $lv_limit = count($lv);
                                $credits = S('User')->find('credits',['uid'=>$v['uid']]);
                            ?>
                            <!-- 性别 -->
                            <?php if ($sex == 0): ?>
                            <!-- 没设置 -->
                            <span class="lv no">
                                <i class="iconfont icon-xingbie"><?php $user_data = M('User')->read($v['uid']);; $age =  date('Y')-date('Y',$user_data['age']) ?><?php if ($age!=0): ?><?php echo $age;?><?php endif ?></i>
                            </span>
                            <?php elseif ($sex == 1): ?>
                            <!-- 男 -->
                            <span class="lv nan">
                                <i class="iconfont icon-nan1"><?php $user_data = M('User')->read($v['uid']);; $age =  date('Y')-date('Y',$user_data['age']) ?><?php if ($age!=0): ?><?php echo $age;?><?php endif ?></i>
                            </span>
                            <?php else: ?>
                            <!-- 女 -->
                            <span class="lv nv">
                                <i class="iconfont icon-nv1"><?php $user_data = M('User')->read($v['uid']);; $age =  date('Y')-date('Y',$user_data['age']) ?><?php if ($age!=0): ?><?php echo $age;?><?php endif ?></i>
                            </span>
                            <?php endif ?>
                            <!-- 等级 -->
                            <?php foreach ($lv as $key => $lv): ?>
                            <?php $user_lv = explode("|",$lv); ?>
                                <?php if ($credits < $user_lv['0']): ?>
                                <span class="lv" style="color: <?php echo $user_lv['1'];?>;background: <?php echo $user_lv['2'];?>;border-radius: 1.5px;font-size: 12px;padding: 2px 4px;box-shadow: 0 1px 10px -2px <?php echo $user_lv['2'];?>;">Lv.<?php echo $key+1;?></span>
                                <?php break; ?>
                                <?php endif ?>
                                <?php if ($key+1 == $lv_limit && $credits > $user_lv['0']): ?>
                                <span class="lv max">Lv.Max</span>
                                <?php break; ?>
                                <?php endif ?>
                            <?php endforeach ?>
                            <!-- 用户组 -->
                            <?php
                                $gid =  S('User')->find('gid',['uid'=>$v['uid']]);
                                $gname = M("Usergroup")->gid_to_name($gid);
                                
                                $style = array_filter(explode("\r\n",$inc['style']));
                            ?>
                            <?php foreach ($style as $style): ?>
                            <?php $sty = explode("|",$style); ?>
                            <?php if ($sty['0'] == $gid): ?>
                            <span class="lv group" style="color:<?php echo $sty['1'];?>;background:<?php echo $sty['2'];?>;box-shadow: 0 1px 10px -2px <?php echo $sty['2'];?>;"><?php echo $gname;?></span>
                            <?php endif ?>
                            <?php endforeach ?>    
                        <?php //echo humandate($v['atime']); ?></p>
                    </div>
                    <?php if (NOW_UID != $v['uid']): ?>
                    <a href="javascript:;" onclick="friend(1,this)" class="btn_gz jcenter"><?php if (M("Friend")->get_state(NOW_UID,$v['uid'])): ?>取消关注<?php else: ?><i class="icon-plus"></i>关注<?php endif ?></a>
                    <?php endif ?>
                </div>
            </div>
            <div class="list_content" style="position: relative;">
                
                <?php if ($v['jing'] == 1): ?>
                    <img class="tuzhang" src="<?php echo WWW;?>View/nd_mobile/img/stamp/001.gif" alt="">
                <?php endif ?>
                <?php if ($v['jing'] == 2): ?>
                    <img class="tuzhang" src="<?php echo WWW;?>View/nd_mobile/img/stamp/002.gif" alt="">
                <?php endif ?>
                <?php if ($v['jing'] == 3): ?>
                    <img class="tuzhang" src="<?php echo WWW;?>View/nd_mobile/img/stamp/003.gif" alt="">
                <?php endif ?>
                <?php if ($v['jing'] == 4): ?>
                    <img class="tuzhang" src="<?php echo WWW;?>View/nd_mobile/img/stamp/004.gif" alt="">
                <?php endif ?>
                <?php if ($v['jing'] == 5): ?>
                    <img class="tuzhang" src="<?php echo WWW;?>View/nd_mobile/img/stamp/006.gif" alt="">
                <?php endif ?>
                <?php if ($v['jing'] == 6): ?>
                    <img class="tuzhang" src="<?php echo WWW;?>View/nd_mobile/img/stamp/007.gif" alt="">
                <?php endif ?>
                <?php if ($v['jing'] == 7): ?>
                    <img class="tuzhang" src="<?php echo WWW;?>View/nd_mobile/img/stamp/009.gif" alt="">
                <?php endif ?>
                <?php if ($v['jing'] == 8): ?>
                    <img class="tuzhang" src="<?php echo WWW;?>View/nd_mobile/img/stamp/banzhurenzhen.png" alt="">
                <?php endif ?>
                <?php if ($v['jing'] == 9): ?>
                    <img class="tuzhang" src="<?php echo WWW;?>View/nd_mobile/img/stamp/008.gif" alt="">
                <?php endif ?>
                <div class="content_img_list">
                    <?php if (!empty($v['img'])): ?>
                        <?php $img = array_filter(explode(',',$v['img'])); ?>
                        
                        <div class="thread_content" style="box-shadow: none;">
                        <a class="forum_name" href="<?php echo HYBBS_URL('forum',$v['fid']);?>" data-pjax style="color:<?php echo $forum[$v['fid']]['color'];?>;"><span>#<?php echo $forum[$v['fid']]['name'];?>#</span></a> 
                        <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" data-pjax>
                            <span><?php echo $v['title'];?></span>
                        </a>
                        
                        <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" data-pjax>
                            <div class="summary"><?php echo $v['summary'];?></div>
                        </a>
                        </div>
                        <div class="m-grids-3">
                            <?php foreach ($img as $keys=>$vals): ?>
                            <div href="#" class="grids-item">
                                <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" data-pjax>
                                    <img class="lazyload" src="<?php echo WWW;?>View/nd_mobile/img/load_q.svg" data-original="<?php echo $vals;?>" alt="<?php echo $v['title'];?>-<?php echo $keys+1;?>" >
                                </a>
                            </div>
                            <?php if ($keys == 5): ?>
                            <?php break; ?>
                            <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    <?php else: ?>
                    <div class="m-grids-1">
                        <div class="thread_content" style="box-shadow: none;">
                        <a class="forum_name" href="<?php echo HYBBS_URL('forum',$v['fid']);?>" data-pjax style="color:<?php echo $forum[$v['fid']]['color'];?>;"><span>#<?php echo $forum[$v['fid']]['name'];?>#</span></a> 
                        <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" data-pjax>
                            <span><?php echo $v['title'];?></span>
                        </a>
                        
                        <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>" data-pjax>
                            <div class="summary"><?php echo $v['summary'];?></div>
                        </a>
                        </div>
                    </div>
                    <?php endif ?>
                </div>
            </div>
    <div class="list_footer">
        <div class="m-grids-3">
            <a href="<?php echo HYBBS_URL('thread',$v['tid']);?>#thread_post" data-pjax class="grids-item">
                <div class="grids-txt">
                    <span>
                        <i class="icon-huifu1"></i> <?php echo $v['posts'];?>回复</span>
                </div>
            </a>
            <a href="javascript:;" class="grids-item">
                <div class="grids-txt">
                    <span>
                        <i class="iconfont icon-yduizuji"></i> <?php if ($v['views']): ?><?php echo $v['views'];?><?php endif ?>人踩过</span>
                </div>
            </a>
            <a href="javascript:;" class="grids-item">
                <div class="grids-txt">
                    <span class="zan" onclick="tp('thread1',<?php echo $v['tid'];?>,this)">
                        <i class="icon-zansel"></i> <p><?php if ($v['goods']): ?><?php echo $v['goods'];?><?php endif ?></p><span>喜欢</span></span>
                </div>
            </a>
        </div>
    </div>
</div>
<?php if ($k == rand(1,10)): ?>
    <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<?php $gg = array_filter(explode(",",view_form('nd_mobile','guanggao_forum'))) ?>
<div class="tuijianz">
    <a href="<?php echo $gg['0'];?>">
        <span>广告</span>
        <img src="<?php echo $gg['2'];?>" alt="<?php echo $gg['1'];?>">
    </a>
</div>
<?php endif ?>
        <?php endforeach ?>
            <!--ajax end-->
        </div>
        <div class="jiazai"><a href="javascript:;" data-page="<?php echo $pageid;?>" onclick="ajax_list(this)">加载更多</a></div>
        <script>
                function ajax_list(obj){
                    $(obj).text('加载中...');
                    var page = parseInt($(obj).attr("data-page")) + 1;
                    var url = "<?php echo HYBBS_URL('new','"+page+"'); ?>";
                    
                    var pege_count = "<?php echo $page_count;?>";
                    if (page <= pege_count) {
                            $.get(url, function(s) {
                                s = s.replace(/\\n|\\r/g, "");
                                s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                                $('#index-list').append(s);
                                $('#load-forun').attr('url', page);
                                $(obj).removeClass('btn-disabled');
                                $("img.lazyload").lazyload();
                                $(obj).attr('data-page',page).text('加载更多')
                            });

                    } else {
                        $('#load-forun span').text('- 我是有底线的 -');
                    };
                };
        </script>
        <?php if (view_form('nd_mobile','links_no') == 1): ?>
        <!-- 友情链接 -->
        <div class="nd_crde">
            <div style="position: relative;">
                <h4>友情链接
                    <a href="<?php echo view_form('nd_mobile','links_shenqing') ?>"><span style="float:right;color:#03a9f4">申请</span></a>
                </h4>
            </div>
            <article class="m-list list-theme1 links" style="padding:0">
                <div class="m-grids-4" style="margin: 10px 12px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
                <?php $links = array_filter(explode("\r\n",view_form('nd_mobile','links'))) ?>
                <?php foreach ($links as $v): ?>
                    <?php $youlian = explode(",",$v) ?>
                    <a href="<?php echo $youlian['0'];?>" class="grids-item">
                        <div class="grids-txt"><span><?php echo $youlian['1'];?></span></div>
                    </a>
                <?php endforeach ?>
                </div>
                <style>
                .links .m-grids-4 .grids-item:after{
                    border-bottom: 1px solid #D9D9D9;
                }
                </style>
            </article>
        </div>
        <?php endif ?>
        <div class="index_footer">
            <?php echo view_form('nd_mobile','index_footer');?>
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