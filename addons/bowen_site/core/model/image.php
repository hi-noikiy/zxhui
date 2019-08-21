<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/8/31 15:12:28] -->
 */
defined('IN_IA') or exit('Access Denied');

class Image_Model
{
    /**
     * $source必须为完整的图片路径，传入前tomedia
     */
    public function image_crop($source, $width =  '', $height = '', $type = 'center', $target = ''){
       global $_W, $_B;
        if(empty($source)){return false;}
        $file_name = basename($source);
        if(empty($file_name)){return false;}
        if(empty($width)){return $source;}
        if(empty($height)){$height = $width;}
        if(empty($target)){
            $target = M_DATA . "cache/{$_W['uniacid']}/images/{$width}_{$height}_{$file_name}";
        }
        
        $remote = $_W['setting']['remote_complete_info'];
        
        /** 如果平台应用开启了远程附件，则优先读取平台的远程附件设置 */
        $remote_uniacid = $_W['setting']['remote_complete_info'][$_W['uniacid']];
        $remote = !empty($remote_uniacid['type'])?$remote_uniacid:$remote;
        
        /** 阿里云 */
        if(!empty($remote['type']) && $remote['type'] == '2'){
            if(!empty($_W['attachurl_remote'])){
                if (stripos($source, $_W['attachurl_remote']) !== false){
                    //return tomedia($source) . "?x-oss-process=image/resize,m_fill,w_{$width},limit_0&y={$height}";
                    return tomedia($source) . "?x-oss-process=image/resize,m_fill,w_{$width},h_{$height},limit_0";
                }
            }
        }
        /** 七牛 */
        if(!empty($remote['type']) && $remote['type'] == '3'){
            if(!empty($_W['attachurl_remote'])){
                if (stripos($source, $_W['attachurl_remote']) !== false){
                    return tomedia($source) . "?imageMogr2/thumbnail/!{$width}x{$height}r/gravity/Center/crop/{$width}x{$height}";
                }
            }
        }
        /** 腾讯云储存，需要开启万象优图 */
        if(!empty($remote['type']) && $remote['type'] == '4' && $_B['config']['upload']['cos']['cloud_image']['open'] == '1'){
            if(!empty($_W['attachurl_remote'])){
                if (stripos($source, $_W['attachurl_remote']) !== false){
                    return tomedia($source) . "?imageView2/1/w/{$width}/h/{$height}";
                }
            }
        }
        
        /** 非远程附件或者其他远程附件 */
        if($type == 'center' && !file_exists($target)){
            $this->image_center_crop($source, $width, $height, $target);
        }
        
        /** 取消原本输出base64图片的步骤，改为直接输出缓存图片 */
        /** return $this->base64EncodeImage($target);*/
        return M_URL . "data/cache/{$_W['uniacid']}/images/{$width}_{$height}_{$file_name}";
    }
    
    /**
     * 居中裁剪图片
     * @param string $source [原图路径]
     * @param int $width [设置宽度]
     * @param int $height [设置高度]
     * @param string $target [目标路径]
     * @return bool [裁剪结果]
     */
    public function image_center_crop($source, $width =  '', $height = '', $target = '')
    {
        global $_B;
        /** 根据类型载入图像 */
        $img_info = !empty($_B['img_info'])?$_B['img_info']:getimagesize($source);
        switch ($img_info['mime']) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
        }
        if (!isset($image)) return false;
        /** 获取图像尺寸信息 */
        $target_w = !empty($width)?$width:160;
        $target_h = !empty($height)?$height:160;
        $source_w = imagesx($image);
        $source_h = imagesy($image);
        /** 计算裁剪宽度和高度 */
        $judge = (($source_w / $source_h) > ($target_w / $target_h));
        $resize_w = $judge ? ($source_w * $target_h) / $source_h : $target_w;
        $resize_h = !$judge ? ($source_h * $target_w) / $source_w : $target_h;
        $start_x = $judge ? ($resize_w - $target_w) / 2 : 0;
        $start_y = !$judge ? ($resize_h - $target_h) / 2 : 0;
        /** 绘制居中缩放图像 */
        $resize_img = imagecreatetruecolor($resize_w, $resize_h);
        imagecopyresampled($resize_img, $image, 0, 0, 0, 0, $resize_w, $resize_h, $source_w, $source_h);
        $target_img = imagecreatetruecolor($target_w, $target_h);
        imagecopy($target_img, $resize_img, 0, 0, $start_x, $start_y, $resize_w, $resize_h);
        /** 将图片保存至文件 */
        if($target != ''){
            if (!file_exists(dirname($target))) mkdir(dirname($target), 0777, true);
            switch ($img_info['mime']) {
                case 'image/jpeg':
                    imagejpeg($target_img, $target);
                    break;
                case 'image/png':
                    imagepng($target_img, $target);
                    break;
                case 'image/gif':
                    imagegif($target_img, $target);
                    break;
            }
            return boolval(file_exists($target));
        }
        header("Content-Type:".$img_info['mime']);
        switch ($img_info['mime']) {
            case 'image/jpeg':
                imagejpeg($target_img);
                break;
            case 'image/png':
                imagepng($target_img);
                break;
            case 'image/gif':
                imagegif($target_img);
                break;
        }
    }
    
    public function base64EncodeImage ($image)
    {
        $base64_image = '';
        if(!is_array($image) && is_file($image)){
            $image_info = getimagesize($image);
            $image_data = fread(fopen($image, 'r'), filesize($image));
        }else{
            $image_info = $image['info'];
            $image_data = $image['data'];
        }
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }
}

