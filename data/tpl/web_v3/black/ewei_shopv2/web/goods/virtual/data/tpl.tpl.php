<?php defined('IN_IA') or exit('Access Denied');?><?php  if (!empty($num)) {
    for($i=1;$i<=$num;$i++) {
?>
        <tr>
            <?php  if(is_array($item['fields'])) { foreach($item['fields'] as $key => $name) { ?>
                <td>
                    <div class="input-group autotc" style="width:100%;">
                        <input type="text" name="tp_value_<?php  echo $key;?>[]" class="form-control count" value="" placeholder="请填写 <?php  echo $name;?>" <?php  if($key=='key') { ?>mk="1"<?php  } ?> />
                        <?php  if($key=='key') { ?>
                        <div class="input-group-btn" style="display: none">
                            <a class='btn btn-default btn-sm btn-add-type' style="float: right;" href="javascript:;" onclick='autonum(this)' >自动填充 <i class="fa fa-angle-double-down"></i></a>
                        </div>
                        <?php  } ?>
                    </div>
                </td>
            <?php  } } ?>
            <td>
                <a class="btn btn-default btn-op btn-operation" href="javascript:;" title="删除" onclick="removeType(this)">
                    <span data-toggle="tooltip" data-placement="top" data-original-title="删除">
                        <i class="icow icow-shanchu1"></i>
                    </span>
                </a>
            </td>
             <input type="hidden" name="tp_id[]" value="" />
        </tr>
<?php  } } else { ?>
            <tr>
                    <?php  $data['fields'] = iunserializer($data['fields']) ?>
                    <?php  if(!empty($data['edit'])) { ?>
                        <?php  if(is_array($data['fields'])) { foreach($data['fields'] as $k=>$v) { ?>
                            <td>
                                <div class="input-group autotc" style="width:100%;">
                                    <input type="text" name="tp_value_<?php  echo $k;?>[]" class="form-control count" value="<?php  echo $v;?>" placeholder="" <?php  if($kk=='key') { ?>mk="1"<?php  } ?> />
                                    <?php  if($key=='key') { ?>
                                    <div class="input-group-btn" style="display:none">
                                        <a class='btn btn-default btn-sm btn-add-type' style="float: right;" href="javascript:;" onclick='autonum(this)' >自动填充 <i class="fa fa-angle-double-down"></i></a>
                                    </div>
                                    <?php  } ?>
                                </div>
                            </td>
                        <?php  } } ?> 
                    <?php  } else { ?>
                         <?php  if(is_array($item['fields'])) { foreach($item['fields'] as $key => $name) { ?>
                            <td>
                                <div class="input-group autotc" style="width:100%;">
                                    <input type="text" name="tp_value_<?php  echo $key;?>[]" class="form-control count" value="" placeholder="请填写 <?php  echo $name;?>" <?php  if($key=='key') { ?>mk="1"<?php  } ?> />
                                    <?php  if($key=='key') { ?>
                                    <div class="input-group-btn"  style="display: none">
                                        <a class='btn btn-default btn-sm btn-add-type' style="float: right;" href="javascript:;" onclick='autonum(this)' >自动填充 <i class="fa fa-angle-double-down"></i></a>
                                    </div>
                                    <?php  } ?>
                                </div>
                            </td>
                        <?php  } } ?>
                    <?php  } ?> 

               <td>禁止<br>删除</td>
               <input type="hidden" name="tp_id[]" value="<?php  echo $data['id'];?>" />
           </tr>
<?php  } ?>   

