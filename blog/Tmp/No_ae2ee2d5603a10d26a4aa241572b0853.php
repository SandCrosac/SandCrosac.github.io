<?php
namespace Action;
use HY\Action;
!defined('HY_PATH') && exit('HY_PATH not defined.');
class No extends HYBBS {
    public function __construct(){
        //parent::__construct();
        
    }
    public function index(){
        
        $_GET['type'] = ACTION_NAME;
        if($_GET['type'] != 'New' && $_GET['type'] != 'Btime' && preg_match("/^[0-9a-zA-Z]+$/",ACTION_NAME))
            E('不存在该页面',false);

        $_GET['pageid'] = intval(isset($_GET['HY_URL'][1]) ? $_GET['HY_URL'][1] : 1) or $pageid=1;
        A("Index")->Index();
    }
    public function _no(){
        
        $_GET['type'] = ACTION_NAME;
        if($_GET['type'] != 'New' && $_GET['type'] != 'Btime' && preg_match("/^[0-9a-zA-Z]+$/",ACTION_NAME))
            E('不存在该页面',false);
        
        $_GET['pageid'] = intval(isset($_GET['HY_URL'][1]) ? $_GET['HY_URL'][1] : 1) or $pageid=1;
        A("Index")->Index();
    }
    
}