<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-heading"><h2>系统授权 </h2></div>





<form action="" method="post" class="form-horizontal form-validate" enctype="multipart/form-data" >



    <div class="form-group">

        <label class="col-sm-2 control-label">域名</label>

        <div class="col-sm-9 col-xs-12">

            <input type="text" name="domain" class="form-control" value="<?php  echo $domain;?>" readonly/>

            <span class="help-block">服务器域名</span>

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2 control-label">站点IP</label>

        <div class="col-sm-9 col-xs-12">

            <input type="text" name="ip" class="form-control" value="<?php  echo $ip;?>" readonly/>

            <span class="help-block">站点IP</span>

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2 control-label">站点ID</label>

        <div class="col-sm-9 col-xs-12">

            <input type="text" name="id" class="form-control" value="<?php  echo $id;?>" readonly/>

            <span class="help-block">站点ID,绑定您的服务器</span>

        </div>

    </div>


    <div class="form-group">

        <label class="col-sm-2 control-label">授权状态</label>

        <div class="col-sm-9 col-xs-12">

            <div class='form-control-static'>

                <?php  if(!empty($result['status'])) { ?>

                <span class='label label-primary'>已授权</span>

                <?php  } else if($status==0) { ?>

                <span class='label label-danger'>已授权</span>

                <?php  } ?>

            </div>

        </div>

		
    <div class="form-group">

        <label class="col-sm-2 control-label">授权来自</label>

        <div class="col-sm-9 col-xs-12">

            <div class='form-control-static'>

                <?php  if(!empty($result['status'])) { ?>

                <span class='label label-primary'>开吧源码社区www.k8ym.com</span>

                <?php  } else if($status==0) { ?>

                <span class='label label-danger'>开吧源码社区www.k8ym.com</span>

                <?php  } ?>

            </div>

        </div>
		
    </div>

            </div>

        </div>

    </div>

</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>