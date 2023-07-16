<div class="dashboard-content">

    <?php

        if( is_user_logged_in() == true ):

            // check user role and load right template for him
            $user = wp_get_current_user();
            MPR_Core::join_student_basen_on_memberships($user->ID);
            if ( in_array( 'stm_lms_instructor', (array) $user->roles ) ):
                //The user has the "Instructor" role and is approved
                $status = get_user_meta($user->ID, 'admin_approval', true);
                if( $status == true ):
                    get_template_part('template-parts/template-instructor-dashboard');
                else:
                    get_template_part('template-parts/template-not-approved-instructor');
                endif;
            else:
                get_template_part('template-parts/template-learner-dashboard');
            endif;

        else:
            wp_safe_redirect(site_url() . '/login-register');
        endif;


        // if admin show admin tools btn
        if ( in_array( 'administrator', (array) $user->roles ) ):
            echo "<a href='#' class='admin-tools-btn'> Admin Tools </a>";
        endif;

    ?>

</div>

<style>

    a.admin-tools-btn {
        background: var(--bg-gradient);
        color: #fff;
        font-size: 1.1rem;
        margin: 2rem auto;
        display: flex;
        width: fit-content;
        padding: 1rem 2rem;
        border-radius: 10px;
    }

</style>

<script>

    jQuery(".admin-tools-btn").on("click", function(e){
        e.preventDefault();
        jQuery('.ajax-loader').show();
        // load template admin dashboard
        jQuery.post(ajaxurl, {
            action: 'show_admin_tools',
        }, function (response){ // response callback function
            jQuery('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
        .done(function(response) {
            //alert( "second success" );
        });

    });

</script>