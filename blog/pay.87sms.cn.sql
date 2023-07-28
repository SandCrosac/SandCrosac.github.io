-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2021-11-25 21:48:57
-- 服务器版本： 5.6.50-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mh_87sms_cn`
--

-- --------------------------------------------------------

--
-- 表的结构 `hy_cache`
--

CREATE TABLE IF NOT EXISTS `hy_cache` (
  `cachekey` varchar(255) NOT NULL,
  `expire` int(11) NOT NULL,
  `data` blob,
  `datacrc` int(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_chat`
--

CREATE TABLE IF NOT EXISTS `hy_chat` (
  `id` int(10) unsigned NOT NULL,
  `uid1` int(10) unsigned NOT NULL,
  `uid2` int(10) unsigned NOT NULL,
  `content` tinytext,
  `atime` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_chat`
--

INSERT INTO `hy_chat` (`id`, `uid1`, `uid2`, `content`, `atime`) VALUES
(1, 1, 0, '今日签到成功<br>系统奖励您1金币和10积分', 1637839243),
(2, 2, 0, '您好，恭喜成功注册成为本站用户，系统将赠送您10个金币和10点积分，在本站发帖请遵守国家法律，如遇到问题可以联系管理员：admin', 1637843358),
(3, 2, 0, '您好，恭喜成功注册成为本站用户，系统将赠送您10个金币和10点积分，在本站发帖请遵守本站规定。官方QQ:475533741', 1637843358);

-- --------------------------------------------------------

--
-- 表的结构 `hy_chat_count`
--

CREATE TABLE IF NOT EXISTS `hy_chat_count` (
  `uid` int(10) unsigned NOT NULL,
  `c` int(11) NOT NULL DEFAULT '0',
  `atime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_chat_count`
--

INSERT INTO `hy_chat_count` (`uid`, `c`, `atime`) VALUES
(1, 0, 1637839243),
(2, 0, 1637843358);

-- --------------------------------------------------------

--
-- 表的结构 `hy_count`
--

CREATE TABLE IF NOT EXISTS `hy_count` (
  `name` varchar(12) NOT NULL,
  `v` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_count`
--

INSERT INTO `hy_count` (`name`, `v`) VALUES
('A1.0', 1),
('A1.1', 1),
('A1.2', 1),
('1.5', 1),
('1.5.1', 1),
('1.5.27', 1),
('1.5.33', 1),
('2.0', 1),
('2.0.12', 1),
('2.0.17', 1),
('2.0.20', 1),
('2.1.0', 1),
('2.1.3', 1),
('2.2', 1),
('2.2.1', 1),
('thread', 0);

-- --------------------------------------------------------

--
-- 表的结构 `hy_file`
--

CREATE TABLE IF NOT EXISTS `hy_file` (
  `id` int(10) unsigned NOT NULL COMMENT '附件ID',
  `uid` int(10) unsigned NOT NULL COMMENT '附件主人UID',
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `filename` text COMMENT '附件名称',
  `md5name` text COMMENT '附件随机名',
  `md5` char(32) DEFAULT NULL,
  `filesize` int(10) unsigned NOT NULL COMMENT '文件大小',
  `file_type` int(11) NOT NULL DEFAULT '0',
  `atime` int(10) unsigned NOT NULL COMMENT '添加时间'
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_file`
--

INSERT INTO `hy_file` (`id`, `uid`, `tid`, `pid`, `filename`, `md5name`, `md5`, `filesize`, `file_type`, `atime`) VALUES
(1, 1, 0, 0, 'Screenshot_2021-11-25-17-40-03-465_com.tencent.mm.jpg', 'c050ed7359d912dfaac6826baebc5d40.jpg', 'c050ed7359d912dfaac6826baebc5d40', 1045901, 1, 1637840017),
(2, 1, 0, 0, 'Screenshot_2021-11-25-17-40-08-785_com.tencent.mm.jpg', '3172807094f8885e476a11a700edb389.jpg', '3172807094f8885e476a11a700edb389', 375604, 1, 1637840026),
(3, 1, 0, 0, 'Screenshot_2021-11-25-17-40-24-288_com.tencent.mm.jpg', 'd99e69cc86b140bafc7156247057e76f.jpg', 'd99e69cc86b140bafc7156247057e76f', 437773, 1, 1637840033),
(4, 1, 0, 0, 'Screenshot_2021-11-25-17-40-03-465_com.tencent.mm.jpg', 'e96b08c57a59aaf79ba294910d1a77d0.jpg', 'e96b08c57a59aaf79ba294910d1a77d0', 1045901, 1, 1637841213),
(5, 1, 0, 0, 'Screenshot_2021-11-25-17-40-08-785_com.tencent.mm.jpg', '07fab69a3a97013fecb6d6d0cfc57f4f.jpg', '07fab69a3a97013fecb6d6d0cfc57f4f', 375604, 1, 1637841222),
(6, 1, 0, 0, 'Screenshot_2021-11-25-17-40-24-288_com.tencent.mm.jpg', '4db52780271246056839d7ccc4a5d79c.jpg', '4db52780271246056839d7ccc4a5d79c', 437773, 1, 1637841229),
(7, 1, 1, 1, 'Screenshot_2021-11-25-17-40-03-465_com.tencent.mm.jpg', '1b8ea51fdbb6924114a9ec2e4af6433d.jpg', '1b8ea51fdbb6924114a9ec2e4af6433d', 1045901, 1, 1637841520),
(8, 1, 1, 1, 'Screenshot_2021-11-25-17-40-08-785_com.tencent.mm.jpg', '7a2b778852473698a6e363f87204d4d5.jpg', '7a2b778852473698a6e363f87204d4d5', 375604, 1, 1637841529),
(9, 1, 1, 1, 'Screenshot_2021-11-25-17-40-24-288_com.tencent.mm.jpg', '7cbe76f74c2ecbeb3d3eb0fe8272da91.jpg', '7cbe76f74c2ecbeb3d3eb0fe8272da91', 437773, 1, 1637841537),
(10, 1, 2, 2, '202008143331_2157.jpg', 'c6f89b0917954f838b553e53beb6814f.jpg', 'c6f89b0917954f838b553e53beb6814f', 63650, 1, 1637845859),
(11, 1, 2, 2, '202008145295_2923.jpg', '4d8f683ca42ba3976d4103636f626ac8.jpg', '4d8f683ca42ba3976d4103636f626ac8', 28609, 1, 1637845866),
(12, 1, 2, 2, '202008148590_4442.jpg', 'b996eb34ba4fa0fd7db3388fb044d087.jpg', 'b996eb34ba4fa0fd7db3388fb044d087', 27645, 1, 1637845870);

-- --------------------------------------------------------

--
-- 表的结构 `hy_filegold`
--

CREATE TABLE IF NOT EXISTS `hy_filegold` (
  `uid` int(10) unsigned NOT NULL,
  `fileid` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_fileinfo`
--

CREATE TABLE IF NOT EXISTS `hy_fileinfo` (
  `fileid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `gold` int(10) unsigned NOT NULL DEFAULT '0',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `downs` int(10) unsigned NOT NULL DEFAULT '0',
  `mess` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_file_type`
--

CREATE TABLE IF NOT EXISTS `hy_file_type` (
  `id` int(11) NOT NULL,
  `name` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_file_type`
--

INSERT INTO `hy_file_type` (`id`, `name`) VALUES
(0, '未知'),
(1, '图片'),
(2, '附件'),
(3, '视频'),
(4, '音频');

-- --------------------------------------------------------

--
-- 表的结构 `hy_forum`
--

CREATE TABLE IF NOT EXISTS `hy_forum` (
  `id` int(10) unsigned NOT NULL,
  `fid` int(10) NOT NULL DEFAULT '-1',
  `fgid` int(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(12) NOT NULL,
  `name2` varchar(18) NOT NULL,
  `threads` int(10) unsigned NOT NULL DEFAULT '0',
  `posts` int(10) unsigned NOT NULL DEFAULT '0',
  `forumg` text,
  `json` text,
  `html` longtext,
  `color` varchar(30) NOT NULL DEFAULT '',
  `background` varchar(30) NOT NULL DEFAULT '',
  `bg_img` varchar(255) NOT NULL,
  `bangui` text NOT NULL COMMENT '版规'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_forum`
--

INSERT INTO `hy_forum` (`id`, `fid`, `fgid`, `name`, `name2`, `threads`, `posts`, `forumg`, `json`, `html`, `color`, `background`, `bg_img`, `bangui`) VALUES
(1, 1, 5, '精品源码', 'morenfenlei', 2, 2, '1', '{"vforum":"","vthread":""}', '经过调试发出来的源码', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `hy_forum_group`
--

CREATE TABLE IF NOT EXISTS `hy_forum_group` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_forum_group`
--

INSERT INTO `hy_forum_group` (`id`, `name`) VALUES
(7, '调试源码'),
(6, '免费源码'),
(5, '精品源码'),
(8, '讨论区');

-- --------------------------------------------------------

--
-- 表的结构 `hy_friend`
--

CREATE TABLE IF NOT EXISTS `hy_friend` (
  `uid1` int(10) unsigned NOT NULL,
  `uid2` int(10) unsigned NOT NULL,
  `c` int(11) NOT NULL DEFAULT '0',
  `atime` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_friend`
--

INSERT INTO `hy_friend` (`uid1`, `uid2`, `c`, `atime`, `update_time`, `state`) VALUES
(1, 0, 0, 1637839243, 1637839243, 0),
(2, 0, 0, 1637843358, 1637843358, 0);

-- --------------------------------------------------------

--
-- 表的结构 `hy_log`
--

CREATE TABLE IF NOT EXISTS `hy_log` (
  `id` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `gold` int(11) NOT NULL DEFAULT '0',
  `credits` int(11) NOT NULL DEFAULT '0',
  `content` varchar(32) NOT NULL DEFAULT '',
  `atime` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_log`
--

INSERT INTO `hy_log` (`id`, `uid`, `gold`, `credits`, `content`, `atime`) VALUES
(1, 1, 1, 10, '每日签到奖励1金币和10积分', 1637839243),
(2, 1, 3, 2, '发表文章 文章ID[1]', 1637841546),
(3, 2, 10, 5, '新注册赠送系统10金币和5积分', 1637843358),
(4, 2, 10, 10, '新注册赠送系统10金币和10积分', 1637843358),
(5, 1, 3, 2, '发表文章 文章ID[2]', 1637845888);

-- --------------------------------------------------------

--
-- 表的结构 `hy_online`
--

CREATE TABLE IF NOT EXISTS `hy_online` (
  `uid` int(10) unsigned NOT NULL,
  `user` char(18) NOT NULL,
  `gid` int(10) unsigned NOT NULL,
  `atime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_online`
--

INSERT INTO `hy_online` (`uid`, `user`, `gid`, `atime`) VALUES
(1, 'jxdj', 1, 1637846720),
(2, '0467', 0, 1637843743);

-- --------------------------------------------------------

--
-- 表的结构 `hy_plugins_collection`
--

CREATE TABLE IF NOT EXISTS `hy_plugins_collection` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT '0',
  `tid` int(11) DEFAULT '0',
  `atime` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_plugins_jubao`
--

CREATE TABLE IF NOT EXISTS `hy_plugins_jubao` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL COMMENT '帖子id',
  `atime` int(11) NOT NULL COMMENT '举报时间',
  `state` varchar(20) NOT NULL COMMENT '举报内容',
  `uid` int(11) NOT NULL COMMENT '举报用户，0=游客',
  `mess` varchar(250) NOT NULL COMMENT '留言'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_plugins_myforum`
--

CREATE TABLE IF NOT EXISTS `hy_plugins_myforum` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `atime` int(11) NOT NULL COMMENT '最后访问'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_plugins_post`
--

CREATE TABLE IF NOT EXISTS `hy_plugins_post` (
  `uid` int(11) DEFAULT '0',
  `post_state` int(11) DEFAULT '0',
  `post_atime` int(11) DEFAULT '0',
  `thread_state` int(11) DEFAULT '0',
  `thread_atime` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_plugins_post`
--

INSERT INTO `hy_plugins_post` (`uid`, `post_state`, `post_atime`, `thread_state`, `thread_atime`) VALUES
(1, 0, 0, 2, 1637769600);

-- --------------------------------------------------------

--
-- 表的结构 `hy_plugins_share`
--

CREATE TABLE IF NOT EXISTS `hy_plugins_share` (
  `id` int(11) NOT NULL,
  `tid` int(11) DEFAULT '0',
  `share` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_plugins_share`
--

INSERT INTO `hy_plugins_share` (`id`, `tid`, `share`) VALUES
(5, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `hy_post`
--

CREATE TABLE IF NOT EXISTS `hy_post` (
  `pid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `fid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `rpid` int(10) unsigned NOT NULL DEFAULT '0',
  `isthread` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` longtext,
  `atime` int(10) unsigned NOT NULL,
  `etime` int(10) unsigned NOT NULL DEFAULT '0',
  `euid` int(10) unsigned DEFAULT '0',
  `goods` int(10) unsigned DEFAULT '0',
  `nos` int(10) unsigned NOT NULL DEFAULT '0',
  `posts` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_post`
--

INSERT INTO `hy_post` (`pid`, `tid`, `fid`, `uid`, `rpid`, `isthread`, `content`, `atime`, `etime`, `euid`, `goods`, `nos`, `posts`) VALUES
(1, 1, 1, 1, 0, 1, '<p>在手里很久了，今天放出来给大家</p><p><a href="https://www.lanzouw.com/ixqZuwts6kf">下载地址</a><br></p><p><img src="http://mh.87sms.cn/upload/tid/1/1b8ea51fdbb6924114a9ec2e4af6433d.jpg"></p><p><img src="http://mh.87sms.cn/upload/tid/1/7a2b778852473698a6e363f87204d4d5.jpg"></p><p><img src="http://mh.87sms.cn/upload/tid/1/7cbe76f74c2ecbeb3d3eb0fe8272da91.jpg"></p>', 1637841546, 1637841824, 1, 0, 0, 0),
(2, 2, 1, 1, 0, 1, '<p>一款免公众号的小游戏源码<a href="http://www.lanzoui.com/izriDwdguij">下载</a></p><p><img src="http://mh.87sms.cn/upload/tid/2/c6f89b0917954f838b553e53beb6814f.jpg"></p><p><img src="http://mh.87sms.cn/upload/tid/2/4d8f683ca42ba3976d4103636f626ac8.jpg"></p><p><img src="http://mh.87sms.cn/upload/tid/2/b996eb34ba4fa0fd7db3388fb044d087.jpg"></p>', 1637845888, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `hy_post_post`
--

CREATE TABLE IF NOT EXISTS `hy_post_post` (
  `id` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `content` longtext,
  `atime` int(10) unsigned NOT NULL,
  `goods` int(10) unsigned DEFAULT '0',
  `nos` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_thread`
--

CREATE TABLE IF NOT EXISTS `hy_thread` (
  `tid` int(10) unsigned NOT NULL,
  `fid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL COMMENT 'user_id',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` char(128) NOT NULL,
  `summary` text,
  `atime` int(10) unsigned NOT NULL DEFAULT '0',
  `etime` int(10) unsigned NOT NULL DEFAULT '0',
  `euid` int(10) unsigned NOT NULL DEFAULT '0',
  `btime` int(10) unsigned NOT NULL DEFAULT '0',
  `buid` int(10) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'view_size',
  `posts` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'post_size',
  `goods` int(10) unsigned NOT NULL DEFAULT '0',
  `nos` int(10) unsigned NOT NULL DEFAULT '0',
  `img` text,
  `img_count` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `top` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `files` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `digest` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `gold` int(10) unsigned NOT NULL DEFAULT '0',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `jing` tinyint(2) NOT NULL COMMENT '精华'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_thread`
--

INSERT INTO `hy_thread` (`tid`, `fid`, `uid`, `pid`, `title`, `summary`, `atime`, `etime`, `euid`, `btime`, `buid`, `views`, `posts`, `goods`, `nos`, `img`, `img_count`, `top`, `files`, `hide`, `digest`, `gold`, `state`, `jing`) VALUES
(1, 1, 1, 1, '免公众号盲盒源码', '在手里很久了，今天放出来给大家下载地址', 1637841546, 1637841824, 1, 1637841546, 0, 11, 0, 0, 0, 'http://mh.87sms.cn/upload/tid/1/1b8ea51fdbb6924114a9ec2e4af6433d.jpg,http://mh.87sms.cn/upload/tid/1/7a2b778852473698a6e363f87204d4d5.jpg,http://mh.87sms.cn/upload/tid/1/7cbe76f74c2ecbeb3d3eb0fe8272da91.jpg,', 3, 1, 0, 0, 0, 10, 0, 0),
(2, 1, 1, 2, '免公众号猜色子', '一款免公众号的小游戏源码下载', 1637845888, 1637845888, 0, 1637845888, 0, 3, 0, 0, 0, 'http://mh.87sms.cn/upload/tid/2/c6f89b0917954f838b553e53beb6814f.jpg,http://mh.87sms.cn/upload/tid/2/4d8f683ca42ba3976d4103636f626ac8.jpg,http://mh.87sms.cn/upload/tid/2/b996eb34ba4fa0fd7db3388fb044d087.jpg', 3, 0, 0, 0, 0, 10, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `hy_threadgold`
--

CREATE TABLE IF NOT EXISTS `hy_threadgold` (
  `uid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_thread_star`
--

CREATE TABLE IF NOT EXISTS `hy_thread_star` (
  `uid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `atime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_user`
--

CREATE TABLE IF NOT EXISTS `hy_user` (
  `uid` int(10) unsigned NOT NULL,
  `user` varchar(18) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `age` int(11) NOT NULL COMMENT '年龄',
  `sex` int(11) DEFAULT '0' COMMENT '性别',
  `city` varchar(50) NOT NULL COMMENT '城市',
  `email_state` int(1) DEFAULT '0',
  `avatar_state` int(1) DEFAULT '0' COMMENT '头像状态',
  `salt` varchar(8) NOT NULL,
  `threads` int(10) unsigned NOT NULL DEFAULT '0',
  `posts` int(10) unsigned NOT NULL DEFAULT '0',
  `post_ps` int(10) unsigned NOT NULL DEFAULT '0',
  `atime` int(10) unsigned NOT NULL,
  `gid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0' COMMENT '金钱',
  `credits` int(11) NOT NULL DEFAULT '0',
  `etime` int(10) unsigned NOT NULL DEFAULT '0',
  `ps` varchar(40) DEFAULT '',
  `fans` int(10) unsigned NOT NULL DEFAULT '0',
  `follow` int(10) unsigned NOT NULL DEFAULT '0',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0',
  `chat_size` int(10) unsigned NOT NULL DEFAULT '0',
  `ban_post` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ban_login` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_user`
--

INSERT INTO `hy_user` (`uid`, `user`, `pass`, `email`, `age`, `sex`, `city`, `email_state`, `avatar_state`, `salt`, `threads`, `posts`, `post_ps`, `atime`, `gid`, `gold`, `credits`, `etime`, `ps`, `fans`, `follow`, `ctime`, `file_size`, `chat_size`, `ban_post`, `ban_login`) VALUES
(1, 'jxdj', '76be905649d0400bdc1fb0217cadbb25', '95536327@qq.com', 1637769600, 1, '', 0, 0, 'd49d661f', 2, 0, 0, 1637837858, 1, 323, 12002, 0, '當铺雲', 0, 0, 1637837873, 5565, 0, 0, 0),
(2, '0467', '63bed4393e0dacf341bd5a0cb47718f7', '23436469@qq.com', 0, 0, '', 0, 0, '6c9d6a8f', 0, 0, 0, 1637843358, 0, 0, 15, 0, '', 0, 0, 1637843358, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `hy_usergroup`
--

CREATE TABLE IF NOT EXISTS `hy_usergroup` (
  `gid` int(10) unsigned NOT NULL,
  `credits` int(11) NOT NULL DEFAULT '-1',
  `credits_max` int(11) NOT NULL DEFAULT '-1',
  `space_size` int(10) unsigned NOT NULL DEFAULT '4294967295',
  `chat_size` int(10) unsigned NOT NULL DEFAULT '4294967295',
  `name` varchar(12) NOT NULL,
  `font_color` varchar(30) NOT NULL DEFAULT '',
  `font_css` longtext,
  `json` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_usergroup`
--

INSERT INTO `hy_usergroup` (`gid`, `credits`, `credits_max`, `space_size`, `chat_size`, `name`, `font_color`, `font_css`, `json`) VALUES
(1, -1, -1, 4294967295, 4294967295, '管理员', '', NULL, '{"uploadfile":1,"down":1,"del":1,"upload":1,"mess":1,"post":1,"thread":1,"tgold":1,"thide":1,"nogold":0}'),
(2, -1, -1, 4294967295, 4294967295, '新用户', '', NULL, '{"down":1,"uploadfile":1,"del":1,"upload":1,"mess":1,"post":1,"thread":1,"nogold":0,"thide":1,"tgold":1}'),
(3, -1, -1, 4294967295, 4294967295, '游客', '', NULL, '{"down":1,"uploadfile":1,"del":1,"upload":1,"mess":1,"post":1,"thread":1,"nogold":0,"thide":1,"tgold":1}');

-- --------------------------------------------------------

--
-- 表的结构 `hy_user_sign`
--

CREATE TABLE IF NOT EXISTS `hy_user_sign` (
  `sign_code` int(8) NOT NULL COMMENT '签到id',
  `sign_uid` int(11) DEFAULT NULL COMMENT '用户id',
  `signcount` int(11) DEFAULT '0' COMMENT '连续签到次数',
  `count` int(11) DEFAULT '0' COMMENT '签到次数',
  `lastModifyTime` datetime DEFAULT NULL COMMENT '最后修改时间'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='签到记录表';

--
-- 转存表中的数据 `hy_user_sign`
--

INSERT INTO `hy_user_sign` (`sign_code`, `sign_uid`, `signcount`, `count`, `lastModifyTime`) VALUES
(1, 1, 0, 1, '2021-11-25 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `hy_user_sign_record`
--

CREATE TABLE IF NOT EXISTS `hy_user_sign_record` (
  `recorde_id` int(8) NOT NULL COMMENT '签到历史记录id',
  `sign_code` int(8) DEFAULT NULL COMMENT '签到id',
  `sign_time` datetime DEFAULT NULL COMMENT '签到时间'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='签到历史记录表';

--
-- 转存表中的数据 `hy_user_sign_record`
--

INSERT INTO `hy_user_sign_record` (`recorde_id`, `sign_code`, `sign_time`) VALUES
(1, 1, '2021-11-25 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `hy_user_style`
--

CREATE TABLE IF NOT EXISTS `hy_user_style` (
  `img` varchar(225) NOT NULL,
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_user_style`
--

INSERT INTO `hy_user_style` (`img`, `id`, `uid`) VALUES
('/Plugin/nd_user_img/img/1.jpg', 6, 1);

-- --------------------------------------------------------

--
-- 表的结构 `hy_vote_post`
--

CREATE TABLE IF NOT EXISTS `hy_vote_post` (
  `uid` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `atime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hy_vote_thread`
--

CREATE TABLE IF NOT EXISTS `hy_vote_thread` (
  `uid` int(10) NOT NULL,
  `tid` int(10) NOT NULL,
  `atime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hy_cache`
--
ALTER TABLE `hy_cache`
  ADD UNIQUE KEY `cachekey` (`cachekey`);

--
-- Indexes for table `hy_chat`
--
ALTER TABLE `hy_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid1` (`uid1`,`uid2`);

--
-- Indexes for table `hy_chat_count`
--
ALTER TABLE `hy_chat_count`
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `hy_file`
--
ALTER TABLE `hy_file`
  ADD PRIMARY KEY (`id`,`uid`) USING BTREE,
  ADD UNIQUE KEY `md5` (`md5`) USING BTREE,
  ADD UNIQUE KEY `uid_md5` (`uid`,`md5`),
  ADD KEY `tid` (`tid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `hy_filegold`
--
ALTER TABLE `hy_filegold`
  ADD PRIMARY KEY (`uid`,`fileid`) USING BTREE;

--
-- Indexes for table `hy_fileinfo`
--
ALTER TABLE `hy_fileinfo`
  ADD PRIMARY KEY (`fileid`) USING BTREE,
  ADD KEY `tid` (`tid`) USING BTREE,
  ADD KEY `uid` (`uid`) USING BTREE;

--
-- Indexes for table `hy_file_type`
--
ALTER TABLE `hy_file_type`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `hy_forum`
--
ALTER TABLE `hy_forum`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fid` (`fid`);

--
-- Indexes for table `hy_forum_group`
--
ALTER TABLE `hy_forum_group`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `hy_friend`
--
ALTER TABLE `hy_friend`
  ADD PRIMARY KEY (`uid1`,`uid2`) USING BTREE,
  ADD KEY `uid2` (`uid2`,`state`) USING BTREE;

--
-- Indexes for table `hy_log`
--
ALTER TABLE `hy_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `hy_online`
--
ALTER TABLE `hy_online`
  ADD PRIMARY KEY (`uid`) USING BTREE;

--
-- Indexes for table `hy_plugins_collection`
--
ALTER TABLE `hy_plugins_collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hy_plugins_jubao`
--
ALTER TABLE `hy_plugins_jubao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `hy_plugins_myforum`
--
ALTER TABLE `hy_plugins_myforum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hy_plugins_share`
--
ALTER TABLE `hy_plugins_share`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hy_post`
--
ALTER TABLE `hy_post`
  ADD PRIMARY KEY (`pid`) USING BTREE,
  ADD KEY `tid` (`tid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `hy_post_post`
--
ALTER TABLE `hy_post_post`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `hy_thread`
--
ALTER TABLE `hy_thread`
  ADD PRIMARY KEY (`tid`) USING BTREE,
  ADD KEY `uid` (`uid`),
  ADD KEY `fid` (`fid`),
  ADD KEY `top` (`top`),
  ADD KEY `posts` (`posts`),
  ADD KEY `btime` (`btime`),
  ADD KEY `views` (`views`);

--
-- Indexes for table `hy_threadgold`
--
ALTER TABLE `hy_threadgold`
  ADD PRIMARY KEY (`uid`,`tid`) USING BTREE;

--
-- Indexes for table `hy_thread_star`
--
ALTER TABLE `hy_thread_star`
  ADD UNIQUE KEY `uid_tid` (`uid`,`tid`),
  ADD KEY `atime` (`atime`);

--
-- Indexes for table `hy_user`
--
ALTER TABLE `hy_user`
  ADD PRIMARY KEY (`uid`) USING BTREE,
  ADD UNIQUE KEY `user` (`user`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD KEY `gid` (`gid`);

--
-- Indexes for table `hy_usergroup`
--
ALTER TABLE `hy_usergroup`
  ADD PRIMARY KEY (`gid`) USING BTREE;

--
-- Indexes for table `hy_user_sign`
--
ALTER TABLE `hy_user_sign`
  ADD PRIMARY KEY (`sign_code`);

--
-- Indexes for table `hy_user_sign_record`
--
ALTER TABLE `hy_user_sign_record`
  ADD PRIMARY KEY (`recorde_id`);

--
-- Indexes for table `hy_user_style`
--
ALTER TABLE `hy_user_style`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hy_vote_post`
--
ALTER TABLE `hy_vote_post`
  ADD PRIMARY KEY (`uid`,`pid`) USING BTREE;

--
-- Indexes for table `hy_vote_thread`
--
ALTER TABLE `hy_vote_thread`
  ADD PRIMARY KEY (`uid`,`tid`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hy_chat`
--
ALTER TABLE `hy_chat`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hy_file`
--
ALTER TABLE `hy_file`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '附件ID',AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `hy_forum_group`
--
ALTER TABLE `hy_forum_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `hy_log`
--
ALTER TABLE `hy_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `hy_plugins_collection`
--
ALTER TABLE `hy_plugins_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hy_plugins_jubao`
--
ALTER TABLE `hy_plugins_jubao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hy_plugins_myforum`
--
ALTER TABLE `hy_plugins_myforum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hy_plugins_share`
--
ALTER TABLE `hy_plugins_share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `hy_post`
--
ALTER TABLE `hy_post`
  MODIFY `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hy_post_post`
--
ALTER TABLE `hy_post_post`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hy_thread`
--
ALTER TABLE `hy_thread`
  MODIFY `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hy_user`
--
ALTER TABLE `hy_user`
  MODIFY `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hy_user_sign`
--
ALTER TABLE `hy_user_sign`
  MODIFY `sign_code` int(8) NOT NULL AUTO_INCREMENT COMMENT '签到id',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hy_user_sign_record`
--
ALTER TABLE `hy_user_sign_record`
  MODIFY `recorde_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '签到历史记录id',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hy_user_style`
--
ALTER TABLE `hy_user_style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
