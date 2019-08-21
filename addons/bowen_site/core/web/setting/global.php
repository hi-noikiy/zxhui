<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/8/22 11:44:50] -->
 */
defined('IN_IA') or exit('Access Denied');

class Global_Page extends ComWebPage 
{
	public function main() 
	{
	   global $_W,$_GPC,$_B;
        if($_GPC['status'] == 'success'){
            mymessage('操作成功', webUrl('setting/global'),'success');
        }
        $_W['page']['title'] = '参数设置';
        $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $settings = $_B['setting'];
        $settings['global']['diycode'] = base64_decode($settings['global']['diycode']);
        $mobilethemes = $this->getThemes_mobile();
        
        if(empty($settings['global']['mobilethemes'])){
            mymessage('请先选择模板！', webUrl('setting/themes'), 'error');
        }
        
        if(checksubmit('submit')){
            $mobilethemes = trim($_GPC['mobilethemes']);
            $data = array(
                'global' => array(
                    'login' => array(
                        'text' => trim($_GPC['login']['text']),
                        'link' => trim($_GPC['login']['link'])
                    ),
                    'register' => array(
                        'text' => trim($_GPC['register']['text']),
                        'link' => trim($_GPC['register']['link'])
                    ),
                    'title' => trim($_GPC['title']),
                    'subtitle' => trim($_GPC['subtitle']),
                    'keyword' => trim($_GPC['keyword']),
                    'description' => trim($_GPC['description']),
                    'isrewrite' => intval($_GPC['isrewrite']),
                    'color' => array(
                        '1' => $_GPC['color1'],
                        '2' => $_GPC['color2']
                    ),
                    'kf' => array(
                        'pc' => array(
                            0=> trim(trim($_GPC['kf']['pc'][0]))
                        ),
                        'mobile' => array(
                            0 => trim($_GPC['kf']['mobile'][0])
                        )
                    ),
                    'loading' => array(
                        'bg1' => trim($_GPC['loading_bg1']),
                        'bg2' => trim($_GPC['loading_bg2']),
                        'bg3' => trim($_GPC['loading_bg3']),
                        'logo' => trim($_GPC['loading_logo']),
                        'text' => trim($_GPC['loading_text'])
                    ),
                    'ico' => trim($_GPC['ico']),
                    'tn_logo' => trim($_GPC['tn_logo']),
                    'logo2' => trim($_GPC['logo2']),
                    'qr' => trim($_GPC['qr']),
                    'flink' => $_GPC['flink'],
                    'bt_contact' => $_GPC['bt_contact'],
                    'copyright' => trim($_GPC['copyright']),
                    'mobilethemes' => $mobilethemes,
                    'webthemes' => 'default',
                    'diycode' => base64_encode($_GPC['diycode']),
                    'style' => array(
                        'logo' => array(
                            'margin_top' => trim($_GPC['logo_margin_top']),
                            'margin_left' => trim($_GPC['logo_margin_left']),
                        ),
                        'logo2' => array(
                            'margin_top' => trim($_GPC['logo2_margin_top']),
                        ),
                    ),
                    'contact' => array(
                        'qq' => trim($_GPC['qq'])
                        ,'weibo' => trim($_GPC['weibo'])
                        ,'wechat' => trim($_GPC['wechat'])
                        ,'email' => trim($_GPC['email'])
                        ,'phone' => trim($_GPC['phone'])
                        ,'address' => trim($_GPC['address'])
                    ),
                    'copyright2' => trim($_GPC['copyright2']),
                ),
            );

            if(TEST_SITE){mymessage('测试站禁止操作数据', 'refresh','error');}
            $result = m('common')->saveModuleSetting($data, $_W['uniacid'], 'setting');
            if(!empty($result)){
                mymessage('操作成功', 'refresh','success');
            }
        }
        
        include $this->mytemplate('setting/global-base');
	}
}
