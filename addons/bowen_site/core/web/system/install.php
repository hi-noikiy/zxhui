<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:18:48] -->
 */
defined('IN_IA') or exit('Access Denied');

class Install extends WeModuleSite {
    
    public function __construct()
	{
       global $_W, $_B;
		define('IS_M_SYSTEM', true);
        mychecklogin();
        
        if ($_W['role'] != 'founder') {
			mymessage('权限不足，禁止访问', 'referer', 'error');
		}
        
        if($_W['ispost'] && $_W['isajax'] && DEVELOPMENT){
            $this->result(6, '请关闭开发者模式后再操作');
        }
        
        $_W['config']['setting']['filemode'] = 0755;/** 微擎封装的文件写入函数，个别环境读取不到全局文件权限 **/
        
        load()->func('db');
        load()->func('communication');
        load()->func('file');
        
        $version = (defined('VERSION') ? VERSION : '0.0.1');
        $release = (defined('RELEASE') ? RELEASE : '20171001170045');
        
        $oauth = (array)$oauth;
        $oauth['domain'] = $_SERVER['HTTP_HOST'];
        $setting = setting_load('site');
        $_B['sys_set'] = m('common')->getModuleSetting(0);
        $oauth['oauth_code'] = !empty($_B['sys_set']['oauth_info']['oauth_code'])?1:0;
        $oauth['id'] =isset($setting['site']['key'])? $setting['site']['key'] : '1';
        $oauth['module']= MODULE_NAME;
        $oauth['site'] = $setting;
        $oauth['version'] = $version;
        $oauth['release'] = $release;
        $oauth['timestamp'] = TIMESTAMP;
        $oauth['sign'] = md5("id={$oauth['id']}&oauth_code={$_B['sys_set']['oauth_info']['oauth_code']}&timestamp=".$oauth['timestamp']);
        
        $_B['oauth'] = $oauth;
        $update_source = MODULE_ROOT.'/data/update';
        $file_write_update_source = FILE_WRITE_M_ROOT.'/data/update';
        
	}
    
	public function main(){
	   global $_W,$_GPC,$_B;
        $_W['page']['title'] = '授权维护';
        $oauth = $_B['oauth'];
        $oauth['oauth_code'] = $_B['sys_set']['oauth_info']['oauth_code'];
        
        if(checksubmit('check')){
            $copysite_data = array(
                'oauth_info' => array(
                    'oauth_code' => trim($_GPC['oauth_code'])
                )
            );
            m('common')->saveModuleSetting($copysite_data, '0', 'core');
            itoast('操作成功', 'refresh', 'success');
        }
        
        include mytemplate('system/install');
	}
    
    public function upgrade(){
        global $_W,$_GPC,$_B;
        $_W['page']['title'] = '系统升级';
        
        $oauth = $_B['oauth'];
        
        if($_W['ispost'] && $_W['isajax']){
            if (DEVELOPMENT) {
                $this->result(0, '请关闭开发者模式后再操作');
            }
            
            if($_GPC['action'] == 'check'){
                $res = @json_decode(oauthPost(oUrl(),$oauth),true);
                if(empty($res['data']['files']) && empty($res['data']['db'])){
                    $this->result(0, $res['message'], $res['data']);
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
                
                /** 升级完成，重写版本号 **/
                file_write(FILE_WRITE_M_ROOT.'/version.php',"<?php\nif(!defined(VERSION)){\n    define(VERSION,'".$res['data']['version']."');\n}\n\nif(!defined(RELEASE)){\n    define(RELEASE,'".$res['data']['release']."');\n}");
                
                if($_W['current_module']['version'] != $res['data']['version']){
                    pdo_update('modules', array('version' => $res['data']['version']), array('name' => 'bowen_site'));
                }
                
                $this->result(1, 'ok');
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
        include $this->mytemplate('system/install/upgrade');
    }
    
    private function result($errno = '0', $message = '', $data = array(), $params = array(), $type = 'exit'){
        return result($errno, $message, $data, $params, $type);
    }
    
    private function mytemplate($filename = '', $tthemes = ''){
        return mytemplate($filename, $tthemes);
    }
}
