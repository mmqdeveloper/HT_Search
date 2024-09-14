<?php
/**
 * Core - Config
 * 
 */

namespace MauiMarketing\MMTF\Core;

use MauiMarketing\MMTF\Product\Availability;
use MauiMarketing\MMTF\Logs;

/**
 * Initial setup from a config .ini file
 * 
 * The idea behind this singleton class is to read the configuration from an .ini file,
 * instead of creating additional database queries for every single bit of information,
 * like blog name, tagline, logo image, primary and secondary color etc.
 * 
 * The initial configuration file `mmtf_setup.ini` should be placed in the root folder of the WordPress installation (next to _wp-config.php_)
 */
class Config{
    
    /**
     * The static instance will be saved here
     * 
     * @var Config
     */
    private static $instance = null;
    
    /**
     * This will hold the defaults
     * 
     * @var array
     */
    private $defaults = [];
    
    /**
     * This will hold the configuration details
     * 
     * @var null|array  Null until the .ini file is read
     */
    private $config = null;
    
    /**
     * This will hold the global availability details
     * 
     * @var null|array  Null until the global availability is read
     */
    private $global_availability = null;
    
    /**
     * Main constructor
     * 
     * Gets the configuration and merges it with the defaults
     * 
     * @return   void     Use get_config() instead
     */
    private function __construct(){
        
        $this->read_ini_file();
        
        // DEFAULTS The defaults for the theme setup are defined here
        
        $this->defaults = [
        
            // colors
            "primary_color"         => '#ff9903',
            
            // location
            "search_page_slug"      => 'search',
            "group_offers_link"     => '/group-tour/',
            
            "group_size_for_offer"  => 12,
            
            // search results
            "products_per_page"     => 12,
            
            // exclude product categories
            "exclude_categories"    => [],
            
            // exclude product tags
            "exclude_tags"          => [],
            
            // exclude certificates
            "exclude_certs"         => [],
            
            // maximum filtering price
            "max_price"             => 6000,

            // max item category filter
            "limit_category_filter" => 10,
            
        ];
        
        $this->config = wp_parse_args( $this->config, $this->defaults );
        
        if( ! is_array( $this->config["exclude_categories"] ) ){
            
            $this->config["exclude_categories"] = explode( ",", $this->config["exclude_categories"] );
        }
        if( ! is_array( $this->config["exclude_tags"] ) ){
            
            $this->config["exclude_tags"] = explode( ",", $this->config["exclude_tags"] );
        }
        if( ! is_array( $this->config["exclude_certs"] ) ){
            
            $this->config["exclude_certs"] = explode( ",", $this->config["exclude_certs"] );
        }
    }
    
    /**
     * Reads the ini file
     * 
     * Gets the config from the .ini file (if it exists)
     * 
     * @see      https://www.php.net/manual/en/function.parse-ini-file.php PHP Manual: parse_ini_file()
     * 
     * @return   void   Found values are saved in the $config property
     */
    private function read_ini_file(){
        
        $ini_file = ABSPATH . 'mmtf_setup.ini';
        
        if( ! file_exists( $ini_file ) ){
            
            $this->config = array();
            
            return;
        }
        
        $config = parse_ini_file( $ini_file );
        
        $this->config = is_array( $config ) ? $config : array();
        
    }
    
    public function update_ini( $key, $value ){
        
        if( ! in_array( $key, array_keys( $this->config ) ) ){
            
            return false;
        }
        
        $this->config[ $key ] = $value;
        
        if( is_array( $this->config["exclude_categories"] ) ){
            
            $this->config["exclude_categories"] = array_filter( $this->config["exclude_categories"] );
            $this->config["exclude_categories"] = implode( ",", $this->config["exclude_categories"] );
        }
        
        if( is_array( $this->config["exclude_tags"] ) ){
            
            $this->config["exclude_tags"] = array_filter( $this->config["exclude_tags"] );
            $this->config["exclude_tags"] = implode( ",", $this->config["exclude_tags"] );
        }
        
        if( is_array( $this->config["exclude_certs"] ) ){
            
            $this->config["exclude_certs"] = array_filter( $this->config["exclude_certs"] );
            $this->config["exclude_certs"] = implode( ",", $this->config["exclude_certs"] );
        }
        
        $this->save_ini_file();
    }
    
    private function save_ini_file(){
        
        Logs\debug_log( $this->config, "config.save_ini_file-this->config" );
        
        $res = array();
        
        foreach( $this->config as $key => $val ){
            
            if( empty( $val ) ){
                continue;
            }
            
            if( is_array( $val ) ){
                
                $res[] = "[$key]";
                
                foreach( $val as $skey => $sval ){
                    
                    $res[] = "$skey = " . ( is_numeric( $sval ) ? $sval : '"' . $sval . '"' );
                }
                
            } else {
                
                $res[] = "$key = " . ( is_numeric( $val ) ? $val : '"' . $val . '"' );
            }
        }
        
        $content = implode( PHP_EOL, $res );
        
        // Logs\debug_log( $content, "config.save_ini_file-content" );
        
        $ini_file = ABSPATH . 'mmtf_setup.ini';
        
        $this->safe_file_write( $ini_file, $content );
    }
    
    private function safe_file_write( $file_path, $string ){
        
        if( $fp = fopen( $file_path, 'w' ) ){
            
            $start_time = microtime( true );
            
            do{
                $can_write = flock( $fp, LOCK_EX );
                
                // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
                if( ! $can_write ){
                    
                    usleep( round( rand( 0, 100 ) * 1000 ) );
                }
                
            } while( ! $can_write && ( microtime( true ) - $start_time ) < 5 );

            // file was locked so now we can store information
            if( $can_write ){
                
                fwrite( $fp, $string );
                flock( $fp, LOCK_UN );
            }
            
            fclose( $fp );
        }

    }
    
    /**
     * Returns the singleton instance
     * 
     * @return   Config
     */
    public static function get_instance(){
        
        if( is_null( self::$instance ) ){
            
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    /**
     * Returns the configuration array
     * 
     * @return   array     The configuration
     */
    public function get_config(){
        
        // return $this->config;
        return $this->defaults;
    }
    
    /**
     * Returns the global availability array
     * 
     * @return   array     The configuration
     */
    public function get_global_availability(){
        
        if( $this->global_availability === null ){
            
            $global_availability = get_option('wc_global_booking_availability');
            
            if( empty( $global_availability ) ){
                
                $this->global_availability = [];
                
                return $this->global_availability;
            }
            
            $global_availability = Availability\_sort_by_priority( $global_availability );
            
            
            // convert comma separated lists to arrays
            foreach( $global_availability as $index => $range ){
                
                $keys = [
                    "category",
                    "excategory",
                    "tag",
                    "extag",
                    "product",
                    "exproduct",
                ];
                
                foreach( $keys as $key ){
                    
                    if( empty( $range[ $key ] ) ){
                        
                        $global_availability[ $index ][ $key ] = [];
                        
                        continue;
                    }
                    
                    $global_availability[ $index ][ $key ] = explode( ",", $range[ $key ] );
                }
                
            }
            
            
            // Logs\debug_log( $global_availability, "config.get_global_availability-global_availability" );
            
            $this->global_availability = $global_availability;
            
        }
        
        return $this->global_availability;
    }
    
}
