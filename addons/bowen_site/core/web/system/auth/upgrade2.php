<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/7 11:10:02] -->
 */
defined('IN_IA') or exit('Access Denied');

class Upgrade2_Page extends SystemPage 
{
    public function __construct()
	{
	   parent::__construct();
       global $_W, $_B, $_GPC;
        
        if($_W['ispost'] && $_W['isajax']){
            if (DEVELOPMENT) {
                $this->result(6, '请关闭开发者模式后再操作');
            }
        }
        
        load()->func('db');
        load()->func('communication');
        load()->func('file');
        
        /** 修复微擎封装的文件写入函数在个别环境下读取不到全局文件权限 **/
        $_W['config']['setting']['filemode'] = 0755;
        
        $version = (defined('VERSION') ? VERSION : '0.0.1');
        $release = (defined('RELEASE') ? RELEASE : '20171001170045');
                        
        $oauth = array();
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
        
        $_B['oauth'] = $oauth;
	}
    
	public function main() 
	{
	   global $_W,$_B,$_GPC;
        $_W['page']['title'] = '系统升级';
                      
        $sign = 'pc_auth_upgrade';
        
        $oauth = $_B['oauth'];
        
        $version = $oauth['version'];
        $release = $oauth['release'];
        
        $update_source = MODULE_ROOT.'/data/update';
        $file_write_update_source = FILE_WRITE_M_ROOT.'/data/update';
        
        if($_W['ispost'] && $_W['isajax']){
            if($_GPC['action'] == 'check'){
                $this->check();
            }  
            
            if($_GPC['action'] == 'checkfix'){
                $this->checkfix();
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
                $this->result(0, 'success',$data);
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
                $res = @json_decode(oauthPost(oUrl('web', '',array('r' => 'upgrade.dfile')),$oauth),true);
                $fcont = base64_decode($res['data']['fcont']);
                $result = file_write(FILE_WRITE_M_ROOT.'/'.$files[$key], $fcont);
                if(empty($result)){
                    @chmod(MODULE_ROOT.'/'.$files[$key], 0755);
                    $result = file_write(FILE_WRITE_M_ROOT.'/'.$files[$key], $fcont);
                }
                $data['upftimes'] = $key+1;
                $data['wrongfile'] = $files[$key];
                if(!empty($result)){
                    $this->result(0, 'success',$data);
                }
                $this->result(2, '文件同步出错,请刷新重试', $data);
            }
            /** 此处不需要动作，只是单纯的响应下前端的post，然后前端就执行其他的了，有浪费性能的问题，新版不需要这个步骤 */
            if($_GPC['action'] == 'upgrade'){
                $this->result(0, 'success');
            }
            if($_GPC['action'] == 'upgradedone'){
                $this->upgradedone();
            }
            if($_GPC['action'] == 'deleteversion'){
                $this->deleteversion();
            }
            $this->result(2, '参数错误！');
        }
        
        include $this->mytemplate('system/auth/upgrade2');
	}
    
    /** 对比是否有更新(获取对比标准) */
    public function check(){
       global $_W,$_B,$_GPC;
        if(!$_W['ispost'] || !$_W['isajax']){
            $this->result(2, '非法访问！');
        }
        $oauth = $_B['oauth'];
        $res = @json_decode(oauthPost(oUrl('web', '',array('r' => 'upgrade')),$oauth),true);
        if(empty($res['data']['files']) && empty($res['data']['db'])){
            if($res['message']){
                $this->result($res['errno'], $res['message'], $res['data']);
            }else{
                $this->result(8, '与云服务失去连接，请联系管理员');
            }
        }
        
        if(!empty($res['data']['manifest'])){
            file_write(FILE_WRITE_M_ROOT.'/manifest.xml', base64_decode($res['data']['manifest']));
            unset($res['data']['manifest']);
        }
        $this->result($res['errno'], $res['message'], $res['data']);
    }
    
    /** 生成对比结果 */
    public function checkfix(){
       global $_W,$_B,$_GPC;
        if(!$_W['ispost'] || !$_W['isajax']){
            $this->result(2, '非法访问！');
        }
        $oauth = $_B['oauth'];
        $update_source = MODULE_ROOT.'/data/update';
        $file_write_update_source = FILE_WRITE_M_ROOT.'/data/update';
        set_time_limit(0);
        
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
        
        $this->result(0, 'success', $data);
    }
    
    public function upgradedone()
    {
       global $_W,$_B,$_GPC;
        if(!$_W['ispost'] || !$_W['isajax']){
            $this->result(2, '非法访问！');
        }
        $oauth = $_B['oauth'];
        $update_source = MODULE_ROOT.'/data/update';
        rmdirs($update_source);
        
        $res = @json_decode(oauthPost(oUrl('web', '',array('r' => 'upgrade')),$oauth),true);
        
        if($res['data']['plugins']){
            $old_plugins = pdo_fetchall('SELECT * FROM ' . tablename($this->table_plugin));
            $old_plugins_name = array();
            if(!empty($old_plugins)){
                foreach($old_plugins as $op){
                    $old_plugins_name[] = $op['name'];
                }
            }
            
            $plugins = iunserializer(base64_decode($res['data']['plugins']));
            foreach($plugins as $p){
                $p = iunserializer($p);
                $data = array(
                    'category' => $p['category']
                    ,'author' => $p['author']
                    ,'version' => $p['version']
                    ,'status' => $p['status']
                    ,'rolelevel' => $p['rolelevel']
                );
                    /** 暂时同步下面的数据 */
                    $data['title'] = $p['title'];
                    $data['thumb'] = $p['thumb'];
                    $data['desc'] = $p['desc'];
                if(in_array($p['name'], $old_plugins_name)){
                    pdo_update($this->table_plugin, $data, array('name' => $p['name']));
                }else{
                    $data['name'] = $p['name'];
                    
                    $data['displayorder'] = 0;
                    $data['createtime'] = TIMESTAMP;
                    pdo_insert($this->table_plugin, $data);
                }
            }
        }
        
        /** 升级补丁 **/
        if(RELEASE > '201712111356' && RELEASE < '20180429101222'){
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
        
        if(RELEASE > '201712111356' && RELEASE < '20180525134925'){
            if(file_exists(M_PLUGIN . 'pcsite/template/web/default/index.html')){
                @file_delete(M_PLUGIN . 'pcsite/template/web/default/index.html');
            }
        }
        
        if(RELEASE > '201712111356' && RELEASE < '20180617205706'){
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

        pdo_update('modules', array('version' => '2.0.1', 'account_support' => 2, 'webapp_support' => 2, 'welcome_support' => 2), array('name' => MODULE_NAME));

        if(VERSION == '0.0.1'){
            unset($_GPC['s']);
            $re_url = webUrl().'#/cloud/oauth/upgrade';
        }
        
        /** 缓存清理 **/
        cache_clean();
        
        /** 升级完成，重写版本号 **/
        file_write(FILE_WRITE_M_ROOT.'/version.php',"<?php\nif(!defined(VERSION)){\n    define(VERSION,'".$res['data']['version']."');\n}\n\nif(!defined(RELEASE)){\n    define(RELEASE,'".$res['data']['release']."');\n}\n\nif(!defined(FAMILY)){\n    define(FAMILY,'".$res['data']['u_family']."');\n}");
                
        $this->result(0, '升级成功！', array('re_url'=>$re_url));
    }

    public function deleteversion(){
        @unlink(MODULE_ROOT.'/version.php');
        $result = file_write(FILE_WRITE_M_ROOT.'/version.php',"<?php\nif(!defined(VERSION)){\n    define(VERSION,'0.0.1');\n}\n\nif(!defined(RELEASE)){\n    define(RELEASE,'201712111356');\n}\n\nif(!defined(FAMILY)){\n    define(FAMILY,'D');\n}");
        if(empty($result)){
            @chmod(MODULE_ROOT, 0755); 
            $result = file_write(FILE_WRITE_M_ROOT.'/version.php',"<?php\nif(!defined(VERSION)){\n    define(VERSION,'0.0.1');\n}\n\nif(!defined(RELEASE)){\n    define(RELEASE,'201712111356');\n}\n\nif(!defined(FAMILY)){\n    define(FAMILY,'D');\n}");
        }
                
        $this->result(0, 'success');
    }
}