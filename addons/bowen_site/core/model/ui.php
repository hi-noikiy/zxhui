<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/9/26 16:21:33] -->
 */
defined('IN_IA') or exit('Access Denied');

class Ui_Model
{
    /** 转换图片标签为layui懒加载结构 */
    public function lazy($html = '')
	{
		global $_W;
		$html = preg_replace_callback('/<img.*?src=[\\\\\'| \\"](.*?(?:[\\.gif|\\.jpg|\\.png|\\.jpeg|\\.bmp]?))[\\\\\'|\\"].*?[\\/]?>/', function($matches) use($_W) {
			$images = $matches[0];
			if (strexists($images, 'http://') || strexists($images, 'https://')) {
				return preg_replace('/src=/', 'lay-src=', $images);
			}

			$attachurl = str_replace(array('https://', 'http://'), '', $_W['attachurl_local']);

			if (strexists($images, $attachurl)) {
				$image = $matches[1];
				$image = str_replace(array('https://', 'http://'), '', $image);
				$image = str_replace($attachurl, '', $image);
				$images = str_replace(array('https://', 'http://'), '', $images);
				$images = str_replace($attachurl, '', $images);
				$images = str_replace($image, tomedia($image), $images);
			}

			return preg_replace('/src=/', 'lay-src=', $images);
		}, $html);
        
		return $html;
	}

	/** 对内容进行一些layui方面的优化 */
    public function layui($html = '', $need_lazy = true)
    {
        if($need_lazy){
            $html = $this->html_lazy($html);
        }else{
            $html = html_entity_decode($html, ENT_QUOTES);
        }
        
        $html = preg_replace_callback('/<blockquote.*?[\\/]?>/', function($matches) {
			$blockquotes = $matches[0];
			
			if (strexists($blockquotes, 'class=')) {
				return preg_replace('/class="/', 'class="layui-elem-quote layui-quote-nm ', $blockquotes);
			}

			return preg_replace('/>/', ' class="layui-elem-quote layui-quote-nm " >', $blockquotes);
		}, $html);
        
        $html = preg_replace_callback('/<pre.*?[\\/]?>/', function($matches) {
			$pres = $matches[0];
			
			if (strexists($pres, 'class=')) {
				return preg_replace('/class="/', 'class="layui-code ', $pres);
			}

			return preg_replace('/>/', ' class="layui-code " >', $pres);
		}, $html);
        
		return $html;
    }
    
    /** 对编辑器存库内容进行转换 */
    public function ueditor_content($html = ''){
        $html = html_entity_decode($html, ENT_QUOTES);
        $html = preg_replace_callback('|<blockquote>(.*)</blockquote>|isU', function($matches) {
            $blo = $matches[0];
            $blo = str_replace("<p>", '', $blo);
            $blo = str_replace("</p>", '', $blo);
            return $blo;
		}, $html);
        
        $html = preg_replace_callback('|<pre.*>(.*)</pre>|isU', function($matches) {
			$pres = $matches[1];
			return '<pre class="brush:bowen_code;toolbar:false">'.html_entity_decode(htmlspecialchars(htmlentities($pres)), ENT_QUOTES).'</pre>';
		}, $html);
        
        return htmlentities($html);
    }

    /** 分离文章中的图片及内容，并以数组形式输出 */
    public function separation_ImgText($html = ''){
        $html = html_entity_decode($html, ENT_QUOTES);
        /** 提取图片 */
        $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png|\.jpeg|\.bmp]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern, $html,$match);
        $images = array_unique($match[1]);

        /** 去除内容中的图片 */
        $content = preg_replace("/(<img.*?>)/is", '', $html);

        $data = array(
            'images' => $images
            ,'content' => $content
            ,'html' => $html
        );

        return $data;
    }

    public function html_lazy($html = '')
    {
        $html = html_entity_decode($html, ENT_QUOTES);
        return $this->lazy($html);
    }

    /** 让文本框内容输出时能换行和空格 */
    public function replaceRN($content, $type = 'p'){
        $pattern = array(
            '/ /',/** 半角下空格 */
            '/　/',/** 全角下空格 */
            '/\r\n/',/** window 下换行符 */
            '/\n/',/** Linux && Unix 下换行符 */
        );
        if($type == 'p'){
            $replace = array('&nbsp;','&nbsp;','</p><p>','</p><p>');
            $content = preg_replace($pattern, $replace, $content);
            $content = '<p>'.$content.'</p>';
        }elseif($type == 'br'){
            $replace = array('&nbsp;','&nbsp;','<br />','<br />');
            $content = preg_replace($pattern, $replace, $content);
        }
        return $content;
    }

    /** 去除换行、空格 **/
    public function deleteRN($content, $is_en = false){
        $pattern = array(
            '/ /',/** 半角下空格 */
            '/　/',/** 全角下空格 */
            '/&nbsp;/',/** html里的空格占位符 */
            '/\r\n/',/** window 下换行符 */
            '/\n/',/** Linux && Unix 下换行符 */
        );
        if($is_en){
            $replace = array('&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;');
        }else{
            $replace = array("", "", "", "", "");
        }
        $content = preg_replace($pattern, $replace, $content);
        return $content;
    }

    /**
     * 去除图片链接中的附件地址
     * 注：如果是本地附件，因多域名使用的问题，会存在没能识别出附件地址的情况
     */
    public function replace_image_attachurl($image_url){
        global $_W;
        $image_url = str_replace($_W['attachurl'], '', $image_url);
        return $image_url;
    }

    /** 从百度编辑器提交的内容中仅提取文字 */
    public function html_to_text($detail){
        $detail = htmlspecialchars_decode($detail);
        $detail = strip_tags($detail);
        $detail = $this->deleteRN($detail);
        return $detail;
    }
}

