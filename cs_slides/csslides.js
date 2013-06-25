//Thanks HEAPS to CSS Tricks - http://css-tricks.com/snippets/jquery/simple-auto-playing-slideshow/
jQuery(document).ready(function($) {
    $("#cs_slides > div:gt(0)").hide();
    $('#cs_slides > div:first').addClass('active');
    
    setInterval(function() { 
      $('#cs_slides > div:first')
        .fadeOut(1500).removeClass('active')
        .next()
        .fadeIn(1500).addClass('active')
        .end()
        .appendTo('#cs_slides');
        $('.csslide_nav li').removeClass('active')
        $slideNumber = '.csslide_nav .' + $('#cs_slides .active').attr('id');
        $($slideNumber).addClass('active');
    },  8000);
    
    $('.csslide_nav a').click(function(e){
        e.preventDefault();
        $slideNumber = $(this).attr('href');
        $('#cs_slides .active').fadeOut(1500).removeClass('active');
        $($slideNumber).fadeIn(1500).addClass('active');
    });
});