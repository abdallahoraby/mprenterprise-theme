<?php

    if ( !empty($args) && $args['course_id'] ):
        $course_id = (int) $args['course_id'];
    else:
        // no course selected, redirect to home
        $dashboard_url = site_url() . '/dashboard';
        wp_safe_redirect($dashboard_url);
    endif;


    $course_obj = get_post($course_id);
    $course_title = $course_obj->post_title;
    $course_description = $course_obj->post_content;
    $course_description = wp_strip_all_tags( $course_description );
    $course_video_ids = get_post_meta($course_id, 'course_video_id', false);
    if( !empty($course_video_ids) ):
        $video_url = wp_get_attachment_url($course_video_ids[0]);
    endif;
    $level = get_post_meta($course_id, 'level', true);
    $duration = (int) get_post_meta($course_id, 'duration_info', true);
    $author_obj = get_user_by('id', $course_obj->post_author);
    $author_name = $author_obj->data->display_name;

    $current_progress = (int) MPR_Core::get_user_course_progress(get_current_user_id(), $course_id);

    $length_formatted = wp_get_attachment_metadata($course_video_ids[0])['length_formatted'];

    $term_id = wp_get_object_terms( $course_id, 'stm_lms_course_taxonomy' )[0]->term_id;



?>



<div class="row new-course-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'course',
            'back_template' => 'courses',
            'term_id' => $term_id
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">

            <div class="course-details-section">

                <?php
                    get_template_part('template-parts/template-course-videos', null, array(
                        'course_id' => $course_id));
                ?>

<!--                <video width="100%" height="700px" controls controlsList="nodownload" oncontextmenu="return false;" class="main-video">-->
<!--                    <source src="--><?//= $video_url ?><!--" type="video/mp4" />-->
<!--                </video>-->
<!--                <a href="#" class="complete-lesson"> <i class="fa-regular fa-circle-check"></i> Complete This Lesson </a>-->

<!--                --><?php //if(!empty($course_video_ids)): ?>
<!---->
<!--                    <div class="playlist">-->
<!--                        --><?php
//                            foreach ( $course_video_ids as $course_video_id ):
//                                $playlist_video_url = wp_get_attachment_url($course_video_id);
//                                ?>
<!--                            <video width="30%" height="120px" controlsList="nodownload" oncontextmenu="return false;" data-vid-url="--><?//= $playlist_video_url ?><!--">-->
<!--                                <source src="--><?//= $playlist_video_url ?><!--" type="video/mp4" />-->
<!--                            </video>-->
<!--                        --><?php //endforeach; ?>
<!--                    </div>-->
<!---->
<!--                --><?php //endif; ?>


                <div class="row d-flex justify-content-between align-content-center flex-wrap px-5 mt-5 mb-5 course-header-details">
                    <div class="col-md-6">

                        <div class="level"> Level <?= ucfirst($level) ?> </div>
                        <div class="hosted-by"> Hosted by <strong> <?= $author_name ?> </strong> </div>

                    </div>

                    <div class="col-md-6">

                        <div class="row duration-info">
                            <div class="col-md-6 d-flex align-content-end">
                                <div class="course-status"> Progress: <span class="text-gradient"> <?= $current_progress ?> % </span> </div>
                            </div>

                            <div class="col-md-6">
                                <div class="duration"> Lessons: <?= MPR_Core::get_lessons_count($course_id) ?> </div>
                                <div class="progress single-course-progress">
                                    <div class="progress-bar w-<?= $current_progress ?>" style="width: <?= $current_progress ?>%" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $current_progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>


                <h3 class="course-title px-5"> <?= $course_title ?> </h3>
                <p class="course-description px-5"> <?= $course_description ?> </p>

                <div class="row rate-this-course px-5">
                    <div class="col-md-6">
                        Rate This Course
                    </div>

                    <div class="col-md-6">
                        <div class="rate-stars">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                    </div>
                </div>

            </div>


            <div class="related-courses">
                <p class="text-center mt-5 mb-3"> Related Courses </p>


            </div>


        </div>

    </div>
</div>


<style>
    a.complete-lesson {
        background: var(--mint-green);
        color: #fff;
        width: fit-content;
        padding: 0.5rem 1rem;
        border-radius: 5px;
    }

    .course-details-section {
        background: #fff;
        border-radius: 30px;
        border-bottom: 1px solid #E8EDF0;
        display: flex;
        flex-flow: column;
        padding-bottom: 4rem;
    }

    .course-details-section video{
        border-radius: inherit;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .checked {
        color: var(--pink);
    }

    .progress {
        margin: 0.5rem 0 0 0;
    }

    .course-header-details * {
        font-size: 1rem;
    }

    .duration-info{
        display: flex;
        justify-content: space-between;
        align-content: end;
    }


    .course-status {
        position: absolute;
        bottom: 0;
    }


    h3.course-title {
        font-size: 1.5rem;
        margin-bottom: 3rem;
    }

    p.course-description {
        margin-bottom: 5rem;
    }

    .rate-this-course {
        background: #F6F8FA;
        border: 1px solid #E8EDF0;
        border-radius: 100px;
        padding: 1.2rem;
        width: 90%;
        margin: 0 auto;
    }

    .rate-stars {
        display: flex;
        justify-content: flex-end;
    }

    .rate-stars span:hover{
        cursor: pointer;

    }

    .playlist {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 2rem auto;
        flex-flow: wrap;
        gap: 1rem;
    }

    .playlist video {
        border: 3px solid #e1e1e1ba;
        border-radius: 15px;
        object-fit: cover;
        height: 180px;
        cursor: pointer;
        box-shadow: 0 0 10px #dddddda6;
        transition: all 0.3s ease-in-out;
    }

    .playlist video:hover {
        background: var(--bg-gradient);
    }




</style>


<script>

    // jQuery('.playlist video').on('click', function(){
    //
    //     let vid_url = jQuery(this).data('vid-url');
    //     jQuery('video.main-video').html('<source src="'+ vid_url +'" type="video/mp4">');
    //     jQuery('video.main-video')[0].load();
    //
    //
    // });


    // on click complete lesson
    // jQuery(".complete-lesson").on("click", function(e){
    //     e.preventDefault();
    //
    //     jQuery('.ajax-loader').show();
    //     // load template qa
    //     jQuery.post(ajaxurl, {
    //         action: 'get_instructor_qa',
    //     }, function (response){ // response callback function
    //         jQuery('.ajax-loader').hide();
    //         jQuery('.dashboard-content').html(response);
    //     })
    //         .done(function(response) {
    //             //alert( "second success" );
    //         });
    //
    // });

</script>