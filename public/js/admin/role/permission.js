var ajaxForm_list = $('form.js-ajax-form');
if (ajaxForm_list.length) {
    Wind.use('ajaxForm', 'artDialog', function () {
        if ($.support.msie) {
            //ie8及以下，表单中只有一个可见的input:text时，会整个页面会跳转提交
            ajaxForm_list.on('submit', function (e) {
                //表单中只有一个可见的input:text时，enter提交无效
                e.preventDefault();
            });
        }

        $('button.js-ajax-submit').bind('click', function (e) {
            e.preventDefault();
            var btn = $(this),
                form = btn.parents('form.js-ajax-form');

            //批量操作 判断选项
            if (btn.data('subcheck')) {
                btn.parent().find('span').remove();
                if (form.find('input.js-check:checked').length) {
                    var msg = btn.data('msg');
                    if (msg) {
                        art.dialog({
                            id: 'warning',
                            icon: 'warning',
                            content: btn.data('msg'),
                            cancelVal: "关闭",
                            cancel: function () {
                                btn.data('subcheck', false);
                                btn.click();
                            }
                        });
                    } else {
                        btn.data('subcheck', false);
                        btn.click();
                    }

                } else {
                    $('<span class="tips_error">请至少选择一项</span>').appendTo(btn.parent()).fadeIn('fast');
                }
                return false;
            }

            //ie处理placeholder提交问题
            if ($.browser.msie) {
                form.find('[placeholder]').each(function () {
                    var input = $(this);
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                });
            }
            // 请求
            form.ajaxSubmit({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: btn.data('action') ? btn.data('action') : form.attr('action'),
                // 按钮上是否自定义提交地址(多按钮情况)
                dataType: 'json',
                beforeSubmit: function (arr, $form, options) {
                    var text = btn.text();
                    // 按钮文案、状态修改
                    btn.text(text + '中...').attr('disabled', true).addClass('disabled');
                },
                success: function (data, statusText, xhr, $form) {
                    var text = btn.text();

                    // 按钮文案、状态修改
                    btn.removeClass('disabled').text(text.replace('中...', '')).parent().find('span').remove();
                    if (data.state === 'success') {
                        $('<span class="tips_success">' + data.info + '</span>').appendTo(btn.parent()).fadeIn('slow').delay(1000).fadeOut(function () {
                            if (data.referer) {
                                //返回带跳转地址
                                if (window.parent.art) {
                                    //iframe弹出页
                                    window.parent.location.href = data.referer;
                                } else {
                                    window.location.href = data.referer;
                                }
                            } else {
                                if (window.parent.art) {
                                    reloadPage(window.parent);
                                } else {
                                    //刷新当前页
                                    reloadPage(window);
                                }
                            }
                        });
                    } else if (data.state === 'fail') {
                        $('<span class="tips_error">' + data.info + '</span>').appendTo(btn.parent()).fadeIn('fast');
                        btn.removeProp('disabled').removeClass('disabled');
                    }
                }
            });
        });

    });
}
// 树形菜单
$(document).ready(function () {
    Wind.css('treeTable');
    Wind.use('treeTable', function () {
        $("#dnd-example").treeTable({
            indent: 20,
            // initialState: 'expanded'
        });
    });
});
//重新刷新页面，使用location.reload()有可能导致重新提交
function reloadPage(win) {
    var location = win.location;
    location.href = location.pathname + location.search;
}
// 复选框勾选事件
function checknode(obj) {
    var chk = $("input[type='checkbox']");
    var count = chk.length;
    var num = chk.index(obj);

    var level_top = level_bottom = chk.eq(num).attr('level');
    // 向上遍历勾选
    for (let i = num; i >= 0; i--) {
        let le = chk.eq(i).attr('level');
        if (eval(le) < eval(level_top)) {
            chk.eq(i).attr("checked", true);
            level_top = level_top - 1;
        }
    }
    // 向下遍历勾选
    for (let j = num + 1; j < count; j++) {
        let le = chk.eq(j).attr('level');
        if (chk.eq(num).attr("checked") == "checked") {
            if (eval(le) > eval(level_bottom)){
                chk.eq(j).attr("checked", true);
            } else if (eval(le) == eval(level_bottom)){
                break;
            }
        } else {
            if (eval(le) > eval(level_bottom)){
                chk.eq(j).attr("checked", false);
            } else if(eval(le) == eval(level_bottom)){
                break;
            }
        }
    }
}