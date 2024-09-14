<?php

// Tour Type Fillter
add_action('restrict_manage_posts', 'mm_filter_resource_tour_type');
if( !function_exists('mm_filter_resource_tour_type') ){
    function mm_filter_resource_tour_type(){
        global $typenow;
        if($typenow == 'bookable_resource'){
            $Types = array(
                'Not-Set' => 'Not Set',
                'Self-Guided' => 'Seft-Guided',
                'Guided' => 'Guided',
            );
            $currentstatus = $_GET["tour_type_status"];
            echo "<select id='tour_type_status' name='tour_type_status'>";
            echo "<option value =''>All Tour Type</option>";
            foreach ($Types as $key => $Type){
                if ( isset($currentstatus) && $currentstatus === $key ){
                    $selected = 'selected';
                }else{
                    $selected= '';
                }
                echo "<option value='".$key."' ".$selected." >Tour Type: ".$Type."</option>";
            }
            echo "</select>";
        }
    }
}
if( isset( $_GET["tour_type_status"]) && $_GET["tour_type_status"] !== ''  ){
    add_filter('parse_query', 'mm_filter_resource_tour_type_status_query');
}
if( !function_exists( 'mm_filter_resource_tour_type_status_query' ) ){
    function mm_filter_resource_tour_type_status_query($query){
        global $pagenow;
        global $typenow;
        if( $pagenow == "edit.php" && $typenow == "bookable_resource" ){
            $qv = &$query->query_vars;
            
            if( isset( $_GET["tour_type_status"] ) && !empty($_GET["tour_type_status"])){
                if ($_GET["tour_type_status"] == 'Self-Guided') {
                    $qv['meta_query'][] = array(
                        'key' => 'resource_tour_type',
                        'compare' => '=',
                        'value' => 'Self-Guided',
                    );
                } elseif ($_GET["tour_type_status"] == 'Guided') {
                    $qv['meta_query'][] = array(
                        'key' => 'resource_tour_type',
                        'compare' => '=',
                        'value' => 'Guided',
                    );
                } elseif ($_GET["tour_type_status"] == 'Not-Set') {
                    $qv['meta_query'][] = array(
                        'relation' => 'OR',
                        array(
                            'key' => 'resource_tour_type',
                            'compare' => 'NOT EXISTS',
                        ),
                        array(
                            'key' => 'resource_tour_type',
                            'compare' => 'NOT IN',
                            'value' => array('Guided', 'Self-Guided'),
                        )
                    );
                }
            }

        }
    }
}
// End

// add filter faq in admin
add_action('restrict_manage_posts', 'mm_filter_mmfaq');
if( !function_exists('mm_filter_mmfaq') ){
	function mm_filter_mmfaq() {
		global $wpdb;
		global $typenow;
		if( $typenow == 'mmfaq' ){
			$arr_faq = $wpdb->get_results("SELECT posts.post_title,posts.ID FROM wp_posts posts INNER JOIN wp_postmeta p_meta  ON posts.ID = p_meta.post_id WHERE p_meta.meta_key = 'mmfaqtags_id' AND posts.post_type IN ('product','page') AND posts.post_status = 'publish' ORDER BY posts.post_title",ARRAY_A);
			$currentFaq = $_GET["selected_faq"];

			echo "<select id='current-faq' name='selected_faq'>";
			echo "<option value =''>All post,page</option>";
			if( !empty($arr_faq) ){
				foreach ($arr_faq as $faq){
					if ( isset($currentFaq) && $currentFaq === $faq['ID']){
						$selected = 'selected';
					}else{
						$selected= '';
					}
					echo "<option value='".$faq['ID']."' ".$selected." >".$faq['post_title']."</option>";
				}
			}
			echo "</select>";
		}
	}
}

if( isset( $_GET["selected_faq"]) && $_GET["selected_faq"] !== ''  ){
	add_filter('parse_query', 'mm_filter_faq_admin');
}

if( !function_exists( 'mm_filter_faq_admin' ) ){
	function mm_filter_faq_admin($query){
		global $pagenow;
		global $typenow;
		global $wpdb;
		$post_id_meta = $_GET["selected_faq"];
		$arr_faq = $wpdb->get_results("SELECT meta_value FROM wp_postmeta WHERE post_id = $post_id_meta AND meta_key = 'mmfaqtags_id'",ARRAY_A);
		foreach ($arr_faq as $faq){
			$search = $faq['meta_value'];
		}
		$integerIDs = array_map('intval', explode(',',$search));
		if( $pagenow == "edit.php" && $typenow == "mmfaq" ){
			$qv = &$query->query_vars;

			if( !empty ($post_id_meta) ){
				$qv['post_type']='mmfaq';
				$qv['post__in']= $integerIDs;
			}
		}
	}
}
// add filter certificates  in admin
add_action('restrict_manage_posts', 'mm_filter_certificates');
if( !function_exists('mm_filter_certificates') ){
	function mm_filter_certificates() {
		global $wpdb;
		global $typenow;
		if( $typenow == 'product' ){
			$arr_certificates = $wpdb->get_results("SELECT term.name, term.slug  FROM wp_terms term INNER JOIN wp_term_taxonomy tx_term ON term.term_id = tx_term.term_id WHERE tx_term.taxonomy = 'certificates'",ARRAY_A);
			$currentCertificate = $_GET["selected_certificates"];
			echo "<select id='currentCertificate' name='selected_certificates'>";
			echo "<option value =''>All Certificate</option>";
			if( !empty($arr_certificates) ){
				foreach ($arr_certificates as $certificate){
					if ( isset($currentCertificate) && $currentCertificate === $certificate['slug'] ){
						$selected = 'selected';
					}else{
						$selected= '';
					}
					echo "<option value='".$certificate['slug']."' ".$selected." >".$certificate['name']."</option>";
				}
			}
			echo "</select>";
		}
	}
}

if( isset( $_GET["selected_certificates"]) && $_GET["selected_certificates"] !== ''  ){
	add_filter('parse_query', 'mm_filter_certificates_admin');
}

if( !function_exists( 'mm_filter_certificates_admin' ) ){
	function mm_filter_certificates_admin($query){
		global $pagenow;
		global $typenow;
		if( $pagenow == "edit.php" && $typenow == "product" ){
			$qv = &$query->query_vars;
			$qv['meta_query'] = array();

			if( isset( $_GET["selected_certificates"] ) ){
				$qv['tax_query'][] = array(
					'taxonomy'  => 'certificates',
					'field'     => 'slug',
					'terms'     => $_GET["selected_certificates"]
				);
			}
		}
	}
}

// add filter booking type in admin
add_action('restrict_manage_posts', 'mm_filter_tag_bookingtype');
if( !function_exists('mm_filter_tag_bookingtype') ){
	function mm_filter_tag_bookingtype(){
		global $typenow;
		if($typenow == 'product'){
			$bookingTypes = array('FHAPI','FHDN','FHPopup','PonorezAPI','WOO','ContactForm');
			$currentTag = $_GET["selected_tag"];


			echo "<select id='currentTag' name='selected_tag'>";
			echo "<option value =''>All Booking Type</option>";
			foreach ($bookingTypes as $bookingType){
				if ( isset($currentTag) && $currentTag === $bookingType ){
					$selected = 'selected';
				}else{
					$selected= '';
				}
				echo "<option value='".$bookingType."' ".$selected." >$bookingType</option>";
			}
			echo "</select>";
		}
	}

}

// add filter company in admin
add_action('restrict_manage_posts', 'mm_filter_tag_company');
if( !function_exists('mm_filter_tag_company') ){
	function mm_filter_tag_company(){
		global $typenow;
		if($typenow == 'product'){
			$companyNames = array('Action Sports Maui','Adventure Boat Tours','Adventures In Paradise Kayak and Snorkel',
				'Air Kauai','Air Maui','Airport Lei Greetings','Alii Air Tours','All About The View','All Hawaii Cruises',
				'Aloha Eco Adventures','Aloha Hawaii Tours','Aloha Kauai Tours','Aloha Kauai Tours','Aloha Scuba Diving Co.',
				'Anelakai Adventures','Apex Hawaii','Atlantis','ATV Outfitters','Auilii Luau','Banyan Tree Divers',
				'Banzai Divers Hawaii','Big Island Bike Tours','Big Island Ghost Tours','Bike Hawaii','Bike Tour Hawaii',
				'Bite Me','Blue Dolphin Charters','Blue Hawaii Photo Tours','Blue Hawaiian','Body Glove Hawaii','Calypso',
				'Captain Cook Cruises','Captain Steves','Captain Zodiac','Chiefs Luau','Climbworks','Coral Crater',
				'Dahana Ranch','Diamond Head Luau','Dive Oahu','Dolphin Discoveries','Dolphin Quest','Drake Hickman',
				'Elite Maui Chef','Enoa','Epic Tours','Fair Wind','Feast At Lele','Feast At Mokapu','Germaines',
				'Grand Wailea','Gung Ho Sailing','Haleakala Bike Co','Haleakala Eco Tours','Hana And Beyond','Hana Tours Of Maui',
				'Hang Gliding Maui','Hawaii By Storm','Hawaii Forest And Trail','Hawaii Glass Bottom Boats','Hawaii Island And Ocean Tours',
				'Hawaii Lifeguard Surf Instructors','Hawaii Mermaid Adventures','Hawaii Nautical','Hawaii Nautical','Hawaii Ocean Project',
				'Hawaii Ocean Promotions','Hawaii Ocean Rafting','Hawaii Shark Encounter','Hawaii Tours And Activities',
				'Hawaii Turtle Tours','Hawaii Walking Tours','Hawaiian Diving Adventures','Hawaiian Style Cooking Classes',
				'Hawaiian Style Surfing','Hawaiian Style Tours','Helewai Eco Tours','Hike Maui','Hilton Waikoloa','Hoaloha Jeep Adventures',
				'Holo Holo Charters','Holo Holo Maui Tours','Holokai Adventures','HTA','HTA Big Island','HTA Kauai','HTA Maui',
				'HTA Oahu','Huakai Luau Maui','Hula Girl','Hyatt Regency','Island Breeze','Jet Ski Oahu','Jungle Zipline',
				'Ka Moana','Kaanapali Beach Hotel','Kaanapali Ocean Adventures','Kahaluu Bay Surf and Sea','Kai Kanani',
				'Kailani Tour Hawaii','Kaimana Tours','Kamoauli','Kapalua','Kapohokine','Kauai ATV','Kauai Back Country',
				'Kauai Down Under Scuba','Kauai Hiking Adventures','Kauai Hiking Tours','Kauai Sea Tours','Kauai Surf School',
				'Kauai Zodiac Tours','Kayak Kauai','Keep It Simple Hawaii','Kipu Ranch','Ko Olina Ocean Adventures','Koa Canoes',
				'Kohala Zipline','Koloa Zipline','Kona Boys','Kona Cowboy Sportfishing','Kona Honu Divers','Kona Mikes Surf Adventures',
				'Kona Snorkel Trips','Kona Surf Town Adventures','Kualoa Ranch','Learn To Surf Kona','Living Ocean Scuba',
				'Luau Kalamaku','Luau Makaiwa','Mana Cruises','Maui Adventure Tours','Maui Brewery Tours','Maui Classic Charters',
				'Maui Dreams Dive Co.','Maui Eco Tours','Maui Goat Farm','Maui Kayak Adventures','Maui Off Road Adventures',
				'Maui Plane Rides','Maui Skydiving','Maui Spearfishing','Maui Sports Unlimited','Maui Sunriders','Maui Surf Lessons',
				'Maui Water Sports','Maui Wave Riders','Mauis Finest Luau','Mauna Loa Helicopters','Maverick','Mendes Ranch',
				'Moana Glass','Mololo','Mountain Riders','Naalapa Stables','Noahʻs Ark Tours','North Shore Beach Bus',
				'North Shore Surf Girls','Oahi Entertainment','Oahu Horseback Rides','Oahu Nature Tours','Oahu Photography Tours',
				'Oahu Scuba Diving','Ocean Encounters','Ocean Joy Cruises','Ocean Outfitters Hawaii','Ocean Sports','Ohana Surf Project',
				'Old Lahaina Luau','Ono Kauai Tours','Paniolo','Paradise Cove','Paradise Cruises','Paradise Helicopters',
				'Pearl Harbor Aviation Museum','Pearl Harbor Tours','Piiholo','PolyAd','Polynesian Cultural Center','Port Waikiki Cruises',
				'Princeville Ranch','Pro Diver Maui','Quicksilver','Rainbow Helicopters','Rainbow Kayak','Rainbow Watersports',
				'Rappel Maui','Rascal Charters','Redline Rafting','Roberts Hawaii','Royal Kona','Royal Lahaina','Sail Maui',
				'Sailing Catamaran','Sammys Hawaii','Scotch Mist Sailing Charters','Sea Life Park','Sea Maui','Sea Monkey Private Charters',
				'Sea Paradise','Secret Hawaii Tours','Segway Hawaii','Shaxi','Sheraton Maui','Silver Falls Ranch','Skyline',
				'Smiths Family','Star Gaze Hawaii','Strike Zone','Sunshine Helicopters','Surf Honolulu','Te Moana Nui',
				'Temptation Tours','The Adventure Boat','Tihati Productions','Toa Luau','Torpedo Tours','Trilogy Excursions',
				'Triple L Ranch','UFO','Ultimate Whale Watch And Snorkel','Umauma Experience','Valley Isle Excursions',
				'Waikoloa Beach','Wailea Boating Company','Wailea Horseback Adventure','Waipio On Horseback','Wasabi Tours Hawaii',
				'West Maui Parasail','Westin','Wings Over Kauai','Wings Over Pearl','Xtreme Parasail','Yoga Floats'
			);
			$currentCompany = $_GET["company_name"];

			echo "<select id='currentTag' name='company_name'>";
			echo "<option value=''>All Company Name</option>";
			foreach ($companyNames as $companyName){
                            $product_tag = get_term_by('name', $companyName, 'product_tag');
                            if(!empty($product_tag)){
                                $tag_slug = $product_tag->slug;
				if ( isset($currentCompany) && $currentCompany === $tag_slug ){
					$selected = 'selected';
				}else{
					$selected= '';
				}
				echo "<option value='".$tag_slug."' ".$selected." >$companyName</option>";
                            }
			}
			echo "</select>";
		}
	}

}

//  add filter rating in admin

add_action('restrict_manage_posts', 'mm_filter_tag_rating');
if( !function_exists('mm_filter_tag_rating') ){
	function mm_filter_tag_rating(){
		global $typenow;
		if($typenow == 'product'){
			$ratingNames = array('1','10','15','2','20','25','3','30','35','4','40','5','6','A','A1','A2','A3','B','C');
			$currentRating = $_GET["rating_name"];

			echo "<select id='currentTag' name='rating_name'>";
			echo "<option value=''>Rating</option>";
			foreach ($ratingNames as $ratingName){
				if ( isset($currentRating) && $currentRating === str_replace(" ",'-',trim(strtolower($ratingName))) ){
					$selected = 'selected';
				}else{
					$selected= '';
				}
				echo "<option value='".str_replace(" ",'-',trim(strtolower($ratingName)))."' ".$selected." >$ratingName</option>";
			}
			echo "</select>";
		}
	}

}


if( isset( $_GET["rating_name"]) && $_GET["rating_name"] !== ''  ){
	add_filter('parse_query', 'mm_filter_rating_admin');
}

if( !function_exists( 'mm_filter_rating_admin' ) ){
	function mm_filter_rating_admin($query){
		global $pagenow;
		global $typenow;

		if( $pagenow == "edit.php" && $typenow == "product" ){
			$qv = &$query->query_vars;
			$qv['meta_query'] = array();

			if( isset( $_GET["rating_name"] ) ){
				$qv['tax_query'][] = array(
					'taxonomy'  => 'product_tag',
					'field'     => 'slug',
					'terms'     => $_GET["rating_name"]
				);

			}

		}
	}
}

if( isset( $_GET["company_name"]) && $_GET["company_name"] !== ''  ){
	add_filter('parse_query', 'mm_filter_company_admin');
}

if( !function_exists( 'mm_filter_company_admin' ) ){
	function mm_filter_company_admin($query){
		global $pagenow;
		global $typenow;

		if( $pagenow == "edit.php" && $typenow == "product" ){
			$qv = &$query->query_vars;
			$qv['meta_query'] = array();

			if( isset( $_GET["company_name"] )){
				$qv['tax_query'][] = array(
					'taxonomy'  => 'product_tag',
					'field'     => 'slug',
					'terms'     => $_GET["company_name"]
				);
			}
		}
	}
}
if( isset( $_GET["selected_tag"]) && $_GET["selected_tag"] !== ''  ){
	add_filter('parse_query', 'mm_filter_bookingtype_admin');
}

if( !function_exists( 'mm_filter_bookingtype_admin' ) ){
	function mm_filter_bookingtype_admin($query){
		global $pagenow;
		global $typenow;

		if( $pagenow == "edit.php" && $typenow == "product" ){
			$qv = &$query->query_vars;
			$qv['meta_query'] = array();

			if( isset( $_GET["selected_tag"] ) ){
                            $qv['meta_query'][] = array(
                                'key' => 'mm_select_booking_type',
                                'value' => strtolower($_GET["selected_tag"]),
                                'compare' => '==',
                            );
			}

		}
	}
}

// remove meta box dropdown seo
add_action( 'admin_init', 'mm_remove_yoast_seo_admin_filters', 20 );
function mm_remove_yoast_seo_admin_filters() {
	global $wpseo_meta_columns ;
	if ( $wpseo_meta_columns  ) {
		remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown' ) );
		remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown_readability' ) );
	}
}


add_filter( 'woocommerce_products_admin_list_table_filters', 'remove_products_admin_list_table_filters', 10, 1 );
function remove_products_admin_list_table_filters( $filters ){
	// Remove "Product type" dropdown filter
	if( isset($filters['product_type']))
		unset($filters['product_type']);

	// Remove "Product stock status" dropdown filter
	if( isset($filters['stock_status']))
		unset($filters['stock_status']);

	return $filters;
}

add_action('restrict_manage_posts', 'mm_filter_tag_mm_email');
if( !function_exists('mm_filter_tag_mm_email') ){
    function mm_filter_tag_mm_email(){
        global $typenow;
        if($typenow == 'product'){
            $mm_emails = array('Yes','No');
            $currentmm_email = $_GET["mm_email"];

            echo "<select name='mm_email'>";
            echo "<option value=''>All MM Email</option>";
            foreach ($mm_emails as $mm_email){
                if ( isset($currentmm_email) && $currentmm_email === str_replace(" ",'-',trim(strtolower($mm_email))) ){
                    $selected = 'selected';
                }else{
                    $selected= '';
                }
                echo "<option value='".str_replace(" ",'-',trim(strtolower($mm_email)))."' ".$selected." >$mm_email</option>";
            }
            echo "</select>";
        }
    }

}

if( isset( $_GET["mm_email"]) && $_GET["mm_email"] !== ''  ){
    add_filter('parse_query', 'mm_filter_product_mm_email_admin');
}

if( !function_exists( 'mm_filter_product_mm_email_admin' ) ){
    function mm_filter_product_mm_email_admin($query){
        global $pagenow;
        global $typenow;
        if( $pagenow == "edit.php" && $typenow == "product" ){
            $qv = &$query->query_vars;
            
            if( isset( $_GET["mm_email"] ) ){
                if($_GET["mm_email"] =='yes'){
                    $qv['meta_query'][] = array(
                        
                        'key' => 'content_email_meta_box',
                        'value' => '',
                        'compare' => '!=',
                        
                    );
                }else{
                    $qv['meta_query'][] = array(
                       
                        'key' => 'content_email_meta_box',
                        'value' => '',
                        'compare' => '==',
                        
                    );
                }
            }

        }
    }
}
//add column
add_filter( 'manage_edit-product_columns', 'mm_add_colunm_is_check_farehabor_api');
if(!function_exists('mm_add_colunm_is_check_farehabor_api')) {
	function mm_add_colunm_is_check_farehabor_api($columns){
		//add column
		$columns['mm_enable_api'] = __( 'API');
		return $columns;
	}
}
add_action( 'manage_product_posts_custom_column', 'mm_get_enable_fareharbor_api', 10, 2 );
if(!function_exists('mm_get_enable_fareharbor_api')) {
	function mm_get_enable_fareharbor_api( $column, $postid ) {
		if ( $column == 'mm_enable_api' ) {
			$value_fhapi = unserialize(get_post_meta( $postid, 'mm_fareharbor_api', true ));
			echo "FH: ";
			echo get_post_meta( $postid, 'mm_enable_fareharbor_api', true ) == 'yes' ? 'yes' . '</br>' : 'no' . '</br>';
			if (is_array($value_fhapi)) {
				foreach ( $value_fhapi as $key => $val ) {
					echo '[' . $key . ']';
					foreach ( $val as $key_vd => $val_vd ) {
						if ( $key_vd == 'resource' ) {
							echo $key_vd . ':' . $val_vd;
						} else {
							echo $key_vd . ':' . $val_vd . '||';
						}
					}
					echo '</br>';
				}
			}
		}
		echo '</br>';
		if ( $column == 'mm_enable_api' ) {
			$value_fhponorez = unserialize(get_post_meta( $postid, 'mm_ponorez_api', true ));
			echo "PONOREZ: ";
			echo get_post_meta( $postid, 'mm_enable_ponorez_api', true ) == 'yes' ? 'yes' . '</br>' : 'no' . '</br>';
			if (is_array($value_fhponorez)) {
				foreach ( $value_fhponorez as $key => $val ) {
					echo '[' . $key . ']';
					foreach ( $val as $key_vd => $val_vd ) {
						if ( $key_vd == 'resource' ) {
							echo $key_vd . ':' . $val_vd;
						} else {
							echo $key_vd . ':' . $val_vd . '||';
						}
					}
					echo '</br>';
				}
			}
		}
	}
}

add_filter( 'manage_edit-product_columns', 'mm_add_colunm_is_check_fareharbor_reservation');
if(!function_exists('mm_add_colunm_is_check_fareharbor_reservation')) {
	function mm_add_colunm_is_check_fareharbor_reservation($columns){
		//add column
		$columns['mm_disable_fareharbor_reservation'] = __( 'Disable FHAPI Reservations');
		return $columns;
	}
}
add_action( 'manage_product_posts_custom_column', 'mm_get_disable_fareharbor_reservation', 10, 2 );
if(!function_exists('mm_get_disable_fareharbor_reservation')) {
	function mm_get_disable_fareharbor_reservation( $column, $postid ) {
		if ( $column == 'mm_disable_fareharbor_reservation' ) {
			echo get_post_meta( $postid, 'mm_disable_fareharbor_reservation', true ) == 'yes' ? 'yes' : 'no';


		}
	}
}
// add filter Status product
add_action('restrict_manage_posts', 'mm_filter_products_status');
if( !function_exists('mm_filter_products_status') ){
    function mm_filter_products_status(){
        global $typenow;
        if($typenow == 'product'){
            $products_status = array('Published','Draft','Private','Trash');
            $currentstatus = $_GET["product_status"];
            echo "<select id='product_status' name='product_status'>";
            echo "<option value =''>All Status</option>";
            foreach ($products_status as $product_status){
                if ( isset($currentstatus) && $currentstatus === $product_status ){
                    $selected = 'selected';
                }else{
                    $selected= '';
                }
                echo "<option value='".$product_status."' ".$selected." >$product_status</option>";
            }
            echo "</select>";
        }
    }

}
if( isset( $_GET["product_status"]) && $_GET["product_status"] !== ''  ){
    add_filter('parse_query', 'mm_filter_products_status_query');
}

if( !function_exists( 'mm_filter_products_status_query' ) ){
    function mm_filter_products_status_query($query){
        global $pagenow;
        global $typenow;
        if( $pagenow == "edit.php" && $typenow == "product" ){
            $qv = &$query->query_vars;
            
            if( isset( $_GET["product_status"] ) && !empty($_GET["product_status"])){
                switch ($_GET["product_status"]) {
                    case 'Published':
                        $status = 'publish';
                        break;
                    case 'Draft':
                        $status = 'draft';
                        break;
                    case 'Private':
                        $status = 'private';
                        break;
                    case 'Trash':
                        $status = 'trash';
                        break;
                    default:
                        $status = $_GET["product_status"];
                        break;
                }
                $qv['post_status'] = $status;
                
            }

        }
    }
}
//Order
// add filter booking type in admin
add_action('restrict_manage_posts', 'mm_filter_order_hubspot_status');
if( !function_exists('mm_filter_order_hubspot_status') ){
    function mm_filter_order_hubspot_status(){
        global $typenow;
        if($typenow == 'shop_order'){
            $hubspotTypes = array('Pending','Errors');
            $currentstatus = $_GET["hubspot_status"];
            echo "<select id='hubspot_status' name='hubspot_status'>";
            echo "<option value =''>All Hubspot API</option>";
            foreach ($hubspotTypes as $hubspotType){
                if ( isset($currentstatus) && $currentstatus === $hubspotType ){
                    $selected = 'selected';
                }else{
                    $selected= '';
                }
                echo "<option value='".$hubspotType."' ".$selected." >$hubspotType</option>";
            }
            echo "</select>";
        }
    }

}
add_action('restrict_manage_posts', 'mm_filter_order_fhapi_status');
if( !function_exists('mm_filter_order_fhapi_status') ){
    function mm_filter_order_fhapi_status(){
        global $typenow;
        if($typenow == 'shop_order'){
            $Types = array('Pending','Errors');
            $currentstatus = $_GET["fhapi_status"];
            echo "<select id='fhapi_status' name='fhapi_status'>";
            echo "<option value =''>All FHAPI</option>";
            foreach ($Types as $Type){
                if ( isset($currentstatus) && $currentstatus === $Type ){
                    $selected = 'selected';
                }else{
                    $selected= '';
                }
                echo "<option value='".$Type."' ".$selected." >FHAPI ".$Type."</option>";
            }
            echo "</select>";
        }
    }

}
add_action('restrict_manage_posts', 'mm_filter_order_ponorez_status');
if( !function_exists('mm_filter_order_ponorez_status') ){
    function mm_filter_order_ponorez_status(){
        global $typenow;
        if($typenow == 'shop_order'){
            $Types = array('Pending','Errors');
            $currentstatus = $_GET["ponorez_status"];
            echo "<select id='ponorez_status' name='ponorez_status'>";
            echo "<option value =''>All Ponorez API</option>";
            foreach ($Types as $Type){
                if ( isset($currentstatus) && $currentstatus === $Type ){
                    $selected = 'selected';
                }else{
                    $selected= '';
                }
                echo "<option value='".$Type."' ".$selected." >".$Type."</option>";
            }
            echo "</select>";
        }
    }

}
if( isset( $_GET["fhapi_status"]) && $_GET["fhapi_status"] !== ''  ){
    add_filter('parse_query', 'mm_filter_order_fhapi_status_query');
}

if( !function_exists( 'mm_filter_order_fhapi_status_query' ) ){
    function mm_filter_order_fhapi_status_query($query){
        global $pagenow;
        global $typenow;
        if( $pagenow == "edit.php" && $typenow == "shop_order" ){
            $qv = &$query->query_vars;
            
            if( isset( $_GET["fhapi_status"] ) && !empty($_GET["fhapi_status"])){
                if($_GET["fhapi_status"] =='Errors'){
                    $qv['meta_query'][] = array(
                        'key' => 'mm_fareharbor_is_success',
                        'compare' => '==',
                        'value' => 'No',
                    );
                    $qv['date_query'] = array(
                        'column' => 'post_date',
                        'after' => '- 7 days'
                    );
                    $qv['post_status'] = array('wc-pending','wc-processing','wc-transporting','wc-ready-for-pickup','wc-on-hold','wc-completed','wc-quote','wc-partial-payment');
                }elseif($_GET["fhapi_status"] =='Pending'){
                    $qv['meta_query'][] = array(
                        'relation' => 'AND',
                        array(
                            'key' => 'mm_fareharbor_is_success',
                            'compare' => '==',
                            'value' => 'No',
                        ),
                        array(
                            'key' => 'mm_fareharbor_errors',
                            'compare' => 'NOT EXISTS',
                        ),
                    );
                }
            }

        }
    }
}
if( isset( $_GET["ponorez_status"]) && $_GET["ponorez_status"] !== ''  ){
    add_filter('parse_query', 'mm_filter_order_ponorez_status_query');
}

if( !function_exists( 'mm_filter_order_ponorez_status_query' ) ){
    function mm_filter_order_ponorez_status_query($query){
        global $pagenow;
        global $typenow;
        if( $pagenow == "edit.php" && $typenow == "shop_order" ){
            $qv = &$query->query_vars;
            
            if( isset( $_GET["ponorez_status"] ) && !empty($_GET["ponorez_status"])){
                if($_GET["ponorez_status"] =='Errors'){
                    $qv['meta_query'][] = array(
                        'key' => 'mm_ponorez_is_success',
                        'compare' => '==',
                        'value' => 'No',
                    );
                    $qv['date_query'] = array(
                        'column' => 'post_date',
                        'after' => '- 7 days'
                    );
                    $qv['post_status'] = array('wc-pending','wc-processing','wc-transporting','wc-ready-for-pickup','wc-on-hold','wc-completed','wc-quote','wc-partial-payment');
                }elseif($_GET["ponorez_status"] =='Pending'){
                    $qv['meta_query'][] = array(
                        'relation' => 'AND',
                        array(
                            'key' => 'mm_ponorez_is_success',
                            'compare' => '==',
                            'value' => 'No',
                        ),
                        array(
                            'key' => 'mm_ponorez_errors',
                            'compare' => 'NOT EXISTS',
                        ),
                    );
                }
            }

        }
    }
}
if( isset( $_GET["hubspot_status"]) && $_GET["hubspot_status"] !== ''  ){
    add_filter('parse_query', 'mm_filter_order_hubspot_status_query');
}

if( !function_exists( 'mm_filter_order_hubspot_status_query' ) ){
    function mm_filter_order_hubspot_status_query($query){
        global $pagenow;
        global $typenow;
        if( $pagenow == "edit.php" && $typenow == "shop_order" ){
            $qv = &$query->query_vars;
            
            if( isset( $_GET["hubspot_status"] ) && !empty($_GET["hubspot_status"])){
                if($_GET["hubspot_status"] =='Errors'){
                    $qv['meta_query'][] = array(
                        'key' => 'mm_hub_spot_send_error',
                        'value' => 'yes',
                        'compare' => '==',
                    );
                }elseif($_GET["hubspot_status"] =='Pending'){
                    $qv['meta_query'][] = array(
                        'relation' => 'AND',
                        array(
                            'key' => 'hubwoo_ecomm_deal_created',
                            'compare' => '==',
                            'value' => 'yes',
                        ),
                        array(
                            'key' => 'mm_hub_spot_deal_created',
                            'compare' => 'NOT EXISTS',
                        ),
                    );
                }
            }

        }
    }
}
//add column
add_filter( 'manage_edit-product_columns', 'mm_add_colunm_farehabor_calendar');
if(!function_exists('mm_add_colunm_farehabor_calendar')) {
    function mm_add_colunm_farehabor_calendar($columns){
        //add column
        $columns['mm_fareharbor_calendar'] = __( 'FH Calendar');
        return $columns;
    }
}
add_action( 'manage_product_posts_custom_column', 'mm_show_colunm_farehabor_calendar', 10, 2 );
if(!function_exists('mm_show_colunm_farehabor_calendar')) {
    function mm_show_colunm_farehabor_calendar( $column, $postid ) {
        if ( $column == 'mm_fareharbor_calendar' ) {
            $popup_link = get_post_meta( $postid, 'enable_fareharbor_popup_link', true );
            $calendar_url = get_post_meta( $postid, 'enable_fareharbor_link', true );
            if(!empty($popup_link)){
                echo "Popup URL:".$popup_link;
            }
            if(!empty($calendar_url)){
                echo "<br>Calendar URL: ".$calendar_url;
            }
        }
    }
}

add_filter('manage_edit-product_columns', 'mm_add_colunm_audited_product');
add_filter('manage_edit-shop_order_columns', 'mm_add_colunm_audited_product');
if (!function_exists('mm_add_colunm_audited_product')) {

    function mm_add_colunm_audited_product($columns) {
        //add column
        $columns['mm_audited_product'] = __('Audited');
        return $columns;
    }

}
add_action('manage_product_posts_custom_column', 'mm_add_show_colunm_audited_product_item', 10, 2);
add_action('manage_shop_order_posts_custom_column', 'mm_add_show_colunm_audited_product_item', 10, 2);
if (!function_exists('mm_add_show_colunm_audited_product_item')) {

    function mm_add_show_colunm_audited_product_item($column, $postid) {
        if ($column == 'mm_audited_product') {
            $audited = get_post_meta($postid, 'mm_audited_product', true);
            $content = $audited;
            if (empty($audited)) {
                $content = 'Not Yet';
            }
            echo '<div class="mm-audited-field" data-type="mm_product_audited" data-post_id="' . $postid . '" data-content="' . $audited . '" title="" >
                            <span class="audited-content"><span>' . $content . '</span></span>
                        </div>';
        }
    }

}
add_action('wp_ajax_mm_save_product_audited_field', 'mm_save_product_audited_field');

function mm_save_product_audited_field() {
    $postid = $_POST['postid'];
    $audited = $_POST['audited'];
    if(empty($audited)){
        delete_post_meta( $postid, 'mm_audited_product', null );
    }
    else{
        update_post_meta($postid, 'mm_audited_product', $audited);
    }
}

add_action('restrict_manage_posts', 'mm_filter_audited_product');
if (!function_exists('mm_filter_audited_product')) {

    function mm_filter_audited_product() {
        global $typenow;
        if ($typenow == 'product' || $typenow == 'shop_order') {
            $currentaudited = $_GET["audited"];
            echo "<select id='filter_audited_product' name='audited'>";
            echo "<option value=''>ALL Audited</option>";
            echo "<option value='audited' ".(($currentaudited=="audited")?"selected='selected'":"").">Audited</option>";
            echo "<option value='not_yet' ".(($currentaudited=="not_yet")?"selected='selected'":"").">Not Yet</option>";
            echo "</select>";
        }
    }

}
if (!function_exists('mm_filter_query_audited_product')) {

    function mm_filter_query_audited_product($query) {
        global $pagenow;
        global $typenow;
        if ($pagenow == "edit.php" && ($typenow == "product" || $typenow == 'shop_order')) {
            $qv = &$query->query_vars;

            if (isset($_GET["audited"]) && !empty($_GET["audited"])) {
                if ($_GET["audited"] == 'not_yet') {
                    $qv['meta_query'][] = array(
                        'key' => 'mm_audited_product',
                        'compare' => 'NOT EXISTS',
                    );
                } else{
                    $qv['meta_query'][] = array(
                            'key' => 'mm_audited_product',
                            'compare' => '!=',
                            'value' => '',
                        );
                }
            }
        }
    }

}
add_filter('parse_query', 'mm_filter_query_audited_product');

add_filter('manage_edit-shop_order_columns', 'mm_add_colunm_payment_link_order');
if (!function_exists('mm_add_colunm_payment_link_order')) {

    function mm_add_colunm_payment_link_order($columns) {
        //add column
        $columns['mm_payment_link'] = __('Payment Link');
        return $columns;
    }

}
add_action('manage_shop_order_posts_custom_column', 'mm_add_show_colunm_payment_link_item', 10, 2);
if (!function_exists('mm_add_show_colunm_payment_link_item')) {

    function mm_add_show_colunm_payment_link_item($column, $postid) {
        if ($column == 'mm_payment_link') {
            $order = wc_get_order($postid);
            if ( WC()->payment_gateways() ) {
                $payment_gateways = WC()->payment_gateways->payment_gateways();
            } else {
                $payment_gateways = array();
            }
            $payment_method = $order->get_payment_method();
            $payment_method_string = '';

            if ( $transaction_id = $order->get_transaction_id() ) {
                if ( isset( $payment_gateways[ $payment_method ] ) && ( $url = $payment_gateways[ $payment_method ]->get_transaction_url( $order ) ) ) {
                    $payment_method_string .= '<a href="' . esc_url( $url ) . '" target="_blank">' . esc_html( $transaction_id ) . '</a>';
                } else {
                    $payment_method_string .=  esc_html( $transaction_id );
                }
            }
            if(empty($payment_method_string) && $order->get_payment_method_title() =='Check payments'){
                $payment_method_string = 'Check payments';
            }
            
            $used_gift_cards = get_post_meta( $postid, '_ywgc_applied_gift_cards', true);
            if(!empty($used_gift_cards)){
                foreach ( $used_gift_cards as $code => $amount ){
                    $url_gift_card = '/wp-admin/edit.php?s='.$code.'&post_status=all&post_type=gift_card&action=-1&m=0&seocol_filter=0&paged=1&action2=-1';
                    $payment_method_string.=' <a href="' . esc_url( $url_gift_card ) . '" target="_blank">' . esc_html( $code ) . '</a>';
                }
            }
            echo $payment_method_string;
        }
    }

}

//add column last modified post
add_filter( 'manage_edit-product_columns', 'mm_add_colunm_last_modified_post');
if(!function_exists('mm_add_colunm_last_modified_post')) {
	function mm_add_colunm_last_modified_post($columns){
		//add column
		$columns['mm_last_modified_post'] = __( 'Last Modified');
		return $columns;
	}
}
add_action( 'manage_product_posts_custom_column', 'mm_show_colunm_last_modified_post', 10, 2 );
if(!function_exists('mm_show_colunm_last_modified_post')) {
	function mm_show_colunm_last_modified_post( $column, $postid ) {
		if ( $column == 'mm_last_modified_post' ) {
			global $wpdb;
			$arr_post = $wpdb->get_results("SELECT post_modified_gmt FROM {$wpdb->prefix}posts where ID = $postid",ARRAY_A);
			foreach( $arr_post as $post_test ){
				echo $post_test['post_modified_gmt'];
			}
		}
	}
}

add_filter( 'manage_edit-product_columns', 'mm_add_custom_column_products');
if(!function_exists('mm_add_custom_column_products')) {
	function mm_add_custom_column_products($columns){
            $columns['mm_booking_type'] = __( 'Booking Type');
            return $columns;
	}
}
add_action( 'manage_product_posts_custom_column', 'mm_show_custom_column_products', 10, 2 );
if(!function_exists('mm_show_custom_column_products')) {
	function mm_show_custom_column_products( $column, $postid ) {
		if ( $column == 'mm_booking_type' ) {
                    $mm_select_booking_type = get_post_meta($postid, 'mm_select_booking_type', true);
                    echo strtoupper($mm_select_booking_type);
		}
	}
}

add_filter('manage_edit-shop_order_columns', 'mm_add_colunm_confirm_page_order');
if (!function_exists('mm_add_colunm_confirm_page_order')) {

    function mm_add_colunm_confirm_page_order($columns) {
        $columns['mm_confirm_url'] = __('Confirmation Page');
        return $columns;
    }

}
add_action('manage_shop_order_posts_custom_column', 'mm_add_show_colunm_confirm_page_order', 10, 2);
if (!function_exists('mm_add_show_colunm_confirm_page_order')) {
    function mm_add_show_colunm_confirm_page_order($column, $postid) {
        if ($column == 'mm_confirm_url') {
            $order = wc_get_order($postid);
            $url = $order->get_checkout_order_received_url();
            echo '<a href="'.$url.'" target="_blank">'.$order->get_order_number().'</a>';
        }
        
    }
}

add_action('restrict_manage_posts', 'mm_filter_resource_location');
if( !function_exists('mm_filter_resource_location') ){
    function mm_filter_resource_location(){
        global $typenow;
        if($typenow == 'bookable_resource'){
            $Types = array(
                'audited' => 'Audited',
                'not_yet' => 'Not Yet',
            );
            $currentstatus = $_GET["location_status"];
            echo "<select id='location_status' name='location_status'>";
            echo "<option value =''>All Locations</option>";
            foreach ($Types as $key => $Type){
                if ( isset($currentstatus) && $currentstatus === $key ){
                    $selected = 'selected';
                }else{
                    $selected= '';
                }
                echo "<option value='".$key."' ".$selected." >Locations ".$Type."</option>";
            }
            echo "</select>";
        }
    }
}

if( isset( $_GET["location_status"]) && $_GET["location_status"] !== ''  ){
    add_filter('parse_query', 'mm_filter_resource_location_status_query');
}

if( !function_exists( 'mm_filter_resource_location_status_query' ) ){
    function mm_filter_resource_location_status_query($query){
        global $pagenow;
        global $typenow;
        if( $pagenow == "edit.php" && $typenow == "bookable_resource" ){
            $qv = &$query->query_vars;
            
            if( isset( $_GET["location_status"] ) && !empty($_GET["location_status"])){
                if($_GET["location_status"] == 'audited'){
                    $qv['meta_query'][] = array(
                        'key' => '_wc_booking_location',
                        'compare' => '!=',
                        'value' => '',
                    );
                }elseif($_GET["location_status"] == 'not_yet'){
                    $qv['meta_query'][] = array(
                        'key' => '_wc_booking_location',
                        'compare' => 'NOT EXISTS',
                    );
                }
            }

        }
    }
}
add_action('restrict_manage_posts', 'mm_filter_resource_email_confirm');
if( !function_exists('mm_filter_resource_email_confirm') ){
    function mm_filter_resource_email_confirm(){
        global $typenow;
        if($typenow == 'bookable_resource'){
            $Types = array(
                'activated' => 'Activated',
                'deactivated' => 'Deactivated',
            );
            $currentstatus = $_GET["email_confirm"];
            echo "<select id='email_confirm' name='email_confirm'>";
            echo "<option value =''>All Email Confirmation</option>";
            foreach ($Types as $key => $Type){
                if ( isset($currentstatus) && $currentstatus === $key ){
                    $selected = 'selected';
                }else{
                    $selected= '';
                }
                echo "<option value='".$key."' ".$selected." >Email Confirmation: ".$Type."</option>";
            }
            echo "</select>";
        }
    }
}
if( isset( $_GET["email_confirm"]) && $_GET["email_confirm"] !== ''  ){
    add_filter('parse_query', 'mm_filter_resource_email_confirm_query');
}
if( !function_exists( 'mm_filter_resource_email_confirm_query' ) ){
    function mm_filter_resource_email_confirm_query($query){
        global $pagenow;
        global $typenow;
        if( $pagenow == "edit.php" && $typenow == "bookable_resource" ){
            $qv = &$query->query_vars;
            
            if( isset( $_GET["email_confirm"] ) && !empty($_GET["email_confirm"])){
                if($_GET["email_confirm"] == 'activated'){
                    $qv['meta_query'][] = array(
                        'key' => 'mm_enable_send_email_confirm',
                        'compare' => '==',
                        'value' => 'yes',
                    );
                }elseif($_GET["email_confirm"] == 'deactivated'){
                    $qv['meta_query'][] = array(
                        'key' => 'mm_enable_send_email_confirm',
                        'compare' => 'NOT EXISTS',
                    );
                }
            }

        }
    }
}

// filter product by tag
if (!function_exists('mm_admin_filter_tags_product')) {
    add_action('restrict_manage_posts', 'mm_admin_filter_tags_product');
    if (!function_exists('mm_admin_filter_tags_product')) {
        function mm_admin_filter_tags_product() {
            global $typenow;
            if ($typenow == 'product') {
                $tags = get_terms( array(
                    'taxonomy' => 'product_tag',
                    'hide_empty' => false,
                ) );
                $currentaudited = $_GET["audited"];
                echo "<select id='filter_tags_product' name='product_tag'>";
                echo "<option value=''>Filter by tag</option>";
                foreach($tags as $tag) {
                    $is_selected = $_GET["product_tag"] == $tag->slug ? 'selected' : '';
                    echo "<option {$is_selected} value='$tag->slug'>{$tag->name}</option>";
                }
                echo "</select>";
            }
        }
    }
}