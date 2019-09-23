<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}
class Log_EweiShopV2Model
{
    static private $setting;
    public  function __construct()
    {
        global $_W;
        self::$setting = $_W;

    }
    //记录日志
    public  function log($dir = '', $content = ''){
        global $_GPC;
        //记录日志
        if ($content == '') {
            $print = print_r($_GPC, true);
        } else {
            if (is_array($content)){
                $print = json_encode($content);
            }else{
                $print = $content;
            }
        }
        $log = 'time:' . date('Y-m-d H:i:s', time()) . '---' . $print . "\r\n";
        if (!is_dir(ATTACHMENT_ROOT . 'data/log/'. $dir)) {
            load()->func('file');
            mkdirs(ATTACHMENT_ROOT . 'data/log/'. $dir);
        }
        file_put_contents(ATTACHMENT_ROOT . 'data/log/' . $dir .'/'. date('Ymd', time()), $log, FILE_APPEND);
    }
}