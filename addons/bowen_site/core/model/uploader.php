<?php
/**
 * ������ҵ����
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 15:28:32] -->
 */
defined('IN_IA') or exit('Access Denied');

class Uploader_Model
{
    /**
     * $file = $_FILES['file'];
     */
    public function Image($file, $prefix = '')
    {
       global $_W;
        if (DEVELOPMENT) {
            $this->result(6, '�����Ա�رյ���ģʽ���ٲ�����');
        }
        load()->func('file');

        $result = file_upload($file);
        if (is_error($result)) {
			return $result;
		}
        file_remote_upload($result['path']);
        $uid = 0;
        if(defined('IN_SYS')){
            $uid = intval($_W['uid']);
        }
        $groupid = $this->GetImageGroup();
        if(!empty($result['success'])){
            $new_image_data = array(
                'uniacid' => $_W['uniacid'],
                'uid' => $uid,
                'filename' => $prefix?$prefix."-".$file['name']:$file['name'],
                'attachment' => $result['path'],
                'type' => 1,
                'group_id' => $groupid,
                'createtime' => TIMESTAMP
            );
            pdo_insert('core_attachment', $new_image_data);
        }
        return $result;
    }
    
    private function GetImageGroup(){
       global $_W;
        $id = m('cache')->get('sysImageGroup', $_W['uniacid']);
        if(empty($id)){
            $group = pdo_fetch("SELECT * FROM " . tablename('attachment_group') . " WHERE name = :name AND uniacid = :uniacid", array(':name' => MODULE_NAME, ':uniacid' => $_W['uniacid']));
            if(empty($group)){
                $data = array(
                    'name' => MODULE_NAME
                    ,'uniacid' => $_W['uniacid']
                    ,'uid' => 1
                    ,'type' => 0
                );
                pdo_insert('attachment_group', $data);
                $id = pdo_insertid();
            }else{
                $id = $group['id'];
            }
            m('cache')->set('sysImageGroup', $id, $_W['uniacid']);
        }
        return intval($id);
    }
}