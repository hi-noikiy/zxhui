/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.we7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/8/25 12:05:23] -->
 */
layui.define(['code', 'element', 'table', 'util', 'flow', 'layer', 'jquery', 'clip', 'php', 'myutil'], function(exports) {
	var $ = layui.jquery
		,element = layui.element
		,layer = layui.layer
		,form = layui.form
		,util = layui.util
        ,flow = layui.flow
        ,device = layui.device()
    	,clip = layui.clip
        ,php = layui.php
        ,myutil = layui.myutil;

    /** 阻止IE7以下访问 */
	if (device.ie && device.ie < 8) {
		layer.alert('最低支持ie8，您当前使用的是古老的 IE' + device.ie + '，赶紧换个浏览器吧！');
	}
    
    /** 图片懒加载 */
    flow.lazyimg();
    
    /** 点击事件 */
    var active = {
        show_qr_wechat:function() {
            layer.open({
                title: false,
                type: 1,
                shadeClose: true,
                skin: 'layui-layer-rim',
                area: ['300px', '300px'],
                content: '<img src="'+global.qr_wechat+'" width="300px" />'
            });
        }
        ,clip:function() {
            var data_href = this.getAttribute('data-href');
            clip(this, data_href);
        }
        ,show_diyform: function(){
            var dfid = this.getAttribute('data-dfid');
            if(!dfid || dfid == "")layui.hint().error('表单ID为空');
            var diyform_url = myutil.foregUrl('diyform', {id:dfid}, true);
            console.log(diyform_url);
            layer.open({
                type: 2
                ,content: [diyform_url, 'no']
                ,area: ['90%', '95%']
                ,shadeClose: true
                ,moveOut: true
            }); 
        }
        ,show_img:function() {
            var area = this.getAttribute('data-area')
            ,src = this.getAttribute('data-src')
            ,title = this.getAttribute('data-title');
            if(!src)return false;
            if(area){
                area = php.explode('|',area); 
            }else{
                area = ['300px', '300px'];
            }
            if(!title)title = false;
            layer.open({
                title: title,
                type: 1,
                shadeClose: true,
                skin: 'layui-layer-rim',
                area: area,
                content: '<img src="'+src+'" width="100%" />'
            });
        }
    };
    
    /** 文章加载 */
    flow.load({
  		elem: '#items'
        ,isLazyimg: true
  		,done: function(page, next) {
            var lis = [];
            $.post(global.link_getArticles_list + "&page=" + page
                ,{psize: global.list_psize, isASC: 'true', contentType: 'layui', hide_lower_leve: 1}
                ,function(res){
                    layui.each(res.data, function(index, item) {
                        
                        $(".site-dir").append('<li><a href="#article_'+item.id+'"><cite>'+item.title+'</cite></a></li>');
                        
                        var item_data = [];
                        var description_repl = ''
                        if(item.description_repl){
                            description_repl = '<blockquote class="layui-elem-quote">'+item.description_repl+'</blockquote>';
                        }
                        
                        var article_url = global.siteurl;
                        if(window.location.hash != ""){
                           article_url = article_url.replace(window.location.hash, ""); 
                        }
                        
                        item_data = ''+
                            '<fieldset class="layui-elem-field layui-field-title site-title">'+
            					'<legend>'+
            						'<a name="article_'+item.id+'" href="#article_'+item.id+'" class="onclick" data-type="clip" data-href="'+article_url+'#article_'+item.id+'">'+item.title+'</a>'+
            					'</legend>'+
            				'</fieldset>'+
                            description_repl+
            				'<div class="site-text">'+
            					item.content+
            				'</div>';
                                        
       					lis.push(item_data);
                    });
                             
                    next(lis.join(''), page < res.pages);
                    
                    /** 代码修饰 */
                    layui.code({
                        title  : global.code_title?global.code_title:"Code"
                        ,elem  : 'pre'
                        ,about : false
                    });
                    
                    /** 显示目录 */
                    var siteDir = $('.site-dir');
                    if (siteDir[0] && $(window).width() > 750) {
                        layer.ready(function() {
                            layer.open({
                                type: 1,
                                zIndex: 999,
                                content: siteDir,
                                skin: 'layui-layer-dir',
                                area: 'auto',
                                maxHeight: $(window).height() - 300,
                                title: '目录',
                                offset: 'r',
                                shade: false,
                                success: function(layero, index) {
                                    layer.style(index, {
                                        marginLeft: -15
                                    });
                				}
                 			});
                  		});
                        /** 点击后为选中状态 */
                        siteDir.find('li').on('click', function() {
                            var othis = $(this);
                            othis.find('a').addClass('layui-this');
                            othis.siblings().find('a').removeClass('layui-this');
                        });
                   	}
                    
                    /** 根据锚点跳转到指定文章 */
                    goHash = function(thisId, targetTop, scrollTime, waitTime){
                        scrollTime = scrollTime?scrollTime:500;
                        waitTime= waitTime?waitTime:500;
                        if($('a[name="'+thisId+'"]').length>0){
                            var target_top = $('a[name="'+thisId+'"]').offset().top;
                            if(targetTop != target_top){
                                $("html,body").animate({scrollTop: target_top}, scrollTime);
                                setTimeout('goHash("'+thisId+'", "'+target_top+'");', waitTime);
                            }
                            return target_top;
                        }
                        return false;
                    }
                    var thisId = window.location.hash;
                    if(thisId != "" && thisId != undefined){
                        thisId = thisId.split("#").join("");
                        goHash(thisId);
                    }
                    
                    /** 构造图片弹出层 */
                    $(".site-content img").each(function() {
              		    if (0 == $(this).parent("a").length && !$(this).hasClass('no-lightGallery')) {
                            var t = $(this).attr("src");
                            if(!t){t=$(this).attr("lay-src");}
                            $(this).wrap("<div class='lg-item-box' data-src='" + t + "' data-exthumbimage='" + t + "'></div>");
                        }
                   	})
                    $("body").addClass("bowen-white-lightGallery");
                    $(".site-content").wrapInner("<div id='lightgallery'></div>");
                    layui.link("../addons/bowen_site/static/lightGallery/css/lightgallery.min.css?v=" + global.version);
                    $.getScript("../addons/bowen_site/static/lightGallery/lib/picturefill.min.js?v=" + global.version);
                    $.getScript("../addons/bowen_site/static/lightGallery/js/lightgallery-all.min.js?v=" + global.version).done(function(){
                        $(document).ready(function() {
                            $("#lightgallery").lightGallery({
                                selector: ".lg-item-box",
                                autoplayControls: false,
                                exThumbImage: "data-exthumbimage",
                              	share: false,
                              	download: false
                            });
                        });
                    });
                    $.getScript("../addons/bowen_site/static/lightGallery/lib/jquery.mousewheel.min.js?v=" + global.version);
                    
                    /** 监听点击事件 */
                    $('.onclick').on('click', function() {
                        var type = $(this).data('type');
                        active[type] ? active[type].call(this) : '';
                    });
                    
                    /** 渲染点击复制组件 */
                    $(".onclick").each(function() {
                        if($(this).data('type') == 'clip' && $(this).attr("data-href")){
                            clip(this, $(this).attr("data-href"))
                        }
                	});
                    
  		        }
            ,"json");      
  		}
        ,end: '&nbsp;'
   	});
    
    /** 分类搜索 */
    form.on('select(searchClass)', function(data) {
	   var value = data.value;
       location.href = '../app/index.php?i='+global.uniacid+'&c=entry&m=bowen_site&do=foreg&r=class&id='+value;
   	});

	/** 固定Bar */
    util.fixbar(global.fixbar);
    
    /** 窗口scroll */
	;!function() {
		var main = $('.site-tree').parent(),
			scroll = function() {
				var stop = $(window).scrollTop();

				if ($(window).width() <= 750) return;
				var bottom = $('.footer').offset().top - $(window).height();
				if (stop > 61 && stop < bottom) {
					if (!main.hasClass('site-fix')) {
						main.addClass('site-fix');
					}
					if (main.hasClass('site-fix-footer')) {
						main.removeClass('site-fix-footer');
					}
				} else if (stop >= bottom) {
					if (!main.hasClass('site-fix-footer')) {
						main.addClass('site-fix site-fix-footer');
					}
				} else {
					if (main.hasClass('site-fix')) {
						main.removeClass('site-fix').removeClass('site-fix-footer');
					}
				}
				stop = null;
			};
		scroll();
		$(window).on('scroll', scroll);
	}();

    /** 手机设备的简单适配 */
	var treeMobile = $('.site-tree-mobile'),
		shadeMobile = $('.site-mobile-shade');

    treeMobile.on('click', function() {
        $('body').addClass('site-mobile');
    });

	shadeMobile.on('click', function() {
		$('body').removeClass('site-mobile');
	});
    
    var scrollLeftNav = function(){
        $(".tree2").each(function() {
            var tree2_id = this.getAttribute('data-id');
            var list_id = '#tree3_of_'+tree2_id, icon_id = '#layui-icon-'+tree2_id;
            $(this).on("mouseenter", function () {
                //变换图标
                if($(icon_id).length > 0){
                    if($(icon_id).hasClass('layui-icon-triangle-r')){
                        $(icon_id).removeClass('layui-icon-triangle-r');
                    }
                    $(icon_id).addClass('layui-icon-triangle-d');
                }
                //显示
                if($(list_id).hasClass('layui-hide-sm')){
                    $(list_id).removeClass('layui-hide-sm');
                }
            }).on("mouseleave", function () {
                //变换图标
                if($(icon_id).length > 0){
                    if($(icon_id).hasClass('layui-icon-triangle-d')){
                        $(icon_id).removeClass('layui-icon-triangle-d');
                    }
                    $(icon_id).addClass('layui-icon-triangle-r');
                }
                //隐藏
                if($(list_id).hasClass('needhide')){
                    $(list_id).addClass('layui-hide-sm');
                }
            });
            $(this).on('click', function(){
                if($(list_id).hasClass('layui-hide-xs')){
                    return $(list_id).removeClass('layui-hide-xs');
                }
                if(!$(list_id).hasClass('layui-hide-xs') && $(list_id).hasClass('needhide')){
                    return $(list_id).addClass('layui-hide-xs');
                }
            });
        });
    }
    setTimeout(scrollLeftNav, 500);

    var runTask = function(){
        $.ajax({
            url: myutil.webUrl('runTask', '', true)
            ,type: 'get'
            ,cache: false
            ,dataType: "json"
            ,success: function (d) {
                if(d.msg){
                    console.log(d.msg);
                }
            }
        });
    }
    setTimeout(runTask, 1000);
    
	exports('global', {});
});