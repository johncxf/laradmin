$(function(){
    $("nav ul li a").click(function () {
        $('nav ul li a').each(function () {
            $(this).removeClass('active');
        });
        let level = $(this).attr('data-menu-level');
        if (level !== '0') {
            $(this).addClass('active');
            if ($(this).parent().parent().parent().hasClass('has-treeview') === true) {
                $(this).parent().parent().siblings().addClass('active');
            }
        }
    });

    let current = $('nav ul li:not(.has-treeview) > a');
    current.click(function () {
        let i = current.index(this);
        if ($(this).attr('data-menu-level') === '0') {
            sessionStorage.setItem('current_menu_index', '0');
        } else {
            $(this).addClass('active');
            sessionStorage.setItem('current_menu_index',i);
        }
    });
    let currentMenuIndex = sessionStorage.getItem('current_menu_index');
    if (currentMenuIndex !== '0') {
        current.eq(currentMenuIndex).addClass('active');
        let current_level = current.eq(currentMenuIndex).attr('data-menu-level');

        if (current_level === '2') {
            current.eq(currentMenuIndex).parent().parent().siblings('a').addClass('active');
            current.eq(currentMenuIndex).parent().parent().parent().addClass('menu-open');
        } else if (current_level === '3') {
            // current.eq(currentMenuIndex).parent().parent().siblings('a').addClass('active');
            current.eq(currentMenuIndex).parent().parent().parent().addClass('menu-open');

            current.eq(currentMenuIndex).parent().parent().parent().parent().siblings('a').addClass('active');
            current.eq(currentMenuIndex).parent().parent().parent().parent().parent().addClass('menu-open');
        } else {
            return false;
        }
    }

});