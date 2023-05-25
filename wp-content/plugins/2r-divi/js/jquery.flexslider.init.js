var isFixed = false;

jQuery(window).on('load', function() {
    ph_init_slideshow();
});

// Resize flexsider image to prevent images showing as incorrect height when lazy loading
jQuery('#slider.flexslider .slides img').on('load', function(){
    setTimeout(function() { jQuery(window).trigger('resize'); }, 500);
});
jQuery('#carousel.thumbnails .slides img').on('load', function(){
    setTimeout(function() { jQuery(window).trigger('resize'); }, 500);
});

jQuery(window).on('resize', function() {
    // set height of all thumbnails to be the same (i.e. height of the first one) 
    jQuery('#carousel.thumbnails .slides img').css('height', 'auto');
    var thumbnail_height = jQuery('#carousel.thumbnails .slides img:eq(0)').height();
    jQuery('#carousel.thumbnails .slides img').each(function()
    {
        jQuery(this).height(thumbnail_height);
    });
});

function ph_init_slideshow()
{
    // The slider being synced must be initialized first
    jQuery('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: true,
        slideshow: false,
        itemWidth: 120,
        itemMargin: 10,
        asNavFor: '#slider'
    });

    jQuery('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: true,
        slideshow: false,
        sync: "#carousel",
        smoothHeight: true
    });

    if (jQuery(window).width() > 768 && jQuery(window).height() > 800) {
        var sb = jQuery(".sliding-sidebar");
        sb.height(jQuery(".sliding-sidebar").parent().height());
        sb.css("position", "relative");
        positionSidebar();
        jQuery(window).scroll(function () {
            positionSidebar();
        });
    }
}


function positionSidebar() {
    var sb = jQuery(".sliding-sidebar");
    var headerHeight = jQuery("#mainNav").outerHeight() + 15;
    var boxHeight = jQuery(".sidebar-content-wrapper").outerHeight();
    var topHeight = sb.offset().top;
    var bottomHeight = topHeight + sb.height() - boxHeight - headerHeight - 15;

    var newScroll = jQuery(window).scrollTop();
    if (newScroll >= topHeight - headerHeight && newScroll < bottomHeight && !isFixed) {
        jQuery(".sidebar-content-wrapper").width($(".sidebar-content-wrapper").parent().width());
        jQuery(".sidebar-content-wrapper")
            .attr("style", "width:" + sb.width() + "px;position:fixed;top:" + headerHeight + "px");
        isFixed = true;
    } else if (newScroll < topHeight - headerHeight && isFixed) {
        jQuery(".sidebar-content-wrapper").attr("style", "");
        isFixed = false;
    } else if (newScroll > bottomHeight && isFixed) {
        jQuery(".sidebar-content-wrapper").attr("style", "width:" + sb.width() + "px;position:absolute;bottom:0");
        isFixed = false;
    }
}