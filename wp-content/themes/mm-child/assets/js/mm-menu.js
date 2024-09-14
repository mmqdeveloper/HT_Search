jQuery(document).ready(function ($) {
    if (jQuery(window).width() < 990) {
        jQuery(".main_menu #avia-menu .av-burger-menu-main.menu-item-avia-special").insertBefore(".main_menu #avia-menu .menu-item.btn-booknow-header");
    }

});

jQuery(window).resize(function () {
    if (jQuery(window).width() <= 990) {
        jQuery(".main_menu #avia-menu .av-burger-menu-main.menu-item-avia-special").insertBefore(".main_menu #avia-menu .menu-item.btn-booknow-header");
    } else {
        jQuery(".main_menu #avia-menu .av-burger-menu-main.menu-item-avia-special").insertAfter(".main_menu #avia-menu .menu-contact.menu-item");
    }

});