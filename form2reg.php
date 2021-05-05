<?php
 /**
 *
 * @link              https://github.com/
 * @since             1.0.0
 * @package           form2reg
 *
 * @wordpress-plugin
 * Plugin Name:       Form2Reg
 * Plugin URI:        https://github.com/form2reg/form2reg
 * Description:       This is a custom plugin, it's used for multiform registration.
 * Version:           1.0.0
 * Author:            Junayedzx90
 * Author URI:        https://www.fiverr.com/junaidzx90
 * Text Domain:       form2reg
 * Domain Path:       /languages
 */

// If this file is called directly, abort.

define( 'FORM2REG_NAME', 'form2reg' );
define( 'FORM2REG_PATH', plugin_dir_path( __FILE__ ) );

if ( ! defined( 'WPINC' ) && ! defined('FORM2REG_NAME') && ! defined('FORM2REG_NAME_PATH')) {
	die;
}

add_action( 'plugins_loaded', 'form2reg_init' );
function form2reg_init() {
    load_plugin_textdomain( 'form2reg', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    add_action('init', 'form2reg_run');
}

// Main Function iitialize
function form2reg_run(){

    register_activation_hook( __FILE__, 'activate_form2reg_cplgn' );
    register_deactivation_hook( __FILE__, 'deactivate_form2reg_cplgn' );

    // Activision function
    function activate_form2reg_cplgn(){
        // global $wpdb;
        // require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    }

    // Dectivision function
    function deactivate_form2reg_cplgn(){
        // Nothing For Now
    }

    // Admin Enqueue Scripts
    add_action('admin_enqueue_scripts',function(){
        wp_register_script( FORM2REG_NAME, plugin_dir_url( __FILE__ ).'admin/js/form2reg-admin.js', array(), 
        microtime(), true );
        wp_enqueue_script(FORM2REG_NAME);
        wp_localize_script( FORM2REG_NAME, 'admin_ajax_action', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ) );
    });

    // WP Enqueue Scripts
    add_action('wp_enqueue_scripts',function(){
        wp_register_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '', 'all' );
        wp_register_style( FORM2REG_NAME, plugin_dir_url( __FILE__ ).'public/css/form2reg-public.css', array(), microtime(), 'all' );
        wp_enqueue_style('fontawesome');
        wp_enqueue_style(FORM2REG_NAME);

		wp_register_script( 'jquery.min', 'https://code.jquery.com/jquery-3.6.0.min.js', array(),
        '', true );
        wp_enqueue_script('jquery.min');
        wp_register_script( 'easing.min', plugin_dir_url( __FILE__ ).'public/js/easing.min.js', array(),
        microtime(), true );
        wp_enqueue_script('easing.min');
        wp_register_script( FORM2REG_NAME, plugin_dir_url( __FILE__ ).'public/js/form2reg-public.js', array(),
        microtime(), true );
        wp_enqueue_script(FORM2REG_NAME);
        wp_localize_script( FORM2REG_NAME, 'public_ajax_action', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'nonces' )
        ) );
    });

    // Register Menu
    add_action('admin_menu', function(){
        add_menu_page( 'Form2Reg', 'Form2Reg', 'manage_options', 'form2reg', 'form2reg_menupage_display', 'dashicons-text', 45 );
    
        // For colors
        add_settings_section( 'form2reg_colors_section', 'Form Background', '', 'form2reg_colors' );
    
        //form2reg_body_bg
        add_settings_field( 'form2reg_body_bg', 'Body Background', 'form2reg_body_bg_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_body_bg');

        //form2reg_form_bg
        add_settings_field( 'form2reg_form_bg', 'Form Background', 'form2reg_form_bg_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_form_bg');

        //form2reg_form_title
        add_settings_field( 'form2reg_form_title', 'Form Title color', 'form2reg_form_title_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_form_title');

        //form2reg_form_label
        add_settings_field( 'form2reg_form_label', 'Form labels color', 'form2reg_form_label_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_form_label');

        //form2reg_next_button
        add_settings_field( 'form2reg_next_button', 'Next button bg', 'form2reg_next_button_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_next_button');

        //form2reg_form_width
        add_settings_field( 'form2reg_form_width', 'Form Background', 'form2reg_form_width_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_form_width');
    });

    // form2reg_form_bg_func
    function form2reg_form_bg_func(){
        echo '<input type="color" value="'.(get_option("form2reg_form_bg")?get_option("form2reg_form_bg"):'#ffffff').'" name="form2reg_form_bg">';
    }

    // form2reg_form_title_func
    function form2reg_form_title_func(){
        echo '<input type="color" value="'.(get_option("form2reg_form_title")?get_option("form2reg_form_title"):'#2c3e50').'" name="form2reg_form_title">';
    }

    // form2reg_form_label_func
    function form2reg_form_label_func(){
        echo '<input type="color" value="'.(get_option("form2reg_form_label")?get_option("form2reg_form_label"):'#777').'" name="form2reg_form_label">';
    }

    // form2reg_next_button_func
    function form2reg_next_button_func(){
        echo '<input type="color" value="'.(get_option("form2reg_next_button")?get_option("form2reg_next_button"):'#ff9a76').'" name="form2reg_next_button">';
    }

    // form2reg_body_bg_func
    function form2reg_body_bg_func(){
        echo '<input type="color" value="'.(get_option("form2reg_body_bg")?get_option("form2reg_body_bg"):'#f5f5f5').'" name="form2reg_body_bg">';
    }

    // form2reg_form_width_func
    function form2reg_form_width_func(){
        echo '<input type="text" value="'.(get_option("form2reg_form_width")?get_option("form2reg_form_width"):'550px').'" name="form2reg_form_width">';
    }

    // get_introducer_name
    add_action("wp_ajax_get_introducer_name", "get_introducer_name");
    add_action("wp_ajax_nopriv_get_introducer_name", "get_introducer_name");
    function get_introducer_name(){
        if(wp_verify_nonce( $_POST['nonces'], 'nonces' ))
            if(isset($_POST['isanumber'])){
                if(!empty($_POST['isanumber'])){
                    global $wpdb,$wp_error;
                    // admin 876567
                    $isanumber = wp_specialchars( $_POST['isanumber'] );
                    $introducer_user = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}usermeta WHERE `meta_key` = 'my_isa_number' AND `meta_value` = `$isanumber`");

                    if(is_wp_error( $wpdb )){
                        echo json_encode(array('error' => 'blank'));
                        die;
                    }
                }
                if($introducer_user){
                    $introducer_user_id = $introducer_user->user_id;
                    $user_name = get_user_by( 'id', $introducer_user_id )->display_name;
                    $avatar = get_avatar_url($introducer_user_id);
                    $get_isanumber = get_user_meta($introducer_user_id, 'my_isa_number', true);
                    
                    echo json_encode(array('name'=> $user_name, 'avatar' => $avatar, 'isanumber' => $get_isanumber));
                    
                    die;
                }else{
                    echo json_encode(array('error' => 'blank'));
                }
                die;
            }
        die;
    }
    
    // get_introducer_name
    add_action("wp_ajax_check_user_exists", "check_user_exists");
    add_action("wp_ajax_nopriv_check_user_exists", "check_user_exists");
    function check_user_exists(){
        if(wp_verify_nonce( $_POST['nonces'], 'nonces' ))
            if(isset($_POST['email'])){
                if(!empty($_POST['email'])){
                    global $wpdb;
                    if(get_user_by_email( sanitize_email( $_POST['email']) )){
                        echo 'exist';
                    }else{
                        echo 'granted';
                    }
                    die;
                }
                die;
            }
        die;
    }

    // form2reg_register_user
    add_action("wp_ajax_form2reg_register_user", "form2reg_register_user");
    add_action("wp_ajax_nopriv_form2reg_register_user", "form2reg_register_user");
    function form2reg_register_user(){
        if(wp_verify_nonce( $_POST['nonces'], 'nonces' ))

            $isa_num = rand(5,9999);
            $introducer = sanitize_text_field($_POST['data']['introducer']);
            $email = sanitize_email($_POST['data']['email']);
            $pass = sanitize_text_field($_POST['data']['pass']);
            $gender_ = sanitize_text_field($_POST['data']['gender_']);
            $id_type = sanitize_text_field($_POST['data']['id_type']);
            $id_number = sanitize_text_field($_POST['data']['id_number']);
            $fname = sanitize_text_field($_POST['data']['fname']);
            $phone_ = intval($_POST['data']['phone_']);
            $_state = sanitize_text_field($_POST['data']['_state']);
            $_city = sanitize_text_field($_POST['data']['_city']);
            $_zipcode = intval($_POST['data']['_zipcode']);
            $_addr_1 = sanitize_text_field($_POST['data']['_addr_1']);
            $_addr_2 = sanitize_text_field($_POST['data']['_addr_2']);

            if(!empty($isa_num) && !empty($introducer) && !empty($email) && !empty($pass) && !empty($gender_) && !empty($id_type) && !empty($id_number) && !empty($fname) && !empty($phone_) && !empty($_state) && !empty($_city) && !empty($_zipcode) && !empty($_addr_1) && !empty($_addr_2)){
                $userdata = array(
                    'user_login'    =>  $fname,
                    'user_email'     =>  $email,
                    'user_pass'     =>  $pass,
                    'role'          => (get_option('form2reg_user_role')?get_option('form2reg_user_role'):'subscriber'),
                    'show_admin_bar_front' => false
                );
                $user_id = wp_insert_user( $userdata );
                
                $usermeta = update_user_meta( $user_id, 'my_isa_number', $isa_num );
                $usermeta = update_user_meta( $user_id, 'gender', $gender_ );
                $usermeta = update_user_meta( $user_id, 'gov_id_type', $id_type );
                $usermeta = update_user_meta( $user_id, 'identity_number', $id_number );
                $usermeta = update_user_meta( $user_id, 'phone_number', $phone_ );
                $usermeta = update_user_meta( $user_id, 'billing_state', $_state );
                $usermeta = update_user_meta( $user_id, 'city', $_city );
                $usermeta = update_user_meta( $user_id, 'postalcode', $_zipcode );
                $usermeta = update_user_meta( $user_id, 'address_line_1', $_addr_1 );
                $usermeta = update_user_meta( $user_id, 'address_line_2', $_addr_2 );
                global $wp_error;
                if(!is_wp_error($usermeta)){
                    echo $user_id;
                    die;
                }else{
                    delete_user_meta( $user_id, 'my_isa_number');
                    delete_user_meta( $user_id, 'gender');
                    delete_user_meta( $user_id, 'gov_id_type');
                    delete_user_meta( $user_id, 'identity_number');
                    delete_user_meta( $user_id, 'phone_number');
                    delete_user_meta( $user_id, 'billing_state');
                    delete_user_meta( $user_id, 'city');
                    delete_user_meta( $user_id, 'postalcode');
                    delete_user_meta( $user_id, 'address_line_1');
                    delete_user_meta( $user_id, 'address_line_2');
                    wp_delete_user( $user_id );
                }
                die;
            }
        die;
    }


    add_action( 'show_user_profile', 'extra_user_profile_fields' );
    add_action( 'edit_user_profile', 'extra_user_profile_fields' );

    function extra_user_profile_fields( $user ) { ?>
        <h3><?php _e("Form2Reg user informations", "blank"); ?></h3>

        <table class="form-table">
        <tr>
            <th><label for="introducer_isa"><?php _e("Introducer ISA"); ?></label></th>
            <td>
                <input type="text" name="introducer_isa" id="introducer_isa" value="<?php echo esc_attr( get_the_author_meta( 'my_isa_number', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your Introducer isa."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="Gender"><?php _e("Gender"); ?></label></th>
            <td>
                <select name="gender" id="gender">
                    <?php
                    if(get_the_author_meta( 'gender', $user->ID )){
                        echo '<option selected value="'.strtolower( get_the_author_meta( 'gender', $user->ID ) ).'">'.esc_attr( ucfirst(get_the_author_meta( 'gender', $user->ID) ) ).'</option>';
                    }
                    ?>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select><br />
                <span class="description"><?php _e("Please enter your Gender."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="gov_id_type"><?php _e("City"); ?></label></th>
            <td>
                <select name="gov_id_type" id="gov_id_type"> 
                    <?php
                    if(get_the_author_meta( 'gov_id_type', $user->ID )){
                        echo '<option selected value="'.strtolower( get_the_author_meta( 'gov_id_type', $user->ID ) ).'">'.esc_attr( ucfirst(get_the_author_meta( 'gov_id_type', $user->ID) ) ).'</option>';
                    }
                    ?>
                    <option value="">Select</option> 
                    <option value="nid">NID</option> 
                    <option value="passp">Passport</option>
                    <option value="dlicense">Driving License</option>
                </select><br />
                <span class="description"><?php _e("Please enter your ID Type."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="identity_number"><?php _e("Identity Number"); ?></label></th>
            <td>
                <input type="text" name="identity_number" id="identity_number" value="<?php echo esc_attr( get_the_author_meta( 'identity_number', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your identity number."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="phone_number"><?php _e("Phone Number"); ?></label></th>
            <td>
                <input type="text" name="phone_number" id="phone_number" value="<?php echo ( get_the_author_meta( 'phone_number', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your phone number."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="billing_state"><?php _e("District"); ?></label></th>
            <td>
                <select class="input-text ncselect" name="billing_state" id="billing_state"> 
                    <?php
                    if(get_the_author_meta( 'billing_state', $user->ID )){
                        echo '<option selected value="'.strtolower( get_the_author_meta( 'billing_state', $user->ID ) ).'">'.esc_attr( ucfirst(get_the_author_meta( 'billing_state', $user->ID) ) ).'</option>';
                    }
                    ?>
                    <option value="Colombo">Colombo</option>
                    <option value="Gampaha">Gampaha</option>
                    <option value="Kalutara">Kalutara</option>
                    <option value="Kandy">Kandy</option>
                    <option value="Matale">Matale</option>
                    <option value="Nuwara-Eliya">Nuwara-Eliya</option>
                    <option value="Batticaloa">Batticaloa</option>
                    <option value="Trincomalee">Trincomalee</option>
                    <option value="Ampara">Ampara</option>
                    <option value="Jaffna">Jaffna</option>
                    <option value="Mannar">Mannar</option>
                    <option value="Mullaitivu">Mullaitivu</option>
                    <option value="Vavuniya">Vavuniya</option>
                    <option value="Anuradhapura">Anuradhapura</option>
                    <option value="Polonnaruwa">Polonnaruwa</option>
                    <option value="Kurunegala">Kurunegala</option>
                    <option value="Puttalam">Puttalam</option>
                    <option value="Ratnapura">Ratnapura</option>
                    <option value="Kegalle">Kegalle</option>
                    <option value="Galle">Galle</option>
                    <option value="Galle">Galle</option>
                    <option value="Matara">Matara</option>
                    <option value="Hambantota">Hambantota</option>
                    <option value="Badulla">Badulla</option>
                    <option value="Monaragala">Monaragala</option>
                    <option value="Kilinochchi">Kilinochchi</option>
                </select><br />
                <span class="description"><?php _e("Please enter your billing state."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="city"><?php _e("City"); ?></label></th>
            <td>
                <input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your city."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="postalcode"><?php _e("Postal Code"); ?></label></th>
            <td>
                <input type="text" name="postalcode" id="postalcode" value="<?php echo esc_attr( get_the_author_meta( 'postalcode', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your postal code."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="address_line_1"><?php _e("Address Line 1"); ?></label></th>
            <td>
                <input type="text" name="address_line_1" id="address_line_1" value="<?php echo esc_attr( get_the_author_meta( 'address_line_1', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your address line 1."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="address_line_2"><?php _e("Address Line 2"); ?></label></th>
            <td>
                <input type="text" name="address_line_2" id="address_line_2" value="<?php echo esc_attr( get_the_author_meta( 'address_line_2', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your address line 2."); ?></span>
            </td>
        </tr>
        </table>
    <?php 
    }

    add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
    add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

    function save_extra_user_profile_fields( $user_id ) {
        if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
            return;
        }
        
        if ( !current_user_can( 'edit_user', $user_id ) ) { 
            return false; 
        }
        update_user_meta( $user_id, 'my_isa_number', $_POST['my_isa_number'] );
        update_user_meta( $user_id, 'gender', $_POST['gender'] );
        update_user_meta( $user_id, 'gov_id_type', $_POST['gov_id_type'] );
        update_user_meta( $user_id, 'identity_number', $_POST['identity_number'] );
        update_user_meta( $user_id, 'phone_number', $_POST['phone_number'] );
        update_user_meta( $user_id, 'billing_state', $_POST['billing_state'] );
        update_user_meta( $user_id, 'city', $_POST['city'] );
        update_user_meta( $user_id, 'postalcode', $_POST['postalcode'] );
        update_user_meta( $user_id, 'address_line_1', $_POST['address_line_1'] );
        update_user_meta( $user_id, 'address_line_2', $_POST['address_line_2'] );
    }

    // form2reg_reset_colors
    add_action("wp_ajax_form2reg_reset_colors", "form2reg_reset_colors");
    add_action("wp_ajax_nopriv_form2reg_reset_colors", "form2reg_reset_colors");
    function form2reg_reset_colors(){
        delete_option( 'form2reg_form_bg' );
        delete_option( 'form2reg_body_bg' );
        delete_option( 'form2reg_form_width' );
        echo 'Success';
        wp_die();
    }

    // Menu callback funnction
    function form2reg_menupage_display(){
        wp_enqueue_script(FORM2REG_NAME);
        ?>
        <style>
            p.submit { display: inline-block; }
            button#rest_color { padding: 7px 10px; background: red; border: none; outline: none; border-radius: 3px; margin-left: 10px; color: #fff; cursor: pointer; opacity: .7; } button#rest_color:hover{ opacity: 1;}
        </style>
        <?php
        echo '<form action="options.php" method="post" id="form2reg_colors">';
        echo '<h1>Form2Reg Colors</h1><hr>';
        echo '<table class="form-table">';

        settings_fields( 'form2reg_colors_section' );
        do_settings_fields( 'form2reg_colors', 'form2reg_colors_section' );
        
        echo '</table>';
        submit_button();
        echo '<button id="rest_color">Reset</button>';
        echo '</form>';
    }

    add_shortcode( 'form2reg_v1', 'form2reg_display_view' );
    require_once FORM2REG_PATH.'public/form2reg-display.php';
}