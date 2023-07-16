<?php

    if ( !empty($args) && $args['term_id'] ):
        $term_id = (int) $args['term_id'];
    else:
        $term_id = 'all';
    endif;


    // get all learner courses
    $user_courses = STM_LMS_User::_get_user_courses(0, 'date_low');


    // extract post author id
    if( !empty($user_courses['posts']) ):

        foreach ( $user_courses['posts'] as $user_course ):

            // get assignments in this term only
            $term_list = wp_get_post_terms( $user_course['id'], 'stm_lms_course_taxonomy', array( 'fields' => 'all' ) );
            $course_term_id = (int) $term_list[0]->term_id;


            if( $term_id == $course_term_id ):

                $instructor_ids[] = get_post_field( 'post_author', $user_course['id'] );

                // get assignment in this course
                $curriculum = get_post_meta($user_course['id'], 'curriculum', true);
                if( !empty($curriculum) ):
                    $curriculum_arrays = explode(',', $curriculum);
                    foreach( $curriculum_arrays as $curriculum_id ):
                        $curriculum_ids[$user_course['id']] = $curriculum_id;
                    endforeach;
                endif;

            endif;

        endforeach;


        if( !empty($curriculum_ids) ):
            $curriculum_ids = array_unique($curriculum_ids);

            foreach ( $curriculum_ids as $course_id=>$curriculum_id ):
                // check post type is "stm-assignments" get its data
                $post_type = get_post_type($curriculum_id);
                if( $post_type == 'stm-assignments' ):
                    $assignments[$course_id] = $curriculum_id;
                endif;

            endforeach;
        endif;

    endif;



?>

<div class="row new-assignment-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'assignment'
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">

            <?php if( empty($curriculum_ids) ): ?>
                <p class="text-center"> No assignments fround for this category. </p>
            <?php endif; ?>

            <div class="courses-filter ">
                <div class="filter-title">
                    <i class="fa-solid fa-arrow-down-wide-short mid-gray"></i>
                    <strong class="mid-gray heading-font">  Filter Assignments By Instructor: </strong>
                </div>
                <select id="instructor-id" aria-label="">
                    <option value="show-all" selected> Show All </option>
                    <?php if( !empty($instructor_ids) ):
                            $instructor_ids = array_unique($instructor_ids);
                            foreach ( $instructor_ids as $instructor_id ):
                                $user_obj = get_user_by('id', $instructor_id);
                        ?>
                            <option value="<?= $instructor_id ?>"> <?= $user_obj->data->display_name ?> </option>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </select>
            </div>

            <?php if(!empty($assignments)):
                    foreach ( $assignments as $course_id=>$assignment_id ):

                        $course_title = get_the_title($course_id);
                        $assignment_title = get_the_title($assignment_id);
                        $assignment_content = get_post_field('post_content', $assignment_id);

                        $author_id = get_post_field( 'post_author', $assignment_id );
                        $instructor_obj = get_user_by('id', $author_id);

                        $publish_date = get_the_date('l, d F, Y', $assignment_id);

                        // get assignment attachment data
                        $assignment_attach_id = get_post_meta($assignment_id, 'assignment_attachment', true);


            ?>
            <div class="assignment-card instructor_<?= $author_id ?>">
                <div class="row d-flex justify-content-center align-content-center mt-3 mb-3 p-5">
                    <div class="col-md-6">

                        <div class="profile-section">

                            <div class="col-md-3 d-flex justify-content-center p-0">
                                <div class="rounded-corners-gradient-borders">
                                    <img class="profile-picture" src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png" alt="">
                                </div>
                            </div>

                            <div class="col-md-9">
                                <h3> <?= $instructor_obj->data->display_name ?> </h3>
                                <p> Submitted on <?= $publish_date ?> </p>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 d-flex justify-content-center align-content-center">
                        <span class="assigned-course almarai"> <?= $course_title ?> </span>
                    </div>
                </div>


                <div class="row assignment-content">
                    <div class="col-md-12">
                        <h3 class="almarai"> <?= $assignment_title ?> </h3>
                        <p> <?= $assignment_content ?> </p>
                    </div>
                </div>

                <div class="assignment-card-footer row d-flex justify-content-center align-content-center">
                    <div class="col-md-6">
                        <?php if(!empty( $assignment_attach_id )):
                                $attachment_metadata = wp_get_attachment_metadata($assignment_attach_id);
                                $attach_size = round($attachment_metadata['filesize'] / 1048576, 2);
                        ?>
                            Attached <i class="fa-regular fa-file"></i> <?= basename ( get_attached_file( $assignment_attach_id ) ) ?> <span class="attachment-size"> <?= $attach_size ?> MB </span>
                        <?php else: ?>
                            no attachments found.
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end align-content-center gap-3">
                        <?php if(!empty( $assignment_attach_id )): ?>
                            <a href="<?= wp_get_attachment_url($assignment_attach_id) ?>" class="download-attachment" download> Download Attachment <i class="fa-solid fa-cloud-arrow-down"></i> </a>
                        <?php endif; ?>
                        <a href="#" class="complete-assignment" data-assignment-id="<?= $assignment_id ?>" data-course-id="<?= $course_id ?>"> Complete Assignment <i class="fa-solid fa-upload"></i> </a>
                    </div>
                </div>

            </div> <!-- end of assignment card -->
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>
</div>





<style>


    span.select2.select2-container.select2-container--default,
    #instructor-id{
        width: 50% !important;
    }

    span.select2-selection.select2-selection--single,
    #instructor-id{
        border-radius: 150px;
    }

    .filter-title{
        display: flex;
        justify-content: center;
        align-content: center;
        gap: 1rem;
    }

    span.assigned-course {
        width: 100%;
        max-width: 100%;
        display: block;
        text-align: end;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--mid-gray);
        height: 100%;
        align-content: center;
    }

    .assignment-card {
        background: #fff;
        margin: 3rem 3rem 0 3rem;
        border-radius: 30px;
        box-shadow: 0 0 10px #eef1f3;
    }

    .assignment-card:last-child{
        margin-bottom: 3rem;
    }

    .courses-bottom{
        padding: 3rem 0 0 0;
    }

    .assignment-card-footer {
        background: var(--mid-gray);
        width: 100%;
        margin: 0;
        min-height: 10vh;
        border-radius: 30px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        padding: 1rem;
    }

    .assignment-card-footer * {
        color: #fff;
    }

    .assignment-card-footer i{
        margin: 0 1rem;
    }

    a.download-attachment,
    a.complete-assignment {
        padding: 0.5rem 1rem;
        border-radius: 100px;
        color: #fff;
        border: 2px solid var(--mid-gray);
    }

    a.download-attachment:hover,
    a.complete-assignment:hover {
        color: #fff !important;
        background: transparent;
        border-color: #fff;
    }

    a.download-attachment{
        background: var(--pink);
    }

    a.complete-assignment{
        background: var(--orange);
    }

    a.download-attachment i,
    a.complete-assignment i{
        margin: 0;
    }


    span.attachment-size {
        margin: 0 1rem;
    }

    .assignment-content {
        padding: 2rem;
    }

    .courses-filter {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2rem;
    }

    .filter-title {
        font-size: 0.9rem;
    }

    .profile-section * {
        margin: 0;
    }






</style>


<script>

    jQuery(document).ready(function() {

        jQuery('#instructor-id').select2();

        jQuery('select#instructor-id').on('change', function(){

            let instructor_id = jQuery(this).val();
            if( instructor_id == 'show-all' ){
                jQuery('.assignment-card').show();
            } else {
                jQuery('.instructor_' + instructor_id).show();
                jQuery('.assignment-card').not('.instructor_' + instructor_id).hide();
            }

        })


        // dashboard on click complete assignmenmt
        jQuery(".complete-assignment").on("click", function(e){
            e.preventDefault();
            $('.ajax-loader').show();
            let assignment_id = $(this).data('assignment-id');
            let course_id = $(this).data('course-id');
            // load template courses
            jQuery.post(ajaxurl, {
                action: 'get_single_assignment',
                assignment_id: assignment_id,
                course_id: course_id
            }, function (response){ // response callback function
                $('.ajax-loader').hide();
                jQuery('.dashboard-content').html(response);
            })
                .done(function(response) {
                    //alert( "second success" );
                });

        });

    });

</script>

