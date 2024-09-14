
jQuery( document ).ready( function($){
    'use strict';
	console.log( "Ready: jQuery " + $.fn.jquery );
    
    let product_ids = {
        processed : [],
        todo      : [],
    };
    
    $('body').on('click', '#progress_start', function(){
        
        $('#progress_start_wrapper').slideUp();
        $('#progress_result_wrapper').slideDown();
        
        call_ajax__recalculate_products();
        
    });
    
    function call_ajax__recalculate_products(){
        
        let data = {
            action      : 'mmtf_' + 'recalculate_products',
            product_ids : product_ids,
        };
        
        $.post( mm_object.ajax_url, data, function( response ){
            
            if( response.success === true ){
                // console.clear();
                console.log( response.data );
                
                product_ids.processed = response.data.processed;
                product_ids.todo      = response.data.todo;
                
                
                if( ! response.data.todo ){
                    
                    $('#progress_bar').removeClass('animate').css('opacity', '0' );
                    
                    $('#progress_result_wrapper').html( 'All done! Processed ' + product_ids.processed.length + ' published products.' );
                    
                    return;// nothing to do anymore
                }
                
                
                update_progress_numbers();
                
                // one more round
                call_ajax__recalculate_products();
                
            } else {
                
                console.log( "Failure:", response.data );
            }
            
            
        }, "json");
        
    }
    
    function update_progress_numbers(){
        
        let total = product_ids.processed.length + product_ids.todo.length;
        
        let result = product_ids.processed.length + " / " + total;
        
        $('#progress_result').html( result );
        
        
        let percentage = parseInt( product_ids.processed.length / total * 100 );
        
        $('#progress_bar > span').css('width', percentage + '%' );
    }
    
});
