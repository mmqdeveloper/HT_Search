window.addEventListener('load', function () {
    const searchInputs = document.querySelectorAll('.mmtf_filter_search_wrapper > input');
    const btnClearSearch = document.querySelectorAll('#mmtf_filter_clear_search');

    searchInputs.forEach(function (input) {
        if (input.value !== '') {
            btnClearSearch.forEach(function (clear) {
                !clear.classList.contains('show') && clear.classList.add('show');
            });
        } else {
            btnClearSearch.forEach(function (clear) {
                clear.classList.remove('show');
            });
        }
        input.addEventListener('keyup', function (e) {
            if (e.target.value !== '') {
                btnClearSearch.forEach(function (clear) {
                    !clear.classList.contains('show') && clear.classList.add('show');
                });
            } else {

                btnClearSearch.forEach(function (clear) {
                    clear.classList.remove('show');
                });
            }
        });
    });

    btnClearSearch.forEach(function (clear) {
        clear.addEventListener('click', function (e) {
            searchInputs.forEach(function (input) {
                input.value = '';
            });
            e.target.classList.remove('show');
        });
    });

    const searchContainer = document.querySelector('#mm-search-bar-mobile-wrapper.not-active');
    const btnCloseSearch = document.getElementById('mm-search-bar-mobile-btn-close');
    const inputSearch = document.getElementById('search-box-mobile-header');
    const suggestions = document.getElementById('mm-search-bar-mobile-suggestions');
    const searchSuggestions = document.querySelectorAll('#mm-search-bar-mobile-suggestions .mm-search-suggestions-item');
    const btnClosePopupSearchMobile = document.getElementById('btn_close_popup_search_mobile');
    const openPopupSearch = document.getElementById('btn_open_filter_top_mobile');
    const overlayPopupSearch = document.getElementById('popup-search-mobile-overlay');

    if (openPopupSearch && overlayPopupSearch && btnClosePopupSearchMobile) {
        openPopupSearch.addEventListener('click', function () {
            searchContainer.classList.remove('not-active');
            searchContainer.classList.add('active');
        });
        overlayPopupSearch.addEventListener('click', function () {
            searchContainer.classList.remove('active');
            searchContainer.classList.add('not-active');
        });
        btnClosePopupSearchMobile.addEventListener('click', function () {
            searchContainer.classList.remove('active');
            searchContainer.classList.add('not-active');
        });
    }

    // ===================== Handle Fill Datepicker Desktop ================= //
    const dateStart = document.getElementById('mm_quick_search_date_start');
    const dateEnd = document.getElementById('mm_quick_search_date_end');
    const applyDate = document.getElementById('mm_quick_search_datepicker_apply');
    const showDate = document.querySelector('#mm_quick_search_datepicker_result label');

    const formatDateShow = (start, end) => {
        const dateStart = start.split('-');
        const dateEnd = end.split('-');
        let monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        let result = 'Select dates';

        if (start && end) {
            if (dateStart[1] == dateEnd[1] && dateStart[2] != dateEnd[2]) {
                let month = monthNames[Number(dateStart[1]) - 1];
                result = `${month} ${dateStart[2]} - ${dateEnd[2]}`;
            } else if (dateStart[1] != dateEnd[1] && dateStart[2] != dateEnd[2]) {
                let monthStart = monthNames[Number(dateStart[1]) - 1];
                let monthEnd = monthNames[Number(dateEnd[1]) - 1];
                result = `${monthStart} ${dateStart[2]} - ${monthEnd} ${dateEnd[2]}`;
            } else if (dateStart[1] == dateEnd[1] && dateStart[2] == dateEnd[2]) {
                let month = monthNames[Number(dateStart[1]) - 1];
                result = `${month} ${dateStart[2]}`;
            } else if ((dateStart[1] != dateEnd[1] && dateStart[2] == dateEnd[2])) {
                let monthStart = monthNames[Number(dateStart[1]) - 1];
                let monthEnd = monthNames[Number(dateEnd[1]) - 1];
                result = `${monthStart} ${dateStart[2]} - ${monthEnd} ${dateEnd[2]}`;
            }
        }
        
        return result;
    }
    
    if (applyDate && showDate) {
        applyDate.addEventListener('click', function () {
            showDate.innerText = formatDateShow(dateStart.value, dateEnd.value);
        });
    }

    // ===================== Handle Fill Datepicker Mobile ================= //
    const dateStartHeader = document.getElementById('mm_quick_search_date_start_header');
    const dateEndHeader = document.getElementById('mm_quick_search_date_end_header');
    const applyDateHeader = document.getElementById('mm_quick_search_datepicker_apply_header');
    const showDateHeader = document.querySelector('#mm_quick_search_datepicker_result_header label');

    const formatDateShowHeader = (start, end) => {
        const dateStartHeader = start.split('-');
        const dateEndHeader = end.split('-');
        let monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        let result = 'Select dates';

        if (start && end) {
            if (dateStartHeader[1] == dateEndHeader[1] && dateStartHeader[2] != dateEndHeader[2]) {
                let month = monthNames[Number(dateStartHeader[1]) - 1];
                result = `${month} ${dateStartHeader[2]} - ${dateEndHeader[2]}`;
            } else if (dateStartHeader[1] != dateEndHeader[1] && dateStartHeader[2] != dateEndHeader[2]) {
                let monthStart = monthNames[Number(dateStartHeader[1]) - 1];
                let monthEnd = monthNames[Number(dateEndHeader[1]) - 1];
                result = `${monthStart} ${dateStartHeader[2]} - ${monthEnd} ${dateEndHeader[2]}`;
            } else if (dateStartHeader[1] == dateEndHeader[1] && dateStartHeader[2] == dateEndHeader[2]) {
                let month = monthNames[Number(dateStartHeader[1]) - 1];
                result = `${month} ${dateStartHeader[2]}`;
            } else if ((dateStartHeader[1] != dateEndHeader[1] && dateStartHeader[2] == dateEndHeader[2])) {
                let monthStart = monthNames[Number(dateStartHeader[1]) - 1];
                let monthEnd = monthNames[Number(dateEndHeader[1]) - 1];
                result = `${monthStart} ${dateStartHeader[2]} - ${monthEnd} ${dateEndHeader[2]}`;
            }
        }
        
        return result;
    }
    if(applyDateHeader){
        applyDateHeader.addEventListener('click', function () {
            showDateHeader.innerText = formatDateShowHeader(dateStartHeader.value, dateEndHeader.value);
        });
    }
    

    // ==================================================================== //

    const groupOptionIsland = document.querySelector('.mmtf_filter_option_group');
    const btnOptionIsland = document.querySelector('.mmtf_filter_option_selected');
    const groupOptionIslandMobile = document.querySelector('.mmtf_filter_option_group_mobile');
    const btnOptionIslandMobile = document.querySelector('.mmtf_filter_option_selected_mobile');
    
    document.addEventListener('click', function (event) {
        const statusGroupOptionIsland = document.getElementById('mmtf_filter_option_toggle_group');
        const statusGroupOptionIslandMobile = document.getElementById('mmtf_filter_option_toggle_group_mobile');
        if (groupOptionIsland && btnOptionIsland && statusGroupOptionIsland) {
            if (!groupOptionIsland.contains(event.target) 
                && !btnOptionIsland.contains(event.target) 
                && !statusGroupOptionIsland.contains(event.target) 
                && statusGroupOptionIsland.checked == true
            ) {
                statusGroupOptionIsland.checked = false;
            }
        }
        if (groupOptionIslandMobile && btnOptionIslandMobile && statusGroupOptionIslandMobile) {
            if (!groupOptionIslandMobile.contains(event.target) 
                && !btnOptionIslandMobile.contains(event.target) 
                && !statusGroupOptionIslandMobile.contains(event.target) 
                && statusGroupOptionIslandMobile.checked == true
            ) {
                statusGroupOptionIslandMobile.checked = false;
            }
        }
    });

    

    const popupSearchFormMobile = document.getElementById("popup_search_form_mobile");

    if (popupSearchFormMobile) {
        popupSearchFormMobile.addEventListener('submit', function (e) {
            e.preventDefault();

            let dates = {
                date_start: e.target[1].value,
                date_end: e.target[2].value,
            };
    
            if (dates.date_start != '' && dates.date_end != '') {
                dates = `sa_date_start=${dates.date_start}&sa_data_end=${dates.date_end}`;
            } else if (dates.date_start == '' && dates.date_end != '') {
                dates = `sa_date_start=${dates.date_end}&sa_data_end=${dates.date_end}`;
            } else if (dates.date_start != '' && dates.date_end == '') {
                dates = `sa_date_start=${dates.date_start}&sa_data_end=${dates.date_start}`;
            } else {
                dates = null;
            }

            let searchInput = e.target[0].value;
            
            let search = [
                dates,
            ];
    
            search = search.filter(e => e != null);
    
            search = search.join('&');
    
            if (searchInput != null && searchInput != '') {
                search = `${search}&keyword=${searchInput}`;
            }
    
            let url = window.location.origin + '/search/';
            url = `${url}?${search}&action=mmtf_search_ajax&mmtf_query_by=ajax`;
    
            window.location.href = url;
        });
    }

    const scroll = document.querySelector("#mmtf_filter .mmtf_filter_inner");
    if (scroll) {
        let isDown = false;
        let scrollX;
        let scrollLeft;

        scroll.addEventListener("mouseup", () => {
            isDown = false;
            scroll.classList.remove("active");
        });

        scroll.addEventListener("mouseleave", () => {
            isDown = false;
            scroll.classList.remove("active");
        });

        scroll.addEventListener("mousedown", (e) => {
            e.preventDefault();
            isDown = true;
            scroll.classList.add("active");
            scrollX = e.pageX - scroll.offsetLeft;
            scrollLeft = scroll.scrollLeft;
        });

        scroll.addEventListener("mousemove", (e) => {
            if (!isDown) return;
            e.preventDefault();
            var element = e.pageX - scroll.offsetLeft;
            var scrolling = (element - scrollX) * 2;
            scroll.scrollLeft = scrollLeft - scrolling;
        });
    }
});

jQuery(document).ready(function(){
    function mmtfFormatIslandName (name) {
        return name.replace(/-/g, ' ').charAt(0).toUpperCase() + name.replace(/-/g, ' ').slice(1);
    }
    jQuery('#mmtf_filter_top_form .mmtf_filter_option_group input[type="checkbox"]').each(function() {
        jQuery( this ).change(function() {
            setTimeout(function () {
                let textIsland = '';
                jQuery('#mmtf_filter_top_form .mmtf_filter_option_group input[type="checkbox"]:checked').each(function( index ) {
                    if (index == 0) {
                        textIsland += jQuery(this).val();
                    } else {
                        textIsland += `, ${jQuery(this).val()}`;
                    }
                });

                if (textIsland != '') {
                    jQuery('[for="mmtf_filter_option_toggle_group"] span').text(mmtfFormatIslandName(textIsland));
                } else {
                    jQuery('[for="mmtf_filter_option_toggle_group"] span').text('Choose destinations');
                }
            }, 100);
        }); 
    });

    jQuery('#popup_search_form_mobile .mmtf_filter_option_item input[type="checkbox"]').each(function() {
        jQuery( this ).change(function() {
            setTimeout(function () {
                let textIsland = '';
                jQuery('#popup_search_form_mobile .mmtf_filter_option_item input[type="checkbox"]:checked').each(function( index ) {
                    if (index == 0) {
                        textIsland += jQuery(this).val();
                    } else {
                        textIsland += `, ${jQuery(this).val()}`;
                    }
                });

                if (textIsland != '') {
                    jQuery('[for="mmtf_filter_option_toggle_group_mobile"] span').text(mmtfFormatIslandName(textIsland));
                } else {
                    jQuery('[for="mmtf_filter_option_toggle_group_mobile"] span').text('Select Islands');
                }
            }, 100);
        }); 
    });

    if(jQuery('#mmtf_filter_top_form').length > 0){
        jQuery('#mmtf_filter_top_form .mmtf_filter_option input#mmtf_filter_search').focus();
        jQuery('#mmtf_filter_top_form .mmtf_filter_option:last-child').addClass('active');
        jQuery('#mmtf_filter_top_form #mmtf_filter_top_btn_search').addClass('active');
    }
    
    jQuery(document).on('click', function(e) {
        if (!e.target.closest('#mmtf_filter_option_search_autocomplate')) {
            var filterOptionSearch = jQuery('#mmtf_filter_option_search_autocomplate');
            filterOptionSearch.html('');
            filterOptionSearch.css({'height':'0'});
            filterOptionSearch.removeClass('on-show');
        }
        if (e.target.closest('#mmtf_filter_top_form .mmtf_filter_option')) {
            var filterOption = jQuery(e.target.closest('.mmtf_filter_option'));
            if(!filterOption.hasClass('active')){
                var btn_search = jQuery('#mmtf_filter_top_form #mmtf_filter_top_btn_search');
                if(filterOption.hasClass('key-search'))
                    btn_search.addClass('active')
                else 
                    btn_search.removeClass('active');
                jQuery('#mmtf_filter_top_form .mmtf_filter_option').removeClass('active');
                filterOption.addClass('active');
            }
            
        }
        // if (e.target.closest('#mmtf_filter_top_form .mmtf_filter_option.active .mmtf_filter_option_group .mmtf_filter_option_item label')) {
            
        //     var foundElement = jQuery(e.target.closest('#mmtf_filter_top_form .mmtf_filter_option.active .mmtf_filter_option_group .mmtf_filter_option_item label'));
        //     var foundTitle = foundElement.find('span');
        //     var title = '';
        //     if (foundTitle.length) {
        //         title = foundTitle.text();
        //     }
        //     if(title){
        //         var chooseAnIsland = jQuery('#mmtf_filter_top_form .mmtf_filter_option.active .mmtf_filter_option_selected span');
        //         var currentText = chooseAnIsland.text();
        //         if (currentText == 'Choose an Island') {
        //             chooseAnIsland.text(title);
        //         }else{
        //             if(currentText.trim() == title.trim()){
        //                 chooseAnIsland.text('Choose an Island');
        //             }else{
        //                 if ( currentText.includes(title.trim())) {
        //                     var arrayIsland = currentText.split(',');
        //                     arrayIsland.forEach(function(element, index, arrayIsland) {
        //                         if(title.trim() == element.trim()){
        //                             arrayIsland.splice(index, 1);
        //                         }
        //                     });
        //                     //var chooseAnIsland_text = currentText.replace(',' + title, '').replace( title + ',', '').replace(title, '');
        //                     chooseAnIsland.text(arrayIsland.join(", "));
        //                 }else{
        //                     chooseAnIsland.text(currentText + ', ' + title);
        //                 }
        //             }
                    

        //         }
                
        //     }
        // }
    });
});

// =============================== Datepicker =====================================
var mm_filter_search_header = {
    next : "start",
    last_hovered_date : false,
    el : {},
};

mm_filter_search_header.el = {
    date_start : "#mm_quick_search_date_start_header",
    date_end   : "#mm_quick_search_date_end_header",
    wrapper    : "#mm_quick_search_datepicker_wrapper_header",
    result     : "#mm_quick_search_datepicker_result_header",
    widget     : "#mmtf_datepicker_widget_header",
    controls   : "#mm_quick_search_datepicker_controls_header",
    reset      : "#mm_quick_search_datepicker_reset_header",
    apply      : "#mm_quick_search_datepicker_apply_header",
    close      : "#mm_quick_search_datepicker_close_header",
};

jQuery( document ).ready( function($){
    'use strict';
    console.log( "Ready: jQuery " + $.fn.jquery );

    mm_filter_search_header.ui_options = {
        dateFormat      : 'yy-mm-dd',
        dayNamesMin     : [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
        minDate         : 0,
        maxDate         : "+1y",
        gotoCurrent     : true,
        showButtonPanel : false,
        beforeShowDay   : define_day_class,
        onSelect        : populate_hidden_fields
    };
    
    calculate_human_readable();
    
    $('body').on("click", mm_filter_search_header.el.result, function(){
        if( $(this).hasClass("widget_hidden") ){
            
            mm_filter_search_header.ui_options.defaultDate = $( mm_filter_search_header.el.date_start ).val() ? $( mm_filter_search_header.el.date_start ).val() : new Date();
            
            $( mm_filter_search_header.el.widget ).datepicker( mm_filter_search_header.ui_options );
            $( mm_filter_search_header.el.wrapper ).show();
            $( mm_filter_search_header.el.controls ).removeClass("hidden");
            
        } else {
            
            $( mm_filter_search_header.el.widget ).datepicker("destroy");
            $( mm_filter_search_header.el.wrapper ).hide();
            $( mm_filter_search_header.el.controls ).addClass("hidden");
            restore_initial_dates();
        }
        
        $(this).toggleClass("widget_hidden");
        
    });
    
    $('body').on('click', mm_filter_search_header.el.result + ' .the_x', function(e){
        e.preventDefault();
        e.stopPropagation();
        
        // $( mm_filter_search_header.el.result ).removeClass("has_value");
        // $( mm_filter_search_header.el.result + ' span').html( $( mm_filter_search_header.el.result ).data('placeholder') );
        
        $( mm_filter_search_header.el.date_start ).val("");
        $( mm_filter_search_header.el.date_end   ).val("");
        
        calculate_human_readable();
        
        $( mm_filter_search_header.el.widget ).datepicker("refresh");
    });
    
    $('body').on("click", mm_filter_search_header.el.reset, function(){
        
        $( mm_filter_search_header.el.date_start ).val("");
        $( mm_filter_search_header.el.date_end   ).val("");
        
        calculate_human_readable();
        
        $( mm_filter_search_header.el.widget ).datepicker("refresh");
        
    });
    
    $('body').on("click", mm_filter_search_header.el.apply, function(){
        
        var start = $( mm_filter_search_header.el.date_start ).val();
        var end   = $( mm_filter_search_header.el.date_end   ).val();
        
        $( mm_filter_search_header.el.date_start ).data('initial',  start );
        $( mm_filter_search_header.el.date_end   ).data('initial',  end   );
        
        $( mm_filter_search_header.el.widget ).datepicker("destroy");
        $( mm_filter_search_header.el.wrapper ).hide();
        $( mm_filter_search_header.el.controls ).addClass("hidden");
        $( mm_filter_search_header.el.result ).addClass("widget_hidden");
        
    });
    
    $("body").click(function(e) {
        // console.clear();
        // console.log("target: ", e.target );
        // console.log("target: ", $(e.target) );
        // console.log("parents: ", $(e.target).parents() );
        if (`#${$(e.target).attr('id')}` == mm_filter_search_header.el.close) {
            if( ! $( mm_filter_search_header.el.result ).hasClass("widget_hidden") ){
                $( mm_filter_search_header.el.widget ).datepicker("destroy");
                $( mm_filter_search_header.el.wrapper ).hide();
                $( mm_filter_search_header.el.controls ).addClass("hidden");
                $( mm_filter_search_header.el.result ).addClass("widget_hidden");
                restore_initial_dates();
            }
        }

        if( e.target.id == mm_filter_search_header.el.wrapper.substring(1) || $( e.target ).parents( mm_filter_search_header.el.wrapper ).length || $( e.target ).parents('a.ui-datepicker-prev, a.ui-datepicker-next').length ){
        } else if( e.target.id == mm_filter_search_header.el.result.substring(1) || $( e.target ).parents( mm_filter_search_header.el.result ).length ){

        } else {
            if( ! $( mm_filter_search_header.el.result ).hasClass("widget_hidden") ){
                $( mm_filter_search_header.el.widget ).datepicker("destroy");
                $( mm_filter_search_header.el.wrapper ).hide();
                $( mm_filter_search_header.el.controls ).addClass("hidden");
                $( mm_filter_search_header.el.result ).addClass("widget_hidden");
                restore_initial_dates();
            }
        }
    });
    
    function define_day_class( date ){
        
        var date_start = $.datepicker.parseDate( 'yy-mm-dd', $( mm_filter_search_header.el.date_start ).val() );
        var date_end   = $.datepicker.parseDate( 'yy-mm-dd', $( mm_filter_search_header.el.date_end   ).val() );
        let hover_date = false;
        
        if( mm_filter_search_header.last_hovered_date ){
            
            hover_date = $.datepicker.parseDate( 'yy-mm-dd', mm_filter_search_header.last_hovered_date );
        }
            
        if( hover_date && date_start && date_end && $( mm_filter_search_header.el.date_start ).val() != mm_filter_search_header.last_hovered_date && $( mm_filter_search_header.el.date_end ).val() != mm_filter_search_header.last_hovered_date ){
            
            if( days_difference( hover_date, date_start ) > 0 ){
                
                date_start = hover_date;
                
            } else if( days_difference( hover_date, date_end ) < 0 ){
                
                date_end = hover_date;
                
            } else {
                
                if( mm_filter_search_header.next === 'start' ){
                    
                } else {
                    
                }
                
            }
            
        }
        
        let selectable = true;
        let css_class  = '';
        
        // we have the range start
        if( date_start && date.getTime() == date_start.getTime() ){
            
            css_class += ' mm_range_picker__range_start';
        }
        
        // we have the range end
        if( date_end && date.getTime() == date_end.getTime() ){
            
            css_class += ' mm_range_picker__range_end';
        }
        
        // range is more than 1 day so we have middle, then start and end look different
        if( date_start && date_end && ( date.getTime() == date_start.getTime() || date.getTime() == date_end.getTime() ) ){
            
            if( days_difference( date_start, date_end ) >= 1 ){
                
                css_class += ' range_long';
            }
        }
        
        // this date is within the range
        if( ( date_start && date.getTime() > date_start.getTime() ) && ( date_end && date.getTime() < date_end.getTime() ) ){
            
            css_class = 'mm_range_picker__range_middle';
        }
        
        return [ selectable, css_class ];
    }
    
    function populate_hidden_fields( dateText, inst ){
        
        var date_start = $.datepicker.parseDate( 'yy-mm-dd', $( mm_filter_search_header.el.date_start ).val() );
        var date_end   = $.datepicker.parseDate( 'yy-mm-dd', $( mm_filter_search_header.el.date_end   ).val() );
        var selected   = $.datepicker.parseDate( 'yy-mm-dd', dateText );
        
        if( ! date_start && ! date_end ){
            
            $( mm_filter_search_header.el.date_start ).val( dateText );
            $( mm_filter_search_header.el.date_end   ).val( dateText );
            mm_filter_search_header.next = "end";
        }
        
        if( date_start && selected < date_start ){
            
            $( mm_filter_search_header.el.date_start ).val( dateText );
            mm_filter_search_header.next = "end";
        }
        
        if( ! date_end && selected > date_start ){
            
            $( mm_filter_search_header.el.date_end ).val( dateText );
            mm_filter_search_header.next = "start";
        }
        
        if( date_end && selected > date_end ){
            
            $( mm_filter_search_header.el.date_end ).val( dateText );
            mm_filter_search_header.next = "start";
        }
        
        if( date_start && date_end && selected > date_start && selected < date_end ){
            
            if( mm_filter_search_header.next == "start" ){
               
                $( mm_filter_search_header.el.date_start ).val( dateText );
                
            } else {
                
                $( mm_filter_search_header.el.date_end ).val( dateText );
                
            }
            
            mm_filter_search_header.next = mm_filter_search_header.next == "start" ? "end" : "start";
        }
        
        $('#mm_datepicker_widget .ui-datepicker-today').removeClass('ui-datepicker-today').addClass('mm_datepicker_today');
        
        calculate_human_readable();
    }
    
    function restore_initial_dates(){
        
        var start = $( mm_filter_search_header.el.date_start ).data('initial');
        var end   = $( mm_filter_search_header.el.date_end   ).data('initial');
        
        $( mm_filter_search_header.el.date_start ).val( start );
        $( mm_filter_search_header.el.date_end   ).val( end   );
        
        calculate_human_readable();
    }
    
    function calculate_human_readable(){
        
        var date_start = $.datepicker.parseDate( 'yy-mm-dd', $( mm_filter_search_header.el.date_start ).val() );
        var date_end   = $.datepicker.parseDate( 'yy-mm-dd', $( mm_filter_search_header.el.date_end   ).val() );
        
        let human_readable = "";
        
        if( date_start ){
            
            human_readable += $.datepicker.formatDate( "d M", date_start );
        }
        
        if( date_start && date_end ){
            
            if( $.datepicker.formatDate( "d M", date_start ) == $.datepicker.formatDate( "d M", date_end ) ){
                
                // do nothing, we have a single day range
                
            } else if( $.datepicker.formatDate( "M", date_start ) == $.datepicker.formatDate( "M", date_end ) ){
                
                human_readable  = $.datepicker.formatDate( "d", date_start );
                human_readable += " - ";
                human_readable += $.datepicker.formatDate( "d M", date_end );
                
            } else {
                
                human_readable += " - ";
                human_readable += $.datepicker.formatDate( "d M", date_end );
            }
        }
        
        if( ! human_readable ){
            
            human_readable = $( mm_filter_search_header.el.result ).data('placeholder');
            
            $( mm_filter_search_header.el.result ).removeClass("has_value");
        } else {
            $( mm_filter_search_header.el.result ).addClass("has_value");
        }
        
        $( mm_filter_search_header.el.result + ' span').html( human_readable );
        
    }
    
    function days_difference( date_start, date_end, absolute = false ){
        
        let difference = absolute ? Math.abs( date_end.getTime() - date_start.getTime() ) / ( 1000 * 60 * 60 * 24 ) : ( date_end.getTime() - date_start.getTime() ) / ( 1000 * 60 * 60 * 24 );
        
        return Number.parseInt( difference );
    }
    
    $('body').on('mouseenter', mm_filter_search_header.el.widget + ' table.ui-datepicker-calendar tbody tr td[data-handler="selectDay"]', function(){
        
        let $hovered = $(this);
        
        let hover_date_string = "" + $hovered.data("year") + "-" + ( $hovered.data("month") + 1 ) + "-" + $hovered.children('a').text();
        
        if( hover_date_string == mm_filter_search_header.last_hovered_date ){
            
            return;
        }
        
        mm_filter_search_header.last_hovered_date = hover_date_string;   
        
    });
    $('body').on('mouseleave', mm_filter_search_header.el.widget + ' table.ui-datepicker-calendar tbody tr', function(){
        
        mm_filter_search_header.last_hovered_date = false;

    });
    
});
