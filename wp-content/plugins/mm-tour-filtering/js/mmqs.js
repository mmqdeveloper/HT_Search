
mmtf_range_datepicker.el = {
    date_start : "#mm_quick_search_date_start",
    date_end   : "#mm_quick_search_date_end",
    wrapper    : "#mm_quick_search_datepicker_wrapper",
    result     : "#mm_quick_search_datepicker_result",
    widget     : "#mmtf_datepicker_widget",
    controls   : "#mm_quick_search_datepicker_controls",
    reset      : "#mm_quick_search_datepicker_reset",
    apply      : "#mm_quick_search_datepicker_apply",
};



jQuery( document ).ready( function($){
    'use strict';
	console.log( "Ready: jQuery " + $.fn.jquery );
    
    $('#mm_quick_search_submit').click(function(){
        $(this).html('<div class="quick-search-loader"></div>');
        $(this).css('pointer-events', 'none');
        
        let date_start      = $('#mm_quick_search_date_start').val();
        let date_end        = $('#mm_quick_search_date_end').val();
        
        let keyword = $('#mm_quick_search_keyword').val();
        let goto_link = mm_object.set_url_var( 'keyword', keyword, mm_object.search_page_url );
        if( date_start ){
            
            goto_link = mm_object.set_url_var( 'sa_date_start', date_start, goto_link );
        }
        
        if( date_end ){
            
            goto_link = mm_object.set_url_var( 'sa_data_end',   date_end,   goto_link );
        }

        goto_link = mm_object.set_url_var( 'mmtf_query_by',   'ajax',   goto_link );

        window.location.href = goto_link;
        
        return true;// to allow the browser to know that we handled it.
    });

    $('#mm_quick_search_keyword').keyup(function (event) {
        if (event.which === 13) {
            if ($(this).val() != '') {
                $('#mm_quick_search_submit').click();
            }
        }
    });

    $('#mm_quick_search_keyword').keydown(function (event) {
        if (event.which === 9) {
            event.preventDefault();
            $('#mm_quick_search_datepicker_result').click();
        }
    });
    
    $('body').on('click', '#mm_quick_search_island_result', function(){
        
        $('#mm_quick_search_island_result').hide();
        $('#mm_quick_search_island_widget').show();
        
    });
    
    $('body').on('click', '#mm_quick_search_island_widget .island_selector', function(){
        
        $(this).toggleClass('selected');
        
        let island_cat = $(this).data('control');
        
        $('#mm_quick_search_island option[value="' + island_cat + '"]').prop('selected', $(this).hasClass('selected') );
        
        
        let islands = $('#mm_quick_search_island option:selected').length;
        
        let text = islands ? islands + ' island' : 'All island';
            text = islands === 1 ? $('#mm_quick_search_island option:selected').text() : text + 's';
        
        $('#mm_quick_search_island_result').html( text );
        
    });
    
    $('body').on('click', '#mm_quick_search_island_apply', function(){
        
        $('#mm_quick_search_island_widget').hide();
        
    });

    if ($(window).width() < 600) {
        $('#mm_quick_search').append($('#mm_quick_search_submit'));
    }
    
    $('#mm_quick_search_keyword').keyup(function () {
        const inputValue = $(this).val();
        if (inputValue != '') {
            $('#mm_quick_search #mmtf_filter_clear_search').addClass('show');
        } else {
            $('#mm_quick_search #mmtf_filter_clear_search').removeClass('show');
        }
    });

    $('#mm_quick_search #mmtf_filter_clear_search').click(function () {
        $('#mm_quick_search_keyword').val('');
        $('#mm_quick_search #mmtf_filter_clear_search').removeClass('show');
    });
    
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

jQuery(document).ready(function($) {
    $('#popup_search_form_mobile .mmtf_filter_option_item [name="island"]').change(function () {
        if ($(this).is(':checked')) {
            $('#popup_search_form_mobile .mmtf_filter_option_item [name="island"]').prop('checked', false);
            $(this).prop('checked', true);
        } else {
            $('#popup_search_form_mobile .mmtf_filter_option_item [name="island"]').prop('checked', false);
        }
        $('#mmtf_filter_option_toggle_group_mobile').prop('checked', false);
    });
});