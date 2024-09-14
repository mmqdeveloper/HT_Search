<?php

defined( 'ABSPATH' ) || exit;

class tempaleEmail {
    private $settings_base;
    private $settings;
    protected static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {

        $this->settings_base = 'ht_email_';

        $this->init_hooks();

        do_action( 'tempale_admin_loaded' );
    }

    public function init_hooks() {
        add_action( 'admin_init', array( $this, 'init' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_menu', array( $this, 'add_menu_item' ), 99 );
    }
    
    public function init() {
        $this->settings = $this->settings_fields();
    }

    /**
     * Add settings page to admin menu
     * @return void
     */
    public function add_menu_item() {
       $page = add_submenu_page( 'maui-marketing-menu', __( 'MM Emails', 'mm' ), __( 'MM Emails', 'mm' ), 'manage_options', 'ht_tempale_settings', array( $this, 'settings_page' ) );
        add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
    }

    /**
     * Load settings JS & CSS
     * @return void
     */
    public function settings_assets() {

        wp_enqueue_style( 'farbtastic' );
        wp_enqueue_script( 'farbtastic' );
        wp_enqueue_media();
    }

    /**
     * Add settings link to plugin list table
     *
     * @param  array $links Existing links
     *
     * @return array        Modified links
     */
    public function add_settings_link( $links, $file ) {
        if ( $file === 'tempale/tempale.php' && current_user_can( 'manage_options' ) ) {

            $settings_link = '<a href="edit.php?post_type=tempale&page=ht_tempale_settings">' . __( 'Settings', 'tempale' ) . '</a>';
            array_unshift( $links, $settings_link );

        }

        return $links;
    }

    /**
     * Build settings fields
     * @return array Fields to be displayed on settings page
     */
    private function settings_fields() {

        $settings['options'] = array(
            'title'       => __( '', 'mm' ),
            'description' => '',
            'fields'      => array(
                array(
                    'id'          => 'template_content',
                    'label'       => __( 'Content Email Header:', 'mm' ),
                    'description' => __( 'Content Email Header', 'mm' ),
                    'type'        => 'textarea',
                ),
				array(
					'id'          => 'template_content_footer',
					'label'       => __( 'Content Email Footer:', 'mm' ),
					'description' => __( 'Content Email Footer', 'mm' ),
					'type'        => 'textarea',
				),
            )
        );

        $settings = apply_filters( 'ht_tempale_settings_fields', $settings );

        return $settings;
    }


    /**
     * Register plugin settings
     * @return void
     */
    public function register_settings() {
        if ( is_array( $this->settings ) ) {
            foreach ( $this->settings as $section => $data ) {
                // Add section to page
                add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), 'ht_tempale_settings' );

                foreach ( $data['fields'] as $field ) {

                    // Validation callback for field
                    $validation = '';
                    if ( isset( $field['callback'] ) ) {
                        $validation = $field['callback'];
                    }

                    // Register field
                    $option_name = $this->settings_base . $field['id'];
                    register_setting( 'ht_tempale_settings', $option_name, $validation );
                    // Add field to page
                    add_settings_field( $field['id'], $field['label'], array( $this, 'display_field' ), 'ht_tempale_settings', $section, array( 'field' => $field ) );
                }
            }
        }
    }

    public function settings_section( $section ) {
        $html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
        echo $html;
    }

    /**
     * Generate HTML for displaying fields
     *
     * @param  array $args Field data
     *
     * @return void
     */
    public function display_field( $args ) {

        $field = $args['field'];
        $field['options'] = ["minute", "hours", "day"];
        $html = '';

        $option_name = $this->settings_base . $field['id'];
        $option      = get_option( $option_name );
        $data = '';

        if ( !isset( $field['default'] ) ) {
            $data = $field['default'];
            if ( $option ) {
                $data = $option;
            }
        }

        switch ( $field['type'] ) {

            case 'text':
            case 'password':
            case 'number':
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . $data . '"/>' . "\n";
                break;

            case 'text_secret':
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value=""/>' . "\n";
                break;

            case 'textarea':
                $html .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="100" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '">' . $data . '</textarea><br/>' . "\n";
                break;

            case 'checkbox':
                $checked = '';
                if ( $option && 'on' == $option ) {
                    $checked = 'checked="checked"';
                }
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
                break;

            case 'checkbox_multi':
                foreach ( $field['options'] as $k => $v ) {
                    $checked = false;
                    if ( in_array( $k, $data ) ) {
                        $checked = true;
                    }
                    $html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
                }
                break;

            case 'radio':
                foreach ( $field['options'] as $k => $v ) {
                    $checked = false;
                    if ( $k == $data ) {
                        $checked = true;
                    }
                    $html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
                }
                break;

            case 'select':
                $html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
                foreach ( $field['options'] as $k => $v ) {
                    $selected = false;
                    if ( $k == $data ) {
                        $selected = true;
                    }
                    $html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
                }
                $html .= '</select> ';
                break;

            case 'select_multi':
                $html .= '<select name="' . esc_attr( $option_name ) . '[]" id="' . esc_attr( $field['id'] ) . '" multiple="multiple">';
                foreach ( $field['options'] as $k => $v ) {
                    $selected = false;
                    if ( in_array( $k, $data ) ) {
                        $selected = true;
                    }
                    $html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '" />' . $v . '</label> ';
                }
                $html .= '</select> ';
                break;

            case 'image':
                $image_thumb = '';
                if ( $data ) {
                    $image_thumb = wp_get_attachment_thumb_url( $data );
                }
                $html .= '<img id="' . $option_name . '_preview" class="image_preview" src="' . $image_thumb . '" /><br/>' . "\n";
                $html .= '<input id="' . $option_name . '_button" type="button" data-uploader_title="' . __( 'Upload an image', 'tempale' ) . '" data-uploader_button_text="' . __( 'Use image', 'tempale' ) . '" class="image_upload_button button" value="' . __( 'Upload new image', 'tempale' ) . '" />' . "\n";
                $html .= '<input id="' . $option_name . '_delete" type="button" class="image_delete_button button" value="' . __( 'Remove image', 'tempale' ) . '" />' . "\n";
                $html .= '<input id="' . $option_name . '" class="image_data_field" type="hidden" name="' . $option_name . '" value="' . $data . '"/><br/>' . "\n";
                break;

            case 'color':
                ?>
                <div class="color-picker" style="position:relative;">
                    <input type="text" name="<?php esc_attr_e( $option_name ); ?>" class="color" value="<?php esc_attr_e( $data ); ?>"/>
                    <div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>
                </div>
                <?php
                break;

        }

        switch ( $field['type'] ) {

            case 'checkbox_multi':
            case 'radio':
            case 'select_multi':
                $html .= '<br/><span class="description">' . $field['description'] . '</span>';
                break;

            default:
                $html .= '<label for="' . esc_attr( $field['id'] ) . '"><span class="description">' . $field['description'] . '</span></label>' . "\n";
                break;
        }

        echo $html;
    }

    /**
     * Validate individual settings field
     *
     * @param  string $data Inputted value
     *
     * @return string       Validated value
     */
    public function validate_field( $data ) {
        if ( $data && strlen( $data ) > 0 && $data != '' ) {
            $data = urlencode( strtolower( str_replace( ' ', '-', $data ) ) );
        }

        return $data;
    }

    /**
     * Load settings page content
     * @return void
     */
    public function settings_page() {
        // Build page HTML
        $html = '<div class="wrap" id="ht_tempale_settings">' . "\n";
        $html .= '<h2>' . __( 'Content Email HT', 'mm' ) . '</h2>' . "\n";
        $html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";
        $html .= '<div class="clear"></div>' . "\n";

        // Get settings fields
        ob_start();
        settings_fields( 'ht_tempale_settings' );
        do_settings_sections( 'ht_tempale_settings' );
        $html .= ob_get_clean();

        $html .= '<p class="submit">' . "\n";
        $html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings', 'mm' ) ) . '" />' . "\n";
        $html .= '</p>' . "\n";
        $html .= '</form>' . "\n";
        $html .= '</div>' . "\n";

        echo $html;
    }

    public static function get_options( $key, $default = null ) {
        return get_option( $key, $default );
    }
}

tempaleEmail::instance();