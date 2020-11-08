$(function(){

    $('button.navbar-toggler').click(function(){
        if( $(this).attr('data-target') === '#sidebar')
        {
            $(this).toggleClass("menu-lines-click");
            $('.main-panel').fadeToggle('slow');
        }
    });

    $('#mensajes').on('click', function(){
        globalReset();
        checkModal();
        $('#panel-mensajes').css('display','block');
        $('#panel-mensajes-close').on('click', function(){
            $('#panel-mensajes').attr('style','display:none');
        })
    });

    $('#configuracion').on('click', function(){
        globalReset();
        checkModal();
        $('#panel-configuracion').css('display','block');
        $('#panel-configuracion-close').on('click', function(){
            $('#panel-configuracion').attr('style','display:none');
        })
    });

    $('#reportes').on('click', function(){
        globalReset();
        checkModal();
        $('#panel-reportes').css('display','block');
        $('#panel-reportes-close').on('click', function(){
            $('#panel-reportes').attr('style','display:none');
        })
    });

    $('#usuarios').on('click', function(){
        globalReset();
        checkModal();
        $('#panel-usuarios').css('display','block');
        $('#panel-usuarios-close').on('click', function(){
            $('#panel-usuarios').attr('style','display:none');
        })
    });

    $('#contratos').on('click', function(){
        globalReset();
        checkModal();
        $('#panel-contratos').css('display','block');
        $('#panel-contratos-close').on('click', function(){
            $('#panel-contratos').attr('style','display:none');
        })
    });

    $('#empresas').on('click', function(){
        globalReset();
        checkModal();
        $('#panel-empresas').css('display','block');
        $('#panel-empresas-close').on('click', function(){
            $('#panel-empresas').attr('style','display:none');
        });
    });

    var globalReset = function()
    {
        $('.main-panel').each(function(){
            $('.active').removeClass('active');
        });
    }

    var checkModal = function()
    {
        if($('#sidebar').css('display') === 'block' && $(window).width() < 768)
        {
            $('button.navbar-toggler').click();
        }
        $('.main-panel').children().each(function(){
            if($(this).hasClass('modal-panel-bg') && $(this).css('display') === "block")
            {
                $(this).css('display', 'none');
            }
        });
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
        var vh;// = ($(window).innerHeight() - $('nav').innerHeight()) * 0.01;

        var mh;
        if($(window).width() < 768)
        {
            var vh = ($(window).innerHeight() - $('nav').innerHeight()) * 0.01;
            var mh = ($(window).innerHeight() - ($('nav').innerHeight()*2)) * 0.01;
        }
        else
        {
            var vh = $(window).innerHeight() * 0.01;
            var mh = ($(window).innerHeight() - 80) * 0.01;
        }
     
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