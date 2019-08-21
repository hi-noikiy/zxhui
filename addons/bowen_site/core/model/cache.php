<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/10/23 23:21:47] -->
 */
defined('IN_IA') or exit('Access Denied');

class Cache_Model
{
    public function get($key = '', $uniacid = '')
    {
        return cache_load($this->get_key($key, $uniacid));
    }
    
    public function set($key = '', $value = null, $uniacid = '')
    {
        return cache_write($this->get_key($key, $uniacid), $value);
    }

    public function del($key, $uniacid = '')
    {
        return cache_delete($this->get_key($key, $uniacid));
    }
    
    public function get_key($key = '', $uniacid = 0)
    {
        $uniacid = intval($uniacid);
        return BOWEN_SITE_PREFIX . md5($uniacid . '_bowen_site_' . $key);
    }

    /**
     * 旧版本,已废弃

    public function getArray($key = '', $uniacid = '')
    {
        return $this->get($key, $uniacid);
    }*/
}
