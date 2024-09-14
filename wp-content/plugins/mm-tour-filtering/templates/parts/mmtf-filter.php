<?php

namespace MauiMarketing\MMTF\Templates\TourFiltering\Filter;

use MauiMarketing\MMTF\Logs;

if( ! defined('ABSPATH') ){ die(); }

?>

<?php
    function mmtf_filter_format_date_show ($date) {
        $dateObj = new \DateTime($date);
        $formattedDate = $dateObj->format('M d');
        return $formattedDate;
    }
    $date_string = 'Add dates';
    if (!empty($_GET['sa_date_start'])) {
        $date_string = mmtf_filter_format_date_show($_GET['sa_date_start']);
    }
    if (!empty($_GET['sa_data_end']) && ($_GET['sa_date_start'] != $_GET['sa_data_end'])) {
        $date_string .= ' - '.mmtf_filter_format_date_show($_GET['sa_data_end']);
    }
?>

<div id="mmtf_filter">
    <div class="mmtf_filter_top">
        <div id="mmtf_filter_top_form" class="container">
            <div class="mmtf_filter_option_wrapper">
                <div class="mmtf_filter_option key-search">
                    <img class="icon-search" src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/search-black.svg' ?>" alt="icon search" />
                    <div class="mmtf_filter_search_wrapper">
                        <input id="mmtf_filter_search_desktop" autocomplete="off" name="mmtf_search" autofocus placeholder="Search for a place or activity" value="<?php echo($_GET['keyword'] != null ? $_GET['keyword'] : ''); ?>" />
                        <img id="mmtf_filter_clear_search" src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/clear-search.svg' ?>" />
                    </div>
                    <div class="mmtf_filter_top_btn_search" id="mmtf_filter_top_btn_search">Search</div>
                </div>
                <div class="mmtf_filter_option datepicker_desktop">
                    <div id="mm_quick_search_datepicker_result" class="widget_hidden">
                        <img class="icon-date" src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/date.svg' ?>" alt="icon date" />
                        <b><?php echo $date_string; ?></b>
                        <img class="icon-dropdown" src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/icon-dropdown.svg' ?>" alt="icon date" />
                    </div>
                    <div id="mm_quick_search_datepicker_wrapper" style="display: none;">
                        <div id="mmtf_datepicker_widget"></div>
                        <div id="mm_quick_search_datepicker_controls" class="hidden">
                            <div id="mm_quick_search_datepicker_reset">Reset</div>
                            <div id="mm_quick_search_datepicker_apply">Apply</div>
                        </div>
                    </div>
                    <input type="text" value="<?php echo($_GET['sa_date_start'] != null ? $_GET['sa_date_start'] : ''); ?>" class="mm_quick_search_date" name="mm_quick_search_date_start" id="mm_quick_search_date_start"/>
                    <input type="text" value="<?php echo($_GET['sa_data_end'] != null ? $_GET['sa_data_end'] : ''); ?>" class="mm_quick_search_date" name="mm_quick_search_date_end"   id="mm_quick_search_date_end"/>
                </div>
            </div>
            <div class="mmtf_filter_keyword_search" style="display: none;"><?php echo $_GET['keyword'] ? '"'.$_GET['keyword'].'"' : ''; ?></div>
        </div>
        <!-- <span class="av-seperator-icon" aria-hidden="true" data-av_icon="\ue39a" data-av_iconfont="hawaii-tours-icon-fonts"></span> -->
    </div>
</div>


<div id="mmtf_filter_loading" style="display: none;">
    <div id="mmtf_filter_loading_list">
        <?php 
            $count_item = 8;
            for($i = 0; $i < $count_item; $i++) {
                ?>
                    <div class="loading-container">
                        <div class="loading">
                            <div class="shape1"></div>
                            <div class="shape2"></div>
                            <div class="shape6"></div>
                            <div class="shape3"></div>
                            <div class="shape4"></div>
                            <div class="shape5"></div>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
</div>

