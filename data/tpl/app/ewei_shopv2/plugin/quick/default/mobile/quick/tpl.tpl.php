<?php defined('IN_IA') or exit('Access Denied');?><script type="text/html" id="tpl_nav">
    <%each data as item index%>
    <nav data-index="<%index%>" <%if selected==index%>class="on"<%/if%>><%if item.icon!=''%><i class="icon <%item.icon%>"></i> <%/if%><%item.title%><%if item.title==''&&item.icon==''%>未命名<%/if%><%if item.num>0%><i class="dot"><%item.num%></i><%/if%></nav>
    <%/each%>
</script>
<script type="text/html" id="tpl_goods">
    <%each data as item index%>
    <div class="quick-item" data-index="<%index%>">
        <a class="thumb" href="<?php  echo mobileUrl('goods/detail')?>&id=<%item.id%>" data-nocache="true">
            <img src="<%imgsrc item.thumb%>" onerror="this.src='';" />
        </a>
        <div class="info">
            <a class="title" href="<?php  echo mobileUrl('goods/detail')?>&id=<%item.id%>" data-nocache="true"><%if item.presell==1%><i class="fui-tag fui-tag-danger">预</i><%/if%><%if item.isbargain==1%><i class="fui-tag fui-tag-danger red">砍</i><%/if%><%item.title%></a>
            <a class="subtitle" href="<?php  echo mobileUrl('goods/detail')?>&id=<%item.id%>" data-nocache="true"><%item.subtitle%></a>
            <%if item.showsales==1 || item.showtotal==1%>
            <div class="sales">
                <%if item.showsales==1%>销量 <%item.sales||0%><%/if%> <%if item.showtotal==1%>库存 <%item.total||0%><%/if%>
            </div>
            <%/if%>
            <div class="buyline">
                <div class="price">￥<%item.minprice%></div>
                <div class="buy">
                    <div class="quick-num <%if item.num>0%>open<%/if%>" data-num="0">
                        <div class="minus icon <%if item.dismin==1%>disabled<%/if%>"></div>
                        <div class="num"><%item.num%></div>
                        <div class="plus icon <%if item.cannotbuy!=''||item.dismax==1%>disabled<%/if%>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <%/each%>
</script>
<script type="text/html" id="tpl_cart">
    <%each list as item index%>
    <div class="item" data-index="<%index%>">
        <div class="text">
            <p><%item.title%></p>
            <%if item.hasoption==1%>
            <p class="spec"><%item.optiontitle%></p>
            <%/if%>
        </div>
        <%if item.maxbuy>0%>
        <div class="sale"> 最多购买<%item.totalmaxbuy < item.maxbuy ? item.totalmaxbuy : item.maxbuy%><%item.unit%></div>
        <%else%>
        <%if item.minbuy>0%>
        <div class="sale"> 最少购买<%item.minbuy%><%item.unit%></div>
        <%/if%>
        <%/if%>
        <div class="price">￥<%calculate(item.marketprice * item.total)%></div>
        <div class="num">
            <div class="quick-num open" data-num="0">
                <div class="minus icon <%if item.dismin==1%>disabled<%/if%>"></div>
                <div class="num"><%item.total%></div>
                <div class="plus icon <%if item.dismax==1%>disabled<%/if%>"></div>
            </div>
        </div>
    </div>
    <%/each%>
</script>
<script type="text/html" id="tpl_spec">
    <%each specs as item index%>
    <div class="spec"><%item.title%></div>
    <%if item.items%>
    <div class="specs">
        <%each item.items as child%>
        <div class="item"><%child.title%></div>
        <%/each%>
    </div>
    <%/if%>
    <%/each%>
</script>
<script type="text/html" id="option-picker">
    <div class="option-picker">
        <div class="option-picker-inner">
            <div class="option-picker-cell goodinfo">
                <div class="closebtn"><i class="icon icon-roundclose"></i></div>
                <div class="img"><img class='thumb' src="<%goods.thumb%>" /></div>
                <div class="info info-price text-warning"><span>￥<span class='price'><%if goods.maxprice == goods.minprice%><%goods.minprice%><%else%><%goods.minprice%>~<%goods.maxprice%><%/if%></span></span></div>
                <div class="info info-total">
                    <%if seckillinfo==false || ( seckillinfo && seckillinfo.status==1) %>
                    <%if goods.showtotal != 0%>库存 <span class='total text-warning'><%goods.total%></span> 件<%/if%>
                    <%/if%>
                </div>
                <div class="info info-titles"><%if specs.length>0%>请选择规格<%/if%></div>
            </div>
            <div class="option-picker-options">
                <%each specs as spec%>
                <div class="option-picker-cell option spec">
                    <div class="title"><%spec.title%></div>
                    <div class="select">
                        <%each spec.items as item%>
                        <a href="javascript:;" class="btn btn-default btn-sm nav spec-item"  data-id="<%item.id%>" data-thumb="<%item.thumb%>"> <%item.title%> </a>
                        <%/each%>
                    </div>
                </div>
                <%/each%>
                <%=diyformhtml%>
                <%if (seckillinfo==false || ( seckillinfo && seckillinfo.status==1)) %>
                <div class="fui-cell-group">
                    <div class="fui-cell">
                        <div class="fui-cell-label">数量</div>
                        <div class="fui-cell-info"></div>
                        <div class="fui-cell-mask noremark">
                            <div class="fui-number">
                                <div class="minus">-</div>
                                <input class="num" type="tel" name="" value="1"/>
                                <div class="plus ">+</div>
                            </div>
                        </div>
                    </div>
                </div>
                <%else%>
                    <input class="num" type="hidden" name="" value="1"/>
                <%/if%>
            </div>
            <div class="fui-navbar">
                <a href="javascript:;" class="nav-item btn confirmbtn"  style='display:none'><%if goods.canAddCart%>确定<%else%>立刻购买<%/if%></a>
            </div>
        </div>
    </div>
</script>