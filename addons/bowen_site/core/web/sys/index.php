<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/20 11:50:17] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends SystemPage 
{
    public function __construct($_init = true)
	{
	   global $_W, $_B;
        parent::__construct();
        if(!$_W['isajax'] || !$_W['ispost']){
            $this->result(2, '参数错误，非法访问');
        }
        $_B['welcomedata'] = 'PD9waHANCi8qKg0KICog546W56W65LyB5Lia5a6Y572RDQogKg0KICogQGF1dGhvciBCb3dlbg0KICogQHVybCBodHRwczovL3dlY2VudGVyLmppdWNoZXQuY29tLw0KICogPCEtLSBwaHBEZXNpZ25lciA6OiBUaW1lc3RhbXAgWzIwMTgvOC8yIDIzOjQ0OjQwXSAtLT4NCiAqLw0KZGVmaW5lZCgnSU5fSUEnKSBvciBleGl0KCdBY2Nlc3MgRGVuaWVkJyk7DQoNCnJlcXVpcmVfb25jZSBJQV9ST09UIC4gJy9hZGRvbnMvYm93ZW5fc2l0ZS9kZWZpbmVzLnBocCc7DQpyZXF1aXJlX29uY2UgTV9ST09ULicvdmVyc2lvbi5waHAnOw0KaW5jbHVkZV9vbmNlIE1fSU5DIC4gJ2Z1bmN0aW9ucy5waHAnOw0KbG9hZCgpLT5tb2RlbCgnbW9kdWxlJyk7DQppZiAoIWVtcHR5KCRfV1sndWlkJ10pKSB7DQoJaGVhZGVyKCdMb2NhdGlvbjogJy51cmwoJ2FjY291bnQvZGlzcGxheScsIGFycmF5KCd0eXBlJyA9PiBBQ0NPVU5UX1RZUEVfU0lHTikpKTsNCglleGl0Ow0KfQ0KDQpib3dlbl9zaXRlX3dlbGNvbWUoZmFsc2UpOw0KDQokc2V0dGluZ3MgPSAkX1dbJ3NldHRpbmcnXTsNCg0KJGNvcHlyaWdodCA9ICRzZXR0aW5nc1snY29weXJpZ2h0J107DQokY29weXJpZ2h0WydzbGlkZXMnXSA9IGl1bnNlcmlhbGl6ZXIoJGNvcHlyaWdodFsnc2xpZGVzJ10pOw0KaWYgKGlzc2V0KCRjb3B5cmlnaHRbJ3Nob3dob21lcGFnZSddKSAmJiBlbXB0eSgkY29weXJpZ2h0WydzaG93aG9tZXBhZ2UnXSkpIHsNCgloZWFkZXIoIkxvY2F0aW9uOiAiLnVybCgndXNlci9sb2dpbicpKTsNCglleGl0Ow0KfQ0KbG9hZCgpLT5tb2RlbCgnYXJ0aWNsZScpOw0KJG5vdGljZXMgPSBhcnRpY2xlX25vdGljZV9ob21lKCk7DQokbmV3cyA9IGFydGljbGVfbmV3c19ob21lKCk7DQp0ZW1wbGF0ZSgnYWNjb3VudC93ZWxjb21lJyk7';
	}
    
    public function getSetData(){
       global $_W, $_B;
        $settings = $_W['setting'];
        $site_welcome_module = $settings['site_welcome_module'];
        $copyright = $settings['copyright'];
        if(IMS_FAMILY == 'v'){
            $welcomedata = $_B['welcomedata'];
            $now_welcome_file = file_get_contents(IA_ROOT . '/web/source/account/welcome.ctrl.php');
            $now_welcome_file = base64_encode($now_welcome_file);
            if($now_welcome_file != $welcomedata){
                $copyright['showhomepage'] = 0;
            }
        }
        $webThemes = $this->getWebThemes();
        $data = array(
            'showhomepage' => $copyright['showhomepage']
            ,'site_welcome_module' => ($site_welcome_module == MODULE_NAME)?1:0
            ,'is_rewrite' => $_B['core_settings']['is_rewrite']
            ,'webtheme' => $_B['core_settings']['webtheme']
            ,'compatible_site_welcome_module' => $_B['core_settings']['compatible_site_welcome_module']
            ,'webthemes' => $webThemes //It's the admin theme,Not from database
        );
        $this->result(0, 'success', $data);
    }
    
    public function setData(){
        global $_GPC, $_B, $_W;
        $op = $_GPC['op'];
        $status = !empty($_GPC['status'])?1:0;;
        
        $settings = $_W['setting'];
        $site_welcome_module = $settings['site_welcome_module'];
        $copyright = $settings['copyright'];
        $welcomedata = $_B['welcomedata'];
        $modulename = MODULE_NAME;
        
        if($op == 'showhomepage'){
            if(IMS_FAMILY == 'v' && !empty($status)){
                $fcont = base64_decode($welcomedata);
                $result = file_write(FILE_WRITE_IA_ROOT . '/web/source/account/welcome.ctrl.php', $fcont);
                if(empty($result)){
                    @chmod(IA_ROOT . '/web/source/account', 0755);
                    $result = file_write(FILE_WRITE_IA_ROOT . '/web/source/account/welcome.ctrl.php', $fcont);
                }
            }
            $copyright['showhomepage'] = $status;
            setting_save($copyright, 'copyright');
            $this->result(0,'操作成功');
        }
            
        if($op == 'site_welcome_module'){
            if(empty($status)){
                $modulename = '';
            }
      		if (!empty($modulename)) {
     			$site = WeUtility::createModuleSystemWelcome($modulename);
     			if (!method_exists($site, 'systemWelcomeDisplay')) {
				    $this->result(1, '应用未实现系统首页功能！');
     			}
      		}
      		setting_save(trim($modulename), 'site_welcome_module');
      		$this->result(0,'操作成功');
        }
            
        if($op == 'is_rewrite'){
            $core_site_data['core_settings'] = array(
                'is_rewrite' => $status
            );
            $core_site_data['core_settings'] = array_merge($_B['core_settings'], $core_site_data['core_settings']);
            m('common')->saveModuleSetting($core_site_data, 0, 'core');
            $this->result(0,'操作成功');
        }
        
        $this->result(2, '操作失败，未知错误');
    }
    
    public function postSysData()
    {
       global $_W, $_GPC, $_B;
        $compatible_site_welcome_module = trim($_GPC['compatible_site_welcome_module']);
        if(!empty($compatible_site_welcome_module)){
            if($compatible_site_welcome_module == MODULE_NAME){
                $this->result(2, '若无需兼容其他模块，请直接留空');
            }
            $result = pdo_fetch("SELECT * FROM " . tablename("modules") . " WHERE name=:name LIMIT 1", array(':name' => $compatible_site_welcome_module));
            if(empty($result)){
               $this->result(-1, '需要兼容的模块不存在'); 
            }
        }
        $core_site_data['core_settings'] = array(
            'webtheme' => trim($_GPC['webtheme'])
            ,'compatible_site_welcome_module' => $compatible_site_welcome_module
        );
        $core_site_data['core_settings'] = array_merge($_B['core_settings'], $core_site_data['core_settings']);
        m('common')->saveModuleSetting($core_site_data, 0, 'core');
        $this->result(0,'操作成功');
    }
}
