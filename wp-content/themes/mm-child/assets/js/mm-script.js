jQuery(document).ready(function () {   
    
    //mobile call phone
    var burger_wrap = jQuery('.av-burger-menu-main a');
    jQuery(burger_wrap).on('click', function(){
        
        if(jQuery('html').hasClass('av-burger-overlay-active')){
            
            jQuery('.icon-phone-number-menu').removeClass('menu-show-phone');
            
        }else{
            
            setTimeout(function(){
                jQuery('.icon-phone-number-menu').addClass('menu-show-phone');
            }, 700);
            
        }
        
    });

    /* Custom Tab Product VP */
    /*jQuery('#top.single #itinerary-highlights.tab-product .av-section-tab-title').on('click', function () {
        if (jQuery(window).width() < 768) {
            jQuery('html, body').animate({
                scrollTop: jQuery('#top.single #itinerary-highlights.tab-product .av-tab-section-inner-container').offset().top - 100
            }, 800);
        }
    });*/
    /* End Custom Tab Product VP */
});
jQuery('.html_av-submenu-display-click').on("click", "#av-burger-menu-ul li.av-width-submenu > a > .avia-menu-text", function(e) {
    var link = jQuery(e.target).closest('a');
    if(link && link.attr('href').indexOf('#top') === -1){
        window.location.href = link.attr('href');
        return false;
    }
});

jQuery(document).on("mouseenter", "ul#avia-menu li.menu-item ul.sub-menu .menu-item.menu-item-has-children > a", function(e) {
    var menu_item_a = jQuery(e.target);
    var sub_menu = menu_item_a.closest('.sub-menu');
    var nextElement = jQuery(e.target).next();
    var height_sub_menu = sub_menu.height() + 32;
    sub_menu.addClass('active');
    if( height_sub_menu > (nextElement.height() + 32)){
        nextElement.height(height_sub_menu - 32);
    }
    if (nextElement.find('.menu-over').length === 0) {
        nextElement.append('<div class="menu-over" style="height:' + height_sub_menu  + 'px;"></div>');
    }
});
jQuery(document).on("mouseleave", "ul#avia-menu li.menu-item ul.sub-menu .menu-item.menu-item-has-children > a", function(e) {
    var menu_item_a = jQuery(e.target);
    var sub_menu = menu_item_a.closest('.sub-menu');
    if(!sub_menu.hasClass('active')){
        jQuery('ul#avia-menu li.menu-item ul.sub-menu .menu-item.menu-item-has-children > .sub-menu .menu-over').remove();
    }
});
jQuery(document).on("mouseenter", "ul#avia-menu li.menu-item ul.sub-menu .menu-item.menu-item-has-children > a + .sub-menu", function(e) {
    var sub_menu = jQuery(e.target).closest('li.menu-item.menu-item-has-children');
    sub_menu.addClass('active');
});
jQuery(document).on("mouseleave", "ul#avia-menu li.menu-item ul.sub-menu .menu-item.menu-item-has-children > a + .sub-menu", function(e) {
    var sub_menu = jQuery(e.target).closest('li.menu-item.menu-item-has-children');
    sub_menu.removeClass('active');
});

//page-id-8203 
// if(jQuery(window).width() < 768){
//     if(jQuery( '.page-id-8203 #custom-vacation-planner').length){
//         const sectionCustomVP = jQuery( '.page-id-8203 #custom-package').clone();
//         sectionCustomVP.find('.flex_column.faq-column').remove();
//         jQuery( '.page-id-8203 #custom-package #custom-vacation-planner').remove();
//         jQuery('#av_section_1').after(sectionCustomVP.attr('id','move-vacation-planner'));
//         //-----------------
//         jQuery(window).scroll(function () {
//             const windowTop = jQuery(window).scrollTop();
//             const stopPoint = jQuery('#footer').offset().top - jQuery(window).height();
//             const avSection2 = jQuery('#av_section_2').offset().top + jQuery('#av_section_2').height() - 200;
//             //console.log(avSection2);
//             if(windowTop<stopPoint){
//                 if( windowTop > avSection2){
//                     jQuery('.sticky-custom-vacation-planner').css('display','block');
//                 }
//                 else jQuery('.sticky-custom-vacation-planner').css('display','none');
//             }
//             else{
//                 jQuery('.sticky-custom-vacation-planner').css('display','none');
//             }
//         });
//     }
//
// }


//page-id-8203 
if(jQuery(window).width() < 768){
    if(jQuery( '.page-id-20299 #custom-vacation-planner').length){
        const formVP = jQuery('#custom-vacation-planner');
        const ssFirst = jQuery('#av_section_1');

        if (formVP && ssFirst) {
            formVP.insertAfter(ssFirst);
        }
        //-----------------
        if (jQuery('#footer') && jQuery('#custom-package') && jQuery('.sticky-custom-vacation-planner')) {
            jQuery(window).scroll(function () {
                const windowTop = jQuery(window).scrollTop();
                const stopPoint = jQuery('#footer').offset().top - jQuery(window).height();
                const avSection2 = jQuery('#custom-package').offset().top + jQuery('#custom-package').height() - 200;
                if(windowTop < stopPoint){
                    if ( windowTop > avSection2 ) {
                        jQuery('.sticky-custom-vacation-planner').css('display','block');
                    }
                    else jQuery('.sticky-custom-vacation-planner').css('display','none');
                }
                else {
                    jQuery('.sticky-custom-vacation-planner').css('display','none');
                }
            });
        }
    }
}

//page-id-111  
if(jQuery(window).width() <= 768) {
    if(jQuery('.page-id-111 #free-consultation-form').length){
        const formVP = jQuery('#free-consultation-form');
        const ssFirst = jQuery('#av_section_1');

        if (formVP && ssFirst) {
            formVP.insertAfter(ssFirst);
        }
        //-----------------
        if (jQuery('#footer') && jQuery('#av_section_2') && jQuery('.sticky-custom-vacation-planner')) {
            jQuery(window).scroll(function () {
                const windowTop = jQuery(window).scrollTop();
                const stopPoint = jQuery('#footer').offset().top - jQuery(window).height();
                const avSection2 = jQuery('#av_section_2').offset().top + jQuery('#av_section_2').height() - 200;
                if(windowTop<stopPoint){
                    if( windowTop > avSection2){
                        jQuery('.sticky-custom-vacation-planner').css('display','block');
                    }
                    else jQuery('.sticky-custom-vacation-planner').css('display','none');
                }
                else{
                    jQuery('.sticky-custom-vacation-planner').css('display','none');
                }
            });
        }
    }
}
jQuery(document).ready(function($){
    if ($('#top.single-product .hr-mm-star .aiosrs-rating-count').length > 0) {
        $('#top.single-product .hr-mm-star .aiosrs-rating-count').on('click', function (){
            $('html,body').animate({
                    scrollTop: jQuery('.es-embed-root').offset().top - 300},
                'slow');
        });
    }

    // Create zoom image for Image short code
    $('.mm-image-with-zoom-popup-inner').on('click', function(e) {
        let image = $(this).find('img');
        
        if (image.hasClass('zoomed')) {
            image.removeClass('zoomed');
            image.css('transform', 'scale(1)');
            $(this).css('cursor', 'zoom-in');
        } else {
            let offset = $(this).offset();
            let xPos = e.pageX - offset.left;
            let yPos = e.pageY - offset.top;
            let width = $(this).width();
            let height = $(this).height();
            
            let xPercent = xPos / width * 100;
            let yPercent = yPos / height * 100;
        
            image.css('transform-origin', xPercent + '% ' + yPercent + '%');
            image.css('transform', 'scale(1.5)');
            image.addClass('zoomed');
            $(this).css('cursor', 'zoom-out');
        }
    });

    $('.mm-image-with-zoom-btn-zoom').click(function () {
        const src = $(this).data('src');
        $('.mm-image-with-zoom-popup-inner').append(`<img src="${src}" />`);
        $('.mm-image-with-zoom-popup').addClass('active');
    });

    $('.mm-image-with-zoom-popup-btn-close').click(function (event) {
        event.stopPropagation();
        $('.mm-image-with-zoom-popup').removeClass('active');
        $('.mm-image-with-zoom-popup img').remove();
    });

    $('.mm-image-with-zoom-popup-overlay').click(function () {
        $('.mm-image-with-zoom-popup').removeClass('active');
        $('.mm-image-with-zoom-popup img').remove();
    });


    /* VP Menu Top */
    $('.mm-nav-vp-item.scroll-to').click(function (event) {
        event.preventDefault();
        const target = $($(this).attr('href'));
        $('html, body').stop().animate({
            scrollTop: target.offset().top - 140
        }, 500);
    });
    $('#mm-nav-vp-hamburger').click(function () {
        $(this).toggleClass('show');
        $('.mm-nav-vp-wrap').toggleClass('show');
    });
});