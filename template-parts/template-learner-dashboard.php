<section class="instructor-dashboard-page">

    <?php get_template_part('template-parts/template-dashboard-top-section') ?>

    <?php

    $user_courses = STM_LMS_User::_get_user_courses(0, 'date_low');

    $course_categories = get_terms( array(
        'taxonomy' => 'stm_lms_course_taxonomy',
        'hide_empty' => false,
    ) );

    $allowed_categories = MPR_Core::get_learner_allowed_categories( get_current_user_id() );


    if( !empty($allowed_categories) ):

        $user_courses_categories = array_column($user_courses['posts'], 'terms_list');
        if(!empty($user_courses_categories)):
            foreach ( $user_courses_categories as $user_courses_category ):
                $user_courses_categories_list[] = $user_courses_category[0];
            endforeach;
        else:
            echo '<div class="text-center"> No courses found. </div>';
            return;
        endif;

    else:
        echo "<span class='text-center'> No courses found. </span>";
        return;
    endif;


    ?>

    <?php if(empty($user_courses)): ?>
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Info:"><use xlink:href="#info-fill"></use></svg>
            <div>
                No available courses.
            </div>
        </div>

    <?php else: ?>

        <div class="learner-dashboard-bottom">

            <ul class="tabs">
                <?php foreach ( $course_categories as $course_category ): ?>
                    <?php
                        if( in_array( strtolower($course_category->name), $allowed_categories) ):
                            $enable_tab = 'enabled';
                        else:
                            $enable_tab = 'disabled';
                        endif;
                    ?>
                    <li class="heading-font <?= $enable_tab ?>" rel="<?= $course_category->term_id ?>"> <?= $course_category->name ?> </li>
                <?php endforeach; ?>

            </ul>

            <div class="tab_container">

                <?php foreach ( $course_categories as $course_category ): ?>
                    <?php
                        if( in_array( strtolower($course_category->name), $allowed_categories) ):
                            $enable_tab = 'enabled';
                        else:
                            $enable_tab = 'disabled';
                        endif;
                    ?>
                    <h3 class="tab_drawer_heading <?= $enable_tab ?>" rel="<?= $course_category->term_id ?>"> <?= strtoupper($course_category->name) ?>  </h3>
                    <div id="<?= $course_category->term_id ?>" class="tab_content <?= $enable_tab ?>">

                        <div class="row bottom-cards">

                            <?php if( $enable_tab == 'disabled' ): ?>
                                <p class="text-center"> No Data Available. </p>
                            <?php else: ?>
                                <main class="page-content">
                                <div class="card get-courses" data-term-id="<?= $course_category->term_id ?>">
                                    <div class="content">
                                        <h2 class="title">
                                            <img class="card-icons" src="<?= get_stylesheet_directory_uri() ?>/assets/img/course-icon.png" alt="">
                                            <span> + COURSE </span>
                                        </h2>
                                        <p class="copy"> select </p>
                                        <button class="btn"> <i class="fa-solid fa-arrow-right-long"></i> </button>
                                    </div>
                                </div>
                                <div class="card get-learner-live-sessions">
                                    <div class="content">
                                        <h2 class="title">
                                            <img class="card-icons" src="<?= get_stylesheet_directory_uri() ?>/assets/img/live-sessions-icon.png" alt="">
                                            <span> + LIVE SESSION </span>
                                        </h2>
                                        <p class="copy"> select </p>
                                        <button class="btn"> <i class="fa-solid fa-arrow-right-long"></i> </button>
                                    </div>
                                </div>
                                <div class="card get-learner-assignments" data-term-id="<?= $course_category->term_id ?>">
                                    <div class="content">
                                        <h2 class="title">
                                            <img class="card-icons" src="<?= get_stylesheet_directory_uri() ?>/assets/img/assignment-icon.png" alt="">
                                            <span> + ASSIGNMENT </span>
                                        </h2>
                                        <p class="copy"> select </p>
                                        <button class="btn"> <i class="fa-solid fa-arrow-right-long"></i> </button>
                                    </div>
                                </div>
                                <div class="card get-learner-qa">
                                    <div class="content">
                                        <h2 class="title">
                                            <img class="card-icons" src="<?= get_stylesheet_directory_uri() ?>/assets/img/q_and_a_icon.png" alt="">
                                            <span> Q & A </span>
                                        </h2>
                                        <p class="copy"> select </p>
                                        <button class="btn"> <i class="fa-solid fa-arrow-right-long"></i> </button>
                                    </div>
                                </div>

                                <div class="card get-learner-certificates">
                                    <div class="content">
                                        <h2 class="title">
                                            <img class="card-icons" src="<?= get_stylesheet_directory_uri() ?>/assets/img/q_and_a_icon.png" alt="">
                                            <span> Certificates </span>
                                        </h2>
                                        <p class="copy"> select </p>
                                        <button class="btn"> <i class="fa-solid fa-arrow-right-long"></i> </button>
                                    </div>
                                </div>


                            </main>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- #tab1 -->
                <?php endforeach; ?>

            </div>
            <!-- .tab_container -->

        </div>

    <?php endif; ?>


</section>


<style>
    ul.tabs {
        margin: 0;
        padding: 0;
        list-style: none;
        width: 100%;
        background: #3D5766;
        border-top-left-radius: 30px !important;
        border-top-right-radius: 30px !important;
        float: left;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-flow: row;
    }

    ul.tabs li {
        cursor: pointer;
        height: auto;
        line-height: inherit;
        color: #fff;
        overflow: hidden;
        position: relative;
        flex: 0 100%;
        float: unset;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 1.5rem;
        border-radius: inherit;
    }

    .disabled {
        cursor: not-allowed !important;
        opacity: 0.5;
    }

    .tab_last { border-right: 1px solid #333; }

    ul.tabs li:hover {
        background-color: #ccc;
        color: #333;
    }

    ul.tabs li.active {
        background-color: #F5F8FA;
        color: #333;
        display: block;
        font-weight: bold;
    }

    .tab_container {
        border: 1px solid #E8EDF0;
        border-top: none;
        clear: both;
        float: left;
        width: 100%;
        background: #fff;
        overflow: auto;
        padding: 2rem;
    }

    .tab_content {
        padding: 20px;
        display: none;
    }

    .tab_drawer_heading { display: none; }

    @media screen and (max-width: 768px) {

        .tabs {
            display: none;
        }

        ul.tabs{
            flex-flow: column;
            display: none;
        }

        .tab_drawer_heading {
            background-color: #3D5766;
            color: #fff;
            border-top: 1px solid #333;
            margin: 0;
            padding: 5px 20px;
            display: block;
            cursor: pointer;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            font-size: 1rem;
        }
        .d_active {
            background-color: #F5F8FA;
            color: #333;
        }
    }


    .card:nth-child(1):before {
        background-image: url(<?= get_stylesheet_directory_uri() ?>/assets/img/courses.png);
    }
    .card:nth-child(2):before {
        background-image: url(<?= get_stylesheet_directory_uri() ?>/assets/img/live-sessions.png);
    }
    .card:nth-child(3):before {
        background-image: url(<?= get_stylesheet_directory_uri() ?>/assets/img/assignments.png);
    }
    .card:nth-child(4):before {
        background-image: url(<?= get_stylesheet_directory_uri() ?>/assets/img/q_and_a.png);
    }
    .card:nth-child(5):before {
        background-image: url(<?= get_stylesheet_directory_uri() ?>/assets/img/certificates.png);
    }

    .page-content {
        grid-template-columns: repeat(5, 1fr);
    }

    .content{
        padding: 0;
    }

    p.copy {
        font-size: 0.8rem;
        font-family: 'actor';
    }


</style>


<script>
    // tabbed content
    // http://www.entheosweb.com/tutorials/css/tabs.asp
    jQuery(".tab_content").hide();
    jQuery(".tab_content.enabled:first").show();

    jQuery('li.heading-font.enabled').eq(0).click().addClass('active');

    /* if in tab mode */
    jQuery("ul.tabs li.enabled").click(function() {

        jQuery(".tab_content").hide();
        var activeTab = jQuery(this).attr("rel");
        jQuery("#"+activeTab).fadeIn();

        jQuery("ul.tabs li").removeClass("active");
        jQuery(this).addClass("active");

        jQuery(".tab_drawer_heading").removeClass("d_active");
        jQuery(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");

    });
    /* if in drawer mode */
    jQuery(".tab_drawer_heading.enabled").click(function() {

        jQuery(".tab_content").hide();
        var d_activeTab = jQuery(this).attr("rel");
        jQuery("#"+d_activeTab).fadeIn();

        jQuery(".tab_drawer_heading").removeClass("d_active");
        jQuery(this).addClass("d_active");

        jQuery("ul.tabs li").removeClass("active");
        jQuery("ul.tabs li[rel^='"+d_activeTab+"']").addClass("active");
    });


    /* Extra class "tab_last"
       to add border to right side
       of last tab */
    jQuery('ul.tabs li').last().addClass("tab_last");

    // jQuery('.tabs li').eq(0).addClass('active');
    jQuery('h3.tab_drawer_heading').eq(0).addClass('d_active');




    // dashboard on click assignment
    jQuery("body").delegate(".get-learner-assignments", "click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        let term_id = $(this).data('term-id');
        // load template courses
        jQuery.post(ajaxurl, {
            action: 'get_learner_assignments',
            term_id: term_id
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });


    // dashboard on click certificates
    jQuery("body").delegate(".get-learner-certificates", "click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();

        // load template courses
        jQuery.post(ajaxurl, {
            action: 'get_learner_certificates',

        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });


    // dashboard on click q and a
    jQuery(".get-learner-qa").on("click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();

        // load template courses
        jQuery.post(ajaxurl, {
            action: 'get_learner_qa',

        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });

    // dashboard on click live session
    jQuery(".get-learner-live-sessions").on("click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        var site_url = '<?= site_url(); ?>';
        window.location.href = site_url + '/calendar';
    });

</script>