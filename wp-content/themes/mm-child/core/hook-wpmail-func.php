<?php

add_filter( 'ninja_forms_run_action_settings', function( $settings, $form_id, $action_id, $form_settings ) {
    if( 'email' == $settings[ 'type' ] ) {
        
        $email_address = $settings[ 'from_address' ];
        $form_name = $settings[ 'from_name' ];
        if (strpos(strtolower($email_address), 'yahoo.com') !== false || strpos(strtolower($email_address), 'aol.com') !== false || strpos(strtolower($email_address), 'verizon.net') !== false) {
            $settings[ 'from_name' ] = 'Hawaii Tour Packages and Activities';
            $settings[ 'from_address' ] = 'info@hawaiitours.com';
            $settings[ 'reply_to' ] = $email_address;
        }
    }     
    return $settings;
}, 10, 4 );

