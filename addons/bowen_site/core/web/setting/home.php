<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/22 11:44:44] -->
 */
defined('IN_IA') or exit('Access Denied');

class Home_Page extends ComWebPage 
{
	public function main() 
	{
	   global $_W,$_GPC,$_B;
        $_W['page']['title'] = '主题设置';
        $settings = m('common')->getModuleSetting($_W['uniacid']);
        $_B['setting'] = $settings;
        
        if(empty($settings['global']['mobilethemes'])){
            mymessage('请先选择模板！', webUrl('setting/themes'), 'error');
        }
        
        $settings['home']['banner'] = iunserializer($settings['home']['banner']);
        $settings['home']['advantages']['content'] = iunserializer($settings['home']['advantages']['content']);
        $settings['global']['mobilethemes'] = !empty($settings['global']['mobilethemes'])?$settings['global']['mobilethemes']:'default';
        $templete = $settings['global']['mobilethemes'];
        
        if(!file_exists(M_PATH.'template/web/setting/home-'.$templete)) {
            $templete = 'default';
        }
        $template_title = $this->getThemes_mobile_config('title');//print_r($settings);
        if(checksubmit('submit')){
            $filter_key = array(
                'c'
                ,'a'
                ,'m'
                ,'do'
                ,'r'
                ,'__uniacid'
                ,'__switch'
                ,'__uid'
                ,'__session'
                ,'__lastvisit_1'
                ,'__notice'
                ,'token'
                ,'submit'
                ,'__entry'
                ,'__state'
                ,'state'
                ,'__code'
            );
            foreach($_GPC as $gk=>$gv)
            {
                if(in_array($gk, $filter_key) || preg_match("/^module_status:/", $gk)){
                    unset($_GPC[$gk]);
                }
                if(preg_match("/_ngi$/", $gk)){
                    $gk = str_replace('_ngi', '', $gk);
                    if(!is_array($gv)){
                        $_GPC[$gk] = $this->getId($gv);
                    }else{
                        for($g = 0; $g < count($gv); $g++){
                            $_GPC[$gk][$g] = $this->getId($gv[$g]);
                        }
                    }
                    
                }
                
            }
            
            /** 整理/兼容旧版banner数据 */
            if(!empty($_GPC['bannerimg'])){
                $banner = array();
                for($i = 0; $i < count($_GPC['bannerimg']); $i++){
                    $banner[] = array(
                        'bannertitle' => trim($_GPC['bannertitle'][$i]),
                        'bannercontent' => $_GPC['bannercontent'][$i],
                        'bannerimg' => trim($_GPC['bannerimg'][$i]),
                        'bannerurl' => trim($_GPC['bannerurl'][$i]),
                        'bannerstyle' => trim($_GPC['bannerstyle'][$i]),
                    );
                }
            }else{
                $banner = $settings['home']['banner'];
            }
            
            $hook_path = M_ROOT."/template/mobile/".$settings['global']['mobilethemes']."/hook.php";
            if(file_exists($hook_path)){
                include_once $hook_path;
                if(function_exists('getInsertDataForSettingHome')){
                    $settingData = getInsertDataForSettingHome();
                }
            }
            $settingData = $settingData?$settingData:$_GPC;
            $data = array(
                'value' => array(
                    'home' => array(
                        'banner' => iserializer($banner),
                        $settings['global']['mobilethemes'] => $settingData
                    )
                )
            );
            
            $data['value']['home'] = array_merge($settings['home'], $data['value']['home']);
            
            if(TEST_SITE){$this->result(1, '测试站禁止操作数据');mymessage('测试站禁止操作数据', 'refresh','error');}
            $result = m('common')->saveModuleSetting($data, $_W['uniacid'], 'setting');
            if(!empty($result)){
                mymessage('操作成功', 'refresh','success');
            }
        }
        
        include $this->mytemplate('setting/home-base');
	}
    
    /** 获取链接中的ID */
    private function getId($content)
    {
        return m('common')->getId($content);
    }
}
