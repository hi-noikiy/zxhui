<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .select2{
        margin:0;
        width:100%;
        height:34px;
        border-radius: 3px;
        border-color: rgb(229, 230, 231);
    }
    .select2 .select2-choice{
        height: 34px;
        line-height: 32px;
        border-radius: 3px;
        border-color: rgb(229, 230, 231);
    }
    .select2 .select2-choice .select2-arrow{
        background: #fff;
    }
    .form-group .radio-inline{
        padding-top: 0px;;
    }
</style>
<div class="page-header">当前位置：<span class="text-primary">砍价活动设置</span></div>
<div class="page-content">
<form action="" method="post" class="form-horizontal form-search form-validate" id="myform">
    <hr>
    <div class="form-group">
        <label class="col-lg control-label">必须关注才能砍价</label>
        <div class="col-sm-9 col-xs-12">
            <label class="checkbox-inline">
                <input type="checkbox" name="follow_swi" value="1" aria-invalid="false" class="valid" onclick="check()" id="follow_swi" <?php  if(!empty($res['follow_swi'])) { ?>checked<?php  } ?>>
                开启
            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg control-label">诱导分享模式</label>
        <div class="col-sm-9 col-xs-12">
            <label class="checkbox-inline">
                <input type="checkbox" name="sharestyle" value="1" aria-invalid="false" class="valid" onclick="check()" id="sharestyle" <?php  if(!empty($res['sharestyle'])) { ?>checked<?php  } ?>> 开启
            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg control-label">砍价活动参与榜</label>
        <div class="col-sm-9 col-xs-12">
            <label class="checkbox-inline">
                <input type="checkbox" name="bang_swi" value="1" aria-invalid="false" class="valid" onclick="check()" id="bang" <?php  if($res['partin']>-10000) { ?>checked<?php  } ?>>
                开启
            </label>
        </div>
    </div>
    <div class="form-group" id="partin" style="display: none">
        <label class="col-lg control-label">砍掉多少可以上榜</label>
        <div class="col-sm-9 col-xs-12" style="width: 200px">
            <input type="number" name="money_limit" class="form-control" value="<?php  echo $res['partin'];?>" placeholder="单位:元(含)" required>
        </div>
    </div>
    <script>
        check();
        function check() {
            var res = document.getElementById("bang").checked;
            if(res){
                document.getElementById("partin").style.display = "block";
            }else{
                document.getElementById("partin").style.display = "none";
            }
        }
    </script>

    <div class="form-group">
        <label class="col-lg control-label">全局砍价规则设置</label>
        <div class="col-sm-9 col-xs-12">
            <?php  echo tpl_ueditor('rule',$res['rule']);?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label"></label>
        <div class="col-sm-9 col-xs-12">
            <input type="submit" value="保存" class="btn btn-primary">
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
        </div>
    </div>
</form>
</div>
</body>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
