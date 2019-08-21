<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<script>document.title = "兑换中心"; </script>



<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/exchange/static/css/common.css?v=<?php  echo time()?>">



<div class='fui-page fui-page-current'>



    <div class="fui-content">

<?php  if(!empty($banner)) { ?>

        <div class='fui-swipe' data-transition="500" data-gap="1">

            <div class='fui-swipe-wrapper' style="height: 220px">

                <?php  if(is_array($banner)) { foreach($banner as $k => $v) { ?>

                <a class='fui-swipe-item external' href="">

                    <img src="<?php  echo urldecode(tomedia($v));?>" height="100%" width="100%"/>

                </a>

                <?php  } } ?>

            </div>

            <div class='fui-swipe-page'></div>

        </div>

<?php  } ?>

        <!--<div class="block-text"></div>-->



        <div class="block-exchange">

            <div class="title">

                <p class="text">兑换中心</p>

                <p class="text2" style="display: none;">兑换码: D123456</p>

                <p class="num">此兑换码已查询<span id="num">1</span>次</p>

            </div>

            <div class="input">

                <input placeholder="请输入兑换码" id="exchangeno" value="<?php  echo $key;?>"/>

            </div>

            <div class="list">

                <div class="item balance" style="display: none">

                    <div class="ico money"></div>

                    <div class="info">

                        <p class="t1">余额兑换</p>

                        <p class="t2">面值：1000元</p>

                    </div>

                    <div class="btn-exc btn btn-danger btn-sm" id="balance">兑换</div>

                </div>

                <div class="item score" style="display: none">

                    <div class="ico credit"></div>

                    <div class="info">

                        <p class="t1">积分兑换</p>

                        <p class="t2">面值：1000元</p>

                    </div>

                    <div class="btn-exc btn btn-danger btn-sm" id="score">兑换</div>

                </div>

                <div class="item coupon" style="display: none">

                    <div class="ico coupon"></div>

                    <div class="info">

                        <p class="t1">优惠券兑换</p>

                        <p class="t2">面值：1000元</p>

                    </div>

                    <div class="btn-exc btn btn-danger btn-sm" id="coupon">兑换</div>

                </div>

                <div class="item red" style="display: none">

                    <div class="ico redbag"></div>

                    <div class="info">

                        <p class="t1">红包兑换</p>

                        <p class="t2">面值：1000元</p>

                    </div>

                    <div class="btn-exc btn btn-danger btn-sm" id="red">兑换</div>

                </div>

                <div class="item goods" style="display: none">

                    <div class="ico goods"></div>

                    <div class="info">

                        <p class="t1">商品兑换</p>

                        <p class="t2">面值：1000元</p>

                    </div>

                    <div class="btn-exc btn btn-danger btn-sm" id="goods">兑换</div>

                </div>

            </div>

            <div class="btn btn-danger block" id="exchange">马上兑换</div>

            <div class="btn btn-default block" id="reset">返回重新输入兑换码</div>

        </div>



        <div class="block-info">

            <div class="head">

                <div class="title">兑换中心</div>

            </div>

            <div class="info">

                <p><b>兑换规则<?php  echo htmlspecialchars_decode($res['rule']);?></b></p>

                <p></p>

            </div>

        </div>



        <div class="alert-success-outer" style="display: none;">

            <div class="alert-success">

                <div class="text" id="status1">恭喜！兑换成功！</div>

                <div class="btn btn-warning">确定</div>

            </div>

        </div>



        <div class="alert-error-outer" style="display: none;">

            <div class="alert-error">

                <div class="text" id="status0">很遗憾！兑换码已失效！</div>

                <div class="btn btn-warning">知道了</div>

            </div>

        </div>



    </div>

    <input type="hidden" name="url" value="<?php  echo mobileUrl('exchange',array(),1);?>" id="url">

</div>



<script language='javascript'>require(['../addons/ewei_shopv2/plugin/exchange/static/js/common.js'],function(modal){modal.init({style:{},all:<?php  echo $all;?>});});</script>





<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

