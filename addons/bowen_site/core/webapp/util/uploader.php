<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 21:49:59] -->
 */
defined('IN_IA') or exit('Access Denied');

class Uploader_Page extends WebappPage
{
	public function main()
	{
		global $_W,$_GPC;
        if(!$_W['isajax'] || !$_W['ispost']){
            exit($this->result(2, '无效的访问方式'));
        }
        if(!empty($_FILES['file'])){
            $result = m('uploader')->Image($_FILES['file']);
            $src = tomedia($result['path']);
        }
        if($result['success']){
            $this->result(0, 'success', array('path' => $result['path'], 'src' => $src));
        }
        $this->result(2, '上传失败', $result);
	}
}
