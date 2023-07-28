<?php
//插件安装时 执行的安装函数
function plugin_install(){
    $sql = S("Plugin");
    $result = $sql->query("ALTER TABLE hy_thread ADD fine int(5) NOT NULL DEFAULT '0'"); //执行SQL语句
     
    if($result->errorCode() != 0) //执行失败
        return $result->errorInfo()[2]; //返回错误原因
    return true; //执行成功
} 
//插件卸载时 执行的安装函数
function plugin_uninstall(){
    $sql = S("Plugin");
$result = $sql->query("ALTER TABLE hy_thread DROP COLUMN fine;"); //执行SQL语句
     
    if($result->errorCode() != 0){ //执行失败
        return $result->errorInfo()[2]; //返回错误原因
    }
    return true; //执行成功
}