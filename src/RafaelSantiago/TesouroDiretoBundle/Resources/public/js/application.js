// ------------------------------
// On submit
// ------------------------------

$(function() {
    $('form [type="submit"]').click(function() {
        $(this).parents('form').addClass('validate');
    });
});

//-------------------------------
// Campos de Data
//-------------------------------

$(function(){
    $('.datepicker').datepicker({
        format: 'DD/MM/YYYY'
    });
})

// ------------------------------
// Pagination
// ------------------------------
$(function(){
    $('#pageGoTo').on('change', function(){
        document.location = $(this).val();
    });
})

// ------------------------------
// On delete
// ------------------------------
$(function() {

    $(document).on('click', '[data-action="delete"]', function(e) {
        //event.stopPropagation();
        e.preventDefault();
        var link = $(this).data('href');
        bootbox.confirm("Você tem certeza de que realmente deseja excluir este registro?", function(result) {
            if (result == true) {
                window.location = link;
            }
        });
    });
    $(document).on('click', '[data-action="change-password"]', function(e) {
        //event.stopPropagation();
        e.preventDefault();
        var link = $(this).data('href');
        bootbox.confirm("Deseja realmente alterar a senha para este usuário? Será gerada uma nova senha aleatória e mostrada na próxima tela.", function(result) {
            if (result == true) {
                window.location = link;
            }
        });
    });
    $(document).on('click', '[data-action="delete-departamento"]', function(e) {
        //event.stopPropagation();
        e.preventDefault();
        var link = $(this).data('href');
        bootbox.confirm("<span class='text-danger'><strong>Atenção: Ao excluir o departamento todos os arquivos vinculados ao mesmo serão excluidos.</strong></span><br/><br/>Você tem certeza de que realmente deseja excluir este registro?", function(result) {
            if (result == true) {
                window.location = link;
            }
        });
    });
})

// ------------------------------
// Toggle
// ------------------------------
$(function() {

    var optDefault = {
        text: {
            on: $toggle_on,
            off: $toggle_off
        },
        width: 60,
        height: 22
    };

    $('.toggle.on').toggles($.extend({'on': true}, optDefault));
    $('.toggle.off').toggles($.extend({'on': false}, optDefault));

    // Getting notified of changes, and the new state:
    $('.toggle').on('toggle', function(e, active) {
        varPath = $(this).data('path');
        var param = {
            id: $(this).data('id'),
            object: $(this).data('object'),
            method: $(this).data('method'),
            value: active
        };
        $.post(varPath, param);
    });
})

// ------------------------------
// Sidebar Accordion Menu
// ------------------------------

$(function() {

    if ($.cookie('admin_leftbar_collapse') === 'collapse-leftbar') {
        $('body').addClass('collapse-leftbar');
    } else {
        $('body').removeClass('collapse-leftbar');
    }

    $('body').on('click', 'ul.acc-menu a', function() {
        var LIs = $(this).closest('ul.acc-menu').children('li');
        $(this).closest('li').addClass('clicked');
        $.each(LIs, function(i) {
            if ($(LIs[i]).hasClass('clicked')) {
                $(LIs[i]).removeClass('clicked');
                return true;
            }
            if ($.cookie('admin_leftbar_collapse') !== 'collapse-leftbar' || $(this).parents('.acc-menu').length > 1)
                $(LIs[i]).find('ul.acc-menu:visible').slideToggle();
            $(LIs[i]).removeClass('open');
        });
        if ($(this).siblings('ul.acc-menu:visible').length > 0)
            $(this).closest('li').removeClass('open');
        else
            $(this).closest('li').addClass('open');
        if ($.cookie('admin_leftbar_collapse') !== 'collapse-leftbar' || $(this).parents('.acc-menu').length > 1)
            $(this).siblings('ul.acc-menu').slideToggle({
                duration: 200,
                progress: function() {
                    checkpageheight();
                }
            });
    });

    var targetAnchor;
    $.each($('ul.acc-menu a'), function() {
        //console.log(this.href);
        if (this.href == window.location) {
            targetAnchor = this;
            return false;
        }
    });

    var parent = $(targetAnchor).closest('li');
    while (true) {
        parent.addClass('active');
        parent.closest('ul.acc-menu').show().closest('li').addClass('open');
        parent = $(parent).parents('li').eq(0);
        if ($(parent).parents('ul.acc-menu').length <= 0)
            break;
    }

    var liHasUlChild = $('li').filter(function() {
        return $(this).find('ul.acc-menu').length;
    });
    $(liHasUlChild).addClass('hasChild');

    if ($.cookie('admin_leftbar_collapse') === 'collapse-leftbar') {
        $('ul.acc-menu:first ul.acc-menu').css('visibility', 'hidden');
    }
    $('ul.acc-menu:first > li').hover(function() {
        if ($.cookie('admin_leftbar_collapse') === 'collapse-leftbar')
            $(this).find('ul.acc-menu').css('visibility', '');
    }, function() {
        if ($.cookie('admin_leftbar_collapse') === 'collapse-leftbar')
            $(this).find('ul.acc-menu').css('visibility', 'hidden');
    });
});

// ------------------------------
//Toggle Buttons
// ------------------------------

// Reads Cookie for Collapsible Leftbar

// reads cookies with javascript.
// if($.cookie('admin_leftbar_collapse') === 'collapse-leftbar')
//     $("body").addClass("collapse-leftbar");

$(function() {
    //Make only visible area scrollable
    $("#widgetarea").css({"max-height": $("body").height()});
    //Bind widgetarea to nicescroll
    $("#widgetarea").niceScroll({horizrailenabled: false});

    //Autocollapse leftbar on <768px screens
    ww = $(window).width();
    $(window).resize(function() {
        widgetheight();
        ww = $(window).width();

        if (ww < 786) {
            $("body").removeClass("collapse-leftbar");
            $.removeCookie("admin_leftbar_collapse");
        } else {
            $("body").removeClass("show-leftbar");
        }
    });

    //On click of left menu
    $("a#leftmenu-trigger").click(function() {
        if (($(window).width()) < 786) {
            $("body").toggleClass("show-leftbar");
        } else {
            $("body").toggleClass("collapse-leftbar");

            //Sets Cookie for Toggle
            if ($.cookie('admin_leftbar_collapse') === 'collapse-leftbar') {
                $.cookie('admin_leftbar_collapse', '');
                $('ul.acc-menu').css('visibility', '');
                $(".box-logo").removeClass("hidden");
                $(".box-user").removeClass("hidden");
                $(".box-user-small").addClass("hidden");
            }
            else {
                $.each($('.acc-menu'), function() {
                    if ($(this).css('display') == 'none')
                        $(this).css('display', '');
                })

                $('ul.acc-menu:first ul.acc-menu').css('visibility', 'hidden');
                $(".box-logo").addClass("hidden");
                $(".box-user").addClass("hidden");
                $(".box-user-small").removeClass("hidden");
                $.cookie('admin_leftbar_collapse', 'collapse-leftbar');
            }
        }
    });

    // On click of right menu
    $("a#rightmenu-trigger").click(function() {
        $("body").toggleClass("show-rightbar");
        widgetheight();

        if ($.cookie('admin_rightbar_show') === 'show-rightbar')
            $.cookie('admin_rightbar_show', '');
        else
            $.cookie('admin_rightbar_show', 'show-rightbar');
    });

    checkpageheight();

});

// Recalculate widget area on a widget being shown
$(".widget-body").on('shown.bs.collapse', function() {
    widgetheight();
});

// Match page height with Sidebar Height
function checkpageheight() {
    sh = $("#page-leftbar").height();
    ch = $("#page-content").height();
    if (sh > ch){
        $("#page-content").css("min-height", sh + "px");
        $("#box-logo").css('display','none');
    }
}

// Recalculate widget area to area visible
function widgetheight() {
    $("#widgetarea").css({"max-height": $("body").height()});
    $("#widgetarea").getNiceScroll().resize();
}

// -------------------------------
// Rightbar Positionings
// -------------------------------

$(window).scroll(function() {
    $("#widgetarea").getNiceScroll().resize();
    $(".chathistory").getNiceScroll().resize();
    rightbarTopPos();
});

$(window).resize(function() {
    rightbarRightPos();
});
rightbarRightPos();

function rightbarTopPos() {
    var scr = $('body.static-header').scrollTop();

    if (scr < 41) {
        $('#page-rightbar').css('top', 40 - scr + 'px');
    } else {
        $('#page-rightbar').css('top', 0);
    }
}

function rightbarRightPos() {
    if ($('body').hasClass('fixed-layout')) {
        var $pc = $('#page-content');
        var ending_right = ($(window).width() - ($pc.offset().left + $pc.outerWidth()));
        if (ending_right < 0)
            ending_right = 0;
        $('#page-rightbar').css('right', ending_right);
    }
}

// -------------------------------
//Allow Swiping for Mobile Only
// -------------------------------

try {
    enquire.register("screen and (max-width: 768px)", {
        match: function() {
            // For less than 768px
            $(function() {
                //Enable swiping...
                $("body").swipe({
                    swipe: function(event, direction, distance, duration, fingerCount) {
                        if (direction == "right")
                            $("body").addClass("show-leftbar");
                        if (direction == "left")
                            $("body").removeClass("show-leftbar");
                    }
                });
                $('ul ul.acc-menu').css('visibility', '');
            });
        }
    });
}
catch (e) {
    //ignore errors for browsers who do't support match.media
}

// -------------------------------
// Back to Top button
// -------------------------------

$('#back-to-top').click(function() {
    $('body,html').animate({
        scrollTop: 0
    }, 500);
    return false;
});

// -------------------------------
// Panel Collapses
// -------------------------------
$('a.panel-collapse').click(function() {
    $(this).children().toggleClass("icon-chevron-down icon-chevron-up");
    $(this).closest(".panel-heading").next().toggleClass("in");
    $(this).closest(".panel-heading").toggleClass('rounded-bottom');
    return false;
});

// -------------------------------
// Quick Start
// -------------------------------
$('#headerbardropdown').click(function() {

    $('#headerbar').css('top', 0);
    return false;
});

$('#headerbardropdown').click(function(event) {
    $('html').one('click', function() {
        $('#headerbar').css('top', '-1000px');
    });

    event.stopPropagation();
});

//Presentational: set all panel-body with br0 if it has panel-footer
$(".panel-footer").prev().css("border-radius", "0");