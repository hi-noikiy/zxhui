/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 17:50:37] -->
 */
layui.define(['layer', 'myutil', 'element'], function(exports){
    var $ = layui.$
        ,layer = layui.layer
        ,myutil = layui.myutil
        ,element = layui.element;
        
    var this_selector = '';
    
    var s = {
        /** 渲染选择器 */
        render: function(){
            var action = {
                link: function(){
                    s.link(this);
                }
                ,vicefounder: function(){
                    s.vicefounder(this);
                }
                ,account: function(){
                    s.account(this);
                }
            };
            $('.selector').on('click', function() {
                var type = $(this).data('type');
                action[type] ? action[type].call(this) : '';
            });
        }
        /** 链接选择器 */
        ,link: function(o){
            var site_cover_url = window.global.siteroot+'app/index.php?i='+window.global.uniacid+'&c=entry&m=bowen_site&do=foreg';
            var site_login_url = window.global.siteroot+'web/index.php?c=site&a=entry&m=bowen_site&do=web&r=pcsite.user.login';
            var site_register_url = window.global.siteroot+'web/index.php?c=site&a=entry&m=bowen_site&do=web&r=pcsite.user.register';
            if(window.global.isrewrite == '1'){
                site_cover_url = window.global.siteroot+window.global.uniacid+'/index.html';
                site_login_url = window.global.siteroot+'web/login.html';
                site_register_url = window.global.siteroot+'web/register.html';
            }
            this_selector = layer.open({
                type: 1
                ,title: '链接选择器'
                ,id: 'LinkSelector'
                ,area: ['850px']
                ,shadeClose: true
                ,content: ''+
                        '<style>'+
                            '#LinkSelector .layui-input-group {width:-webkit-calc(100% - 94px); width:-moz-calc(100% - 94px); width:calc(100% - 94px); display: inline-block;}'+
                            '#LinkSelector .input-group {width:100%;}'+
                    		'#LinkSelector .layui-tab-item {min-height: 300px; max-height: 300px; overflow-y: auto;}'+
                    		'#LinkSelector .page-head {margin: 10px 0 3px 0;}'+
                    		'#LinkSelector .page-head h4 {margin: 0;}'+
                    		'#LinkSelector .layui-btn {margin-bottom: 3px;}'+
                            '#LinkSelector .layui-btn.choseClick{margin: 3px 5px;}'+
                    		'#LinkSelector .line {border-bottom: 1px dashed #ddd; color: #999; height: 36px; line-height: 36px;}'+
                    		'#LinkSelector .line .icon {height: 35px; width: 30px; position: relative; float: left;}'+
                    		'#LinkSelector .line .icon.icon-1:before {content: ""; width: 10px; height: 10px; border: 1px dashed #ccc; position: absolute; top: 12px; left: 10px;}'+
                    		'#LinkSelector .line .icon.icon-2 {width: 50px;}'+
                    		'#LinkSelector .line .icon.icon-2:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 20px;}'+
                    		'#LinkSelector .line .icon.icon-3 {width: 60px;}'+
                    		'#LinkSelector .line .icon.icon-3:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 30px;}'+
                    		'#LinkSelector .line .layui-btn-sm {float: right; margin-top: 5px; margin-right: 5px; height: 24px; line-height: 24px; padding: 0 10px;}'+
                    		'#LinkSelector .line .text {display: block;}'+
                    		'#LinkSelector .line .label-sm {padding: 2px 5px;}'+
                    		'#LinkSelector .tip {line-height: 250px; text-align: center;}'+
                    		'#LinkSelector .layui-tab-title > li {padding: 8px 20px;}'+
                    	'</style>'+
                        '<div class="layui-tab layui-tab-brief" lay-filter="selectorTab">'+
                            '<ul class="layui-tab-title" id="LinkSelectorTab">'+
                                '<li class="layui-this" lay-id="#select_site">网站</li>'+
                                '<li lay-id="#select_article">文章</li>'+
                                '<li lay-id="#select_cate">分类</li>'+
                                '<li lay-id="#select_diyform">自定义表单</li>'+
    						'</ul>'+
                        
                            '<div class="layui-tab-content ">'+
                                
                                '<div class="layui-tab-item layui-show" id="select_site">'+
                					'<div class="page-head"><h4><i class="fa fa-folder-open-o"></i> 网站</h4></div>'+
                                    '<nav data-href="'+site_cover_url+'" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="网站首页">网站首页</nav>'+
                                    '<nav data-href="'+window.global.siteroot+'web/index.php?c=site&a=entry&m=bowen_site&do=web&r=pcsite.account.display" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="站点切换">站点切换</nav>'+
                                    '<div class="page-head"><h4><i class="fa fa-folder-open-o"></i> 独立后台</h4></div>'+
                                    '<nav data-href="'+site_login_url+'" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="登录入口">登录入口</nav>'+
                                    '<nav data-href="'+site_register_url+'" data-type="choseLink" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="注册入口">注册入口</nav>'+
                                '</div>'+
                                
                				'<div class="layui-tab-item" id="select_article">'+
                					'<div class="input-group">'+
                						'<input type="text" placeholder="请输入文章标题进行搜索" id="select-select_article-kw" value="" class="layui-input layui-input-group">'+
                						'<span class=" layui-btn layui-btn-primary select-btn" data-type="select_article">搜索</span>'+
                					'</div>'+
                					'<div id="select-select_article-list"></div>'+
                                '</div>'+
                                
                                '<div class="layui-tab-item" id="select_cate">'+
                					'<div class="input-group">'+
                						'<input type="text" placeholder="请输入分类标题进行搜索" id="select-select_cate-kw" value="" class="layui-input layui-input-group">'+
                						'<span class=" layui-btn layui-btn-primary select-btn" data-type="select_cate">搜索</span>'+
                					'</div>'+
                                    '<span class="layui-bg-green">&nbsp;直接点击搜索按钮，可显示全部分类&nbsp;</span>'+
                					'<div id="select-select_cate-list"></div>'+
                                '</div>'+
                                
                                '<div class="layui-tab-item" id="select_diyform">'+
                					'<div class="input-group">'+
                						'<input type="text" placeholder="请输入表单标题进行搜索" id="select-select_diyform-kw" value="" class="layui-input layui-input-group">'+
                						'<span class=" layui-btn layui-btn-primary select-btn" data-type="select_diyform">搜索</span>'+
                					'</div>'+
                					'<div id="select-select_diyform-list"></div>'+
                                '</div>'+
                                
                            '</div>'+
                        '</div>'
                 ,btn: '关闭'
            });
            
            element.render();
            
            element.on('tab(selectorTab)', function(data){
                if($(this).attr('lay-id') == '#select_cate'){
                    $.ajax(myutil.webUrl('selector'), {
                        type: "get",
                        dataType: "html",
                        cache: false,
                        data: {kw:'', type:'select_cate'}
                    }).done(function (html) {
                        $("#select-select_cate-list").html(html);
                        deal_active(o);
                        return;
                    });
                }
            });
            
            $(".select-btn").click(function(){
                var type = $(this).data("type");
                var kw = $.trim($("#select-"+type+"-kw").val());
                
                if((!kw || kw=='') && type != 'select_cate'){
                    layer.msg("请输入搜索关键字！", {icon: 5});
                    return false;
                }
    
                $("#select-"+type+"-list").html('<div class="tip">正在进行搜索...</div>');
                $.ajax(myutil.webUrl('selector'), {
                    type: "get",
                    dataType: "html",
                    cache: false,
                    data: {kw:kw, type:type}
                }).done(function (html) {
                    $("#select-"+type+"-list").html(html);
                    deal_active(o);
                    return;
                });
            });
            
            deal_active(o);
        }
        /** 副站长选择器 */
        ,vicefounder: function(o){
            this_selector = layer.open({
                type: 1
                ,title: '用户选择器'
                ,id: 'ViceFounderSelector'
                ,area: ['850px']
                ,shadeClose: true
                ,content: ''+
                        '<style>'+
                            '#LinkSelector .layui-input-group {width:-webkit-calc(100% - 94px); width:-moz-calc(100% - 94px); width:calc(100% - 94px); display: inline-block;}'+
                            '#LinkSelector .input-group {width:100%;}'+
                    		'#LinkSelector .layui-tab-item {min-height: 300px; max-height: 300px; overflow-y: auto;}'+
                    		'#LinkSelector .page-head {margin: 10px 0 3px 0;}'+
                    		'#LinkSelector .page-head h4 {margin: 0;}'+
                    		'#LinkSelector .layui-btn {margin-bottom: 3px;}'+
                            '#LinkSelector .layui-btn.choseClick{margin: 3px 5px;}'+
                    		'#LinkSelector .line {border-bottom: 1px dashed #ddd; color: #999; height: 36px; line-height: 36px;}'+
                    		'#LinkSelector .line .icon {height: 35px; width: 30px; position: relative; float: left;}'+
                    		'#LinkSelector .line .icon.icon-1:before {content: ""; width: 10px; height: 10px; border: 1px dashed #ccc; position: absolute; top: 12px; left: 10px;}'+
                    		'#LinkSelector .line .icon.icon-2 {width: 50px;}'+
                    		'#LinkSelector .line .icon.icon-2:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 20px;}'+
                    		'#LinkSelector .line .icon.icon-3 {width: 60px;}'+
                    		'#LinkSelector .line .icon.icon-3:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 30px;}'+
                    		'#LinkSelector .line .layui-btn-sm {float: right; margin-top: 5px; margin-right: 5px; height: 24px; line-height: 24px; padding: 0 10px;}'+
                    		'#LinkSelector .line .text {display: block;}'+
                    		'#LinkSelector .line .label-sm {padding: 2px 5px;}'+
                    		'#LinkSelector .tip {line-height: 250px; text-align: center;}'+
                    		'#LinkSelector .layui-tab-title > li {padding: 8px 20px;}'+
                    	'</style>'+
                        '<div class="layui-tab layui-tab-brief" lay-filter="selectorTab">'+
                            '<ul class="nav nav-tabs" id="ViceFounderSelectorTab">'+
                                '<li class="active"><a href="#select_vicefounder">副站长</a></li>'+
    						'</ul>'+
                        
                            '<div class="layui-tab-content ">'+
                                
                				'<div class="layui-tab-item layui-show" id="select_vicefounder">'+
                					'<div class="input-group">'+
                						'<input type="text" placeholder="请输入副站长名称进行搜索" id="select-select_vicefounder-kw" value="" class="layui-input layui-input-group">'+
                						'<span class=" layui-btn layui-btn-primary select-btn" data-type="select_vicefounder">搜索</span>'+
                					'</div>'+
                					'<div id="select-select_vicefounder-list"></div>'+
                                '</div>'+
                                
                            '</div>'+
                        '</div>'
                 ,btn: '关闭'
            });
            
            element.render(); 
            
            $(".select-btn").click(function(){
                var type = $(this).data("type");
                var kw = $.trim($("#select-"+type+"-kw").val());
                
                if((!kw || kw=='') && type != 'select_cate'){
                    layer.msg("请输入搜索关键字！", {icon: 5});
                    return false;
                }
    
                $("#select-"+type+"-list").html('<div class="tip">正在进行搜索...</div>');
                $.ajax(myutil.webUrl('selector'), {
                    type: "get",
                    dataType: "html",
                    cache: false,
                    data: {kw:kw, type:type}
                }).done(function (html) {
                    $("#select-"+type+"-list").html(html);
                    deal_active(o);
                    return;
                });
            });
            
            deal_active(o);
        }
        //平台选择器
        ,account: function(o){
            this_selector = layer.open({
                type: 1
                ,title: '平台选择器'
                ,id: 'accountSelector'
                ,area: ['850px']
                ,shadeClose: true
                ,content: ''+
                        '<div class="layui-form" >' +
                            '<div class="layui-form-item">'+
                                '<label class="layui-form-label must">关键词</label>'+
                                '<div class="layui-input-block">'+
                                    '<input type="text" name="account" autocomplete="off" placeholder="支持模糊搜索" class="layui-input">'+
                                '</div>'+
                            '</div>'+
                            '<div id="selectorAccount" ></div>' + 
                        '</div>'
                ,btn: ['搜索', '关闭']
                ,yes: function(index, layero){
                    var kw = $('#accountSelector').find('input[name="account"]').val();
    				if (kw == '') {
    					layer.msg('搜索关键词不能为空', {icon: 2});
    					return false;
    				}
    				var obj = $('#selectorAccount');
    
    				obj.html('');
    				$.post(myutil.webUrl('selector/account')
                        ,{keyword: kw}
                        ,function(res) {
        					if (res.errno == '0') {
        						var items = res.data;
        						for (var i = 0; i < items.length; i++) {
        							obj.append(
                                        '<nav data-id="' + items[i].uniacid + '" data-name="' + items[i].name + '" data-type="choseAccount" class="choseClick layui-btn layui-btn-primary layui-btn-sm" title="['+items[i].uniacid+']'+items[i].name+'">'+items[i].name+'</nav>'
                                    );
        						}
                                deal_active(o);
        					} else if (res.errno == '1') {
                                layer.msg('没有匹配到名称中带 ' + res.data.keyword + ' 的平台', {icon: 2});
        					} else {
        						layer.msg(res.message, {icon: 2});
        					}
        				}
                    , "json");
                }
            });
            deal_active(o);
        }
        
    };
    
    /** 链接选择器输出选择链接到输入框 */
    function deal_active(o){
        var active = {
       	    choseLink: function() {
      		    var data_href = this.getAttribute('data-href')
                ,needecho = $(o).parent().siblings('input');
                
                needecho.val(data_href);
                layer.close(this_selector);
           	}
            ,choseAccount: function() {
      		    var uniacid = $(this).data('id')
                ,account_name = $(this).data('name');
                var needecho = $(o).parent().siblings('input');
                
                $(needecho[0]).val(uniacid);
                if(needecho[1]){
                    $(needecho[1]).val(account_name);
                }
           	}
        };
            
        $('.choseClick').on('click', function() {
       	    var type = $(this).data('type');
           	active[type] ? active[type].call(this) : '';
        });
    }
    
    exports('selector', s);
}); 