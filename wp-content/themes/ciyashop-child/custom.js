jQuery(document).ready(function () {    
    jQuery('.mega-menu-item').find('.mega-menu-row:first').addClass('active_link_hover');
    jQuery("body").on("mouseenter", ".mega-sub-menu .product-grid .left-side-product ul li a",function (event) {
        event.preventDefault();

        /* myclass = jQuery(this).parents('.mega-menu-row ').attr('id');
        parentUl = jQuery(this).parents('.mega-menu-item').find('.mega-sub-menu:first');
        parentUl.attr('class','mega-sub-menu');
        parentUl.addClass(myclass); */

        jQuery(this).parents('.mega-menu-row').siblings().removeClass('active_link_hover');
        jQuery(this).parents('.mega-menu-row').addClass('active_link_hover');
    });
});