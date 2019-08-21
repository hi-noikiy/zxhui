<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/11/08 21:20:47] -->
 */
defined('IN_IA') or exit('Access Denied');

class Task_Model
{
    private $table_notice = 'bowen_site_notice';
    private $table_msg_sign = 'bowen_site_msg_sign';

    public $_msg_type_config = array(
        '0' => array(
            'name' => 'notice',
            'title' => '通知'
        ),
    );

    public function api_run(){
        ob_end_clean();
        header("Connection:close");
        header("HTTP/1.1 200 OK");

        ob_start();
        //header("Content-type:text/html;charset=utf-8");
        header("Content-Type: application/json;charset=utf-8");
        $cache_key = 'task_crontab';
        $cache_data = m('cache')->get($cache_key);
        $msg = '队列任务激活成功...';
        if(TIMESTAMP < $cache_data['endtime']){
            $msg = '队列任务正常执行中...';
        }
        echo result_r(0, $msg);

        $size=ob_get_length();
        header("Content-Length: $size");
        ob_end_flush();
        flush();

        if (function_exists("fastcgi_finish_request")) {
            fastcgi_finish_request();
        }

        sleep(1);

        ignore_user_abort(true);
        set_time_limit(0);

        //业务代码
        $this->run_task('', $cache_data);
    }

    public function run_task($run_id = '', $cache_data = array()){
        $cache_key = 'task_crontab';
        $run_id = !empty($run_id)?$run_id:random(6);

        $cache_data = empty($cache_data)?m('cache')->get($cache_key):$cache_data;

        //加载config文件，方便根据配置停止运行
        $configfile = M_DATA . 'config.php';
        if(file_exists($configfile)){
            require $configfile;
        }

        if(!empty($cache_data) && $cache_data['run_id'] != $run_id && TIMESTAMP < $cache_data['endtime']){
            result(2, '队列任务已经运行！');
        }elseif(!empty($config['setting']['end_crontab'])){
            result(2, '配置终止运行中！');
        }

        $sql = 'SELECT s.id,s.uniacid,s.type,s.openid,s.nickname,s.param,n.sign as n_sign,n.template_id as n_template_id FROM ' . tablename($this->table_msg_sign) . ' s left join ' . tablename($this->table_notice) . ' n on s.taskid = n.id where s.status = 0 ORDER BY s.id limit 30 ';
        $items = pdo_fetchall($sql);
        foreach ($items as $item ) {
            //type=0执行通知类任务
            if($item['type'] == 0){
                $param = array(
                    'id' => $item['id'],
                    'uniacid' => $item['uniacid'],
                    'openid' => $item['openid'],
                    'template_id' => $item['n_template_id'],
                    'nickname' => $item['nickname'],
                    'sign' => $item['n_sign']
                );
                m('notice')->send($param);
            }
        }

        $data = array(
            'endtime' => time()+60,
            'run_id' => $run_id
        );
        m('cache')->set($cache_key,$data);

        sleep(1);
        $new_items = pdo_fetchall($sql);
        $count_new = count($new_items);
        if($count_new>0){
            $this->run_task($run_id);
        }else{
            die();
        }
    }
}
