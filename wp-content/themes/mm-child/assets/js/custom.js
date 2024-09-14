function getAnchorLink() {
    return (document.URL.split('#').length > 1) ? '#' + document.URL.split('#')[1] : null;
}
function isMobileDevice() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}
jQuery(document).ready(function () {
    //js on tab_homespace
    if(isMobileDevice()){
        if(jQuery( "#top .tab_homespace" ).length > 0){
            const tabHomespace = jQuery('#top .tab_homespace .av_tab_section');

            tabHomespace.find('.active_tab').removeClass('active_tab');
            tabHomespace.find('.active_tab_content').removeClass('active_tab_content');

            tabHomespace.find('[data-fake-id="#oahu-tours"]').addClass('active_tab');
            tabHomespace.find('#oahu-tours-content').addClass('active_tab_content');

            tabHomespace.find('.tab').click(function(event) {
                var tabHome = jQuery(this);
                var targetPosition = tabHome.offset().top;
                jQuery("html, body").animate({
                    scrollTop: targetPosition - 100
                }, 100);
            });
        }
        
    }
    if(jQuery( '.avia-cookie-consent-wrap a.avia-cookie-close-bar' ).length){
        var timeCookieBar = 6000;
        if (isMobileDevice()) {
            timeCookieBar = 4000;
        }
        setTimeout(function() {
            jQuery('.avia-cookie-consent-wrap a.avia-cookie-close-bar').click();
        }, timeCookieBar);
    }
    //code js share
    if(jQuery('.ht-share-product').length > 0){
        var dropdown_share_product = jQuery('.ht-share-product .ht-dropdown-share-product');
        jQuery('.ht-share-product').on('mouseenter click', function(event) {
            dropdown_share_product.addClass('open');
        });
        
        jQuery(document).mouseup(function(e) {
            if (!dropdown_share_product.is(e.target) && dropdown_share_product.has(e.target).length === 0) {
                dropdown_share_product.removeClass('open');
            }
        });

        jQuery('.ht-share-product .ht-dropdown-share-product ul.items-dropdown-share li.item-share a.ht-copy-link').click(function(event) {
            event.preventDefault();
            var contentToCopy = jQuery(this).attr('data-copy-text'); 
            var tempInput = jQuery('<input>');
            jQuery('body').append(tempInput);
            tempInput.val(contentToCopy).select();
            document.execCommand('copy');
            tempInput.remove();
            jQuery(this).addClass('clipboard');
            
        });
    }
    //code breadcrumb menu
    if( jQuery('.single-product .woocommerce-breadcrumb').length > 0 ){
        var island_breadcrumb = jQuery('.single-product .woocommerce-breadcrumb a:nth-child(2)').text().toLowerCase();
        var el_product_breadcrumb = jQuery('.single-product .woocommerce-breadcrumb a:nth-child(3)');
        var product_name_breadcrumb = jQuery('.single-product .woocommerce-breadcrumb a:nth-child(3)').text().toLowerCase();

        jQuery( ".single-product #avia-menu > li" ).each(function( index ) {
            var this_ = jQuery(this);
            var name_island_menu = this_.children('a').find('.menu-image-title').text().toLowerCase();
            var menu_child_li = this_.children('.sub-menu').find('.menu-item'); 

            if( island_breadcrumb == name_island_menu ){
                jQuery( menu_child_li ).each(function( index ) {
                    var this__ = jQuery(this);
                    var link_child_li = this__.find('a').attr('href');
                    var name_menu_child = this__.find('.menu-image-title').text().toLowerCase();
                    if( product_name_breadcrumb == name_menu_child || (name_menu_child.indexOf(product_name_breadcrumb) != -1) ){
                        el_product_breadcrumb.attr('href',link_child_li) ;
                        return;
                    }
                });
                return;
            }
        });
    }

    //end code breadcrumb menu

    //code search faq ajax

    var input_search_faq = jQuery('#wrap-search-faq input');
    var btn_search = jQuery('#wrap-search-faq button')

    btn_search.click(function(){
        jQuery.ajax({
            type : "post",
            dataType : "html",
            url : ajax_custom_js.ajax_url,
            data : {
                action: "mm_search_faq_sc",
                key_faq_search: input_search_faq.val()
            },
            beforeSend: function(){
                jQuery( "#wrap-search-faq .wrap-content-faq" ).empty();
                jQuery( "#wrap-search-faq .wrap-content-faq" ).append( '<div class="loader"><span class="loader__dot"></span><span class="loader__dot"></span><span class="loader__dot"></span></div>' );

            },
            success: function(response) {
                jQuery('.loader').remove();
                jQuery( "#wrap-search-faq .wrap-content-faq" ).empty();
                jQuery( "#wrap-search-faq .wrap-content-faq" ).append( response );

                jQuery(".item-arrcordian").on("click", ".accordion-heading", function () {
                    jQuery(this).toggleClass("active").next().slideToggle();
                    jQuery(".accordion-content").not(jQuery(this).next()).slideUp(300);
                    jQuery(this).parents().siblings().find('.accordion-heading').removeClass("active");
                });

                jQuery(".item-arrcordian").slice(0, 4).show();
                jQuery("#loadMore").on("click", function(e){
                    e.preventDefault();
                    jQuery(".item-arrcordian:hidden").slice(0, 4).slideDown();
                    if(jQuery(".item-arrcordian:hidden").length == 0) {
                        jQuery("#loadMore").text("No Content").addClass("noContent");
                    }
                });
            },
            error: function( jqXHR, textStatus, errorThrown ){
                //console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        });

        //ajax search faq

    })

    //end code search faq ajax
    //code style account page
    if (jQuery('.wrap-account-form #customer_login').length > 0) {
        let formLogin = jQuery('.wrap-account-form #customer_login .u-column1.col-1');
        let formRegister = jQuery('.wrap-account-form #customer_login .u-column2.col-2');
        let btnLogin = jQuery('.wrap-account-form .btn.login');
        let btnLoginSubmit = jQuery('.wrap-account-form .woocommerce-form-login__submit');
        let linkLostPassword = jQuery('.wrap-account-form .woocommerce-LostPassword.lost_password');
        let btnRegister = jQuery('.wrap-account-form .btn.register');
        let noticeRegister = jQuery('.wrap-account-form .wrap-notice-register');

        linkLostPassword.insertBefore(btnLoginSubmit);

        let urlGoogleLogin = formLogin.find('.button-social-login').attr('href');
        formRegister.find('form.woocommerce-form-register').append(`<div class="wc-social-login form-row-wide">
            <a href="${urlGoogleLogin}" class="button-social-login button-social-login-google" target="_blank"><span class="si si-google"></span>Log in with Google</a> 		
        </div>`);

        btnLogin.addClass('active');
        btnLogin.click();
        formLogin.append('<p>Don’t have an account? <span class="mm-create-a-account-btn">Create an Account</span></p>');
        formRegister.append('<p>You have an account? <span class="mm-login-a-account-btn">Sign In</span></p>');
        let btnSwithToRegister = jQuery('.wrap-account-form .mm-create-a-account-btn');
        let btnSwithToLogin = jQuery('.wrap-account-form .mm-login-a-account-btn');
        btnSwithToRegister.click(function () {
            btnRegister.addClass('active');
            btnLogin.removeClass('active');
            formLogin.hide();
            formRegister.show();
            noticeRegister.show();
        });
        btnSwithToLogin.click(function () {
            btnLogin.addClass('active');
            btnRegister.removeClass('active');
            formRegister.hide();
            formLogin.show();
            noticeRegister.hide();
        });
    }
    //end code style account page

    if( jQuery('.woocommerce-MyAccount-navigation-link--likes > a').length > 0 ){
        jQuery('.woocommerce-MyAccount-navigation-link--likes > a').attr('href','/product-likes');
    }
    jQuery('#wc-bookings-booking-form').prepend(jQuery('.av-woo-purchase-button .wcpl-product-likes-product'));
//code filter product by island
    jQuery('.island-select').insertBefore(jQuery('.product-like'));
    var islandArray = [];
    jQuery('.option_island option').each(function(){
        var img = jQuery(this).attr("data-thumbnail");
        var text = this.innerText;
        var value = jQuery(this).val();
        var item = '<li><img src="'+ img +'" alt="" value="'+value+'"/><span>'+ text +'</span></li>';
        islandArray.push(item);
    })

    jQuery('#list-island').html(islandArray);

//Set the button value to the first el of the array
    jQuery('.btn-select').html(islandArray[0]);
    jQuery('.btn-select').attr('value', 'en');

//change button stuff on click
    jQuery('.btn-select').click(function(){
        jQuery(".container-list-island").toggle();
    })
    jQuery('#list-island li').click(function(){
        var img = jQuery(this).find('img').attr("src");
        var value = jQuery(this).find('img').attr('value');
        var text = this.innerText;
        var item = '<li><img src="'+ img +'" alt="" /><span>'+ text +'</span></li>';
        jQuery('.btn-select').html(item);
        jQuery('.btn-select').attr('value', value);
        jQuery(".container-list-island").toggle();
        //console.log(value);




        var name_island = jQuery(this).val();
        jQuery.ajax({
            type : "post",
            dataType : "html",
            url : ajax_custom_js.ajax_url,
            data : {
                action: "filter_product_by_island",
                name_island: value
            },
            beforeSend: function(){
                jQuery('.notice-empty-product').remove();
                jQuery('.circle-wrapper').remove();
                jQuery('<div class="loader"><span class="loader__dot"></span><span class="loader__dot"></span><span class="loader__dot"></span></div>').insertAfter( jQuery( '.island-select' ) );
            },
            success: function(response) {
                jQuery( '.product-like .products,.product-like .product-sorting' ).remove();
                //var response = JSON.stringify(response);
                try{
                var arr_res = JSON.parse(response);
                if(arr_res[1] == 'all'){
                    jQuery('.loader').remove();
                    jQuery('.notice-empty-product').remove();
                    jQuery('.circle-wrapper').remove();
                    jQuery(arr_res[0]).insertAfter( jQuery( '.island-select' ) );
                    jQuery('.product-like .products .inner_product_header').matchHeight();
                }else{
                    var arr_id_product = [];
                    if(arr_res.length){
                        var arr_id_product = arr_res[1].split(',');
                        JSON.parse(response).forEach(function (item, index) {
                            if( index == 0 ){
                                jQuery(item).insertAfter( jQuery( '.island-select' ) );
                                var product_id_like = [];
                                jQuery( ".product-like .products li.product" ).each(function( index ) {
                                    var _this = jQuery(this);
                                    var product_id = _this.find('.wcpl-product-likes-product').data('product-id');
                                    // console.log(product_id);
                                    if( arr_id_product.includes('' + product_id) ){
                                        product_id_like.push(product_id);
                                    }

                                });
                                jQuery( '.product-like' ).remove();

                                //console.log(product_id_like);
                                jQuery.ajax({
                                    type : "post",
                                    dataType : "html",
                                    url : ajax_custom_js.ajax_url,
                                    data : {
                                        action: "filter_product_by_island_order_by_id",
                                        list_product_id: JSON.stringify(product_id_like)
                                    },
                                    beforeSend: function(){
                                        // jQuery('<div class="overlay-spinner"></div>').insertAfter( jQuery( '.island-select' ) );
                                    },
                                    success: function(response) {
                                        jQuery('.loader').remove();
                                        jQuery('.notice-empty-product').remove();
                                        jQuery('.circle-wrapper').remove();
                                        jQuery(response).insertAfter( jQuery( '.island-select' ) );
                                        jQuery('.product-like .products .inner_product_header').matchHeight();


                                    },
                                    error: function( jqXHR, textStatus, errorThrown ){
                                        //console.log( 'The following error occured: ' + textStatus, errorThrown );
                                    }
                                });

                            }
                            // console.log(item + '</br></br>');
                        });
                    }
                }
                
                }catch (e) {
                    jQuery('.loader').remove();
                    //jQuery(response).insertAfter( jQuery( '.island-select' ) );
                }
            },
            error: function( jqXHR, textStatus, errorThrown ){
                //console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        });
    });

//end code filter product by island
    jQuery('.wcpl-product-likes-product').click(function(){
        jQuery.ajax({
            type : "post",
            dataType : "html",
            url : ajax_custom_js.ajax_url,
            data : {
                action: "check_user_login_like",
            },
            beforeSend: function(){

            },
            success: function(response) {
                // alert(response);
                if(response !== 'logined'){
                    jQuery( "#wrap-sc-account" ).remove();
                    jQuery( '<div id="wrap-sc-account"></div>' ).insertAfter( jQuery( '#wrap_all' ) );
                    jQuery( "#wrap-sc-account" ).append( response );
                    jQuery('#wrap-sc-account .woocommerce-LostPassword').insertBefore(jQuery('#wrap-sc-account .woocommerce-form-login .form-row:not(.form-row-wide)'));
                    jQuery( "#wrap-sc-account > .woocommerce" ).append( '<span class="close">X</span>' );
                    jQuery('#wrap-sc-account input[name="_wp_http_referer"]').val(window.location.href);
                    jQuery('<span class="link-account">Or <a href="/my-account" target="_blank">Create account</a></span>').insertAfter('.woocommerce-form-login__submit');
                    jQuery('#wrap-sc-account .close').click( function() {
                        jQuery( "#wrap-sc-account" ).remove();
                    })

                }else{
                    if(  jQuery( '.logged-in' ).length == 0 ){
                        location.reload();
                    }
                }
            },
            error: function( jqXHR, textStatus, errorThrown ){
                //console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        });
    })
    //ajax show notice ticket
    var is_product_page = jQuery( '.single-product' ).length;
    if( is_product_page > 0 ){
        jQuery.ajax({
            type : "post",
            dataType : "html",
            url : ajax_custom_js.ajax_url,
            data : {
                action: "check_product_tag",
                product_id: ajax_custom_js.product_id
            },
            beforeSend: function(){

            },
            success: function(response) {
                if( response !== ''){
                    if( jQuery.cookie(`product_seen_notice_ticket-${ajax_custom_js.product_id}`) && (+jQuery.cookie(`product_seen_notice_ticket-${ajax_custom_js.product_id}`) == +ajax_custom_js.product_id) ){
                        return false;
                    }else{
                        jQuery('.avia-cookie-consent-wrap').hide();
                        jQuery(`<div class="avia-cookie-consent-wrap-notice"><div class="avia-cookie-consent
                    avia-cookiemessage-bottom"><div class="container"><p class="avia_cookie_text">${response}</p><a href="javascript:void(0)" class="avia-button avia-color-theme-color-highlight avia-cookie-consent-button avia-cookie-consent-button-1  avia-cookie-close-bar ">OK</a></div></div></div>`).insertAfter(jQuery('body > #wrap_all'));
                    }
                }
            },
            error: function( jqXHR, textStatus, errorThrown ){
                //console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        });

        jQuery(document).ajaxComplete(function(){
            jQuery('.avia-cookie-consent-wrap-notice a.avia-cookie-close-bar').click(function(e){
                jQuery('.avia-cookie-consent-wrap-notice').hide();
                var expDate = new Date();
                expDate.setTime(expDate.getTime() + (3600 * 60 * 1000)); // add 5 minutes
                jQuery.cookie(`product_seen_notice_ticket-${ajax_custom_js.product_id}`, ajax_custom_js.product_id, { path: '/', expires: expDate });
            });
        });

    }
    //end ajax show notice ticket
    
    //scroll of vacation tour
    jQuery('.js-anchor-link').click(function(e){
        e.preventDefault();
        var target = jQuery(jQuery(this).attr('href'));
        var target_link_tab = jQuery(jQuery(this).attr('href') + ' > a');
        if(target.length){
            // tab-title-travel-insurance
            var scrollTo = target.offset().top;
            jQuery('body, html').animate({scrollTop: scrollTo+'px'}, 200);
            target_link_tab.click();
        }
    });
    jQuery( '.woocommerce-account #main > .container ' ).insertAfter( "#my_account" );
    if(jQuery('#top .av_textblock_section a:not(.checkout-button)').length){
        jQuery("#top .av_textblock_section a:not(.checkout-button)").each(function () {
            var get_href = jQuery(this).attr('href');
            if(get_href.indexOf("tel:") < 0){
                jQuery(this).attr('target', '_blank');
            }
        });
    }
    // anchor link
    jQuery( ".archive .avia-buttonrow-wrap a.avia-button" ).click(function( event ) {
        if(jQuery('.product_tag-' + (jQuery(this).attr("href")).replace("#", "")).length){
            event.preventDefault();
            jQuery("html, body").animate({ scrollTop: jQuery('.product_tag-' + (jQuery(this).attr("href")).replace("#", "")).offset().top - 150 }, 500);
    
        }
    });
    jQuery( ".archive .product-sorting,.archive #category-select" ).before( jQuery( ".archive #breadcrumb_product" ) );
    jQuery(".category .category-item.left").each(function () {
        var _this = this;
        jQuery(_this).find('.category-title').append(jQuery(_this).find('.cate__read-more .read__more'));
    });
    jQuery( ".category .category-title" ).append( jQuery( ".category .cate__read-more .read__more" ) );

    jQuery('.postid-6665 #wc-bookings-booking-form #tm-epo-field-1 h3').html('Bags, Anchors & Snorkel Gear'+ '<span class="tcfa tm-arrow tcfa-angle-down"></span>');
    jQuery("<div class='overlay'></div>").insertAfter(jQuery('.mm-grid-content a .mm-thumbnail img'));
    jQuery("#main > #booking-box > .container").prepend(jQuery("#breadcrumb_product"));
    //jQuery('.postid-49579 #wc-bookings-booking-form ul.list-costs-island li .ht-price-option small').html('two adults');
    jQuery('.postid-66318 #wc-bookings-booking-form ul.list-costs-island li .ht-price-option small').html('per person');
    jQuery('.postid-49702 #wc-bookings-booking-form ul.list-costs-island li .ht-price-option small').html('per person');

    

    // jQuery('.postid-49579 #wc-bookings-booking-form ul.list-costs-island li .ht-price-option small').text(function (i,oldText) {
    //     return oldText === 'per adult' ? 'per person' : oldText;
    // });
    jQuery(".booking_form_sidebar.booking_box_fareharbox .title-resource").click(function () {
        if(jQuery(this).closest('.resource-item').find('.tour-price').css('display') == 'none'){
            jQuery(this).closest('.resource-item').find('.tour-price').show( "slow" );
        }else jQuery(this).closest('.resource-item').find('.tour-price').hide( "slow" );
        
    });
    jQuery( '.single-product .av-tab-section-inner-container .av-layout-tab.av-active-tab-content' ).addClass('current');
    jQuery('.av-tab-section-tab-title-container a.av-section-tab-title.av-tab-with-icon.av-tab-no-image').click(function(){
        var tab_id = jQuery(this).attr('data-av-tab-section-title');
        jQuery('.av-tab-section-tab-title-container a.av-section-tab-title.av-tab-with-icon.av-tab-no-image').removeClass('current');
        jQuery('.single-product .av-tab-section-inner-container .av-layout-tab').removeClass('current');

        jQuery(this).addClass('current');
        jQuery(".av-layout-tab[data-av-tab-section-content='"+ tab_id +"']").addClass('current');
    });

    /**Hide title when hover**/
    jQuery('.av-horizontal-gallery-large-gap .av-horizontal-gallery-wrap .av-horizontal-gallery-img').hover(
        function() {
            jQuery(this).attr("org_title",
                jQuery(this).attr('title'));
            jQuery(this).attr('title', '');
        }, function() {
            jQuery(this).attr('title', jQuery(this).attr("org_title"));
        }
    );
    /**Hide title when hover**/

    jQuery('.ht-search-result .mm_thumbnail').matchHeight();
    jQuery('.carousel img').css('display', 'block');
    jQuery('.flickity-prev-next-button.previous').css('display', 'block');
    jQuery('.flickity-prev-next-button.next').css('display', 'block');
    jQuery('.flickity-prev-next-button.previous svg').css('display', 'block');
    jQuery('.flickity-prev-next-button.next svg').css('display', 'block');
    
    jQuery('.woocommerce-checkout .logo-footer').attr('href', document.location.origin + '/tickets');

    jQuery("#order_comments_field label").text('Reservation, Language & Pickup Notes');
    jQuery("#order_comments").attr("placeholder", "Please provide the name of the registered guest and date of arrival in Hawaii as well as any other details about your travel needs.");

    jQuery('.mm-single-product .type-product .inner_product_header,.shop-filter-product .type-product .inner_product_header,#top .product.type-product .inner_product_header').matchHeight();
    //jQuery('#top:not(.archive) .product.type-product .inner_product_header').matchHeight();
    jQuery(window).on('resize', function(){
        var win = jQuery(this); //this = window
        if (win.height() >= 767) {
            jQuery('.archive .product.type-product .inner_product_header').matchHeight();
        }
    });
    if(jQuery('#list_restaurants').length){
        jQuery('#list_restaurants .slide-entry-excerpt').matchHeight();
    }
    if(jQuery('.learn-more-blog').length){
        jQuery('.learn-more-blog .slide-entry-excerpt').matchHeight();
        jQuery('.learn-more-blog .entry-content-header').matchHeight();
    }
    jQuery(document).on( 'nfFormReady', function( e, layoutView ) {
        if(jQuery('.set_an_amount_number').length){
            jQuery('.set_an_amount_number input').trigger('change');
        }
    });
    jQuery(document).on('click', '.set_an_amount_number input', function (e) {
        var amount = jQuery(this).val();
        if(amount>0){
            jQuery('.set_an_amount_radio input[type="radio"]:checked').each(function(){
                jQuery(this).prop( "checked", false ); 
            });
        }
    });
    jQuery(document).on("click", ".mm-list-restaurants-load-more", function(e) {
        e.preventDefault();
        var page = jQuery(this).data('page') + 1;
        var max_page = jQuery(this).data('max_page');
        var atts = jQuery(this).data('atts');
        jQuery('#mm-list-restaurants .custom-loading-icon').css('display','');
        jQuery.ajax({
            type: "post",
            dataType: "text",
            url: AJAX.url,
            data: {
                action: "mm_ajax_load_more_list_restaurant",
                page: page,
                atts: atts
                
            },
            success: function (response) {
                jQuery( "#list_restaurants .slide-entry-wrap" ).append( response );
                if(page >= max_page){
                    jQuery('.mm-list-restaurants-load-more').css('display', 'none');
                }
                else{
                    jQuery('.mm-list-restaurants-load-more').data( "page", page );
                }
                jQuery('#mm-list-restaurants .custom-loading-icon').css('display','none');
                setTimeout(function(){ jQuery('.ajax-item-restaurant .slide-entry-excerpt').matchHeight(); }, 3000);
                //jQuery('.products .product.type-product .inner_product_header').matchHeight();
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
            },
        });
        return false;
    });
    
    jQuery('.avia-mm-grid-row .grid-item-content').matchHeight();
    if (jQuery(".picker").hasClass("active")) {
        jQuery('.bookings-date-1').css("position", "relative !important");
    }
    //hover phone number main menu
    jQuery(".icon-phone-number-menu").hover(
            function () {
                jQuery(".main-phone-number").addClass("hover");
            }, function () {
        jQuery(".main-phone-number").removeClass("hover");
    }
    );
    if(jQuery(".menu-phone-number").length){
        jQuery(".menu-phone-number").appendTo(".icon-phone-number-menu");
    }
    var max_height = 0;
    jQuery(".av-woo-product-related-upsells ul.products li").each(function () {
        if (jQuery(".av-woo-product-related-upsells ul.products li a .inner_product_header").height() > max_height)
            max_height = jQuery(".av-woo-product-related-upsells ul.products li a .inner_product_header").height();
    });
    if (jQuery(window).width() > 420) {
        jQuery(".av-woo-product-related-upsells ul.products li a .inner_product_header").height(max_height);
    }
    jQuery('.content-blog .blog-item.left .link-blog h3').matchHeight();
    jQuery('.list-costs-island .island-name').matchHeight();



// set quantity for checkout form
    var qtyPeople = jQuery('.mm-qty-people').val();
    var tour_id_hw = jQuery('.product_id_hw').val();
    jQuery('#many_people').val(qtyPeople);
    jQuery('#private_tour').val(tour_id_hw);
    jQuery('#many_people_field').css({'visibility': 'hidden', 'height': '0', 'padding': '0'});
    var heightJeep = jQuery('.fields_Guests').height();
    jQuery('.container-number').css('height', heightJeep + 42);

    jQuery("#top .pearl-harbol-date .wc-bookings-date-picker-booking").click(function () {
        jQuery(this).siblings(".mmt-select-wrap").children(".list-costs-island").css("display", "none");
    });

    jQuery("#wc-bookings-booking-form .wc_booking_field_hotel-rooms").click(function () {
        jQuery(this).siblings(".mmt-select-wrap").children(".list-costs-island").css("display", "none");
    });

    //jQuery("<img src='https://www.hawaiitours.com/wp-content/uploads/2018/03/IconPhone-1.png' width='38' height='38' alt='Call Us'>").appendTo(".icon-phone-number-menu a");
    jQuery("<img src='https://www.hawaiitours.com/wp-content/uploads/2018/03/IconPhone-1.png' width='38' height='38' alt='Call Us'>").prependTo(".menu-phone-mobile a");
    //find a tour header
    if(jQuery(".find-a-tour").length){
        var tour_select = jQuery('select.all-island-select').val();
        if(tour_select!=''){
            jQuery('.all-tour-select .'+tour_select).css('display','block');
        }
        jQuery(".find-a-tour select").on( "click", function() {
            if(jQuery(this).parent().hasClass('focus-select')){
                jQuery(this).parent().removeClass('focus-select');
            }
            else jQuery(this).parent().addClass('focus-select');
            
        });
        jQuery(".find-a-tour select").blur(function () {
            jQuery(this).parent().removeClass('focus-select');
        });
        jQuery( "body" ).append( "<div class='change-header-image' style='display:none'></div>" );
        jQuery( ".all-island-select option" ).each(function() {
            var option_image = jQuery(this).data('image');
            var img_html = "<img src='"+option_image+"' width='1920' height='800' alt='Hawaii Tours and Activities'>";
            jQuery( ".change-header-image" ).append(img_html);
        });
    }
    if(jQuery("select.all-tour-select").length){
        var select   = jQuery("select.all-tour-select"),
        oahu = select.children(".oahu"),
        maui = select.children(".maui"),
        bigisland = select.children(".big-island"),
        kauai = select.children(".kauai"),
        hawaii = select.children(".hawaii"),
        others   = select.children(":not(.choose-tour)");
        others.remove();
    }
    jQuery("select.all-island-select").change(function(){
        var selectedvalue = jQuery(this).children("option:selected").val();
        var bg_image = jQuery(this).children("option:selected").data('image');
        if(bg_image!=''){
            jQuery(this).closest(".avia-section" ).css('background-image','url('+bg_image+')').fadeIn(1000);
        }
        //jQuery('.all-tour-select option').css('display','none');
        jQuery(".all-tour-select").val('');
        /*if(selectedvalue!=''){
            jQuery('.all-tour-select .'+selectedvalue).css('display','block');
        }*/
        others.remove();
        switch(selectedvalue) {
            case 'oahu':
              select.append(oahu);
              break;
            case 'maui':
              select.append(maui);
              break;
            case 'big-island':
              select.append(bigisland);
              break;
            case 'kauai':
              select.append(kauai);
              break;
            case 'hawaii':
              select.append(hawaii);
              break;
        }
    });

    jQuery(".submit-find-tour").click(function () {
        var tour_select = jQuery('.all-tour-select').val();
        if(tour_select!=''){
            window.location.href = tour_select;
        }
        else{
            var island_select = jQuery('.all-island-select').children("option:selected").data('link');
            if(island_select!=''){
                window.location.href = island_select;
            }
        }
        return false;
    });
    if(jQuery('.uap-form-uap_country').length){
        jQuery('.uap-form-uap_country select#uap_uap_country_field').val('us');
        jQuery('.uap-form-uap_country #select2-uap_uap_country_field-container').attr('title', 'United States (US)' );
        jQuery('.uap-form-uap_country #select2-uap_uap_country_field-container').html('<span class="select2-selection__clear">×</span>United States (US)' );
    }
    if(jQuery('#uap_login_form').length){
        var form_links_reg = jQuery('.uap-form-links-reg').html();
        jQuery('.uap-form-links-reg').html(form_links_reg.replace("Dont have an account?", "Don't have an account?"));
        jQuery('.uap-reg-success-msg').text('Registration Successful!');
    }
    jQuery(".sticky-start-booking #start-booking").click(function () {
        if (jQuery(this).hasClass('mm-unable-click')) {
            return;
        }
        jQuery(this).addClass('mm-unable-click');
        setTimeout(function () {
            jQuery(".sticky-start-booking #start-booking").removeClass('mm-unable-click');
        }, 1000);
        jQuery('html, body').animate({
            scrollTop: jQuery(".av-woo-purchase-button").offset().top
        }, 1000);
        // jQuery( ".field_resource" ).trigger('click');
    });
    scroll_sticky_start_booking();
    sticky_checkout_btn();
    jQuery(window).on('resize', function () {
        scroll_sticky_start_booking();
        sticky_checkout_btn();
    });
    function scroll_sticky_start_booking(){
        if (jQuery('.sticky-start-booking').length) {
            if (jQuery(window).width() < 767) {
                jQuery(window).scroll(function () {
                    var windowTop = jQuery(window).scrollTop();
                    var stopPoint = jQuery('#footer').offset().top - jQuery(window).height();
                    var booking_form = jQuery('.av-woo-purchase-button').offset().top - jQuery(window).height() + 20;
                    var booking_form_end = jQuery('.av-woo-purchase-button').offset().top + jQuery('.av-woo-purchase-button').height() - 20;
                    if(windowTop<stopPoint){
                        if( windowTop > booking_form_end){
                            jQuery('.sticky-start-booking').css('display','block');
                            jQuery('html').addClass('mm-sticky-booking');
                        }
                        else {
                            jQuery('.sticky-start-booking').css('display','none');
                            jQuery('html').removeClass('mm-sticky-booking');
                        }
                    }
                    else{
                        jQuery('.sticky-start-booking').css('display','none');
                        jQuery('html').removeClass('mm-sticky-booking');
                    }
                    
                });
            }
            else{
                jQuery('.sticky-start-booking').css('display','none');
            }
        }
    }
    function sticky_checkout_btn(){
        if (jQuery('.btn-checkout-sticky').length) {
            if (jQuery(window).width() < 767) {
                jQuery(window).scroll(function () {
                    var windowTop = jQuery(window).scrollTop();
                    var stopPoint = jQuery('#footer').offset().top - jQuery(window).height();
                    if(windowTop>stopPoint){
                        jQuery('.btn-checkout-sticky').css('display','none');
                    }
                    else{
                        jQuery('.btn-checkout-sticky').css('display','block');
                    }
                });
            }
            else{
                jQuery('.btn-checkout-sticky').css('display','none');
            }
        }
    }

    // Hide createaccount
    if( jQuery('.variation-CustomerInfo').length ){
        jQuery(".variation-CustomerInfo p:contains('#1This field is required.')").hide();
    }
    if( jQuery('#createaccount').length ){
        jQuery('.woocommerce-checkout #createaccount').prop( 'checked', true );
        jQuery('.woocommerce-checkout .woocommerce-account-fields').hide();
    }
    jQuery('.faq-readmore').on('click', function () {
        var button_label = jQuery(this).text();
        jQuery(this).closest('.togglecontainer').find('.hide-faq-item').toggleClass('show'); 
        jQuery(this).remove();
         
        return false;
    });
    if( jQuery('.coupon-saveonhawaii').length ){
        jQuery('.woocommerce-notices-wrapper .woocommerce-info').css('display','none');
    }
    jQuery('#wc-bookings-booking-form').on('click', '.label-content-person', function (e) {
        const e_target = jQuery(e.target).attr('class');
        if(e_target == 'person-description-tooltip' ){
            return false;
        }
    });
    jQuery('.customer-info-field').on('click', ' .mm-collapse-title', function (e) {
        const e_target = jQuery(e.target).attr('class');
        if(e_target != 'mm-guestinfo-tooltip' && e_target != 'tooltip-content'){
            jQuery(this).closest('.customer-info-item').toggleClass('mm-collapse-open');
        }
    });
    jQuery('.tm-collapse').on('click', ' .tm-section-label', function () {
       var collapse_wrap = jQuery(this).closest('.tm-collapse').find( ".tm-collapse-wrap" );
       if(collapse_wrap.hasClass( "closed" )){
           jQuery(this).closest('.tm-collapse').removeClass( "mmclosed mmopen" ).addClass( "mmclosed" );
       }
       else jQuery(this).closest('.tm-collapse').removeClass( "mmclosed mmopen" ).addClass( "mmopen" );
    });
    jQuery(document).on('click','.woocommerce-cart-form .product-remove > a',function (e) {
        if(jQuery('.woocommerce-cart-form .cart_item').length == '1'){
            window.location.href = jQuery(this).attr("href");
            return false;
        }
    });
    /*jQuery( ".tc-extra-product-options input.tmcp-checkbox" ).change(function() {
        return false;
    });*/
    if( jQuery('input[type="image"]').length ){
        jQuery('input[type="image"]').each(function() {
            var src_url = jQuery(this).data('src');
            if(src_url!=''){
                jQuery(this).attr("src", src_url);
            }
        });
    }
    jQuery(".hw-vacation-package .eapps-pricing-table-column-button").on("click", function() {
        var get_href = jQuery(this).attr("href");
        if(!jQuery(get_href).length){
            jQuery('html, body').animate({scrollTop: jQuery(".woocommerce-tabs").offset().top - 120}, "slow");
            jQuery( ".woocommerce-tabs ul.tabs  a[href='"+get_href+"']" ).trigger('click');
            return false;
        }
    });
    jQuery(".scroll-highlights-tab a.avia-button").on("click", function() {
        var get_href = jQuery(this).attr("href");
        if(!jQuery(get_href).length){
            jQuery('html, body').animate({scrollTop: jQuery("#itinerary-highlights").offset().top - 120}, "slow");
            jQuery( "#itinerary-highlights .av-tab-section-tab-title-container  a[href='"+get_href+"']" ).trigger('click');
            return false;
        }
    });
    /*jQuery("form#category-select #category_id").on("change", function() {
        var category_id = jQuery(this).val();
        var certificate_id = jQuery('form#category-select input[name="certificate_id"]').val();
        jQuery('.mm_loader_ajax').css('display','');
        jQuery.ajax({
            type: "post",
            dataType: "text",
            url: AJAX.url,
            data: {
                action: "mm_ajax_load_certificate_tag",
                category_id: category_id,
                certificate_id: certificate_id,
                change_category: true
            },
            success: function (response) {
                jQuery('.mm_loader_ajax').css('display','none');
                jQuery('.template-shop .entry-content-wrapper').html(response);
                jQuery('.product.type-product .inner_product_header').matchHeight();
            },
            error: function (jqXHR, textStatus, errorThrown) {
            },
        });
    });*/
    jQuery("form#category-select .mm-button-filter").on("click", function() {
        var category_id = jQuery("form#category-select select#category_id").val();
        var tag_id = jQuery("form#category-select select#tag_id").val();
        var certificate_id = jQuery('form#category-select input[name="certificate_id"]').val();
        jQuery('.mm_loader_ajax').css('display','');
        jQuery.ajax({
            type: "post",
            dataType: "text",
            url: AJAX.url,
            data: {
                action: "mm_ajax_load_certificate_tag",
                category_id: category_id,
                tag_id: tag_id,
                certificate_id: certificate_id,
                change_category: true
            },
            success: function (response) {
                jQuery('.mm_loader_ajax').css('display','none');
                jQuery('main.template-shop .entry-content-wrapper').html(response);
                jQuery('.product.type-product .inner_product_header').matchHeight();
            },
            error: function (jqXHR, textStatus, errorThrown) {
            },
    });
        return false;
    });
    jQuery(".template-shop").on("click", ".mm-product-load-more", function(e) {
        e.preventDefault();
        var category_id = jQuery('form#category-select #category_id').val();
        var certificate_id = jQuery('form#category-select input[name="certificate_id"]').val();
        var tag_id = jQuery("form#category-select select#tag_id").val();
        var page = jQuery(this).data('page') + 1;
        var max_page = jQuery(this).data('max_page');
        jQuery('#load-more .custom-loading-icon').css('display','');
        
        jQuery.ajax({
            type: "post",
            dataType: "text",
            url: AJAX.url,
            data: {
                action: "mm_ajax_load_certificate_tag",
                category_id: category_id,
                certificate_id: certificate_id,
                tag_id: tag_id,
                page: page
                
            },
            success: function (response) {
                jQuery('.mm_loader_ajax').css('display','none');
                jQuery( ".template-shop ul.products" ).append( response );
                if(page >= max_page){
                    jQuery('.mm-product-load-more').css('display', 'none');
                }
                else{
                    jQuery('.mm-product-load-more').data( "page", page );
                }
                jQuery('#load-more .custom-loading-icon').css('display','none');
                setTimeout(function(){ jQuery('.products .product.type-product .inner_product_header').matchHeight(); }, 3000);
                //jQuery('.products .product.type-product .inner_product_header').matchHeight();
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
            },
        });
        return false;
    });
    jQuery(".sort-filter-category #category_id").on("change", function() {
        var category_id = jQuery(this).val();
        jQuery(this).closest('.mm_filter_product_element').find("li.product").each(function () {
            if(category_id == '-1'){
                jQuery(this).css('display','');
            }
            else if(jQuery(this).hasClass(category_id)){
                jQuery(this).css('display','');
            }   
            else{
                jQuery(this).css('display','none');
            }
        });
    });
    jQuery(".avia-icon-faq-list .mmfaq .av_iconlist_title").on("click", function() {
        var iconlist_content = jQuery(this).closest('li.mmfaq').find('.iconlist_content');
        if(iconlist_content.css('display') == 'none'){
            iconlist_content.show( "slow" );
        }
        else{
            iconlist_content.hide( "slow" );
        }
    });
    if( jQuery('.avia-icon-faq-list .mmfaq').length ){
        var tmp = 0;
        jQuery(".avia-icon-faq-list .mmfaq").each(function () {
            tmp++;
            if(tmp>3){
                jQuery(this).find('.iconlist_content').css('display','none');
            }
        });
    }
    //hide content checkout
    // if(jQuery(".variation-CustomerInfo").length>0){
        // console.log("i");
    //     jQuery(".tc-value.variation-CustomerInfo p:contains('This field')").hide();
    // }
    if(jQuery('.weight_option_hilo-div').length){
        //jQuery('<span class="mm-weight-note">+$100 for guests 265 to 300 lbs<br>+$248.77 for guests 300+ lbs</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.weight_hono-div').length && jQuery('.postid-9292').length){
        //jQuery('<span class="mm-weight-note">+$172.5 for guests greater than 240 lbs</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.total_weight_400-div').length){
        var text_descrition = jQuery('.total_weight_400-div:not(.tc-hidden) .total_weight_400-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.total_weight_420-div').length){
        var text_descrition = jQuery('.total_weight_420-div:not(.tc-hidden) .total_weight_420-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.total_weight_470-div').length){
        var text_descrition = jQuery('.total_weight_470-div:not(.tc-hidden) .total_weight_470-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.weight_hono-div').length){
        var price_guest = jQuery('.form_person_0 .price-person').data('cost-person');
        var text_descrition = jQuery('.weight_hono-div:not(.tc-hidden) .weight_hono-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
        /*if(jQuery('.postid-192152').length){
            jQuery('<span class="mm-weight-note">+$'+price_guest+' for guests greater than 230 lbs</span>').insertAfter('.customer-info-item .mm-unit');
        }
        else jQuery('<span class="mm-weight-note">+$'+price_guest+' for guests greater than 240 lbs</span>').insertAfter('.customer-info-item .mm-unit');*/
    }
    if(jQuery('.weight_option_260_280-div').length){
        var text_descrition_260 = jQuery('.weight_option_260_280-div:not(.tc-hidden) .weight_option_260_280-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        var text_descrition_280 = jQuery('.weight_option_260_280-div:not(.tc-hidden) .weight_option_260_280-ul li:nth-child(2) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition_280+'</span>').insertAfter('.customer-info-item .mm-unit');
        jQuery('<span class="mm-weight-note">'+text_descrition_260+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.weight_option_240_290-div').length){
        var text_descrition_240 = jQuery('.weight_option_240_290-div:not(.tc-hidden) .weight_option_240_290-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        var text_descrition_290 = jQuery('.weight_option_240_290-div:not(.tc-hidden) .weight_option_240_290-ul li:nth-child(2) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition_240+'</span>').insertAfter('.customer-info-item .mm-unit');
        jQuery('<span class="mm-weight-note">'+text_descrition_290+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.weight_option_230-div').length){
        var price_guest = jQuery('.form_person_0 .price-person').data('cost-person');
        var text_descrition = jQuery('.weight_option_230-div:not(.tc-hidden) .weight_option_230-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.weight_option_270-div').length){
        var price_guest = jQuery('.form_person_0 .price-person').data('cost-person');
        var text_descrition = jQuery('.weight_option_270-div:not(.tc-hidden) .weight_option_270-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.weight_option_285-div').length){
        var price_guest = jQuery('.form_person_0 .price-person').data('cost-person');
        var text_descrition = jQuery('.weight_option_285-div:not(.tc-hidden) .weight_option_285-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.weight_option_290-div').length){
        var price_guest = jQuery('.form_person_0 .price-person').data('cost-person');
        var text_descrition = jQuery('.weight_option_290-div:not(.tc-hidden) .weight_option_290-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.weight_option_300-div').length){
        var price_guest = jQuery('.form_person_0 .price-person').data('cost-person');
        var text_descrition = jQuery('.weight_option_300-div:not(.tc-hidden) .weight_option_300-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    if(jQuery('.weight_option_260-div').length){
        var price_guest = jQuery('.form_person_0 .price-person').data('cost-person');
        var text_descrition = jQuery('.weight_option_260-div:not(.tc-hidden) .weight_option_260-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
        jQuery('<span class="mm-weight-note">'+text_descrition+'</span>').insertAfter('.customer-info-item .mm-unit');
    }
    /*jQuery("#top form.cart .tm-quantity .button.qty_minus").on("click", function() {
        var new_qty = parseInt(jQuery(this).closest('.tm-quantity').find('.tm-qty').val()) - 1;
        if(new_qty>=0){
            jQuery(this).closest('.tm-quantity').find('.tm-qty').val(new_qty);
        }
    });
    jQuery("#top form.cart .tm-quantity .button.qty_plus").on("click", function() {
        var new_qty = parseInt(jQuery(this).closest('.tm-quantity').find('.tm-qty').val()) + 1;
        jQuery(this).closest('.tm-quantity').find('.tm-qty').val(new_qty);
    });
    */
    /*Addons option maui private tour*/
    jQuery(".tm-extra-product-options ul.tmcp-elements ").on('click', '.tc-mm-disable', function(e) {
        e.preventDefault();
        return false;
    });
    if( jQuery('.postid-34517').length ){
        setTimeout(function(){
        jQuery(".maui_private_addons label.tm-epo-field-label").on("click", function() {
            if(!jQuery(this).closest('li.tmcp-field-wrap').hasClass('tc-mm-disable')){
                var option_title = jQuery(this).find('.tm-label').text();
                var get_check = jQuery(this).find('input[type="checkbox"]').prop("checked");

                if(option_title.indexOf("Pipiwai Hiking Trip") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(get_check == true){
                            if(option_title.indexOf("Road To Hana") >= 0){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', true);
                                jQuery(this).addClass('tc-active');
                            }
                            if(option_title.indexOf("Sit-Down Lunch") >= 0 || option_title.indexOf("Garden Of Eden") >= 0 || option_title.indexOf("Kahanu Garden") >= 0 || option_title.indexOf("Hana Cave") >= 0 || option_title.indexOf("Tasting Tour") >= 0 || option_title.indexOf("Iao Valley") >= 0){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }
                        }else{
                            if(option_title.indexOf("Sit-Down Lunch") >= 0 || option_title.indexOf("Garden Of Eden") >= 0 || option_title.indexOf("Kahanu Garden") >= 0 || option_title.indexOf("Hana Cave") >= 0 || option_title.indexOf("Tasting Tour") >= 0 || option_title.indexOf("Iao Valley") >= 0){
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                            if(option_title.indexOf("Road To Hana") >= 0){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                            }
                        }
                    });
                }
                if(option_title.indexOf("Road To Hana") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(option_title.indexOf("Tasting Tour") >= 0 || option_title.indexOf("Iao Valley") >= 0){
                            if(get_check == true){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }else{
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }
                        

                    });
                }
                if(option_title.indexOf("Tasting Tour") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(option_title.indexOf("Road To Hana") >= 0 || option_title.indexOf("Iao Valley") >= 0){
                            if(get_check == true){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }else{
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }
                        

                    });
                }
                if(option_title.indexOf("Iao Valley") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(get_check == true){
                            if(option_title.indexOf("Road To Hana") >= 0 || option_title.indexOf("Tasting Tour") >= 0){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }
                        }else{
                            if(option_title.indexOf("Road To Hana") >= 0 || option_title.indexOf("Tasting Tour") >= 0){
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }

                    });
                }
                if(option_title.indexOf("Maui Winery") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(get_check == true){
                            if(option_title.indexOf("Kahanu Garden") >= 0 || option_title.indexOf("Hana Cave") >= 0 || option_title.indexOf("Tasting Tour") >= 0 || option_title.indexOf("Road To Hana") >= 0 || option_title.indexOf("Sit-Down Lunch") >= 0 || option_title.indexOf("Pipiwai Hiking Trip") >= 0){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }
                        }else{
                            if(option_title.indexOf("Kahanu Garden") >= 0 || option_title.indexOf("Hana Cave") >= 0 || option_title.indexOf("Tasting Tour") >= 0 || option_title.indexOf("Road To Hana") >= 0 || option_title.indexOf("Sit-Down Lunch") >= 0 || option_title.indexOf("Pipiwai Hiking Trip") >= 0){
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }

                    });
                }
                if(option_title.indexOf("Kahanu Garden") >= 0 || option_title.indexOf("Hana Cave") >= 0 || option_title.indexOf("Pipiwai Hiking Trip") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(get_check == true){
                            if(option_title.indexOf("Maui Winery") >= 0){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }
                        }else{
                            if(option_title.indexOf("Maui Winery") >= 0){
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }

                    });
                }
                if(option_title.indexOf("Sit-Down Lunch") >= 0 ){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(option_title.indexOf("Road To Hana") >= 0 || option_title.indexOf("Kahanu Garden") >= 0 || option_title.indexOf("Hana Cave") >= 0 || option_title.indexOf("Tasting Tour") >= 0 || option_title.indexOf("Pipiwai Hiking Trip") >= 0 || option_title.indexOf("Maui Winery") >= 0){
                            if(get_check == true){
                            
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }
                            else{
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }

                    });
                }
                if(option_title.indexOf("Kahanu Garden") >= 0 || option_title.indexOf("Hana Cave") >= 0 || option_title.indexOf("Garden Of Eden") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(option_title.indexOf("Tasting Tour") >= 0 || option_title.indexOf("Iao Valley") >= 0 || option_title.indexOf("Pipiwai Hiking Trip") >= 0){
                            if(get_check == true){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }else{
                                jQuery(this).removeClass('tc-mm-disable');
                                
                            }
                        }
                        if(get_check == true){
                            if(option_title.indexOf("Road To Hana") >= 0 && !jQuery(this).hasClass('tc-mm-disable')){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', true);
                                jQuery(this).addClass('tc-active');
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }else{
                            if(option_title.indexOf("Road To Hana") >= 0){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                            }
                        }

                    });
                }
                if(option_title.indexOf("Kahanu Garden") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(option_title.indexOf("Hana Cave") >= 0 || option_title.indexOf("Garden Of Eden") >= 0 || option_title.indexOf("Sit-Down Lunch") >= 0){
                            if(get_check == true){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }else{
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }

                    });
                }
                if(option_title.indexOf("Hana Cave") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(option_title.indexOf("Kahanu Garden") >= 0 || option_title.indexOf("Garden Of Eden") >= 0 || option_title.indexOf("Sit-Down Lunch") >= 0){
                            if(get_check == true){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }else{
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }

                    });
                }
                if(option_title.indexOf("Garden Of Eden") >= 0){
                    jQuery(".maui_private_addons li.tmcp-field-wrap").each(function() {
                        var option_title = jQuery(this).find('.tm-label').text();
                        if(option_title.indexOf("Hana Cave") >= 0 || option_title.indexOf("Kahanu Garden") >= 0){
                            if(get_check == true){
                                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                                jQuery(this).removeClass('tc-active');
                                jQuery(this).addClass('tc-mm-disable');
                            }else{
                                jQuery(this).removeClass('tc-mm-disable');
                            }
                        }

                    });
                }
            }
        });
        },500);
    }
    if( jQuery('.click-for-waitlist').length ){
        jQuery('.click-for-waitlist').magnificPopup({
            type: 'inline',
            preloader: false
            
        });

    }
    jQuery('.mmt-button-waitlist .mmt-button, .product-button-call .mmt-button').click(function () {
        var tour_name = jQuery("#wc_bookings_field_resource option:selected").html();
        var count_person = 0;
        jQuery("#wc-bookings-booking-form .form_field_person").each(function () {
            var person_name = jQuery(this).find('.person-name').text();
            //console.log(person_name);
            if(person_name.toLowerCase().indexOf("adult") >= 0){
                var count_adult = parseInt(jQuery(this).find('input[type="number"]').attr('data-value'));
               // console.log(typeof(count_adult));
                jQuery('#nf-form-14-cont .adults').val(count_adult);
            }
            if(person_name.toLowerCase().indexOf("child") >= 0){
                var count_child = parseInt(jQuery(this).find('input[type="number"]').attr('data-value'));
                //console.log(typeof(count_child));
                jQuery('#nf-form-14-cont .children').val(count_child);

            }
            count_person += parseInt(jQuery(this).find('.content-person input[type="number"]').attr("data-value"));
        });
        var mm_day = jQuery("#wc-bookings-booking-form .wc-bookings-date-picker-date-fields .booking_date_day").val();
        var mm_month = jQuery("#wc-bookings-booking-form .wc-bookings-date-picker-date-fields .booking_date_month").val();
        var mm_year = jQuery("#wc-bookings-booking-form .wc-bookings-date-picker-date-fields .booking_date_year").val();
        var m_length = mm_month.length;
        var m_d = mm_day.length;
        mm_month = (m_length < 2 ? '0' : '') + mm_month;
        mm_day = (m_d < 2 ? '0' : '') + mm_day;

        let mm_check_date = false;

        if (mm_month != 0 && mm_day != 0 && mm_year != 0) {
            mm_check_date = true;
        }

        var pickupTime = mm_month+'/'+mm_day+'/'+mm_year;
        jQuery('#click-for-waitlist #nf-form-14-cont input.tour_name').val(tour_name);
        jQuery('#click-for-waitlist #nf-form-14-cont input.number_of_guests').val(count_person);

        if (mm_check_date == true) {
            jQuery('#click-for-waitlist #nf-form-14-cont input.tour_date').val(pickupTime);
            jQuery('#click-for-waitlist #nf-form-14-cont input#nf-field-342').val(pickupTime);
        } else {
            let mm_date_current = new Date(new Date().toLocaleString("en-US", {timeZone: "Pacific/Honolulu"}));
            let mm_date_current_day = String(mm_date_current.getDate()).padStart(2, '0');
            let mm_date_current_month = String(mm_date_current.getMonth() + 1).padStart(2, '0');
            let mm_date_current_year = mm_date_current.getFullYear();
            let mm_date_current_formatted = mm_date_current_month + '/' + mm_date_current_day + '/' + mm_date_current_year;

            jQuery('#click-for-waitlist #nf-form-14-cont input.tour_date').val(mm_date_current_formatted);
            jQuery('#click-for-waitlist #nf-form-14-cont input#nf-field-342').val(mm_date_current_formatted);
        }

        if( jQuery( ".list-costs-island" ).length > 0 ){
            jQuery( ".list-costs-island > li" ).each(function( index ) {
                var value_island = jQuery(this).data("island") ;
                //var _this = jQuery( this );
                var is_select = jQuery( this ).hasClass("selected") ;
                if( is_select ){
                    jQuery( "#nf-form-14-cont .listcheckbox-wrap ul li" ).each(function( index ) {
                        var value_checkbox = jQuery( this ).find('input[type="checkbox"]').attr("value");
                        if(  value_island ==  value_checkbox ){
                            jQuery( this ).find('input[type="checkbox"]').trigger('click');
                            jQuery( this ).find('input[type="checkbox"]').attr("checked", "checked");
                            jQuery( this ).find('input[type="checkbox"]').addClass("nf-checked");
                            jQuery( this ).find('label').addClass("nf-checked-label");
                        }else{
                            jQuery( this ).find('input[type="checkbox"]').removeAttr("checked");
                            jQuery( this ).find('input[type="checkbox"]').removeClass("nf-checked");
                            jQuery( this ).find('label').removeClass("nf-checked-label");
                        }

                        switch(value_island){
                            case 'Hilo' :
                            case 'Kona' :
                                if( value_checkbox == "BigIsland"){
                                    jQuery( this ).find('input[type="checkbox"]').trigger('click');
                                    jQuery( this ).find('input[type="checkbox"]').attr("checked", "checked");
                                    jQuery( this ).find('input[type="checkbox"]').addClass("nf-checked");
                                    jQuery( this ).find('label').addClass("nf-checked-label");
                                }else{
                                    jQuery( this ).find('input[type="checkbox"]').removeAttr("checked");
                                    jQuery( this ).find('input[type="checkbox"]').removeClass("nf-checked");
                                    jQuery( this ).find('label').removeClass("nf-checked-label");
                                }
                                break;
                            case 'Waikiki' :
                            case 'Waikiki (Small Group)' :
                            case 'Waikiki (Large Group)' :
                            case 'Turtle Bay' :
                            case 'Ko Olina' :
                                if( value_checkbox == "Oahu"){
                                    jQuery( this ).find('input[type="checkbox"]').trigger('click');
                                    jQuery( this ).find('input[type="checkbox"]').attr("checked", "checked");
                                    jQuery( this ).find('input[type="checkbox"]').addClass("nf-checked");
                                    jQuery( this ).find('label').addClass("nf-checked-label");
                                }else{
                                    jQuery( this ).find('input[type="checkbox"]').removeAttr("checked");
                                    jQuery( this ).find('input[type="checkbox"]').removeClass("nf-checked");
                                    jQuery( this ).find('label').removeClass("nf-checked-label");
                                }
                                break;
                            case 'Lihue' :
                                if( value_checkbox == "Kauai"){
                                    jQuery( this ).find('input[type="checkbox"]').trigger('click');
                                    jQuery( this ).find('input[type="checkbox"]').attr("checked", "checked");
                                    jQuery( this ).find('input[type="checkbox"]').addClass("nf-checked");
                                    jQuery( this ).find('label').addClass("nf-checked-label");
                                }else{
                                    jQuery( this ).find('input[type="checkbox"]').removeAttr("checked");
                                    jQuery( this ).find('input[type="checkbox"]').removeClass("nf-checked");
                                    jQuery( this ).find('label').removeClass("nf-checked-label");
                                }
                                break;
                            case 'Kahului' :
                                if( value_checkbox == "Maui"){
                                    jQuery( this ).find('input[type="checkbox"]').trigger('click');
                                    jQuery( this ).find('input[type="checkbox"]').attr("checked", "checked");
                                    jQuery( this ).find('input[type="checkbox"]').addClass("nf-checked");
                                    jQuery( this ).find('label').addClass("nf-checked-label");
                                }else{
                                    jQuery( this ).find('input[type="checkbox"]').removeAttr("checked");
                                    jQuery( this ).find('input[type="checkbox"]').removeClass("nf-checked");
                                    jQuery( this ).find('label').removeClass("nf-checked-label");
                                }
                                break;
                        }
                    });



                }
            });
        }
    });
    if( jQuery('.mm_certificate_tag').length ){
        jQuery(".mm_certificate_tag").each(function () {
            jQuery(this).closest( '.av_default_container_wrap' ).addClass('section_certificate_tag');
        });
    }
    /*Fix timezone booking*/
    if(jQuery('.mm-calendar-absolute .picker').length){
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var year = d.getFullYear();
        if(month < 10){
            month = '0' + month;
        }
        if(day < 10){
            day = '0' + day;
        }
        var ymdIndex_format = year + '-' + month + '-' + day;
        var get_form_current_date = jQuery('.mm-calendar-absolute .picker').data('current_date');
        //get_form_current_date = get_form_current_date.replace("-", "");
        //get_form_current_date = get_form_current_date.replace("-", "");
        if(get_form_current_date!='' && new Date(ymdIndex_format)< new Date(get_form_current_date)){
            jQuery('.mm-calendar-absolute .picker').data('current_date',year+'-'+month+'-'+day);
            var min_date_js = jQuery('.mm-calendar-absolute .picker').data('min_date_js');
            var ex_min_date = min_date_js.split('-');
            var min_date = new Date(Date.UTC(ex_min_date[0],ex_min_date[1] - 1,ex_min_date[2]));
            min_date.setDate(min_date.getDate() + 1);
            var m_day = min_date.getDate();
            var m_month = min_date.getMonth() + 1;
            var m_year = min_date.getFullYear();
            if(m_month < 10){
                m_month = '0' + m_month;
            }
            if(m_day < 10){
                m_day = '0' + m_day;
            }
            var m_date_format = m_year + '-' + m_month + '-' + m_day;
            jQuery('.mm-calendar-absolute .picker').data('min_date_js',m_date_format);
        }
    }
    /*Restaurant ajax*/
    function handleRestaurantFilterAjax(e) {
        e.preventDefault();
        let mthis = jQuery(this);
        let action = "mm_ajax_filter_restaurant";
        if(mthis.closest('.sidebar-restaurant').hasClass('sidebar-hotel')){
            action = "mm_ajax_filter_hotel";
        }
        if(mthis.closest('ul').hasClass('list-restaurant-term')){
            mthis.closest('ul').find('li').removeClass('active');
            mthis.addClass('active');
        }
        if(mthis.closest('ul').hasClass('restaurant-categories-child')){
            jQuery('ul.list-restaurant-term.restaurant-categories.restaurant-categories-parent li').removeClass('active');
            mthis.addClass('active');
        }
        jQuery('#search_restaurants').addClass('restaurant_loader_ajax');
        let search = jQuery('.sidebar-restaurant #s').val();
        let categories = jQuery('.sidebar-restaurant .restaurant-categories li.active').data('id');
        let island = jQuery('.sidebar-restaurant .restaurant-island li.active').data('id');
        let tags = jQuery('.sidebar-restaurant .restaurant-tags li.active').data('id');
        let items = jQuery('.sidebar-restaurant .restaurant-island li.active').data('items');

        let cateParam = '';
        let islandParam = '';
        if(jQuery('.sidebar-restaurant .restaurant-island li.active').data('island')) {
            cateParam = jQuery('.sidebar-restaurant .restaurant-island li.active').data('island');
        }
        if(jQuery('.sidebar-restaurant .restaurant-categories li.active').data('cate')) {
            islandParam = jQuery('.sidebar-restaurant .restaurant-categories li.active').data('cate');
        }
        setURLSearchParam('key_search', search);
        setURLSearchParam('island', cateParam);
        setURLSearchParam('cate', islandParam);

        jQuery('.mm-list-restaurants-inner').html('<span class="mm-hotel-loader"></span>');
        jQuery('html, body').animate({
            scrollTop: jQuery(".mm-list-restaurants").offset().top - 200
        }, 1000);
        jQuery.ajax({
            type: "post",
            dataType: "text",
            url: AJAX.url,
            data: {
                action: action,
                search: search,
                island: island,
                categories: categories,
                items: items,
                tags: tags
            },
            success: function (response) {
                const result = JSON.parse(response);
                jQuery('.mm-list-restaurants-inner').html(result['output']);
                jQuery('#list_restaurants .restaurant-pagination').html(result['output_pagination']);
                jQuery('#search_restaurants').removeClass('restaurant_loader_ajax');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            },
        });
        return false;
    }

    jQuery(".sidebar-restaurant").on("click", ".list-restaurant-term li:not(.is-parent), #search_restaurants", handleRestaurantFilterAjax);
    jQuery('#restaurants #s').keyup(function(e){
        if(e.which === 13){
            handleRestaurantFilterAjax.call(this, e);
        }
    });
    jQuery('#hotels #s').keyup(function(e){
        if(e.which === 13){
            handleRestaurantFilterAjax.call(this, e);
        }
    });

    jQuery('.list-restaurant-term .is-parent.item_cate').click(function () {
        jQuery(this).toggleClass('show');
    });

    function setURLSearchParam(key, value) {
        const url = new URL(window.location.href);
        url.searchParams.set(key, value);
        window.history.pushState({ path: url.href }, '', url.href);
    }

    getResultHotelsRestaurants();
    function getResultHotelsRestaurants(e) {
        let search = jQuery('.sidebar-restaurant #s').val();
        let categories = jQuery('.sidebar-restaurant .restaurant-categories li.active').data('cate');
        let island = jQuery('.sidebar-restaurant .restaurant-island li.active').data('island');
        if(search == '' & categories == 'all-categories' & island == 'all-island') {
            return false;
        }
        if(search != '' || categories != 'all-categories' || island != 'all-island') {
            jQuery('input#search_restaurants').click();
            if (jQuery("#list_restaurants").length) {
                jQuery('html, body').animate({
                    scrollTop: jQuery("#list_restaurants").offset().top - 200
                }, 1000);
            }
        }
    }

    // ajax pagination hotel
    jQuery(".restaurant-pagination").on("click", ".mm-pagination-hotel > a", function(e) {
        e.preventDefault();
        let mthis = jQuery(this);
        let action = "mm_ajax_pagination_hotel";
        let paged = mthis.data('paged');
        let island = jQuery('.sidebar-restaurant .restaurant-island li.active').data('id');
        let categories = jQuery('.sidebar-restaurant .restaurant-categories li.active').data('id');
        let tags = jQuery('.sidebar-restaurant .restaurant-tags li.active').data('id');
        let search = jQuery('.sidebar-restaurant #s').val();
        jQuery('.mm-list-restaurants-inner').html('<span class="mm-hotel-loader"></span>');
        jQuery('.mm-pagination-hotel').html('');
        jQuery('html, body').animate({
            scrollTop: jQuery(".mm-list-restaurants").offset().top - 200
        }, 100);
        jQuery.ajax({
            type: "post",
            dataType: "text",
            url: AJAX.url,
            data: {
                action: action,
                search: search,
                paged: paged,
                island: island,
                categories: categories,
                tags: tags
            },
            success: function (response) {
                const result = JSON.parse(response);
                jQuery('.mm-list-restaurants-inner').html(result['output']);
                jQuery('#list_restaurants .restaurant-pagination').html(result['output_pagination']);
                mthis.removeClass('restaurant_loader_ajax');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            },
        });
        return false;
    });

    // ajax pagination restaurant
    jQuery(".restaurant-pagination").on("click", ".mm-pagination-restaurant > a", function(e) {
        e.preventDefault();
        let mthis = jQuery(this);
        let action = "mm_ajax_pagination_restaurant";
        let paged = mthis.data('paged');
        let island = jQuery('.sidebar-restaurant .restaurant-island li.active').data('id');
        let categories = jQuery('.sidebar-restaurant .restaurant-categories li.active').data('id');
        let tags = jQuery('.sidebar-restaurant .restaurant-tags li.active').data('id');
        let search = jQuery('.sidebar-restaurant #s').val();
        jQuery('.mm-list-restaurants-inner').html('<span class="mm-hotel-loader"></span>');
        jQuery('.mm-pagination-hotel').html('');
        jQuery('html, body').animate({
            scrollTop: jQuery(".mm-list-restaurants").offset().top - 200
        }, 100);
        jQuery.ajax({
            type: "post",
            dataType: "text",
            url: AJAX.url,
            data: {
                action: action,
                search: search,
                paged: paged,
                island: island,
                categories: categories,
                tags: tags
            },
            success: function (response) {
                const result = JSON.parse(response);
                jQuery('.mm-list-restaurants-inner').html(result['output']);
                jQuery('#list_restaurants .restaurant-pagination').html(result['output_pagination']);
                mthis.removeClass('restaurant_loader_ajax');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            },
        });
        return false;
    });
    /* End Restaurant ajax*/
    // Blogs filter ajax
    function mmHandleFilteringBlogsAjax (e) {
        e.preventDefault();
        let mthis = jQuery(this);
        let action = "mm_ajax_filter_blogs";
        mthis.closest('ul').find('li').removeClass('active');
        mthis.addClass('active');
        let search = jQuery('.blogs-page-filtering-sidebar #s').val();
        let island = jQuery('.blogs-page-filtering-sidebar .blogs-island li.active').data('id');
        let paged = jQuery(mthis).data('paged');
        let number = jQuery(mthis).data('number');
        let category = jQuery('.blogs-page-filtering-sidebar .blogs-categorys li.active').data('id');
        jQuery('.blogs-page-filtering-list-inner').html('<span class="mm-hotel-loader"></span>');
        jQuery('html, body').animate({
            scrollTop: jQuery(".blogs-page-filtering-list").offset().top - 200
        }, 1000);
        jQuery.ajax({
            type: "post",
            dataType: "text",
            url: AJAX.url,
            data: {
                action: action,
                search: search,
                island: island,
                paged: paged,
                number: number,
                category: category
            },
            success: function (response) {
                const result = JSON.parse(response);
                jQuery('.blogs-page-filtering-list-inner').html(result['blogs']);
                jQuery('.mm-blogs-pagination').html(result['pagination']);
            },
            error: function (jqXHR, textStatus, errorThrown) {
            },
        });
        return false;
    }
    jQuery(".blogs-page-filtering-sidebar").on("click", ".blogs-categorys li, .blogs-island li, #search_blogs", mmHandleFilteringBlogsAjax);
    jQuery(".mm-blogs-pagination").on("click", ".mm-blogs-pagination-links .mm-blogs-pagination-num", mmHandleFilteringBlogsAjax);
    jQuery('.blogs-page-filtering-sidebar #s').keyup(function(e){
        if(e.which === 13){
            mmHandleFilteringBlogsAjax.call(this, e);
        }
    });
    jQuery('.blogs-page-btn-see-more').click(function () {
        jQuery('#top #container_category.blogs-page .content-category').addClass('see-all-blogs');
        jQuery(this).remove();
    });
    if(jQuery('.mm-blogs-post.blogs-page.mm-blogs-slider .content-category').length){
        jQuery('.mm-blogs-post.blogs-page.mm-blogs-slider .content-category').slick({
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [
                {
                    breakpoint: 990,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
    // End Blogs filter ajax

    if(jQuery('.archive.tax-restaurant_categories article').length || jQuery('.archive.tax-restaurant_island article').length){
        jQuery('article .slide-content').matchHeight();
    }
    if(jQuery('#restaurants').length && jQuery('#list_restaurants').length &&jQuery('.restaurant-pagination').length){
        jQuery('.restaurant-pagination a').each(function () {
           var href = jQuery(this).attr('href');
           href = href.replace("list_restaurants", "restaurants");
           jQuery(this).attr('href',href);
        });
    }
    jQuery(document).on( 'nfFormReady', function( e, layoutView ) {
        if(jQuery('.ninja-forms-field.datepicker.input').length){
            jQuery('.ninja-forms-field.datepicker.input').attr('readonly', 'readonly');
        }
        if(jQuery('#nf-form-12-cont .travel_date').length && jQuery('#nf-form-12-cont .travel_date .ninja-forms-field[type="hidden"]').val()==''){
            var d = new Date();
            d.setDate(d. getDate() + 7); 
            var month = d.getMonth()+1;
            var day = d.getDate();
            var year = d.getFullYear();
            var output =  (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' + year;
            jQuery('#nf-form-12-cont .travel_date .ninja-forms-field').val(output);
        }
    });
    jQuery(document).on('click', '.nf-next, a.nf-breadcrumb', function(e, layoutView ) {
        if(jQuery('.ninja-forms-field.datepicker.input').length){
            jQuery('.ninja-forms-field.datepicker.input').attr('readonly', 'readonly');
        }
        if(jQuery('#nf-form-12-cont .travel_date').length && jQuery('#nf-form-12-cont .travel_date .ninja-forms-field[type="hidden"]').val()==''){
            var d = new Date();
            d.setDate(d. getDate() + 7); 
            var month = d.getMonth()+1;
            var day = d.getDate();
            var year = d.getFullYear();
            var output =  (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' + year;
            //jQuery('#nf-form-12-cont .travel_date .ninja-forms-field').val(output);
            var config =  {
                dateFormat: "m/d/Y",
                defaultDate: output,
            };
            jQuery('#nf-form-12-cont .travel_date .ninja-forms-field').flatpickr(config);
        }
    });
    if(jQuery('.woocommerce-checkout .validate-phone').length){
        jQuery('.woocommerce-checkout .validate-phone').append( '<span class="mobile-phone-description">If you have an international number, please download WhatsApp for better service in communicating with you about your experience(s).</span>' );
    }
    if(jQuery('.mmproduct-slider .products').length){
        jQuery('.mmproduct-slider .products ').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [

              {
                breakpoint: 767,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
              // You can unslick at a given breakpoint now by adding:
              // settings: "unslick"
              // instead of a settings object
            ]
        });
    }
    if(jQuery('.text-phone-number').length){
        var date_time_now = new Date(new Date().toLocaleString('en', {timeZone: 'Pacific/Honolulu'}));
        var month = date_time_now.getMonth() + 1; //months from 1-12
        var day = date_time_now.getDate();
        var year = date_time_now.getFullYear();
        var newdate = year + "/" + month + "/" + day;
        var time = date_time_now.getHours() + ":" + date_time_now.getMinutes() + ":" + date_time_now.getSeconds();
        var time_now = new Date(newdate + " " + time);
        time_now = time_now.getTime();
        var time_start = new Date(newdate + " " + "05:00:00");
        time_start = time_start.getTime();
        var time_end = new Date(newdate + " " + "21:00:00");
        time_end = time_end.getTime();
        if(time_now>=time_start && time_now <=time_end){
            var status = 'OPEN';
        }else{
            var status = 'CLOSED';
        }
        if(status == 'OPEN'){
            var output = '<a href="tel:1-808-379-3701"><div class="phone-number">1-808-379-3701</div><div class="time_open_wrrap open"><span class="now_is">Call Us Now</span></div></a>';
        }else{
            var output = '<div class="time_open_wrrap closed"><span class="time_open_wrrap_closed_heading">GOT A QUESTION?</span><span class="">We are currently</span><span class="">CLOSED</span><a href="/contact-us/">Email Us</a></div>';
        }
        jQuery('.text-phone-number .textwidget').html(output);
    }
    if(jQuery('.woofc-suggested-products .woofc-suggested-product-name').length){
        jQuery('.woofc-suggested-products .woofc-suggested-product-name').matchHeight();
    }
    if(jQuery('.tc-extra-product-options input.mm_pickup_time ').length){
        /*jQuery('.tc-extra-product-options input.mm_pickup_time').each(function () {
            jQuery( '<input type="time" class="input-text mm_pickup_time_field" name="mm_pickup_time_field" value="" >' ).insertAfter( jQuery(this) );
        });
        jQuery('.tc-extra-product-options').on('change', 'input.mm_pickup_time_field', function( e ) {
            var get_value = jQuery(this).val();
            if(get_value !=''){
                var mm_pickup_time = mm_Convert_time(get_value);
                jQuery(this).closest('.tmcp-field-wrap').find('input.mm_pickup_time').val(mm_pickup_time);
            }
        });
        */
        jQuery('.tc-extra-product-options input.mm_pickup_time.mm_time_min_7am').timepicker({
            timeFormat: 'h:mm p',
            interval: 5,
            startTime: '07:00',
            minTime: '7:00am',
            maxTime: '11:00pm',
            dynamic: true,
            dropdown: true,
            scrollbar: true,
            change: function(/*time*/) {
                jQuery(this).change();
            }
        });
        jQuery('.tc-extra-product-options input.mm_pickup_time.mm_time_5am_11pm').timepicker({
            timeFormat: 'h:mm p',
            interval: 5,
            startTime: '05:00',
            minTime: '5:00am',
            maxTime: '11:00pm',
            dynamic: true,
            dropdown: true,
            scrollbar: true,
            change: function(/*time*/) {
                jQuery(this).change();
            }
        });
        jQuery('.tc-extra-product-options input.mm_pickup_time:not(.mm_time_5am_11pm,.mm_time_min_7am)').timepicker({
            timeFormat: 'h:mm p',
            interval: 5,
            startTime: '06:00',
            dynamic: true,
            dropdown: true,
            scrollbar: true,
            change: function(/*time*/) {
                jQuery(this).change();
            }
        });
       
        jQuery('.tc-extra-product-options input.mm_pickup_time').attr('readonly', 'readonly');

    }
    function mm_Convert_time(time) {
        // Check correct time format and split into components
        time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

        if (time.length > 1) { // If time format correct
          time = time.slice(1); // Remove full string match value
          time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
          time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join(''); // return adjusted time or original string
    }
    /*Checkout page*/
    jQuery(".mm-list-order-item").on("click", ".product-sumary label.mm-toggle-sumary", function(e) {
    
        var show_option = jQuery(this).closest('.product-sumary').find('input[type="checkbox"]');
        var showtext = jQuery(this).data('showtext');
        var hidetext = jQuery(this).data('hidetext');
        if(show_option.is(':checked') ){
            jQuery(this).closest('.product-sumary').removeClass('show-product-sumary');
            jQuery(this).text(showtext);
        }else{
            jQuery(this).closest('.product-sumary').addClass('show-product-sumary');
            jQuery(this).text(hidetext);
        }
    });
    if (jQuery(window).width() < 768) {
        jQuery( ".woocommerce-checkout .width-your-order" ).prepend( jQuery('.woocommerce-checkout .woocommerce-checkout-payment') );
        jQuery( ".woocommerce-checkout #customer_details" ).prepend( jQuery('.woocommerce-checkout .mm-list-order-item') );
        //jQuery(".checkout.woocommerce-checkout #customer_details .col-1 .checkout-billing-custom .woocommerce-additional-fields").insertAfter(".checkout.woocommerce-checkout #customer_details .col-2 .width-your-order #order_review .shop_table");
        //jQuery(".checkout.woocommerce-checkout #customer_details .col-2 #order_review .woocommerce-additional-fields .title-private-tour").insertAfter(".checkout.woocommerce-checkout #customer_details .col-1 .checkout-billing-custom .woocommerce-shipping-fields");
        //jQuery(".checkout.woocommerce-checkout #customer_details .col-2 #order_review .woocommerce-additional-fields .mm-private-tours-island").insertAfter(".checkout.woocommerce-checkout #customer_details .col-1 .checkout-billing-custom .title-private-tour");
    }

    function adjustFieldWidth() {
        var zipField = jQuery('#billing_state_field');
        var stateField = jQuery('#billing_postcode_field');
        if (zipField.is(':visible')) {
            stateField.css('width', '');
        } else {
            stateField.css('width', '100%');
        }
        if (stateField.is(':visible')) {
            zipField.css('width', '');
        } else {
            zipField.css('width', '100%');
        }
    }
    adjustFieldWidth();
    jQuery('#billing_country').on('change', function() {
        setTimeout(function (){
            adjustFieldWidth();
        }, 200);
    });
    /*Show more MM Filter*/
    jQuery('.mm-filter-show-more').on('click', function () {
        jQuery(this).closest('.shop-filter-product').find('li.product').css('display','');
        jQuery(this).remove();

        return false;
    });
    jQuery( "#top:not(.mm-custom-builder) div.product .woocommerce-tabs #tab-highlights" ).addClass('active');
    jQuery( "#top:not(.mm-custom-builder) div.product .woocommerce-tabs .panel h5.yikes-custom-woo-tab-title" ).click(function( event ) {
        jQuery(this).parent().toggleClass('active');
    });

    // Menu Mobile
    jQuery(document).on('mousedown', '#top #av-burger-menu-ul li a' , function () {
        jQuery('#top .mm-item-active').removeClass('mm-item-active');
        jQuery(this).addClass('mm-item-active');
    });
});

jQuery(window).resize(function () {
    jQuery('.content-blog .blog-item.left .link-blog h3').matchHeight();
    if(jQuery('.woocommerce-checkout').length){
        if (jQuery(window).width() < 768) {
            if(!jQuery('#customer_details>.mm-list-order-item').length){
                jQuery( ".woocommerce-checkout .width-your-order" ).prepend( jQuery('.woocommerce-checkout .woocommerce-checkout-payment') );
                jQuery( ".woocommerce-checkout #customer_details" ).prepend( jQuery('.woocommerce-checkout .mm-list-order-item') );

            }
        } else {
            if(!jQuery('.width-your-order .mm-list-order-item').length){
                jQuery( ".woocommerce-checkout .width-your-order" ).prepend( jQuery('.woocommerce-checkout .mm-list-order-item') );
                jQuery( ".woocommerce-checkout .mm-list-order-item" ).append( jQuery('.woocommerce-checkout .woocommerce-checkout-payment') );

            }
        }
    }
});

jQuery(".avia-content-slider-inner .products.slide-entry-wrap li").removeClass("first");
jQuery(".avia-content-slider-inner .products.slide-entry-wrap li").removeClass("last");
jQuery(".avia-content-slider-inner .products.slide-entry-wrap li:first-child").addClass("first");
jQuery(".avia-content-slider-inner .products.slide-entry-wrap li:last-child").addClass("last");


lightBoxAllImage();
function lightBoxAllImage() {
    var groups = {};
    jQuery(".avia-image-container-inner a.avia_image.lightbox-added").attr("data-group", "1");
    jQuery('.avia-image-container-inner a.avia_image.lightbox-added').each(function () {
        var title = jQuery(this).children('img').attr("alt");
        jQuery(this).attr("title", title);
        var id = parseInt(jQuery(this).attr('data-group'), 10);

        if (!groups[id]) {
            groups[id] = [];
        }

        groups[id].push(this);
    });

    jQuery.each(groups, function () {
        jQuery(this).magnificPopup({
            type: 'image',
            titleSrc: 'title',
            closeOnContentClick: true,
            closeBtnInside: false,
            gallery: {enabled: true}
        });

    });
}

// fix link certificate
 
document.addEventListener("DOMContentLoaded", function(event) {


    changeLinKCertificate([
        {
            island : 'oahu',
            post_id: ['postid-3127','postid-138384','postid-108732','postid-107699','postid-107501','postid-107484','postid-107477',
            'postid-107428','postid-107367','postid-106898','postid-106884','postid-106872','postid-106856','postid-106849',
            'postid-106768','postid-106759','postid-106753','postid-106740','postid-105824','postid-105786','postid-105769',
            'postid-105724','postid-105115','postid-105107','postid-105103','postid-105081','postid-105073','postid-104933',
            'postid-103107','postid-87264','postid-86961','postid-86950','postid-86910','postid-86890','postid-86862','postid-86845',
            'postid-86822','postid-85177','postid-85158','postid-80211','postid-80186','postid-80182','postid-80178','postid-30978',
            'postid-24053','postid-24049','postid-24053','postid-22038','postid-22011','postid-9736','postid-15551','postid-10625',
            'postid-11773','postid-11310','postid-11294','postid-9383','postid-9292','postid-6665','postid-6189','postid-6171','postid-6162',
            'postid-6047','postid-3930','postid-3869','postid-3864','postid-3859','postid-3844','postid-3839','postid-3812','postid-3743',
            'postid-3713','postid-3575','postid-3565','postid-3127','postid-3113','postid-1120'],
            linkCer :['https://www.hawaiitours.com/oahu/family-activities-to-do/','https://www.hawaiitours.com/oahu/bucket-list-must-do-activities/']
        },
        {
            island : 'big-island',
            post_id: ['postid-44871','postid-92288','postid-91792','postid-91747','postid-90017','postid-89957','postid-89227','postid-8921',
            'postid-89186','postid-89181','postid-89142','postid-89119','postid-88563','postid-88537','postid-85289','postid-85283','postid-80028',
            'postid-80023','postid-80001','postid-79994','postid-79988','postid-79959','postid-4487','postid-27923','postid-27781','postid-27711',
            'postid-27411','postid-27335','postid-27179','postid-26793','postid-21478','postid-9972','postid-6059','postid-5590','postid-5418',
            'postid-5103','postid-5090','postid-5053','postid-3791','postid-3708','postid-3685','postid-3676','postid-3661','postid-3633','postid-3627',
            'postid-3619','postid-3613','postid-3607','postid-3007'],
            linkCer :['https://www.hawaiitours.com/big-island/family-activities-with-kids/','https://www.hawaiitours.com/big-island/bucket-list-must-do-activities/']
        },
        {
            island : 'maui',
            post_id: ['postid-104828','postid-104130','postid-104120','postid-104114','postid-104107','postid-103242','postid-103225','postid-103214',
            'postid-103200','postid-103182','postid-103158','postid-103117','postid-98208','postid-96093','postid-96075','postid-88523','postid-88504',
            'postid-86785','postid-86755','postid-86331','postid-86299','postid-80160','postid-80156','postid-79314','postid-79308','postid-79302','postid-79290',
            'postid-79242','postid-79176','postid-79162','postid-79158','postid-79154','postid-79137','postid-79111','postid-79107','postid-79103',
            'postid-79099','postid-79095','postid-79091','postid-79087','postid-79082','postid-79078','postid-79074','postid-49579','postid-66318',
            'postid-49702','postid-45485','postid-35159','postid-35149','postid-34517','postid-26848','postid-26633','postid-22106','postid-19463','postid-11261',
            'postid-6627','postid-6576','postid-6028','postid-6018','postid-6008','postid-5946','postid-5782','postid-5623','postid-5595','postid-5103',
            'postid-5090','postid-5053','postid-3967','postid-3957','postid-3941','postid-3936','postid-3920','postid-3915','postid-3904','postid-3768',
            'postid-3007'],
            linkCer: ['https://www.hawaiitours.com/maui/family-activities/','https://www.hawaiitours.com/maui/bucket-list-must-do-activities/']
        },
        {
            island: 'kauai',
            post_id:['postid-123239','postid-29346','postid-28772','postid-27830','postid-22106','postid-19710','postid-19126','postid-18929','postid-17212',
            'postid-6285','postid-5103','postid-5090','postid-5053','postid-3738','postid-3732','postid-3724','postid-3007'],
            linkCer:['https://www.hawaiitours.com/kauai/family-activities-with-kids/','https://www.hawaiitours.com/kauai/bucket-list-must-do-activities/']
        }
    ]);
    function replaceLinkForIsland(value) {
        var bodyElement = document.querySelector('body');
        var linkCerFamily = document.querySelector('.mm_certificate_tag a[alt="Family Friendly"]');
        var linkCerPopular = document.querySelector('.mm_certificate_tag a[alt="Most Popular"]');
        value.post_id.forEach(function (postId) {
            var isContainPost = bodyElement.classList.contains(postId);
            if(isContainPost){
                    if(linkCerFamily !== null){
                        linkCerFamily.href = value.linkCer[0];
                    }
                    if(linkCerPopular !== null){
                        linkCerPopular.href = value.linkCer[1];
                    }
                }
        });
    }

    function changeLinKCertificate(options){
        //console.log("oahu");
        options.forEach(function (value) {
            switch (value.island) {
                case "big-island":
                    replaceLinkForIsland(value);
                    //console.log("bigiland");
                    break;
                case "oahu":
                    //console.log("oahu");
                    replaceLinkForIsland(value);
                    break;
                case "maui":
                    //console.log("maui");
                    replaceLinkForIsland(value);
                    break;
                case "kauai":
                    //console.log("kaui");
                    replaceLinkForIsland(value);
                    break;

            }
        });
    }
});
jQuery( window ).on("load", function() {
    
    window.nrWrapper = function() {
        console.log('remove');
    };
    jQuery('.wc-bookings-booking-form-button').click(function(){
        if( jQuery('.has-error').length > 0 && jQuery('.customer-info-field.mm-hide-field-with-logic').length <= 0){
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery(".has-error:first").offset().top - 200
            }, 2000);
        }else{
            if( jQuery(".tm-error").length > 0 ){
                jQuery([document.documentElement, document.body]).animate({
                    scrollTop: jQuery(".has-error:first").offset().top - 200
                }, 2000);
            }
        }

    });
    // anchor link don't click tag woo
    var anchorLink = getAnchorLink();
    if( anchorLink !== null ){
        var targets = jQuery(anchorLink);
        if( targets.length ){
            var target_link_tabs = jQuery(anchorLink + ' > a');
            // target_link_tabs.removeClass('no-scroll');
            //console.log(anchorLink + ' > a');
            var scrollTos = targets.offset().top;
            jQuery('body, html').animate({scrollTop: scrollTos +'px'}, 400);
            target_link_tabs.click();
        }
    }
    var element_person_input = jQuery( '.form_field_person .content-person > input[type="number"]' );
    var person_number = element_person_input.val();
    var element_radio_li = jQuery( ".wrap__section-radio .tm-extra-product-options-container > ul.tm-element-ul-radio > li.tmcp-field-wrap" );
    var elemene_btn_qty =jQuery( '.form_field_person .content-person .button.circle' );
    var elemene_btn_qty_plus =jQuery( '.form_field_person .content-person .button.circle[data-quantity="plus"]' );
    var elemene_btn_qty_minus =jQuery( '.form_field_person .content-person .button.circle[data-quantity="minus"]' );

    if( element_radio_li.length > 0 ){
        element_radio_li.hide();
        element_radio_li.each(function( index ) {
            var _this = jQuery(this);
            if( index == 0 ){
                _this.show();
            }
            if( index <= parseInt(person_number)){
                _this.show();
            }
        });
        elemene_btn_qty_plus.on('click', function() {
            ++person_number;
            element_radio_li.each(function( index ) {
                var _this_el = jQuery(this);
                if( index  <=  person_number){
                    _this_el.show();
                }else{
                    _this_el.hide();
                }
            });
        });
        elemene_btn_qty_minus.on('click', function() {
            --person_number;
            element_radio_li.each(function( index ) {
                var _this_el = jQuery(this);
                if( index  <=  person_number){
                    _this_el.show();
                }else{
                    _this_el.hide();
                }
            });
        });
    }

    jQuery('.mm_filter_product_element').on('click', '.mm-filter-show-more', function () {
        jQuery(this).closest('.shop-filter-product').find('li.product').css('display','');
        jQuery(this).remove();

        return false;
    });
});

// check scroll
window.addEventListener('load', function () {
    const scrollCurrent = window.pageYOffset || document.documentElement.scrollCurrent;
    const body = document.querySelector('body.logged-in');
    if (scrollCurrent > 45 && body) {
        body.classList.add('mm-on-scroll');
    }
    const handleScroll = function handleScroll() {
        if (body) {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop == 0) {
                body.classList.remove('mm-on-scroll');
            } else {
                body.classList.add('mm-on-scroll');
            }
        }
    }
    window.addEventListener("scroll", handleScroll);
});



// add collapsible tabs on homepage
window.addEventListener('load', function () {
    const tabs = document.querySelectorAll('#top.home .tab_homespace .av_tab_section .tab');
    if (tabs.length > 0) {  
        // let tabActive = tabs.length - 1;
        let tabActive = 0;
        tabs.forEach((e, i) => {
            e.addEventListener('click', function () {
                if (isMobileDevice()) {
                    if (tabActive == i && tabActive != 'closeall') {
                        e.classList.remove('active_tab');
                        const siblings = e.parentNode.querySelector(':scope > .tab_content.active_tab_content');
                        siblings.classList.remove('active_tab_content');
                        tabActive = 'closeall';
                        return;
                    }
                    tabActive = i;
                }
            });
        });
    }

    const tabsVP = document.querySelectorAll('#top.mm_vp_tour #itinerary-highlights.tab-product .av-tab-section-inner-container .av-section-tab-title');
    if (tabsVP.length > 0) {  
        // let tabVPActive = tabsVP.length - 1;
        let tabVPActive = 0;
        tabsVP.forEach((e, i) => {
            e.addEventListener('click', function () {
                if (isMobileDevice()) {
                    const siblings = e.parentNode.parentNode.parentNode.querySelectorAll('.av-layout-tab.active-ss-tab');
                    if (siblings.length > 0) {
                        siblings.forEach(e => e.classList.remove('active-ss-tab'));
                    }
                    
                    if (tabVPActive == i && tabVPActive != 'closeall') {
                        tabVPActive = 'closeall';
                        return;
                    } 
                    
                    e.parentNode.parentNode.classList.add('active-ss-tab');
                    tabVPActive = i;
                }
            });
        });
    }

    // add collapsible for faq section
    const faqs = document.querySelectorAll('#top:not(.all-inclusive-vp-page, .cruise-ship-page) #faq ul.togglecontainer .mmfaq');
    if (faqs.length > 0) {
        faqs.forEach(e => {
            e.addEventListener('click', () => {
                if (isMobileDevice()) {
                    e.classList.toggle('on-select');
                }
            });
        });
    }

    // slider galery
    const sliders = document.querySelectorAll('#top .av-horizontal-gallery');
    if (sliders.length > 0) {
        sliders.forEach(slider => {
            const btnNext = slider.querySelector('.next-slide.av-horizontal-gallery-next');
            const btnPrev = slider.querySelector('.prev-slide.av-horizontal-gallery-prev');
            if (btnNext && btnPrev) {
                btnNext.addEventListener('click', function () {
                    if (isMobileDevice()) {
                        const slideFirst = slider.querySelector('.av-horizontal-gallery-slider .av-horizontal-gallery-wrap:first-child');
                        const siderWrap = slider.querySelector('.av-horizontal-gallery-slider');
                        siderWrap.appendChild(slideFirst);
                    }
                });
                btnPrev.addEventListener('click', function () {
                    if (isMobileDevice()) {
                        const siderWrap = slider.querySelector('.av-horizontal-gallery-slider');
                        siderWrap.insertBefore(
                            slider.querySelector('.av-horizontal-gallery-slider .av-horizontal-gallery-wrap:last-child'),
                            slider.querySelector('.av-horizontal-gallery-slider .av-horizontal-gallery-wrap:first-child')
                        );
                    }
                });
            }
        });
    }

    // open search
    const searchIcon = document.querySelector('#header .main_menu .mm-search-header');
    if (searchIcon) {
        searchIcon.addEventListener('click', function (e) {
            if (e.target.classList.contains('mm-search-header') && window.innerWidth < 1740 && window.innerWidth > 990) {
                searchIcon.classList.toggle('mm-open-search');
            }
        });
    }

    // Focus on the first field when you have selected the date and time in the booking box
    if (typeof MutationObserver !== "undefined") {
        const productOption = document.getElementById('tm-extra-product-options');
        if (productOption) {
            const observer = new MutationObserver(function(mutationsList, observer) {
                if (mutationsList.length > 0) {
                    mutationsList.forEach(function (mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                            const computedStyle = window.getComputedStyle(productOption);
                            if (computedStyle.display === 'block') {
                                const cusInfoField = document.querySelectorAll('.customer-info-field input[type="text"]');
                                if (cusInfoField.length > 0) {
                                    const cusInfoFieldArray = Array.from(cusInfoField);
                                    const visibleCusInfoField = cusInfoFieldArray.filter(element => {
                                        return element.offsetParent !== null;
                                    });
                                    if (visibleCusInfoField.length > 0) {
                                        if(visibleCusInfoField[0].value == ''){
                                            visibleCusInfoField[0].focus();
                                        }
                                    }
                                } else {
                                    const field = document.querySelectorAll('#tm-extra-product-options input[type="text"].tmcp-field.tm-epo-field.tmcp-textfield.tcenabled');
                                    if (field.length > 0) {
                                        const fieldArray = Array.from(field);
                                        const visibleField = fieldArray.filter(element => {
                                            return element.offsetParent !== null;
                                        });
                                        if (visibleField.length > 0) {
                                            if(visibleField[0].value == ''){
                                                visibleField[0].focus();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
            if (observer) {
                observer.observe(productOption, { attributes: true });
            }
        }
    }

    // Form vacation packages
    const formVP = document.getElementById('nf-form-12-cont');
    if (formVP) {
        formVP.addEventListener('click', function (event) {
            if (event.target.classList.contains('nf-breadcrumb') || event.target.classList.contains('nf-previous') || event.target.classList.contains('nf-next')) {
                if (document.getElementById('nf-field-178')) {
                    formVP.classList.add('mm-step-last');
                } else {
                    formVP.classList.remove('mm-step-last');
                }
            }
        });
    }

    // Form group tours
    const formGT = document.getElementById('nf-form-2-cont');
    if (formGT) {
        formGT.addEventListener('click', function (event) {
            if (event.target.classList.contains('nf-breadcrumb') || event.target.classList.contains('nf-previous') || event.target.classList.contains('nf-next')) {
                if (document.getElementById('nf-field-8')) {
                    formGT.classList.add('mm-step-last');
                } else {
                    formGT.classList.remove('mm-step-last');
                }
            }
        });
    }

    // Non-emergency Transportation Form
    const formNTF = document.getElementById('nf-form-39-cont');
    if (formNTF) {
        formNTF.addEventListener('click', function (event) {
            if (event.target.classList.contains('nf-breadcrumb') || event.target.classList.contains('nf-previous') || event.target.classList.contains('nf-next')) {
                if (document.getElementById('nf-field-858')) {
                    formNTF.classList.add('mm-step-last');
                } else {
                    formNTF.classList.remove('mm-step-last');
                }
            }
        });
    }

    // Community Transportation Form
    const formCT = document.getElementById('nf-form-40-cont');
    if (formCT) {
        formCT.addEventListener('click', function (event) {
            if (event.target.classList.contains('nf-breadcrumb') || event.target.classList.contains('nf-previous') || event.target.classList.contains('nf-next')) {
                if (document.getElementById('nf-field-867')) {
                    formCT.classList.add('mm-step-last');
                } else {
                    formCT.classList.remove('mm-step-last');
                }
            }
        });
    }

    // Form Job Application
    const formJA = document.getElementById('nf-form-37-cont');
    if (formJA) {
        formJA.addEventListener('click', function (event) {
            if (event.target.classList.contains('nf-breadcrumb') || event.target.classList.contains('nf-previous') || event.target.classList.contains('nf-next')) {
                if (document.getElementById('nf-field-839')) {
                    formJA.classList.add('mm-step-last');
                } else {
                    formJA.classList.remove('mm-step-last');
                }
            }
        });
    }

    // Do not collapse when viewing tooltips on mobile
    const tooltips = document.querySelectorAll('#wc-bookings-booking-form .tm-tooltip');
    if (tooltips.length > 0) {
        tooltips.forEach(e => {
            e.addEventListener('click', function(event) {
                const toolTipBox = document.getElementById('tm-tooltip');
                if (toolTipBox) {
                    if (toolTipBox.classList.contains('on-show')) {
                        toolTipBox.style.display = 'none';
                        toolTipBox.classList.remove('on-show');
                    } else {
                        toolTipBox.style.display = '';
                        toolTipBox.classList.add('on-show');
                    }
                }
                event.stopPropagation();
            });
        });
    }

    // Center image galery slider
    const mmCenterImageGallerySlider = () => {
        const galerySlidersInner = document.querySelectorAll('.av-horizontal-gallery-inner');
        if (galerySlidersInner.length > 0) {
            galerySlidersInner.forEach(e => {
                const galerySliders = e.querySelectorAll('.av-horizontal-gallery-slider');
                const slidersInnerWidth = e.offsetWidth;
                if (galerySliders.length > 0) {
                    galerySliders.forEach(i => {
                        const galeryActive = i.querySelector('.av-active-gal-item');
                        if (galeryActive) {
                            const galeryOriginWidth = +galeryActive.offsetWidth;
                            const galeryActiveWidth = +galeryActive.offsetWidth * 1.2;
                            const widthDifference = galeryActiveWidth - galeryOriginWidth;
                            let left = galeryActive.offsetLeft - (widthDifference / 2);
                            left = left - ((+slidersInnerWidth - galeryActiveWidth) / 2);
                            i.style.left = `-${left}px`;
                        }
                    });
                }
            });
        }
    }
    mmCenterImageGallerySlider();
    window.addEventListener('resize', () => {
        setTimeout(() => {
            mmCenterImageGallerySlider();
        }, 200);
    });
});
jQuery(document).ready(function ($) {
    function checkDate(stringDate) {
        var specifiedDate = new Date(stringDate);

        var currentTime = new Date();

// Adjust for UTC -8 (Pacific Standard Time)
        var utcMinus8 = currentTime.getTime() + (currentTime.getTimezoneOffset() * 60000) - (8 * 60 * 60 * 1000);
        currentTime = new Date(utcMinus8);

        var timeDifference = specifiedDate - currentTime;

// Convert milliseconds to hours
        var hoursDifference = Math.abs(timeDifference / 36e5); // 1 hour = 36e5 milliseconds

        if (hoursDifference <= 72) {
            return 0;
        } else {
            return 1;
        }
    }

    $('table.woocommerce-checkout-review-order-table tbody .cart_item').each(function () {
        let date = $('.product-name .variation-BookingDate p', this).text();
        let n = checkDate(date);
        if(n == 0) {
            $('.mm-notice-checkout-section').addClass('show-notice');
            return true;
        }
    });

    $('.booking_date_day').on('change', function () {
        let day = $('.booking_date_day').val();
        let month = $('.booking_date_month').val();
        let year = $('.booking_date_year').val();
        let date = year+'/'+month+'/'+day;
        let n = checkDate(date);
        if(n == 0) {
            $('.mm-notice-booking-box').addClass('show-notice-booking');
        }else {
            $('.mm-notice-booking-box').removeClass('show-notice-booking');
        }
    });



    const checkIsDayFlashSale = (d, m, y) => {
        const dataDateFlashSale = $('#mm-data-date-flash-sale');
        if (dataDateFlashSale.length > 0) {
            let flashSaleDay = dataDateFlashSale.attr('day-flash-sale');
            let flashSaleMonth = dataDateFlashSale.attr('month-flash-sale');
            let flashSaleYear = dataDateFlashSale.attr('year-flash-sale');
            if (flashSaleDay && flashSaleMonth && flashSaleYear) {
                flashSaleDay = flashSaleDay.split(',');
                flashSaleMonth = flashSaleMonth.split(',');
                flashSaleYear = flashSaleYear.split(',');

                flashSaleDay = flashSaleDay.map(e => +e);
                flashSaleMonth = flashSaleMonth.map(e => +e);
                flashSaleYear = flashSaleYear.map(e => +e);

                if (flashSaleDay.includes(+d) && flashSaleMonth.includes(+m) && flashSaleYear.includes(+y)) {
                    return true;
                }
            }
        }
        return false;
    }

    let bookingCost = $("#top.single-product .mm-flashsale .wc-bookings-booking-cost")[0];
    if (bookingCost) {
        let observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                let day = $('.booking_date_day').val();
                let month = $('.booking_date_month').val();
                let year = $('.booking_date_year').val();
                let isFlashDay = checkIsDayFlashSale(day, month, year);
                $("#top.single-product .mm-flashsale .wc-bookings-booking-cost .mm-price-origin").css('display', 'none');
                $("#top.single-product .mm-flashsale .wc-bookings-booking-cost .mm-price-origin").text('');
                $("#top.single-product .mm-flashsale .wc-bookings-booking-cost").removeClass('mm-price-flash-sale');
                if(isFlashDay) {
                    const price = parseFloat($('#top.single-product .mm-flashsale .wc-bookings-booking-cost .custom-prc').text().split('.')[0].replace(/,/g, ''));
                    let priceOrigin = `$${Math.ceil(price / 0.95).toLocaleString()} USD`;
                    if($("#top.single-product .cpf-product-price").length){
                        let pricebase = parseFloat($("#top.single-product .cpf-product-price").val().split('.')[0].replace(/,/g, ''));
                        let mm_pricebase = parseFloat($("#top.single-product .mm-cpf-product-price").val().split('.')[0].replace(/,/g, ''));
                        if(mm_pricebase!=0){
                            pricebase = mm_pricebase;
                        }
                        if(pricebase!=0 && pricebase != ''){
                            const addons_price = price - pricebase;
                            if(addons_price > 0){
                                let priceOrigin_extra = (parseFloat(pricebase)/ 0.95) + parseFloat(addons_price);
                                priceOrigin = `$`+priceOrigin_extra.toFixed(0)+` USD`;
                            }
                        }
                    }
                    if (priceOrigin) {
                        $("#top.single-product .mm-flashsale .wc-bookings-booking-cost .mm-price-origin").text(priceOrigin);
                        $("#top.single-product .mm-flashsale .wc-bookings-booking-cost .mm-price-origin").css('display', 'inline-block');
                        $("#top.single-product .mm-flashsale .wc-bookings-booking-cost").addClass('mm-price-flash-sale');
                    }
                }
            });
        });

        let config = { childList: true };
        observer.observe(bookingCost, config);
    }
    let bookingCostvp = $("#top.single-product.postid-577863 .wc-bookings-booking-cost")[0];
    if (bookingCostvp) {
        let observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                let day = $('.booking_date_day').val();
                let month = $('.booking_date_month').val();
                let year = $('.booking_date_year').val();
                let payment_type = $('input[name="_sumo_pp_payment_type"]:checked').val();
                $("#top.single-product .wc-bookings-booking-cost .mm-price-origin").css('display', 'none');
                $("#top.single-product .wc-bookings-booking-cost .mm-price-origin").text('');
                $("#top.single-product .wc-bookings-booking-cost").removeClass('mm-price-flash-sale');
                if(day != '' && month != '' && year != '' && payment_type == 'pay_in_full') {
                    let price = parseFloat($('#top.single-product .wc-bookings-booking-cost .custom-prc').text().split('.')[0].replace(/,/g, ''));
                    let priceOrigin = price + 100;
                    priceOrigin = `$`+priceOrigin.toFixed(0)+` USD`;
                    
                    if (priceOrigin) {
                        $("#top.single-product .wc-bookings-booking-cost .mm-price-origin").text(priceOrigin);
                        $("#top.single-product .wc-bookings-booking-cost .mm-price-origin").css('display', 'inline-block');
                        $("#top.single-product .wc-bookings-booking-cost").addClass('mm-price-flash-sale');
                    }
                }
            });
        });

        let config = { childList: true };
        observer.observe(bookingCostvp, config);
    }
});

jQuery(document).ready(function($) {
    if(isMobileDevice()) {
        $('.person-description-tooltip').on('click', function(e){
            e.preventDefault();
            $('.style-for-tooltip').remove();
            let x = $(this).offset().left;
            if(x > 150) {
                let l = x - 150;
                let z = x - 143;
                $('.person-description', this).css('left', -l+'px');
                $('.person-description', this).append("<span class='style-for-tooltip'><style>.person-description-tooltip .person-description::before{left:"+z+"px !important;}</style></span>");
            }

        });
    }

    if ($(window).width() <= 768) {
        // Slider product
        if($('#top.single-hotel').length){
            $('#top.single-hotel #tours .products.mm-filter-product').slick();
            $('#top.single-hotel #interisland .products.mm-filter-product').slick();
        }
        if($('#top.page-id-586885').length){
            $('#top.page-id-586885 #maui .products.mm-filter-product').slick();
            $('#top.page-id-586885 #hilo .products.mm-filter-product').slick();
            $('#top.page-id-586885 #kona .products.mm-filter-product').slick();
            $('#top.page-id-586885 #kauai .products.mm-filter-product').slick();
        }
        // move element share social
        $('#top.single-hotel #contact .av-social-sharing-box').insertAfter('#top.single-hotel #contact #nf-form-12-cont');
        $('#top.single-cruise #contact .av-social-sharing-box').insertAfter('#top.single-cruise #contact #nf-form-12-cont');
    }

    // slider tab section shortcode
    if ($('.av-tab-section-outer-container.tab-ss-show-arrow-slider .av-tab-section-tab-title-container').length > 0) {
        let totalWidth = 0;
        $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .av-tab-section-tab-title-container').children().each(function() {
            totalWidth += $(this).outerWidth();
        });
        if (totalWidth > $(window).outerWidth()) {
            $('.av-tab-section-outer-container.tab-ss-show-arrow-slider').append(`<div class="mm-tab-title-scroll-left"></div><div class="mm-tab-title-scroll-right"></div>`);

            $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .av-tab-section-tab-title-container').children().each(function() {
                $(this).click(function () {
                    $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .mm-tab-title-scroll-left').css('opacity', '1');
                    $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .mm-tab-title-scroll-right').css('opacity', '1');
                });
            });

            $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .mm-tab-title-scroll-left').click(function() {
                let currentPosition = parseInt($('.av-tab-section-outer-container.tab-ss-show-arrow-slider .av-tab-section-tab-title-container').css('left'), 10);
                if (currentPosition == 0) {
                    $(this).css('opacity', '0.5');
                }
                $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .mm-tab-title-scroll-right').css('opacity', '1');
                if (currentPosition < 0) {
                    let position = (totalWidth / 4) + currentPosition;
                    if (position < 0) {
                        $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .av-tab-section-tab-title-container').animate({ left: position }, 50);
                    } else {
                        $(this).css('opacity', '0.5');
                        $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .av-tab-section-tab-title-container').animate({ left: 0 }, 50);
                    }
                }
            });

            $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .mm-tab-title-scroll-right').click(function() {
                let currentPosition = parseInt($('.av-tab-section-outer-container.tab-ss-show-arrow-slider .av-tab-section-tab-title-container').css('left'), 10);
                let position = (totalWidth / 4) + Math.abs(currentPosition);
                if ((Math.abs(currentPosition) + position) > totalWidth) {
                    $(this).css('opacity', '0.5');
                }
                $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .mm-tab-title-scroll-left').css('opacity', '1');
                let maxPosition = $(window).outerWidth() + Math.abs(currentPosition);

                if (maxPosition < totalWidth) {
                    if ((Math.abs(currentPosition) + position) < totalWidth) {
                        $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .av-tab-section-tab-title-container').animate({ left: -position }, 50);
                    } else {
                        position = (totalWidth - maxPosition) + Math.abs(currentPosition);
                        $(this).css('opacity', '0.5');
                        $('.av-tab-section-outer-container.tab-ss-show-arrow-slider .av-tab-section-tab-title-container').animate({ left: -position }, 50);
                    }
                }
            });
        }
    }
});

jQuery(document).ready(function($){

    const faqsAllInclusive = document.querySelectorAll('#top.all-inclusive-vp-page #faq ul.togglecontainer .mmfaq');
    const faqsCruiseShip = document.querySelectorAll('#top.cruise-ship-page #faq ul.togglecontainer .mmfaq');

    if (faqsAllInclusive.length > 0) {
        faqsAllInclusive.forEach(e => {
            e.addEventListener('click', () => {
                e.classList.toggle('on-select');
            });
        });
    }

    if (faqsCruiseShip.length > 0) {
        faqsCruiseShip.forEach(e => {
            e.addEventListener('click', () => {
                e.classList.toggle('on-select');
            });
        });
    }

    $('#top.all-inclusive-vp-page #faq ul.togglecontainer .mmfaq:eq(0) ').addClass('on-select');
    $('#top.cruise-ship-page #faq ul.togglecontainer .mmfaq:eq(0) ').addClass('on-select');

    // check date format
    $('.nf-form-cont').on('change', '.mm-validate-date .datepicker.flatpickr-input', function() {
        const mmCheckDateFormat = (dateString) => {
            let regex = /^\d{2}\/\d{2}\/\d{4}$/;
            if (!regex.test(dateString)) {
                return "Invalid date, should be MM/DD/YYYY";
            }

            let parts = dateString.split("/");
            let month = parseInt(parts[0], 10);
            let day = parseInt(parts[1], 10);
            let year = parseInt(parts[2], 10);

            if (year < 1000 || year > 3000) {
                return "Invalid year, please select again";
            }

            if (month == 0 || month > 12) {
                return "Invalid month, please select again";
            }

            let monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0)) {
                monthLength[1] = 29;
            }

            if (day <= 0 || day > monthLength[month - 1]) {
                return "Invalid day, please select again";
            }

            return true;
        }

        let value = $(this).val();
        let checkResult = mmCheckDateFormat(value);
        if (checkResult == true) {
            $(this).closest('.pikaday__container').removeAttr('mm-error-format-date');
        } else {
            $(this).val('');
            $(this).closest('.pikaday__container').attr('mm-error-format-date', `${checkResult}`);
        }
    });

    // Paralax on mobile
    if ($(window).width() < 768) {
        if ($('.av-parallax-section.avia-bg-style-parallax').length > 0) {
            $(window).scroll(function() {
                $('.av-parallax-section.avia-bg-style-parallax').each(function () {
                    let eleParallax = $(this).find('.av-parallax.active-parallax');
                    if (eleParallax.length > 0) {
                        let scroll = $(this).offset().top - $(window).scrollTop();
                        if (scroll > 1 && scroll < eleParallax.height()) {
                            eleParallax.css('transform', `translate3d(0, ${scroll / 3}px, 0)`);
                        }
                    }
                });
            });
        }
    }

    // Hide tooltip box when clicked a second time
    if ($(window).width() < 990) {
        const iconTooltip1 = jQuery('.person-description-tooltip');
        if (iconTooltip1.length > 0) {
            iconTooltip1.each(function() {
                $(this).mouseleave(function() {
                    $(this).find('person-description').css('display', '');
                    $(this).removeClass('on-show-desc');
                });
                $(this).click(function (event) {
                    event.stopPropagation();
                    if ($(this).hasClass('on-show-desc')) {
                        $(this).find('.person-description').css('display', 'none');
                        $(this).removeClass('on-show-desc');
                    } else {
                        $(this).find('.person-description').css('display', '');
                        $(this).addClass('on-show-desc');
                    }
                });
            });
        }

        const iconTooltip2 = jQuery('.mm-guestinfo-tooltip');
        if (iconTooltip2.length > 0) {
            iconTooltip2.each(function() {
                $(this).mouseleave(function() {
                    $(this).find('.tooltip-content').css('display', '');
                    $(this).removeClass('on-show-desc');
                });
                $(this).click(function (event) {
                    event.stopPropagation();
                    if ($(this).hasClass('on-show-desc')) {
                        $(this).find('.tooltip-content').css('display', 'none');
                        $(this).removeClass('on-show-desc');
                    } else {
                        $(this).find('.tooltip-content').css('display', '');
                        $(this).addClass('on-show-desc');
                    }
                });
            });
        }
    }

    if ($('.list-restaurant-term .list-restaurant-term-more-btn').length > 0) {
        $('.list-restaurant-term .list-restaurant-term-more-btn').click(function () {
            if ($(this).parent().hasClass('active')) {
                $(this).parent().removeClass('active');
                $(this).text('More');
            } else {
                $(this).parent().addClass('active');
                $(this).text('Less');
            }
        });
    }
    var customer_info = $(".tmcp-field.customer-info");
    if (customer_info[0]) {
        var observer = new MutationObserver(function(mutations) {
          mutations.forEach(function(mutation) {
            var attributeValue = $(mutation.target).prop(mutation.attributeName);
            if(attributeValue.indexOf("tcdisabled")>=0){
                jQuery('.customer-info-field').addClass('mm-hide-field-with-logic');
            }else{
                jQuery('.customer-info-field').removeClass('mm-hide-field-with-logic');
            }
            
          });
        });

        observer.observe(customer_info[0], {
          attributes: true,
          attributeFilter: ['class']
        });
    }
    function handles_button_my_account() {
        var account_button = $(".action_my_account");
        if (account_button.length > 0) {
            account_button.off('click').on('click', function(event) {
                event.preventDefault();
                window.location.href = '/my-account/';
            });
        }
    }

    if (!accountIsMobile()) {
        handles_button_my_account();
    }
    var mobile_menu_button_handle = $(".menu-item-avia-special");
    if (mobile_menu_button_handle.length > 0) {
        mobile_menu_button_handle.click(function() {
            if (accountIsMobile()) {
                handles_button_my_account(); 
            } 
        });
    }
    function accountIsMobile() {
        return window.innerWidth <= 990; 
    }

});

jQuery(window).on('load', function () {
    jQuery('#top.all-inclusive-vp-page .fa-info-circle.nf-help').on('click', function(e){
        e.preventDefault();
    });

    // Add scroll up/down for Reviews section
    jQuery('.single-product .aiosrs-rating-summary-wrap').click(function () {
        let target = jQuery('[data-app="eapps-all-in-one-reviews"]');
        if (target.length == 0) {
            target = jQuery('[data-app="eapps-google-reviews"]');
        }
        if (target) {
            jQuery('html, body').animate({
                scrollTop: target.offset().top - 300
            }, 800);
        }
    });
})