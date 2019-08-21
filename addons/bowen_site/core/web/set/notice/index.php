<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/10 11:50:17] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends ComWebPage
{
    public function __construct()
    {
        global $_W;
        parent::__construct();
        if(!$_W['isajax'] || !$_W['ispost']){
            $this->result(2, '参数错误，非法访问');
        }
    }

    public function getAllTpl(){
        global $_W;
        //对借权用户禁止访问
        $oauth = m('common')->getOauth($_W['uniacid']);
        if(!empty($oauth['account']) && $oauth['account'] != $_W['acid']){
            $this->result(2, '当前平台已设置借权，禁止访问本页面', array('re_url' => '/set/notice/msg'));
        }

        $account_api = m('common')->getAccount();
        $industry = m('wechatapi')->getTplNoticeIndustry($account_api);
        if(empty($industry))$this->result(2, '当前平台缺少模板消息权限，或未开通模板消息', array('re_url' => '/set/notice/msg'));
        $list = m('wechatapi')->showTplNoticeList($account_api);
        $this->result(0, 'success', $list, array('industry'=> $industry));
    }

    public function viewTpl(){
        global $_GPC;
        $tplId = trim($_GPC['template_id']);
        $tplInfo = m('wechatapi')->showTplNotice($tplId);
        $this->result(0, 'success', $tplInfo);
    }

    public function addTpl(){
        global $_GPC;
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $tplId_short = trim($_GPC['template_id_short']);
        $result = m('wechatapi')->addTplNotice($tplId_short);
        $this->result($result['errcode'], $result['errmsg'], $result);
    }

    public function delTpl(){
        global $_GPC;
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $tplId = trim($_GPC['template_id']);
        $result = m('wechatapi')->delTplNotice($tplId);
        $this->result($result['errcode'], $result['errmsg'], $result);
    }
}
