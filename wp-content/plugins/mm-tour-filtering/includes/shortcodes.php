<?php
/**
 * Shortcode functions
 * 
 */

namespace MauiMarketing\MMTF\Shortcodes;

use MauiMarketing\MMTF\Core;
use MauiMarketing\MMTF\Logs;
use MauiMarketing\MMTF\Product\Availability;
use MauiMarketing\MMTF\Templates;
use MauiMarketing\MMTF\Filtering;



function quick_search( $atts, $content = "" ){
    static $count = 0;
    $count++;
    //check shortcode duptication
    if ($count > 1) 
        return '';

    $config = Core\config();
    
    $category__oahu       = get_term_by( 'name', 'Oahu',       'product_cat' );
    $category__maui       = get_term_by( 'name', 'Maui',       'product_cat' );
    $category__big_island = get_term_by( 'name', 'Big Island', 'product_cat' );
    $category__kauai      = get_term_by( 'name', 'Kauai',      'product_cat' );
    // Logs\debug_log( $category__kauai, "Shortcodes-quick_search-category__kauai" );
    
    $primary_color = $config["primary_color"];
    
    $today    = date("Y-m-d", time() );
    $tomorrow = date("Y-m-d", strtotime('tomorrow') );
    
    $link_icon_search = \MauiMarketing\MMTF\PLUGIN_URL. 'images/search-black.svg';
    $link_icon_date = \MauiMarketing\MMTF\PLUGIN_URL. 'images/date.svg';
    $link_icon_dropdown = \MauiMarketing\MMTF\PLUGIN_URL. 'images/icon-dropdown.svg';
    $link_icon_clear_search = \MauiMarketing\MMTF\PLUGIN_URL. 'images/clear-search.svg';

    $html = <<<HTML
<div id="mm_quick_search">
    
    <div id="mm_quick_search_keyword_wrapper">
        <img class="icon-search" src="{$link_icon_search}" alt="icon search" />
        <input type="text" id="mm_quick_search_keyword" autocomplete="off" class="mm_quick_search_input" name="keyword" placeholder="Search for a place or activity">
        <img id="mmtf_filter_clear_search" src="{$link_icon_clear_search}" />
        <div id="mm_quick_search_submit">Search</div>
    </div>
    
    <div id="mm_quick_search_datepicker_result" class="widget_hidden" data-placeholder="Add dates">
        <img class="icon-date" src="{$link_icon_date}" alt="icon date" />
        <span>Add dates</span>
        <img class="icon-dropdown" src="{$link_icon_dropdown}" alt="icon date" />
    </div>
        
    <div id="mm_quick_search_datepicker_wrapper">
        
        <div id="mmtf_datepicker_widget"></div>
        
        <div id="mm_quick_search_datepicker_controls" class="hidden">
            <div id="mm_quick_search_datepicker_reset">Reset</div>
            <div id="mm_quick_search_datepicker_apply">Apply</div>
        </div>
    </div>
    
    <input type="text" value="" class="mm_quick_search_date" name="mm_quick_search_date_start" id="mm_quick_search_date_start"/>
    <input type="text" value="" class="mm_quick_search_date" name="mm_quick_search_date_end"   id="mm_quick_search_date_end"/>
    
</div>
<style>
    :root{
        --mmtf-primary-color: $primary_color;
        --mmtf-primary-transparent: {$primary_color}60;
        --mmtf-primary-transparent-light: {$primary_color}20;
        --mmtf-primary-transparent-dark: {$primary_color}90;
    }
</style>

HTML;
    
    
    return $html;
}

add_shortcode('mm_quick_search', __NAMESPACE__ . '\\' . 'quick_search');

if (!function_exists('mm_tour_search_templates')) {

    function mm_tour_search_templates($atts) {

        $config = Core\config();
        $list_categories = array();
        $list_certificates = array();
        $list_tag = array();

        if (empty($_GET["group"])) {

            $_GET["group"] = 2;
        }

        $current_page = !empty($_GET["pp"]) ? $_GET["pp"] : 1;

        $args = [];

        if ($current_page > 1) {

            $args = [
                'paged' => 1,
                'posts_per_page' => $config["products_per_page"] * $current_page,
            ];
        }
        $posts_per_page = '';
        if(!empty($atts)){
            $tax_query = array();
            if (!empty($atts['categories'])) {
                $list_categories = explode(',', $atts['categories']);
                $tax_query[] = array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $list_categories,
                );
            }
            if (!empty($atts['mm_certificate'])) {
                $list_certificates = explode(',', $atts['mm_certificate']);
                $tax_query[] = array(
                    'taxonomy' => 'certificates',
                    'field' => 'id',
                    'terms' => $list_certificates,
                );
            }
            if (!empty($atts['mm_tag'])) {
                $list_tag = explode(',', $atts['mm_tag']);
                $tax_query[] = array(
                    'taxonomy' => 'product_tag',
                    'field' => 'id',
                    'terms' => $list_tag,
                );
            }
            if(!empty($tax_query)){
                $args['tax_query'] = $tax_query;
            }
            if (!empty($atts['items'])) {
                if($atts['items']!='-1'){
                    $args['posts_per_page'] = $atts['items'];
                    $posts_per_page = $atts['items'];
                }else{
                    $args['posts_per_page'] = 9;
                    $posts_per_page = 9;
                }
            }
        }

        $query = Filtering\get_filtered_products_query($args);

        $availability = Availability\get_filtered_products_availability(wp_list_pluck($query->posts, 'ID'));

// Logs\debug_log( $query->posts, "mmtf.php-query->posts" );


        $price_low = !empty($_GET["min"]) ? (int) $_GET["min"] : 0;
        $price_high = !empty($_GET["max"]) ? (int) $_GET["max"] : $config["max_price"];
        $price_high = $price_high > $config["max_price"] ? $config["max_price"] : $price_high;
        $price_high_style = $price_high == $config["max_price"] ? '' : ' style="display:none;"';

        $categories = !empty($_GET["cat"]) ? explode(",", $_GET["cat"]) : [];
        $certificates = Templates\_sanitize_explode_int_get("cert");
        $tags = Templates\_sanitize_explode_int_get("tag");

        $categories_title_active = empty($categories) ? ' style="font-weight: bold;"' : '';
        $certificates_title_active = empty($certificates) ? ' style="font-weight: bold;"' : '';
        $tags_title_active = empty($tags) ? ' style="font-weight: bold;"' : '';

        $categories_html = Templates\_get_taxonomies_html("product_cat", $categories, $list_categories);
        $certificates_html = Templates\_get_taxonomies_html("certificates", $certificates, $list_certificates);
        //$tags_html = Templates\_get_taxonomies_html("product_tag", $tags, $list_tag);
        $tags_html = '';

        $date_start = !empty($_GET["date_start"]) ? $_GET["date_start"] : "";
        $date_end = !empty($_GET["date_end"]) ? $_GET["date_end"] : ( $date_start ? $date_start : "" );

        $group_size = !empty($_GET["group"]) ? (int) $_GET["group"] : "";
        $group_class = $group_size && $group_size != 2 ? ' class="has_value"' : '';

        $search = !empty($_GET["sr"]) ? $_GET["sr"] : "";
        $search_class = $search ? ' class="has_value"' : '';

        $active_filters = Filtering\count_active_filters();

        $primary_color = $config["primary_color"];

        if (class_exists('WCPL_Product_Likes_Display')) {

            $likes = new \WCPL_Product_Likes_Display();
        }
        $post_count = $query->post_count;
        $found_posts = $query->found_posts;
        $output = '';
        ob_start();
        ?>

        <style>
            :root{
                --mmtf-primary-color: <?php echo $primary_color; ?>;
                --mmtf-primary-transparent: <?php echo $primary_color; ?>60;
                --mmtf-primary-transparent-light: <?php echo $primary_color; ?>20;
                --mmtf-primary-transparent-dark: <?php echo $primary_color; ?>90;
            }
        </style>
        <script>
            var mm_price_range = {
                low: <?php echo $price_low; ?>,
                high: <?php echo $price_high; ?>,
                max: <?php echo $config["max_price"]; ?>
            };
        </script>
        <div class='mmtf_shortcode'>

            <div id='mmtf'>

                <div id="mmtf_sidebar">

                    <?php include( \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/parts/mmtf-sidebar.php' ); ?>

                </div>

                <div id="mmtf_sidebar_toggler" data-alter="Hide filters">Show filters</div>

                <div id="mmtf_results">

                    <?php if ($group_size >= $config["group_size_for_offer"]) { ?>
                        <div id="mmtf_big_group">
                            It seems that you are travelling with a lot of friends which is awesome! You should consider our special offers for bigger groups
                            <a id="mmtf_big_group_link" href="<?php echo esc_attr(home_url($config["group_offers_link"])); ?>">Group Tours</a>
                        </div>
                    <?php } ?>

                    <div id="mmtf_results_header">

                        <b id="mmtf_results_count">Displaying <span id="mmtf_results_displayed"><?php echo $post_count; ?></span> out of <span id="mmtf_results_total"><?php echo $found_posts; ?></span> results</b>

                        <?php if ($active_filters) { ?>
                            <div id="mmtf_results_fiters_state">
                                Reset active filters (<?php echo $active_filters; ?>)
                            </div>
                        <?php } ?>

                        <div id="mmtf_search_wrapper"<?php echo $search_class; ?>>
                            <input id="mmtf_search" name="mmtf_search" placeholder="Search" value="<?php echo esc_attr($search); ?>" data-submitted="<?php echo esc_attr($search); ?>"/>
                            <div class="the_x">X</div>
                            <div class="the_apply">Apply</div>
                        </div>

                    </div>

                    <?php if ($query->posts) { ?>

                        <ul id="mmtf_products_results">

                            <?php foreach ($query->posts as $product) { ?>

                                <?php include( \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/parts/mmtf-product.php' ); ?>

                            <?php } ?>

                        </ul>

                    <?php } else{ ?>
                        <div class="result_not_found">
                            <?php
                        if(!empty($search)){ ?>
                            Sorry, we couldn't find any experiences or activities that match "<strong><?php echo $search;?></strong>"
                        <?php }else{ ?>
                            Sorry, we couldn't find any experiences or activities
                        <?php } ?>
                        </div>
                    <?php }?>

                    <?php if ($post_count < $found_posts) { ?>

                        <div id="mmtf_load_more" data-posts_per_page="<?php echo esc_attr($posts_per_page); ?>" data-current_page="<?php echo esc_attr($current_page); ?>">Show more</div>

                    <?php } ?>

                    <div id="mmtf_loading_more">Please wait, loading...</div>
                </div>

            </div>

        </div><!-- close default .container_wrap element -->
        <?php
        $output .= ob_get_clean();
        return $output;
    }

}

add_shortcode('mm_tour_search', __NAMESPACE__ . '\\' . 'mm_tour_search_func');
if (!function_exists('mm_tour_search_func')) {

    function mm_tour_search_func() {
        $out = mm_tour_search_templates();
        return $out;
    }

}

// ===================== Search Form Header ===================== //
if (!function_exists('mm_shotcode_template_search_mobile_header')) {
    function mm_shotcode_template_search_mobile_header () {
        ob_start();
        function mmtf_filter_format_date_show ($start, $end) {
            $start_explode = explode("-", $start); 
            $end_explode = explode("-", $end);
            $result_date = '';
    
            $start_explode = [
                'y' => $start_explode[0],
                'm' => $start_explode[1],
                'd' => $start_explode[2],
            ];
    
            $end_explode = [
                'y' => $end_explode[0],
                'm' => $end_explode[1],
                'd' => $end_explode[2],
            ];
    
            $format_month_start = strftime("%B", mktime(0, 0, 0, intval($start_explode['m']), 1));
            $format_month_end = strftime("%B", mktime(0, 0, 0, intval($end_explode['m']), 1));
    
            if ($start_explode['d'] != $end_explode['d'] && $format_month_start == $format_month_end && $start_explode['y'] == $end_explode['y']) {
                $result_date = $format_month_start.' '.$start_explode['d'].' - '.$end_explode['d'];
            } else if ($start_explode['d'] != $end_explode['d'] && $format_month_start != $format_month_end && $start_explode['y'] == $end_explode['y']) {
                $result_date = $format_month_start.' '.$start_explode['d'].' - '.$format_month_end.' '.$end_explode['d'];
            } else if ($format_month_start == $format_month_end && $start_explode['d'] == $end_explode['d'] && $start_explode['y'] == $end_explode['y']) {
                $result_date = $format_month_start.' '.$start_explode['d'];
            }
    
            if ($start != null && $end != null) {
                return $result_date;
            } else {
                return 'Add Date';
            }
        }
    
        $option_island = ['oahu', 'maui', 'big-island', 'kauai'];
        $location_selected = explode(",", $_GET['island']);
        foreach($location_selected as $key => $location) {
            if (!in_array($location, $option_island)) {
                unset($location_selected[$key]);
            }
        }
        $location_selected = implode(', ', $location_selected);
        $location_selected = str_replace("oahu", "Oahu", $location_selected);
        $location_selected = str_replace("maui", "Maui", $location_selected);
        $location_selected = str_replace("big-island", "Big Island", $location_selected);
        $location_selected = str_replace("kauai", "Kauai", $location_selected);
    
        parse_str($_SERVER['QUERY_STRING'], $AllParams);

        ?>
            <div id="mm-search-bar-mobile-wrapper" class="not-active">
                <div class="mmtf_filter_top_mobile" id="btn_open_filter_top_mobile">
                    <div class="mmtf_filter_top_btn_search">
                        <img alt="Icon loupe search" src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/loupe-search-2.png'; ?>" />
                    </div>
                    <div class="mmtf_filter_top_mobile_info">
                        <span>Search...</span>
                    </div>
                </div>
                <div id="popup-search-mobile-in-header">
                    <div class="mmtf_filter_top_header">
                        <p>Change your search</p>
                        <button id="btn_close_popup_search_mobile"><img alt="Icon close search" src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/close.png' ?>" /></button>
                    </div>
                    <form method="GET" id="popup_search_form_mobile">
                        <div class="mmtf_filter_option_wrapper">
                            <div class="mmtf_filter_option option_search">
                                <div class="mmtf_filter_option_search_box">
                                    <img alt="Icon search black" src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/search-black.svg' ?>" class="show_on_mobile" />
                                    <div class="mmtf_filter_search_wrapper">
                                        <input id="mmtf_filter_search" autocomplete="off" name="mmtf_search" placeholder="Search for a place or activity" value="<?php echo($_GET['keyword'] != null ? $_GET['keyword'] : ''); ?>" />
                                        <img alt="Icon clear search" id="mmtf_filter_clear_search" src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/clear-search.svg' ?>" />
                                    </div>
                                </div>
                                <div id="mmtf_filter_option_search_autocomplate"></div>
                            </div>
                            <div class="mmtf_filter_option datepicker_mobile">
                                <div class="mmtf_filter_option_datepicker">
                                    <div id="mm_quick_search_datepicker_result_header" class="widget_hidden">
                                        <img alt="icon date" src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/date.svg' ?>" class="show_on_mobile" />
                                        <label><?php echo(mmtf_filter_format_date_show($_GET['sa_date_start'], $_GET['sa_data_end'])); ?></label>
                                    </div>
                                    <div id="mm_quick_search_datepicker_wrapper_header" style="display: none;">
                                        <div class="mm_quick_search_datepicker_top">
                                            <span>Choose dates</span>
                                            <div id="mm_quick_search_datepicker_close_header"></div>
                                        </div>
                                        <div id="mmtf_datepicker_widget_header"></div>
                                        <div id="mm_quick_search_datepicker_controls_header" class="hidden">
                                            <div id="mm_quick_search_datepicker_reset_header">Reset</div>
                                            <div id="mm_quick_search_datepicker_apply_header">Apply</div>
                                        </div>
                                    </div>
                                    <input type="text" value="<?php echo($_GET['sa_date_start'] != null ? $_GET['sa_date_start'] : ''); ?>" class="mm_quick_search_date" name="mm_quick_search_date_start" id="mm_quick_search_date_start_header"/>
                                    <input type="text" value="<?php echo($_GET['sa_data_end'] != null ? $_GET['sa_data_end'] : ''); ?>" class="mm_quick_search_date" name="mm_quick_search_date_end"   id="mm_quick_search_date_end_header"/>
                                </div>
                            </div>
                        </div>
                        <div id="btn_search_popup_mobile">
                            <button type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div id="popup-search-mobile-overlay"></div>
            </div>
        <?php
        $result = ob_get_clean();
        return $result;
    }
    add_shortcode('mm_template_search_mobile_header1', __NAMESPACE__ . '\\' .'mm_shotcode_template_search_mobile_header');
}