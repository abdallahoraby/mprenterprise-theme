<section class="instructor-dashboard-page">

    <?php get_template_part('template-parts/template-dashboard-top-section') ?>

    <div class="row bottom-cards">


        <main class="page-content">
            <div class="card get-courses" data-term-id="all">
                <div class="content">
                    <h2 class="title">
                        <img class="card-icons" src="<?= get_stylesheet_directory_uri() ?>/assets/img/course-icon.png" alt="">
                        <span> + COURSE </span>
                    </h2>
                    <p class="copy"> select </p>
                    <button class="btn"> <i class="fa-solid fa-arrow-right-long"></i> </button>
                </div>
            </div>
            <div class="card get-live-sessions">
                <div class="content">
                    <h2 class="title">
                        <img class="card-icons" src="<?= get_stylesheet_directory_uri() ?>/assets/img/live-sessions-icon.png" alt="">
                        <span> + LIVE SESSION </span>
                    </h2>
                    <p class="copy"> select </p>
                    <button class="btn"> <i class="fa-solid fa-arrow-right-long"></i> </button>
                </div>
            </div>
            <div class="card get-assignments">
                <div class="content">
                    <h2 class="title">
                        <img class="card-icons" src="<?= get_stylesheet_directory_uri() ?>/assets/img/assignment-icon.png" alt="">
                        <span> + ASSIGNMENT </span>
                    </h2>
                    <p class="copy"> select </p>
                    <button class="btn"> <i class="fa-solid fa-arrow-right-long"></i> </button>
                </div>
            </div>
            <div class="card get-instructor-qa">
                <div class="content">
                    <h2 class="title">
                        <img class="card-icons" src="<?= get_stylesheet_directory_uri() ?>/assets/img/q_and_a_icon.png" alt="">
                        <span> Q & A </span>
                    </h2>
                    <p class="copy"> select </p>
                    <button class="btn"> <i class="fa-solid fa-arrow-right-long"></i> </button>
                </div>
            </div>
        </main>

    </div>


</section>


<style>
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
</style>


<script>

    jQuery(".get-assignments").on("click", function(e){
        e.preventDefault();
        jQuery('.ajax-loader').show();
        // load template courses
        jQuery.post(ajaxurl, {
            action: 'get_instructor_assignments',
        }, function (response){ // response callback function
            jQuery('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
        .done(function(response) {
            //alert( "second success" );
        });

    });


    // on click get instructor live sessions
    jQuery(".get-live-sessions").on("click", function(e){
        e.preventDefault();
        jQuery('.ajax-loader').show();
        // load template live sessions
        jQuery.post(ajaxurl, {
            action: 'get_instructor_live_sessions',
        }, function (response){ // response callback function
            jQuery('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });

    // on click get instructor q and a
    jQuery(".get-instructor-qa").on("click", function(e){
        e.preventDefault();
        jQuery('.ajax-loader').show();
        // load template qa
        jQuery.post(ajaxurl, {
            action: 'get_instructor_qa',
        }, function (response){ // response callback function
            jQuery('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });

</script>