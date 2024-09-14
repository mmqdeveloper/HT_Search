<?php
defined('ABSPATH') || exit;

class mm_change_author {

    protected static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {

        $this->init_hooks();

        do_action('mm_change_author_loaded');
    }

    public function init_hooks() {
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));
        add_action('admin_menu', array($this, 'add_menu_item'));
    }

    public function admin_enqueue() {
        wp_enqueue_script('multiselect_dropdown', get_stylesheet_directory_uri() . '/module/assets/admin/js/multiselect-dropdown.js', array('jquery'), '1.0.0', true);
    }

    /**
     * Add settings page to admin menu
     * @return void
     */
    public function add_menu_item() {
        $page = add_submenu_page('tools.php', __('MM Change Author', 'mm'), __('MM Change Author', 'mm'), 'manage_options', 'mm_change_author_settings', array($this, 'settings_page'));
        add_action('admin_print_styles-' . $page, array($this, 'settings_assets'));
    }

    public function settings_assets() {
        
    }

    /**
     * Load settings page content
     * @return void
     */
    public function settings_page() {
        if (isset($_POST['save_change_author'])) {
            $mm_change_author_posttype = serialize($_POST['mm_change_author_posttype']);
            update_option('mm_change_author_posttype', $mm_change_author_posttype);
            $mm_author = serialize($_POST['mm_author']);
            update_option('mm_change_author_id', $mm_author);
        }

        $custom_post_data = self::get_options('mm_change_author_posttype');
        $mm_change_author_id = self::get_options('mm_change_author_id');
        if (!empty($custom_post_data)) {
            $posts_from_db = unserialize($custom_post_data);
        }
        $author_id = array();
        if (!empty($mm_change_author_id)) {
            $author_id = unserialize($mm_change_author_id);
        }

        $checked_post = '';
        $checked_page = '';
        $checked_product = '';
        $post_types = get_post_types(array('_builtin' => FALSE), 'objects');
        if (!empty($posts_from_db)) {
            if (in_array('post', $posts_from_db)) {
                $checked_post = 'checked';
            } else {
                $checked_post = '';
            }
            if (in_array('page', $posts_from_db)) {
                $checked_page = 'checked';
            } else {
                $checked_page = '';
            }
            if (in_array('product', $posts_from_db)) {
                $checked_product = 'checked';
            } else {
                $checked_product = '';
            }
        }
        ?>
        <div class="main-wrap">
            <h1>Change Author to Hawaii Tours Expert</h1>

            <div class="outer-mmfaq-box">
                <form method="POST" class="mm_change_author_form" id="mm_change_author_form">
                    <h2>Select Post Type</h2>
                    <div class="mm_choose_posttype">
                        <label class="wp_mmfaq_container">Product
                            <input class="styled-checkbox" <?php echo $checked_product; ?> id="page" name="mm_change_author_posttype[]" type="checkbox" value="product">
                            <span class="checkmark"></span>
                        </label>
                        <label class="wp_mmfaq_container">Post
                            <input  class="styled-checkbox" <?php echo $checked_post; ?> id="post" name="mm_change_author_posttype[]" type="checkbox" value="post">
                            <span class="checkmark"></span>
                        </label>
                        <label class="wp_mmfaq_container">Page
                            <input class="styled-checkbox" <?php echo $checked_page; ?> id="page" name="mm_change_author_posttype[]" type="checkbox" value="page">
                            <span class="checkmark"></span>
                        </label>
                        <?php
                        foreach ($post_types as $post_type => $properties) {
                            if (!empty($posts_from_db)) {
                                if (in_array($properties->name, $posts_from_db)) {
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            }
                            if (!in_array($properties->name, array('product', 'post', 'page', 'pys_event'))) {
                                ?>
                                <label class="wp_mmfaq_container <?php echo $properties->name; ?>"><?php echo $properties->labels->name; ?>
                                    <input  class="styled-checkbox" <?php echo $checked; ?> id="<?php echo $properties->name; ?>" name="mm_change_author_posttype[]" type="checkbox" value="<?php echo $properties->name; ?>">
                                    <span class="checkmark"></span>
                                </label>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <h2>Select Author</h2>
                    <div class="mm_choose_author">
                        <?php
                        $args = array(
                            'role__in' => array('administrator', 'shop_manager'),
                            'orderby' => 'user_nicename',
                            'order' => 'ASC'
                        );
                        $users = get_users($args);
                        ?>
                        <select name="mm_author[]" id="mm_author" multiple multiselect-select-all="true" multiselect-search="true">
                            <?php
                            foreach ($users as $user) {
                                $selected = '';
                                if (in_array($user->ID, $author_id)) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?php echo $user->ID; ?>" <?php echo $selected; ?>><?php echo esc_html($user->display_name); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="save_btn_wrapper">
                        <input type="submit" name="save_change_author" id="save_change_author" class="save_change_author" value="Save">
                    </div>
                </form>
            </div>
        </div>
        <?php
    }

    public static function get_options($key, $default = null) {
        return get_option($key, $default);
    }

}

mm_change_author::instance();

if (!function_exists('mm_cron_change_author_func')) {

    function mm_cron_change_author_func() {
        $post_type = get_option('mm_change_author_posttype');
        $list_user = get_option('mm_change_author_id');
        $post_type_array = array();
        $list_user_array = array();
        if (!empty($post_type)) {
            $post_type_array = unserialize($post_type);
        }
        if (!empty($list_user)) {
            $list_user_array = unserialize($list_user);
        }
        if (!empty($post_type_array) && !empty($list_user_array)) {
            $args = array(
                'post_type' => $post_type_array,
                'author__in' => $list_user_array,
                'orderby' => 'post_date',
                'order' => 'ASC',
                'posts_per_page' => -1
            );
            $query = new WP_Query($args);
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $update_post = array(
                    'ID' => $post_id,
                    'post_author' => '441',
                );
                wp_update_post($update_post);
            }
            wp_reset_query();
        }
    }

}
add_action('mm_cron_change_author', 'mm_cron_change_author_func');
