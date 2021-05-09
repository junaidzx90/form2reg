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
        wp_localize_script( FORM2REG_NAME, 'admin_ajax_action', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ) );
    });

    // WP Enqueue Scripts
    add_action('wp_enqueue_scripts',function(){
        wp_register_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '', 'all' );
        wp_register_style( FORM2REG_NAME, plugin_dir_url( __FILE__ ).'public/css/form2reg-public.css', array(), microtime(), 'all' );

		wp_register_script( 'jquery.min', 'https://code.jquery.com/jquery-3.6.0.min.js', array(),
        '', true );
        wp_register_script( 'easing.min', plugin_dir_url( __FILE__ ).'public/js/easing.min.js', array(),
        microtime(), true );
        wp_register_script( FORM2REG_NAME, plugin_dir_url( __FILE__ ).'public/js/form2reg-public.js', array(), microtime(), true );
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
        add_settings_field( 'form2reg_form_width', 'Form Width', 'form2reg_form_width_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_form_width');

        //form2reg_user_role
        add_settings_field( 'form2reg_user_role', 'Define a role', 'form2reg_user_role_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_user_role');
        
        //form2reg_default_isa_id
        add_settings_field( 'form2reg_default_isa_id', 'Default ISA ID', 'form2reg_default_isa_id_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_default_isa_id');

        //form2reg_default_isa_number
        add_settings_field( 'form2reg_default_isa_number', 'Default ISA Number', 'form2reg_default_isa_number_func', 'form2reg_colors', 'form2reg_colors_section');
        register_setting( 'form2reg_colors_section', 'form2reg_default_isa_number');
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
        echo '<input type="text" value="'.(get_option("form2reg_form_width")?get_option("form2reg_form_width"):'550px').'" name="form2reg_form_width" placeholder="Form width">';
    }

    // form2reg_user_role_func
    function form2reg_user_role_func(){
        echo '<select name="form2reg_user_role">';
        echo wp_dropdown_roles( get_option("form2reg_user_role") );
        echo '</select>';
    }

    // form2reg_default_isa_id_func
    function form2reg_default_isa_id_func(){
        echo '<input type="text" value="'.(get_option("form2reg_default_isa_id")?get_option("form2reg_default_isa_id"):'').'" name="form2reg_default_isa_id" placeholder="Admin ID">';
        echo '<br><small>Default value <strong>1</strong></small>';
    }

    // form2reg_default_isa_number_func
    function form2reg_default_isa_number_func(){
        echo '<input type="text" value="'.(get_option("form2reg_default_isa_number")?get_option("form2reg_default_isa_number"):'').'" name="form2reg_default_isa_number" placeholder="Admin ISA Number">';
        echo '<br><small>Default value <strong>ISA1</strong></small>';
    }

    // get_introducer_name
    add_action("wp_ajax_get_introducer_name", "get_introducer_name");
    add_action("wp_ajax_nopriv_get_introducer_name", "get_introducer_name");
    function get_introducer_name(){
        if(wp_verify_nonce( $_POST['nonces'], 'nonces' ))
            if(isset($_POST['isanumber'])){
                $isanumber = sanitize_text_field( $_POST['isanumber'] );
                $introducer_user = get_user_by( 'login', $isanumber );
             
                if($introducer_user){
                    $avatar = get_avatar_url($introducer_user->ID);
                    $get_isanumber = $introducer_user->user_login;
                    
                    echo json_encode(array('name'=> $introducer_user->display_name, 'avatar' => $avatar, 'isanumber' => $get_isanumber));
                    
                    die;
                }else{
                    echo json_encode(array('error' => 'blank'));
                }
                die;
            }
        die;
    }
    
    // checking email address
    add_action("wp_ajax_check_user_exists", "check_user_exists");
    add_action("wp_ajax_nopriv_check_user_exists", "check_user_exists");
    function check_user_exists(){
        if(wp_verify_nonce( $_POST['nonces'], 'nonces' ))
            if(isset($_POST['email'])){
                if(!empty($_POST['email'])){
                    global $wpdb;
                    if(get_user_by_email( sanitize_email( $_POST['email']) )){
                        echo json_encode(array('exist' => 'exist')); 
                        die;
                    }else{
                        echo json_encode(array('granted' => 'granted'));
                        die;
                    }
                    die;
                }
                die;
            }
        die;
    }


    // checking gov_docs_number
    add_action("wp_ajax_check_gov_docs_number_exists", "check_gov_docs_number_exists");
    add_action("wp_ajax_nopriv_check_gov_docs_number_exists", "check_gov_docs_number_exists");
    function check_gov_docs_number_exists(){
        if(wp_verify_nonce( $_POST['nonces'], 'nonces' ))
            if(isset($_POST['gov_docs_number'])){
                if(!empty($_POST['gov_docs_number'])){
                    global $wpdb;
                    $identy_number = sanitize_text_field( $_POST['gov_docs_number'] );
                    $identity = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE meta_key = 'reg_billing_nic' AND meta_value = $identy_number");

                    if($identity){
                        echo json_encode(array('exist' => 'exist'));
                        die;
                    }else{
                        echo json_encode(array('granted' => 'granted'));
                        die;
                    }
                    die;
                }
                die;
            }
        die;
    }

    // Generate Unique ISA Number
    function form2reg_isa_generates($id = ''){
        global $wpdb;
        if(empty($id)){
            $username = "ISA1";
            $beforeuser = $wpdb->get_row("SELECT MAX( ID ) AS ID, user_nicename FROM {$wpdb->prefix}users");
        
            $prefix = substr(get_user_by( 'id', $beforeuser->ID )->user_nicename,0,3);

            if(!empty($prefix)){
                if($prefix == "isa" || $prefix == "ISA"){
                    $lastindexes = substr(get_user_by( 'id', $beforeuser->ID )->user_nicename,3);
                    $username = "ISA".($lastindexes+1);
                }else{
                    $username = "ISA1";
                }
            }
        }else{
            $username = get_user_by( 'id', $id )->user_login;
        }

        return $username;
    }

    // GET Default ISA Number
    add_action("wp_ajax_get_default_introducer_isa", "get_default_introducer_isa");
    add_action("wp_ajax_nopriv_get_default_introducer_isa", "get_default_introducer_isa");
    function get_default_introducer_isa(){
        if(wp_verify_nonce( $_POST['nonces'], 'nonces' )){
            $isa_number = get_option("form2reg_default_isa_number")? get_option("form2reg_default_isa_number"):'ISA1';
            $disaname = get_user_by( 'login', $isa_number )->display_name;
            
            echo json_encode(array('number' => $isa_number, 'name' => $disaname));
            die;
        }
        die;
    }

    // form2reg_register_user
    add_action("wp_ajax_form2reg_register_user", "form2reg_register_user");
    add_action("wp_ajax_nopriv_form2reg_register_user", "form2reg_register_user");
    function form2reg_register_user(){
        if(wp_verify_nonce( $_POST['nonces'], 'nonces' ))
            global $wpdb;
            $introducer_isa_number = get_option("form2reg_default_isa_id")?get_option("form2reg_default_isa_id"):'1';

            if(isset($_POST['data']['isa_num'])){
                $introducer_isa = sanitize_text_field( $_POST['data']['isa_num'] );
                if($u = get_user_by( 'login', $introducer_isa )){
                    $introducer_isa_number = $u->ID;
                }
            }
            
            $myisa = form2reg_isa_generates();
            $introducer_name = sanitize_text_field($_POST['data']['introducer']);
            $email = sanitize_email($_POST['data']['email']);
            $pass = sanitize_text_field($_POST['data']['pass']);
            $gender_ = sanitize_text_field($_POST['data']['gender_']);
            $id_type = sanitize_text_field($_POST['data']['id_type']);
            $id_number = sanitize_text_field($_POST['data']['id_number']);
            $iitialsname = sanitize_text_field($_POST['data']['iitialsname']);
            $fname = sanitize_text_field($_POST['data']['fname']);
            $phone_ = intval($_POST['data']['phone_']);
            $_state = sanitize_text_field($_POST['data']['_state']);
            $_city = sanitize_text_field($_POST['data']['_city']);
            $_zipcode = intval($_POST['data']['_zipcode']);
            $_addr_1 = sanitize_text_field($_POST['data']['_addr_1']);
            $_addr_2 = sanitize_text_field($_POST['data']['_addr_2']);

            $getuserdata = get_user_by_email( $email );
            
            if( $getuserdata ){
                echo 'User Exist';
                die;
            }
            
            if(!empty($introducer_isa_number) && !empty($introducer_name) && !empty($email) && !empty($pass) && !empty($gender_) && !empty($id_type) && !empty($id_number) && !empty($iitialsname) && !empty($fname) && !empty($phone_) && !empty($_state) && !empty($_city) && !empty($_zipcode) && !empty($_addr_1)){
                
                $userdata = array(
                    'user_login'    =>  $myisa,
                    'user_nicename'    =>  $myisa,
                    'user_email'     =>  $email,
                    'user_pass'     =>  $pass,
                    'role'          => (get_option('form2reg_user_role')?get_option('form2reg_user_role'):'subscriber'),
                    'show_admin_bar_front' => false
                );
                $user_id = wp_insert_user( $userdata );
                
                if(!$user_id){
                    echo 'Error';
                    die;
                }

                $usermeta = update_user_meta( $user_id, 'reg_billing_ncfull_name', $iitialsname );
                $usermeta = update_user_meta( $user_id, 'billing_first_name', $fname );
                $usermeta = update_user_meta( $user_id, 'billing_silver_introducer', $introducer_name );
                $usermeta = update_user_meta( $user_id, 'billing_gender', $gender_ );
                $usermeta = update_user_meta( $user_id, 'reg_billing_nicch', $id_type );
                $usermeta = update_user_meta( $user_id, 'reg_billing_nic', $id_number );
                $usermeta = update_user_meta( $user_id, 'billing_phone', $phone_ );
                $usermeta = update_user_meta( $user_id, 'billing_state', $_state );
                $usermeta = update_user_meta( $user_id, 'billing_city', $_city );
                $usermeta = update_user_meta( $user_id, 'billing_postcode', $_zipcode );
                $usermeta = update_user_meta( $user_id, 'billing_address_1', $_addr_1 );
                $usermeta = update_user_meta( $user_id, 'billing_address_2', $_addr_2 );

                $reffer_table = $wpdb->prefix.'refferels';
                if($introducer_isa_number){
                    $wpdb->insert(
                        $reffer_table,
                        array(
                            'parent_id' => $introducer_isa_number,
                            'user_id' => $user_id,
                            'isa_num' => form2reg_isa_generates($user_id),
                            'username' => form2reg_isa_generates($user_id),
                        ),
                        array('%d','%d','%s','%s')
                    );
                }

                global $wp_error;
                if(!is_wp_error($usermeta) || !is_wp_error($wpdb)){
                    if ( $myaccess = get_user_by_email( $email ) ) {
                        // check the user's login with their password.
                        if ( wp_check_password( $pass, $myaccess->user_pass, $myaccess->ID ) ) {
                            wp_clear_auth_cookie();
                            wp_set_current_user($myaccess->ID);
                            wp_set_auth_cookie($myaccess->ID);
                        }
                    }
                    echo $user_id;
                    die;
                }else{
                    delete_user_meta( $user_id, 'billing_first_name');
                    delete_user_meta( $user_id, 'billing_silver_introducer');
                    delete_user_meta( $user_id, 'billing_gender');
                    delete_user_meta( $user_id, 'reg_billing_nicch');
                    delete_user_meta( $user_id, 'billing_phone');
                    delete_user_meta( $user_id, 'billing_state');
                    delete_user_meta( $user_id, 'billing_state');
                    delete_user_meta( $user_id, 'billing_city');
                    delete_user_meta( $user_id, 'billing_postcode');
                    delete_user_meta( $user_id, 'billing_address_1');
                    delete_user_meta( $user_id, 'billing_address_2');
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
            <th><label for="billing_silver_introducer"><?php _e("Introducer Name"); ?></label></th>
            <td>
                <input readonly disabled type="text" name="billing_silver_introducer" id="billing_silver_introducer" value="<?php echo esc_attr( get_the_author_meta( 'billing_silver_introducer', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Introducer Name."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="Gender"><?php _e("Gender"); ?></label></th>
            <td>
                <select name="billing_gender" id="billing_gender">
                    <?php
                    if(get_the_author_meta( 'billing_gender', $user->ID )){
                        echo '<option selected value="'.strtolower( get_the_author_meta( 'billing_gender', $user->ID ) ).'">'.esc_attr( ucfirst(get_the_author_meta( 'billing_gender', $user->ID) ) ).'</option>';
                    }
                    ?>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select><br />
                <span class="description"><?php _e("User Gender."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="reg_billing_nicch"><?php _e("City"); ?></label></th>
            <td>
                <select name="reg_billing_nicch" id="reg_billing_nicch"> 
                    <?php
                    if(get_the_author_meta( 'reg_billing_nicch', $user->ID )){
                        echo '<option selected value="'.strtolower( get_the_author_meta( 'reg_billing_nicch', $user->ID ) ).'">'.esc_attr( ucfirst(get_the_author_meta( 'reg_billing_nicch', $user->ID) ) ).'</option>';
                    }
                    ?>
                    <option value="">Select</option> 
                    <option value="nid">NID</option> 
                    <option value="passp">Passport</option>
                    <option value="dlicense">Driving License</option>
                </select><br />
                <span class="description"><?php _e("ID Type."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="reg_billing_nic"><?php _e("Identity Number"); ?></label></th>
            <td>
                <input type="text" name="reg_billing_nic" id="reg_billing_nic" value="<?php echo esc_attr( get_the_author_meta( 'reg_billing_nic', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your identity number."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="billing_phone"><?php _e("Phone Number"); ?></label></th>
            <td>
                <input type="text" name="billing_phone" id="billing_phone" value="<?php echo ( get_the_author_meta( 'billing_phone', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Phone number."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="billing_state"><?php _e("District"); ?></label></th>
            <td>
                <select class="input-text ncselect" name="billing_state"> 
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
                <span class="description"><?php _e("Billing state."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="billing_city"><?php _e("City"); ?></label></th>
            <td>
                <input type="text" name="billing_city" id="billing_city" value="<?php echo esc_attr( get_the_author_meta( 'billing_city', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your city."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="billing_postcode"><?php _e("Postal Code"); ?></label></th>
            <td>
                <input type="text" name="billing_postcode" id="billing_postcode" value="<?php echo esc_attr( get_the_author_meta( 'billing_postcode', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Postalcode."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="billing_address_1"><?php _e("Address Line 1"); ?></label></th>
            <td>
                <input type="text" name="billing_address_1" id="billing_address_1" value="<?php echo esc_attr( get_the_author_meta( 'billing_address_1', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Address line 1."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="billing_address_2"><?php _e("Address Line 2"); ?></label></th>
            <td>
                <input type="text" name="billing_address_2" id="billing_address_2" value="<?php echo esc_attr( get_the_author_meta( 'billing_address_2', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Address line 2."); ?></span>
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

        //update_user_meta( $user_id, 'billing_silver_introducer', $_POST['billing_first_name'] );
        update_user_meta( $user_id, 'billing_gender', $_POST['billing_gender'] );
        update_user_meta( $user_id, 'reg_billing_nicch', $_POST['reg_billing_nicch'] );
        update_user_meta( $user_id, 'reg_billing_nic', $_POST['reg_billing_nic'] );
        update_user_meta( $user_id, 'billing_phone', $_POST['billing_phone'] );
        update_user_meta( $user_id, 'billing_state', $_POST['billing_state'] );
        update_user_meta( $user_id, 'billing_city', $_POST['billing_city'] );
        update_user_meta( $user_id, 'billing_postcode', $_POST['billing_postcode'] );
        update_user_meta( $user_id, 'billing_address_1', $_POST['billing_address_1'] );
        update_user_meta( $user_id, 'billing_address_2', $_POST['billing_address_2'] );
    }

    // form2reg_reset_colors
    add_action("wp_ajax_form2reg_reset_colors", "form2reg_reset_colors");
    add_action("wp_ajax_nopriv_form2reg_reset_colors", "form2reg_reset_colors");
    function form2reg_reset_colors(){
        delete_option( 'form2reg_form_bg' );
        delete_option( 'form2reg_body_bg' );
        delete_option( 'form2reg_form_title' );
        delete_option( 'form2reg_form_label' );
        delete_option( 'form2reg_next_button' );
        delete_option( 'form2reg_form_width' );
        delete_option( 'form2reg_user_role' );
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