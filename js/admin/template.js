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
});
//WOW Scroll Spy
var wow = new WOW({
    //disabled for mobile
    mobile: false
});
wow.init();

