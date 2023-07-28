<?php
function plugin_install(){
    if(!get_plugin_install_state("smtpmail"))
    {
        file_put_contents(PLUGIN_PATH."smtpmail/on","");
        return true;
    }else{
        return false;
    }
}
function plugin_uninstall(){
    if (get_plugin_install_state("smtpmail"))
    {
        unlink(PLUGIN_PATH."smtpmail/on");
        return true;
    }else{
        return false;
    }
}
                  