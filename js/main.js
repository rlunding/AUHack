/**
 * Created by Lunding on 03/08/15.
 */


var smallWindow;

$( document ).ready(function() {
    function checkWidth() {
        var windowSize = $(window).width();
        if (windowSize < 768) {
            smallWindow = true;
            $(".faq-section p").slideUp(0);
        } else {
            $(".faq-section p").slideDown(0);
            smallWindow = false;
        }
    }
    checkWidth();
    $(window).resize(checkWidth);

    /*$(".expand-icon").click(function(){
        var element = $(this).parent().next();
        if (element.is(":visible")){
            element.slideUp(500);
        } else {
            $(".expand-icon-selected").slideUp(500).removeClass("expand-icon-selected");
            element.slideDown(500);
            element.addClass("expand-icon-selected");
        }
    });*/
    $(".faq-section h4").click(function(){
        if (smallWindow) {
            var element = $(this).next();
            if (element.is(":visible")){
                element.slideUp(500);
            } else {
                $(".faq-item-selected").slideUp(500).removeClass("faq-item-selected");
                element.slideDown(500);
                element.addClass("faq-item-selected");
            }
        }

    });
});