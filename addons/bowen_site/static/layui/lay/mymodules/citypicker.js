/**
 * 企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 17:53:37] -->
 */
layui.define(['citydata', 'layer', 'form', 'jquery'], function(exports){
    var $=layui.jquery
    ,layer = layui.layer
    ,citydata = layui.citydata
    ,form = layui.form;
    
    var picker = {
        render: function(name, selected){
            if(selected){
                selected = JSON.parse(selected)
            }
            
            var select_province = $('select[name="'+name+'[province]"]')
            ,select_city = $('select[name="'+name+'[city]"]')
            ,select_area = $('select[name="'+name+'[area]"]');
            
            var lis_1 = '<option value="">请选择省/直辖市</option>'
            ,lis_2 = '<option value="">请选择市/直辖市</option>'
            ,lis_3 = '<option value="">请选择县/区</option>';
            
            var i = 0;
            layui.each(citydata, function(index, item) {
                lis_1 += '<option value="'+item.text+'" data-p="'+i+'">'+item.text+'</option>';
                i++;
            });
            
            select_province.append(lis_1);
            if(select_city.length>0)select_city.append(lis_2);
            if(select_area.length>0)select_area.append(lis_3);
            form.render('select');
            
            form.on('select('+name+'_province)', function(data){
                if(data.value == "" || select_city.length < 0)return;
                $('select[name="'+name+'[city]"] option').remove();
                $('select[name="'+name+'[area]"] option').remove();
                
                var code_p = $(data.elem).find("option:selected").attr("data-p");
                
                var lis_2_new = lis_2;
                i = 0;
                layui.each(citydata[code_p]['children'], function(index, item) {
                    lis_2_new += '<option value="'+item.text+'" data-p="'+code_p+'" data-c="'+i+'">'+item.text+'</option>';
                    i++;
                });
                select_city.append(lis_2_new);
                if(select_area.length>0)select_area.append(lis_3);
                form.render('select');
            })
            
            form.on('select('+name+'_city)', function(data){
                if(data.value == "" || select_area.length < 0)return;
                $('select[name="'+name+'[area]"] option').remove();
                
                var code_p = $(data.elem).find("option:selected").attr("data-p");
                var code_c = $(data.elem).find("option:selected").attr("data-c");
                
                var lis_3_new = lis_3;
                i = 0;
                layui.each(citydata[code_p]['children'][code_c]['children'], function(index, item) {
                    lis_3_new += '<option value="'+item.text+'">'+item.text+'</option>';
                    i++;
                });
                select_area.append(lis_3_new);
                form.render('select');
            })
        }
    };
  
    exports('citypicker', picker);
}); 