<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 15:59:59] -->
 */
defined('IN_IA') or exit('Access Denied');

class Classes_Page extends ComWebPage 
{
	public function main() 
	{
	   global $_W,$_GPC,$_B;
        $_W['page']['title'] = '文章分类';
        $settings = m('common')->getModuleSetting($_W['uniacid']);
        $_B['setting'] = $settings;
        $op = trim($_GPC['op']);
        $class_themes = $this->getThemes_mobile_config('class');
        
        $id = intval($_GPC['id']);
        
        if($op == ''){
            $children = array();
    		$category = pdo_fetchall('SELECT * FROM ' . tablename($this->table_classes) . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY parid ASC, displayorder DESC');
    		foreach ($category as $index => $row) {
    			if (!empty($row['parid'])) {
    				$children[$row['parid']][] = $row;
    				unset($category[$index]);
    			}
    		}
            
            if(empty($settings['global']['mobilethemes'])){
                itoast('请先选择模板！', webUrl('setting/themes'), 'error');
            }
            
            include $this->mytemplate('content/classes');
        }
        
        if($op == 'add' || $op == 'edit'){
            if($op == 'edit'){
                $class = $this->getClassInfo($id);
                $class['value'] = iunserializer($class['value']);
                $class['images'] = iunserializer($class['images']);
                if(!empty($class['parid'])){
                    $lastclass = $this->getClassInfo($class['parid']);
                    if($class['topid'] != $class['parid'] && $class['level'] == 3){
                        $topclass = $this->getClassInfo($class['topid']);
                    }
                }
            }else{
                $level = 1;
                $lastclass = $this->getClassInfo($id);
                if(!empty($lastclass)){
                    $level = 2;
                    $topid = $parid = $lastclass['id'];
                    if(!empty($lastclass['parid'])){
                        $level = 3;
                        $topid = $lastclass['parid'];
                        $topclass = $this->getClassInfo($lastclass['parid']);
                    }
                }
            }
            
            if(checksubmit('submit')){
                $value = array(
                    'seo' => $_GPC['seo']
                    ,'psize' => intval($_GPC['psize'])
                    ,'mobilethumb' => trim($_GPC['mobilethumb'])
                );
                
                $tourl = trim($_GPC['tourl']);
                if($tourl == foregUrl('class', array('id' => $id))){
                    mymessage('直接链接填写错误！', '', 'error');
                }
                
                $data = array(
                    'title' => trim($_GPC['title']),
                    'subtitle' => trim($_GPC['subtitle']),
                    'icon' => trim($_GPC['icon']),
                    'images' => iserializer($_GPC['images']),
                    'description' => $_GPC['description'],
                    'sign' => trim($_GPC['sign']),
                    'thumb' => trim($_GPC['thumb']),/** 分类顶部图，命名有误 */
                    'themes' => $_GPC['themes'],
                    'tourl' => trim($_GPC['tourl']),
                    'value' => iserializer($value),
                    'status' => intval($_GPC['status']),
                    'displayorder' => intval($_GPC['displayorder'])
                );
                
                if(TEST_SITE){mymessage('测试站禁止操作数据', 'refresh','error');}
                
                if($op == 'add'){
                    $data['topid'] = intval($topid);
                    $data['parid'] = intval($parid);
                    $data['level'] = intval($level);
                    $data['uniacid'] = $_W['uniacid'];
                    $data['createtime'] = TIMESTAMP;
                    $result = pdo_insert($this->table_classes, $data);
                    $new_class = pdo_insertid();
                }else{
                    $result = pdo_update($this->table_classes, $data, array('id'=>$id));
                }
                
                if($new_class){
                    //mymessage('新增分类成功', webUrl('content/classes', array('op' => 'edit', 'id' => $new_class)), 'success');
                    mymessage('新增分类成功', webUrl('content/classes'), 'success');
                }
                mymessage('操作成功', webUrl('content/classes', array('op' => 'edit', 'id' => $id)), 'success');
            }
            
            include $this->mytemplate('content/classes/post');
        }
        
        if($op == 'delete'){
            if(TEST_SITE){itoast('测试站禁止操作数据', 'refresh','error');}
            
            if(empty($id)){
                itoast('参数错误', 'referer', 'error');
            }
            $articles = $this->getClasseArticlesColumn($id);
            if(!empty($articles)){
                itoast('当前分类下还有文章未删除或未转移到其他分类', 'referer', 'error');
            }
            $result = pdo_delete($this->table_classes, array('id'=>$id));
            if(!empty($result)){
                itoast('操作成功', webUrl('content/classes'),'success');
            }
        }
	}
    
    public function changeStatus(){
       global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $data = intval($_GPC['data']);
        //初始数据
        $errno = '1';
        $message = '未知错误';
        $content['status'] = $data;
        
        empty($data)?($data = 1):$data = 0;
        
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        
        $result = pdo_update($this->table_classes, array('status' => $data), array("id" => $id));
        if(!empty($result)){
            $errno = '0';
            $message = 'ok';
            $content['status'] = $data;
        }
        
        $this->result($errno, $message, $content);
    }
    
    public function upgradeCategory(){
        global $_W;
        $category = pdo_fetchall('SELECT * FROM ' . tablename($this->table_classes));
        $i = 0;
        foreach($category as $class){
            if(empty($class['level'])){
                $level = !empty($class['topid'])?2:1;
                $result = pdo_update($this->table_classes, array('parid' => $class['topid'], 'level' => $level), array('id'=>$class['id']));
                if(!empty($result)){
                    $i++;
                }
            }
        }
        if($i == 0){
            itoast('分类数据已是最新，无需修复', 'referer','success');
        }
        itoast('修复 ' . $i . '条 数据成功', 'referer','success');
    }
}
