<?php

if (!function_exists('booking_you_save_enqueue_script')) {

    function booking_you_save_enqueue_script() {
        wp_register_script('booking_you_save_js', get_stylesheet_directory_uri() . '/assets/js/booking-you-save.js', array('jquery'), null, false);
        wp_localize_script('booking_you_save_js', 'AJAX', array('url' => admin_url('admin-ajax.php')));
        wp_enqueue_script('booking_you_save_js', 9999);
    }

    add_action('init', 'booking_you_save_enqueue_script');
    add_action('wp_ajax_booking_you_save', 'mm_html_you_save');
    add_action('wp_ajax_nopriv_booking_you_save', 'mm_html_you_save');
}


/* ----- return html ------ */
if (!function_exists('mm_html_you_save')) {

    function mm_html_you_save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['date']) && !empty($_POST['month']) && !empty($_POST['year']) && !empty($_POST['id'])) {
                $date = intval($_POST['date']);
                $month = intval($_POST['month']);
                $year = intval($_POST['year']);
                $product_id = $_POST['id'];
                $id_resource = $_POST['resource'];
                $WC_Product = wc_get_product($product_id);
                if($WC_Product){
                    $costs = $WC_Product->get_costs();
                    $args_percent = $args_person_qty = $args_person = array();
                    $cost_resource = 0;
                    if (isset($_POST['person_first']) && isset($_POST['person_second']) && isset($_POST['person_third']) && isset($_POST['person_four'])) {
                        array_push($args_person_qty, $_POST['person_first'], $_POST['person_second'], $_POST['person_third'], $_POST['person_four']);
                    }
                                    $mm_custom_price = get_post_meta($product_id, 'mm_custom_price', true);
                                    $dataArray = array();
                                    $custom_price = '';
                                    if (!empty($mm_custom_price) && !empty(unserialize($mm_custom_price))) {
                                            $dataArray = unserialize($mm_custom_price);
                                    }
                    //get cost resource select
                    if (isset($id_resource) && $id_resource != 0) {
                        $resource = $WC_Product->get_resource($id_resource);
                        if ($resource->get_base_cost()) {
                            $cost_resource = $resource->get_base_cost();
                        } elseif ($resource->get_block_cost()) {
                            $cost_resource = $resource->get_block_cost();
                        }
                    }
                    //get cost person select

                    if ($WC_Product->has_person_types()) {
                        $person_types = $WC_Product->get_person_types();
                        foreach ($person_types as $person_id => $person_count) {
                            $person_type = new WC_Product_Booking_Person_Type($person_id);
                            array_push($args_person, $person_id);
                        }
                        if (sizeof($args_person) < 4) {
                            for ($i = sizeof($args_person); $i < 4; $i++) {
                                array_push($args_person, 0);
                            }
                        }
                        $data_person = array_combine($args_person, $args_person_qty);
                        if (!empty($data_person)) {
                            foreach ($data_person as $person_id_p => $person_count_p) {
                                if ($person_count_p != 0) {
                                    $person_type = new WC_Product_Booking_Person_Type($person_id_p);
                                    $person_cost = 0;
                                    if ($person_type->get_block_cost()) {
                                        $person_cost = $person_type->get_block_cost();
                                    }
                                    if ($person_type->get_cost()) {
                                        $person_cost = $person_type->get_cost();
                                    }
                                    $args_percent[$person_id_p] = $person_cost + $cost_resource;
                                                                    if (!empty($dataArray)){
                                                                            foreach ($dataArray as $key => $items) {
                                                                                    if($items['resource'] == $id_resource && $items['person'] == $person_id_p && $items['price'] != ''){
                                                                                            $args_percent[$person_id_p] = $items['price'];
                                                                                    }
                                                                            }
                                                                    }
                                }
                            }
                        }
                    }
                    $block_cost_person = $base_cost_person = $block_cost = $base_cost = 0;
                    $total_people = $_POST['person_first'] + $_POST['person_second'] + $_POST['person_third'] + $_POST['person_four'];
                    //calculator
                    foreach ($costs as $rule_key => $rule) {
                        $type = $rule[0];
                        $rules = $rule[1];
                        if (strrpos($type, 'time') === 0) {
                            if (!in_array($this->product->get_duration_unit(), array('minute', 'hour'))) {
                                continue;
                            }
                            if ('time:range' === $type) {
                                $year = date('Y', $block_start_time['timestamp']);
                                $month = date('n', $block_start_time['timestamp']);
                                $day = date('j', $block_start_time['timestamp']);

                                if (!isset($rules[$year][$month][$day])) {
                                    continue;
                                }

                                $rule_val = $rules[$year][$month][$day]['rule'];
                                $from = $rules[$year][$month][$day]['from'];
                                $to = $rules[$year][$month][$day]['to'];
                            } else {
                                if (!empty($rules['day'])) {
                                    if ($rules['day'] != $block_start_time['day_of_week']) {
                                        continue;
                                    }
                                }

                                $rule_val = $rules['rule'];
                                $from = $rules['from'];
                                $to = $rules['to'];
                            }

                            $rule_start_time_hi = date('YmdHi', strtotime(str_replace(':', '', $from), $block_start_time['timestamp']));
                            $rule_end_time_hi = date('YmdHi', strtotime(str_replace(':', '', $to), $block_start_time['timestamp']));
                            $matched = false;

                            // Reverse time rule - The end time is tomorrow e.g. 16:00 today - 12:00 tomorrow
                            if ($rule_end_time_hi <= $rule_start_time_hi) {

                                if ($block_end_time['time'] > $rule_start_time_hi) {
                                    $matched = true;
                                }
                                if ($block_start_time['time'] >= $rule_start_time_hi && $block_end_time['time'] >= $rule_end_time_hi) {
                                    $matched = true;
                                }
                                if ($block_start_time['time'] <= $rule_start_time_hi && $block_end_time['time'] <= $rule_end_time_hi) {
                                    $matched = true;
                                }
                            } // Else Normal rule.
                            else {
                                if ($block_start_time['time'] >= $rule_start_time_hi && $block_end_time['time'] <= $rule_end_time_hi) {
                                    $matched = true;
                                }
                            }
                            if ($matched) {
                                $block_cost = $this->apply_cost($block_cost, $rule_val['block'][0], $rule_val['block'][1]);
                                $base_cost = $this->apply_base_cost($base_cost, $rule_val['base'][0], $rule_val['base'][1], $rule_key);
                            }
                        } else {
                            switch ($type) {
                                case 'months' :
                                case 'weeks' :
                                case 'days' :
                                case 'custom' :
                                    if (isset($rules[$year][$month][$date])) {
                                        $percentate = intval($rules[$year][$month][$date]['percentage']);
                                        $args_resource_save = explode(',', $rules[$year][$month][$date]['id_resource']);
                                        if ($rules[$year][$month][$date]['id_resource'] != '') {
                                            if (in_array($id_resource, $args_resource_save)) {
                                                if (isset($percentate) && $percentate == 1) {
                                                    if ($rules[$year][$month][$date]['block'][1] != 0) {
                                                        $rule_block = $rules[$year][$month][$date]['block'][1] / 100;
                                                        foreach ($args_percent as $key_percent => $value_percent) {
                                                            $block_cost += $rule_block * $value_percent;
                                                        }
                                                    } elseif ($rules[$year][$month][$date]['base'][1] != 0) {
                                                        $rule_base = $rules[$year][$month][$date]['base'][1] / 100;
                                                        foreach ($args_percent as $key_percent => $value_percent) {
                                                            $base_cost += $value_percent * $data_person[$key_percent] * $rule_base;
                                                        }
                                                    }
                                                } else {
                                                    if ($rules[$year][$month][$date]['block'][1] != 0) {
                                                        $block_cost = $rules[$year][$month][$date]['block'][1];
                                                    } elseif ($rules[$year][$month][$date]['base'][1] != 0) {
                                                        $base_cost = $rules[$year][$month][$date]['base'][1] * $total_people;
                                                    }
                                                }
                                            }
                                        } else {
                                            if (isset($percentate) && $percentate == 1) {
                                                if ($rules[$year][$month][$date]['block'][1] != 0) {
                                                    $rule_block = $rules[$year][$month][$date]['block'][1] / 100;
                                                    foreach ($args_percent as $key_percent => $value_percent) {
                                                        $block_cost += $rule_block * $value_percent;
                                                    }
                                                } elseif ($rules[$year][$month][$date]['base'][1] != 0) {
                                                    $rule_base = $rules[$year][$month][$date]['base'][1] / 100;
                                                    foreach ($args_percent as $key_percent => $value_percent) {
                                                        $base_cost += $value_percent * $data_person[$key_percent] * $rule_base;
                                                    }
                                                }
                                            } else {
                                                if ($rules[$year][$month][$date]['block'][1] != 0) {
                                                    $block_cost = $rules[$year][$month][$date]['block'][1];
                                                } elseif ($rules[$year][$month][$date]['base'][1] != 0) {
                                                    $base_cost = $rules[$year][$month][$date]['base'][1] * $total_people;
                                                }
                                            }
                                        }
                                    }
                                    break;
                                case 'persons' :
                                    if ($rules['from'] <= $total_people && $rules['to'] >= $total_people) {
                                        $percentate = intval($rules['rule']['percentage']);
                                        $args_resource_save = explode(',', $rules['rule']['id_resource']);
                                        if (!empty($rules['rule']['id_resource'] != '')) {
                                            if (in_array($id_resource, $args_resource_save)) {
                                                if (isset($percentate) && $percentate == 1) {
                                                    if ($rules['rule']['block'][1] != 0) {
                                                        $rule_block_p = $rules['rule']['block'][1] / 100;
                                                        foreach ($args_percent as $key_percent => $value_percent) {
                                                            $block_cost_person += $rule_block_p * $value_percent;
                                                        }
                                                    } elseif ($rules['rule']['base'][1] != 0) {
                                                        $rule_base_p = $rules['rule']['base'][1] / 100;
                                                        foreach ($args_percent as $key_percent => $value_percent) {
                                                            $base_cost_person += $value_percent * $data_person[$key_percent] * $rule_base_p;
                                                        }
                                                    }
                                                } else {
                                                    $block_cost_person = $rules['rule']['block'][1];
                                                    $base_cost_person = $rules['rule']['base'][1] * $total_people;
                                                }
                                            }
                                        } else {
                                            if (isset($percentate) && $percentate == 1) {
                                                if ($rules['rule']['block'][1] != 0) {
                                                    $rule_block_p = $rules['rule']['block'][1] / 100;
                                                    foreach ($args_percent as $key_percent => $value_percent) {
                                                        $block_cost_person += $rule_block_p * $value_percent;
                                                    }
                                                } elseif ($rules['rule']['base'][1] != 0) {
                                                    $rule_base_p = $rules['rule']['base'][1] / 100;
                                                    foreach ($args_percent as $key_percent => $value_percent) {
                                                        $base_cost_person += $value_percent * $data_person[$key_percent] * $rule_base_p;
                                                    }
                                                }
                                            } else {
                                                $block_cost_person = $rules['rule']['block'][1];
                                                $base_cost_person = $rules['rule']['base'][1] * $total_people;
                                            }
                                        }
                                    }
                                    break;
                                case 'blocks' :
                            }
                        }
                    }
                    echo round($block_cost_person + $base_cost_person + $block_cost + $base_cost, 2);
                }
            }
        }
        die();
    }

}