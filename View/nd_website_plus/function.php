<?php

function plugin_install()
{

    if(!get_plugin_install_state("nd_website_plus"))
    {
        $sql = <<<sql
        ALTER TABLE `hy_user` 
            ADD `age` INT(11) NOT NULL COMMENT '年龄' AFTER `email`, 
            ADD `sex` INT NULL DEFAULT '0' COMMENT '性别' AFTER `age`, 
            ADD `city` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '城市' AFTER `sex`,
            ADD `email_state` INT(1) NULL DEFAULT '0' AFTER `city`,
            ADD `avatar_state` INT(1) NULL DEFAULT '0' COMMENT '头像状态' AFTER `email_state`;
        ALTER TABLE `hy_thread` ADD `jing` TINYINT(2) NOT NULL COMMENT '精华' AFTER `state`;

        CREATE TABLE `hy_user_sign` (
            `sign_code` int(8) NOT NULL COMMENT '签到id',
            `sign_uid` int(11) DEFAULT NULL COMMENT '用户id',
            `signcount` int(11) DEFAULT '0' COMMENT '连续签到次数',
            `count` int(11) DEFAULT '0' COMMENT '签到次数',
            `lastModifyTime` datetime DEFAULT NULL COMMENT '最后修改时间'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='签到记录表' ROW_FORMAT=COMPACT;
          
        CREATE TABLE `hy_user_sign_record` (
            `recorde_id` int(8) NOT NULL COMMENT '签到历史记录id',
            `sign_code` int(8) DEFAULT NULL COMMENT '签到id',
            `sign_time` datetime DEFAULT NULL COMMENT '签到时间'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='签到历史记录表' ROW_FORMAT=DYNAMIC;
        
        CREATE TABLE IF NOT EXISTS `hy_plugins_post` (
            `uid` int(11) DEFAULT '0',
            `post_state` int(11) DEFAULT '0',
            `post_atime` int(11) DEFAULT '0',
            `thread_state` int(11) DEFAULT '0',
            `thread_atime` int(11) DEFAULT '0'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        CREATE TABLE IF NOT EXISTS `hy_plugins_collection` (
            `id` int(11) NOT NULL,
            `uid` int(11) DEFAULT '0',
            `tid` int(11) DEFAULT '0',
            `atime` int(11) DEFAULT '0'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `hy_plugins_myforum` (
            `id` int(11) NOT NULL,
            `uid` int(11) NOT NULL,
            `fid` int(11) NOT NULL,
            `atime` int(11) NOT NULL COMMENT '最后访问'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ALTER TABLE `hy_user_sign`
        ADD PRIMARY KEY (`sign_code`);

        ALTER TABLE `hy_user_sign_record`
        ADD PRIMARY KEY (`recorde_id`);

        ALTER TABLE `hy_user_sign`
        MODIFY `sign_code` int(8) NOT NULL AUTO_INCREMENT COMMENT '签到id';


        ALTER TABLE `hy_user_sign_record`
        MODIFY `recorde_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '签到历史记录id';

        ALTER TABLE `hy_plugins_myforum`
        ADD PRIMARY KEY (`id`);
            
        ALTER TABLE `hy_plugins_myforum`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
      
        ALTER TABLE `hy_plugins_collection`
            ADD PRIMARY KEY (`id`);
        ALTER TABLE `hy_plugins_collection`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        CREATE TABLE IF NOT EXISTS `hy_plugins_share` (
            `id` int(11) NOT NULL,
            `tid` int(11) DEFAULT '0',
            `share` int(11) DEFAULT '0'
            ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
        ALTER TABLE `hy_plugins_share`
            ADD PRIMARY KEY (`id`);
        ALTER TABLE `hy_plugins_share`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;

        ALTER TABLE `hy_forum` ADD `bg_img` VARCHAR(255) NOT NULL AFTER `background`;
        ALTER TABLE `hy_forum` ADD `bangui` TEXT NOT NULL COMMENT '版规' AFTER `bg_img`;
        CREATE TABLE IF NOT EXISTS `hy_plugins_jubao` ( 
            `id` INT NOT NULL AUTO_INCREMENT , 
            `tid` INT NOT NULL COMMENT '帖子id' , 
            `atime` INT NOT NULL COMMENT '举报时间' , 
            `state` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '举报内容' , 
            `uid` INT NOT NULL COMMENT '举报用户，0=游客' , 
            `mess` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '留言' , 
            PRIMARY KEY (`id`)) ENGINE = InnoDB;
        ALTER TABLE `hy_plugins_jubao` ADD UNIQUE(`id`);
sql;
        $data = S("user");
       if($data -> query($sql))
        {
            copy(PLUGIN_PATH.'nd_website_plus/Plugins.php',ACTION_PATH.'Plugins.php'); 
            copy(PLUGIN_PATH.'nd_website_plus/Coterie.php',ACTION_PATH.'Coterie.php');
            file_put_contents(PLUGIN_PATH."nd_website_plus/on","");
            return true;
        }else{
           return false;
       }
    }else{
        return false;
    }

}

function plugin_uninstall()
{
    if (get_plugin_install_state("nd_website_plus"))
    {
        $data = S("user");
        $sql = <<<sql
        DROP table 
            `hy_user_sign`,
            `hy_user_sign_record`,
            `hy_plugins_post`,
            `hy_plugins_collection`,
            `hy_plugins_share`,
            `hy_plugins_myforum`,
            `hy_plugins_jubao`;

        ALTER TABLE `hy_user` 
            DROP `age`, 
            DROP `sex`, 
            DROP `city`, 
            DROP `email_state`, 
            DROP `avatar_state`;

        ALTER TABLE `hy_forum` 
            DROP `bg_img`,
            DROP `bangui`;

        ALTER TABLE `hy_thread`
            DROP `jing`;
sql;
        if($data -> query($sql))
        {
            unlink(ACTION_PATH."Plugins.php");
            unlink(ACTION_PATH."Coterie.php");
            unlink(PLUGIN_PATH."nd_website_plus/on");
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }

}

