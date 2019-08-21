//选择器

var this_selector = "";

//链接选择器
var LinkSelector = function(obj){
    layui.use('layer', function(){
        var layer = layui.layer;
        
        var site_cover_url = window.global.siteroot+'app/index.php?i='+window.sysinfo.uniacid+'&c=entry&m=bowen_site&do=foreg';
        var site_login_url = window.global.siteroot+'web/index.php?c=site&a=entry&m=bowen_site&do=web&r=pcsite.user.login';
        var site_register_url = window.global.siteroot+'web/index.php?c=site&a=entry&m=bowen_site&do=web&r=pcsite.user.register';
        if(window.sysinfo.isrewrite == '1'){
            site_cover_url = window.global.siteroot+window.sysinfo.uniacid+'/index.html';
            site_login_url = window.global.siteroot+'web/login.html';
            site_register_url = window.global.siteroot+'web/register.html';
        }
        
        this_selector = layer.open({
            type: 1
            ,title: '链接选择器'
            ,id: 'LinkSelector'
            ,area: '930px'
            ,shadeClose: true
            ,content: ''+
                    '<style>'+
                		'#LinkSelector .modal-body {padding: 10px 15px;}'+
                		'#LinkSelector .tab-pane {margin-top: 5px; min-height: 400px; max-height: 400px; overflow-y: auto;}'+
                        '#LinkSelector .tab-content {padding:16px 16px 30px 16px;}'+
                		'#LinkSelector .page-head {padding: 9px 0; margin-bottom: 8px;}'+
                		'#LinkSelector .page-head h4 {margin: 0;}'+
                		'#LinkSelector .layui-btn {margin-bottom: 3px;}'+
                        '#LinkSelector .layui-btn.choseLink{margin: 0 5px;}'+
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
                		'#LinkSelector .nav-tabs > li > a {padding: 8px 20px;}'+
                	'</style>'+
                    '<div class="panel-body">'+
                        '<ul class="nav nav-tabs" id="LinkSelectorTab">'+
                            '<li class="active"><a href="#select_site">网站</a></li>'+
                            '<li class=""><a href="#select_article">文章</a></li>'+
                            '<li class=""><a href="#select_cate">分类</a></li>'+
                            '<li class=""><a href="#select_diyform">自定义表单</a></li>'+
						'</ul>'+
                    '</div>'+
                    '<div class="tab-content ">'+
                        
                        '<div class="tab-pane active" id="select_site">'+
        					'<div class="page-head"><h4><i class="fa fa-folder-open-o"></i> 网站</h4></div>'+
                            '<nav data-href="'+site_cover_url+'" data-type="choseLink" class="choseLink layui-btn layui-btn-primary layui-btn-sm" title="网站首页">网站首页</nav>'+
                            '<nav data-href="'+window.global.siteroot+'web/index.php?c=site&a=entry&m=bowen_site&do=web&r=pcsite.account.display" data-type="choseLink" class="choseLink layui-btn layui-btn-primary layui-btn-sm" title="站点切换">站点切换</nav>'+
                            '<div class="page-head"><h4><i class="fa fa-folder-open-o"></i> 独立后台</h4></div>'+
                            '<nav data-href="'+site_login_url+'" data-type="choseLink" class="choseLink layui-btn layui-btn-primary layui-btn-sm" title="登录入口">登录入口</nav>'+
                            '<nav data-href="'+site_register_url+'" data-type="choseLink" class="choseLink layui-btn layui-btn-primary layui-btn-sm" title="注册入口">注册入口</nav>'+
                        '</div>'+
                        
        				'<div class="tab-pane" id="select_article">'+
        					'<div class="input-group">'+
        						'<input type="text" placeholder="请输入文章标题进行搜索" id="select-select_article-kw" value="" class="form-control">'+
        						'<span class="input-group-addon layui-btn layui-btn-primary select-btn" data-type="select_article">搜索</span>'+
        					'</div>'+
        					'<div id="select-select_article-list"></div>'+
                        '</div>'+
                        
                        '<div class="tab-pane" id="select_cate">'+
        					'<div class="input-group">'+
        						'<input type="text" placeholder="请输入分类标题进行搜索" id="select-select_cate-kw" value="" class="form-control">'+
        						'<span class="input-group-addon layui-btn layui-btn-primary select-btn" data-type="select_cate">搜索</span>'+
        					'</div>'+
                            '<span class="layui-bg-green">&nbsp;直接点击搜索按钮，可显示全部分类&nbsp;</span>'+
        					'<div id="select-select_cate-list"></div>'+
                        '</div>'+
                        
                        '<div class="tab-pane" id="select_diyform">'+
        					'<div class="input-group">'+
        						'<input type="text" placeholder="请输入表单标题进行搜索" id="select-select_diyform-kw" value="" class="form-control">'+
        						'<span class="input-group-addon layui-btn layui-btn-primary select-btn" data-type="select_diyform">搜索</span>'+
        					'</div>'+
        					'<div id="select-select_diyform-list"></div>'+
                        '</div>'+
                        
                    '</div>'
             ,btn: '关闭'
        });
        
        $("#LinkSelector").find('#LinkSelectorTab a').click(function(e) {
            $('#tab').val($(this).attr('href'));
            e.preventDefault();
            $(this).tab('show');
            if($(this).attr('href') == '#select_cate'){
                $.ajax("./index.php?c=site&a=entry&m=bowen_site&do=web&r=selector", {
                    type: "get",
                    dataType: "html",
                    cache: false,
                    data: {kw:'', type:'select_cate'}
                }).done(function (html) {
                    $("#select-select_cate-list").html(html);
                    deal_active(layer,obj);
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
            $.ajax("./index.php?c=site&a=entry&m=bowen_site&do=web&r=selector", {
                type: "get",
                dataType: "html",
                cache: false,
                data: {kw:kw, type:type}
            }).done(function (html) {
                $("#select-"+type+"-list").html(html);
                deal_active(layer,obj);
                return;
            });
        });
        
        deal_active(layer,obj);
    });
}

/** 副站长选择器 */
var ViceFounderSelector = function(obj){
    layui.use('layer', function(){
        var layer = layui.layer;
        
        var site_cover_url = window.global.siteroot+'app/index.php?i='+window.sysinfo.uniacid+'&c=entry&m=bowen_site&do=foreg';
        var site_login_url = window.global.siteroot+'web/index.php?c=site&a=entry&m=bowen_site&do=web&r=pcsite.user.login';
        var site_register_url = window.global.siteroot+'web/index.php?c=site&a=entry&m=bowen_site&do=web&r=pcsite.user.register';
        if(window.sysinfo.isrewrite == '1'){
            site_cover_url = window.global.siteroot+window.sysinfo.uniacid+'/index.html';
            site_login_url = window.global.siteroot+'web/login.html';
            site_register_url = window.global.siteroot+'web/register.html';
        }
        
        this_selector = layer.open({
            type: 1
            ,title: '用户选择器'
            ,id: 'ViceFounderSelector'
            ,area: '930px'
            ,shadeClose: true
            ,content: ''+
                    '<style>'+
                		'#ViceFounderSelector .modal-body {padding: 10px 15px;}'+
                		'#ViceFounderSelector .tab-pane {margin-top: 5px; min-height: 400px; max-height: 400px; overflow-y: auto;}'+
                        '#ViceFounderSelector .tab-content {padding:16px 16px 30px 16px;}'+
                		'#ViceFounderSelector .page-head {padding: 9px 0; margin-bottom: 8px;}'+
                		'#ViceFounderSelector .page-head h4 {margin: 0;}'+
                		'#ViceFounderSelector .layui-btn {margin-bottom: 3px;}'+
                        '#ViceFounderSelector .layui-btn.choseLink{margin: 0 5px;}'+
                		'#ViceFounderSelector .line {border-bottom: 1px dashed #ddd; color: #999; height: 36px; line-height: 36px;}'+
                		'#ViceFounderSelector .line .icon {height: 35px; width: 30px; position: relative; float: left;}'+
                		'#ViceFounderSelector .line .icon.icon-1:before {content: ""; width: 10px; height: 10px; border: 1px dashed #ccc; position: absolute; top: 12px; left: 10px;}'+
                		'#ViceFounderSelector .line .icon.icon-2 {width: 50px;}'+
                		'#ViceFounderSelector .line .icon.icon-2:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 20px;}'+
                		'#ViceFounderSelector .line .icon.icon-3 {width: 60px;}'+
                		'#ViceFounderSelector .line .icon.icon-3:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 30px;}'+
                		'#ViceFounderSelector .line .layui-btn-sm {float: right; margin-top: 5px; margin-right: 5px; height: 24px; line-height: 24px; padding: 0 10px;}'+
                		'#ViceFounderSelector .line .text {display: block;}'+
                		'#ViceFounderSelector .line .label-sm {padding: 2px 5px;}'+
                		'#ViceFounderSelector .tip {line-height: 250px; text-align: center;}'+
                		'#ViceFounderSelector .nav-tabs > li > a {padding: 8px 20px;}'+
                	'</style>'+
                    '<div class="panel-body">'+
                        '<ul class="nav nav-tabs" id="ViceFounderSelectorTab">'+
                            '<li class="active"><a href="#select_vicefounder">副站长</a></li>'+
						'</ul>'+
                    '</div>'+
                    '<div class="tab-content ">'+
                        
        				'<div class="tab-pane active" id="select_vicefounder">'+
        					'<div class="input-group">'+
        						'<input type="text" placeholder="请输入副站长名称进行搜索" id="select-select_vicefounder-kw" value="" class="form-control">'+
        						'<span class="input-group-addon layui-btn layui-btn-primary select-btn" data-type="select_vicefounder">搜索</span>'+
        					'</div>'+
        					'<div id="select-select_vicefounder-list"></div>'+
                        '</div>'+
                        
                    '</div>'
             ,btn: '关闭'
        });
        
        $("#ViceFounderSelector").find('#ViceFounderSelectorTab a').click(function(e) {
            $('#tab').val($(this).attr('href'));
            e.preventDefault();
            $(this).tab('show');
        });
        
        $(".select-btn").click(function(){
            var type = $(this).data("type");
            var kw = $.trim($("#select-"+type+"-kw").val());
            
            if((!kw || kw=='') && type != 'select_cate'){
                layer.msg("请输入搜索关键字！", {icon: 5});
                return false;
            }

            $("#select-"+type+"-list").html('<div class="tip">正在进行搜索...</div>');
            $.ajax("./index.php?c=site&a=entry&m=bowen_site&do=web&r=selector", {
                type: "get",
                dataType: "html",
                cache: false,
                data: {kw:kw, type:type}
            }).done(function (html) {
                $("#select-"+type+"-list").html(html);
                deal_active(layer,obj);
                return;
            });
        });
        
        deal_active(layer,obj);
    });
}

/** 链接选择器输出选择链接到输入框 */
var deal_active = function(layer,obj)
{
    var active = {
   	    choseLink: function() {
  		    var needecho = $(obj).parent().siblings('input');
            var data_href = this.getAttribute('data-href');
            needecho.val(data_href);
            layer.close(this_selector);
       	}
    };
        
    $('.choseLink').on('click', function() {
   	    var type = $(this).data('type');
       	active[type] ? active[type].call(this) : '';
    });
}