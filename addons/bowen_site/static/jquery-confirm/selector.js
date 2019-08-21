/**对 jquery-confirm 的增强 */

//公众号选择器，接收数据回调的输入框必须设置id为uniacid和account_name
var choseAccount = $.confirm({
	lazyOpen: true,
	type: 'blue',
	title: '公众号/PC 选择器',
	content: '' + 
        '<form action="" class="formName" >' + 
            '<div class="form-group">' + 
                '<label></label>' + 
                '<input type="text" placeholder="请输入公众号/PC名称" class="name form-control" required />' + 
            '</div>' + 
            '<div id="select_account" class="input-group col-sm-12"></div>' + 
        '</form>',
	buttons: {
		formSubmit: {
			text: '搜索',
			btnClass: 'btn-blue',
			action: function() {
				var keyword = this.$content.find('.name').val();
				if (!keyword) {
					$.alert('请输入公众号或PC的名称');
					return false;
				}
				var obj = $('#select_account');

				obj.html('');
				$.post('./index.php?c=site&a=entry&m=bowen_site&do=web&r=selector.account', {
					keyword: keyword
				}, function(res) {
					if (res.errno == '0') {
						//obj.append('<div class="col-sm-6">Done!</div>');
						var items = res.data;
						for (var i = 0; i < items.length; i++) {
							obj.append("" + 
                                "<div class='col-sm-6'>" + 
                                    "<input type='text' class='form-control' value='[" + items[i].uniacid + "]" + items[i].name + "' onclick='$(\"#uniacid\").val(\"" + items[i].uniacid + "\");$(\"#account_name\").val(\"" + items[i].name + "\");choseAccount.close();' style='cursor: pointer;' readonly='true'>" + 
                                "</div>");
						}
					} else if (res.errno == '1') {
						$.dialog({
							title: '数据为空！',
							content: '没有搜索到能匹配到名称中带' + res.data.keyword + '的公众号或PC',
						});
					} else {
						obj.append('<div class="col-sm-6">Contact Fail!</div>');
					}
				}, "json");
				return false;
			}
		},
		'关闭': function() {
			//close
		},
	},
	onContentReady: function() {
		// bind to events
		var jc = this;
		this.$content.find('form').on('submit', function(e) {
			// if the user submits the form by pressing enter in the field.
			e.preventDefault();
			jc.$$formSubmit.trigger('click'); // reference the button and click it
		});
	},
	backgroundDismiss: true
});