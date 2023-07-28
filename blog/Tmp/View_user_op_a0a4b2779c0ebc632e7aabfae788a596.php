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
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <span class="navbar-title">设置</span>
    </div>
</header>
<style>

.fileInputContainer{
    height:75px;
    background:url('<?php echo WWW;?><?php echo $data['avatar']['b'];?>?s=<?php echo NOW_TIME;?>');
    position:relative;
    width: 75px;
    background-repeat: round;
    border-radius: 100%
}
.fileInputContainer span{
    position: absolute;
    right: -7px;
    bottom: 3px;
}
.fileInputContainer span i{
    color: #9C27B0;
    font-size: 20px;
}
.fileInputContainer .fileInput{
    height:75px;
    overflow: hidden;
    font-size: 300px;
    position:absolute;
    right:0;
    top:0;
    opacity: 0;
    filter:alpha(opacity=0);
    cursor:pointer;
}
</style>
<div class="g-view">
    <div class="text-center" style="padding: 15px;background: #fff;margin-bottom: 15px;justify-content: center;align-items: center;display: flex;">
        <div class="fileInputContainer">
            <form action="" enctype="multipart/form-data">
                <input id="upfile" class="fileInput" type="file" name="photo" accept="image/*" multiple="multiple" onchange="updata_avatar()"/>
            </form>
            <span><i class="iconfont icon-shangchuan"></i></span>
        </div> 
    </div>
    <div class="m-celltitle">邮箱验证</div>
    <div class="m-cell">
        <div class="cell-item">
            <div class="cell-left">
                <input type="text" name="email" class="cell-input" placeholder="邮箱地址" value="<?php echo $data['email'];?>" <?php if ($data['email_state'] ==1): ?>disabled<?php endif ?>/>
            </div>
            <div class="cell-right">
                <?php if ($data['email_state'] ==0): ?>
                <a href="javascript:;" class="btn btn-primary" style="margin:10px 0;" id="J_GetCode">发送验证</a>
                <?php else: ?>
                <i class="iconfont icon-gou_1" style="color: #04BE02;"></i>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="m-celltitle">基本信息</div>
    <div class="m-cell">
        <div class="cell-item">
            <div class="cell-right">
                <input type="text" class="cell-input" placeholder="用户名"value="<?php echo $data['user'];?>" disabled/>
            </div>
        </div>
        <div class="cell-item">
            <label class="cell-right cell-arrow">
                <select class="cell-select" style="color: #7d7d7d;margin-left: 0px;">
                    <option name="sex" value="0" <?php if ($data['sex'] == 0): ?>selected<?php endif ?>>性别</option>
                    <option name="sex" value="1" <?php if ($data['sex'] == 1): ?>selected<?php endif ?>>男</option>
                    <option name="sex" value="2" <?php if ($data['sex'] == 2): ?>selected<?php endif ?>>女</option>
                </select>
            </label>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <input id="date" class="cell-input" type="date" name="age" value="<?php if ($data['age'] != '0'): ?><?php echo date('Y-m-d',$data['age']);?><?php endif ?>" placeholder="年龄">
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <input type="text" name="sign" class="cell-input" placeholder="签名" value="<?php echo $data['ps'];?>"/>
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <!-- <input type="text" name="city" class="cell-input" placeholder="城市" value="<?php echo $data['city'];?>"/> -->
                <input type="text" name="city" class="cell-input" readonly id="J_Address" placeholder="<?php if ($data['city']): ?><?php echo $data['city'];?><?php else: ?>城市<?php endif ?>">
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <a href="javascript:;" class="btn-block btn-primary" style="margin:10px 0;" onclick="modify()">修改资料</a>
            </div>
        </div>
    </div>
    <div class="m-celltitle">修改密码</div>
    <div class="m-cell">
        <div class="cell-item">
            <div class="cell-right">
                <input type="hidden" name="gn" class="cell-input" value="pass">
                <input type="text" name="pass0" class="cell-input" placeholder="旧密码"/>
            </div>
        </div>
        <div class="cell-item">

            <div class="cell-right">
                <input type="text" name="pass1" class="cell-input" placeholder="新密码"/>
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <input type="text" name="pass2" class="cell-input" placeholder="重复新密码"/>
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <a href="javascript:;" class="btn-block btn-danger" style="margin:10px 0;" onclick="pass()">修改密码</a>
            </div>
        </div>
    </div>
</div>
<script>
    // 头像上传
    function updata_avatar(){
        var formData = new FormData();
            formData.append("photo",document.getElementById("upfile").files[0]);
            YDUI.dialog.loading.open('上传中');
            $.ajax({
                type: "POST", // 数据提交类型
                url: "<?php HYBBS_URL('user','ava'); ?>", // 发送地址
                data: formData, //发送数据
                async: true, // 是否异步
                processData: false, //processData 默认为false，当设置为true的时候,jquery ajax 提交的时候不会序列化 data，而是直接使用data
                contentType: false, //
                success:function(e){
                    if(e.error){
                        YDUI.dialog.loading.close();
                        YDUI.dialog.toast(e.info, 'success', 1500);
                        // window.location.reload();
                    }else{
                        YDUI.dialog.loading.close();
                        YDUI.dialog.toast(e.info, "error", 1500);
                    }
                }
            });
    }
    function pass(){
        var data = {
                uid:'<?php echo $data['uid'];?>',
                gn:$('[name="gn"]').val(),
                pass0:$('[name="pass0"]').val(),
                pass1:$('[name="pass1"]').val(),
                pass2:$('[name="pass2"]').val()
            };
            YDUI.dialog.loading.open('提交中');
            $.post("<?php echo HYBBS_URL('user','Edit');?>",data,function(e){
                if(e.error){
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, 'success', 1500);
                }else{
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, "error", 1500);
                }
            },'json');        
    }
    function modify(){
        var data = {
                uid:'<?php echo $data['uid'];?>',
                age:$('[name="age"]').val(),
                sex:$('[name="sex"]option:selected').val(),
                city:$('[name="city"]').val(),
                sign:$('[name="sign"]').val()
            };
            YDUI.dialog.loading.open('提交中');
            $.post("<?php echo HYBBS_URL('plugins','modify');?>",data,function(e){
                if(e.error){
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, 'success', 1500);
                }else{
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, "error", 1500);
                }
            },'json');
    }

    $(function(){
        
        var $getCode = $('#J_GetCode');
        /* 定义参数 */
        $getCode.sendCode({
            disClass: 'btn-disabled',
            secs: 15,
            run: false,
            runStr: '{%s}秒后重新获取',
            resetStr: '重新发送'
        });
        $getCode.on('click', function () {
            /* ajax 成功发送验证码后调用【start】 */
            YDUI.dialog.loading.open('发送中');
            $.post("<?php echo HYBBS_URL('plugins','Activate_mail');?>",{email:$('[name="email"]').val()},function(e){
                if(e.error){
                    YDUI.dialog.loading.close();
                    $getCode.sendCode('start');
                    YDUI.dialog.toast(e.info, 'success', 1500);
                }else{
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, "error", 1500);
                }
            },'json');     
        });
        // 解决移动端输入框dete属性placeholder无效
        var o = document.getElementById('date');
        o.onfocus = function(){
            this.removeAttribute('placeholder');
        };
        o.onblur = function(){
            if(this.value == ''){
                this.setAttribute('placeholder','年龄');
            }
        };
        // 省级联动
        $("head").append('<script src="<?php echo WWW;?>View\/nd_mobile\/js\/ydui.citys.js"><\/script>');
        var $address = $('#J_Address');

        $address.citySelect();

        $address.on('click', function () {
            $address.citySelect('open');
        });

        $address.on('done.ydui.cityselect', function (ret) {
            /* 省：ret.provance */
            /* 市：ret.city */
            /* 县：ret.area */
            $(this).val(ret.provance + ' ' + ret.city + ' ' + ret.area);
        });
    });
</script>

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