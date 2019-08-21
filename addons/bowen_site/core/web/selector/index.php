<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/10 0:04:36] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends WebPage 
{
	public function main() 
	{
	   global $_W,$_GPC;
        if(!$_W['isajax'])$this->result(2, '参数错误，非法访问');
        $keyword = safe_gpc_string(trim($_GPC['kw']));
        $type = $_GPC['type'];
        if(!in_array($type, array('select_article', 'select_cate', 'select_vicefounder', 'select_diyform', 'select_fans'))){
            $this->result(2, '参数错误，非法请求');
        }
        $this->$type($keyword);
	}
    
    private function select_article($keyword = '')
    {
       global $_GPC;
       
        if(empty($keyword)){
            exit('Access Denied');
        }
        $commoncondition = "";
        $commoncondition .= " AND title LIKE '%{$keyword}%' ";
        $pindex = max(1, intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?$_GPC['psize']:15;
            
        $count = $this->getArticlesColumn($commoncondition);
        $articles = $this->getArticles($commoncondition, array('displayorder DESC', 'createtime DESC'), array($pindex, $psize));
        $pages = ceil($count/$psize);
            
        $content = '';
        if(count($articles) > 0){
            for($i = 0; $i < count($articles); $i++){
                $content .= '<div class="line">
                                <div class="icon icon-1"></div>
        				        <nav data-href="' . foregUrl('article',array('id'=>$articles[$i]['id']),true) . '" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="选择">选择</nav>
            				    <div class="text">' . "[{$articles[$i]['id']}]" .  $articles[$i]['title'] . '</div>
                            </div>';
            }
        }else{
            $content = '没有搜索到相关数据';
        }
        exit($content);
    }
    
    private function select_cate($keyword = '')
    {
       global $_W,$_GPC;
        
        if(empty($keyword)){
            $children = array();
    		$category = pdo_fetchall('SELECT * FROM ' . tablename($this->table_classes) . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' AND status  = 1 ORDER BY parid ASC, displayorder DESC');
    		foreach ($category as $index => $row) {
    			if (!empty($row['parid'])) {
    				$children[$row['parid']][] = $row;
    				unset($category[$index]);
    			}
    		}
            
            $content = '';
            foreach($category as $c){
                $content .= '<div class="line">
                                <div class="icon icon-1"></div>
        				        <nav data-href="' . foregUrl('class',array('id'=>$c['id']),true) . '" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="选择">选择</nav>
            				    <div class="text">' . "[{$c['id']}]" .  $c['title'] . '</div>
                            </div>';
                if(count($children[$c['id']]) > 0){
                    foreach($children[$c['id']] as $c_s){
                        $content .= '<div class="line">
                                        <div class="icon icon-2"></div>
                				        <nav data-href="' . foregUrl('class',array('id'=>$c_s['id']),true) . '" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="选择">选择</nav>
                    				    <div class="text">' . "[{$c_s['id']}]" .  $c_s['title'] . '</div>
                                    </div>';
                        if(count($children[$c_s['id']]) > 0){
                            foreach($children[$c_s['id']] as $c_t){
                                $content .= '<div class="line">
                                                <div class="icon icon-3"></div>
                        				        <nav data-href="' . foregUrl('class',array('id'=>$c_t['id']),true) . '" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="选择">选择</nav>
                            				    <div class="text">' . "[{$c_t['id']}]" .  $c_t['title'] . '</div>
                                            </div>';
                            }
                        }
                    }
                }
            }
            exit($content);
        }
        
        $commoncondition = " uniacid LIKE {$_W['uniacid']}";
        if(!empty($keyword)){
            $commoncondition .= " AND title LIKE '%{$keyword}%' ";
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?$_GPC['psize']:15;
            
        $count = $this->countAll($this->table_classes, $commoncondition);
        $category = $this->getAll($this->table_classes, $commoncondition, array('displayorder DESC', 'createtime DESC'), array($pindex, $psize));
        $pages = ceil($count/$psize);
            
        $content = '';
        if(count($category) > 0){
            for($i = 0; $i < count($category); $i++){
                $content .= '<div class="line">
                                <div class="icon icon-'.$category[$i]['level'].'"></div>
        				        <nav data-href="' . foregUrl('class',array('id'=>$category[$i]['id']),true) . '" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="选择">选择</nav>
            				    <div class="text">' . $category[$i]['title'] . '</div>
                            </div>';
            }
        }else{
            $content = '没有搜索到相关数据';
        }
        exit($content);
    }
    
    private function select_vicefounder($keyword = ''){
       global $_GPC;
        if(empty($keyword)){
            exit('Access Denied');
        }
        
        $commoncondition = " founder_groupid LIKE ". ACCOUNT_MANAGE_GROUP_VICE_FOUNDER;
        $commoncondition .= " AND username LIKE '%{$keyword}%' ";
        $pindex = max(1, intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?$_GPC['psize']:15;
            
        $count = $this->countAll('users', $commoncondition);
        $vice_founders = $this->getAll('users', $commoncondition, array('joindate DESC'), array($pindex, $psize));
        $pages = ceil($count/$psize);
        
        $content = '';
        if(!empty($vice_founders)){
            for($i = 0; $i < count($vice_founders); $i++){
                $content .= '<div class="line">
                                <div class="icon icon-1"></div>
        				        <nav data-href="' . $vice_founders[$i]['uid'] . '" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="选择">选择</nav>
            				    <div class="text">' . "[{$vice_founders[$i]['uid']}]" . $vice_founders[$i]['username'] . '</div>
                            </div>';
            }
        }else{
            $content = '没有搜索到相关数据';
        }
        exit($content);
    }
    
    private function select_diyform($keyword = ''){
       global $_W, $_GPC;
        if(empty($keyword)){
            exit('Access Denied');
        }
        
        $config = m('plugin')->getConfig('diyform');
        $table = $config['table'];
        $commoncondition = " uniacid = {$_W['uniacid']} ";
        $commoncondition .= " AND title LIKE '%{$keyword}%' ";
        $pindex = max(1, intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?intval($_GPC['psize']):15;
        $count = $this->countAll($table['temp'], $commoncondition);
        $items = $this->getAll($table['temp'], $commoncondition, array('createtime DESC'), array($pindex, $psize));
        $pages = ceil($count/$psize);
        
        $content = '';
        if(count($items) > 0){
            for($i = 0; $i < count($items); $i++){
                $content .= '<div class="line">
                                <div class="icon icon-1"></div>
        				        <nav data-href="' . foregUrl('diyform', array('id'=>$items[$i]['id']), true) . '" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="选择">选择</nav>
            				    <div class="text">' . "[{$items[$i]['id']}]" . $items[$i]['title'] . '</div>
                            </div>';
            }
        }else{
            $content = '没有搜索到相关数据';
        }
        exit($content);
    }

    private function select_fans($keyword = ''){
	   global $_W,$_GPC;
        if(empty($keyword)){
            $this->result(2, '参数错误，禁止操作');
        }
        $inputname = trim($_GPC['inputname']);
        $inputname = !empty($inputname)?$inputname:'openid[]';

        $content = '';

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 12;

        //处理借权下的搜索
        $oauth = m('common')->getOauth($_W['uniacid']);
        $acid = !empty($oauth['account'])?$oauth['account']:$_W['acid'];
        if($acid != $_W['acid']){
            $uniacid = m('common')->getUniacidByAcid($acid);;
        }
        $uniacid = !empty($uniacid)?intval($uniacid):$_W['uniacid'];

        $condition = " WHERE f.`uniacid` = :uniacid AND f.`acid` = :acid";
        $condition .= " AND f.`follow` = 1";
        $param = array(
            ':uniacid' => $uniacid,
            ':acid' => $acid
        );

        $keyword = addslashes($keyword);
        if (!empty($keyword)) {
            $condition .= " AND ((f.`nickname` LIKE :nickname) OR (f.`openid` LIKE :openid))";
            $param[':nickname'] = "%" . $keyword . "%";
            $param[':openid'] = "%" . $keyword . "%";
        }

        $select_sql = "SELECT %s FROM " .tablename('mc_mapping_fans')." AS f LEFT JOIN ".tablename('mc_fans_tag_mapping')." AS m ON m.`fanid` = f.`fanid` " . $condition ." %s";
        $fans_list_sql = sprintf($select_sql, "f.fanid, f.acid, f.uniacid, f.uid, f.openid, f.nickname, f.tag ", " GROUP BY f.`fanid` ORDER BY f.`fanid` DESC LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize);
        $fans_list = pdo_fetchall($fans_list_sql, $param);
        if (!empty($fans_list)) {
            foreach ($fans_list as &$v) {
                if (!empty($v['uid'])) {
                    $user = mc_fetch($v['uid'], array('realname', 'nickname', 'mobile', 'email', 'avatar'));
                }
                if (!empty($user)) {
                    $v['member'] = $user;
                }
                if (!empty($v['tag']) && is_string($v['tag'])) {
                    if (is_base64($v['tag'])) {
                        $v['tag'] = base64_decode($v['tag']);
                    }
                    if (is_serialized($v['tag'])) {
                        $v['tag'] = @iunserializer($v['tag']);
                    }
                    if (!empty($v['tag']['headimgurl'])) {
                        $v['tag']['avatar'] = tomedia($v['tag']['headimgurl']);
                    }
                    if (empty($v['nickname']) && !empty($v['tag']['nickname'])) {
                        $v['nickname'] = strip_emoji($v['tag']['nickname']);
                    }
                }
                if (empty($v['tag'])) {
                    $v['tag'] = array();
                }
                if (empty($v['user']['nickname']) && !empty($v['tag']['nickname'])) {
                    $v['user']['nickname'] = strip_emoji($v['tag']['nickname']);
                }
                if (empty($v['user']['avatar']) && !empty($v['tag']['avatar'])) {
                    $v['user']['avatar'] = $v['tag']['avatar'];
                }
                unset($user);
            }
            unset($v);

            foreach($fans_list as $key => $fans){
                $content .= '<tr>
                                <td>
                                    <img src="'.$fans['tag']['avatar'].'" style="width:30px;height:30px;padding1px;border:1px solid #ccc"> '.$fans['nickname'].'
                                </td>
                                <td>'.$fans['member']['realname'].'</td>
                                <td style="text-align: center;">'.$fans['member']['mobile'].'</td>
                                <td style="width:80px; text-align: right;">
                                    <a href="javascript:;" class="choseClick layui-btn layui-btn-primary layui-btn-sm" data-type="choseFans"
                                        data-inputname="'.$inputname.'"
                                        data-openid="'.$fans['openid'].'"
                                        data-nickname="'.$fans['nickname'].'"
                                        data-avatar="'.$fans['tag']['avatar'].'">
                                        选择
                                    </a>
                                </td>
                              </tr>';
            }
        }else{
            $content = '<div class="tip" style="color: #FF5722;">搜索的信息不存在</div>';
        }
        exit($content);
    }
}
