<?php
/**
 * Templates functions
 * 
 */

namespace MauiMarketing\MMTF\Templates;

use MauiMarketing\MMTF\Core;
use MauiMarketing\MMTF\Logs;

function get_product_short_description( $product, $permalink = "" ){
    
    if( ! $permalink ){
        $permalink = get_permalink( (int) $product->ID );
    }
    
    //$description = get_post_meta( $product->ID, 'description_inner', true );
    //$excerpt     = ! $description ? get_the_excerpt( $product->ID ) : stripslashes( wpautop( trim( html_entity_decode( $description) ) ) );
    $excerpt     = get_the_excerpt( $product->ID );
    $desc = [
        "short"     => "",
        "long"      => "",
        "features"  => "",
    ];
    
    if( empty( $excerpt ) ){
        
        return $desc;
    }
    
    $av_hr_start = strpos( $excerpt, "[av_hr" );
    
    if( $av_hr_start !== false ){
        
        $av_hr_end = strpos( $excerpt, "]", $av_hr_start );
        
        if( $av_hr_end !== false ){
            
            $av_hr = substr( $excerpt, $av_hr_start, ( $av_hr_end - $av_hr_start ) + 1 );
            
            $excerpt = str_replace( $av_hr, "", $excerpt );
            
            // Logs\debug_log( $av_hr, "mmtf-product.php-av_hr" );
        }
    }
    
    $excerpt = apply_filters( 'the_content', $excerpt );
    
    $pos_array = array();
    
    if( strlen( strstr( $excerpt, '</p>' ) ) > 0 ){
        $pos_array[] = strpos( $excerpt, '</p>' );
    }
    if( strlen( strstr( $excerpt, '<br' ) ) > 0 ){
        $pos_array[] = strpos( $excerpt, '<br' );
    }
    if( strlen( strstr( $excerpt, 'av_hr' ) ) > 0 ){
        $pos_array[] = strpos( $excerpt, '[av_hr' );
    }
    if( empty( $pos_array ) ){
        if( strlen( strstr( $excerpt, '<ul' ) ) > 0 ){
            $pos_array[] = strpos( $excerpt, '<ul' );
        }
    }
    
    if( ! empty( $pos_array ) ){
        
        $pos                = min( $pos_array );
        $description        = substr( $excerpt, 0, $pos );
        $desc["features"]   = substr( $excerpt, $pos );
        
        if( wp_doing_ajax() ){
            
            $desc["features"]   = str_replace( "avia-icon-animate", "", $desc["features"] );
        }
        
        
        $desc["short"]  = wordwrap( $description, 100 );
        $desc["short"]  = explode( "\n", $desc["short"] );
        $desc["short"]  = $desc["short"][0];
        
        if( strlen( $desc["short"] ) < strlen( $description ) ){
            
            $desc["short"] .= ' ...' . ' <a href="' . $permalink . '"><span class="description_more">More</span></a>';
        }
        
        
        $desc["long"]  = wordwrap( $description, 200 );
        $desc["long"]  = explode( "\n", $desc["long"] );
        $desc["long"]  = $desc["long"][0];
        
        if( strlen( $desc["long"] ) < strlen( $description ) ){
            
            $desc["long"] .= ' ...' . ' <a href="' . $permalink . '"><span class="description_more">More</span></a>';
        }
        
    }
    
    return $desc;
}

function _sanitize_explode_int_get( $string ){
    
    $results = [];
    
    if( ! empty( $_GET[ $string ] ) ){
        
        $results = explode( ",", $_GET[ $string ] );
        
        // sanitizing
        foreach( $results as $index => $result ){
            
            $results[ $index ] = (int) $result;
        }
    }
    
    return $results;
}

function _get_taxonomies_html( $taxonomy, $current_terms, $include = array()){
    
    $exclude = [];
    
    if( $taxonomy == 'product_cat' ){
        
        $config = Core\config();
        
        $exclude = $config["exclude_categories"];
        
        $term_ids = [];
        
        foreach( $current_terms as $term_slug ){
            
            $term = get_term_by( 'slug', $term_slug, 'product_cat' );
            $term_ids[] = $term->term_id;
        }
        
        $current_terms = $term_ids;
    }
    
    if( $taxonomy == 'product_tag' ){
        
        $config = Core\config();
        
        $exclude = $config["exclude_tags"];
    }
    
    if( $taxonomy == 'certificates' ){
        
        $config = Core\config();
        
        $exclude = $config["exclude_certs"];
    }
    if(!empty($include)){
    $args = [
        "echo"              => false,
        "current_category"  => $current_terms,
        "taxonomy"          => $taxonomy,
        "title_li"          => "",
        "exclude"           => $exclude,
            'include' => $include
    ];
    }else{
        $args = [
            "echo"              => false,
            "current_category"  => $current_terms,
            "taxonomy"          => $taxonomy,
            "title_li"          => "",
            "exclude"           => $exclude,
        ];
    }
    
    if( $taxonomy != 'product_cat' ){
        
        // $args["use_desc_for_title "] = 1;
        // $args["title_li "] = "";
        $args["orderby"] = "count";
        $args["order"]   = "desc";
    }
    
    return wp_list_categories( $args );
    
}

function get_star_rating_html( $rating ){
    
    // $full  = '<span class="dashicons dashicons-star-filled"></span>';
    // $semi  = '<span class="dashicons dashicons-star-half"></span>';
    // $empty = '<span class="dashicons dashicons-star-empty"></span>';
    
    // $html = str_repeat( $full, floor( $rating ) );
    
    // if( $rating > floor( $rating ) ){
        
    //     $html .= $semi;
    // }
    
    // $html .= str_repeat( $empty, 5 - ceil( $rating ) );
    
    $html = '<span class="dashicons dashicons-star-filled"></span>'.number_format($rating, 1);

    return $html;
}
