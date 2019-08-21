/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.we7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/8/24 15:15:53] -->
 */
layui.define(['flow', 'layer', 'jquery', 'clip', 'myutil', 'php'], function(exports) {
	var $ = layui.jquery
		,layer = layui.layer
        ,flow = layui.flow
        ,clip = layui.clip
        ,myutil = layui.myutil
        ,php = layui.php;

    /** 监听点击事件 */
    var active = {
        clip:function() {
            var data_href = this.getAttribute('data-href');
            clip(this, data_href);
        }
        ,show_qr_wechat:function() {
            layer.open({
                title: false,
                type: 1,
                shadeClose: true,
                skin: 'layui-layer-rim',
                area: ['300px', '300px'],
                content: '<img src="'+global.qr_wechat+'" width="300px" />'
            });
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

    ;!function() {
        //计算阅读量
        var siteurl = window.location.href;
        if(siteurl.indexOf("r=article") >= 0 || siteurl.indexOf("/article_") >= 0 || siteurl.indexOf("/article-") >= 0 || siteurl.indexOf("/article/") >= 0){
            setTimeout('$.post(layui.myutil.foregUrl("article/addReading", "", true), {id: global.id}, function(d){console.log(d.message);}, "json");',3000);
        }

        //检测是否有需要懒加载的图片
        if($('*[lay-src]').length>0){
            flow.lazyimg();
        }
    }();

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