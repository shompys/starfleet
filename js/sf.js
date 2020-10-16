$(function(){

    $('button.navbar-toggler').click(function(){
        if( $(this).attr('data-target') === '#sidebar')
        {
            $(this).toggleClass("menu-lines-click");
            $('.main-panel').fadeToggle('slow');
        }
    });

    $('#usuarios').on('click', function(){
        globalReset();
        $('#panel-usuarios').css('z-index', checkModal).css('display','block');
        $('#panel-usuarios-close').on('click', function(){
            $('#panel-usuarios').attr('style','display:none');
        })
    });
    
    $('#informes').on('click', function(){
        globalReset();
        $('#panel-informes').css('z-index', checkModal).css('display','block');
        $('#panel-informes-close').on('click', function(){
            $('#panel-informes').attr('style','display:none');
        })
    });

    var globalReset = function()
    {
        $('.main-panel').each(function(){
            $('.active').removeClass('active');
            //$('input').val('');
        });
    }

    var checkModal = function()
    {
        var zindex = 0;
        if($('#sidebar').css('display') === 'block' && $(window).width() < 768)
        {
            $('button.navbar-toggler').click();
        }
        $('.main-panel').children().each(function(){
            if($(this).hasClass('modal-panel-bg') && $(this).css('display') === "block")
            {
                zindex = parseInt($(this).css('z-index')) + 1;
            }
            else
            {
                zindex = 9999;
            }
        });
        return zindex;
    }

    $('.main-panel .dropdown-item').on('click', function(){
        var href = $(this).attr('href');
        $('.main-panel .nav-link').each(function(){ 
            if($(this).attr('href') === href)
            {
                $('.active').removeClass('active');
                $(this).addClass('active');
            }
        });
    });

    $('.main-panel .nav-link').on('click', function(){
        var href = $(this).attr('href');
        $('.main-panel .dropdown-item').each(function(){ 
            if($(this).attr('href') === href)
            {
                $('.active').removeClass('active');
                $(this).addClass('active');
            }
        });
    });

    /* Fix Panel Height - Test */
    fixHeight();
    function fixHeight()
    {
        var body = $(window).innerHeight() * 0.01;
        var vh = ($(window).innerHeight() - $('nav').innerHeight()) * 0.01;
        var mh = ($(window).innerHeight() - ($('nav').innerHeight()*2)) * 0.01;
        $('body').attr('style','--bodyHeight:' + body + 'px');
        $('.profile-sidebar').attr('style','--sidebarHeight:' + vh + 'px');
        $('.main-panel').attr('style','--panelHeight:' + vh + 'px');
        $('.form-height').attr('style','--formHeight:' + mh + 'px');
    }
    /* Fix Panel Height - Test */

    $(window).on('resize', function(){
        setTimeout(function(){
            fixHeight();
        }, 100);
    });
    


});