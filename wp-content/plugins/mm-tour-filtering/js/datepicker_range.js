var mmtf_range_datepicker = {
    next : "start",
    last_hovered_date : false,
    el : {},
};

jQuery( document ).ready( function($){
    'use strict';
	console.log( "Ready: jQuery " + $.fn.jquery );
    
    mmtf_range_datepicker.ui_options = {
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
    
    $('body').on("click", mmtf_range_datepicker.el.result, function(){
        
        if( $(this).hasClass("widget_hidden") ){
            
            mmtf_range_datepicker.ui_options.defaultDate = $( mmtf_range_datepicker.el.date_start ).val() ? $( mmtf_range_datepicker.el.date_start ).val() : new Date();
            
            $( mmtf_range_datepicker.el.widget ).datepicker( mmtf_range_datepicker.ui_options );
            $( mmtf_range_datepicker.el.wrapper ).show();
            $( mmtf_range_datepicker.el.controls ).removeClass("hidden");
            
        } else {
            
            $( mmtf_range_datepicker.el.widget ).datepicker("destroy");
            $( mmtf_range_datepicker.el.wrapper ).hide();
            $( mmtf_range_datepicker.el.controls ).addClass("hidden");
            restore_initial_dates();
        }
        
        $(this).toggleClass("widget_hidden");
        
    });
    
    $('body').on('click', mmtf_range_datepicker.el.result + ' .the_x', function(e){
        e.preventDefault();
        e.stopPropagation();
        
        // $( mmtf_range_datepicker.el.result ).removeClass("has_value");
        // $( mmtf_range_datepicker.el.result + ' span').html( $( mmtf_range_datepicker.el.result ).data('placeholder') );
        
        $( mmtf_range_datepicker.el.date_start ).val("");
        $( mmtf_range_datepicker.el.date_end   ).val("");
        
        calculate_human_readable();
        
        $( mmtf_range_datepicker.el.widget ).datepicker("refresh");
    });
    
    $('body').on("click", mmtf_range_datepicker.el.reset, function(){
        
        $( mmtf_range_datepicker.el.date_start ).val("");
        $( mmtf_range_datepicker.el.date_end   ).val("");
        
        calculate_human_readable();
        
        $( mmtf_range_datepicker.el.widget ).datepicker("refresh");
        
    });
    
    $('body').on("click", mmtf_range_datepicker.el.apply, function(){
        
		var start = $( mmtf_range_datepicker.el.date_start ).val();
		var end   = $( mmtf_range_datepicker.el.date_end   ).val();
        
        $( mmtf_range_datepicker.el.date_start ).data('initial',  start );
        $( mmtf_range_datepicker.el.date_end   ).data('initial',  end   );
        
        $( mmtf_range_datepicker.el.widget ).datepicker("destroy");
        $( mmtf_range_datepicker.el.wrapper ).hide();
        $( mmtf_range_datepicker.el.controls ).addClass("hidden");
        $( mmtf_range_datepicker.el.result ).addClass("widget_hidden");
        
    });
    
    $("body").click(function(e) {
        // console.clear();
        // console.log("target: ", e.target );
        // console.log("target: ", $(e.target) );
        // console.log("parents: ", $(e.target).parents() );
        if( e.target.id == mmtf_range_datepicker.el.wrapper.substring(1) || $( e.target ).parents( mmtf_range_datepicker.el.wrapper ).length || $( e.target ).parents('a.ui-datepicker-prev, a.ui-datepicker-next').length ){
            // console.log("Inside date widget");
        } else if( e.target.id == mmtf_range_datepicker.el.result.substring(1) || $( e.target ).parents( mmtf_range_datepicker.el.result ).length ){
            // console.log("Inside date result");
        } else {
            // console.log("Outside date widget");
            if( ! $( mmtf_range_datepicker.el.result ).hasClass("widget_hidden") ){
                $( mmtf_range_datepicker.el.widget ).datepicker("destroy");
                $( mmtf_range_datepicker.el.wrapper ).hide();
                $( mmtf_range_datepicker.el.controls ).addClass("hidden");
                $( mmtf_range_datepicker.el.result ).addClass("widget_hidden");
                restore_initial_dates();
            }
        }
    });
    
    function define_day_class( date ){
        
		var date_start = $.datepicker.parseDate( 'yy-mm-dd', $( mmtf_range_datepicker.el.date_start ).val() );
		var date_end   = $.datepicker.parseDate( 'yy-mm-dd', $( mmtf_range_datepicker.el.date_end   ).val() );
		let hover_date = false;
        
        if( mmtf_range_datepicker.last_hovered_date ){
            
            hover_date = $.datepicker.parseDate( 'yy-mm-dd', mmtf_range_datepicker.last_hovered_date );
        }
            
        if( hover_date && date_start && date_end && $( mmtf_range_datepicker.el.date_start ).val() != mmtf_range_datepicker.last_hovered_date && $( mmtf_range_datepicker.el.date_end ).val() != mmtf_range_datepicker.last_hovered_date ){
            
            if( days_difference( hover_date, date_start ) > 0 ){
                
                // console.log("start replaced");
                date_start = hover_date;
                
            } else if( days_difference( hover_date, date_end ) < 0 ){
                
                // console.log("end replaced");
                date_end = hover_date;
                
            } else {
                
                if( mmtf_range_datepicker.next === 'start' ){
                    
                    // date_start = hover_date;
                    
                } else {
                    
                    // date_end = hover_date;
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
        
		var date_start = $.datepicker.parseDate( 'yy-mm-dd', $( mmtf_range_datepicker.el.date_start ).val() );
		var date_end   = $.datepicker.parseDate( 'yy-mm-dd', $( mmtf_range_datepicker.el.date_end   ).val() );
		var selected   = $.datepicker.parseDate( 'yy-mm-dd', dateText );
        
        if( ! date_start && ! date_end ){
            
            $( mmtf_range_datepicker.el.date_start ).val( dateText );
            $( mmtf_range_datepicker.el.date_end   ).val( dateText );
            mmtf_range_datepicker.next = "end";
        }
        
        if( date_start && selected < date_start ){
            
            $( mmtf_range_datepicker.el.date_start ).val( dateText );
            mmtf_range_datepicker.next = "end";
        }
        
        if( ! date_end && selected > date_start ){
            
            $( mmtf_range_datepicker.el.date_end ).val( dateText );
            mmtf_range_datepicker.next = "start";
        }
        
        if( date_end && selected > date_end ){
            
            $( mmtf_range_datepicker.el.date_end ).val( dateText );
            mmtf_range_datepicker.next = "start";
        }
        
        if( date_start && date_end && selected > date_start && selected < date_end ){
            
            if( mmtf_range_datepicker.next == "start" ){
               
                $( mmtf_range_datepicker.el.date_start ).val( dateText );
                
            } else {
                
                $( mmtf_range_datepicker.el.date_end ).val( dateText );
                
            }
            
            mmtf_range_datepicker.next = mmtf_range_datepicker.next == "start" ? "end" : "start";
        }
        
        $('#mm_datepicker_widget .ui-datepicker-today').removeClass('ui-datepicker-today').addClass('mm_datepicker_today');
        
        calculate_human_readable();
	}
    
    function restore_initial_dates(){
        
		var start = $( mmtf_range_datepicker.el.date_start ).data('initial');
		var end   = $( mmtf_range_datepicker.el.date_end   ).data('initial');
        
        $( mmtf_range_datepicker.el.date_start ).val( start );
        $( mmtf_range_datepicker.el.date_end   ).val( end   );
        
        calculate_human_readable();
	}
    
    function calculate_human_readable(){
        
		var date_start = $.datepicker.parseDate( 'yy-mm-dd', $( mmtf_range_datepicker.el.date_start ).val() );
		var date_end   = $.datepicker.parseDate( 'yy-mm-dd', $( mmtf_range_datepicker.el.date_end   ).val() );
        
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
            
            human_readable = $( mmtf_range_datepicker.el.result ).data('placeholder');
            
            $( mmtf_range_datepicker.el.result ).removeClass("has_value");
        } else {
            $( mmtf_range_datepicker.el.result ).addClass("has_value");
        }
        
        $( mmtf_range_datepicker.el.result + ' span').html( human_readable );
        
    }
    
    function days_difference( date_start, date_end, absolute = false ){
        
        let difference = absolute ? Math.abs( date_end.getTime() - date_start.getTime() ) / ( 1000 * 60 * 60 * 24 ) : ( date_end.getTime() - date_start.getTime() ) / ( 1000 * 60 * 60 * 24 );
        
        return Number.parseInt( difference );
    }
    
    $('body').on('mouseenter', mmtf_range_datepicker.el.widget + ' table.ui-datepicker-calendar tbody tr td[data-handler="selectDay"]', function(){
        
        let $hovered = $(this);
        
        let hover_date_string = "" + $hovered.data("year") + "-" + ( $hovered.data("month") + 1 ) + "-" + $hovered.children('a').text();
        
        if( hover_date_string == mmtf_range_datepicker.last_hovered_date ){
            
            return;
        }
        
        mmtf_range_datepicker.last_hovered_date = hover_date_string;
        
        // console.log("refresh: ", mmtf_range_datepicker.last_hovered_date );
        //$( mmtf_range_datepicker.el.widget ).datepicker("refresh");
        
    });
    $('body').on('mouseleave', mmtf_range_datepicker.el.widget + ' table.ui-datepicker-calendar tbody tr', function(){
        
        mmtf_range_datepicker.last_hovered_date = false;
        
        // console.log("refresh leave: ", mmtf_range_datepicker.last_hovered_date );
        //$( mmtf_range_datepicker.el.widget ).datepicker("refresh");
    });
    
});
