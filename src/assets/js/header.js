"use strict"
$(document).ready(() => {
    $('.custom-navbar').click(() => {
        $('.main-menu ul').slideToggle(500);
    });
    $(window).on('resize', function(){
        if ( $(window).width() > 992 ) {
            $('.main-menu ul').removeAttr('style');
        }
    });
    $('#submenu').click(()=>{
        $('.main-menu li ul.sub-menu').css("display", "block");
    })

    $('#sub-menu-1').click(()=>{
        $('.main-menu li ul.sub-menu-1').css("display", "block");
    })


    window.onclick = function(event) {
        if (!event.target.matches('#submenu a')) {
            $('.main-menu li ul.sub-menu').css("display", "none");
        }
        if (!event.target.matches('#sub-menu-1')) {
            $('.main-menu li ul.sub-menu-1').css("display", "none");
        }
      }
});

