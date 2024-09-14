<?php

/**
 * @package    Internals
 * @since      1.8.0
 * @version    1.8.0
 */
// Avoid direct calls to this file.
/*if (!class_exists('WPSEO_Video_Sitemap')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
*/
/**
 * ****************************************************************
 * Add support for WP Core video functionality
 *
 * @see      https://codex.wordpress.org/Video_Shortcode
 * @see      https://codex.wordpress.org/Embed_Shortcode
 *
 * {@internal Last update: August 2014 based upon v 3.9.2.}}
 */
//if ( ! class_exists( 'WPSEO_Video_Support_Core' ) ) {

/**
 * Class WPSEO_Video_Support_Core
 */
if(class_exists('WPSEO_Video_Sitemap')){
    class WPSEO_Video_Support_Core extends WPSEO_Video_Supported_Plugin {

        /**
         * Regular expression to use to find the video file.
         *
         * {@internal Set here as other classes extend on this one using a slightly different regex.}}
         *
         * @var string
         */
        protected $att_regex = '`(?:src|mp4|m4v|webm|ogv|wmv|flv)=([\'"])?([^\'"\s]+)[\1\s]?`';

        /**
         * Conditionally add features to analyse for video content
         */
        public function __construct() {
            $this->shortcodes = array(
                'embed',
                'av_video_text',
                'av_video'
            );

            $this->shortcodes[] = 'video'; // WP 3.6+.
            // Handler name => VideoSEO service name.
            $this->video_autoembeds = array(
                'googlevideo' => 'googlevideo',
                'video' => '',
            );

            // OEmbed url (well, without the protocol or {format} tags) as specified in plugin => VideoSEO service name.
            $this->video_oembeds = array(
                '//blip.tv/oembed/' => 'blip',
                '//www.dailymotion.com/services/oembed' => 'dailymotion',
                '//www.flickr.com/services/oembed/' => 'flickr',
                '//www.funnyordie.com/oembed' => 'funnyordie',
                '//www.hulu.com/api/oembed' => 'hulu',
                '//revision3.com/api/oembed/' => 'revision3',
                '//vimeo.com/api/oembed' => 'vimeo',
                '//wordpress.tv/oembed/' => 'wordpresstv',
                '//www.youtube.com/oembed' => 'youtube',
                '//animoto.com/oembeds/create' => 'animoto',
                '//www.collegehumor.com/oembed' => 'collegehumor',
                '//www.ted.com/talks/oembed' => 'ted',
            );
        }

        /**
         * Analyse a video shortcode as used in WP core for usable video information
         *
         * @param  string $full_shortcode Full shortcode as found in the post content.
         * @param  string $sc             Shortcode found.
         * @param  array  $atts           Shortcode attributes - already decoded if needed.
         * @param  string $content        The shortcode content, i.e. the bit between [sc]content[/sc].
         *
         * @return array   An array with the usable information found or else an empty array
         */
        public function get_info_from_shortcode($full_shortcode, $sc, $atts = array(), $content = '') {
            if ($sc == 'av_video_text' || $sc == 'av_video') {
                $sc = 'video';
            }
            $method = 'get_info_from_shortcode_' . $sc;

            return $this->$method($full_shortcode, $sc, $atts, $content);
        }

        /**
         * Analyse the video shortcode as used in WP core for usable video information
         *
         * @param  string $full_shortcode Full shortcode as found in the post content.
         * @param  string $sc             Shortcode found.
         * @param  array  $atts           Shortcode attributes - already decoded if needed.
         * @param  string $content        The shortcode content, i.e. the bit between [sc]content[/sc].
         *
         * @return array   An array with the usable information found or else an empty array
         */
        public function get_info_from_shortcode_video($full_shortcode, $sc, $atts = array(), $content = '') {
            $vid = array();

            if (preg_match($this->att_regex, $full_shortcode, $match)) {
                $vid['type'] = 'mediaelement-js';
                $vid['url'] = $match[2];
                $vid['maybe_local'] = true;

                // If a poster image was specified, use that, otherwise, try and find a suitable .jpg.
                if (isset($atts['poster']) && is_string($atts['poster']) && $atts['poster'] !== '') {
                    if (WPSEO_Video_Wrappers::yoast_wpseo_video_is_url_relative($atts['poster']) === true) {
                        $info = WPSEO_Video_Analyse_Post::wp_parse_url(get_site_url());
                        // @todo should we surround this with a file_exists check?
                        $vid['thumbnail_loc'] = $info['scheme'] . '://' . $info['host'] . $atts['poster'];
                    } else {
                        $vid['thumbnail_loc'] = $atts['poster'];
                    }
                }

                $vid = $this->maybe_get_dimensions($vid, $atts);
            }

            return $vid;
        }

        /**
         * Analyse the embed shortcode as used in WP core for usable video information
         *
         * @param  string $full_shortcode Full shortcode as found in the post content.
         * @param  string $sc             Shortcode found.
         * @param  array  $atts           Shortcode attributes - already decoded if needed.
         * @param  string $content        The shortcode content, i.e. the bit between [sc]content[/sc].
         *
         * @return array   An array with the usable information found or else an empty array
         */
        public function get_info_from_shortcode_embed($full_shortcode, $sc, $atts = array(), $content = '') {
            $vid = array();

            if (!empty($content) && ( strpos($content, 'http') === 0 || strpos($content, '//') === 0 )) {
                $vid['url'] = $content;
            }

            if ($vid !== array()) {
                $vid = $this->maybe_get_dimensions($vid, $atts);
            }

            return $vid;
        }

    }
}
/* End of class */

//} /* End of class-exists wrapper */

add_filter( 'wpseo_enhanced_slack_data', function( $data, $presentation ) {
    $object  = $presentation->model;
    $product = \wc_get_product( $object->object_id );

    if ( $product ) {
        $data         = [];
        if(class_exists('WPSEO_WooCommerce_Utils')){
            $product_type = WPSEO_WooCommerce_Utils::get_product_type( $product );
            $show_price = apply_filters( 'Yoast\WP\Woocommerce\og_price', true ) && ! ( $product_type === 'variable' || $product_type === 'grouped' );

            $availability = __( 'Out of stock', 'yoast-woo-seo' );

            if ( $product->is_in_stock() ) {
                    $availability = __( 'In stock', 'yoast-woo-seo' );
            }

            if ( $product->is_on_backorder() ) {
                    $availability = __( 'On backorder', 'yoast-woo-seo' );
            }

            if ( $show_price ) {
                $get_price = $product->get_price_html();
                if(strpos($get_price, '</del><ins>') !== false){
                    $get_price = "From: ".substr($get_price,0,strpos($get_price, '</del><ins>'));
                }
                $price = \wp_strip_all_tags( $get_price );
                $data[ __( 'Price', 'yoast-woo-seo' ) ] = $price;
            }
            $data[ __( 'Availability', 'yoast-woo-seo' ) ] = $availability;
        }
    }
    return $data;
}, 20, 2 );