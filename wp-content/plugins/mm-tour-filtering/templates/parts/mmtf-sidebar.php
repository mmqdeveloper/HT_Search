<?php

namespace MauiMarketing\MMTF\Templates\TourFiltering\Sidebar;

use MauiMarketing\MMTF\Logs;

if( ! defined('ABSPATH') ){ die(); }

?>

<div class="mmtf_widget_sidebar_wrapper">
    <div id="mmtf_sidebar_filter">
        <div class="mmtf_widget_sidebar_header">
            <div id="mmtf_close_sidebar" class="mmtf-hide-sidebar">
                <img src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/close.png'; ?>" />
            </div>
            <h5>Filters</h5>
        </div>
        <div class="mmtf_widget_sidebar_body">
            <div class="mmtf_widget">
                <div class="mmtf_widget_title">Price</div>
                <div id="mmtf_price_range" <?php echo($_GET['sa_price_max'] ? 'data-max="'.$_GET['sa_price_max'].'"' : ''); ?> <?php echo($_GET['sa_price_min'] ? 'data-min="'.$_GET['sa_price_min'].'"' : ''); ?>></div>
                <div id="mmtf_price_labels">
                    <div id="mmtf_price_label_low">
                        $<span class="selected_amount"><?php echo $price_low; ?></span>
                    </div>
                    <div id="mmtf_price_label_high">
                        $<span class="selected_amount" data-max="<?php echo esc_attr( $config["max_price"] ); ?>"><?php echo $price_high; ?></span>
                    </div>
                </div>
            </div>
            <div class="mmtf_widget">
                <div class="mmtf_widget_title all_taxonomies_title" id="mmtf_all_categories"<?php echo $categories_title_active; ?>>Duration</div>
                <div id="mmtf_duration" class="taxonomy_list"></div>
                <input type="hidden" id="mmtf_duration_min" name="sa_dur_min" value="<?php echo(!empty($_GET["sa_dur_min"]) ? $_GET["sa_dur_min"] : ""); ?>">
                <input type="hidden" id="mmtf_duration_max" name="sa_dur_max" value="<?php echo(!empty($_GET["sa_dur_max"]) ? $_GET["sa_dur_max"] : ""); ?>">
                <div id="mmtf_duration_labels">
                    <div id="mmtf_duration_label_low">
                        <span class="selected_amount"><?php echo(!empty($_GET['sa_dur_min']) ? $_GET['sa_dur_min'].'h' : '1h'); ?></span>
                    </div>
                    <div id="mmtf_duration_label_high">
                        <span class="selected_amount"><?php echo(!empty($_GET['sa_dur_max']) ? $_GET['sa_dur_max'].'h' : '24h'); ?></span>
                    </div>
                </div>
            </div>
            <div class="mmtf_widget">
                <div class="mmtf_widget_title all_taxonomies_title" id="mmtf_all_categories"<?php echo $categories_title_active; ?>>Time of Day</div>
                <div id="mmtf_time_of_day" class="taxonomy_list mmtf_filter_checkbox">
                    <label>
                        <input type="checkbox" name="time_of_day" value="6am-12pm" <?php echo($_GET["sa_time_of_day"] == "6am-12pm" ? "checked" : ""); ?> />
                        <span class="mmtf_checkbox_custom"></span>
                        6am - 12pm
                    </label>
                    <label>
                        <input type="checkbox" name="time_of_day" value="12pm-5pm" <?php echo($_GET["sa_time_of_day"] == "12pm-5pm" ? "checked" : ""); ?> />
                        <span class="mmtf_checkbox_custom"></span>
                        12pm - 5pm
                    </label>
                    <label>
                        <input type="checkbox" name="time_of_day" value="5pm-12am" <?php echo($_GET["sa_time_of_day"] == "5pm-12am" ? "checked" : ""); ?> />
                        <span class="mmtf_checkbox_custom"></span>
                        5pm - 12am
                    </label>
                    <label>
                        <input type="checkbox" name="time_of_day" value="5am-12am" <?php echo($_GET["sa_time_of_day"] == "5am-12am" ? "checked" : ""); ?> />
                        <span class="mmtf_checkbox_custom"></span>
                        5am - 12am
                    </label>
                    <label>
                        <input type="checkbox" name="time_of_day" value="12am-5am" <?php echo($_GET["sa_time_of_day"] == "12am-5am" ? "checked" : ""); ?> />
                        <span class="mmtf_checkbox_custom"></span>
                        12am - 5am
                    </label>
                </div>
            </div>
            <div class="mmtf_widget">
                <div class="mmtf_widget_title all_taxonomies_title" id="mmtf_all_categories"<?php echo $categories_title_active; ?>>Pickup</div>
                <div id="mmtf_pickup" class="taxonomy_list mmtf_filter_checkbox">
                    <label>
                        <input type="checkbox" name="sa_pickup" value="pickup semi-avail" <?php echo($_GET["sa_pickup"] == "pickup semi-avail" ? "checked" : ""); ?> />
                        <span class="mmtf_checkbox_custom"></span>
                        Pickup semi-avail
                    </label>
                    <label>
                        <input type="checkbox" name="sa_pickup" value="pickup available" <?php echo($_GET["sa_pickup"] == "pickup available" ? "checked" : ""); ?> />
                        <span class="mmtf_checkbox_custom"></span>
                        Pickup available
                    </label>
                </div>
            </div>
        </div>
        <div class="mmtf_widget_sidebar_bottom">
            <?php 
                $clear_parsed_url = parse_url($_SERVER['REQUEST_URI']);
                parse_str($clear_parsed_url['query'], $clear_params_url);
                if ($clear_params_url['cat'] != NULL) {
                    unset($clear_params_url['cat']);
                }
                if ($clear_params_url['cert'] != NULL) {
                    unset($clear_params_url['cert']);
                }
                if ($clear_params_url['min'] != NULL) {
                    unset($clear_params_url['min']);
                }
                if ($clear_params_url['max'] != NULL) {
                    unset($clear_params_url['max']);
                }
                if ($clear_params_url['dur_min'] != NULL) {
                    unset($clear_params_url['dur_min']);
                }
                if ($clear_params_url['dur_max'] != NULL) {
                    unset($clear_params_url['dur_max']);
                }
                if ($clear_params_url['dur_opt'] != NULL) {
                    unset($clear_params_url['dur_opt']);
                }
                if ($clear_params_url['pk'] != NULL) {
                    unset($clear_params_url['pk']);
                }
                
                $param_url_str = '';
                if (!empty($clear_params_url)) {
                    foreach($clear_params_url as $key => $val) {
                        $param_url_str .= '&'.$key.'='.$val;
                    }
                }
            ?>
            <!-- <a>Clear all</a> -->
            <div id="mmtf_show_result" class="mmtf-hide-sidebar">Show results</div>
        </div>
    </div>
</div>