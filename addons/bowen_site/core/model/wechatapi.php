<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/10/19 12:32:00] -->
 */
defined('IN_IA') or exit('Access Denied');

class Wechatapi_Model
{
    public function sendTplNotice($touser, $template_id, $postdata, $url = '', $topcolor = '#FF683F', $miniprogram = array(), $account_api = NULL)
    {
        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }

        if (!$account_api) {
            return NULL;
        }

        if(empty($account_api->account['key']) || $account_api->account['level'] != ACCOUNT_SERVICE_VERIFY) {
            return error(-1, '你的公众号没有发送模板消息的权限');
        }
        if(empty($touser)) {
            return error(-1, '参数错误,粉丝openid不能为空');
        }
        if(empty($template_id)) {
            return error(-1, '参数错误,模板标示不能为空');
        }
        if(empty($postdata) || !is_array($postdata)) {
            return error(-1, '参数错误,请根据模板规则完善消息内容');
        }
        $token = $account_api->getAccessToken();
        if (is_error($token)) {
            return $token;
        }

        $data = array();
        $data['touser'] = $touser;
        $data['template_id'] = trim($template_id);
        $data['url'] = trim($url);
        $data['topcolor'] = trim($topcolor);
        $data['data'] = $postdata;
        if(!empty($miniprogram)){
            $data['miniprogram'] = $miniprogram;
        }
        $data = json_encode($data);
        $post_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$token}";
        $response = ihttp_request($post_url, $data);
        if(is_error($response)) {
            return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
        }
        $result = @json_decode($response['content'], true);
        if(empty($result)) {
            return error(-1, "接口调用失败, 源数据: {$response['meta']}");
        } elseif(!empty($result['errcode'])) {
            return error(-1, "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']},信息详情：{$account_api->errorCode($result['errcode'])}");
        }
        return true;
    }

    public function sendCustomNotice($openid, $msg, $url = '', $account_api = NULL){
        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }

        if (!$account_api) {
            return NULL;
        }

        $content = '';
        if (is_array($msg)){
            foreach ($msg as $key => $value )
            {
                if (!(empty($value['title']))){
                    $content .= $value['title'] . ':' . $value['value'] . "\n";
                }else {
                    $content .= $value['value'] . "\n";
                    if ($key == 0){
                        $content .= "\n";
                    }
                }
            }
        }else{
            $content = html_entity_decode($msg, ENT_QUOTES);
            $content = emoji_unicode_decode($content);
            if (stripos($content, '"') !== false){
                $content = str_replace('"', "'", $content);
            }
        }
        if (!empty($url)){
            $content .= '<a href=\'' . $url . '\'>点击查看详情</a>';
        }

        return $account_api->sendCustomNotice(
            array(
                'touser' => $openid,
                'msgtype' => 'text',
                'text' => array(
                    'content' => urlencode($content)
                )
            )
        );
    }

    public function sendNews($openid, $articles, $account_api = NULL)
    {
        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }

        if (!$account_api) {
            return NULL;
        }

        $news_data = array();
        foreach($articles as $item){
            $news_data[] = array(
                'title' => urlencode($item['title']),
                'description' => urlencode(emoji_unicode_decode($item['description'])),
                'url'  => $item['url'],
                'picurl'  => tomedia($item['picurl'])
            );
        }
        $message = array(
            'touser' => $openid,
            'msgtype' => 'news',
            'news' => array(
                'articles' =>$news_data,
            ),
        );
        return $account_api->sendCustomNotice($message);
    }

    public function sendImage($openid, $media_id, $account_api = NULL)
    {
        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }

        if (!$account_api) {
            return NULL;
        }

        return $account_api->sendCustomNotice(array( 'touser' => $openid, 'msgtype' => 'image', 'image' => array('media_id' => $media_id)));
    }

    /** 发送语音消息 */
    public function sendVoice($openid, $media_id, $account_api = NULL)
    {
        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }

        if (!$account_api) {
            return NULL;
        }

        return $account_api->sendCustomNotice(array( 'touser' => $openid, 'msgtype' => 'voice', 'voice' => array('media_id' => $media_id)));
    }

    /** 公众号发送小程序卡片 */
    public function sendWxapp($openid, $param, $account_api = NULL)
    {
        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }

        if (!$account_api) {
            return NULL;
        }

        $miniprogrampage = array(
            'title' => $param['title'],
            'appid' => $param['appid'],
            'pagepath' => $param['pagepath'],
            'thumb_media_id' => $param['thumb_media_id']
        );
        return $account_api->sendCustomNotice(array( 'touser' => $openid, 'msgtype' => 'miniprogrampage', 'miniprogrampage' => $miniprogrampage));
    }

    /** 获取模板消息行业 */
    public function getTplNoticeIndustry($account_api = NULL){
        if(ACCOUNT_SERVICE_VERIFY != '4'){
            $industry = array(
                'primary_industry' => array(
                    'first_class' => '权限不足',
                    'second_class' => '权限不足'
                ),
                'secondary_industry' => array(
                    'first_class' => '权限不足',
                    'second_class' => '权限不足'
                )
            );
            return $industry;
        }

        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }

        if (!$account_api) {
            return NULL;
        }

        load()->func('communication');
        $token = $account_api->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=' . $token;
        $c = ihttp_request($url);
        $industry = @json_decode($c['content'], true);

        if (!is_array($industry)) {
            return false;
        }

        if (!empty($industry['errcode'])) {
            return false;
        }

        return $industry;
    }

    /** 从微信获取模板消息列表 */
    private function getTplNoticeAll($account_api = NULL){
        if(ACCOUNT_SERVICE_VERIFY != '4'){
            result(2, '当前平台没有模板消息权限！');
        }

        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }
        if (!$account_api) {
            return NULL;
        }

        $token = $account_api->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token={$token}";
        load()->func('communication');
        $result = ihttp_request($url);
        $tmplmsg_list = @json_decode($result['content'], true);
        return $tmplmsg_list['template_list'];
    }

    /** 对微信获取的模板消息列表转换格式，支持直接输出 */
    public function showTplNoticeList(){
        $templmsg_list = $this->getTplNoticeAll();
        $i = '0';
        foreach($templmsg_list as $item){
            preg_match_all('/{{(.*?)\.DATA}}/', $item['content'], $key);
            $templmsg_list[$i]['contents'] = $key[1];
            $i++;
        }
        return $templmsg_list;
    }

    /** 查看某条 模板消息 详情 */
    public function showTplNotice($template_id = '', $TplNoticeList = NULL){
        if(empty($template_id))return false;
        if(empty($TplNoticeList))$TplNoticeList = $this->showTplNoticeList();
        $TplNotice_all = array();
        foreach($TplNoticeList as $item){
            $TplNotice_all[$item['template_id']] = $item;
        }
        return $TplNotice_all[$template_id];
    }

    /**
     * @$template_id_short 模板消息的短ID，如TM00015
     */
    public function addTplNotice($template_id_short, $account_api = NULL){
        $template_id_short = trim($template_id_short);
        if(ACCOUNT_SERVICE_VERIFY != '4'){
            result(2, '当前平台没有模板消息权限！');
        }

        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }
        if (!$account_api){return NULL;}
        $token = $account_api->getAccessToken();

        load()->func('communication');
        $url = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token='.$token;
        $post = json_encode(array('template_id_short' => $template_id_short));
        $response = ihttp_request($url, $post);
        $result = @json_decode($response['content'],true);
        return $result;
    }

    public function delTplNotice($template_id, $account_api = NULL){
        if(ACCOUNT_SERVICE_VERIFY != '4'){
            result(2, '当前平台没有模板消息权限！');
            return false;
        }

        if (!$account_api) {
            $account_api = m('common')->getAccount();
        }
        if (!$account_api){return NULL;}
        $token = $account_api->getAccessToken();

        load()->func('communication');
        $url = 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token='.$token;
        $post = json_encode(array('template_id' => $template_id));
        $response = ihttp_request($url, $post);
        $result = @json_decode($response['content'],true);
        return $result;
    }
}
