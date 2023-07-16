<?php

//    ini_set('display_errors', 1);
//    ini_set('display_startup_errors', 1);
//    error_reporting(E_ALL);


	add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
	function theme_enqueue_styles() {
	    // Styles
		wp_enqueue_style( 'theme-style-less', get_template_directory_uri() . '/assets/css/styles.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'dataTables-style', get_stylesheet_directory_uri() . '/assets/css/jquery.dataTables.min.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'jquery-confirm-style', get_stylesheet_directory_uri() . '/assets/css/jquery-confirm.min.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'custom-bootstrap-style', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'custom-fontawesome-style', get_stylesheet_directory_uri() . '/assets/css/fontawesome.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'custom-intlTelInput-style', get_stylesheet_directory_uri() . '/assets/css/intlTelInput.css', NULL, STM_THEME_VERSION, 'all' );
//		wp_enqueue_style( 'custom-normalize-style', get_stylesheet_directory_uri() . '/assets/css/normalize.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'custom-theme-style', get_stylesheet_directory_uri() . '/assets/css/style.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'custom-theme-mobile-style', get_stylesheet_directory_uri() . '/assets/css/mobile-style.css', NULL, STM_THEME_VERSION, 'all' );


		// Scripts
        wp_enqueue_script('jquery-script', get_stylesheet_directory_uri() . '/assets/js/jquery.min.js', 'jquery', STM_THEME_VERSION, true );
        wp_enqueue_script('dataTables-script', get_stylesheet_directory_uri() . '/assets/js/jquery.dataTables.min.js', 'jquery', STM_THEME_VERSION, true );
        wp_enqueue_script('jquery-confirm-script', get_stylesheet_directory_uri() . '/assets/js/jquery-confirm.min.js', 'jquery', STM_THEME_VERSION, true );
        wp_enqueue_script('bootstrap-bundle-script', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', 'jquery', STM_THEME_VERSION, true );
        wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', 'jquery', STM_THEME_VERSION, true );
        wp_enqueue_script('intlTelInput-script', get_stylesheet_directory_uri() . '/assets/js/intlTelInput-jquery.min.js', 'jquery', STM_THEME_VERSION, true );
        wp_enqueue_script('utils-script', get_stylesheet_directory_uri() . '/assets/js/utils.js', 'jquery', STM_THEME_VERSION, true );
        wp_enqueue_script('bootstrap-notify-script', get_stylesheet_directory_uri() . '/assets/js/bootstrap-notify.min.js', 'jquery', STM_THEME_VERSION, true );
        wp_enqueue_script('custom-theme-script', get_stylesheet_directory_uri() . '/assets/js/script.js', 'jquery', STM_THEME_VERSION, true );


        // Animations
		if ( !wp_is_mobile() ) {
			wp_enqueue_style( 'theme-style-animation', get_template_directory_uri() . '/assets/css/animation.css', NULL, STM_THEME_VERSION, 'all' );
		}
		
		// Theme main stylesheet
		wp_enqueue_style( 'theme-style', get_stylesheet_uri(), null, STM_THEME_VERSION, 'all' );
		
		// FrontEndCustomizer
		wp_enqueue_style( 'skin_red_green', get_template_directory_uri() . '/assets/css/skins/skin_red_green.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'skin_blue_green', get_template_directory_uri() . '/assets/css/skins/skin_blue_green.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'skin_red_brown', get_template_directory_uri() . '/assets/css/skins/skin_red_brown.css', NULL, STM_THEME_VERSION, 'all' );
		wp_enqueue_style( 'skin_custom_color', get_template_directory_uri() . '/assets/css/skins/skin_custom_color.css', NULL, STM_THEME_VERSION, 'all' );
	}



// include Core Functions
require_once __DIR__ . '/inc/class-functions.php';

// include shortcodes
require_once __DIR__ . '/inc/class-shortcodes.php';

// include Ajax Calls
require_once __DIR__ . '/inc/class-ajax-calls.php';

// include frontend media upload
require_once __DIR__ . '/inc/class-frontend-media.php';

// include Test
require_once __DIR__ . '/inc/class-test.php';



function pre_dump($arr)
{

    echo '<pre>';
    var_dump($arr);
    echo '</pre>';

}

// function to display json in pretty way in html
function json_dump($json, $data_random_id = 1){
    ?>
    <pre style="background-color: #252532; margin: 2rem; border-radius: 10px; padding: 2rem; width: auto;" class="json_dump"><code class="json-container-<?= $data_random_id ?>" style="color: #30bdb6;"></code></pre>
    <script>

        var data_<?= $data_random_id ?> = <?= json_encode($json) ?>
        // document.getElementByClassName('json-container').innerHTML = JSON.stringify(data, null, 2);
        jQuery('.json-container-<?= $data_random_id ?>').html(JSON.stringify(data_<?= $data_random_id ?>, null, 2));

    </script>
    <?php
}


// add Q&A custom table

add_action("after_switch_theme", "mpe_after_activate");

function mpe_after_activate(){

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    // create Q and A table
    $table_name = $wpdb->prefix . "qa";  //get the database table prefix to create my new table

    $sql = "CREATE TABLE $table_name (
      id int(10) unsigned NOT NULL AUTO_INCREMENT,
      sender_id INT(10) NULL,
      receiver_id INT(10) NULL,
      title varchar(255) NULL,
      description TEXT DEFAULT '' NULL,
      status varchar(255) NULL,
      parent_qa INT NULL,
      created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
      updated_at varchar(100) DEFAULT '' NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta( $sql );


    // create notification table



}


// after user login join him to courses
function do_anything_after_login($login) {

    $user = get_userdatabylogin($login);
    //MPR_Core::join_student_basen_on_memberships($user->ID);
}
add_action('wp_login', 'do_anything_after_login');



/**********************************************************************************
 * Notifications Custom Post Type
 ***********************************************************************************/
// add cpt and custom taxoonomies
function create_kensa_notifications_cpt(){
    $labels = array(
        'name' => __('Notifications', 'Post Type General Name', 'kensa'),
        'singular_name' => __('Notification', 'Post Type Singular Name', 'kensa'),
        'menu_name' => __('Notifications' , 'kensa'),
        'name_admin_bar' => __('Notifications' , 'kensa'),
        'archives' => __('Notifications Archives' , 'kensa'),
        'attributes' => __('Notifications Attributes ' , 'kensa'),
        'parent_item_colon' => __('Parent Notifications ' , 'kensa'),
        'all_items' => __('All Notifications ' , 'kensa'),
        'add_new_item' => __('Add New Notification ' , 'kensa'),
        'add_new' => __('Add New ' , 'kensa'),
        'new_item' => __('New Notification ' , 'kensa'),
        'edit_item' => __('Edit Notification ' , 'kensa'),
        'update_item' => __('Update Notification ' , 'kensa'),
        'view_item' => __('View Notification ' , 'kensa'),
        'search_item' => __('Search Notification ' , 'kensa'),
        'not_found_in_trash' => __('No Notifications Found in trash' , 'kensa'),
        'featured_image' => __('Notification Featured Image' , 'kensa'),
        'set_featured_image' => __('Set Notification Featured Image' , 'kensa'),
        'remove_featured_image' => __('Remove Notification Featured Image' , 'kensa'),
        'use_featured_image' => __('Use as Notification Featured Image' , 'kensa'),
        'insert_into_item' => __('Insert into Notifications' , 'kensa'),
        'uploaded_to_this_item' => __('Uploaded to this Notifications' , 'kensa'),
        'items_list' => __('Notifications List' , 'kensa'),
        'items_list_navigation' => __('Notifications List Navigation' , 'kensa'),
        'filter_items_list' => __('Filter Notifications List' , 'kensa'),
    );

    $args = array(
        'label' => __('Notifications' , 'kensa'),
        'description' => __('Notifications Module' , 'kensa'),
        'labels' => $labels,
        'menu_icon' => 'dashicons-rest-api',
        'supports' => array('title', 'thumbnail', 'revisions', 'author', 'editor'),
//        'taxonomies' => array('category', 'post_tag'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'notifications')
    );

    register_post_type('notifications', $args);
}

add_action('init', 'create_kensa_notifications_cpt', 0);


function rewrite_kensa_notifications_flush(){
    create_kensa_notifications_cpt();
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'rewrite_kensa_notifications_flush');



function create_notifications_taxonomies() {
    $labels = array(
        'name'              => _x( 'Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'notifications_categories' ),
    );

    register_taxonomy( 'notifications_categories', array( 'notifications' ), $args );
}
add_action( 'init', 'create_notifications_taxonomies', 0 );


// show only media uploaded by current user
add_filter( 'ajax_query_attachments_args', 'show_current_user_attachments', 10, 1 );

function show_current_user_attachments( $query = array() ) {
    $user_id = get_current_user_id();
    if( $user_id ) {
        $query['author'] = $user_id;
    }
    return $query;
}


// after logout redirect to home

add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
    wp_safe_redirect( home_url() );
    exit;
}

add_action( 'login_form_logout', function () {
    $user = wp_get_current_user();

    wp_logout();

    if ( ! empty( $_REQUEST['redirect_to'] ) ) {
        $redirect_to = $requested_redirect_to = $_REQUEST['redirect_to'];
    } else {
        $redirect_to = 'wp-login.php?loggedout=true';
        $requested_redirect_to = '';
    }

    /**
     * Filters the log out redirect URL.
     *
     * @since 4.2.0
     *
     * @param string  $redirect_to           The redirect destination URL.
     * @param string  $requested_redirect_to The requested redirect destination URL passed as a parameter.
     * @param WP_User $user                  The WP_User object for the user that's logging out.
     */
    $redirect_to = apply_filters( 'logout_redirect', $redirect_to, $requested_redirect_to, $user );
    wp_safe_redirect( $redirect_to );
    exit;
});