<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:14:42] -->
 */
defined('IN_IA') or exit('Access Denied');
!(defined('FILE_WRITE_IA_ROOT')) && define('FILE_WRITE_IA_ROOT', '/..');
!(defined('FILE_WRITE_M_ROOT')) && define('FILE_WRITE_M_ROOT', FILE_WRITE_IA_ROOT . '/addons/' . MODULE_NAME);

class Upgrade_Page extends SystemPage 
{
	public function main() 
	{
	   global $_W,$_GPC;
        $_W['page']['title'] = '系统升级';
        
        if(file_exists(M_CORE_WEB.'system/auth/upgrade2.php')){
            header('loacation: '.webUrl('system/auth/upgrade2', '', true));
        }
        
        /** 微擎封装的文件写入函数，个别环境读取不到全局文件权限 **/
        $_W['config']['setting']['filemode'] = 0755;
        
        $sign = 'pc_auth_upgrade';
        load()->func('db');
        load()->func('communication');
        load()->func('file');
        $op = $_GET['op'];
        $op = !empty($op)?$op:'check';
        
        $version = (defined('VERSION') ? VERSION : '0.0.1');
        $release = (defined('RELEASE') ? RELEASE : '20171001170045');
        
        $oauth = (array)$oauth;
        $oauth['domain'] = $_SERVER['HTTP_HOST'];
        $setting = setting_load('site');
        $copysite = m('common')->getModuleSetting(0);
        $oauth['oauth_code'] = $copysite['oauth_info']['oauth_code'];
        $oauth['id'] =isset($setting['site']['key'])? $setting['site']['key'] : '1';
        $oauth['module']= MODULE_NAME;
        $oauth['site'] = $setting;
        $oauth['version'] = $version;
        $oauth['release'] = $release;
        $oauth['timestamp'] = TIMESTAMP;
        $oauth['sign'] = md5("id={$oauth['id']}&oauth_code={$copysite['oauth_info']['oauth_code']}&timestamp=".$oauth['timestamp']);
        
        $update_source = MODULE_ROOT.'/data/update';
        $file_write_update_source = FILE_WRITE_M_ROOT.'/data/update';
        
        if($_W['ispost'] && $_W['isajax']){
            if (DEVELOPMENT) {
                $this->result(0, '请关闭开发者模式后再操作');
            }
            
            if($_GPC['action'] == 'check'){
                $res = @json_decode(oauthPost(oUrl(),$oauth),true);
                if(empty($res['data']['files']) && empty($res['data']['db'])){
                    if($res['message']){
                        $this->result(0, $res['message'], $res['data']);
                    }else{
                        $this->result(0, '与云服务失去连接，请联系管理员');
                    }
                }
                if(!empty($res['data']['manifest'])){
                    file_write(FILE_WRITE_M_ROOT.'/manifest.xml', base64_decode($res['data']['manifest']));
                    unset($res['data']['manifest']);
                }
                $this->result($res['errno'], $res['message'], $res['data']);
            }  
            
            if($_GPC['action'] == 'checkfix'){
                /** 数据库 **/
                $db = iunserializer(base64_decode($_GPC['info2']));
                $fix_sql = array();
                foreach($db as $dk => $dv){
                    $loc_info = db_table_schema(pdo(),$dk);
                    $sql = db_table_fix_sql($loc_info, $dv);
                    if(!empty($sql)){
                        $fix_sql[] = $sql;
                    }
                }
                $data['dbnum'] = count($fix_sql);
                if($fix_sql){
                    $fix_sql = iserializer($fix_sql);
                    file_write($file_write_update_source.'/db.txt', $fix_sql);
                }
                
                /** 文件 **/
                set_time_limit(0);
                $files = json_decode(iunserializer(base64_decode($_GPC['info'])),true);
                $fil = array();
                foreach($files as $file){
                    $entry =IA_ROOT . "/addons/".$oauth['module']."/".$file['path'];
                    if (!is_file($entry)|| md5_file($entry)!= $file['md5']){
                        $fil[] = $file['path'];
                    }
                }
                if($fil){
                    $fil2 = json_encode($fil);
                    file_write($file_write_update_source.'/files.txt', $fil2);
                }
                $data['filenum'] = count($fil);
        
                $this->result(1, 'ok', $data);
            }
            
            if($_GPC['action'] == 'fixdb'){
                $key = intval($_GPC['info']);
                if(file_exists($update_source."/db.txt")){
                    $s = file_get_contents($update_source."/db.txt");
                }else{/** 兼容旧版 **/
                    $s = file_get_contents(MODULE_ROOT."/tmp/db.txt");
                }
                $sqls = iunserializer($s);
                foreach($sqls[$key] as $sql){
                    pdo_run($sql);
                }
                $data['updtimes'] = $key+1;
                $this->result(1, 'ok',$data);
            }
            
            if($_GPC['action'] == 'dfile'){
                $key = intval($_GPC['info']);
                if(file_exists($update_source."/files.txt")){
                    $f = file_get_contents($update_source."/files.txt");
                }else{/** 兼容旧版 **/
                    $f = file_get_contents(MODULE_ROOT."/tmp/files.txt");
                }
                $files = @json_decode($f,true);
                $oauth['path'] = base64_encode(json_encode($files[$key]));
                $res = @json_decode(oauthPost(oUrl('dfile'),$oauth),true);
                $fcont = base64_decode($res['data']['fcont']);
                $result = file_write(FILE_WRITE_M_ROOT.'/'.$files[$key], $fcont);
                if(empty($result)){
                    @chmod(MODULE_ROOT.'/'.$files[$key], 0755);
                    $result = file_write(FILE_WRITE_M_ROOT.'/'.$files[$key], $fcont);
                }
                $data['upftimes'] = $key+1;
                $data['wrongfile'] = $files[$key];
                if(!empty($result)){
                    $this->result(1, 'ok',$data);
                }
                $this->result(0, '文件同步出错,请刷新重试', $data);
            } 
            if($_GPC['action'] == 'upgrade'){
                $this->result(1, 'ok');
            }
            if($_GPC['action'] == 'upgradedone'){
                $res = @json_decode(oauthPost(oUrl(),$oauth),true);
                rmdirs($update_source);
                /** 升级补丁 **/
                if(RELEASE > '20180101000000' && RELEASE < '20180429101222'){
                    if(file_exists(MODULE_ROOT.'/tmp')){
                        rmdirs(MODULE_ROOT.'/tmp');/** 删除旧版缓存文件 **/
                    }
                    if(file_exists(M_CORE_WEB . 'setting/themes.php')){
                        @file_delete(M_CORE_WEB . 'setting/themes.php');
                    }
                    if(file_exists(M_TPL_W . 'default/content/classes.html')){
                        @file_delete(M_TPL_W . 'default/content/classes.html');
                    }
                    $category = pdo_fetchall('SELECT * FROM ' . tablename($this->table_classes));
                    foreach($category as $class){
                        if(empty($class['level'])){
                            $level = !empty($class['topid'])?2:1;
                            pdo_update($this->table_classes, array('parid' => $class['topid'], 'level' => $level), array('id'=>$class['id']));
                        }
                    }
                    /** 20180323 **/
                    $navs = pdo_fetchall('SELECT * FROM ' . tablename($this->table_navs));
                    foreach($navs as $n){
                        if(empty($n['level'])){
                            $level2 = !empty($n['topid'])?2:1;
                            pdo_update($this->table_navs, array('parid' => $n['topid'], 'level' => $level2), array('id'=>$n['id']));
                        }
                    }
                    
                    if(file_exists(M_TPL_W . 'default/setting/navs.html')){
                        @file_delete(M_TPL_W . 'default/setting/navs.html');
                    }
                }
                if(RELEASE > '20180101000000' && RELEASE < '20180525134925'){
                    if(file_exists(M_PLUGIN . 'pcsite/template/web/default/index.html')){
                        @file_delete(M_PLUGIN . 'pcsite/template/web/default/index.html');
                    }
                }
                if(RELEASE > '20180101000000' && RELEASE < '20180617205706'){
                    if(file_exists(M_LOCAL . 'template/web/default/static/js/web_default.js')){
                        @file_delete(M_LOCAL . 'template/web/default/static/js/web_default.js');
                    }
                    if(file_exists(M_LOCAL . 'template/web/default/static/css/style.css')){
                        @file_delete(M_LOCAL . 'template/web/default/static/css/style.css');
                    }
                    if(file_exists(M_LOCAL . 'template/web/default/static/js/jquery-sortable.js')){
                        @file_delete(M_LOCAL . 'template/web/default/static/js/jquery-sortable.js');
                    }
                }
                /** 升级完成，重写版本号 **/
                //file_write(FILE_WRITE_M_ROOT.'/version.php',"<?php\nif(!defined(VERSION)){\n    define(VERSION,'".$res['data']['version']."');\n}\n\nif(!defined(RELEASE)){\n    define(RELEASE,'".$res['data']['release']."');\n}");
                
                if($_W['current_module']['version'] != $res['data']['version']){
                    pdo_update('modules', array('version' => '1.8.2', 'account_support' => 2, 'webapp_support' => 2, 'welcome_support' => 2), array('name' => MODULE_NAME));
                }
                
                $this->result(1, '初始化升级成功，请刷新后重新点击更新');
            }
            if($_GPC['action'] == 'deleteversion'){
                @unlink(MODULE_ROOT.'/version.php');
                $result = file_write(FILE_WRITE_M_ROOT.'/version.php',"<?php\nif(!defined(VERSION)){\n    define(VERSION,'0.0.1');\n}\n\nif(!defined(RELEASE)){\n    define(RELEASE,'20171001170045');\n}");
                if(empty($result)){
                    @chmod(MODULE_ROOT, 0755); 
                    $result = file_write(FILE_WRITE_M_ROOT.'/version.php',"<?php\nif(!defined(VERSION)){\n    define(VERSION,'0.0.1');\n}\n\nif(!defined(RELEASE)){\n    define(RELEASE,'20171001170045');\n}");
                }
                
                $this->result(1, 'ok');
            }
            $this->result(0, 'Access Denied');
        }
        
        include $this->mytemplate('system/auth/upgrade2');
	}
}
