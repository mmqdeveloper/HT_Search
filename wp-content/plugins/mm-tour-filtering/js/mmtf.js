
// mmtf_range_datepicker.el = {
//     date_start : "#mm_quick_search_date_start",
//     date_end   : "#mm_quick_search_date_end",
//     wrapper    : "#mm_quick_search_datepicker_wrapper",
//     result     : "#mm_quick_search_datepicker_result",
//     widget     : "#mmtf_datepicker_widget",
//     controls   : "#mm_quick_search_datepicker_controls",
//     reset      : "#mm_quick_search_datepicker_reset",
//     apply      : "#mm_quick_search_datepicker_apply",
// };

jQuery( document ).ready( function($){
    'use strict';
	console.log( "Ready: jQuery " + $.fn.jquery );
    
    // slider
    function mmtfLoadFilterSlider () {
        // Price
        $('#mmtf_price_range').slider({
            range   : true,
            min     : 0,
            max     : mm_price_range.max,
            values  : [ 
                $('#mmtf_price_range').attr('data-min') ? +$('#mmtf_price_range').attr('data-min') : mm_price_range.low,
                $('#mmtf_price_range').attr('data-max') ? +$('#mmtf_price_range').attr('data-max') : mm_price_range.high
            ],
            slide   : function( event, ui ){
                
                $('#mmtf_price_label_low  .selected_amount').html( ui.values[0] );
                $('#mmtf_price_label_high .selected_amount').html( ui.values[1] );
                
                $('#mmtf_price_range').attr('data-min', ui.values[0]);
                $('#mmtf_price_range').attr('data-max', ui.values[1]);
                
                $('#mmtf_price_label_high .or_more').toggle( ui.values[1] >= mm_price_range.max );
                
            },
            change  : function( event, ui ){

                $('#mmtf_price_label_low  .selected_amount').html( ui.values[0] );
                $('#mmtf_price_label_high .selected_amount').html( ui.values[1] );

                if (ui.values[0] != '0' && ui.values[1] != '6000') {
                    $('#mmtf_price_range').attr('data-min', ui.values[0]);
                    $('#mmtf_price_range').attr('data-max', ui.values[1]);
                }

            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        const minValue = urlParams.get('dur_min') || 1;
        const maxValue = urlParams.get('dur_max') || 24;

        $('#mmtf_duration').slider({
            range   : true,
            min     : 1,
            max     : 24,
            values  : [ 
                $('#mmtf_duration_min').val() ? $('#mmtf_duration_min').val() : minValue, 
                $('#mmtf_duration_max').val() ? $('#mmtf_duration_max').val() : maxValue 
            ],
            slide   : function( event, ui ){

                $('#mmtf_duration_label_low  .selected_amount').html( `${ui.values[0]}h` );
                $('#mmtf_duration_label_high .selected_amount').html( `${ui.values[1]}h` );
                
            },
            change  : function( event, ui ){

                $('#mmtf_duration_label_low  .selected_amount').html( `${ui.values[0]}h` );
                $('#mmtf_duration_label_high .selected_amount').html( `${ui.values[1]}h` );
                
                if (ui.values[0] != '1' && ui.values[1] != '24') {
                    $('#mmtf_duration_min').val(ui.values[0]);
                    $('#mmtf_duration_max').val(ui.values[1]);
                }
                
            }
        });
    }
    mmtfLoadFilterSlider();

    // reset filters
    $('#mmtf_results_fiters_state').on('click', function(){
        
        let vars = [
            'sr',
            'group',
            'min',
            'max',
            'date_start',
            'date_end',
            'cat',
            'cert',
            'tag',
        ];
        
        
        let goto_url = mm_object.del_url_var( 'pp' );
        
        $.each( vars, function( index, var_name ){
            
            goto_url = mm_object.del_url_var( var_name, goto_url );
        });
        
        window.location.href = goto_url;
        
    });
    
    
    // load more results
    
    $('#mmtf_load_more').on('click', function(){
        
        // return;
        $('#mmtf_products_results').append($('#mmtf_filter_loading_list').html());

        $('#mmtf_load_more').addClass('loading');
        $('#mmtf_load_more').html(`<div class="waveform">
                <div class="waveform__bar"></div>
                <div class="waveform__bar"></div>
                <div class="waveform__bar"></div>
                <div class="waveform__bar"></div>
            </div>`);
        
        let curr_page = $('#mmtf_load_more').data("current_page");
        let next_page = +curr_page + 1;
        
        let urlParams = new URLSearchParams(window.location.search);

        let data = {};

        urlParams.forEach(function(value, key) {
            data[key] = value;
        });

        if ($.isEmptyObject(data)) {
            data = {
                'action': 'mmtf_search_ajax',
                'mmtf_query_by': 'ajax',
            };
        }

        data = {
            ...data, 
            'paged': next_page
        }

        $.post( mm_object.ajax_url, data, function( response ){
        
            if( response.success === true ){
                
                $('#mmtf_load_more').removeClass('loading');
                $('#mmtf_load_more').html('Show more');
                $('#mmtf_products_results .loading-container').remove();
                
                $('#mmtf_products_results').append( response.data.html );
                $('#mmtf_load_more').data("current_page", next_page );

                if (!response.data.show_readmore) {
                    $('#mmtf_load_more').hide();
                }

                productBoxSlider();

                let seenIds = {};
                $('#mmtf_products_results .product_result').each(function() {
                    let productId = $(this).data('product_id');
                    if (seenIds[productId]) {
                        $(this).remove();
                    } else {
                        seenIds[productId] = true;
                    }
                });
            } else {
                
                console.log( "Failure:", response.data );
            }
            
            
        }, "json");
        
    });
    
    $(window).on('popstate', function(ev){
        
        if( ev.originalEvent.state && ev.originalEvent.state.pp ){
            
            // console.log("pp: ", ev.originalEvent.state.pp );
        }
        // console.log("ev: ", ev );
        
    });
    
    
    // show all categories
    $('body').on('click', '.mmtf_widget_title.all_taxonomies_title', function(){
        
        let url_var = 'cat';
        
        if( $(this).attr('id') == 'mmtf_all_certificates' ){
            url_var = 'cert';
        }
        if( $(this).attr('id') == 'mmtf_all_tags' ){
            url_var = 'tag';
        }
        
        window.location.href = mm_object.del_url_var( url_var );
    });
    
    
    // Toggle class children categories
    $('body').on('click', 'ul#mmtf_categories li .tax_toggler', function(){
        
        $(this).toggleClass('toggled');
        $(this).parent().children('ul.children').toggle();
        
        
    });
    
    
    // replace all categories urls and see who has child categories
    $('.taxonomy_list li').each( function( index, $el ){
        
        let url_var = 'cat';
        
        if( $(this).parents('.taxonomy_list').attr('id') == 'mmtf_certificates' ){
            url_var = 'cert';
        }
        if( $(this).parents('.taxonomy_list').attr('id') == 'mmtf_tags' ){
            url_var = 'tag';
        }
        
        if( $(this).children('ul.children').length > 0 ){
            $(this).addClass('has_children').append('<div class="tax_toggler"></div>');
        }
        
        
        let tax_id = false;
        
        if( url_var != 'cat' ){
            
            let tax_class = $(this).attr('class');
            
            // console.log( 'tax_class: ', tax_class );
            
            let match = tax_class.match(/cat\-item\-([0-9]+)/);
            
            if( match ){
                
                tax_id = +match[1];
                
                // console.log( 'tax_id: ', tax_id );
            }
            
        } else {
            
            let cat_url = $(this).children('a').attr('href');
            
            if( cat_url.substr( -1 ) === '/' ){
                
                cat_url = cat_url.slice( 0, -1 );
            }
            
            let last_slash = cat_url.lastIndexOf('/');
            
            tax_id = cat_url.slice( last_slash + 1 )
            
            // console.log( 'cat_url: ', cat_url );
            
            
        }
        
        if( ! tax_id ){
            return;
        }
        
        
        let goto_url = mm_object.del_url_var('pp');
        
        let used_cat_ids = mm_object.get_url_var( url_var );
        
        if( ! used_cat_ids ){
            
            used_cat_ids = [];
            
        } else {
            
            used_cat_ids = used_cat_ids.split(",");
        }
        
        
        if( $(this).hasClass('current-cat') ){
            
            $(this).children('a').append('<div class="tax_reset"></div>');
            
            used_cat_ids = used_cat_ids.filter( x => x != tax_id );
            
        } else {
            
            used_cat_ids.push( tax_id );
            
        }
        
        if(used_cat_ids.length > 1){
            var tmp_used_cat_ids = used_cat_ids;
            var remove_Item = '';
            if($.inArray('big-island', used_cat_ids) !== -1){
                remove_Item = 'big-island';
                tmp_used_cat_ids = $.grep(tmp_used_cat_ids, function(value) {
                    return value != remove_Item;
                });
            }
            if($.inArray('kauai', used_cat_ids) !== -1){
                remove_Item = 'kauai';
                tmp_used_cat_ids = $.grep(tmp_used_cat_ids, function(value) {
                    return value != remove_Item;
                });
            }
            if($.inArray('maui', used_cat_ids) !== -1){
                remove_Item = 'maui';
                tmp_used_cat_ids = $.grep(tmp_used_cat_ids, function(value) {
                    return value != remove_Item;
                });
            }
            if($.inArray('oahu', used_cat_ids) !== -1){
                remove_Item = 'oahu';
                tmp_used_cat_ids = $.grep(tmp_used_cat_ids, function(value) {
                    return value != remove_Item;
                });
            }
            if(tmp_used_cat_ids.length >= 1){
                used_cat_ids = tmp_used_cat_ids;
            }
            
        }
        
        
        goto_url = used_cat_ids.length >= 1 ? mm_object.set_url_var( url_var, used_cat_ids.join(","), goto_url ) : mm_object.del_url_var( url_var, goto_url );
        
        
        $(this).children('a').attr('href', goto_url );
        
    });
    
    
    // replace all title attributes
    $('.taxonomy_list li a').each( function( index, $el ){
        
        let title = $(this).attr('title');
        
        if( ! title ){
            return;
        }
        
        let lines = title.split(/\r?\n|\r/);
        
        title = lines[0];
        title = "";
        
        $(this).attr('title', title );
        
    });
    
    // extra taxonomies
    
    $('#mmtf_certificates > li').each( function( index, $el ){
        
        if( index < 5 || $(this).hasClass('current-cat') ){
            return;
        }
        
        $(this).addClass('extra_taxonomies');
        
    });
    $('#mmtf_tags > li').each( function( index, $el ){
        
        if( index < 5 || $(this).hasClass('current-cat') ){
            return;
        }
        
        $(this).addClass('extra_taxonomies');
        
    });
    $('#mmtf_tags, #mmtf_certificates').append('<li class="tax_more_toggler" data-alter="Less...">More...</li>');
    $('body').on('click', '.tax_more_toggler', function(){
        
        let old_label = $(this).html();
        $(this).html( $(this).data('alter') );
        $(this).data('alter', old_label );
        
        $(this).parent().children('.extra_taxonomies').slideToggle();
        
    });
    
    // toggle filters (mobile mode)
    $('body').on('click', '#mmtf_sidebar_toggler', function(){
        
        let old_label = $(this).html();
        $(this).html( $(this).data('alter') );
        $(this).data('alter', old_label );
        
        $('#mmtf_sidebar').slideToggle();
        
    });
    
    
    // apply selected dates
    $('body').on('click', '#mmtf_datepicker_apply', function(){
        
		var date_start = $( mmtf_range_datepicker.el.date_start ).val();
		var date_end   = $( mmtf_range_datepicker.el.date_end   ).val();
        
        let goto_url = mm_object.del_url_var('pp');
        
            goto_url = mm_object.set_url_var( 'date_start', date_start, goto_url );
            goto_url = mm_object.set_url_var( 'date_end', date_end, goto_url );
        
        if( ! date_start ){
            
            goto_url = mm_object.del_url_var( 'date_start', goto_url );
            goto_url = mm_object.del_url_var( 'date_end', goto_url   );
            
        }
        
        
        window.location.href = goto_url;
    });
    
    // reset selected dates
    $('body').on('click', '#mmtf_datepicker_result .the_x', function(){
        
        let goto_url = mm_object.del_url_var('pp');
        
            goto_url = mm_object.del_url_var( 'date_start', goto_url );
            goto_url = mm_object.del_url_var( 'date_end', goto_url );
        
        
        window.location.href = goto_url;
    });
    
    
    
    // validate group size
    $('body').on('change keyup paste', '#mmtf_group_size', function(ev){
        
        if( ev.which == 13 ){
            
            $('#mmtf_group_size_wrapper .the_apply').click();
            return;
        }
        
        var pattern = /\d+/g;
        
        let group_size = $(this).val().match( pattern );
            group_size = group_size ? parseInt( group_size.join('') ) : '';
            group_size = ( "" + group_size ).substring( 0, 4 );
        
        $(this).val( group_size );
        
        let applied_size = $(this).data('submitted');
        
        $('#mmtf_group_size_wrapper').toggleClass( 'value_changed', ( applied_size != group_size ) );
        
    });
    
    // apply group size
    $('body').on('click', '#mmtf_group_size_wrapper .the_apply', function(){
        
		var group = $('#mmtf_group_size').val();
        
        let goto_url = mm_object.del_url_var('pp');
        
        if( group ){
            goto_url = mm_object.set_url_var( 'group', group, goto_url );
        } else {
            goto_url = mm_object.del_url_var( 'group', goto_url );
        }
        
        
        window.location.href = goto_url;
    });
    
    // reset group size
    $('body').on('click', '#mmtf_group_size_wrapper .the_x', function(){
        
        $('#mmtf_group_size').val('');
        
        let goto_url = mm_object.del_url_var('pp');
            
            goto_url = mm_object.del_url_var( 'group', goto_url );
        
        
        window.location.href = goto_url;
    });
    
    
    
    // validate search field
    $('body').on('change keyup paste', '#mmtf_search', function(ev){
        
        if( ev.which == 13 ){
            
            $('#mmtf_search_wrapper .the_apply').click();
            return;
        }
        
        var pattern = /\d+/g;
        
        let search = $(this).val();
        
        let applied_search = $(this).data('submitted');
        
        $('#mmtf_search_wrapper').toggleClass( 'value_changed', ( applied_search != search ) );
        
    });
    
    // apply search field
    $('body').on('click', '#mmtf_search_wrapper .the_apply', function(){
        
		var search = $('#mmtf_search').val();
        
        let goto_url = mm_object.del_url_var('pp');
        
        if( search ){
            goto_url = mm_object.set_url_var( 'sr', search, goto_url );
        } else {
            goto_url = mm_object.del_url_var( 'sr', goto_url );
        }
        
        
        window.location.href = goto_url;
    });
    
    // reset search field
    $('body').on('click', '#mmtf_search_wrapper .the_x', function(){
        
        $('#mmtf_search').val('');
        
        let goto_url = mm_object.del_url_var('pp');
            
            goto_url = mm_object.del_url_var( 'sr', goto_url );
        
        
        window.location.href = goto_url;
    });
    

    function updateOrAddParamsToURL(url, params) {
        let newURL = url;
        
        for (let key in params) {
            if (params.hasOwnProperty(key)) {
                if (params[key]) {
                    let paramKey = key + '=';
                    let startIndex = newURL.indexOf(paramKey);
                    
                    if (startIndex !== -1) {
                        let endIndex = newURL.indexOf('&', startIndex);
                        if (endIndex === -1) {
                            endIndex = newURL.length;
                        }
                        newURL = newURL.substring(0, startIndex + paramKey.length) + params[key] + newURL.substring(endIndex);
                    } else {
                        if (newURL.indexOf('?') !== -1) {
                            newURL += '&' + key + '=' + params[key];
                        } else {
                            newURL += '?' + key + '=' + params[key];
                        }
                    }
                } else {
                    let paramKey = key + '=';
                    let startIndex = newURL.indexOf(paramKey);
                    if (startIndex !== -1) {
                        let endIndex = newURL.indexOf('&', startIndex);
                        if (endIndex === -1) {
                            endIndex = newURL.length;
                        }
                        newURL = newURL.substring(0, startIndex) + newURL.substring(endIndex + 1);
                    }
                }
            }
        }

        return newURL;
    }

    // Disable, Enable Ajax
    let isHandleAjax = false;

    function mmtfDisableSearchAjax () {
        isHandleAjax = true;
        $('#mmtf-cate-slide-wrap').addClass('disable-search-ajax');
        $('#mmtf_show_result').addClass('disable-search-ajax');
        $('#mmtf_filter_top_btn_search').addClass('disable-search-ajax');
        $('#btn_search_popup_mobile').addClass('disable-search-ajax');
        $('.mmtf_filter_option_group').addClass('disable-search-ajax');
        $('.mmtf_filter_option_group_mobile').addClass('disable-search-ajax');
    }

    function mmtfEnableSearchAjax () {
        isHandleAjax = false;
        $('#mmtf-cate-slide-wrap').removeClass('disable-search-ajax');
        $('#mmtf_show_result').removeClass('disable-search-ajax');
        $('#mmtf_filter_top_btn_search').removeClass('disable-search-ajax');
        $('#btn_search_popup_mobile').removeClass('disable-search-ajax');
        $('.mmtf_filter_option_group').removeClass('disable-search-ajax');
        $('.mmtf_filter_option_group_mobile').removeClass('disable-search-ajax');
    }

    // Search Ajax
    function mmSearchAjax () {
        if (isHandleAjax === true) {
            return;
        }
        mmtfDisableSearchAjax();

        const keyword = $.trim($('#mmtf_filter_search_desktop').val().toLowerCase());
        const dateStart = $('#mm_quick_search_date_start').val();
        const dateEnd = $('#mm_quick_search_date_end').val();
        const priceMin = $('#mmtf_price_range').attr('data-min');
        const priceMax = $('#mmtf_price_range').attr('data-max');
        const durMin = $('#mmtf_duration_min').val();
        const durMax = $('#mmtf_duration_max').val();
        const pickup = $('#mmtf_pickup input:checked').val();
        const timeOfDay = $('#mmtf_time_of_day input:checked').val();
        const category = $('#mmtf-cate-slide-wrap [name="mmtf-cate-slide"]:checked').val()

        if (keyword) {
            $('.mmtf_filter_keyword_search').html(`"${keyword}"`);
        } else {
            $('.mmtf_filter_keyword_search').html("");
        }
        $('#mmtf_products_results').css("padding", "");
        $('#mmtf_products_results').html($('#mmtf_filter_loading_list').html());

        // sa_ is search ajax
        let data = {
            action : 'mmtf_' + 'search_ajax',
            keyword: keyword ? keyword : '',
            sa_date_start: dateStart ? dateStart : '',
            sa_data_end: dateEnd ? dateEnd : '',
            sa_price_min: priceMin ? parseInt(priceMin, 10) : '',
            sa_price_max: priceMax ? parseInt(priceMax, 10) : '',
            sa_dur_min: durMin ? durMin : '',
            sa_dur_max: durMax ? durMax : '',
            sa_pickup: pickup ? pickup : '',
            sa_time_of_day: timeOfDay ? timeOfDay : '',
            sa_category: category ? category : '',
            mmtf_query_by: 'ajax',
        };

        let updatedURL = updateOrAddParamsToURL(window.location.href, data).replace(/&&/g, '&');
        window.history.pushState({}, '', updatedURL);
        mmtfHandleShare(updatedURL);
        $.post( mm_object.ajax_url, data, function ( response ){
            if( response.success === true ){
                if (response.data.post_found) {
                    $('.mmtf_results_header_product_found').text(`${response.data.post_found} activities found`);
                }

                if (response.data.html.indexOf("result_not_found") !== -1) {
                    $('#mmtf_products_results').css({
                        "display": "block",
                        "text-align": "center",
                        "padding": "100px 0 200px"
                    });
                } else {
                    $('#mmtf_products_results').css({
                        "display": "grid",
                        "text-align": ""
                    });
                }

                $('#mmtf_products_results .loading-container').remove();
                $('#mmtf_products_results').html(response.data.html);
                $('#mmtf_load_more').attr('data-args', response.data.args);
                $('#mmtf_load_more').attr('data-mmtf_query_by', 'ajax');
                $('#mmtf_load_more').data('current_page', '1');

                if (response.data.island_checked) {
                    $(`.mmtf_filter_option_group [name="island"][value="${response.data.island_checked}"]`).prop('checked', true).trigger('change');
                }

                if (response.data.show_readmore == true) {
                    $('#mmtf_load_more').css('display', 'block');
                } else {
                    $('#mmtf_load_more').css('display', 'none');
                }

                $('.mmtf-hide-sidebar').click(function (event) {
                    event.stopPropagation();
                    $('#mmtf_sidebar').removeClass('show');
                    $('#mmtf_sidebar_overlay').removeClass('show');
                    $('body').removeClass('open-mm-filter-box');
                });

                $('.mmtf-show-sidebar').click(function (event) {
                    event.stopPropagation();
                    $('#mmtf_sidebar').addClass('show');
                    $('#mmtf_sidebar_overlay').addClass('show');
                    $('body').addClass('open-mm-filter-box');
                });

                slideCategoryFilterSearch();
                productBoxSlider();
                if (response.data.sa_category) {
                    $(`#mmtf-${response.data.sa_category}`).prop("checked", true);
                }

                mmtfEnableSearchAjax();
                
                // if ($('#mmtf_load_more').is(":visible")) {
                //     $('#mmtf_load_more').click();
                // }
            } else {
                console.log( "Failure:", response.data );
                mmtfEnableSearchAjax();
            }
        }, "json");
    }

    // Check Search Ajax
    let searchParamsAjax = new URLSearchParams(window.location.search);

    if (searchParamsAjax.has('mmtf_query_by') && searchParamsAjax.get('mmtf_query_by') === 'ajax') {
        mmSearchAjax();
        mmtfLoadCategoryByIsland();
    }

    $('#mmtf_filter_top_btn_search').click(function() {
        mmSearchAjax();
        mmtfLoadCategoryByIsland();
    });

    function mmFormatDate (date) {
        let dateObj = new Date(date);
        let months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        let month = months[dateObj.getMonth()];
        let day = dateObj.getDate();
        let formattedDate = month + " " + day;
        return formattedDate;
    }

    $('#mm_quick_search_datepicker_apply').click(function() {
        mmSearchAjax();
        mmtfLoadCategoryByIsland();
        let dateString = 'Add dates';
        if ($('#mm_quick_search_date_start').val()) {
            dateString = mmFormatDate($('#mm_quick_search_date_start').val());
        }
        if ($('#mm_quick_search_date_end').val() && ($('#mm_quick_search_date_start').val() != $('#mm_quick_search_date_end').val())) {
            dateString += ` - ${mmFormatDate($('#mm_quick_search_date_end').val())}`;
        }
        $('#mm_quick_search_datepicker_result > b').text(dateString);
    });

    $('#mmtf_filter_search_desktop').keypress(function (event) {
        if (event.which === 13) {
            mmSearchAjax();
            mmtfLoadCategoryByIsland();
        }
    });

    $('#mmtf_filter_search_desktop').keydown(function (event) {
        if (event.which === 9) {
            event.preventDefault();
            $('#mm_quick_search_datepicker_result').click();
        }
    });

    // Search Ajax Mobile
    function mmSearchAjaxMobile () {
        if (isHandleAjax === true) {
            return;
        }
        mmtfDisableSearchAjax();
        $('#mm-search-bar-mobile-wrapper').removeClass('active');

        const keyword = $('#mmtf_filter_search').val();
        const dateStart = $('#mm_quick_search_date_start_header').val();
        const dateEnd = $('#mm_quick_search_date_end_header').val();
        const group = $('#mmtf_filter_quantity_persion').val();
        const priceMin = $('#mmtf_price_range').attr('min');
        const priceMax = $('#mmtf_price_range').attr('max');
        const durMin = $('#mmtf_duration_min').val();
        const durMax = $('#mmtf_duration_max').val();
        const pickup = $('#mmtf_pickup input:checked').val();
        const timeOfDay = $('#mmtf_time_of_day input:checked').val();
        const category = $('#mmtf-cate-slide-wrap [name="mmtf-cate-slide"]:checked').val()
        const island = $('.mmtf_filter_option_group_mobile [name="island"]:checked').val();

        if (keyword == 'oahu' || keyword == 'kauai' || keyword == 'maui' || keyword == 'big island') {
            $('.mmtf_filter_option_group_mobile [name="island"]').prop('checked', false);
            $(`.mmtf_filter_option_group_mobile [name="island"][value="${keyword.replace(/\s+/g, '-')}"]`).prop('checked', true);
            $('[for="mmtf_filter_option_toggle_group_mobile"] span').text(keyword);
        }

        $('#mmtf_products_results').css("padding", "");
        $('#mmtf_products_results').html($('#mmtf_filter_loading_list').html());

        // sa_ is search ajax
        let data = {
            action : 'mmtf_' + 'search_ajax',
            keyword: keyword ? keyword : '',
            island: island ? island : '',
            sa_date_start: dateStart ? dateStart : '',
            sa_data_end: dateEnd ? dateEnd : '',
            sa_group: group ? group : '',
            sa_price_min: priceMin ? priceMin : '',
            sa_price_max: priceMax ? priceMax : '',
            sa_dur_min: durMin ? durMin : '',
            sa_dur_max: durMax ? durMax : '',
            sa_pickup: pickup ? pickup : '',
            sa_time_of_day: timeOfDay ? timeOfDay : '',
            sa_category: category ? category : '',
            mmtf_query_by: 'ajax',
        };

        let updatedURL = updateOrAddParamsToURL(window.location.href, data).replace(/&&/g, '&');
        window.history.pushState({}, '', updatedURL);
        mmtfHandleShare(updatedURL);
        
        $.post( mm_object.ajax_url, data, function ( response ){
            if( response.success === true ){
                if (response.data.post_found) {
                    $('.mmtf_results_header_product_found').text(`${response.data.post_found} activities found`);
                }

                if (response.data.html.indexOf("result_not_found") !== -1) {
                    $('#mmtf_products_results').css({
                        "display": "block",
                        "text-align": "center",
                        "padding": "100px 0 200px"
                    });
                } else {
                    $('#mmtf_products_results').css({
                        "display": "grid",
                        "text-align": ""
                    });
                }

                $('#mmtf_products_results .loading-container').remove();
                $('#mmtf_products_results').html(response.data.html);
                $('#mmtf_load_more').attr('data-args', response.data.args);
                $('#mmtf_load_more').attr('data-mmtf_query_by', 'ajax');
                $('#mmtf_load_more').data('current_page', '1');

                if (response.data.show_readmore == true) {
                    $('#mmtf_load_more').css('display', 'block');
                } else {
                    $('#mmtf_load_more').css('display', 'none');
                }

                $('.mmtf-hide-sidebar').click(function (event) {
                    event.stopPropagation();
                    $('#mmtf_sidebar').removeClass('show');
                    $('#mmtf_sidebar_overlay').removeClass('show');
                    $('body').removeClass('open-mm-filter-box');
                });

                $('.mmtf-show-sidebar').click(function (event) {
                    event.stopPropagation();
                    $('#mmtf_sidebar').addClass('show');
                    $('#mmtf_sidebar_overlay').addClass('show');
                    $('body').addClass('open-mm-filter-box');
                });

                mmtfEnableSearchAjax();

                // if ($('#mmtf_load_more').is(":visible")) {
                //     $('#mmtf_load_more').click();
                // }

            } else {
                console.log( "Failure:", response.data );
                mmtfEnableSearchAjax();
            }
        }, "json");
    }
    
    $('#popup_search_form_mobile #btn_search_popup_mobile button').click(function() {
        mmSearchAjaxMobile();
    });

    $('#mmtf_show_result').click(function() {
        if ($(window).width() > 768) {
            mmSearchAjax();
        } else {
            mmSearchAjaxMobile();
        }
    });

    // Slide category filter
    function slideCategoryFilterSearch () {
        const sliderWrap = $('#mmtf-cate-slide-wrap');
        const slides = $('label', sliderWrap);

        let currentSlide = 0;

        let widthItems = 0;
        slides.each(function () {
            widthItems = widthItems + ($(this).width() + 40);
        });

        $('#mmtf-nextBtn').on('click', function() {
            if (currentSlide < slides.length - 1) {
                currentSlide = (currentSlide + 1) % slides.length;
                sliderWrap.css('transform', `translateX(-${currentSlide * 20}%)`);
                checkButtonsVisibility();
            }
        });

        $('#mmtf-prevBtn').on('click', function() {
            if (currentSlide > 0) {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                sliderWrap.css('transform', `translateX(-${currentSlide * 20}%)`);
                checkButtonsVisibility();
            }
        });

        function checkButtonsVisibility() {
            if (currentSlide === 0) {
                $('#mmtf-prevBtn').hide();
            } else {
                $('#mmtf-prevBtn').show();
            }

            if ((sliderWrap.width() * (currentSlide + 1)) > widthItems) {
                $('#mmtf-nextBtn').hide();
            } else {
                $('#mmtf-nextBtn').show();
            }
        }

        $('#mmtf-prevBtn').hide();

        if (sliderWrap.width() > widthItems) {
            $('#mmtf-nextBtn').hide();
        } else {
            $('#mmtf-nextBtn').show();
        }

        $('#mmtf-cate-slide-wrap [name="mmtf-cate-slide"]').each(function () {
            $(this).change(function () {
                if ($(window).width() > 768) {
                    mmSearchAjax();
                } else {
                    mmSearchAjaxMobile();
                }
            });
        });

        $('#mmtf-cate-slide-wrap .mmtf-btn-uncheck').each(function () {
            $(this).click(function (event) {
                event.preventDefault();
                $(this).siblings("[name='mmtf-cate-slide']").first().prop("checked", false);
                if ($(window).width() > 768) {
                    mmSearchAjax();
                } else {
                    mmSearchAjaxMobile();
                }
            });
        });

        // Mobile
        if ($(window).width() < 768) {
            let isDragging = false;
            let startTouchX, startScrollLeft;

            sliderWrap.on("touchstart", function(e) {
                isDragging = true;
                startTouchX = e.originalEvent.touches[0].clientX;
                startScrollLeft = sliderWrap.scrollLeft();
            });

            $(document).on("touchend", function() {
                if (isDragging) {
                isDragging = false;
                }
            });

            $(document).on("touchmove", function(e) {
                if (!isDragging) return;
                const currentTouchX = e.originalEvent.touches[0].clientX;
                const distance = startTouchX - currentTouchX;
                sliderWrap.scrollLeft(startScrollLeft + distance);
            });
        }    
    }
    slideCategoryFilterSearch();

    function productBoxSlider () {
        $('.mmtf_product_image_slider_container').each(function () {
            let currentIndex = 0;
            let images = $(this).find('.mmtf_product_image_slider_wraper img');
            let animationSpeed = 1000;
            let dots = $(this).find('.dots .dot');

            function showImage(index) {
                images.hide();
                images.eq(index).fadeIn(animationSpeed);
                dots.each(function() {
                    $(this).removeClass('active');
                });
                dots.eq(index).addClass('active');
            }

            function slideNext() {
                currentIndex = (currentIndex + 1) % images.length;
                showImage(currentIndex);
            }

            function slidePrev() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(currentIndex);
            }

            $(this).find('.next').click(function(event) {
                event.preventDefault();
                slideNext();
            });

            $(this).find('.prev').click(function(event) {
                event.preventDefault();
                slidePrev();
            });

            showImage(currentIndex);
        });
    }
    productBoxSlider();

    function mmtfHandleShare (currentURL) {
        const optionCopy = $('#mmtf_option_share_copy');
        const optionEmail = $('#mmtf_option_share_email');
        const optionFacebook = $('#mmtf_option_share_facebook');

        if (currentURL) {
            optionCopy.data('current_url', currentURL);
            optionEmail.attr('href', `mailto:?body=I found this on Hawaiitours and thought you'd love it: - ${currentURL}&subject=Check out this Experience on Hawaiitours!`);
            optionFacebook.attr('href', `https://www.facebook.com/sharer.php?u=${currentURL}`);
        }

        optionCopy.click(function () {
            navigator.clipboard.writeText(optionCopy.data('current_url'));
            optionCopy.addClass('selected');
            setTimeout(function () {
                optionCopy.removeClass('selected');
            }, 3000);
        });
    }
    mmtfHandleShare();

    $("body.page-id-281312").on("click", function(e) {   
        if ($(e.target).closest(".mmtf_btn_share_inner").length) {
            $('#mmtf_btn_share').toggleClass('show');
        } else if ($(e.target).closest("#mmtf_btn_share").length) {
            $('#mmtf_btn_share').addClass('show');
        } else {
            $('#mmtf_btn_share').removeClass('show');
        }
    });

    function mmtfLoadCategoryByIsland () {
        mmtfDisableSearchAjax();
        let loading = '';

        for (var i = 0; i < 20; i++) {
            loading += `<div class="loading">
                <div class="loading-head"></div>
                <div class="loading-text"></div>
            </div>`;
        }

        const sa_category = $('[name="mmtf-cate-slide"]:checked').val();

        $('#mmtf-cate-slide-wrap').html(loading);

        const islandSelected = $('.mmtf_filter_option_group [name="island"]:checked').val();
        const keyword = $.trim($('#mmtf_filter_search_desktop').val().toLowerCase());
        const dateStart = $('#mm_quick_search_date_start').val();
        const dateEnd = $('#mm_quick_search_date_end').val();

        let data = {
            action : 'mmtf_' + 'load_category_filter',
            island_selected: islandSelected,
            keyword: keyword,
            sa_category: sa_category,
            start_day: dateStart,
            end_day: dateEnd,
        };

        $.post( mm_object.ajax_url, data, function ( response ){
            if( response.success === true ){
                $('#mmtf-cate-slide-wrap').html(response.data.html);
                slideCategoryFilterSearch();
                mmtfEnableSearchAjax();
            } else {
                console.log( "Failure:", response.data );
                mmtfEnableSearchAjax();
            }
        }, "json");
    }

    $('.mmtf_filter_option_item [name="island"]').change(function () {
        if ($(this).is(':checked')) {
            $('.mmtf_filter_option_item [name="island"]').prop('checked', false);
            $(this).prop('checked', true);
        } else {
            $('.mmtf_filter_option_item [name="island"]').prop('checked', false);
        }
        $('#mmtf_filter_option_toggle_group').prop('checked', false);
        // mmSearchAjax();
        // mmtfLoadCategoryByIsland();
        $('#mm_quick_search_datepicker_result').click();
    });

    // $('.mmtf_filter_option_item [name="island"]').click(function () {
    //     if ($(this).is(':checked')) {
    //         $(this).prop('checked', false);
    //     }
    // });

    function mmtfClearAllFilter () {
        $('.mmtf_filter_option_item input[name="island"]').prop('checked', false);
        $('#mmtf-cate-slide-wrap input[name="mmtf-cate-slide"]').prop('checked', false);
        $('#mmtf_pickup input[name="sa_pickup"]').prop('checked', false);
        $('#mmtf_time_of_day input[name="time_of_day"]').prop('checked', false);
        $('[for="mmtf_filter_option_toggle_group"] span').text('Choose destinations');
        $('[for="mmtf_filter_option_toggle_group_mobile"] span').text('Select Islands');
        $('#mm_quick_search_datepicker_result label').text('Select dates');
        $('#mm_quick_search_datepicker_result_header label').text('Select dates');
        $('#mmtf_filter_quantity_persion_desktop').val('');
        $('#mmtf_filter_quantity_persion').val('');
        $('#mmtf_filter_search_desktop').val('');
        $('#mmtf_filter_search').val('');
        $('#mmtf_price_range').removeAttr('data-min');
        $('#mmtf_price_range').removeAttr('data-max');
        $('#mmtf_duration_min').val('');
        $('#mmtf_duration_max').val('');
        $('#mm_quick_search_date_start').val('');
        $('#mm_quick_search_date_end').val('');
        $('#mm_quick_search_date_start_header').val('');
        $('#mm_quick_search_date_end_header').val('');
        $('#mmtf_filter_top_form #mmtf_filter_clear_search').removeClass('show');
        $('#popup_search_form_mobile #mmtf_filter_clear_search').removeClass('show');

        if ($(window).width() > 768) {
            mmSearchAjax();
        } else {
            mmSearchAjaxMobile();
        }

        mmtfLoadFilterSlider();

        mmtfLoadCategoryByIsland();

    }

    $('#mmtf_filter_btn_clear_filter').click(function () {
        mmtfClearAllFilter();
    });

    if ($(window).width() < 768) {
        $('#mmtf_filter_top_form .mmtf_filter_option_wrapper').append($('#mmtf_filter_top_btn_search'));
    }
});

if( typeof mm_object === 'undefined' ){
    
    var mm_object = {};
}

// URL manipulation functions
if( typeof mm_object.get_url_var === 'undefined' ){
    mm_object.get_url_var = function( var_name, starting_url = window.location.href ){
        
        var url = new window.URL( starting_url );
        
        return url.searchParams.get( var_name );
    }
}
if( typeof mm_object.set_url_var === 'undefined' ){
    mm_object.set_url_var = function( var_name, var_value, starting_url = window.location.href ){

        var url = new window.URL( starting_url );
        
        url.searchParams.set( var_name, var_value );
        
        return url.toString();
    }
}
if( typeof mm_object.del_url_var === 'undefined' ){
    mm_object.del_url_var = function( var_name, starting_url = window.location.href ){
        
        var url = new window.URL( starting_url );
        
        url.searchParams.delete( var_name );
        
        return url.toString();
    }
}

window.addEventListener('load', function () {
    if (window.location.pathname == '/search/') {
        // Remove widget search footer in page search
        const widgetSearch = document.querySelector('.footer_search');
        widgetSearch && widgetSearch.remove();
        // ----------------------------------------------------------------------

        const overlaySideBar = document.getElementById('mmtf_sidebar_overlay');
        const sideBar = document.getElementById('mmtf_sidebar');
        const body = document.querySelector('body');
        const hideSidebar = document.querySelectorAll('.mmtf-hide-sidebar');
        const showSidebar = document.querySelectorAll('.mmtf-show-sidebar');

        if (hideSidebar.length > 0) {
            hideSidebar.forEach(e => {
                e.addEventListener('click', function (event) {
                    event.stopPropagation();
                    sideBar.classList.remove('show');
                    overlaySideBar.classList.remove('show');
                    body.classList.remove('open-mm-filter-box');
                });
            });
        }

        if (showSidebar.length > 0) {
            showSidebar.forEach(e => {
                e.addEventListener('click', function (event) {
                    event.stopPropagation();
                    sideBar.classList.add('show');
                    overlaySideBar.classList.add('show');
                    body.classList.add('open-mm-filter-box');
                });
            });
        }

        const formTop = document.getElementById("mmtf_filter_top_form");
        if (formTop) {
            formTop.addEventListener('submit', function (e) {
                e.preventDefault();
                const params = new URLSearchParams(window.location.search);
                let paramCert = params.get('cert');
                let paramCat = params.get('cat');
                let paramShowSidebar = params.get('show_sidebar');
                let paramMin = params.get('min');
                let paramMax = params.get('max');
                let paramDurMin = params.get('dur_min');
                let paramDurMax = params.get('dur_max');
                let paramDurOpt = params.get('dur_opt');
                let paramPk = params.get('pk');
    
                let locations = [
                    e.target[1],
                    e.target[2],
                    e.target[3],
                    e.target[4],
                ];
                locations = locations.filter(e => e.checked == true);
                locations = locations.map(e => e.value);
                if (paramCat) {
                    paramCat = paramCat.split(",");
                    paramCat = paramCat.filter(e => ['oahu', 'maui', 'big-island', 'kauai'].includes(e) == false);
                } else {
                    paramCat = [];
                }
    
                locations = [...locations, ...paramCat];
    
                if (locations.length > 0) {
                    locations = locations.filter((item, index) => locations.indexOf(item) === index);
                    locations = locations.join('%2C');
                    locations = `cat=${locations}`;
                } else {
                    locations = null;
                }
    
                let dates = {
                    date_start: e.target[5].value,
                    date_end: e.target[6].value,
                };
    
                if (dates.date_start != '' && dates.date_end != '') {
                    dates = `date_start=${dates.date_start}&date_end=${dates.date_end}`;
                } else if (dates.date_start == '' && dates.date_end != '') {
                    dates = `date_start=${dates.date_end}&date_end=${dates.date_end}`;
                } else if (dates.date_start != '' && dates.date_end == '') {
                    dates = `date_start=${dates.date_start}&date_end=${dates.date_start}`;
                } else {
                    dates = null;
                }
    
                let qtyPersion = e.target[7].value ? `group=${e.target[7].value}` : null;
    
                let searchInput = e.target[8].value;
                
                let search = [
                    locations,
                    dates,
                    qtyPersion,
                ];
    
                search = search.filter(e => e != null);
    
                search = search.join('&');
    
                if (paramCert != null) {
                    paramCert = paramCert.replace(/,/g, "%2C");
                    search = `${search}&cert=${paramCert}`;
                }
    
                if (paramShowSidebar != null) {
                    search = `${search}&show_sidebar=${paramShowSidebar}`;
                }
    
                if (paramMin != null) {
                    search = `${search}&min=${paramMin}`;
                }
    
                if (paramMax != null) {
                    search = `${search}&max=${paramMax}`;
                }
    
                if (searchInput != null && searchInput != '') {
                    search = `${search}&sr=${searchInput}`;
                }

                if (paramDurMin != null && paramDurMin != '') {
                    search = `${search}&dur_min=${paramDurMin}`;
                }

                if (paramDurMax != null && paramDurMax != '') {
                    search = `${search}&dur_max=${paramDurMax}`;
                }

                if (paramDurOpt != null && paramDurOpt != '') {
                    search = `${search}&dur_opt=${paramDurOpt}`;
                }

                if (paramPk != null && paramPk != '') {
                    search = `${search}&pk=${paramPk}`;
                }
    
                let url = window.location.origin + window.location.pathname;
                url = `${url}?${search}`;
    
                window.location.href = url;
            });
        }
        
        const filterItems = document.querySelectorAll('#mmtf_filter .mmtf_filter_item .not-selected');
        if (filterItems.length) {
            filterItems.forEach(e => {
                e.addEventListener("mouseover", function() {
                    let src = e.querySelector('img').getAttribute('src');
                    if (!src.includes('-hover.svg')) {
                        src = src.slice(0, -4);
                        src = `${src}-hover.svg`;
                        e.querySelector('img').setAttribute('src', src);
                    }
                });
                e.addEventListener("mouseout", function() {
                    let src = e.querySelector('img').getAttribute('src');
                    if (src.includes('-hover.svg')) {
                        src = src.slice(0, -10);
                        src = `${src}.svg`;
                        e.querySelector('img').setAttribute('src', src);
                    }
                });
            });
        } 
        
        // ============================
        const checkboxesPickup = document.querySelectorAll('#mmtf_pickup input[type="checkbox"]');
        checkboxesPickup.forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                if (event.target.checked) {
                    uncheckOtherCheckboxes(checkboxesPickup, event.target);
                }
            });
        });

        const checkboxesTimeOfDay = document.querySelectorAll('#mmtf_time_of_day input[type="checkbox"]');
        checkboxesTimeOfDay.forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                if (event.target.checked) {
                    uncheckOtherCheckboxes(checkboxesTimeOfDay, event.target);
                }
            });
        });
        
        function uncheckOtherCheckboxes(checkboxes, checkedCheckbox) {
            checkboxes.forEach(checkbox => {
                if (checkbox !== checkedCheckbox) {
                    checkbox.checked = false;
                }
            });
        }

        // ============================
        const formSidebarFilter = document.getElementById('mmtf_sidebar_filter');
        if (formSidebarFilter) {
            formSidebarFilter.addEventListener('submit', function(event) {
                event.preventDefault();
            
                const form = event.target;
                const formData = new FormData(form);
            
                const currentURL = new URL(window.location.href);
                formData.forEach((value, key) => {
                  currentURL.searchParams.set(key, value);
                });
    
                window.location.href = currentURL;
            });
        }
    }
});
