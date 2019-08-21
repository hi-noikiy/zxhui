<?php
/**
 * 玖祺企业官网模块
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/17 12:29:48] -->
 */
defined('IN_IA') or exit('Access Denied');

//!(defined('BOWEN_SITE_AUTH_URL')) && define('BOWEN_SITE_AUTH_URL', 'https://cloud.we7pc.com/oauth/');

if (!(function_exists('m'))) {
	function m($name = '') 
	{
		static $_modules = array();
		if (isset($_modules[$name])){
			return $_modules[$name];
		}
		$model = M_CORE . 'model/' . strtolower($name) . '.php';
		if (!(is_file($model))) 
		{
			exit(' Model ' . $name . ' Not Found!');
		}
		require_once $model;
		$class_name = ucfirst($name) . '_Model';
		$_modules[$name] = new $class_name();
		return $_modules[$name];
	}
}

if (!(function_exists('d'))) {
	function d($name = '') 
	{
		static $_modules = array();
		if (isset($_modules[$name])){
			return $_modules[$name];
		}
		$model = M_CORE . 'data/' . strtolower($name) . '.php';
		if (!(is_file($model))) 
		{
			exit(' Data Model ' . $name . ' Not Found!');
		}
		require_once M_INC . 'data_model.php';
		require_once $model;
		$class_name = ucfirst($name) . '_DataModel';
		$_modules[$name] = new $class_name();
		return $_modules[$name];
	}
}

if (!function_exists('p')) {
    function p($name = '')
    {
        static $_plugins = array();

        if (isset($_plugins[$name])) {
            return $_plugins[$name];
        }

        $model = M_PLUGIN . strtolower($name) . '/core/model.php';

        if (!is_file($model)) {
            return false;
        }

        require_once M_INC . 'plugin_model.php';
        require_once $model;
        $class_name = ucfirst($name) . 'Model';
        $_plugins[$name] = new $class_name($name);
        return $_plugins[$name];
    }
}

if (!function_exists('com')) {
    function com($name = '')
    {
        static $_coms = array();

        if (isset($_coms[$name])){
            return $_coms[$name];
        }

        $model = M_CORE . 'com/' . strtolower($name) . '.php';
        if (!is_file($model)) {
            return false;
        }
        require_once M_INC . 'com_model.php';
        require_once $model;
        $class_name = ucfirst($name) . '_ComModel';
        $_coms[$name] = new $class_name($name);

        return $_coms[$name];
    }
}

if (!(function_exists('mychecklogin'))) {
    function mychecklogin($checkPermission = true) {
        global $_W;
    	if (empty($_W['uid'])) {
    		if (!empty($_W['setting']['copyright']['showhomepage'])) {
    			itoast('', url('account/welcome'), 'warning');
    		} else {
    			itoast('', webUrl('pcsite/user/login'), 'warning');
    		}
            if($_W['isajax']){
                result('1001', '请重新登录！');
            }
    	}
        
        if(!empty($_W['uid']) && $checkPermission){
            $role = permission_account_user_role($_W['uid'], $_W['uniacid']);
            if(empty($role)) {
                mymessage('操作失败, 非法访问.', '', 'error');
            }
        }
    	return true;
    }
}

if (!(function_exists('mymessage')))
{
    function mymessage($msg, $redirect = '', $type = '') {
    	global $_W, $_GPC;
    	if($redirect == 'refresh') {
    		$redirect = $_W['siteroot'] . '.' . $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
    	}
    	if($redirect == 'referer') {
    		$redirect = referer();
    	}
   		$redirect = safe_gpc_url($redirect);
        
    	if($redirect == '') {
    		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
    	} else {
    		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
    	}
    	if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {
    		if($type != 'ajax' && !empty($_GPC['target'])) {
    			exit("
    <script type=\"text/javascript\">
    	var url = ".(!empty($redirect) ? 'parent.location.href' : "''").";
    	var modalobj = util.message('".$msg."', '', '".$type."');
    	if (url) {
    		modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
    	}
    </script>");
    		} else {
                $r_errno = ($type == 'success')?0:2;
                $r_data = ($redirect)?array('re_url' => $redirect):'';
    			result($r_errno, $msg, $r_data);
    		}
    	}
    	if (empty($msg) && !empty($redirect)) {
    		header('Location: '.$redirect);
    		exit;
    	}
    	$label = $type;
    	if($type == 'error') {
    		$label = 'danger';
    	}
    	if($type == 'ajax' || $type == 'sql') {
    		$label = 'warning';
    	}
        
   		include mytemplate('common/message', 'web');
    	exit;
    }
}

if (!(function_exists('mytemplate')))
{
    function mytemplate($filename = '', $ttheme = '') {
       global $_W,$_GPC,$_B;
        $_W['config']['setting']['filemode'] = 0755;
		$name = strtolower(MODULE_NAME);
		$defineDir = dirname(MODULE_ROOT).'/'.$name;
        $isempty_filename = false;
        if(empty($filename)){
            $filename = implode('/', explode('.', $_B['routes']));
            $isempty_filename = true;
        }
        
        if(empty($_B['setting'])){
            $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        }
        
		if(defined('IN_SYS') || $filename == 'common/message') {
            $filename_old = $filename;
            $theme = $_B['core_settings']['webtheme'];
            if(empty($theme)){
                $theme = 'default';
            }
            $filename = $theme.'/'.$filename;
			$source = IA_ROOT . "/addons/{$name}/template/web/{$filename}.html";
			$compile = IA_ROOT . "/data/tpl/{$name}/template/web/{$filename}.tpl.php";
            
            if($ttheme == 'mobile')
            {/** 先读取模板中的web文件，实现模板对web的替换需求 */
                $mtheme = $_B['setting']['global']['mobilethemes'];
                if(empty($mtheme)){
                    $mtheme = 'default';
                }
                
                $compile = IA_ROOT . "/data/tpl/{$name}/template/mobile/".$mtheme."/web/{$filename}.tpl.php";
				$source = $defineDir . "/template/" . $ttheme . "/" . $mtheme . "/{$filename_old}.html";
                if(!is_file($source))
                {
    				$source = $defineDir . "/template/" . $ttheme . "/" . $mtheme . "/web/{$filename_old}.html";
    			}
                if(!is_file($source))
                {
    				$source = $defineDir . "/template/" . $ttheme . "/default/{$filename_old}.html";
    			}
                if(!is_file($source))
                {//未替换的就读取默认模板中的
    				$source = $defineDir . "/template/mobile/default/{$filename_old}.html";
    			}
			}
            
            if ($_W['isplugin'] && (empty($ttheme) || $ttheme == 'pweb')) {
                $compile = IA_ROOT . "/data/tpl/{$name}/plugin/" . $_W['plugin'] . "/template/web/{$theme}/{$filename_old}.tpl.php";
				$explode = explode('/', $filename_old);
                if($isempty_filename){
                    $temp = array_slice($explode, 1);
                }else{
                    $temp = $explode;
                }
                
                $source = M_PLUGIN . $_W['plugin'] . "/template/web/{$theme}/" . implode('/', $temp) . '.html';

                if (!is_file($source)) {
				    $source = M_PLUGIN . $_W['plugin'] . "/template/web/{$theme}/" . implode('/', $temp) . '/index.html';
                }
                if (!is_file($source)) {
				    $source = M_PLUGIN . $_W['plugin'] . "/template/web/{$theme}/" . implode('/', $temp) . 'index.html';
                }
                
                if (!is_file($source)) {
				    $source = M_PLUGIN . $_W['plugin'] . '/template/web/default/' . implode('/', $temp) . '.html';
                }
                if (!is_file($source)) {
				    $source = M_PLUGIN . $_W['plugin'] . '/template/web/default/' . implode('/', $temp) . '/index.html';
                }
                if (!is_file($source)) {
				    $source = M_PLUGIN . $_W['plugin'] . '/template/web/default/' . implode('/', $temp) . 'index.html';
                }
			}
            
			if(!is_file($source)) {
				$source = $defineDir . "/template/web/{$filename}.html";
			}
            if(!is_file($source)) {
				$source = $defineDir . "/template/web/{$filename}/index.html";
			}
            if(!is_file($source)) {
				$source = $defineDir . "/template/web/default/{$filename_old}.html";
			}
            if(!is_file($source)) {
				$source = $defineDir . "/template/web/default/{$filename_old}/index.html";
			}
            
        }else{//webapp和mobile的模板保持一致
            $theme = $_B['setting']['global']['mobilethemes'];
            if(empty($theme)){
                $theme = 'default';
            }
            $filename_old = $filename;
            $filename = $theme.'/'.$filename;
            $source = IA_ROOT . "/addons/{$name}/template/mobile/{$filename}.html";
            $compile = IA_ROOT . "/data/tpl/{$name}/template/mobile/{$filename}.tpl.php";
			
            if ($_W['isplugin']){
                $compile = IA_ROOT . "/data/tpl/{$name}/plugin/" . $_W['plugin'] . "/template/mobile/{$theme}/{$filename_old}.tpl.php";
				$explode = explode('/', $filename_old);
                if($isempty_filename){
                    $temp = array_slice($explode, 1);
                }else{
                    $temp = $explode;
                }
                
                $source = M_PLUGIN . $_W['plugin'] . "/template/mobile/{$theme}/" . implode('/', $temp) . '.html';

                if (!is_file($source)){
				    $source = M_PLUGIN . $_W['plugin'] . "/template/mobile/{$theme}/" . implode('/', $temp) . '/index.html';
                }
                if (!is_file($source)){
				    $source = M_PLUGIN . $_W['plugin'] . "/template/mobile/{$theme}/" . implode('/', $temp) . 'index.html';
                }
                
                if (!is_file($source)){
				    $source = M_PLUGIN . $_W['plugin'] . '/template/mobile/default/' . implode('/', $temp) . '.html';
                }
                if (!is_file($source)){
				    $source = M_PLUGIN . $_W['plugin'] . '/template/mobile/default/' . implode('/', $temp) . '/index.html';
                }
                if (!is_file($source)){
				    $source = M_PLUGIN . $_W['plugin'] . '/template/mobile/default/' . implode('/', $temp) . 'index.html';
                }
			}
            
            if(!is_file($source)){
				$source = $defineDir . "/template/mobile/{$filename}.html";
			}
            if(!is_file($source)){
				$source = $defineDir . "/template/mobile/{$filename}/index.html";
			}
            if(!is_file($source)){
				$source = $defineDir . "/template/mobile/default/{$filename_old}.html";
			}
            if(!is_file($source)){
				$source = $defineDir . "/template/mobile/default/{$filename_old}/index.html";
			}
		}
        if(!is_file($source)){
            if(BOWEN_DEBUG){
                exit("Error: template source '{$source}' is not exist!");
            }
            if($filename == $theme."/class/article"){
                exit("当前列表页未设置模板，请先设置模板或直接跳转到其他页面");
            }
            if($filename == $theme."/article/pages"){
                exit("当前列表页未设置模板，请先设置模板或直接跳转到其他页面");
            }
            exit("Error: template source '{$filename}' is not exist!");
		}
		$paths = pathinfo($compile);
		$compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . $paths['filename'], $compile);
		if (DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
			bowen_template_compile($source, $compile, true);
		}
		return $compile;
	}
}

if (!(function_exists('bowen_template_compile'))){
    function bowen_template_compile($from, $to, $inmodule = false)
    {
        if (!(function_exists('file_write'))){
            load()->func('file');
        }
		$path = dirname($to);
    	if (!is_dir($path)) {
    		load()->func('file');
    		mkdirs($path);
    	}
        
    	$content = bowen_template_parse(file_get_contents($from), $inmodule);
    	if(IMS_FAMILY == 'x' && !preg_match('/(footer|header|account\/welcome|login|register|home\/welcome)+/', $from)) {
    		$content = str_replace('微擎', '系统', $content);
    	}
        $to = str_replace_once(IA_ROOT, '', $to);
    	file_write(FILE_WRITE_IA_ROOT.$to, $content);
	}
}

if (!(function_exists('bowen_template_parse'))){
    function bowen_template_parse($str, $inmodule = false) {
    	$str = preg_replace('/{mytemplate\\s+(.+?)}/', '<?php (!empty($this) && $this instanceof WeModuleSite || '.intval($inmodule).') ? (include $this->mytemplate($1)) : (include mytemplate($1));?>', $str);
    	$str = preg_replace('/{mytemplate\\s+(\\S+)\\s+(\\S+)}/', '<?php (!empty($this) && $this instanceof WeModuleSite || '.intval($inmodule).') ? (include $this->mytemplate($1, $2)) : (include mytemplate($1, $2));?>', $str);
        $str = preg_replace('/{foregUrl\\s+(\\S+)}/', '<?php echo foregUrl($1);?>', $str);
		$str = preg_replace('/{foregUrl\\s+(\\S+)\\s+(array\\(.+?\\))}/', '<?php echo foregUrl($1, $2);?>', $str);
        $str = preg_replace('/{foregUrl\\s+(\\S+)\\s+(array\\(.+?\\))foregUrl\\s+(\\S+)}/', '<?php echo foregUrl($1, $2, $3);?>', $str);
        $str = preg_replace('/{mcommon\\s+(.+?)}/', '<?php include_once bowen_mcommon($1); ?>', $str);
        $str = template_parse($str, $inmodule);
    	return $str;
    }
}

/** 渲染公共目录下模板 */
function bowen_mcommon($filename, $type = 'mobile'){
    $source = M_ROOT."/template/{$type}/common/".$filename.".html";
    if(file_exists($source)){
        $name = strtolower(MODULE_NAME);
        $compile = IA_ROOT . "/data/tpl/{$name}/template/{$type}/common/{$filename}.tpl.php";
        $paths = pathinfo($compile);
		$compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . $paths['filename'], $compile);
        
        if (DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
			bowen_template_compile($source, $compile, true);
		}
		return $compile;
    }else{
        return $source = M_ROOT."/template/{$type}/common/404.html";;
    };
}

if (!(function_exists('pagination_foreg'))){    
    /**
     * 生成分页导航
     * 
     * $param['html']['s']开始的标签
     * $param['html']['e']结束的标签
     * $param['html']['ac']选中时的a标签class
     * 
     * 如果$param['li'] = 'null'，则没有li标签
     * $param['li']['s'] 包围a标签的开始
     * $param['li']['e'] 包围a标签的结束
     * $param['li']['ac']选中时的li标签class
     * 
     * 如果$param['html']['fpnl']['fl'] = 'null'，则没有首页、尾页按钮
     * $param['html']['fpnl']['f'] 首页按钮的参数
     * $param['html']['fpnl']['l'] 尾页按钮的参数
     * $param['html']['fpnl']['p'] 上页按钮的参数
     * $param['html']['fpnl']['n'] 下页按钮的参数
     * 
     * $param['always_show'] = 1 则一直显示上一页、下一页按钮
     * $param['nopages'] 没有分页时的html
     */
    function pagination_foreg($total, $pageIndex, $pageSize = 15, $context = array('before' => 5, 'after' => 4), $param = array())
    {
        global $_W;
        $settings = m('common')->getModuleSetting($_W['uniacid']);
        
    	$pdata = array(
    		'tcount' => 0,
    		'tpage' => 0,
    		'cindex' => 0,
    		'findex' => 0,
    		'pindex' => 0,
    		'nindex' => 0,
    		'lindex' => 0,
    		'options' => ''
    	);
    	
    	$pdata['tcount'] = $total;//数据总数
    	$pdata['tpage'] = (empty($pageSize) || $pageSize < 0) ? 1 : ceil($total / $pageSize);//每页多少数据
    	if ($pdata['tpage'] <= 1) {
            if($param['nopages']){
                return $param['nopages'];
            }
    		return '';
    	}
    	$cindex = $pageIndex;
    	$cindex = min($cindex, $pdata['tpage']);
    	$cindex = max($cindex, 1);
    	$pdata['cindex'] = $cindex;//当前页数
    	$pdata['findex'] = 1;
    	$pdata['pindex'] = $cindex > 1 ? $cindex - 1 : 1;
    	$pdata['nindex'] = $cindex < $pdata['tpage'] ? $cindex + 1 : $pdata['tpage'];
    	$pdata['lindex'] = $pdata['tpage'];
        
        $_GET['page'] = $pdata['findex'];
        $pdata['faa'] = 'href="?' . http_build_query($_GET) . '"';
        if(!empty($settings['global']['isrewrite']) && $_W['core_settings']['is_rewrite'] == 1){/** 开启伪静态 **/
            $info = array('page'=>$pdata['findex']);
            if(!empty($_GET['kw'])){
                $kw = safe_gpc_string(trim($_GET['kw']));
                $info = array_merge($info, array('kw' => $kw));
            }
            if(!empty($_GET['tag'])){
                $tag = safe_gpc_string(trim($_GET['tag']));
                $info = array_merge($info, array('tag' => $tag));
            }
            $pdata['faa'] = 'href="?' . http_build_query($info) . '"';
        }
        
        $_GET['page'] = $pdata['pindex'];
        $pdata['paa'] = 'href="?' . http_build_query($_GET) . '"';
        if(!empty($settings['global']['isrewrite']) && $_W['core_settings']['is_rewrite'] == 1){/** 开启伪静态 **/
            $info = array('page'=>$pdata['pindex']);
            if(!empty($_GET['kw'])){
                $kw = safe_gpc_string(trim($_GET['kw']));
                $info = array_merge($info, array('kw' => $kw));
            }
            if(!empty($_GET['tag'])){
                $tag = safe_gpc_string(trim($_GET['tag']));
                $info = array_merge($info, array('tag' => $tag));
            }
            $pdata['paa'] = 'href="?' . http_build_query($info) . '"';
        }
        
        $_GET['page'] = $pdata['nindex'];
        $pdata['naa'] = 'href="?' . http_build_query($_GET) . '"';
        if(!empty($settings['global']['isrewrite']) && $_W['core_settings']['is_rewrite'] == 1){/** 开启伪静态 **/
            $info = array('page'=>$pdata['nindex']);
            if(!empty($_GET['kw'])){
                $kw = safe_gpc_string(trim($_GET['kw']));
                $info = array_merge($info, array('kw' => $kw));
            }
            if(!empty($_GET['tag'])){
                $tag = safe_gpc_string(trim($_GET['tag']));
                $info = array_merge($info, array('tag' => $tag));
            }
            $pdata['naa'] = 'href="?' . http_build_query($info) . '"';
        }
        
        $_GET['page'] = $pdata['lindex'];
        $pdata['laa'] = 'href="?' . http_build_query($_GET) . '"';
        if(!empty($settings['global']['isrewrite']) && $_W['core_settings']['is_rewrite'] == 1){/** 开启伪静态 **/
            $info = array('page'=>$pdata['lindex']);
            if(!empty($_GET['kw'])){
                $kw = safe_gpc_string(trim($_GET['kw']));
                $info = array_merge($info, array('kw' => $kw));
            }
            if(!empty($_GET['tag'])){
                $tag = safe_gpc_string(trim($_GET['tag']));
                $info = array_merge($info, array('tag' => $tag));
            }
            $pdata['laa'] = 'href="?' . http_build_query($info) . '"';
        }
   		
    	$html = !empty($param['html']['s'])?$param['html']['s']:'<div class="m-page"><ul class="pagelist pagination">';
    	if ($pdata['cindex'] > 1 || $param['always_show'] == 1) {
            if($param['li'] == 'null'){
                if($param['html']['fpnl']['fl'] != 'null'){
                    $html .= "<a {$pdata['faa']} {$param['html']['fpnl']['f']} >首页</a>";
                    $html .= "<a {$pdata['paa']} {$param['html']['fpnl']['p']} >&laquo;上一页</a>";
                }else{
                    $html .= "<a {$pdata['paa']} {$param['html']['fpnl']['p']} >&laquo;上一页</a>";
                }
            }else{
                if($param['html']['fpnl']['fl'] != 'null'){
                    $html .= "<li><a {$pdata['faa']} {$param['html']['fpnl']['f']} >首页</a></li>";
                    $html .= "<li><a {$pdata['paa']} {$param['html']['fpnl']['p']} >&laquo;上一页</a></li>";
                }else{
                    $html .= "<li><a {$pdata['paa']} {$param['html']['fpnl']['p']} >&laquo;上一页</a></li>";
                }
            }
    	}
   		if (!$context['before'] && $context['before'] != 0) {
    		$context['before'] = 5;
    	}
    	if (!$context['after'] && $context['after'] != 0) {
    		$context['after'] = 4;
    	}
    
    	if ($context['after'] != 0 && $context['before'] != 0) {
    		$range = array();
    		$range['start'] = max(1, $pdata['cindex'] - $context['before']);
    		$range['end'] = min($pdata['tpage'], $pdata['cindex'] + $context['after']);
    		if ($range['end'] - $range['start'] < $context['before'] + $context['after']) {
    			$range['end'] = min($pdata['tpage'], $range['start'] + $context['before'] + $context['after']);
    			$range['start'] = max(1, $range['end'] - $context['before'] - $context['after']);
    		}
    		for ($i = $range['start']; $i <= $range['end']; $i++) {
    			$_GET['page'] = $i;
				$aa = 'href="?' . http_build_query($_GET) . '"';
                if(!empty($settings['global']['isrewrite']) && $_W['core_settings']['is_rewrite'] == 1){/** 开启伪静态 **/
                    $info = array('page'=>$i);
                    if(!empty($_GET['kw'])){
                        $kw = safe_gpc_string(trim($_GET['kw']));
                        $info = array_merge($info, array('kw' => $kw));
                    }
                    if(!empty($_GET['tag'])){
                        $tag = safe_gpc_string(trim($_GET['tag']));
                        $info = array_merge($info, array('tag' => $tag));
                    }
                    $aa = 'href="?' . http_build_query($info) . '"';
                }
                if($param['html']['ac']){
                    if($param['li'] == 'null'){
                        $html .= ($i == $pdata['cindex'] ? "<a class=\"{$param['html']['ac']}\">" . $i . '</a>' : "<a {$aa}>" . $i . '</a>');
                    }else{
                        $html .= ($i == $pdata['cindex'] ? "<li><a class=\"{$param['html']['ac']}\">" . $i . '</a></li>' : "<li><a {$aa}>" . $i . '</a></li>');
                    }
                }else{
                    $param['li']['ac'] = !empty($param['li']['ac'])?$param['li']['ac']:'thisclass';
                    $html .= ($i == $pdata['cindex'] ? "<li class=\"{$param['li']['ac']}\"><a>" . $i . '</a></li>' : "<li><a {$aa}>" . $i . '</a></li>');
                }
    		}
    	}
    
    	if ($pdata['cindex'] < $pdata['tpage'] || $param['always_show'] == 1) {
            if($param['li'] == 'null'){
                if($param['html']['fpnl']['fl'] != 'null'){
                    $html .= "<a {$pdata['naa']} {$param['html']['fpnl']['n']} >下一页&raquo;</a>";
            		$html .= "<a {$pdata['laa']} {$param['html']['fpnl']['l']} >尾页</a>";
                }else{
                    $html .= "<a {$pdata['naa']} {$param['html']['fpnl']['n']} >下一页&raquo;</a>";
                }
            }else{
                if($param['html']['fpnl']['fl'] != 'null'){
            		$html .= "<li><a {$pdata['naa']} {$param['html']['fpnl']['n']} >下一页&raquo;</a></li>";
            		$html .= "<li><a {$pdata['laa']} {$param['html']['fpnl']['l']} >尾页</a></li>";
                }else{
                    $html .= "<li><a {$pdata['naa']} {$param['html']['fpnl']['n']} >下一页&raquo;</a></li>";
                }
            }
    	}
    	$html .= !empty($param['html']['e'])?$param['html']['e']:'</ul></div>';
    	return $html;
    }
}

    /**
     * 通用数据批量获取
     * $table 表名
     * $params 参数指定查询的条件。以 AND 连接，支持大于，小于等范围查询
     * $orderby 排序，可传入数组array('displayorder','id asc'),也可以直接以,分隔
     * $limit 参数指定查询语句的LIMIT值，array(start, end) 或是直接传入范围 2,3
     */
   function getAll($table, $params = array(), $orderby =  array(), $limit = array())
    {
        $orderbysql = myparseOrderby($orderby);//修复底层坏掉的问题
        $limitsql = SqlPaser::parseLimit($limit);
        
        if(!empty($params)){
            if(!is_array($params)){
                $params = ltrim($params," AND");
                $params = ltrim($params,"AND");
            }
        }
        $condition = SqlPaser::parseParameter($params, 'AND');
        $sql = "SELECT * FROM ".tablename($table) . (!empty($condition['fields']) ? " WHERE {$condition['fields']}" : '') . $orderbysql . $limitsql;
        $result = pdo_fetchall($sql, $condition['params']);
        return $result;
    }
    
    /**
     * 通用数据总数获取，返回数字
     * $table 表名
     * $params 参数指定查询的条件。以 AND 连接，支持大于，小于等范围查询
     */
    function countAll($table, $params = array())
    {
        if(!empty($params)){
            if(!is_array($params)){
                $params = ltrim($params," AND");
                $params = ltrim($params,"AND");
            }
        }
        $condition = SqlPaser::parseParameter($params, 'AND');
        
        $sql = "SELECT COUNT(*) FROM ".tablename($table) . (!empty($condition['fields']) ? " WHERE {$condition['fields']}" : '');
        $result = pdo_fetchcolumn($sql, $condition['params']);
        
        return $result;
    }

if( !function_exists('myparseOrderby')) {
    function myparseOrderby($orderby = array())
    {/** 修补系统底层函数parseOrderby */
		$orderbysql = '';
		if (empty($orderby)) {
			return $orderbysql;
		}
	
		if (!is_array($orderby)) {
			$orderby = explode(',', $orderby);
		}
		foreach ($orderby as $i => &$row) {
			$row = strtolower($row);
			list($field, $orderbyrule) = explode(' ', $row);
			if ($orderbyrule != 'asc' && $orderbyrule != 'desc' && $orderbyrule) {
				unset($orderby[$i]);
			}
            if($orderbyrule){
                $orderbyrule = " {$orderbyrule}";
            }
			$row = "{$field}{$orderbyrule}";
		}
		$orderbysql = implode(',', $orderby);
		return !empty($orderbysql) ? " ORDER BY $orderbysql " : '';
	}
}

/**
 * Get the boolean value of a variable
 *
 * @param 	mixed 	The scalar value being converted to a boolean.
 * @return 	boolean The boolean value of var.
 * @refer	http://php.net/manual/en/function.boolval.php#114013
 */
if( !function_exists('boolval')) {
  function boolval($var){
    return !! $var;
  }
}
    
if (!(function_exists('url_set_value'))) {
    function url_set_value($_url, $key, $value)
    {
        $_url = explode('?',$_url);
        $query = $_url[1];
        parse_str($query, $arr);
        $arr[$key] = $value;
        return $_url[0].'?'.http_build_query($arr);
    }
}

if (!(function_exists('strip_selected_tags'))) {
    function strip_selected_tags($text, $tags = array()) {
        $args = func_get_args();
        $text = array_shift($args);
        $tags = func_num_args() > 2 ? array_diff($args, array($text)) : (array) $tags;
        foreach($tags as $tag) {
            if (preg_match_all('/<'.$tag.'[^>]*>([^<]*)</'.$tag.'>/iu', $text, $found)) {
                $text = str_replace($found[0], $found[1], $text);
            }
        }
     
        return preg_replace('/(<('.join('|', $tags).')( | |.)*/>)/iu', '', $text);
    }
}

if (!(function_exists('replaceRN'))) {
    function replaceRN($content, $type = 'p'){
        return m('ui')->replaceRN($content, $type);
    }
}

if (!(function_exists('deleteRN'))) {
    function deleteRN($content, $is_en = false)
    {
        return m('ui')->deleteRN($content, $is_en);
    }
}

/** 
 * 对多维数组进行排序，参数顺序为：多维数组,循环【指定键名，排序方式(SORT_ASC,SORT_DESC)】
 * 使用示例：$arr = sortArrByManyField($array1,'id',SORT_ASC,'name',SORT_ASC,'age',SORT_DESC);
 */
if (!(function_exists('sortArrByManyField'))) {
    function sortArrByManyField()
    {
        $args = func_get_args();
        if(empty($args)){
            return null;
        }
        $arr = array_shift($args);
        if(!is_array($arr)){
            throw new Exception("第一个参数不为数组");
        }
        foreach($args as $key => $field){
            if(is_string($field)){
                $temp = array();
                foreach($arr as $index=> $val){
                    $temp[$index] = $val[$field];
                }
                $args[$key] = $temp;
            }
        }
        $args[] = &$arr;/** 引用值 **/
        call_user_func_array('array_multisort',$args);
        return array_pop($args);
    }
}

if (!(function_exists('myweek'))) {
    function myweek($date = '', $type = 'cn')
    {
        $date = !empty($date)?$date:TIMESTAMP;
        $w = date("w", $date);
        switch($w){
            case 0 :
                $week = "周日";
                break;
            case 1 :
                $week = "周一";
                break;
            case 2 :
                $week = "周二";
                break;
            case 3 :
                $week = "周三";
                break;
            case 4 :
                $week = "周四";
                break;
            case 5 :
                $week = "周五";
                break;
            case 6 :
                $week = "周六";
                break;
            default :
                $week = "错误"; 
        };
        if($type == 'en'){
            switch($w){
                case 0 :
                    $week = "Sun";
                    break;
                case 1 :
                    $week = "Mon";
                    break;
                case 2 :
                    $week = "Tues";
                    break;
                case 3 :
                    $week = "Wed";
                    break;
                case 4 :
                    $week = "Thur";
                    break;
                case 5 :
                    $week = "Fri";
                    break;
                case 6 :
                    $week = "Sat";
                    break;
                default :
                    $week = "error"; 
            };
        }
        return $week;
    }
}

if (!(function_exists('month_en'))) {
    function month_en($m)
    {
            switch($m){
                case 1 :
                    $month = "Jan";
                    break;
                case 2 :
                    $month = "Feb";
                    break;
                case 3 :
                    $month = "Mar";
                    break;
                case 4 :
                    $month = "Apr";
                    break;
                case 5 :
                    $month = "May";
                    break;
                case 6 :
                    $month = "June";
                    break;
                case 7 :
                    $month = "July";
                    break;
                case 8 :
                    $month = "July";
                    break;
                case 9 :
                    $month = "July";
                    break;
                case 10 :
                    $month = "July";
                    break;
                case 11 :
                    $month = "July";
                    break;
                case 12 :
                    $month = "July";
                    break;
                default :
                    $month = "error"; 
            };
        
        return $month;
    }
}

if (!(function_exists('foregUrl'))) {
	function foregUrl($do = '', $query = NULL, $full = false) 
	{
		global $_W,$_GPC,$_B;
        
        if(empty($_B['setting'])){
            $settings = m('common')->getModuleSetting($_W['uniacid']);
        }else{
            $settings = $_B['setting'];
        }
        /** 多判断一次是否在后台生成的，冗余下是为了后期的兼容 **/
        $siteroot = ($_B['action_type'] == 'web')?(!empty($_B['siteroot'])?$_B['siteroot']:$_W['siteroot']):$_W['siteroot'];
        
        if(!is_array($query)){
            $query = !empty($query)?(array)$query:array();
        }
        
        /** 开启伪静态 **/
        if(!empty($settings['global']['isrewrite']) && $_W['core_settings']['is_rewrite'] == 1){
            if(empty($do)){
                $url = $siteroot . $_W['uniacid']. '/index.html';
                $url .= m('common')->ToUrlParams($query, array('id'), '?');
                return $url;
            }elseif($do == 'class'){
                $url = $siteroot . $_W['uniacid']. '/class_' . $query['id'] . '.html';
                $url .= m('common')->ToUrlParams($query, array('id'), '?');
                return $url;
            }elseif($do == 'article'){
                $url = $siteroot . $_W['uniacid']. '/article_' . $query['id'] . '.html';
                $url .= m('common')->ToUrlParams($query, array('id'), '?');
                return $url;
            }
        }
        /** 不开启伪静态 **/
		!($query) && ($query = array());
		$dos = explode('/', trim($do));
		$routes = array();
		$routes[] = $dos[0];
		if (isset($dos[1])) 
		{
			$routes[] = $dos[1];
		}
		if (isset($dos[2])) 
		{
			$routes[] = $dos[2];
		}
		if (isset($dos[3])) 
		{
			$routes[] = $dos[3];
		}
		$r = implode('.', $routes);
		if (!(empty($r))) 
		{
			$query = array_merge(array('r' => $r), $query);
		}
		$query = array_merge(array('do' => 'foreg'), $query);
		$query = array_merge(array('m' => 'bowen_site'), $query);
		if ($full) 
		{
			return $siteroot . 'app/' . substr(murl('entry', $query, true), 2);
		}
		return murl('entry', $query, true);
	}
}

if (!(function_exists('webUrl'))) {
	function webUrl($do = '', $query = array(), $full = true) 
	{
       global $_W,$_GPC,$_B;
        
        if(empty($_B['setting'])){
            $settings = m('common')->getModuleSetting($_W['uniacid']);
        }else{
            $settings = $_B['setting'];
        }
        
        if(!is_array($query)){
            $query = !empty($query)?(array)$query:array();
        }
        
        /** 开启伪静态 **/
        if($_W['core_settings']['is_rewrite'] == 1){
            $siteroot = !empty($_B['siteroot'])?$_B['siteroot']:$_W['siteroot'];
            if($do == 'pcsite/user/login'){
                $url = 'web/login.html';
                /**  废弃
                if(!empty($query['i'])){
                    $url = $siteroot . 'web/login_' . $query['i'] . '.html';
                }*/
                $url .= m('common')->ToUrlParams($query, '', '?');
            }
            if($do == 'pcsite/user/register'){
                $url = 'web/register.html';
                $url .= m('common')->ToUrlParams($query, '', '?');
            }
            if(!empty($url)){
                if($full == true){
                    $url = $siteroot . $url;
                }else{
                    $url = '../' . $url;
                }
                return $url;
            }
        }
        /** 不开启伪静态 **/
		$dos = explode('/', trim($do));
		$routes = array();
		$routes[] = $dos[0];
		if (isset($dos[1])) 
		{
			$routes[] = $dos[1];
		}
		if (isset($dos[2])) 
		{
			$routes[] = $dos[2];
		}
		if (isset($dos[3])) 
		{
			$routes[] = $dos[3];
		}
		$r = implode('.', $routes);
		if (!(empty($r))) 
		{
			$query = array_merge(array('r' => $r), $query);
		}
		$query = array_merge(array('do' => 'web'), $query);
		$query = array_merge(array('m' => 'bowen_site'), $query);
        if($_GPC['s'])$query = array_merge(array('s' => trim($_GPC['s'])), $query);
		if ($full == true)
		{
			return $_W['siteroot'] . 'web/' . substr(wurl('site/entry', $query), 2);
		}
		return wurl('site/entry', $query);
	}
}


if(!function_exists('mytpl_form_field_link')){
    function mytpl_form_field_link($name, $value = '', $options = array(), $options2 = array(), $layui = false)
    {
        global $_GPC;
    	if(!empty($options)) {
            $style = '';
    		foreach ($options as $key => $val){
    			$style .= $key.':'.$val.';';
    		}
    	}
        if(!empty($options2)) {
            $style2 = '';
    		foreach ($options2 as $key2 => $val2){
    			$style2 .= $key2.':'.$val2.';';
    		}
    	}
    	$s = '';
        if($layui){
            $s .= '
        	<div style="'.($style2 ? $style2 : '').'">
                <input type="text" name="'.$name.'" value="'.$value.'" autocomplete="off" class="layui-input layui-input-group" style="'.($style ? $style : '').'">
                <span>
                    <button class="layui-btn layui-btn-primary selector" data-type="link" type="button">选择链接</button>
               	</span>
       		</div>
        	';
        }else{
            $s .= '
        	<div class="input-group " style="'.($style2 ? $style2 : '').'">
                <input type="text" name="'.$name.'" value="'.$value.'" class="form-control" autocomplete="off"  style="'.($style ? $style : '').'" />
      			<span class="input-group-btn">
                    <button class="btn btn-default selector" type="button" data-type="link">选择链接</button>
      			</span>
       		</div>
        	';
        }
    	
    	return $s;
    }
}

if(!function_exists('mytpl_form_field_vicefounder')){
    function mytpl_form_field_vicefounder($name, $value = '', $options = array(), $options2 = array(), $layui = false)
    {
        global $_GPC;
    	if(!empty($options)) {
            $style = '';
    		foreach ($options as $key => $val){
    			$style .= $key.':'.$val.';';
    		}
    	}
        if(!empty($options2)) {
            $style2 = '';
    		foreach ($options2 as $key2 => $val2){
    			$style2 .= $key2.':'.$val2.';';
    		}
    	}
    	$s = '';
        if($layui){
            $s .= '
        	<div style="'.($style2 ? $style2 : '').'">
                <input type="text" name="'.$name.'" value="'.$value.'" autocomplete="off" class="layui-input layui-input-group" style="'.($style ? $style : '').'">
                <span>
                    <button class="layui-btn layui-btn-primary selector" data-type="vicefounder" type="button">选择副创始人</button>
               	</span>
       		</div>
        	';
        }else{
            $s .= '
        	<div class="input-group " style="'.($style2 ? $style2 : '').'">
                <input type="text" name="'.$name.'" value="'.$value.'" class="form-control" autocomplete="off"  style="'.($style ? $style : '').'" />
      			<span class="input-group-btn">
                    <button class="btn btn-default selector" type="button" data-type="vicefounder">选择副创始人</button>
      			</span>
       		</div>
        	';
        }
    	
    	return $s;
    }
}

if(!function_exists('mytpl_ueditor')){
    function mytpl_ueditor($id, $value = '', $options = array()) {
    	$s = '';
        $s = "
            <script src=\"".M_LOCAL."template/web/default/static/js/myutil.js?v=".RELEASE."\"></script>";
    	$options['height'] = empty($options['height']) ? 200 : $options['height'];
    	$options['allow_upload_video'] = isset($options['allow_upload_video']) ? $options['allow_upload_video'] : true;
    	$s .= !empty($id) ? "<textarea id=\"{$id}\" name=\"{$id}\" type=\"text/plain\" style=\"height:{$options['height']}px;\">{$value}</textarea>" : '';
    	$s .= "
    	   <script type=\"text/javascript\">
    			bowen.editor('" . ($id ? $id : "") . "', {
        			height : {$options['height']}, 
        			dest_dir : '" .($options['dest_dir'] ? $options['dest_dir'] : "") . "',
        			image_limit : " . (intval($GLOBALS['_W']['setting']['upload']['image']['limit']) * 1024) . ",
        			allow_upload_video : " . ($options['allow_upload_video'] ? 'true' : 'false') . ",
        			audio_limit : " . (intval($GLOBALS['_W']['setting']['upload']['audio']['limit']) * 1024) . ",
        			callback : function(id, index){
                        bowen_editor_{$id} = index;
        			}
    			});
    	   </script>";
    	return $s;
    }
}

if(!function_exists('mytpl_citypicker')){
    function mytpl_citypicker($name, $value = array(), $level = 3, $verify = "") {
        if(is_array($verify)){
            $verify = implode("|",$verify);
        }
    	$html = '
    		<script type="text/javascript">
    			layui.use(["form", "citypicker"], function(){
                    var form = layui.form
                    , citypicker = layui.citypicker;';
        if(!empty($value) && is_array($value)){
            $html .= 'citypicker.render("'.$name.'", "'.json_encode($value).'");';
        }else{
            $html .= 'citypicker.render("'.$name.'");';
        }
                    
        $html .= '
                });
    		</script>';
        $html .= '
                <div class="layui-input-inline">
                    <select name="'.$name.'[province]" lay-filter="'.$name.'_province" lay-verify="'.$verify.'" lay-search></select>
                </div>
            ';
        if($level >= 2){
            $html .= '
                <div class="layui-input-inline">
                    <select name="'.$name.'[city]" lay-filter="'.$name.'_city" lay-verify="'.$verify.'" lay-search></select>
                </div>
            ';
        }
        if($level == 3){
            $html .= '
                <div class="layui-input-inline">
                    <select name="'.$name.'[area]" lay-filter="'.$name.'_area" lay-verify="'.$verify.'" lay-search></select>
                </div>
            ';
        }
        
    	return $html;
    }
}

if(!function_exists('oauthPost')){
    function oauthPost($url, $postdata = '')
    {
        load()->func('communication');
        $result = ihttp_post($url, $postdata);    
        if($result['code'] == '200'){
            return $result['content'];
        }
        return false;
    }
}
        
if(!function_exists('oUrl')){
    function oUrl($op = '', $module = '', $data = array())
    {//post数据接口
        !empty($op)?$data['op'] = trim($op):$data['op'] = 'check';
        !empty($module)?($module = trim($module)):($module = MODULE_NAME);
        $data['module'] = $module;
        $oauth_url = BOWEN_SITE_AUTH_URL;
        $info = '?';
        foreach($data as $key=>$value){
            $info .= $key.'='.$value.'&';
        }
        return ($oauth_url.$info);
    }
}

if (!(function_exists('getIsSecureConnection'))){
    function getIsSecureConnection()
    {
    	if (isset($_SERVER['HTTPS']) && (('1' == $_SERVER['HTTPS']) || ('on' == strtolower($_SERVER['HTTPS'])))) {
    		return true;
    	}
    	if (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
    		return true;
    	}
    	return false;
    }
}

if(!function_exists('emoji_unicode_decode')){
    function emoji_unicode_decode($string) {
    	preg_match_all('/\[U\+(\\w{4,})\]/i', $string, $match);
    	if(!empty($match[1])) {
    		foreach ($match[1] as $emojiUSB) {
    			$string = str_ireplace("[U+{$emojiUSB}]", utf8_bytes(hexdec($emojiUSB)), $string);
    		}
    	}
    	return $string;
    }
}

if(!function_exists('emoji_unicode_encode')){
    function emoji_unicode_encode($string) {
    	$ranges = array(
    		'\\\\ud83c[\\\\udf00-\\\\udfff]', 		'\\\\ud83d[\\\\udc00-\\\\ude4f]', 		'\\\\ud83d[\\\\ude80-\\\\udeff]'  	);
    	preg_match_all('/' . implode('|', $ranges) . '/i', $string, $match);
    	print_r($match);exit;
    }
}

if (!function_exists('redis')) {
	function redis(){
		global $_W;
		static $redis;

		if (is_null($redis)) {
			if (!extension_loaded('redis')) {
				return error(-1, 'PHP 未安装 redis 扩展');
			}

			if (!isset($_W['config']['setting']['redis'])) {
				return error(-1, '未配置 redis, 请检查 data/config.php 中参数设置');
			}

			$config = $_W['config']['setting']['redis'];

			if (empty($config['server'])) {
				$config['server'] = '127.0.0.1';
			}

			if (empty($config['port'])) {
				$config['port'] = '6379';
			}

			$redis_temp = new Redis();

			if ($config['pconnect']) {
				$connect = $redis_temp->pconnect($config['server'], $config['port'], $config['timeout']);
			}
			else {
				$connect = $redis_temp->connect($config['server'], $config['port'], $config['timeout']);
			}

			if (!$connect) {
				return error(-1, 'redis 连接失败, 请检查 data/config.php 中参数设置');
			}
            
            $config['requirepass'] = !empty($config['requirepass'])?$config['requirepass']:$config['auth'];
			if (!empty($config['requirepass'])) {
				$redis_temp->auth($config['requirepass']);
			}

			try {
				$ping = $redis_temp->ping();
			}
			catch (ErrorException $e) {
				return error(-1, 'redis 无法正常工作，请检查 redis 服务');
			}

			if ($ping != '+PONG') {
				return error(-1, 'redis 无法正常工作，请检查 redis 服务');
			}

			$redis = $redis_temp;
		}
		else {
			try {
				$ping = $redis->ping();
			}
			catch (ErrorException $e) {
				$redis = NULL;
				$redis = redis();
				$ping = $redis->ping();
			}

			if ($ping != '+PONG') {
				$redis = NULL;
				$redis = redis();
			}
		}

		return $redis;
	}
}

if (!(function_exists('str_replace_once'))) {
    function str_replace_once($needle, $replace, $haystack) {
        $pos = strpos($haystack, $needle);
        if ($pos === false) {
            return $haystack;
        }
        return substr_replace($haystack, $replace, $pos, strlen($needle));
    }
}

if (!(function_exists('str_replace_limit'))) {
    function str_replace_limit($search, $replace, $subject, $limit = -1)
    {
        if (is_array($search)) {
            foreach ($search as $k => $v) {
                $search[$k] = '`' . preg_quote($search[$k], '`') . '`';
            }
        } else {
            $search = '`' . preg_quote($search, '`') . '`';
        }
        return preg_replace($search, $replace, $subject, $limit);
    }
}

if (!(function_exists('startsWith'))) {
    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}

if (!(function_exists('endsWith'))) {
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }
}

if (!(function_exists('result'))) {
    function result($errno = '0', $message = '', $data = array(), $params = array(), $type = 'exit'){
       global $_W;
        $result = array(
            'errno' => $errno,
            'code' => $errno,
            'message' => $message,
            'msg' => $message,
            'count' => count($data),
            'data' => $data
        );
        if(!empty($params) && is_array($params)){
            $result = array_merge($result,$params);
        }
        if(($_W['isajax'] && $type == 'exit') || $type == 'exit'){
            die(stripslashes(ijson_encode($result, JSON_UNESCAPED_UNICODE)));
        }else{
            $result = stripslashes(ijson_encode($result, JSON_UNESCAPED_UNICODE));
            return $result;
        }
    }
}

if (!(function_exists('result_r'))) 
{
    function result_r($errno = '0', $message = '', $data = array(), $params = array()){
        return result($errno, $message, $data, $params = array(), 'return');
    }
}

if (!(function_exists('bowen_site_welcome'))){
    /** 执行首页 */
    function bowen_site_welcome($system_login = true) {
       global $_W, $_B;
        if(!$_B['core_settings']){
            $_B['core_settings'] = m('common')->getModuleSetting(0, 'core', 'core_settings');
        }
        $domain_value = pdo_fetch("SELECT * FROM " . tablename('bowen_site_domain') . " WHERE domain LIKE :domain AND status = 1 ORDER BY displayorder DESC, createtime DESC LIMIT 1", array(':domain' => $_SERVER["HTTP_HOST"]));
        
        if($domain_value['type'] == '5'){
            showDefaultWelcome();
        }elseif($domain_value['tourl']){
            if (stripos($domain_value['tourl'],'http') !== false){
                header('location: ' . $domain_value['tourl']);
            }else{
                if(stripos($domain_value['tourl'],'do=foreg') !== false){
                    header('location: ' . $_W['siteroot'] . 'app/' . $domain_value['tourl']);
                }
                header('location: ' . $_W['siteroot'] . 'web/' . $domain_value['tourl']);
            }
        }elseif(!empty($domain_value['uniacid'])){
            if($_B['core_settings']['is_rewrite'] == 1){
                header('location: ' . $_W['siteroot'] . $domain_value['uniacid']. '/index.html');
            }else{
                header('location: ' . $_W['siteroot'] . "app/index.php?i=" . $domain_value['uniacid'] ."&c=entry&m=bowen_site&do=foreg");
            }
        }elseif(!empty($domain_value['compatible_site_welcome_module'])){
            $site = setOtherSysWelcome($domain_value['compatible_site_welcome_module']);
        }else{
            $others = pdo_fetch("SELECT * FROM " . tablename('bowen_site_domain') . " WHERE domain LIKE :domain AND status = 1 ORDER BY displayorder DESC, createtime DESC LIMIT 1", array(':domain' => 'others'));
            
            if($others['type'] == '5'){
                showDefaultWelcome();
            }elseif($others['tourl']){
                if (stripos($others['tourl'],'http') !== false){
                    header('location: ' . $others['tourl']);
                }else{
                    if(stripos($others['tourl'],'do=foreg') !== false){
                        header('location: ' . $_W['siteroot'] . 'app/' . $others['tourl']);
                    }
                    header('location: ' . $_W['siteroot'] . 'web/' . $others['tourl']);
                }
            }elseif(!empty($others['uniacid'])){
                if($_B['core_settings']['is_rewrite'] == 1){
                    header('location: ' . $_W['siteroot'] . $others['uniacid']. '/index.html');
                }else{
                    header('location: ' . $_W['siteroot'] . "app/index.php?i=" . $others['uniacid'] ."&c=entry&m=bowen_site&do=foreg");
                }
            }elseif(!empty($others['compatible_site_welcome_module'])){
                $site = setOtherSysWelcome($others['compatible_site_welcome_module']);
            }elseif(!empty($_B['core_settings']['compatible_site_welcome_module'])){
        		$site = setOtherSysWelcome($_B['core_settings']['compatible_site_welcome_module']);
        	}elseif($system_login){
                header('location: ' . $_W['siteroot'] . 'web/' . url('user/login'));
            }
        }
    }
}

/** 兼容其他的首页 */
function setOtherSysWelcome($moduleName) {
   global $_W;
    $_W['current_module'] = module_fetch($moduleName);
    $site = WeUtility::createModuleSystemWelcome($moduleName);
    if (!is_error($site)) {
        exit($site->systemWelcomeDisplay());
    }
    return $site;
}

/** 兼容显示系统默认首页 */
function showDefaultWelcome(){
   global $_W, $settings, $copyright, $notices, $news;
    $settings = $_W['setting'];
    $copyright = $settings['copyright'];
    $copyright['slides'] = iunserializer($copyright['slides']);
    
    load()->model('article');
    $notices = article_notice_home();
    $news = article_news_home();
    template('account/welcome');
}
