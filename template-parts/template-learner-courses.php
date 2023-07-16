<?php

    if ( !empty($args) && $args['term_id'] ):
        $term_id = (int) $args['term_id'];
    else:
        $term_id = 'all';
    endif;


    $user_courses = STM_LMS_User::_get_user_courses(0, 'date_low');

    if( !empty($user_courses) ):
        $courses_count = 0;
        foreach ( $user_courses['posts'] as &$course ):
            $term_list = wp_get_post_terms( $course['id'], 'stm_lms_course_taxonomy', array( 'fields' => 'all' ) );
            $course_term_id = (int) $term_list[0]->term_id;
            $post_status = get_post_status($course['id']);
            if( $post_status == 'publish' ):
                if( $term_id == $course_term_id ):
                    $courses_count++;
                endif;
            endif;

        endforeach;
    else:
        echo "<span class='text-center'> No courses found </span>";
        return;
    endif;

?>


<span class="mt-5 mb-5 text-center courses-count"> <?php _e('Showing', 'masterstudy-child'); ?> <strong class="heading-font"> <?= $courses_count ?> <?php _e('Results', 'masterstudy-child'); ?> </strong> </span>

<div class="grid-content d-flex justify-content-start align-content-center gap-3 flex-wrap">

    <!-- Courses loop goes here -->

    <?php if( !empty($user_courses['posts']) ): ?>
        <?php
            foreach ( $user_courses['posts'] as &$course ):
                // show only if post status is publish
                $post_status = get_post_status($course['id']);
                if( $post_status == 'publish' ):
                    $term_list = wp_get_post_terms( $course['id'], 'stm_lms_course_taxonomy', array( 'fields' => 'all' ) );
                    $course_term_id = (int) $term_list[0]->term_id;

                    if( $term_id == $course_term_id ):

                        $course_id = $course['id'];
                        $content_post = get_post($course_id);
                        $content = $content_post->post_content;
                        $content = wp_strip_all_tags( $content );

                        $meta = STM_LMS_Helpers::parse_meta_field($course_id);
                        $level = !empty( $meta['level'] ) ? $meta['level'] : 'N/A';
                        $duration = !empty( $meta['duration_info'] ) ? $meta['duration_info'] : 'N/A';
                        $current_progress = (int) MPR_Core::get_user_course_progress(get_current_user_id(), $course_id);
                        $course_video_ids = get_post_meta($course_id, 'course_video_id', false);
                        $length_formatted = wp_get_attachment_metadata($course_video_ids[0])['length_formatted'];

                        $author_id = get_post_field( 'post_author', $course['id'] );
                        $inst_obj = get_user_by('id', $author_id);

                        $lessons_count = MPR_Core::get_lessons_count($course_id);


                ?>


                <div class="course-card instructor-<?= $author_id ?>">
                        <div class="course-image"> <i class="fa-solid fa-circle-play"></i> </div>

                        <div class="col-md-12 d-flex justify-content-start align-content-center">
                            <small> Hosted By: <strong> <?= $inst_obj->data->display_name ?> </strong> </small>
                        </div>

                        <div class="col-md-12 d-flex justify-content-between align-content-center">
                            <div class="col-md-6 course-level"> <?= ucfirst($level) ?> </div>
    <!--                        <div class="col-md-6 course-duration"> --><?//= $duration ?><!-- </div>-->
                            <div class="col-md-6 course-duration"> <?= $lessons_count ?> lessons </div>
                        </div>

                        <h3 class="p-3 course-title almarai"> <?= $course['title'] ?> </h3>
                        <p class="col-md-12 course-short-desc almarai"> <?= $content ?>  </p>
                        <a href="<?= $course['link'] ?>" class="view-course heading-font" data-course-id="<?= $course_id ?>"> <?= _e('Select', 'masterstudy-child') ?> <i class="fa-solid fa-arrow-right"></i> </a>
                        <div class="progress single-course-progress">
                            <div class="progress-bar w-<?= $current_progress ?>" style="width: <?= $current_progress ?>%" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $current_progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="course-status"> <?= _e('Progress:', 'masterstudy-child') ?> <span class="text-gradient"> <?= $current_progress ?> % </span> </div>
                </div>
                    <?php endif; ?>
                <?php endif; ?>
        <?php endforeach; ?>


    <?php else: ?>

        <strong class="text-center"> <?= _e('No courses found.', 'masterstudy-child') ?> </strong>

    <?php endif; ?>

</div>


<script>

    jQuery('select#filter-courses-grid').on('change', function(){
        let inst_id = jQuery(this).val();
        if( inst_id == 'all' ){
            jQuery('.course-card').show();
        } else {
            jQuery('.instructor-'+inst_id).show();
            jQuery('.course-card').not('.instructor-'+inst_id).hide();
        }
    });



</script>