$(window).on('load', function(){
    setTimeout(function(){
        $('.loader').fadeOut('slow', function(){
            $(this).remove();
        });
    },5000);
});