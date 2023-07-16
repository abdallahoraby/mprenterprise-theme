<?php

    $args = apply_filters( 'stm_lms_archive_filter_args', array( 'posts_per_page' => -1 ) );
    $instructor_courses = STM_LMS_Instructor::get_courses( $args, true, STM_LMS_User_Manager_Interface::isInstructor() );

?>

<div class="col-md-12 d-flex justify-content-end align-content-end">
    <a href="#" class="add_new_course_btn"> Add New Course </a>
</div>

<span class="mt-5 mb-5 text-center courses-count"> Showing <strong class="heading-font"> <?= count($instructor_courses['posts']) ?> Results </strong> </span>


<div class="grid-content d-flex justify-content-start align-content-center gap-3 flex-wrap">

    <!-- Courses loop goes here -->

    <?php if( !empty($instructor_courses['posts']) ): ?>
        <?php
            foreach ( $instructor_courses['posts'] as &$course ):
                $course_id = $course['id'];
                $content_post = get_post($course_id);
                $content = $content_post->post_content;
                $content = wp_strip_all_tags( $content );

                $meta = STM_LMS_Helpers::parse_meta_field($course_id);
                $level = !empty( $meta['level'] ) ? $meta['level'] : 'N/A';
                $duration = !empty( $meta['duration_info'] ) ? $meta['duration_info'] : 'N/A';
                $lessons_count = MPR_Core::get_lessons_count($course_id);

            ?>


            <div class="course-card">
                    <div class="course-image"> <i class="fa-solid fa-circle-play"></i> </div>
                    <div class="col-md-12 d-flex justify-content-between align-content-center">
                        <div class="col-md-6 course-level"> <?= ucfirst($level) ?> </div>
<!--                        <div class="col-md-6 course-duration"> --><?//= $duration ?><!-- </div>-->
                        <div class="col-md-6 course-duration"> <?= $lessons_count ?> lessons </div>
                    </div>
                    <h3 class="p-3 course-title almarai"> <?= $course['title'] ?> </h3>
                    <p class="col-md-12 course-short-desc almarai"> <?= $content ?>  </p>
<!--                    <a href="--><?//= $course['link'] ?><!--" class="view-course heading-font" data-course-id="--><?//= $course_id ?><!--"> Select <i class="fa-solid fa-arrow-right"></i> </a>-->
                    <a href="#" class="heading-font edit-course" data-course-id="<?= $course_id ?>"> Edit Course <i class="fa-regular fa-pen-to-square"></i> </a>
            </div>

        <?php endforeach; ?>


    <?php else: ?>

        <strong class="text-center"> No courses found. </strong>

    <?php endif; ?>


</div>


<style>

    a.add_new_course_btn {
        background: var(--bg-gradient);
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 90px;
        border: 3px solid #f6f8fa;
        transition: all 0.5s ease-in-out;
    }

    a.add_new_course_btn:hover {
        background: transparent;
        border-color: var(--bg-gradient);
    }


</style>


<script>


    jQuery("body").delegate(".add_new_course_btn", "click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();

        // load template add new course
        jQuery.post(ajaxurl, {
            action: 'get_new_course_template',
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
        .done(function(response) {
            //alert( "second success" );
        });

    });



    jQuery("body").delegate(".edit-course", "click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        let course_id = jQuery(this).data('course-id');
        // load template
        jQuery.post(ajaxurl, {
            action: 'edit_course',
            course_id: course_id
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });

</script>