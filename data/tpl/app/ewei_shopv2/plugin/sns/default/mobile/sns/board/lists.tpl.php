<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="fui-page fui-current-page">

    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">全部版块</div>
        <a class="fui-header-right external" href="<?php  echo mobileUrl('sns')?>" ><i class="icon icon-home"></i></a>
    </div>
    <div class="fui-content navbar">
        <div class="fui-fullHigh-group" >

            <div class="fui-fullHigh-item menu" id="tab">

                <nav <?php  if(empty($_GPC['cid'])) { ?>class="on"<?php  } ?>>全部版块</nav>

                <nav data-cid="rec">推荐版块</nav>

                <?php  if(is_array($category)) { foreach($category as $c) { ?>
                    <nav data-cid="<?php  echo $c['id'];?>" <?php  if($c['id']==$_GPC['cid']) { ?>class="on"<?php  } ?>><?php  echo $c['name'];?></nav>
                <?php  } } ?>

            </div>
            <div class="fui-fullHigh-item">

                <form method="post" action="<?php  echo mobileUrl('sns')?>">
                    <div class="searchbar" style='margin:0;padding:0'>
                        <div class="search-input">
                            <i class="icon icon-search"></i>
                            <input type="search" id='keywords' name="keywords" placeholder="输入关键字...">
                        </div>
                    </div>
                </form>
                <p class='text-center text-cancel empty' style='display: none;'>暂时没有任何版块</p>
                <div class='fui-list-group ' id="board-list-group" style='margin-top:0;display: none'></div>
                <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>

            </div>
        </div>
    </div>
    <script id='tpl_board_lists' type='text/html'>
        <%each list as s%>
        <a class='fui-list board-lists-item external'
             data-id='<%s.id%>'
             data-title='<%s.title%>'
             href="<?php  echo mobileUrl('sns/board')?>&id=<%s.id%>&page=1" data-nocache="true">
            <div class='fui-list-media'>
                <img data-lazy='<%s.logo%>' class='round' />
            </div>
            <div class='fui-list-inner'>
                <div class='subtitle'><%s.title%></div>
                <div class='text'>话题数: <span class='text-danger'><%s.postcount%></span> 关注数:<span class="text-danger"><%s.followcount%></span></div>
            </div>
            <div class="fui-list-angle">
                <div class='angle'></div>
            </div>
        </a>
        <%/each%>
    </script>


    <script language='javascript'>
        require(['../addons/ewei_shopv2/plugin/sns/static/js/board.js'], function (modal) {
            modal.initList({ cid: <?php  echo intval($_GPC['cid'])?>, page: <?php  echo intval($_GPC['page'])?>});
        });
    </script>

</div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
