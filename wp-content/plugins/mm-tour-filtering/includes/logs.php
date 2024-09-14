<?php
/**
 * Logging functions
 * 
 */

namespace MauiMarketing\MMTF\Logs;

/**
 * Main logging function
 * 
 * 
 * @param    mixed    $log       Anything you want to log
 * @param    string   $text      Any descriptive text that helps you find your log
 * @param    bool     $delete    Append or overwrite the file
 * 
 * @return   void
 */
function debug_log ( $log, $text = "debug_log: ", $delete = false )  {
    
    if( $delete ){
        unlink( WP_CONTENT_DIR . '/log.log' );
    }
    
	if ( is_array( $log ) || is_object( $log ) ) {
		error_log( $text . PHP_EOL . print_r( $log, true ) . PHP_EOL, 3, WP_CONTENT_DIR . '/log.log' );
	} else {
		error_log( $text . PHP_EOL . $log . PHP_EOL, 3, WP_CONTENT_DIR . '/log.log' );
	}
}
