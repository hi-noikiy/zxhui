/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 17:53:14] -->
 */
layui.define(['clipboard', 'layer'], function(exports){
    var clipboard = layui.clipboard, layer = layui.layer;
    
    var c = function(e, t) {
        var o = new clipboard(e,
            {
                text: function(trigger) {
                    return t
                }
            }
        );
        o.on("success", function(e) {
            layer.msg("复制成功", {icon: 1}), e.clearSelection()
        });
        o.on("error", function(e) {
            layer.msg("复制失败，请重试", {icon: 5});
        });
    }
  
    exports('clip', c);
}); 