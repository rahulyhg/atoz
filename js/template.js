/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    if (jQuery("#main-slider").length > 0) {
        // Main Slider
        var mainSlider = jQuery("#main-slider");

        mainSlider.find('.items').each(function(){
                var imgContainer = jQuery(this).find('.img-container');
                imgContainer.css('background-image', 'url(' + imgContainer.data('bg-img') + ')');
        });

        mainSlider.owlCarousel({
                navigation:     !0,
                singleItem:     !0,
                addClassActive: !0,
                autoPlay:       !0,
                pagination:     !1,
        });
    }
    //Update header style + Scroll to Top
    function headerStyle() {
        if($('#main-header').length){
            var windowpos = $(window).scrollTop();
            if (windowpos >= 250) {
                    $('.scroll-to-top').fadeIn(300);
            } else {
                    $('.scroll-to-top').fadeOut(300);
            }
        }
    }
    
    headerStyle();
    $(window).on('scroll', function() {
            headerStyle();
    });
    // Scroll to a Specific Div
    if($('.scroll-to-target').length){
            $(".scroll-to-target").on('click', function() {
                    var target = $(this).attr('data-target');
               // animate
               $('html, body').animate({
                       scrollTop: $(target).offset().top
                     }, 1000);

            });
    }
});
//WOW Scroll Spy
var wow = new WOW({
    //disabled for mobile
    mobile: false
});
wow.init();

