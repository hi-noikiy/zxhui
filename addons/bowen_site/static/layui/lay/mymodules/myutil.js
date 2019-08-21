/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/13 21:23:44] -->
 */
layui.define(function(exports){

    /**
     构造we7后台地址,
     @params s we7系统中的controller, action, do，格式为 'home/welcome/system'
     @params querystring 格式为 {参数名1 : 值1, 参数名2 : 值2}
     */
    var wurl = function(s, querystring){
        var controller = '', action = '', d = '';
        if(s != '' && s != undefined && s != null){
            var segment = s.split('/', 3);
            controller = segment[0];
            if(undefined != segment[1]){
                action = segment[1];
            }
            if(undefined != segment[2]){
                d = segment[2];
            }
        }

        var url = './index.php?';
        if (controller != '') {
            url += "c="+controller+"&";
        }
        if (action != '') {
            url += "a="+action+"&";
        }
        if (d != '') {
            url += "do="+d+"&";
        }
        if (querystring && typeof querystring === 'object') {
            url += http_build_query(querystring);
        }
        return url;
    }

    ,murl = function(segment, params, redirect){
        var controller = '', action = '', d = '';
        if(segment != '' && segment != undefined && segment != null){
            segment = segment.split('/', 3);
            controller = segment[0];
            if(undefined != segment[1]){
                action = segment[1];
            }
            if(undefined != segment[2]){
                d = segment[2];
            }
        }

        var url = './';
        var str = '';
        if(global.uni_is_multi_acid) {
            str += "&j="+global.acid;
        }
        if (global.account_type != '' && global.account_type == 5) {
            str += '&a=webapp';
        }
        if (global.account_type && global.account_type == 6) {
            str += '&a=phoneapp';
        }
        url += "index.php?i="+global.uniacid+str+"&";
        if (controller != '') {
            url += "c="+controller+"&";
        }
        if (action != '') {
            url += "a="+action+"&";
        }
        if (d != '') {
            url += "do="+d+"&";
        }
        if (params && typeof params === 'object') {
            params = http_build_query(params);
            url += params;
            if (redirect != false) {
                url += '&wxref=mp.weixin.qq.com#wechat_redirect';
            }
        }
        return url;
    }

    /**
     * param 将要转为URL参数字符串的对象
     * key URL参数字符串的前缀
     * encode true/false 是否进行URL编码,默认为true
     *
     * return URL参数字符串

     * var obj={name:'tom','class':{className:'class1'},classMates:[{name:'lily'}]};
     * console.log(http_build_query(obj));
     * output: &name=tom&class.className=class1&classMates[0].name=lily
     * console.log(http_build_query(obj,'stu'));
     * output: &stu.name=tom&stu.class.className=class1&stu.classMates[0].name=lily
     */
    ,http_build_query = function(param, key, encode){
        if(param==null) return '';
        var paramStr = '';
        var t = typeof (param);
        if (t == 'string' || t == 'number' || t == 'boolean') {
            paramStr += key + '=' + ((encode==null||encode) ? encodeURIComponent(param) : param) + '&';
        } else {
            for (var i in param) {
                var k = key == null ? i : key + (param instanceof Array ? '[' + i + ']' : '.' + i);
                paramStr += http_build_query(param[i], k, encode);
            }
        }
        return paramStr;
    };


    var myutil = {
        webUrl: function(d,q,f){
            if(!q)q = {};
            q['do'] = 'web';
            q['m'] = 'bowen_site';
            if(d){
                var routes = d.split('/', 4);
                var r = routes.join('.');
            }
            if(undefined != r){
                q['r'] = r;
            }
            var f = f?true:false;
            if(f){
                if(!sysinfo){var sysinfo = global}
                return sysinfo.siteroot + 'web/' + wurl('site/entry', q).substr(2);
            }
            return wurl('site/entry', q);
        }
        ,foregUrl: function(d,q,f){
            if(!q)q = {};
            q['do'] = 'foreg';
            q['m'] = 'bowen_site';
    		if(d){
                var routes = d.split('/', 4);
                var r = routes.join('.');
            }
            if(undefined != r){
                q['r'] = r;
            }
            var f = f?true:false;
    		if (f) 
    		{
                return global.siteroot + 'app/' + murl('entry', q, false).substr(2);
    		}
    		return murl('entry', q, false);
        }
        ,wurl: function(s, querystring){
            return wurl(s, querystring)
        }
        ,murl: function(segment, params, redirect){
            return murl(segment, params, redirect)
        }
    };
    

    
    exports('myutil', myutil);
}); 