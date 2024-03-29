<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mmanage/common', TEMPLATE_INCLUDEPATH)) : (include template('mmanage/common', TEMPLATE_INCLUDEPATH));?>

<div class='fui-page fui-page-current'>
    <div class="fui-header fui-header-success">
        <div class="fui-header-left">
            <a class="back btn-back">返回</a>
            <a class="btn-cancel cancel-params">取消</a>
        </div>
        <div class="title"><?php  if(!empty($item)) { ?>商品编辑<?php  } else { ?>添加商品<?php  } ?></div>
        <div class="fui-header-right"></div>
    </div>
    <div class='fui-content navbar'>

        <input type="hidden" id="id" value="<?php  echo $item['id'];?>" />
        <input type="hidden" id="type" value="<?php  echo $item['type'];?>" />
        <input type="hidden" id="cates" value="<?php  echo $item['cates'];?>" />
        <input type="hidden" id="hasoption" value="<?php  echo $item['hasoption'];?>" />
        <input type="hidden" id="totalcnf" value="<?php  echo $item['totalcnf'];?>" />
        <input type="hidden" id="showlevels" value="<?php  echo $item['showlevels'];?>" />
        <input type="hidden" id="showgroups" value="<?php  echo $item['showgroups'];?>" />
        <input type="hidden" id="buylevels" value="<?php  echo $item['buylevels'];?>" />
        <input type="hidden" id="buygroups" value="<?php  echo $item['buygroups'];?>" />

        <input type="hidden" id="diypage" value="<?php  echo $item['diypage'];?>" />
        <input type="hidden" id="diyformid" value="<?php  echo $item['diyformid'];?>" />

        <?php  if(!empty($merch_user)) { ?>
            <div class="fui-title">商品所属: <?php  echo $merch_user['merchname'];?></div>
        <?php  } ?>

        <div class="fui-cell-group">
            <div class="fui-cell fui-cell-textarea">
                <div class="fui-cell-label ">商品名称</div>
                <div class="fui-cell-info">
                    <textarea rows="3" placeholder="请输入商品名称" id="title"><?php  echo $item['title'];?></textarea>
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">副标题</div>
                <div class="fui-cell-info">
                    <input type="text" placeholder="请输入商品副标题" class="fui-input" value="<?php  echo $item['subtitle'];?>" id="subtitle" />
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">单位</div>
                <div class="fui-cell-info">
                    <input type="text" placeholder="请输入商品单位" class="fui-input" value="<?php  echo $item['unit'];?>" id="unit" />
                </div>
            </div>
        </div>
        <div class="fui-cell-group">
            <div class="fui-cell borderb noactive">
                <div class="fui-cell-info">
                    <ul class="fui-images" id="thumbs">
                        <?php  if(is_array($piclist)) { foreach($piclist as $picitem) { ?>
                            <li style="background-image:url(<?php  echo tomedia($picitem)?>)" class="image" data-filename="<?php  echo $picitem;?>">
                                <span class="image-remove"><i class="icon icon-close"></i></span>
                            </li>
                        <?php  } } ?>
                    </ul>
                    <div class="fui-uploader" data-count="<?php  echo count($piclist)?>" data-max="10" data-name="images[]" <?php  if(count($piclist)>=10) { ?>style="display: none;"<?php  } ?>>
                        <input type="file" name='imgFile0[]' id='imgFile0' multiple="" accept="image/*" >
                    </div>
                </div>
            </div>
            <div class="fui-title">首张图片为商品主图(拖拽可排序)</div>
        </div>

        <div class="fui-cell-group fui-cell-click" id="thumbs3">
            <?php  if(empty($item)) { ?>
                <div class="fui-cell check-param" data-action="type" id="sss">
                    <div class="fui-cell-label">商品类型</div>
                    <div class="fui-cell-info"><?php  echo $type_title;?></div>
                    <div class="fui-cell-remark"></div>
                </div>
            <?php  } else { ?>
                <div class="fui-cell noactive">
                    <div class="fui-cell-label">商品类型</div>
                    <div class="fui-cell-info"><?php  echo $type_title;?></div>
                    <div class="fui-cell-remark noremark">不可修改</div>
                </div>
            <?php  } ?>
            <?php  if($catlevel!=-1) { ?>
                <div class="fui-cell check-param" data-action="cate">
                    <div class="fui-cell-label">商品分类</div>
                    <div class="fui-cell-info"><?php  echo $category_title;?></div>
                    <div class="fui-cell-remark"></div>
                </div>
            <?php  } ?>
            <div class="fui-cell check-param" data-action="prop">
                <div class="fui-cell-label">商品属性</div>
                <div class="fui-cell-info"><?php  echo $prop_title;?></div>
                <div class="fui-cell-remark">选择</div>
            </div>
        </div>

        <?php  if(!empty($item['hasoption'])) { ?>
            <div class="fui-title">多规格商品PC可编辑</div>
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-text">商品规格</div>
                    <div class="fui-cell-remark noremark">请至PC端查看</div>
                </div>
            </div>
        <?php  } else { ?>
        <?php  if(empty($item)) { ?>
            <div class="fui-title">多规格商品PC可添加</div>
        <?php  } ?>
        <div class="fui-cell-group">
            <div class="fui-cell">
                <div class="fui-cell-label">原价</div>
                <div class="fui-cell-info">
                    <input type="number" placeholder="请输入商品原价" class="fui-input" value="<?php echo empty($item['productprice'])?0:$item['productprice']?>" id="productprice" />
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">现价</div>
                <div class="fui-cell-info">
                    <input type="number" placeholder="请输入现价" class="fui-input" value="<?php echo empty($item['marketprice'])?0:$item['marketprice']?>" id="marketprice" />
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">成本价</div>
                <div class="fui-cell-info">
                    <input type="number" placeholder="请输入商品成本价" class="fui-input" value="<?php echo empty($item['costprice'])?0:$item['costprice']?>" id="costprice" />
                </div>
            </div>
        </div>
        <div class="fui-cell-group fui-cell-click">
            <div class="fui-cell noactive">
                <div class="fui-cell-label">库存</div>
                <?php  if(empty($item['hasoption'])) { ?>
                    <div class="fui-cell-info">
                        <input type="tel" placeholder="请输入商品呢库存" class="fui-input" value="<?php  echo intval($item['total'])?>" id="total" />
                    </div>
                <?php  } else { ?>
                    <div class="fui-cell-info"><?php  echo $item['total'];?></div>
                    <div class="fui-cell-remark noremark">不可编辑</div>
                <?php  } ?>
            </div>
            <div class="fui-cell check-param" data-action="totalcnf">
                <div class="fui-cell-text">库存设置</div>
                <div class="fui-cell-remark"><?php  echo $totalcnf_title;?></div>
            </div>
            <div class="fui-cell noactive">
                <div class="fui-cell-label ">显示库存</div>
                <div class="fui-cell-info"><input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="showtotal" <?php  if(!empty($item['showtotal'])) { ?>checked="checked"<?php  } ?>></div>
            </div>
            <?php  if(empty($item['hasoption'])) { ?>
                <div class="fui-cell">
                    <div class="fui-cell-label">商品重量</div>
                    <div class="fui-cell-info">
                        <input type="number" placeholder="请输入商品重量" class="fui-input" value="<?php  echo $item['weight'];?>" id="weight" />
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">商品编码</div>
                    <div class="fui-cell-info">
                        <input type="number" placeholder="请输入商品编码" class="fui-input" value="<?php  echo $item['goodssn'];?>" id="goodssn" />
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">商品条码</div>
                    <div class="fui-cell-info">
                        <input type="number" placeholder="请输入商品条码" class="fui-input" value="<?php  echo $item['productsn'];?>" id="productsn" />
                    </div>
                </div>
            <?php  } ?>
        </div>
        <?php  } ?>

        <div class="fui-title">浏览权限</div>
        <div class="fui-cell-group fui-cell-click">
            <div class="fui-cell check-param" data-action="viewlevel">
                <div class="fui-cell-label">会员等级</div>
                <div class="fui-cell-info"><?php  echo $viewlevel_title;?></div>
                <div class="fui-cell-remark"></div>
            </div>
            <div class="fui-cell check-param" data-action="viewgroup">
                <div class="fui-cell-label">会员分组</div>
                <div class="fui-cell-info"><?php  echo $viewgroup_title;?></div>
                <div class="fui-cell-remark"></div>
            </div>
        </div>

        <div class="fui-title">购买权限</div>
        <div class="fui-cell-group fui-cell-click">
            <div class="fui-cell check-param" data-action="buylevel">
                <div class="fui-cell-label">会员等级</div>
                <div class="fui-cell-info"><?php  echo $buylevel_title;?></div>
                <div class="fui-cell-remark"></div>
            </div>
            <div class="fui-cell check-param" data-action="buygroup">
                <div class="fui-cell-label">会员分组</div>
                <div class="fui-cell-info"><?php  echo $buygroup_title;?></div>
                <div class="fui-cell-remark"></div>
            </div>
        </div>
        <div class="fui-title">商品限购(0为不限)</div>
        <div class="fui-cell-group fui-cell-click">
            <div class="fui-cell">
                <div class="fui-cell-label">单次最多购</div>
                <div class="fui-cell-info">
                    <input type="number" placeholder="单次最多购买数量" class="fui-input" value="<?php  echo intval($item['maxbuy'])?>" id="maxbuy" />
                </div>
                <div class="fui-cell-remark noremark">件</div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">单次最低购</div>
                <div class="fui-cell-info">
                    <input type="number" placeholder="单次最低购买数量" class="fui-input" value="<?php  echo intval($item['minbuy'])?>" id="minbuy" />
                </div>
                <div class="fui-cell-remark noremark">件</div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">会员总限购</div>
                <div class="fui-cell-info">
                    <input type="number" placeholder="会员总限购买数量" class="fui-input" value="<?php  echo intval($item['usermaxbuy'])?>" id="usermaxbuy" />
                </div>
                <div class="fui-cell-remark noremark">件</div>
            </div>
        </div>

        <div class="fui-cell-group fui-cell-click">
            <div class="fui-cell noactive">
                <div class="fui-cell-label ">会员折扣</div>
                <div class="fui-cell-info"><input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="isnodiscount" <?php  if(empty($item['isnodiscount'])) { ?>checked="checked"<?php  } ?>></div>
            </div>
            <div class="fui-cell noactive">
                <div class="fui-cell-label ">参与分销</div>
                <div class="fui-cell-info"><input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="nocommission" <?php  if(empty($item['nocommission'])) { ?>checked="checked"<?php  } ?>></div>
            </div>
            <?php  if(p('diyform')) { ?>
                <?php  if(!empty($diyform) || $item['diyformtype']==2) { ?>
                    <?php  if($item['diyformtype']==2) { ?>
                        <div class="fui-cell">
                            <div class="fui-cell-label">表单选择</div>
                            <div class="fui-cell-info">商品自定义</div>
                            <div class="fui-cell-remark noremark">PC可编辑</div>
                        </div>
                    <?php  } else if(!empty($diyform)) { ?>
                        <div class="fui-cell check-param" data-action="diyform">
                            <div class="fui-cell-label">表单选择</div>
                            <div class="fui-cell-info"><?php  echo $diyform_title;?></div>
                            <div class="fui-cell-remark"></div>
                        </div>
                    <?php  } ?>
                <?php  } ?>
            <?php  } ?>
            <?php  if($diypage) { ?>
                <div class="fui-cell check-param" data-action="diypage">
                    <div class="fui-cell-label">模板选择</div>
                    <div class="fui-cell-info"><?php  echo $diypage_title;?></div>
                    <div class="fui-cell-remark"></div>
                </div>
            <?php  } ?>
        </div>

        <div class="fui-cell-group">
            <div class="fui-cell ">
                <div class="fui-cell-label ">货到付款</div>
                <div class="fui-cell-info"><input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="cash" <?php  if($item['cash']==2) { ?>checked="checked"<?php  } ?>></div>
            </div>
            <div class="fui-cell ">
                <div class="fui-cell-label ">发票</div>
                <div class="fui-cell-info"><input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="invoice" <?php  if(!empty($item['invoice'])) { ?>checked="checked"<?php  } ?>></div>
            </div>
        </div>


        <div class="fui-cell-group fui-cell-click">
            <div class="fui-cell check-param" data-action="dispatch">
                <div class="fui-cell-label">运费设置</div>
                <div class="fui-cell-info"><?php  echo $dispatch_title;?></div>
                <div class="fui-cell-remark"></div>
            </div>
        </div>

        <div class="fui-cell-group fui-cell-click">
            <div class="fui-cell noactive">
                <div class="fui-cell-label ">商品上架</div>
                <div class="fui-cell-info"><input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="status" <?php  if(!empty($item['status'])) { ?>checked="checked"<?php  } ?>></div>
            </div>
        </div>

        <div class="fui-cell-group">
            <div class="fui-cell">
                <div class="fui-cell-label">商品排序</div>
                <div class="fui-cell-info">
                    <input type="number" placeholder="数字越大，排名越靠前" class="fui-input" value="<?php  echo $item['displayorder'];?>" id="displayorder" />
                </div>
            </div>
        </div>

        <div class="fui-title center">更多设置请至PC端后台</div>

    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mmanage/_tpl/goods_params', TEMPLATE_INCLUDEPATH)) : (include template('mmanage/_tpl/goods_params', TEMPLATE_INCLUDEPATH));?>

    <div class="fui-navbar">
        <div class="nav-item btn btn-success btn-submit">保存</div>
    </div>

    <script language="javascript">
        require(['../addons/ewei_shopv2/plugin/mmanage/static/js/goods-detail.js'],function(modal){
            modal.initDetail({category: <?php  echo $category_json;?>});
        });
    </script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
