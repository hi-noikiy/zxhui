layui.define(['flow', 'layer', 'jquery', 'clip', 'myutil'], function(exports) {
	var $ = layui.jquery
		,layer = layui.layer
        ,flow = layui.flow
        ,clip = layui.clip
        ,myutil = layui.myutil;

    //图片懒加载
    flow.lazyimg();
    
    //构造图片弹出层
    $(".qhd-content img").each(function() {
        if (0 == $(this).parent("a").length) {
            var t = $(this).attr("src");
            if(!t){t=$(this).attr("lay-src");}
            $(this).wrap("<div class='lg-item-box' data-src='" + t + "' data-exthumbimage='" + t + "'></div>");
        }
    })
    $("body").addClass("bowen-white-lightGallery");
    $(".qhd-content").wrapInner("<div id='lightgallery'></div>");
    layui.link("../addons/bowen_site/static/lightGallery/css/lightgallery.min.css?v=" + global.version);
    $.getScript("../addons/bowen_site/static/lightGallery/lib/picturefill.min.js?v=" + global.version);
    $.getScript("../addons/bowen_site/static/lightGallery/js/lightgallery-all.min.js?v=" + global.version).done(function(){
        $(document).ready(function() {
            $("#lightgallery").lightGallery({
                selector: ".lg-item-box",
                exThumbImage: "data-exthumbimage",
                getCaptionFromTitleOrAlt: false,
                share: false
            });
        });
    });
    $.getScript("../addons/bowen_site/static/lightGallery/lib/jquery.mousewheel.min.js?v=" + global.version);
    
    /** 监听点击事件 */
    var active = {
        clip:function() {
            var data_href = this.getAttribute('data-href');
            clip(this, data_href);
        },
        show_qr_wechat:function() {
            layer.open({
                title: false,
                type: 1,
                shadeClose: true,
                skin: 'layui-layer-rim',
                area: ['315px', '315px'],
                content: '<img src="'+global.qr_wechat+'" width="300px" />'
            });
        },
        show_diyform: function(){
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
    };
    $('.onclick').on('click', function() {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });
    
    //渲染clip模块
    $(".onclick").each(function() {
        if($(this).data('type') == 'clip' && $(this).attr("data-href")){
            clip(this, $(this).attr("data-href"))
        }
	});
    
	exports('global', {});
});