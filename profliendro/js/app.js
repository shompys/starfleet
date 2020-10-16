$(function(){

    $(this).scrollTop(0);

    $('a.nav-link').on('click', function(e){

        if($('#navbarCollapse').css('display') === 'block' && $(window).width() < 768)
        {
            $('button.navbar-toggler').click();
        }
        
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname)
        {
            var target = $(this.hash);
            
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

            if (target.length)
            {
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 79
                }, 1000);
                return false;
            }
        }

    });

    $('#top').on('click', function(){
        $("html, body").stop().animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('button.navbar-toggler').on('click', function(){
        if($(this).attr('data-target') === '#navbarCollapse')
        {
            $(this).toggleClass("menu-lines-click");
        }
    });

    $('body').scrollspy({
        target: '.navbar',
        offset: 80,
    });

    /* Auto Height CArousel Fix - Ok! */
    autoHeight();
    function autoHeight()
    {
        var vh = ($(window).innerHeight() - $('nav').innerHeight()) * 0.01;
        $('.carousel').attr('style','--carouselHeight:' + vh + 'px');
    }
    $(window).on('resize', function(){
        setTimeout(function(){
            autoHeight();
        }, 100);
    });
    /* Auto Height CArousel Fix - Ok! */

});