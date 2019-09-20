define(['core', 'tpl'], function (core, tpl) {
    var modal = {gift_groups: []};
    var giftPlusPicker = function (params) {
        var self = this;
        self.params = $.extend({}, params || {});
        self.data = {gift_groups: self.params.gift_groups};
        self.show = function () {
            if (self.data.gift_groups !== modal.gift_groups) {
                modal.pickerHTML = tpl('tpl_get-gift-plus', self.data)
            }
            modal.gift_groups = self.data.gift_groups;
            modal.picker = new FoxUIModal({
                content: modal.pickerHTML,
                extraClass: 'picker-modal',
                maskClick: function () {
                    modal.picker.close();
                }
            });

            modal.picker.container.find('.gift-plus-picker').height($(document.body).height() * 0.6).css('max-height', 'none');

            modal.picker.show();

            $('.gift-plus-picker').find('.btn-selected').click(function () {

                var id = $(this).data('id');
                var type = $(this).data('type');
                $('#gift-group-title').text($(this).data('title'));
                $('#gift_group_id').val(id);
                $('#gift_group_type').val(type);

                modal.picker.close();
            });
            $('.gift-plus-picker').find('.btn-cancel').click(function () {
                modal.picker.close();
            });

            // tab切换
            modal.picker.container.find('.gift-plus-picker .tab').click(function () {
                var _tab = $(this).data('tab'),
                    _content = $('.tab-content[data-content=' + _tab + ']');

                modal.picker.container.find('.gift-plus-picker .tab').removeClass('active');
                modal.picker.container.find('.gift-plus-picker .tab-content').removeClass('active');

                $(this).addClass('active');
                $(_content).addClass('active');
            })
        };
    };
    modal.show = function (params) {
        var picker = new giftPlusPicker(params);
        picker.show();
    };

    return modal
});