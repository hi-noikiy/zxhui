<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/03 10:39:32] -->
 */
defined('IN_IA') or exit('Access Denied');

class System_Model
{
	public function __construct()
	{
		
	}

	/**
     * 获取 菜单
     * @return array
     */
	public function getMenu()
	{
	   global $_W;
       
        $return_menu['left'] = array();
        
        if($_W['isplugin']){
            $return_menu['left'] = $this->setMenuActive($this->pluginMenu($_W['plugin']));
            return $return_menu;
        }
        
        $return_menu['left'] = $this->setMenuActive($this->SiteMenu());
        return $return_menu;
	}


	/**
     * 获取 插件 配置
     * @param array $plugin 要获取的插件标识
     * @return array
     */
	protected function pluginMenu($plugin = array(), $key = 'menu')
	{
	   global $_W;	   
		if (empty($plugin)) {
			return array();
		}
        if($plugin == $_W['plugin'])$config = $_W['current_plugin_config'];
        if(empty($config))$config = m('plugin')->getConfig($plugin);
		$config = m('plugin')->getConfig($plugin);
		return empty($config[$key]) ? array() : $config[$key];
	}

    /**
     * 设置 主站点 菜单
     * @return array
     * 旧版本，v2起废弃
     */
    public function SiteMenu()
    {
        return true;
    }
    
    /**
     * 设置 菜单的选中状态
     * @param array $menus 要设置的菜单
     * @return array
     */
    private function setMenuActive($menus)
    {
        global $_W;
        
        $routes = $_W['routes_array'];
        
        if($routes[0]){
            $menus[$routes[0]]['default'] = '1';
            if($routes[1]){
                if(in_array($routes[1], array('auth'))){
                    $menus[$routes[0]]['content']['cloud']['active'] = '1';
                }else{
                    $menus[$routes[0]]['content'][$routes[1]]['active'] = '1';
                }
            }
        }else{
            $menus['content']['default'] = '1';
        }
        
        return $menus;
    }
    
    public function getMenuV2(){
        global $_W;
        $menu = array(
            'home' => array(
                "title" => "主页"
                ,"icon" => "layui-icon-home"
                ,"spread" => true
                ,"list" => array(
                    /** array(
                        "name" => ""
                        ,"title" => "控制台"
                        ,"jump" => "/"
                    ),*/
                    array(
                        "name" => "preview"
                        ,"title" => "预览"
                        ,"jump" => "/preview/"
                    )
                    ,array(
                        "name" => "cover"
                        ,"title" => "入口"
                        ,"jump" => "/cover"
                    )
                )
            ),
            "content" => array(
                "name" => "content"
                ,"title" => "内容"
                ,"icon" => "layui-icon-template"
                ,"spread" => true
                ,"list" => array(
                    array(
                        "name" => "article"
                        ,"title" => "文章列表"
                        ,"jump" => "/content/article/"
                    )
                    ,array(
                        "name" => "category"
                        ,"title" => "分类管理"
                        ,"jump" => "/content/category/"
                    )
                    ,array(
                        "name" => "nav"
                        ,"title" => "导航管理"
                        ,"jump" => "/content/nav/"
                    )
                )
            ),
            "page" => array(
                "name" => "page"
                ,"title" => "页面"
                ,"icon" => "layui-icon-layouts"
                ,"spread" => true
                ,"list" => array(
                    array(
                        "name" => "global"
                        ,"title" => "全局参数"
                        ,"jump" => "/page/global"
                    )
                    ,array(
                        "name" => "set"
                        ,"title" => "主题参数"
                        ,"jump" => "/page/set"
                    )
                    ,array(
                        "name" => "themes"
                        ,"title" => "主题切换"
                        ,"jump" => "/page/themes"
                    )
                )
            ),
            "plugin" => array(
                "name" => "plugin"
                ,"title" => "应用"
                ,"icon" => "layui-icon-app"
                ,"jump" => "/plugin/"
            ),
            "set" =>array(
                "name" => "set"
                ,"title" => "设置"
                ,"icon" => "layui-icon-set"
                ,"spread" => true
                ,"list" => array(
                    array(
                        "name" => "global"
                        ,"title" => "域名管理"
                        ,"jump" => "/set/domain"
                    ),
                    array(
                        "name" => "notice"
                        ,"title" => "消息推送"
                        ,"list" => array(
                            array(
                                'name' => 'msg',
                                'title' => '消息提醒',
                                'jump' => '/set/notice/msg'
                            ),/**
                            array(
                                'name' => 'diy',
                                'title' => '自定义消息库',
                                'jump' => '/set/notice/diy'
                            ),*/
                            array(
                                'name' => 'wechatTpl',
                                'title' => '微信模板库',
                                'jump' => '/set/notice/wechatTpl'
                            )
                        )
                    ),
                    array(
                        "name" => "base"
                        ,"title" => "基础设置"
                        ,"jump" => "/set/base"
                    )
                )
            ),
            "sys" => array(
                "name" => "sys",
                "title" => "系统",
                "icon" => "layui-icon-engine",
                "spread" => true,
                "list" => array(
                    array(
                        "name" => "set",
                        "title" => "设置",
                        "jump" => "/sys/set"
                    ),
                    array(
                        "name" => "copyright",
                        "title" => "版权",
                        "list" => array(
                            array(
                                "name" => "foreg",
                                "title" => "前端版权",
                                "jump" => "/sys/copyright/foreg"
                            ),
                            array(
                                "name" => "manage",
                                "title" => "后台版权",
                                "jump" => "/sys/copyright/manage"
                            )
                        )
                    ),
                    array(
                        'name' => 'plugin',
                        'title' => '应用',
                        'list' => array(
                            array(
                                'name' => 'perm',
                                'title' => '平台权限',
                                'jump' => '/sys/plugin/perm/'
                            ),
                            array(
                                'name' => 'wechat',
                                'title' => '系统公众号',
                                'jump' => '/sys/plugin/wechat'
                            )
                        )
                    )
                )
            ),
            "cloud" => array(
                "name" => "cloud",
                "title" => "云服务",
                "icon" => "layui-icon-auz",
                "spread" => false,
                "list" => array(
                    // array(
                    //     "name" => "upgrade",
                    //     "title" => "云校验",
                    //     "jump" => "/cloud/oauth/upgrade"
                    // ),
                    array(
                        "name" => "wiki",
                        "title" => "云文档",
                        "jump" => "/cloud/wiki"
                    ),
                    // array(
                    //     "name" => "shop",
                    //     "title" => "云商城",
                    //     "jump" => "/cloud/shop"
                    // )
                )
            )
            
        );


        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER){
            //$menu = array_merge_recursive($menu, $founder_menu);
            unset($menu['sys']);
            unset($menu['cloud']);
        }
        elseif(!file_exists(MODULE_ROOT . '/map.json') && file_exists(MODULE_ROOT . '/manifest.xml')){
            $menu['sys']['list'][] = array(
                'name' => 'we7site',
                'title' => 'we7设置',
                'jump' => '/sys/we7site'
            );
        }

        return $menu;
    }
}