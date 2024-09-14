//This for product id 4999
jQuery(document).ready(function ($) {
    $(document).on('click', '#wc-bookings-booking-form .list-costs-island li', function (e) {
        var data_resource = $(this).data('fields');
        var text_pickup_time = $(this).text();
        if (data_resource == 6686 && $('body').hasClass('postid-5043')) {
            //$('.form-field.form_person_0').css('width', '100%');
            $('.form-field.form_person_1 .content-person input[type="number"]').val(0);
            $('.form-field.form_person_1').css('display', 'none');
        } else {
            //$('.postid-4999 .form-field.form_person_0').css('width', '50%');
            $('.postid-5043 .form-field.form_person_1').css('display', '');
        }
        /*if($('body').hasClass('postid-5815')){
            if (data_resource == 15568){
                $('.form-field.form_person_2 .content-person input[type="number"]').val(0);
                $('.form-field.form_person_2').css('display', 'none');
                $('.form-field.form_person_1').css('display', '');
            }
            if (data_resource == 6938 || data_resource == 6939){
                $('.form-field.form_person_1 .content-person input[type="number"]').val(0);
                $('.form-field.form_person_1').css('display', 'none');
                $('.form-field.form_person_2').css('display', '');
            }
            
        }*/
        /*if (data_resource == 6214 && $('body').hasClass('postid-4999')) {
            //$('.form-field.form_person_0').css('width', '100%');
            $('.form-field.form_person_1 .content-person input[type="number"]').val(0);
            $('.form-field.form_person_1').css('display', 'none');
        } else {
            //$('.postid-4999 .form-field.form_person_0').css('width', '50%');
            $('.postid-4999 .form-field.form_person_1').css('display', 'block');
        }*/
        /*if (data_resource == 3992 && $('body').hasClass('postid-3676')) {
            $('.form-field.form_person_1').css('display', 'none');
            //$('.form-field.form_person_0').css('width', '100%');
            $('.form-field.form_person_1 .content-person input[type="number"]').val(0);
        } else {
            $('.postid-3676 .form-field.form_person_1').css('display', 'block');
            //$('.postid-3676 .form-field.form_person_0').css('width', '50%');
        }*/
        if (data_resource == 6957 && $('body').hasClass('postid-6094')) {
            $('.form-field.form_person_2').css('display', 'none');
            $('.form-field.form_person_2 .content-person input[type="number"]').val(0);
        } else {
            $('.postid-6094 .form-field.form_person_2').css('display', 'block');
        }
        if (data_resource == 6714 && $('body').hasClass('postid-3829')) {
            $('.form-field.form_person_1').css('display', 'none');
            //$('.form-field.form_person_2').css('width', '50%');
            //$('.form-field.form_person_2').css('border-left', '2px solid #F0F0F0');
            $('.form-field.form_person_1 .content-person input[type="number"]').val(0);
        } else {
            $('.postid-3829 .form-field.form_person_1').css('display', 'block');
            //$('.postid-3829 .form-field.form_person_2').css('border-left', 'none');
            //$('.postid-3829 .form-field.form_person_2').css('width', '100%');
        }
        var pickup_time = $(".form_field-time .block-picker").find("li").length;
        if (pickup_time > 1) {
            if (data_resource == 6214 || data_resource == 6215 || data_resource == 6715 || data_resource == 6716) {
                $('#wc-bookings-booking-form .form_field-time i').css('display', 'none');
                $('.form_field-time .block-picker li:first-child a').trigger('click');
                var text_pickup_time = $('.form_field-time .block-picker li:first-child a').text();
                $('.pickup-time').css('display', 'block');
                $('.pickup-time').text(text_pickup_time);
                $('#wc-bookings-booking-form .form_field-time .wc_bookings_field_start_date').css('display', 'none');
                $('#wc-bookings-booking-form .form_field-time .icon-hour').css('display', 'none');
                $('#wc-bookings-booking-form .form_field-time .icon-check').css('display', 'block');
            }
            if (data_resource == 6216 || data_resource == 6218 || data_resource == 6714) {
                $('#wc-bookings-booking-form .form_field-time i').css('display', 'none');
                $('.form_field-time .block-picker li:nth-child(2) a').trigger('click');
                var text_pickup_time = $('.form_field-time .block-picker li:nth-child(2) a').text();
                $('.pickup-time').css('display', 'block');
                $('.pickup-time').text(text_pickup_time);
                $('#wc-bookings-booking-form .form_field-time .wc_bookings_field_start_date').css('display', 'none');
                $('#wc-bookings-booking-form .form_field-time .icon-hour').css('display', 'none');
                $('#wc-bookings-booking-form .form_field-time .icon-check').css('display', 'block');
            }
        }
        
        var bookingsSnippetInformationDefault = $("#top.mm-custom-builder #mm_bookings_snippet_information_default .mm-item-snippet-information");
        if(bookingsSnippetInformationDefault.length){
            bookingsSnippetInformationDefault.each(function () {
                var itemThis = $(this);
                var dataShowValue = itemThis.attr("data-resource");

                if (dataShowValue != data_resource) {
                    itemThis.addClass('mm-disable');
                } else {
                    itemThis.removeClass('mm-disable');
                }
                
            });
        }
        var bookingsSnippetInformation = $("#top.mm-custom-builder #mm_bookings_snippet_information .mm-item-snippet-information");
        if(bookingsSnippetInformation.length){
            bookingsSnippetInformation.each(function () {
                var itemThis = $(this);
                var dataShowValue = itemThis.attr("data-resource");

                if (dataShowValue != data_resource) {
                    itemThis.addClass('mm-disable');
                } else {
                    itemThis.removeClass('mm-disable');
                }
                
            });
        }
    });
    var green_dinner = $('.postid-4999 #wc-bookings-booking-form .list-costs-island li[data-fields="6214"]');
    var res_show_dinner = $('.postid-3829 #wc-bookings-booking-form .list-costs-island li[data-fields="6714"]');
    
    if (green_dinner.hasClass('selected')) {
        //$('.form-field.form_person_0').css('width', '100%');
        $('.form-field.form_person_1').css('display', 'none');
    }
    
    if (res_show_dinner.hasClass('selected')) {
        $('.form-field.form_person_1').css('display', 'none');
        //$('.form-field.form_person_2').css('width', '50%');
        //$('.form-field.form_person_2').css('border-left', '2px solid #F0F0F0');
    }
    //var cost_island = $('#wc-bookings-booking-form .list-costs-island li.selected .woocommerce-Price-amount.amount').html();
    

    if ($('.product-template-default').length) {
    
        // Find the div with the class "#booking-box #after_section_2" and remove it
        $('#booking-box #after_section_2').remove();
     
    }
    // ----------------------------
    if ($('#top.mm-custom-builder .mm-content-booking-description:not(.open) > *:not(:first-child, .mm-more-description)').length > 0) {
        var link_more = $('<a>', {
            href: '#',
            class: 'mm-more-description see-more',
            text: 'see more'
        });
        $('#top.mm-custom-builder .mm-content-booking-description > *:last-child').after(link_more);
        $( "#top.mm-custom-builder .mm-content-booking-description .mm-more-description" ).click(function( event ) {
            event.preventDefault();
            var moreDescription = $(this);
            if(moreDescription.hasClass('see-more')){
                var mm_description = moreDescription.closest('.mm-content-booking-description');
                mm_description.addClass('open');
                moreDescription.removeClass('see-more').addClass('see-less').text('see less');
            }else{
                var mm_description = moreDescription.closest('.mm-content-booking-description');
                mm_description.removeClass('open');
                moreDescription.removeClass('see-less').addClass('see-more').text('see more');   
            }
        });
    }
    if ($('#top.mm-custom-builder #mm_bookings_snippet_information').length > 0) {
        $( "#top.mm-custom-builder #mm_bookings_snippet_information .mm-item-snippet-information" ).click(function( event ) {
            event.preventDefault(); //mm-icon-dropdown // mm-icon-minus
            if($(this).hasClass('mm-icon-dropdown')){
                $(this).removeClass('mm-icon-dropdown').addClass('mm-icon-minus');
            }else if($(this).hasClass('mm-icon-minus')){
                $(this).removeClass('mm-icon-minus').addClass('mm-icon-dropdown');
            }
        });
    }
    if(isMobileDevice()){
        var mmIconDropdown = $('#top.mm-custom-builder #mm_bookings_snippet_information .mm-item-snippet-information.mm-icon-dropdown.mm-icon-minus-mobile');
        if(mmIconDropdown.length){
            mmIconDropdown.removeClass('mm-icon-dropdown').addClass('mm-icon-minus');
        }
        var flexColumnFirst = $('#top #main #booking-box #breadcrumb_product + .template-page >.post-entry> .entry-content-wrapper > .flex_column.first');
        if(flexColumnFirst.length){
            //var flexColumn = $('#top #main #booking-box #breadcrumb_product + .template-page >.post-entry> .entry-content-wrapper > .flex_column:not(.first)');
            var elementMoveDownMobile = flexColumnFirst.find('> .wistia_responsive_padding, > iframe, > .maui-snorkeling, > .element-move-down-mobile');
            elementMoveDownMobile.appendTo(flexColumnFirst);
            //flexColumn.appendTo(flexColumnFirst);
        }
    }
    //mm_slideshowzoom
    if ($('#top .avia-slideshow.mm_slideshowzoom').length > 0) {
        $('body').append(`
            <div class="mm-slideshowzoom">
                <div class="mm-controll-img">
                    <div class="mm-arrow-left"></div>
                    <div class="mm-arrow-right"></div>
                </div>
                <div class="mm-imgzoom">
                    <img src="" alt="MM Slide Show Zoom" class="img-slideshowzoom">
                    <div class="close-btn">
                    </div>
                </div>
                <div class="mm-over"></div>
            </div>
        `);
        
        var imagesSlider  = $('.avia-slideshow.mm_slideshowzoom .avia-slideshow-inner .avia-slideshow-slide .avia-slide-wrap img');
        var listSlideZoom = [];
        var eSlideZoom = 0;
        imagesSlider.each(function(n){
            var eImgSlider = $(this);
            var eZoom = $('<a>', {
                href: '#',
                class: 'mm-zoom-holder ',
                text: '',
                'data-av_icon': "",
                'data-av_iconfont': "entypo-fontello",
                'data-src': n
            });
            eImgSlider.after(eZoom);
            listSlideZoom.push(eImgSlider.attr('src'));
        });
        var imgPopup = $('.mm-slideshowzoom');
        var esZoomHolder  = $('.avia-slideshow.mm_slideshowzoom .avia-slideshow-inner .avia-slideshow-slide .avia-slide-wrap .mm-zoom-holder');
        esZoomHolder.on('click', function(event) {
            event.preventDefault();
            var img_src = $(this).attr('data-src');
            if(img_src){
                var eImgPopup = imgPopup.find('.mm-imgzoom img');
                eSlideZoom = img_src;
                eImgPopup.attr('src', listSlideZoom[eSlideZoom]);
                imgPopup.addClass('opened');
            }
        });
        $('.mm-slideshowzoom .mm-imgzoom .close-btn, .mm-slideshowzoom .mm-over').on('click', function() {
            imgPopup.removeClass('opened');
            imgPopup.find('.mm-imgzoom img').attr('src', '');
        });
        $('.mm-slideshowzoom .mm-controll-img .mm-arrow-right').on('click', function() {
            var eImgPopup = imgPopup.find('.mm-imgzoom img');
            if(eSlideZoom >= (listSlideZoom.length - 1)){
                eSlideZoom = 0;
                eImgPopup.attr('src', listSlideZoom[eSlideZoom]);
            }else{
                eImgPopup.attr('src', listSlideZoom[++eSlideZoom]);
            }
        });
        $('.mm-slideshowzoom .mm-controll-img .mm-arrow-left').on('click', function() {
            var eImgPopup = imgPopup.find('.mm-imgzoom img');
            if(eSlideZoom <= 0){
                eSlideZoom = (listSlideZoom.length - 1);
                eImgPopup.attr('src', listSlideZoom[eSlideZoom]);
            }else{
                eImgPopup.attr('src', listSlideZoom[--eSlideZoom]);
            }
        });
    }
    if ($('#top .tc-extra-product-options select').length > 0) {
        $( "#top .tc-extra-product-options .cpf-type-select" ).each(function() {
            var select_placeholder = '';
            if($(this).find('select').data('placeholder').length){
                select_placeholder = $(this).find('select').data('placeholder');
            }
            if($(this).find('select').find('option').length > 15 || select_placeholder.indexOf("Select Your Hotel")>=0){
                $(this).find('select').select2({
                    dropdownParent: $(this).find('.tm-extra-product-options-select')
                });
            }
        });
        $('.cpf-type-select select').one('select2:open', function(e) {
            $('input.select2-search__field').prop('placeholder', 'Search');
        });
    }

    // Hide rs field when opening hotel field
    jQuery('#wc-bookings-booking-form .select2.select2-container').click(function () {
        if (jQuery(this).hasClass('select2-container--open')) {
            jQuery('#wc-bookings-booking-form .field_resource.wc_bookings_field_resource.active').removeClass('active');
            jQuery('#wc-bookings-booking-form .list-costs-island').css('display', 'none');
        }
    });

    // Validate weight customer info
    if ($('#wc-bookings-booking-form input.mm-vailidate-weight-customer-info[type="number"]').length > 0) {
        $('#wc-bookings-booking-form input.mm-vailidate-weight-customer-info[type="number"]').on('input', function() {
            if ($(this).is('[max]')) {
                let inputValue = $(this).val();
                let max = parseInt($(this).attr('max'));

                if (inputValue > max) {
                    $(this).addClass('mm-has-error-weight-limit');
                    $(this).val('');
                } else {
                    $(this).removeClass('mm-has-error-weight-limit');
                }
            }
        });
    }

    // Add attr blank for link on product detail
    $('#top.single-product a.button-upsell').attr('target', '_blank');
    $('#top.single-product #row-button a').attr('target', '_blank');

    // Add attr for link tag in bottom section on pages
    $('#top #custom_html-2 a').attr('target', '_blank');

    $('#booking-box .booking_box_fareharbox .resource-item').each(function (){
        if ($(this).find('.tour-price li').length < 1) {
            $(this).addClass('mm-fhdn-remove-arrow');
            $(this).find('.tour-price').remove();
        }
    });

    if ($('[mm-anchor-scroll-tab-to]').length > 0) {
        $('[mm-anchor-scroll-tab-to]').click(function () {
            const screenWidth = $(window).width();
            const target = $(this).attr('mm-anchor-scroll-tab-to');
            let eleTarget;
            let handleClick;
            let isOpen = false;
            if (screenWidth > 990) {
                eleTarget = $(`[mm-anchor-scroll-tab-target='${target}']`);
                handleClick = eleTarget.find('a')
            } else {
                eleTarget = $(`[mm-anchor-scroll-tab-target-mobile='${target}']`);
                handleClick = eleTarget.find('h5.yikes-custom-woo-tab-title')
                if (eleTarget.hasClass('active')) {
                    isOpen = true;
                }
            }

            if (eleTarget.length > 0) {
                if (isOpen == false) {
                    handleClick.click(); 
                }
                $('html, body').animate({
                    scrollTop: eleTarget.offset().top - 140
                }, 1000);
            }
        });
    }
});






