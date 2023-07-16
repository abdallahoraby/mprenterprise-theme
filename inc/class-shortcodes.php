<?php

// shortcode for login and register template
function login_register_page() {
    // check if user is logged in, redirect to dashboard ( instructor - learner )
    if( is_user_logged_in() == true ):
        // redirest to dashboard
        wp_safe_redirect(site_url() . '/dashboard');
        //get_template_part('template-parts/template-dashboard');
    else:
        get_template_part('template-parts/template-login-register');
    endif;
}
add_shortcode('login_register_page', 'login_register_page');



// shortcode for dashboard
function mpr_dashboard(){
    get_template_part('template-parts/template-dashboard');
}
add_shortcode('mpr_dashboard', 'mpr_dashboard');

// shortcode for intructor dashboard
function instructor_dashboard(){
    get_template_part('template-parts/template-instructor-dashboard');
}
add_shortcode('instructor_dashboard', 'instructor_dashboard');



// shortcode for live sessions calendar
function list_live_sessions(){

    get_template_part('template-parts/template-list-live-sessions');


}
add_shortcode('list_live_sessions', 'list_live_sessions');


// shortcode for custom logout url
function bt_custom_logout_link ($atts) {
    $link = '<a href="' . wp_logout_url('/') . '" title="Logout">Logout</a>';
    return $link;
}
add_shortcode('bt_custom_logout_link', 'bt_custom_logout_link');






