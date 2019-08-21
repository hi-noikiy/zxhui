<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/22 11:22:07] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends WebPage 
{
	public function main() 
	{
	   global $_W, $_GPC, $_B;

        $copyright = $this->getCopyright();
        if($copyright){
            $copyright = array_filter($copyright['param']);
            $_W['page']['copyright'] = array_merge($_W['page']['copyright'],$copyright);
        }

        include $this->mytemplate();
	}
    
    /** 输出全局变量 */
    public function getGlobal() 
	{
        global $_W, $_B;
        
        $this->result(0, 'success', array('W' => $_W, 'B' => $_B));
    }
    
    /** 输出分类信息 */
    public function getCategory(){
        global $_W;
        $children = array();
  		$category = pdo_fetchall('SELECT * FROM ' . tablename($this->table_classes) . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY parid ASC, displayorder DESC');
        if(!$category){
            $this->result(-1, '请先添加分类信息',array('re_url'=>'/content/category/'));
        }
  		foreach ($category as $index => $row) {
            if (!empty($row['parid'])) {
                $children[$row['parid']][] = $row;
				unset($category[$index]);
 			}
  		}
        $this->result(0, 'success', array('category' => $category, 'children' => $children));
    }
    
    /** 输出登录信息 */
    public function getSession() 
	{
        global $_W;
        
        $session = array(
            'username' => $_W['user']['username']
            ,'uid' => $_W['uid']
            ,'avatar' => $_W['user']['avatar']
            ,'role' => $_W['role']
            
            ,'uniaccount' => $_W['uniaccount']
        );
        
        $this->result(0, 'success', $session);
    }
    
    /** 检索新消息 */
    public function getNewMsg() 
	{
        global $_W;
        
        $new = array(
            'newmsg' => 0
        );
        
        $this->result(0, 'success', $new);
    }
    
    /** 输出菜单 */
    public function getMenu()
    {
        $menu = m('system')->getMenuV2();
        $this->result(0, "", $menu);
    }

    public function getManageCopyright(){
        $copyright = $this->getCopyright();
        $this->result(0, 'success', $copyright);
    }

    public function runTask(){
        m('task')->api_run();
    }
}
